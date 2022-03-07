<?php
/*
 * Show custom fields as Live Filter
 *
 * @since 5.0
 * @author ptguy
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	die;
}

add_filter( PT_CV_PREFIX_ . 'filtered_ctf', 'cvp_livefilter_filtered_ctf', 10, 2 );
function cvp_livefilter_filtered_ctf( $fields, $count ) {
	for ( $idx = 0; $idx < $count; $idx ++ ) {
		if ( CVP_LIVE_FILTER_CTF::is_enabled( $fields, $idx ) ) {
			if ( CVP_LIVE_FILTER_CTF::is_enabled( $fields, $idx, 'live-filter-hide-non-matching' ) ) {
				// Show posts which have this field
				$fields[ 'operator' ][ $idx ] = 'EXISTS';
			} else {
				// Ignore this field from query (do not restrict posts to this field by default)
				unset( $fields[ 'value' ][ $idx ] );
			}
		}
	}

	return $fields;
}

// When enabled Live Filter for custom field, ignore it from sortby
add_filter( PT_CV_PREFIX_ . 'custom_field_order_settings', 'cvp_livefilter_ctf_settings' );
function cvp_livefilter_ctf_settings( $metadata_order ) {
	foreach ( array_keys( $metadata_order[ 'key' ] ) as $idx ) {
		if ( CVP_LIVE_FILTER_CTF::is_enabled( $metadata_order, $idx ) ) {
			unset( $metadata_order[ 'key' ][ $idx ] );
			unset( $metadata_order[ 'type' ][ $idx ] );
			unset( $metadata_order[ 'order' ][ $idx ] );
		}
	}

	return $metadata_order;
}

add_action( PT_CV_PREFIX_ . 'add_global_variables', 'cvp_livefilter_ctf' );
function cvp_livefilter_ctf() {
	new CVP_LIVE_FILTER_CTF( CVP_LF_PREFIX_CTF );
}

class CVP_LIVE_FILTER_CTF extends CVP_LIVE_FILTER {

	static function is_enabled( $settings, $idx, $name = 'live-filter-enable' ) {
		return isset( $settings[ $name ][ $idx ] ) && $settings[ $name ][ $idx ] === 'yes';
	}

	// Get configured settings by field name/key
	static function settings_of_field( $settings, $field_name ) {
		$keys_arr	 = array_flip( $settings[ 'key' ] );
		$field_index = isset( $keys_arr[ $field_name ] ) ? $keys_arr[ $field_name ] : null;

		return array(
			'value-type'	 => @$settings[ 'type' ][ $field_index ],
			'filter-type'	 => @$settings[ 'live-filter-type' ][ $field_index ],
			'operator'		 => @$settings[ 'live-filter-operator' ][ $field_index ],
			'date-operator'	 => @$settings[ 'live-filter-daterange-operator' ][ $field_index ],
			'id-to-text'	 => @$settings[ 'live-filter-id-to-text' ][ $field_index ],
		);
	}

	// Get custom fields to show as filters
	function get_selected_filters() {
		if ( !$this->is_this_enabled( 'custom_field' ) ) {
			return;
		}

		$count_enable	 = 0;
		$this->settings	 = $ctf_info		 = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'ctf-filter-' );
		if ( isset( $ctf_info[ 'key' ] ) ) {
			foreach ( $ctf_info[ 'key' ] as $idx => $field ) {
				if ( !empty( $field ) ) {
					$this->selected_filters[ $idx ] = $field;

					if ( CVP_LIVE_FILTER_CTF::is_enabled( $ctf_info, $idx ) ) {
						$count_enable += 1;
					}
				}
			}
		}

		if ( !$count_enable ) {
			unset( $this->selected_filters );
		}
	}

	/**
	 * Update meta_query before querying posts
	 *
	 * @param array $args
	 * @return array
	 */
	function modify_query( $args ) {

		CVP_LIVE_FILTER_QUERY::query_posts_by_filters( $args, 'meta_query', 'key', $this->settings );

		// Relation between multi fields
		$this->set_relation( $args[ 'meta_query' ], PT_CV_Functions::setting_value( PT_CV_PREFIX . 'ctf-filter-relation' ) );

		return parent::modify_query( $args );
	}

	// Show custom fields as filters
	function show_as_filter( $args ) {
		foreach ( $this->selected_filters as $idx => $field ) {
			if ( empty( $this->settings[ 'live-filter-enable' ][ $idx ] ) ) {
				continue;
			}

			$type		 = $this->settings[ 'live-filter-type' ][ $idx ];
			$field_vals	 = $this->_get_ctf_values( $field, $type );

			$others = array(
				'label'				 => $this->get_label( 'live-filter-heading', $idx, $field ),
				'show_count'		 => @$this->settings[ 'live-filter-show-count' ][ $idx ],
				'hide_empty'		 => @$this->settings[ 'live-filter-hide-empty' ][ $idx ],
				'default_text'		 => @$this->settings[ 'live-filter-default-text' ][ $idx ],
				'order_options_by'	 => @$this->settings[ 'live-filter-order-options' ][ $idx ],
				'date_operator'		 => @$this->settings[ 'live-filter-daterange-operator' ][ $idx ],
				'from'				 => @$this->settings[ 'live-filter-rangeslider-from' ][ $idx ],
				'step'				 => @$this->settings[ 'live-filter-rangeslider-step' ][ $idx ],
				'prefix'			 => @$this->settings[ 'live-filter-rangeslider-prefix' ][ $idx ],
				'postfix'			 => @$this->settings[ 'live-filter-rangeslider-postfix' ][ $idx ],
				'thousand_separator' => @$this->settings[ 'live-filter-rangeslider-thousandseparator' ][ $idx ],
            );

			if ( method_exists( 'CVP_LIVE_FILTER_OUTPUT', $type ) ) {
				$ctf = new CVP_LIVE_FILTER_OUTPUT( CVP_LF_PREFIX_CTF, $type, $field, $field_vals, $others );
				$args .= $ctf->html();
			}
		}

		return parent::show_as_filter( $args );
	}

	// Get all values of custom field (ACF, Pods, WP)
	function _get_ctf_values( $field_name, $type ) {
		global $cvp_lf_data;

		$result = array();
		if ( isset( $cvp_lf_data[ CVP_LF_PREFIX_CTF ][ $field_name ] ) ) {
			$ctf_settings = CVP_LIVE_FILTER_CTF::settings_of_field( $this->settings, $field_name );

			foreach ( array_keys( $cvp_lf_data[ CVP_LF_PREFIX_CTF ][ $field_name ] )as $field ) {
				$text = ucwords( $field );

				if ( !empty( $ctf_settings[ 'id-to-text' ] ) && is_numeric( $field ) ) {
					$itt = $this->_text_form_id( intval( $text ), $ctf_settings[ 'id-to-text' ] );
					if ( $itt ) {
						$text = $itt;
					}
				}

				$result[ $field ] = apply_filters( PT_CV_PREFIX_ . 'lf_ctf_text', $text, $field_name );
			}
		}

		return $result;
	}

	// Get title/name from ID of post/term/author
	function _text_form_id( $id, $type ) {

		switch ( $type ) {
			case 'postid':
				$post = get_post( $id );
				if ( $post ) {
					return $post->post_title;
				}
				break;
			case 'termid':
				$taxonomies = array_keys( PT_CV_Values::taxonomy_list() );
				foreach ( $taxonomies as $taxonomy ) {
					$term = get_term_by( 'id', $id, $taxonomy );
					if ( $term ) {
						return $term->name;
					}
				}
				break;
			case 'authorid':
				$author = get_user_by( 'id', $id );
				if ( $author ) {
					return $author->display_name;
				}
				break;

			default:
				break;
		}

		return null;
	}

}
