<?php

/*
 * Queries for Live Filter
 *
 * @since 5.0
 * @author ptguy
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    die;
}

class CVP_LIVE_FILTER_QUERY {

    static function init() {
        add_action( PT_CV_PREFIX_ . 'init', array( __CLASS__, 'add_ajax_action' ) );
        add_action( 'wp_head', array( __CLASS__, 'live_filter_url' ) );
        add_action( PT_CV_PREFIX_ . 'after_query', array( __CLASS__, 'get_matching_filters' ) );

        add_filter( PT_CV_PREFIX_ . 'set_current_page', array( __CLASS__, 'modify_view_page' ), 999 );
        add_filter( PT_CV_PREFIX_ . 'show_pagination', array( __CLASS__, 'show_pagination' ), 999 );
    }

    static function add_ajax_action() {
        $action = 'live_filter_reload';
        add_action( 'wp_ajax_' . $action, array( __CLASS__, 'live_filter_ajax' ) );
        add_action( 'wp_ajax_nopriv_' . $action, array( __CLASS__, 'live_filter_ajax' ) );
    }

    // Get current page
    static function _get_page() {
        global $cvp_lf_params;
        if ( !empty( $cvp_lf_params[ CVP_LF_PAGE ][ 0 ] ) ) {
            return intval( $cvp_lf_params[ CVP_LF_PAGE ][ 0 ] );
        }

        return 0;
    }

    // Set current page
    static function modify_view_page( $page ) {
        $selected_paged = self::_get_page();
        if ( $selected_paged ) {
            $page = $selected_paged;

            add_filter( PT_CV_PREFIX_ . 'timeline_wrap_items', '__return_true' );
        }

        return $page;
    }

    // Force to show pagination
    static function show_pagination( $show ) {
        if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'enable-pagination' ) && self::_get_page() ) {
            $show = true;
        }

        return $show;
    }

    // Get matching filters for selected values
    static function get_matching_filters() {
        $available_filters = PT_CV_Functions::get_global_variable( 'lf_enabled' );

        // Do nothing if not enabled any live filter
        if ( !$available_filters ) {
            return;
        }

        global $cvp_posts_where, $cvp_lf_queries, $cvp_lf_params;
        $cvp_posts_where = self::_get_post_type_and_status();
        $raw_post_query  = self::_get_posts_query_parameters();

        // Show all options of each filter all times, despite which filter is selecting
        $sc_params = PT_CV_Functions::get_global_variable( 'shortcode_params' );
        $lf_or     = strtoupper( $sc_params[ 'lf_relation' ] ) == 'OR';

        // Which filters to show, and its data (posts count, ...)
        $data = array( CVP_LF_PREFIX_TAX => array(), CVP_LF_PREFIX_CTF => array() );

        // Get options to show of each filter
        foreach ( $available_filters as $filter_type => $list ) {
            switch ( $filter_type ) {
                case CVP_LF_PREFIX_TAX:
                    foreach ( $list[ 'selected_filters' ] as $taxonomy => $params ) {
                        $tx_post_query = $raw_post_query;

                        // Not depend on other types: custom field, keyword
                        if ( $lf_or ) {
                            $posts_in = array();
                        } else {
                            $operator = self::get_operator_of_filter( $filter_type, array( 'filter' => $taxonomy, 'settings' => $list[ 'settings' ] ) );

                            // Show all options
                            if ( !isset( $cvp_lf_params[ 'tax_query' ][ $taxonomy ] ) || $operator === 'OR' ) {
                                foreach ( $tx_post_query[ 'tax_query' ] as $idx => $arr ) {
                                    if ( isset( $arr[ 'taxonomy' ] ) && $arr[ 'taxonomy' ] === $taxonomy ) {
                                        unset( $tx_post_query[ 'tax_query' ][ $idx ] );
                                        break;
                                    }
                                }
                            }

                            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-relation' ) === 'OR' ) {
                                // Options (to show) depend on its selected options
                                if ( $operator === 'AND' ) {
                                    $this_field = array();
                                    foreach ( $tx_post_query[ 'tax_query' ] as $arr ) {
                                        if ( isset( $arr[ 'taxonomy' ] ) && $arr[ 'taxonomy' ] === $taxonomy ) {
                                            $this_field = $arr;
                                            break;
                                        }
                                    }

                                    if ( !empty( $this_field ) ) {
                                        $tx_post_query[ 'tax_query' ] = array( $this_field );
                                    }
                                } else {
                                    unset( $tx_post_query[ 'tax_query' ] );
                                }
                            }

                            // Remove relation if single
                            if ( isset( $tx_post_query[ 'tax_query' ] ) && count( $tx_post_query[ 'tax_query' ] ) <= 1 ) {
                                unset( $tx_post_query[ 'tax_query' ][ 'relation' ] );
                            }

                            // Keep depend of custom field, keyword
                            // Query
                            $query1   = new WP_Query( $tx_post_query );
                            $posts_in = $query1->posts;
                            PT_CV_Functions::reset_query();

                            // If empty posts => force to return empty filters
                            if ( !$posts_in ) {
                                $posts_in = array( -1 );
                            }
                        }

                        // Get options
                        $results = array();
                        $parts   = $posts_in ? array_chunk( $posts_in, CVP_LF_MAX_IN ) : array( array() );
                        foreach ( $parts as $pin ) {
                            $results = array_merge( $results, CVP_LIVE_FILTER_MODEL::available_terms( $taxonomy, array_keys( $params ), $pin ) );
                        }

                        $distinct_values = array();
                        foreach ( $results as $term ) {
                            $value = $term->cvp_filter;
                            if ( !isset( $distinct_values[ $value ] ) ) {
                                $distinct_values[ $value ] = array( 'count' => (int) $term->counter );
                            } else {
                                $distinct_values[ $value ][ 'count' ] += (int) $term->counter;
                            }
                        }

                        $data[ CVP_LF_PREFIX_TAX ][ $taxonomy ] = $distinct_values;
                    }

                    break;

                case CVP_LF_PREFIX_CTF:
                    foreach ( $list[ 'selected_filters' ] as $ctf_name ) {
                        $ct_post_query = $raw_post_query;

                        // Not depend on other types: taxonomy, keyword
                        if ( $lf_or ) {
                            $posts_in = array();
                        } else {
                            $operator = self::get_operator_of_filter( $filter_type, array( 'filter' => $ctf_name, 'settings' => $list[ 'settings' ] ) );

                            // Show all options
                            if ( !isset( $cvp_lf_params[ 'meta_query' ][ $ctf_name ] ) || $operator === 'OR' ) {
                                foreach ( $ct_post_query[ 'meta_query' ] as $idx => $arr ) {
                                    if ( (isset( $arr[ 'key' ] ) && $arr[ 'key' ] === $ctf_name) || (isset( $arr[ 0 ][ 'key' ] ) && $arr[ 0 ][ 'key' ] === $ctf_name) ) {
                                        unset( $ct_post_query[ 'meta_query' ][ $idx ] );
                                        break;
                                    }
                                }
                            }

                            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'ctf-filter-relation' ) === 'OR' ) {
                                // Options (to show) depend on its selected options
                                if ( $operator === 'AND' ) {
                                    $this_field = array();
                                    foreach ( $ct_post_query[ 'meta_query' ] as $arr ) {
                                        if ( (isset( $arr[ 'key' ] ) && $arr[ 'key' ] === $ctf_name) || (isset( $arr[ 0 ][ 'key' ] ) && $arr[ 0 ][ 'key' ] === $ctf_name) ) {
                                            $this_field = $arr;
                                            break;
                                        }
                                    }

                                    if ( !empty( $this_field ) ) {
                                        $ct_post_query[ 'meta_query' ] = array( $this_field );
                                    }
                                } else {
                                    unset( $ct_post_query[ 'meta_query' ] );
                                }
                            }

                            // Remove relation if single
                            if ( isset( $ct_post_query[ 'meta_query' ] ) && count( $ct_post_query[ 'meta_query' ] ) <= 1 ) {
                                unset( $ct_post_query[ 'meta_query' ][ 'relation' ] );
                            }

                            // Keep depend of taxonomy, keyword
                            // Query
                            $query1   = new WP_Query( $ct_post_query );
                            $posts_in = $query1->posts;
                            PT_CV_Functions::reset_query();

                            // If empty posts => force to return empty filters
                            if ( !$posts_in ) {
                                $posts_in = array( -1 );
                            }
                        }

                        // Get options
                        $results = array();
                        $parts   = $posts_in ? array_chunk( $posts_in, CVP_LF_MAX_IN ) : array( array() );
                        foreach ( $parts as $pin ) {
                            $results = array_merge( $results, CVP_LIVE_FILTER_MODEL::available_ctf_values( $ctf_name, $pin ) );
                        }

                        $distinct_values = array();
                        foreach ( $results as $info ) {
                            if ( $info->cvp_filter !== '' ) {
                                $fvalues = cvp_sanitize_ctf_value( $info->cvp_filter, $ctf_name );

                                if ( !$fvalues ) {
                                    // Accept 0 if is numeric field
									$ctf_settings = CVP_LIVE_FILTER_CTF::settings_of_field( $list[ 'settings' ], $ctf_name );
									if ( is_numeric( $info->cvp_filter ) && in_array( $ctf_settings[ 'value-type' ], array( 'NUMERIC', 'DECIMAL' ) ) ) {
										$fvalues = array( $info->cvp_filter );
									} else {
										continue;
									}
								}

                                foreach ( $fvalues as $value ) {
                                    // For 'Checkboxes' type of Toolset Types
                                    if ( is_array( $value ) ) {
                                        $value = current( $value );
                                    }

                                    if ( !isset( $distinct_values[ $value ] ) ) {
                                        $distinct_values[ $value ] = array( 'count' => (int) $info->counter );
                                    } else {
                                        $distinct_values[ $value ][ 'count' ] += (int) $info->counter;
                                    }
                                }
                            }
                        }

                        $data[ CVP_LF_PREFIX_CTF ][ $ctf_name ] = $distinct_values;
                    }

                    break;
            }
        }

        global $cvp_lf_data;
        $cvp_lf_data = $data;
    }

    /**
     * Apply selected filters to query matching posts
     *
     * @param array $args
     * @param string $query_type
     * @param string $index
     * @param array $live_filter_settings
     * @return array
     */
    static function query_posts_by_filters( &$args, $query_type, $index, $live_filter_settings = array() ) {
        global $cvp_lf_params, $cvp_lf_queries;

        if ( !isset( $cvp_lf_queries ) ) {
            $cvp_lf_queries = array(); // Array of (filters => posts query)
        }

        if ( !isset( $args[ $query_type ] ) ) {
            $args[ $query_type ] = array();
        }

        if ( isset( $cvp_lf_params[ $query_type ] ) ) {
            $new_args = array( $query_type => array() );
            foreach ( $cvp_lf_params[ $query_type ] as $key => $live_filter ) {
                switch ( $query_type ) {
                    // Taxonomy
                    case 'tax_query':

                        $operator = self::get_operator_of_filter( CVP_LF_PREFIX_TAX, array( 'filter' => $key, 'settings' => $live_filter_settings ) );
                        $operator = count( $live_filter[ 'terms' ] ) === 1 ? 'IN' : ($operator === 'AND' ? 'AND' : 'IN');

                        $new_args[ $query_type ][ $key ] = array(
                            'taxonomy'         => $key,
                            'field'            => CVP_LF_TAX_SLUG ? 'slug' : 'id',
                            'terms'            => $live_filter[ 'terms' ],
                            'operator'         => $operator,
                            'include_children' => $operator == 'AND' || PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-exclude-children' ) ? false : true,
                        );
                        break;

                    // Custom field
                    case 'meta_query':
                        /** Skip unselected field
                         *
                         * Some nginx servers used old configuration:
                         * 		try_files $uri $uri/ /index.php?q=$uri&$args;
                         * => 'q' to be considered as custom field, caused "no posts found"
                         */
                        $available_filters = PT_CV_Functions::get_global_variable( 'lf_enabled' );
                        if ( isset( $available_filters[ CVP_LF_PREFIX_CTF ][ 'selected_filters' ] ) && !in_array( $key, $available_filters[ CVP_LF_PREFIX_CTF ][ 'selected_filters' ] ) ) {
                            break;
                        }

                        $values       = $live_filter[ 'value' ];
                        $ctf_settings = CVP_LIVE_FILTER_CTF::settings_of_field( $live_filter_settings, $key );
                        $this_setting = array();
                        $value_type   = $ctf_settings[ 'value-type' ];
                        $value_type   = $value_type === 'DECIMAL' ? 'DECIMAL(15,5)' : $value_type;

                        if ( $ctf_settings[ 'filter-type' ] === 'date_range' || $ctf_settings[ 'filter-type' ] === 'range_slider' ) {
                            if ( $ctf_settings[ 'filter-type' ] === 'range_slider' ) {
                                if ( empty( $values[ 0 ] ) && !is_numeric( $values[ 0 ] ) ) {
                                    $compare = '>=';
                                } elseif ( empty( $values[ 1 ] ) ) {
                                    $compare = '<=';
                                } else {
                                    $compare = 'BETWEEN';
                                }
                            }

                            if ( $ctf_settings[ 'filter-type' ] === 'date_range' ) {
                                $date_operator = $ctf_settings[ 'date-operator' ];

                                if ( $date_operator !== 'date-fromto' ) {
                                    $values = $values[ 0 ];
                                }

                                switch ( $date_operator ) {
                                    case 'date-from':
                                        $compare = '>=';
                                        break;

                                    case 'date-to':
                                        $compare = '<=';
                                        break;

                                    case 'date-equal':
                                        $compare = 'LIKE';
                                        break;

                                    case 'date-fromto':
                                        if ( empty( $values[ 0 ] ) ) {
                                            $compare = '<=';
                                            $values  = $values[ 1 ];
                                        } elseif ( empty( $values[ 1 ] ) ) {
                                            $compare = '>=';
                                            $values  = $values[ 0 ];
                                        } else {
                                            $compare = 'BETWEEN';
                                        }

                                        break;
                                }
                            }

                            $this_setting = $values ? array(
                                'key'     => $key,
                                'value'   => $values,
                                'compare' => $compare,
                                'type'    => $value_type,
                            ) : null;
                        } else {
                            // Force to use first value if is not checkbox
                            if ( $ctf_settings[ 'filter-type' ] !== 'checkbox' ) {
                                $values = array( $values[ 0 ] );
                            } else if ( count( $values ) > 1 ) {
                                $this_setting[ 'relation' ] = $ctf_settings[ 'operator' ];
                            }

                            foreach ( $values as $value ) {
                                $this_setting[] = !cvp_in_option( 'cvp_serialized__ctf', $key ) ?
                                array(
                                    'key'     => $key,
                                    'value'   => $value,
                                    'compare' => '=',
                                    'type'    => $value_type,
                                ) :
                                // Search in serialized string
                                array(
                                    'key'     => $key,
                                    'value'   => '"' . $value . '"',
                                    'compare' => 'LIKE',
                                    'type'    => 'CHAR',
                                );
                            }
                        }

                        if ( $this_setting ) {
                            $new_args[ $query_type ][ $key ] = count( $this_setting ) > 1 ? $this_setting : $this_setting[ 0 ];
                        }

                        break;
                }
            }

            foreach ( $args[ $query_type ] as $idx => $settings ) {
                if ( isset( $settings[ $index ] ) ) {
                    // Name of taxonomy or custom field
                    $key = $settings[ $index ];

                    if ( isset( $new_args[ $query_type ][ $key ] ) ) {
                        $args[ $query_type ][ $idx ] = $new_args[ $query_type ][ $key ];
                        unset( $new_args[ $query_type ][ $key ] );
                    }
                }
            }
            $args[ $query_type ] = array_merge( $args[ $query_type ], $new_args[ $query_type ] );
        }

        if ( count( $args[ $query_type ] ) <= 1 ) {
            unset( $args[ $query_type ][ 'relation' ] );
        }

        foreach ( $args[ $query_type ] as $settings ) {
            $key = false; // Name of taxonomy or custom field
            if ( isset( $settings[ $index ] ) ) {
                $key = $settings[ $index ];
            }

            // Nested meta query
            if ( isset( $settings[ 0 ][ $index ] ) ) {
                $key = $settings[ 0 ][ $index ];
            }

            if ( $key ) {
                $cvp_lf_queries [ $key ] = $settings;
            }
        }
    }

    // Handle Ajax request
    static function live_filter_ajax() {
        #check_ajax_referer( PT_CV_PREFIX_ . 'ajax_nonce', 'ajax_nonce' );

        if ( isset( $_POST[ 'query' ], $_POST[ 'sid' ] ) ) {
            define( 'CVP_LIVE_FILTER_RELOAD', true );

            $view_id = cv_sanitize_vid( $_POST[ 'sid' ] );
            self::_parse_params( $_POST[ 'query' ] );

            if ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX && !empty( $_POST[ 'view_data' ] ) ) {
                $settings = array();
                parse_str( $_POST[ 'view_data' ], $settings );
            } else {
                $settings = PT_CV_Functions::view_get_settings( $view_id );
            }

            $view_html = PT_CV_Functions::view_process_settings( $view_id, $settings, null, null );
            // Don't need view_final_output(), because wrapper already existed on page
            echo $view_html;
        }

        die;
    }

    // Handle URL
    static function live_filter_url() {
		if ( isset( $_SERVER[ 'QUERY_STRING' ] ) ) {
			self::_parse_params( $_SERVER[ 'QUERY_STRING' ] );
		}
	}

    // Get operator and/or of options in same filter
    static function get_operator_of_filter( $filter_type, $array ) {
        switch ( $filter_type ) {
            case CVP_LF_PREFIX_TAX:
                $configured_settings = @$array[ 'settings' ][ $array[ 'filter' ] ];
                $operator            = ( $configured_settings[ 'live-filter-type' ] === 'checkbox') ? $configured_settings[ 'live-filter-operator' ] : 'OR';

                break;

            case CVP_LF_PREFIX_CTF:
                $configured_settings = CVP_LIVE_FILTER_CTF::settings_of_field( $array[ 'settings' ], $array[ 'filter' ] );
                $operator            = ( $configured_settings[ 'filter-type' ] === 'checkbox') ? $configured_settings[ 'operator' ] : 'OR';

                break;
        }

        return $operator;
    }

    /**
     * Parse parameters from AJAX, URL
     * @param type $string
     */
    static function _parse_params( $string ) {
        $array  = array();
        $params = array();

        if ( !empty( $string ) ) {
            $string                           = apply_filters( PT_CV_PREFIX_ . 'lf_query_string', $string );
            $GLOBALS[ 'cvp_lf_query_string' ] = cv_esc_sql( $string );
        }

        parse_str( $string, $array );

        foreach ( $array as $key => $value ) {
            $key   = cv_esc_sql( $key );
            $value = is_array( $value ) ? $value : explode( CVP_LF_SEPARATOR, cv_esc_sql( $value ) );

            if ( in_array( $key, array( CVP_LF_PAGE, CVP_LF_SEARCH, CVP_LF_SORT, CVP_LF_WHICH_PAGE ) ) ) {
                $params[ $key ] = $value;
            } elseif ( strpos( $key, CVP_LF_PREFIX_TAX ) === 0 ) {
                $tax = CVP_LIVE_FILTER::filter_name_prefix( $key, CVP_LF_PREFIX_TAX, 'remove' );

                if ( !isset( $params[ 'tax_query' ] ) ) {
                    $params[ 'tax_query' ] = array();
                }

                $params[ 'tax_query' ][ $tax ] = array(
                    'terms' => $value,
                );
            } else {
                $key = CVP_LIVE_FILTER::filter_name_prefix( $key, CVP_LF_PREFIX_CTF, 'remove' );

                if ( !isset( $params[ 'meta_query' ] ) ) {
                    $params[ 'meta_query' ] = array();
                }

                $params[ 'meta_query' ][ $key ] = array(
                    'value' => $value,
                );
            }
        }

        global $cvp_lf_params;
        $cvp_lf_params = $params;
    }

    /**
     * Get selected post type & status
     */
    static function _get_post_type_and_status() {
        global $wpdb;
        $where = '';

        $posts_query_params = PT_CV_Functions::get_global_variable( 'args' );

        // When replacing layout
        if ( empty( $posts_query_params[ 'post_type' ] ) ) {
            $posts_query_params[ 'post_type' ] = 'any';
        }

        $post_type = ($posts_query_params[ 'post_type' ] === 'any') ? get_post_types( array( 'exclude_from_search' => false ) ) : (array) $posts_query_params[ 'post_type' ];
        if ( !empty( $post_type ) && is_array( $post_type ) ) {
            $where .= " AND $wpdb->posts.post_type IN ('" . join( "', '", $post_type ) . "')";
        }

        $post_status = (array) $posts_query_params[ 'post_status' ];
        if ( !empty( $post_status ) && is_array( $post_status ) ) {
            $where .= " AND $wpdb->posts.post_status IN ('" . join( "', '", $post_status ) . "')";
        }

        $post_not_in = (array) $posts_query_params[ 'post__not_in' ];
        if ( !empty( $post_not_in ) && is_array( $post_not_in ) ) {
            $where .= " AND $wpdb->posts.ID NOT IN ('" . join( "', '", $post_not_in ) . "')";
        }

        return $where;
    }

    // Get post query parameters of this View
    static function _get_posts_query_parameters() {
        $posts_query_params = PT_CV_Functions::get_global_variable( 'args' );

        $excluding_params = array(
            #'author', 'author_name', 'author__in', // For author filter, maybe
            'orderby',
            'order'
        );

        foreach ( $excluding_params as $param ) {
            unset( $posts_query_params[ $param ] );
        }

        $posts_query_params[ 'fields' ]         = 'ids';
        $posts_query_params[ 'posts_per_page' ] = -1;
        $posts_query_params[ 'nopaging' ]       = true;

        return $posts_query_params;
    }

}

CVP_LIVE_FILTER_QUERY::init();
