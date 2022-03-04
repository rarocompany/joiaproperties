<?php
/**
 * Contain main functions to work with plugin, post, custom fields...
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <http://www.contentviewspro.com/>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'PT_CV_Functions_Pro' ) ) {

    /**
     * @name PT_CV_Functions_Pro
     * @todo Utility functions
     */
    class PT_CV_Functions_Pro {

        /**
         * Check if current user has role to manage Views
         */
        static function user_can_manage_view() {
            return current_user_can( 'administrator' ) || current_user_can( PT_CV_Functions::get_option_value( 'access_role' ) );
        }

        /**
         * Convert $options array to array with: key as 'name' of each parameter, value as settings of that parameters
         *
         * @param string $prefix  The prefix in name of settings
         * @param array  $options The options array (contain full paramaters of settings)
         */
        static function settings_pre_sort( $options ) {
            $result = array();
            foreach ( $options as $option ) {
                if ( $option[ 'params' ] ) {
                    foreach ( $option[ 'params' ] as $params ) {
                        // If name of setting match with prefix string, add new value is $option with key is that name
                        if ( isset( $params[ 'name' ] ) ) {
                            $result[ PT_CV_PREFIX . $params[ 'name' ] ] = $option;
                        }
                    }
                }
            }

            return $result;
        }

        /**
         * Sort $options array by the order of key in $settings_key array
         *
         * @param string $prefix       The prefix in name of settings
         * @param array  $options      The options array (contain full paramaters of settings)
         * @param array  $settings_key The array of settings key
         */
        static function settings_sort( $prefix, $options, $settings_key ) {
            if ( !$settings_key ) {
                return $options;
            }

            $result = array();

            $options = self::settings_pre_sort( $options );

            foreach ( $settings_key as $setting ) {
                // If name of setting match with prefix string, got it name
                if ( isset( $options[ $setting ] ) && substr( $setting, 0, strlen( $prefix ) ) === $prefix ) {
                    $result[ $setting ] = $options[ $setting ];
                    unset( $options[ $setting ] );
                }
            }

            // Append key which is not in $settings_key to beginning of $result
            $result = array_merge( $options, $result );

            return $result;
        }

        /**
         * Read top Google fonts
         *
         * @return array
         */
        static function get_google_fonts() {
            $font_data = get_option( PT_CV_PREFIX . 'google-fonts', array() );
            if ( $font_data ) {
                return $font_data;
            }

            // Limit top 50 fonts
            $limit = 50;

            // Google fonts data file
            $file_path = PT_CV_PATH_PRO . 'admin/includes/google-fonts.data';

            if ( file_exists( $file_path ) ) {
                $fp = @fopen( $file_path, 'r' );

                // Read all fonts data
                $contents = '';
                while ( !feof( $fp ) ) {
                    $contents .= fread( $fp, 8192 );
                }

                $data  = json_decode( $contents, true );
                $items = isset( $data[ 'items' ] ) ? $data[ 'items' ] : array();

                // Get top fonts
                $top_fonts = array_slice( (array) $items, 0, $limit );

                // Get font family, variants
                foreach ( $top_fonts as $font ) {
                    $font_data[ $font[ 'family' ] ] = $font[ 'variants' ];
                }

                add_option( PT_CV_PREFIX . 'google-fonts', $font_data );

                fclose( $fp );
            }

            return $font_data;
        }

        /**
         * Generate background position for each Google font
         */
        static function get_google_fonts_background_position() {

            $css = array();

            // Get font list
            $fonts_list = PT_CV_Values_Pro::font_families();
            $fonts_name = array_keys( $fonts_list );

            // Set background for each font by font name
            foreach ( $fonts_name as $idx => $name ) {
                $css[] = sprintf( '.select2-results li.%s { background-position: 0 -%spx }', PT_CV_PREFIX . 'font-' . sanitize_title( $name ), ( 40 * $idx + 10 ) );
            }

            return implode( "\n", $css );
        }

        /**
         * Get selected terms or all terms of selected taxonomies
         *
         * @global array $query_args
         *
         * @param array  $taxonomies_to_get Array of taxonomies
         *
         * @return array
         */
        public static function get_selected_terms( $taxonomies_to_get ) {
            if ( empty( $taxonomies_to_get ) ) {
                return array();
            }

            $query_args = PT_CV_Functions::get_global_variable( 'args' );
            $terms_info = apply_filters( PT_CV_PREFIX_ . 'terms_data_for_shuffle', isset( $query_args[ 'tax_query' ] ) ? $query_args[ 'tax_query' ] : array() );

            // For translation plugin: use translated slugs here
            foreach ( $terms_info as $idx => $array ) {
                if ( isset( $array[ 'terms_slugs' ] ) ) {
                    $terms_info[ $idx ][ 'terms' ] = $array[ 'terms_slugs' ];
                }
            }

            // Don't need relation in this case
            if ( isset( $terms_info[ 'relation' ] ) ) {
                unset( $terms_info[ 'relation' ] );
            }

            // Get all terms of selected taxonomy
            $terms_of_taxonomies = array();
            foreach ( (array) $taxonomies_to_get as $taxonomy ) {
                PT_CV_Values::term_of_taxonomy( $taxonomy, $terms_of_taxonomies, array(), 'object' );
            }

            if ( $terms_info ) {
                foreach ( $terms_info as $term_info ) {
                    if ( !empty( $term_info[ 'terms' ] ) ) {
                        $taxonomy = $term_info[ 'taxonomy' ];
                        if ( !isset( $terms_of_taxonomies[ $taxonomy ] ) ) {
                            continue;
                        }

                        $all_terms = $terms_of_taxonomies[ $taxonomy ];

                        $compare = array();
                        if ( $term_info[ 'operator' ] == 'NOT IN' ) {
                            $compare = array_diff_key( $all_terms, array_flip( $term_info[ 'terms' ] ) );
                        } else {
                            // Do not use array_intersect_key(), it requires another step to get terms in selected order
                            foreach ( $term_info[ 'terms' ] as $term_slug ) {
                                if ( !empty( $all_terms[ $term_slug ] ) ) {
                                    $compare[ $term_slug ] = $all_terms[ $term_slug ];
                                }
                            }
                        }

                        if ( $compare ) {
                            $terms_of_taxonomies[ $taxonomy ] = $compare;
                        }
                    }
                }
            }

            return PT_CV_Functions_Pro::_array_replace( array_flip( $taxonomies_to_get ), $terms_of_taxonomies );
        }

        /**
         * array_replace is a php 5.3+ function, this is needed to support the oldies
         *
         * @param array $base_order		Order to sort
         * @param array $reorder_arr	Array to sort by order
         * @param string $action
         * @return array
         */
        static function _array_replace( $base_order, $reorder_arr, $action = 'append' ) {
            $result = array();
            foreach ( array_keys( $base_order ) as $key ) {
                if ( isset( $reorder_arr[ $key ] ) ) {
                    $result[ $key ] = $reorder_arr[ $key ];
                    unset( $reorder_arr[ $key ] );
                }
            }

            // Append remain elements in $reorder_arr to $result
            if ( $action === 'append' ) {
                $result += $reorder_arr;
            } else {
                $result = $reorder_arr + $result;
            }

            return $result;
        }

        /**
         * Overwrite WordPress layout by CVPro layout
         * http://docs.contentviewspro.com/completely-replace-wordpress-layout-by-content-views-pro-layout/
         *
         * @global object $pt_cv_glb
         * @global string $pt_cv_id
         * @global object $wp_query
         * @global object $post
         * @return string
         */
        static function view_overwrite_tpl() {

            define( 'PT_CV_VIEW_OVERWRITE', true );

            /* Backward compatible */
            $args_count = func_num_args();
            $args_list  = func_get_args();

            // Default value
            $id         = 0;
            $posts      = array();
            $query_obj  = NULL;
            $pagination = false; // Use theme pagination by default
            $rebuild    = false;

            $existed_params = array( 'id', 'posts', 'query_obj', 'pagination' );

            switch ( $args_count ) {
                case 1:
                    $param = $args_list[ 0 ];
                    if ( is_string( $param ) ) {
                        $id = $param;
                    } elseif ( is_array( $param ) ) {
                        extract( $param );
                    }
                    break;

                case 2:
                case 3:
                case 4:
                    foreach ( $existed_params as $index => $name ) {
                        if ( isset( $args_list[ $index ] ) ) {
                            $$name = $args_list[ $index ];
                        }
                    }

                    break;
            }
            /* End Backward compatible */

            // View settings
            $view_settings = PT_CV_Functions::view_get_settings( $id );

            if ( !$rebuild ) {
                global $pt_cv_glb, $pt_cv_id;

                if ( !isset( $pt_cv_glb ) ) {
                    $pt_cv_glb = array();
                }

                // Get content type & view type
                $content_type = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'content-type', $view_settings );
                $view_type    = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'view-type', $view_settings );

                // Set global variable
                $pt_cv_id                                  = $id;
                $pt_cv_glb[ $pt_cv_id ][ 'view_settings' ] = $view_settings;
                $pt_cv_glb[ $pt_cv_id ][ 'content_type' ]  = $content_type;
                $pt_cv_glb[ $pt_cv_id ][ 'view_type' ]     = $view_type;

                $dargs = $args  = array();
                $dargs = apply_filters( PT_CV_PREFIX_ . 'all_display_settings', PT_CV_Functions::view_display_settings( $view_type, $dargs ) );

                PT_CV_Functions::view_get_pagination_settings( $dargs, $args, array() );
                $pt_cv_glb[ $pt_cv_id ][ 'dargs' ] = $dargs;

                do_action( PT_CV_PREFIX_ . 'before_process_item' );
                $content_items = array();
                if ( $posts ) {
                    foreach ( $posts as $post ) {
                        if ( is_object( $post ) ) {
                            setup_postdata( $post );
                            // Output HTML for this item
                            $content_items[ $post->ID ] = PT_CV_Html::view_type_output( $view_type, $post );
                        }
                    }
                } else {
                    // The Loop
                    while ( $query_obj ? $query_obj->have_posts() : have_posts() ) : $query_obj ? $query_obj->the_post() : the_post();
                        global $post;

                        // Output HTML for this item
                        $content_items[ $post->ID ] = PT_CV_Html::view_type_output( $view_type, $post );
                    endwhile;
                }

                do_action( PT_CV_PREFIX_ . 'after_process_item' );

                // Filter array of items
                $content_items = apply_filters( PT_CV_PREFIX_ . 'content_items', $content_items, $view_type );

                // Wrap items to a wrapper
                $view_html = PT_CV_Html::content_items_wrap( $content_items, 1, count( $content_items ), $id );

                // Clear to prevent the element to shift up in the remaining space
                $view_html .= '<div style="clear: both;"></div>';

                // Show pagination
                $view_html .= $pagination ? self::paginate_links() : '';
            } else {
                // Rebuild whole output with custom pagination in View
                global $wp_query;
                $wp_query->query_vars[ 'post_status' ]     = 'publish';
                $view_settings[ PT_CV_PREFIX . 'rebuild' ] = $wp_query->query_vars;
                $view_settings[ PT_CV_PREFIX . 'limit' ]   = '-1';

                // Show View output
                $view_html = PT_CV_Functions::view_process_settings( $id, $view_settings );
            }

            return PT_CV_Functions::view_final_output( $view_html );
        }

        /**
         * Show pagination
         */
        static function paginate_links() {
            ob_start();
            ?>
            <div class="text-center <?php echo PT_CV_PREFIX; ?>pagination-wrapper">
                <?php
                global $wp_query;
                $pagination = paginate_links( array(
                    'base'      => str_replace( PHP_INT_MAX, '%#%', esc_url( get_pagenum_link( PHP_INT_MAX ) ) ),
                    'format'    => '?paged=%#%',
                    'current'   => max( 1, absint( get_query_var( 'paged' ) ) ),
                    'total'     => $wp_query->max_num_pages,
                    'type'      => 'array',
                    'prev_text' => '&laquo;',
                    'next_text' => '&raquo;',
                    'prev_next' => false,
                ) );
                ?>
                <?php if ( !empty( $pagination ) ) : ?>
                    <ul class="<?php echo PT_CV_PREFIX; ?>pagination pagination" style="background-color: transparent !important;">
                        <?php
                        foreach ( $pagination as $page_link ) :
                            $class = (strpos( $page_link, 'current' ) !== false) ? 'active' : '';
                            ?>
                            <li class="<?php echo $class; ?>">
                                <?php echo str_replace( array( 'span', 'page-numbers' ), array( 'a', '' ), $page_link ) ?>
                            </li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </div>
            <?php
            return ob_get_clean();
        }

        /**
         * Get width, height of a size name (thumbnail, full, custom-size...)
         *
         * @global type  $_wp_additional_image_sizes
         *
         * @param string $size_name The size name
         *
         * @return array
         */
        static function get_dimensions_of_size( $size_name ) {
            // All available thumbnail sizes
            global $_wp_additional_image_sizes;

            $this_size = array();
            if ( in_array( $size_name, array( 'thumbnail', 'medium', 'large' ) ) ) {
                $this_size[] = get_option( $size_name . '_size_w' );
                $this_size[] = get_option( $size_name . '_size_h' );
            } else {
                if ( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $size_name ] ) ) {
                    $this_size[ 'width' ]  = $_wp_additional_image_sizes[ $size_name ][ 'width' ];
                    $this_size[ 'height' ] = $_wp_additional_image_sizes[ $size_name ][ 'height' ];
                } else {
                    $this_size = array( 0, 0 );
                }
            }

            return $this_size;
        }

        /**
         * Filter by date
         *
         * @param array $args
         */
        static function filter_by_date( &$args ) {

            $advanced_settings = (array) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'advanced-settings' );

            if ( in_array( 'date', $advanced_settings ) ) {
                $date_fields = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'post_date_' );
                if ( $date_fields ) {
                    $current_time = current_time( 'timestamp' );
                    $this_year    = date( 'Y', $current_time );
                    $this_month   = date( 'n', $current_time );

                    $date_value = isset( $date_fields[ 'value' ] ) ? $date_fields[ 'value' ] : '';
                    if ( $date_value ) {
                        $date_query = array();

                        switch ( $date_value ) {
                            case 'today':
                                $date_query = array(
                                    'year'  => $this_year,
                                    'month' => $this_month,
                                    'day'   => date( 'j', $current_time ),
                                );
                                break;

                            case 'today_in_history':
                                $date_query = array(
                                    'month' => $this_month,
                                    'day'   => date( 'j', $current_time ),
                                );
                                break;

                            case 'from_today':
                                $date_query = array(
                                    'after' => date( 'Y-m-d 23:59:59', strtotime( '-1 day', $current_time ) ),
                                );
                                break;

                            case 'in_the_past':
                                $date_query = array(
                                    'before' => date( 'Y-m-d H:i:s', $current_time ),
                                );
                                break;

                            case 'yesterday':
                                $yesterday = date( 'Y-m-d', strtotime( '-1 day', $current_time ) );
                                $date      = date_parse( $yesterday );

                                $date_query = array(
                                    'year'  => $date[ 'year' ],
                                    'month' => $date[ 'month' ],
                                    'day'   => $date[ 'day' ],
                                );
                                break;

                            case 'this_week':
                                $date_query = array(
                                    'year' => $this_year,
                                    'week' => date( 'W', $current_time ),
                                );
                                break;

                            case 'this_month':
                                $date_query = array(
                                    'year'  => $this_year,
                                    'month' => $this_month,
                                );
                                break;

                            case 'this_year':
                                $date_query = array(
                                    'year' => $this_year,
                                );
                                break;

                            // Time Ago
                            case 'week_ago':
                            case 'month_ago':
                            case 'year_ago':
                                $date_query = array(
                                    'column' => 'post_date',
                                    'after'  => sprintf( '1 %s ago', str_replace( '_ago', '', $date_value ) ),
                                );
                                break;

                            case 'custom_date':
                                if ( $cus_date = sanitize_text_field( $date_fields[ 'custom_date' ] ) ) {
                                    $date = date_parse( $cus_date );
                                    if ( $date ) {
                                        $date_query = array(
                                            'year'  => $date[ 'year' ],
                                            'month' => $date[ 'month' ],
                                            'day'   => $date[ 'day' ],
                                        );
                                    }
                                }
                                break;

                            case 'custom_year':
                                if ( $cus_year = sanitize_text_field( $date_fields[ 'custom_year' ] ) ) {
                                    $year = intval( $cus_year );
                                    if ( $year ) {
                                        $date_query = array(
                                            'year' => $year,
                                        );
                                    }
                                }
                                break;

                            case 'custom_month':
                                if ( $cus_month = sanitize_text_field( $date_fields[ 'custom_month' ] ) ) {
                                    $m = intval( $cus_month );
                                    if ( $m ) {
                                        $date_query = array(
                                            'month' => $m,
                                        );
                                    }
                                }
                                break;

                            // Custom From - To
                            case 'custom_time':
                                $today = date( 'Y-m-d', $current_time );
                                if ( trim( $date_fields[ 'from' ] ) === '' ) {
                                    $date_fields[ 'from' ] = $today;
                                }
                                if ( trim( $date_fields[ 'to' ] ) === '' ) {
                                    $date_fields[ 'to' ] = $today;
                                }

                                $from = date_parse( $date_fields[ 'from' ] );
                                $to   = date_parse( $date_fields[ 'to' ] );

                                if ( $from && $to ) {
                                    $date_query = array(
                                        'after'     => array(
                                            'year'  => $from[ 'year' ],
                                            'month' => $from[ 'month' ],
                                            'day'   => $from[ 'day' ],
                                        ),
                                        'before'    => array(
                                            'year'  => $to[ 'year' ],
                                            'month' => $to[ 'month' ],
                                            'day'   => $to[ 'day' ],
                                        ),
                                        'inclusive' => true,
                                    );
                                }
                                break;
                        }

                        if ( $date_query ) {
                            $args[ 'date_query' ] = array( $date_query );
                        }
                    }
                }
            }
        }

        /**
         * Check dependences before do action
         *
         * @param string $key The feature
         * @param bool $get_dependence Get instead of check
         */
        static function check_dependences( $key, $get_dependence = false ) {
            if ( !$key ) {
                return true;
            }

            $dargs = PT_CV_Functions::get_global_variable( 'dargs' );

            // Shuffle filter
            if ( $key == 'taxonomy-filter' ) {
                if ( PT_CV_Functions::get_global_variable( 'lf_enabled' ) ) {
                    cvp_preview_notice( __( 'For Administrator only: Shuffle Filter is disabled when enables Live Filter.', 'content-views-pro' ) );
                    return false;
                }

                $view_settings     = PT_CV_Functions::get_global_variable( 'view_settings' );
                $advanced_settings = (array) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'advanced-settings', $view_settings );
                if ( in_array( 'taxonomy', $advanced_settings ) && !empty( $view_settings[ PT_CV_PREFIX . 'taxonomy' ] ) ) {
                    return true;
                } else {
                    return false;
                }
            }

            // Read more - text link
            if ( $key == 'text-link' && isset( $dargs[ 'field-settings' ][ 'content' ][ 'readmore' ] ) && isset( $dargs[ 'field-settings' ][ 'content' ][ 'readmore-textlink' ] ) && $dargs[ 'field-settings' ][ 'content' ][ 'readmore-textlink' ] === 'yes' ) {
                return true;
            }

            if ( $key === 'special-field' ) {
                return PT_CV_Html_ViewType_Pro::ancient_timeline() ? false : true;
            }

            return false;
        }

        /**
         * Check if animation - show Content on hover is activated and ready to use
         */
        static function animate_activated_content_hover() {
            $hover_enable = PT_CV_Functions::get_global_variable( 'content_hover_enable' );
            if ( isset( $hover_enable ) ) {
                return $hover_enable;
            }

            $animation = PT_CV_Functions::get_global_variable( 'animation' );
            if ( !isset( $animation ) ) {
                $animation = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'anm-' );
                PT_CV_Functions::set_global_variable( 'animation', $animation );
            }

            $hover_enable = !empty( $animation[ 'overlay-enable' ] ) ? $animation[ 'overlay-enable' ] : false;

            if ( PT_CV_Functions_Pro::check_device( 'mobile' ) && !empty( $animation[ 'disable-onmobile' ] ) ) {
                $hover_enable = false;
            }

            if ( $hover_enable ) {
                $dargs = PT_CV_Functions::get_global_variable( 'dargs' );
                if ( !in_array( 'thumbnail', $dargs[ 'fields' ] ) ) {
                    $hover_enable = false;
                    cvp_preview_notice( __( 'To use overlay animation, please show thumbnail.', 'content-views-pro' ) );
                }
            }

            PT_CV_Functions::set_global_variable( 'content_hover_enable', $hover_enable );

            return $hover_enable;
        }

        /**
         * Return human readable date
         *
         * @param string $date
         * @return string
         */
        static function date_human( $date ) {
            return sprintf( __( '%s ago', 'content-views-pro' ), human_time_diff( $date, current_time( 'timestamp' ) ) );
        }

        /**
         * @author http://wordpress.stackexchange.com/questions/128538/image-resize-with-image-url/128540#128540
         */
        static function resize_img_by_url( $url, $width, $height = null, $crop = true, $single = true ) {

            //validate inputs
            if ( !$url || (!$width && !$height ) || !apply_filters( PT_CV_PREFIX_ . 'custom_img_generator', true ) )
                return false;

            //define upload path & dir
            $upload_info = wp_upload_dir();
            $upload_dir  = $upload_info[ 'basedir' ];
            $upload_url  = $upload_info[ 'baseurl' ];

            //check if $img_url is local
            if ( strpos( $url, $upload_url ) === false )
                return false;

            //define path of image
            $rel_path = str_replace( $upload_url, '', $url );
            $img_path = $upload_dir . $rel_path;

            //check if img path exists, and is an image indeed
            if ( !file_exists( $img_path ) OR ! getimagesize( $img_path ) )
                return false;

            //custom crop position
            $crop = apply_filters( PT_CV_PREFIX_ . 'image_crop', $crop );

            //get image info
            $info = pathinfo( $img_path );
            $ext  = $info[ 'extension' ];
            list($orig_w, $orig_h) = getimagesize( $img_path );

            //image already exists
            if ( $orig_w === $width && $orig_h === $height ) {
                return $url;
            }

            //get image size after cropping
            $dims  = image_resize_dimensions( $orig_w, $orig_h, $width, $height, $crop );
            $dst_w = $dims[ 4 ];
            $dst_h = $dims[ 5 ];

            //use this to check if cropped image already exists, so we can return that instead
            $suffix       = "{$dst_w}x{$dst_h}";
            $dst_rel_path = str_replace( '.' . $ext, '', $rel_path );
            $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

            if ( !$dst_h ) {
                //can't resize, so return original url
                $img_url = $url;
                $dst_w   = $orig_w;
                $dst_h   = $orig_h;
            }
            //else check if cache exists
            elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
                $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
            }
            //else, we resize the image and return the new resized image url
            else {

                // Note: pre-3.5 fallback check
                if ( function_exists( 'wp_get_image_editor' ) ) {
                    $editor = wp_get_image_editor( $img_path );

                    if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) )
                        return false;

                    $resized_file = $editor->save();

                    if ( !is_wp_error( $resized_file ) ) {
                        $img_url = str_replace( $upload_dir, $upload_url, $resized_file[ 'path' ] );
                    } else {
                        return false;
                    }
                } else {
                    $resized_img_path = image_resize( $img_path, $width, $height, $crop );
                    if ( !is_wp_error( $resized_img_path ) ) {
                        $img_url = str_replace( $upload_dir, $upload_url, $resized_img_path );
                    } else {
                        return false;
                    }
                }
            }

            //return the output
            if ( $single ) {
                $image = $img_url;
            } else {
                $image = array(
                    0 => $img_url,
                    1 => $dst_w,
                    2 => $dst_h
                );
            }

            return $image;
        }

        /**
         * Get heading word for Shuffle filter list
         *
         * @return type
         */
        static function shuffle_filter_group_setting( $idx = 0, $setting = 'heading-word' ) {
            $heading_word = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-filter-' . $setting );
            $words        = explode( ',', $heading_word );
            $all_text     = !empty( $words[ $idx ] ) ? sanitize_text_field( $words[ $idx ] ) : ($setting === 'heading-word' ? __( 'All', 'content-views-pro' ) : 'and');

            return $all_text;
        }

        /**
         * Check type of device
         * @return type
         */
        static function check_device( $device ) {
            global $cvp_is_mobile, $cvp_is_tablet;
            if ( !isset( $cvp_is_mobile, $cvp_is_tablet ) ) {
                $detect        = new Mobile_Detect_CV();
                $cvp_is_mobile = $detect->isMobile();
                $cvp_is_tablet = $detect->isTablet();
            }

            $result = null;
            switch ( $device ) {
                case 'mobile':
                    $result = $cvp_is_mobile && !$cvp_is_tablet;
                    break;

                case 'tablet':
                    $result = $cvp_is_tablet;
                    break;

                case 'mobile_tablet':
                    $result = $cvp_is_mobile;
                    break;
            }

            return $result;
        }

        /**
         * Show Edit Post button
         * @param object $post
         * @return string
         */
        static function show_edit_button( $post ) {
            $args = '';

            $show_edit_post = PT_CV_Functions::get_option_value( 'show_edit_post' );
            if ( PT_CV_Functions_Pro::user_can_manage_view() && !empty( $show_edit_post ) ) {
                $args = sprintf( '<a href="%s" class="%s" target="_blank">%s</a>', get_edit_post_link( is_object( $post ) ? $post->ID : $post ), PT_CV_PREFIX . 'edit-post', __( 'Edit Post' ) );
            }

            return $args;
        }

        /**
         * Check if filter by Taxonomy is checked & custom setting is selected
         * @param array $view_settings
         * @param string $field
         * @param string $value
         * @return boolean
         */
        static function taxonomy_custom_setting_enable( $view_settings, $field, $value = '' ) {
            $advanced_settings = (array) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'advanced-settings', $view_settings );
            $enable            = false;
            if ( in_array( 'taxonomy', $advanced_settings ) ) {
                $enable = isset( $view_settings[ PT_CV_PREFIX . $field ] );
                if ( $value != '' ) {
                    $enable = $enable && $view_settings[ PT_CV_PREFIX . $field ] == $value;
                }
            }

            return $enable;
        }

        /**
         * Callback function for ajax Search by title
         */
        static function ajax_callback_search_by_title() {
            // Validate request
            check_ajax_referer( PT_CV_PREFIX_ . 'ajax_nonce', 'ajax_nonce' );

            if ( !empty( $_POST[ 'data' ] ) ) {
                // Extract post data
                parse_str( $_POST[ 'data' ], $param );

                // Show View output
                $posts = self::search_by_title( $param[ 'search_title' ], $param[ 'post_type' ] );
                echo json_encode( $posts );
            }

            // Must exit
            die;
        }

        /**
         * Search posts by title
         *
         * @param string $search_title
         * @param string $post_type
         * @return object
         */
        static function search_by_title( $search_title, $post_type ) {
            $args = array(
                'post_type'        => cv_esc_sql( $post_type ),
                'posts_per_page'   => -1,
                'cvp_search_title' => cv_esc_sql( $search_title ),
                'post_status'      => in_array( $post_type, array( 'attachment', 'any' ) ) ? array( 'publish', 'inherit' ) : 'publish',
            );

            // Add filter to search posts by Title
            add_filter( 'posts_where', array( __CLASS__, 'search_post_by_title_filter' ), 10, 2 );

            $the_query = new WP_Query( $args );

            // The Loop
            $posts = array();
            if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    $posts[] = array( 'id' => get_the_ID(), 'title' => get_the_title() );
                }
            }

            // Restore original Post Data
            PT_CV_Functions::reset_query();

            // Remove filter to search posts by Title
            remove_filter( 'posts_where', array( __CLASS__, 'search_post_by_title_filter' ), 10, 2 );

            return $posts;
        }

        // Modify WP query by adding "title LIKE" sub query
        static function search_post_by_title_filter( $where, $wp_query ) {
            global $wpdb;

            $search_term = $wp_query->get( 'cvp_search_title' );
            if ( $search_term ) {
                $where .= ' AND LOWER(' . $wpdb->posts . '.post_title) LIKE LOWER(\'%' . cv_esc_sql( $wpdb->esc_like( $search_term ) ) . '%\')';
            }

            return $where;
        }

        /**
         * Try to regenerate image inside post content
         *
         * @param string $img Image src
         * @return string
         */
        static function resize_image_by_url( $img, $dimensions ) {
            if ( PT_CV_Functions::get_global_variable( 'hard_resize' ) ) {
                $original_img = preg_replace( '/-\d+x\d+/', '', $img ); // Remove widthxheight in image URL
                $resized_img  = PT_CV_Functions_Pro::resize_img_by_url( $original_img, !empty( $dimensions[ 0 ] ) ? $dimensions[ 0 ] : null, !empty( $dimensions[ 1 ] ) ? $dimensions[ 1 ] : null );

                if ( $resized_img ) {
                    $img = $resized_img;
                }
            }

            return $img;
        }

        /**
         * @return string|boolean
         */
        static function has_access_restriction_plugin() {
            if ( function_exists( 'members_can_current_user_view_post' ) ) {
                return 'Members';
            }
            if ( function_exists( 'pmpro_has_membership_access' ) ) {
                return 'Paid Memberships Pro';
            }
            if ( function_exists( 'mm_access_decision' ) ) {
                return 'MemberMouse';
            }
            if ( function_exists( 'rcp_user_can_access' ) ) {
                return 'Restrict Content Pro';
            }
            if ( function_exists( 'is_permitted_by_s2member' ) ) {
                return 's2Member';
            }
            if ( cv_is_active_plugin( 'memberpress' ) ) {
                return 'MemberPress';
            }

            return false;
        }

        /**
         * @return string|boolean
         */
        static function has_translation_plugin() {
            if ( function_exists( 'pll_current_language' ) ) {
                return 'Polylang';
            }
            if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
                return 'WPML';
            }
            if ( function_exists( 'qtranxf_use' ) ) {
                return 'qTranslate';
            }

            return false;
        }

        /**
         * Get share count for posts
         * [ post1: [service1:'count1', service2:'count2'],... ]
         */
        static function ajax_callback_share_count() {
            if ( apply_filters( PT_CV_PREFIX_ . 'disable_share_count', false ) ) {
                die;
            }

            // Validate request
            check_ajax_referer( PT_CV_PREFIX_ . 'ajax_nonce', 'ajax_nonce' );

            if ( !isset( $_POST[ 'posts' ], $_POST[ 'services' ] ) ) {
                die;
            }

            $result   = array();
            $services = (array) $_POST[ 'services' ];

            foreach ( (array) $_POST[ 'posts' ] as $id ) {
                $id            = absint( $id );
                $result[ $id ] = array();
                $url           = get_permalink( $id );
                if ( $url ) {
                    $buttons       = array( 'url' => $url ) + array_flip( $services );
                    $social_counts = new PT_CV_Social_Share_Count( $buttons );

                    if ( $social_counts ) {
                        foreach ( $services as $button ) {
                            $number = 0;
                            if ( !empty( $social_counts->socialCounts[ $button ] ) ) {
                                $number = $social_counts->socialCounts[ $button ];
                            }
                            $result[ $id ][ $button ] = sprintf( '<span class="%s">%s</span>', PT_CV_PREFIX . 'social-badge', esc_html( $number ) );
                        }
                    }
                }
            }

            // Show output
            echo json_encode( $result );

            // Must exit
            die;
        }

        static function is_pin_mas() {
            $view_type = PT_CV_Functions::get_global_variable( 'view_type' );
            return ( $view_type === 'pinterest' || $view_type === 'masonry' ) ? $view_type : false;
        }

        static function is_column_layout() {
            $view_type = PT_CV_Functions::get_global_variable( 'view_type' );
            return in_array( $view_type, array( 'grid', 'glossary', 'one_others' ) );
        }

        static function shuffle_filter_key( $term ) {
            return $term->taxonomy . '-' . $term->term_id;
        }

    }

}