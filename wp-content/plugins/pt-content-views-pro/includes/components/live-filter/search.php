<?php
/*
 * Show search field
 *
 * @since 5.0
 * @author ptguy
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    die;
}

add_action( PT_CV_PREFIX_ . 'add_global_variables', 'cvp_livefilter_searchfield' );
function cvp_livefilter_searchfield() {
    new CVP_LIVE_FILTER_SEARCH( CVP_LF_SEARCH );
}

class CVP_LIVE_FILTER_SEARCH extends CVP_LIVE_FILTER {

    // Get the searched value from Ajax request/URL
    static function get_searched_value() {
        global $cvp_lf_params;
        if ( !empty( $cvp_lf_params[ CVP_LF_SEARCH ][ 0 ] ) ) {
            return stripslashes( $cvp_lf_params[ CVP_LF_SEARCH ][ 0 ] );
        }

        return null;
    }

    function get_selected_filters() {
        if ( !$this->is_this_enabled( 'search' ) ) {
            return;
        }

        if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'search-live-filter-enable' ) ) {
            $this->selected_filters = true;
        }
    }

    /**
     * Update search parameter before querying posts
     *
     * @param array $args
     * @return array
     */
    function modify_query( $args ) {
        $searched_value = self::get_searched_value();
        if ( $searched_value ) {
            $args[ 's' ] = $searched_value;
        }

        return parent::modify_query( $args );
    }

    function show_as_filter( $args ) {
        if ( $this->selected_filters ) {
            $type   = 'search_field';
            $others = array(
                'label'       => PT_CV_Functions::setting_value( PT_CV_PREFIX . 'search-live-filter-heading' ),
                'value'       => '',
                'placeholder' => PT_CV_Functions::setting_value( PT_CV_PREFIX . 'search-live-filter-placeholder' ),
            );

            if ( method_exists( 'CVP_LIVE_FILTER_OUTPUT', $type ) ) {
                $ctf  = new CVP_LIVE_FILTER_OUTPUT( CVP_LF_SEARCH, $type, CVP_LF_SEARCH, null, $others );
                $args .= $ctf->html();
            }
        }

        return parent::show_as_filter( $args );
    }

}
