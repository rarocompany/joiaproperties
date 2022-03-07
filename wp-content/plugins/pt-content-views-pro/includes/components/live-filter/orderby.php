<?php
/*
 * Show sort options to visitors
 *
 * @since 5.0
 * @author ptguy
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	die;
}

add_action( PT_CV_PREFIX_ . 'add_global_variables', 'cvp_livefilter_sortby' );
function cvp_livefilter_sortby() {
	new CVP_LIVE_FILTER_SORTBY( CVP_LF_SORT );
}

class CVP_LIVE_FILTER_SORTBY extends CVP_LIVE_FILTER {

	// Get terms to show as filters
	function get_selected_filters() {
		if ( !$this->is_this_enabled( 'order' ) ) {
			return;
		}

		$this->settings	 = $ctf_info		 = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'order-custom-field-' );
		if ( !empty( $ctf_info[ 'live-filter-enable' ] ) ) {
			foreach ( $ctf_info[ 'key' ] as $idx => $field ) {
				if ( !empty( $field ) ) {
					if ( CVP_LIVE_FILTER_CTF::is_enabled( $ctf_info, $idx ) ) {
						$this->selected_filters[ $idx ] = $field;
					}
				}
			}
		}

		// Common options
		if ( !$this->selected_filters && $this->get_common_sortby() ) {
			$this->selected_filters = true;
		}
	}

	/**
	 * Update order before querying posts
	 *
	 * @param array $args
	 * @return array
	 */
	function modify_query( $args ) {

		global $cvp_lf_params;

		if ( !empty( $cvp_lf_params[ CVP_LF_SORT ] ) ) {
			$order_value = (array) $cvp_lf_params[ CVP_LF_SORT ];
			$orderby	 = $order_value[ 0 ];

			// Prevent unwanted value
			if ( isset( $order_value[ 1 ] ) && $order_value[ 1 ] === 'desc' ) {
				$order = 'desc';
			} else {
				$order = 'asc';
			}

			// Common orderby
			if ( in_array( implode( '#', $order_value ), array_keys( CVP_LIVE_FILTER_SORTBY::common_sortby() ) ) ) {
				$args[ 'orderby' ]	 = $orderby;
				$args[ 'order' ]	 = $order;
			} else {
				// Handle custom field here
				$field_type = 'CHAR';
				foreach ( $this->settings[ 'key' ] as $idx => $field ) {
					if ( $field === $orderby ) {
						$field_type = $this->settings[ 'type' ][ $idx ];
						break;
					}
				}
				/* @since 5.3.4 Append id desc to make the consistent results when there are many posts have same values of custom fields */
				$args[ 'orderby' ]	 = array( 'meta_value' => $order, 'ID' => 'DESC' );
				$args[ 'meta_key' ]	 = $orderby;
				$args[ 'meta_type' ] = $field_type === 'DECIMAL' ? 'DECIMAL(15,5)' : $field_type;
			}
		}

		return parent::modify_query( $args );
	}

	// Show taxonomies as filters
	function show_as_filter( $args ) {
		// Merge fields to one array
		$field_vals = array();

		if ( is_array( $this->selected_filters ) ) {
			foreach ( $this->selected_filters as $idx => $field ) {
				$sort	 = $this->settings[ 'order' ][ $idx ];
				$suffix	 = ($sort === 'desc') ? ",$sort" : '';

				$field_vals[ $field . $suffix ] = $this->get_label( 'live-filter-heading', $idx, $field );
			}
		}

		$common_fields	 = (array) $this->get_common_sortby();
		$field_vals		 = array_merge( $common_fields, $field_vals );

		if ( $field_vals ) {
			$type	 = 'dropdown';
			$others	 = array(
				'label'			 => PT_CV_Functions::setting_value( PT_CV_PREFIX . 'livesort-live-filter-heading' ),
				'show_count'	 => false,
				'hide_empty'	 => false,
				'default_text'	 => PT_CV_Functions::setting_value( PT_CV_PREFIX . 'livesort-default-text' ),
			);

			if ( method_exists( 'CVP_LIVE_FILTER_OUTPUT', $type ) ) {
				$ctf = new CVP_LIVE_FILTER_OUTPUT( CVP_LF_SORT, $type, CVP_LF_SORT, $field_vals, $others );
				$args .= $ctf->html();
			}
		}

		return parent::show_as_filter( $args );
	}

	function get_common_sortby() {
		$selected_options = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'livesort-options' );
		if ( $selected_options ) {
			$options = array();
			$default = CVP_LIVE_FILTER_SORTBY::common_sortby();
			$texts	 = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'livesort-options-text' );
			$texts	 = array_map( 'trim', explode( ',', trim( $texts ) ) ); // In settings, separate texts by comma

			foreach ( $selected_options as $idx => $value ) {
				$options[ str_replace( '#', CVP_LF_SEPARATOR, $value ) ] = !empty( $texts[ $idx ] ) ? $texts[ $idx ] : $default[ $value ];
			}

			$selected_options = $options;
		}

		return $selected_options;
	}

	static function common_sortby() {
		return array(
			'title'				 => __( 'Title (A - Z)', 'content-views-pro' ),
			'title#desc'		 => __( 'Title (Z - A)', 'content-views-pro' ),
			'date'				 => __( 'Date (Oldest)', 'content-views-pro' ),
			'date#desc'			 => __( 'Date (Newest)', 'content-views-pro' ),
			'comment_count'		 => __( 'Comments count (asc)', 'content-views-pro' ),
			'comment_count#desc' => __( 'Comments count (desc)', 'content-views-pro' ),
		);
	}

}
