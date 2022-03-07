<?php
/**
 * Able to put live filter in sidebar
 *
 * [pt_view id=123456 show=filter]
 * [pt_view id=123456 show=result]
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	die;
}

class CVP_LIVE_FILTER_SIDEBAR {

	static $wrapper_class;

	static function init() {
		self::$wrapper_class = PT_CV_PREFIX . 'wrapper';
		add_filter( PT_CV_PREFIX_ . 'shortcode_params', array( __CLASS__, 'add_shortcode_params' ), 9999 );
		add_filter( PT_CV_PREFIX_ . 'view_all_output', array( __CLASS__, 'store_output' ), 9999, 3 );
		add_filter( PT_CV_PREFIX_ . 'pagination_output', array( __CLASS__, 'store_pagination' ), 9999 );
		add_filter( PT_CV_PREFIX_ . 'view_shortcode_output', array( __CLASS__, 'restore_output' ), 9999, 2 );
		add_filter( PT_CV_PREFIX_ . 'before_output_html', array( __CLASS__, 'show_configuration' ), PHP_INT_MAX );

		add_filter( 'post_link', array( __CLASS__, 'add_filters_to_post_link' ), 9999, 3 );
	}

	static function add_shortcode_params( $args ) {
		$args[ 'show' ]			 = '';
		$args[ 'submit_to' ]	 = '';
		$args[ 'lf_relation' ]	 = '';
		return $args;
	}

	/**
	 * Skip and store filter/result HTML for showing later
	 *
	 * @param string $args
	 * @param string $before_output The live filter HTML
	 * @param string $output        The result
	 * @return string
	 */
	static function store_output( $args, $before_output, $output ) {
		$sc_params = PT_CV_Functions::get_global_variable( 'shortcode_params' );

		if ( !empty( $sc_params[ 'show' ] ) ) {
			$output = PT_CV_Functions::get_global_variable( 'before_output_not_filter' ) . $output;
		}

		if ( self::is_type( $sc_params, 'filter' ) ) {
			self::store_content( 'cv_view_result', sprintf( '<div class="%s">%s</div>', self::$wrapper_class, $output ) );
			$args = $before_output;
		} elseif ( self::is_type( $sc_params, 'result' ) ) {
			self::store_content( 'cv_view_filter', sprintf( '<div class="%s">%s</div>', self::$wrapper_class, $before_output ) );
			$args = $output;
		}

		return $args;
	}

	/**
	 * Skip and store pagination HTML for showing later
	 *
	 * @param string $pagination
	 * @return string
	 */
	static function store_pagination( $pagination ) {
		$sc_params = PT_CV_Functions::get_global_variable( 'shortcode_params' );

		if ( self::is_type( $sc_params, 'filter' ) ) {
			self::store_content( 'cv_view_pagination', sprintf( '<div class="%s">%s</div>', self::$wrapper_class, $pagination ) );
			$pagination = '';
		}

		return $pagination;
	}

	/**
	 * Return View output immediately if stored before
	 *
	 * @param mixed $result
	 * @param array $atts
	 * @return mixed
	 */
	static function restore_output( $result, $atts ) {
		if ( !empty( $atts[ 'show' ] ) ) {
			$GLOBALS[ 'cvp_lf_part' ] = true;
		}

		if ( isset( $atts[ 'id' ] ) ) {
			$id = cv_sanitize_vid( $atts[ 'id' ] );

			$stored_output = null;
			if ( self::is_type( $atts, 'filter' ) ) {
				$stored_output = self::restore_content( $id, 'cv_view_filter' );
			} elseif ( self::is_type( $atts, 'result' ) ) {
				$stored_output = self::restore_content( $id, 'cv_view_result' );
				$stored_output .= self::restore_content( $id, 'cv_view_pagination' );
			}

			if ( $stored_output ) {
				$result = $stored_output;
			}
		}

		return $result;
	}

	static function show_configuration( $args ) {
		$sc_params = PT_CV_Functions::get_global_variable( 'shortcode_params' );
		if ( !empty( $sc_params[ 'submit_to' ] ) ) {
			$args = sprintf( "<div class='cvp-live-config' data-submit-to='%s'></div>", esc_attr( strip_tags( $sc_params[ 'submit_to' ] ) ) ) . $args;
		}

		return $args;
	}

	/**
	 * Add filter parameters to post link, so the filters are selected when click on each post
	 *
	 * @param string $permalink
	 * @param object $post
	 * @param bool $leavename
	 * @return string
	 */
	static function add_filters_to_post_link( $permalink, $post, $leavename ) {
		global $cvp_process_settings;
		if ( isset( $GLOBALS[ 'cvp_lf_part' ] ) && $cvp_process_settings && !empty( $GLOBALS[ 'cvp_lf_query_string' ] ) ) {
			$arr		 = array();
			parse_str( $GLOBALS[ 'cvp_lf_query_string' ], $arr );
			$permalink	 = add_query_arg( $arr, $permalink );
		}

		return $permalink;
	}

	/**
	 * Check type of the 'show' parameter in View shortcode
	 * [pt_view id=123456 show=filter]
	 * [pt_view id=123456 show=result]
	 *
	 * @param array $array
	 * @param string $type
	 * @return boolean
	 */
	static function is_type( $array, $type ) {
		return !empty( $array[ 'show' ] ) && ($array[ 'show' ] === $type);
	}

	static function store_content( $name, $value ) {
		global $pt_cv_id;
		$GLOBALS[ $name . $pt_cv_id ] = $value;
	}

	static function restore_content( $id, $name ) {
		if ( !empty( $GLOBALS[ $name . $id ] ) ) {
			return $GLOBALS[ $name . $id ];
		}

		return null;
	}

}

CVP_LIVE_FILTER_SIDEBAR::init();
