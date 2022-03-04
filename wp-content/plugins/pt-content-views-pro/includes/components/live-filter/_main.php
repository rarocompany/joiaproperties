<?php
/*
 * Live Filter Type
 *
 * @since 5.0
 * @author ptguy
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	die;
}

define( 'CVP_LF_MAX_IN', 1000 );
define( 'CVP_LF_PREFIX_CTF', 'custom-fields' );
define( 'CVP_LF_PREFIX_TAX', 'tx' );
define( 'CVP_LF_SEPARATOR', ',' );
define( 'CVP_LF_SORT', '_orderby' );
define( 'CVP_LF_PAGE', '_page' );
define( 'CVP_LF_WHICH_PAGE', '_cvpwp' );
CVP_LIVE_FILTER::is_search_page() ? define( 'CVP_LF_SEARCH', 's' ) : define( 'CVP_LF_SEARCH', '_search' );
define( 'CVP_LF_TAX_SLUG', true ); // true: use term slug, false: use term id

include_once dirname( __FILE__ ) . '/_sidebar.php';
include_once dirname( __FILE__ ) . '/_get_filters.php';
include_once dirname( __FILE__ ) . '/_output.php';
include_once dirname( __FILE__ ) . '/_settings.php';
include_once dirname( __FILE__ ) . '/_process_filters.php';
include_once dirname( __FILE__ ) . '/admin.php';
include_once dirname( __FILE__ ) . '/search.php';
include_once dirname( __FILE__ ) . '/taxonomy.php';
include_once dirname( __FILE__ ) . '/custom-field.php';
include_once dirname( __FILE__ ) . '/orderby.php';

// Reposition filters
add_action( PT_CV_PREFIX_ . 'add_global_variables', 'cvp_livefilter_reposition', 1 );
function cvp_livefilter_reposition() {
	$lfp = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'position-live-filters' );
	if ( strpos( $lfp, ',' ) !== false ) {
		$GLOBALS[ 'cvp_live_filter_list' ] = array();
		PT_CV_Functions::set_global_variable( 'lf_reposition', explode( ',', $lfp ) );
		add_filter( PT_CV_PREFIX_ . 'before_output_html', array( 'CVP_LIVE_FILTER', 'repositioned_list' ), PHP_INT_MAX );
	}
}

class CVP_LIVE_FILTER {

	protected $filter_type		 = null;
	protected $selected_filters	 = null;
	protected $settings			 = null;

	public function __construct( $filter_type ) {
		$this->filter_type = $filter_type;

		$this->get_selected_filters();
		if ( !empty( $this->selected_filters ) ) {
			$this->save_filters();
			add_filter( PT_CV_PREFIX_ . 'query_params', array( $this, 'modify_query' ), 999 );
			add_filter( PT_CV_PREFIX_ . 'before_output_html', array( $this, 'show_as_filter' ), 999 );
			// This is the about last filter of a View
			add_filter( PT_CV_PREFIX_ . 'wrapper_class', array( $this, 'remove_attached_filters' ), 999 );
		}
	}

	// Check if this filter is enabled under Filter Settings > Advance
	public function is_this_enabled( $field ) {
		$advanced_settings = (array) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'advanced-settings' );
		return in_array( $field, $advanced_settings );
	}

	// Get enabled filters
	public function get_selected_filters() {

	}

	// Store list of enabled filters
	public function save_filters() {
		$enabled_filters = PT_CV_Functions::get_global_variable( 'lf_enabled' );
		if ( !$enabled_filters ) {
			$enabled_filters = array();
		}

		$this_filter = array( $this->filter_type => array(
				'selected_filters'	 => $this->selected_filters,
				'settings'			 => $this->settings,
			) );
		PT_CV_Functions::set_global_variable( 'lf_enabled', array_merge( $enabled_filters, $this_filter ) );
	}

	// Use selected values to query posts
	public function modify_query( $args ) {
		PT_CV_Functions::set_global_variable( 'args', $args );

		return $args;
	}

	// Show this filter in frontend
	public function show_as_filter( $args ) {
		return $args;
	}

	// Get label text of filter
	public function get_label( $group, $idx, $field ) {
		if ( !empty( $this->settings[ $group ][ $idx ] ) ) {
			$text = $this->settings[ $group ][ $idx ];
		} else {
			$text = self::default_label( $field );
		}

		return $text;
	}

	// Set relation of multiple taxonomies or multiple custom fields
	public function set_relation( &$array, $selected_val ) {
		if ( count( $array ) > 1 ) {
			$array[ 'relation' ] = $selected_val;
		}
	}

	static function default_label( $field ) {
		return ucwords( str_replace( array( '', '_' ), ' ', $field ) );
	}

	// Add/remove prefix to/from filter
	static function filter_name_prefix( $name, $type, $action ) {
		$prefix		 = '';
		$separator	 = '';
		$space		 = ' ';

		switch ( $type ) {
			case CVP_LF_PREFIX_TAX:
				$prefix = CVP_LF_PREFIX_TAX . '_';
				break;

			case CVP_LF_PREFIX_CTF:
				// Add prefix to custom field which is one of public query variables. Otherwise, access url directly with /?key=value will cause 404
				$ctf_prefix = '__';
				foreach ( $GLOBALS[ 'wp' ]->public_query_vars as $value ) {
					if ( $name == $value || $name == $ctf_prefix . $value ) {
						$prefix = $ctf_prefix;
						break;
					}
				}

				// Add separator to custom field name contains space
				$ctf_sep = '---';
				if ( strpos( $name, $space ) !== false || strpos( $name, $ctf_sep ) !== false ) {
					$separator = $ctf_sep;
				}

				break;
		}

		if ( $prefix ) {
			if ( $action === 'add' ) {
				$name = $prefix . $name;
			} else {
				$name = substr( $name, strlen( $prefix ) );
			}
		}

		if ( $separator ) {
			if ( $action === 'add' ) {
				$name = str_replace( $space, $separator, $name );
			} else {
				$name = str_replace( $separator, $space, $name );
			}
		}

		return $name;
	}

	// Check is search page normally, in ajax request, etc.
	static function is_search_page() {
		if ( isset( $_GET[ 's' ] ) ) {
			return true;
		}

		if ( !empty( $_REQUEST[ 'query' ] ) && is_string( $_REQUEST[ 'query' ] ) ) {
			if ( strpos( $_REQUEST[ 'query' ], CVP_LF_WHICH_PAGE . '=s' ) !== false ) {
				return true;
			}
			if ( preg_match( '/[\?&]?s=/', $_REQUEST[ 'query' ] ) ) {
				return true;
			}
		}

		return false;
	}

	// Prevent filters affect to the following Views
	public function remove_attached_filters( $args ) {
		// Fix: Live Filter modified query of followed Views in same page
		remove_filter( PT_CV_PREFIX_ . 'query_params', array( $this, 'modify_query' ), 999 );

		// Fix duplication: 2 Views with Live Filter on page, filters of View 1 will appear twice
		remove_filter( PT_CV_PREFIX_ . 'before_output_html', array( $this, 'show_as_filter' ), 999 );

		return $args;
	}

	/** Reorder filters
	 *
	 * @param type $name
	 * @param type $type
	 * @param type $html
	 */
	static function default_list( $name, $html ) {
		$GLOBALS[ 'cvp_live_filter_list' ][ $name ] = $html;
	}

	static function repositioned_list( $args ) {
		$lfp = PT_CV_Functions::get_global_variable( 'lf_reposition' );
		if ( is_array( $lfp ) ) {
			$lf_list = PT_CV_Functions_Pro::_array_replace( array_flip( $lfp ), $GLOBALS[ 'cvp_live_filter_list' ] );
			$args	 = implode( '', $lf_list ) . $args;
		}

		return $args;
	}

}
