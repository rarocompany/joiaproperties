<?php
/**
 * Custom filters/actions
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

if ( !class_exists( 'PT_CV_Hooks_Pro' ) ) {

    /**
     * @name PT_CV_Hooks_Pro
     */
    class PT_CV_Hooks_Pro {

        /**
         * Add custom filters/actions
         */
        static function init() {
            // Filter Output
            add_filter( PT_CV_PREFIX_ . 'view_settings', array( __CLASS__, 'filter_view_settings' ) );
            add_filter( PT_CV_PREFIX_ . 'regular_orderby', array( __CLASS__, 'filter_regular_orderby' ) );
            add_filter( PT_CV_PREFIX_ . 'found_posts', array( __CLASS__, 'filter_found_posts' ) );
            add_filter( PT_CV_PREFIX_ . 'total_posts', array( __CLASS__, 'filter_total_posts' ) );
            add_filter( PT_CV_PREFIX_ . 'post_type', array( __CLASS__, 'filter_post_type' ) );
            add_filter( PT_CV_PREFIX_ . 'hierarchical_post_type', array( __CLASS__, 'filter_hierarchical_post_type' ) );
            add_filter( PT_CV_PREFIX_ . 'post_status', array( __CLASS__, 'filter_post_status' ) );
            add_filter( PT_CV_PREFIX_ . 'settings_args_limit', array( __CLASS__, 'filter_settings_args_limit' ) );
            add_filter( PT_CV_PREFIX_ . 'settings_args_offset', array( __CLASS__, 'filter_settings_args_offset' ) );
            add_filter( PT_CV_PREFIX_ . 'field_thumbnail_dimension_output', array( __CLASS__, 'filter_field_thumbnail_dimensions' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'field_thumbnail_image', array( __CLASS__, 'filter_field_thumbnail_image' ), 10, 4 );
            add_filter( PT_CV_PREFIX_ . 'force_replace_thumbnail', array( __CLASS__, 'filter_force_replace_thumbnail' ) );
            add_filter( PT_CV_PREFIX_ . 'field_thumbnail_not_found', array( __CLASS__, 'filter_field_thumbnail_not_found' ), 10, 4 );
            add_filter( PT_CV_PREFIX_ . 'btn_more_html', array( __CLASS__, 'filter_btn_more_html' ), 10, 3 );
            add_filter( PT_CV_PREFIX_ . 'pagination_class', array( __CLASS__, 'filter_pagination_class' ) );
            add_filter( PT_CV_PREFIX_ . 'field_href_class', array( __CLASS__, 'filter_field_href_class' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'field_href_attrs', array( __CLASS__, 'filter_field_href_attrs' ), 10, 3 );
            add_filter( PT_CV_PREFIX_ . 'field_href', array( __CLASS__, 'filter_field_href' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'field_meta_author_html', array( __CLASS__, 'filter_field_meta_author_html' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'field_meta_merge_fields', array( __CLASS__, 'filter_field_meta_merge_fields' ) );
            add_filter( PT_CV_PREFIX_ . 'field_meta_seperator', array( __CLASS__, 'filter_field_meta_seperator' ) );
            add_filter( PT_CV_PREFIX_ . 'meta_field_html', array( __CLASS__, 'filter_meta_field_html' ) );
            add_filter( PT_CV_PREFIX_ . 'field_meta_prefix_text', array( __CLASS__, 'filter_field_meta_prefix_text' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'field_meta_date_final', array( __CLASS__, 'filter_field_meta_date_final' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'field_item_html', array( __CLASS__, 'filter_field_item_html' ), 10, 3 );
            add_filter( PT_CV_PREFIX_ . 'field_content_readmore_enable', array( __CLASS__, 'filter_field_content_readmore_enable' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'field_content_readmore_class', array( __CLASS__, 'filter_field_content_readmore_class' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'field_content_readmore_seperated', array( __CLASS__, 'filter_field_content_readmore_seperated' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'field_title_result', array( __CLASS__, 'filter_field_title_result' ), 10, 3 );
            add_filter( PT_CV_PREFIX_ . 'field_content_excerpt', array( __CLASS__, 'filter_field_content_excerpt' ), 10, 3 );
            add_filter( PT_CV_PREFIX_ . 'tag_to_remove', array( __CLASS__, 'filter_tag_to_remove' ) );
            add_filter( PT_CV_PREFIX_ . 'strip_tags', array( __CLASS__, 'filter_strip_tags' ) );
            add_filter( PT_CV_PREFIX_ . 'field_excerpt_dots', array( __CLASS__, 'filter_field_excerpt_dots' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'view_type_asset', array( __CLASS__, 'filter_view_type_asset' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'dargs_others', array( __CLASS__, 'filter_dargs_others' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'view_type_dir', array( __CLASS__, 'filter_view_type_dir' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'view_type_dir_special', array( __CLASS__, 'filter_view_type_dir_special' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'scrollable_toggle_icon', array( __CLASS__, 'filter_scrollable_toggle_icon' ) );
            add_filter( PT_CV_PREFIX_ . 'scrollable_interval', array( __CLASS__, 'filter_scrollable_interval' ) );
            add_filter( PT_CV_PREFIX_ . 'scrollable_fields_enable', array( __CLASS__, 'filter_scrollable_fields_enable' ) );
            add_filter( PT_CV_PREFIX_ . 'scrollable_caption_class', array( __CLASS__, 'filter_scrollable_caption_class' ) );
            add_filter( PT_CV_PREFIX_ . 'page_attr', array( __CLASS__, 'filter_page_attr' ), 10, 3 );
            add_filter( PT_CV_PREFIX_ . 'page_class', array( __CLASS__, 'filter_page_class' ) );
            add_filter( PT_CV_PREFIX_ . 'collapsible_filters', array( __CLASS__, 'filter_collapsible_filters' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'wrap_in_page', array( __CLASS__, 'filter_wrap_in_page' ) );
            add_filter( PT_CV_PREFIX_ . 'content_items_wrap', array( __CLASS__, 'filter_content_items_wrap' ), 10, 4 );
            add_filter( PT_CV_PREFIX_ . 'all_display_settings', array( __CLASS__, 'filter_all_display_settings' ) );
            add_filter( PT_CV_PREFIX_ . 'selected_terms', array( __CLASS__, 'filter_selected_terms' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'order_setting', array( __CLASS__, 'filter_order_setting' ) );
            add_filter( PT_CV_PREFIX_ . 'validate_settings', array( __CLASS__, 'filter_validate_settings' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'query_parameters', array( __CLASS__, 'filter_query_parameters' ) );
            add_filter( PT_CV_PREFIX_ . 'query_params', array( __CLASS__, 'filter_query_params' ), 9999 );
            add_filter( PT_CV_PREFIX_ . 'include_children', array( __CLASS__, 'filter_include_children' ) );
            add_filter( PT_CV_PREFIX_ . 'display_what', array( __CLASS__, 'filter_display_what' ) );
            add_filter( PT_CV_PREFIX_ . 'view_content', array( __CLASS__, 'filter_view_content' ) );
            add_filter( PT_CV_PREFIX_ . 'taxonomies_to_show', array( __CLASS__, 'filter_taxonomies_to_show' ) );
            add_filter( PT_CV_PREFIX_ . 'post_term', array( __CLASS__, 'filter_post_term' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'post_terms_output', array( __CLASS__, 'filter_post_terms_output' ), 10, 3 );
            add_filter( PT_CV_PREFIX_ . 'taxonomy_query_args', array( __CLASS__, 'filter_taxonomy_query_args' ) );
            add_filter( PT_CV_PREFIX_ . 'tax_list', array( __CLASS__, 'filter_tax_list' ) );
            add_filter( PT_CV_PREFIX_ . 'shortcode_params', array( __CLASS__, 'filter_shortcode_params' ) );
            add_filter( PT_CV_PREFIX_ . 'view_class', array( __CLASS__, 'filter_view_class' ) );
            add_filter( PT_CV_PREFIX_ . 'assets_files', array( __CLASS__, 'filter_assets_files' ) );
            add_filter( PT_CV_PREFIX_ . 'before_output_html', array( __CLASS__, 'filter_before_output_html' ) );
            add_filter( PT_CV_PREFIX_ . 'content_item_filter_value', array( __CLASS__, 'filter_content_item_filter_value' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'content_no_post_found_text', array( __CLASS__, 'filter_content_no_post_found_text' ) );
            add_filter( PT_CV_PREFIX_ . 'content_items', array( __CLASS__, 'filter_content_items' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'item_col_class', array( __CLASS__, 'filter_item_col_class' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'collapsible_open_all', array( __CLASS__, 'filter_collapsible_open_all' ) );
            add_filter( PT_CV_PREFIX_ . 'post__not_in', array( __CLASS__, 'filter_post__not_in' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'post_parent_id', array( __CLASS__, 'filter_post_parent_id' ) );
            add_filter( PT_CV_PREFIX_ . 'show_this_post', array( __CLASS__, 'filter_show_this_post' ) );
            add_filter( PT_CV_PREFIX_ . 'fields_html', array( __CLASS__, 'filter_fields_html' ), 10, 2 );
            add_filter( PT_CV_PREFIX_ . 'terms_to_filter', array( __CLASS__, 'filter_terms_to_filter' ) );
            add_filter( PT_CV_PREFIX_ . 'is_mobile', array( __CLASS__, 'filter_is_mobile' ) );
            add_filter( PT_CV_PREFIX_ . 'public_localize_script_extra', array( __CLASS__, 'filter_public_localize_script_extra' ) );
            add_filter( PT_CV_PREFIX_ . '2col_nowrap_fields', array( __CLASS__, 'filter_2col_nowrap_fields' ) );

            // Filter WP
            add_filter( 'posts_orderby', array( __CLASS__, 'filter_posts_orderby' ), 999, 2 );
            add_filter( 'posts_where', array( __CLASS__, 'filter_posts_where' ), 999, 2 );
            add_filter( 'oembed_dataparse', array( __CLASS__, 'filter_oembed_dataparse' ), 999, 3 );
            add_filter( 'wp_get_attachment_image_attributes', array( __CLASS__, 'filter_wp_get_attachment_image_attributes' ), 999, 3 );
            add_filter( 'cvp_get_attachment_image_attributes', array( __CLASS__, 'filter_wp_get_attachment_image_attributes' ), 999, 3 );

            // Do action
            add_action( PT_CV_PREFIX_ . 'print_view_style', array( __CLASS__, 'action_print_view_style' ) );
            add_action( PT_CV_PREFIX_ . 'before_query', array( __CLASS__, 'action_before_query' ) );
            add_action( PT_CV_PREFIX_ . 'after_query', array( __CLASS__, 'action_after_query' ) );
            add_action( PT_CV_PREFIX_ . 'add_global_variables', array( __CLASS__, 'action_add_global_variables' ) );
            add_action( PT_CV_PREFIX_ . 'enqueue_assets', array( __CLASS__, 'action_enqueue_assets' ) );
            add_action( PT_CV_PREFIX_ . 'item_extra_html', array( __CLASS__, 'action_item_extra_html' ) );
            add_action( PT_CV_PREFIX_ . 'view_process_start', array( __CLASS__, 'action_view_process_start' ) );
            add_action( PT_CV_PREFIX_ . 'view_process_end', array( __CLASS__, 'action_view_process_end' ) );

            do_action( PT_CV_PREFIX_ . 'init' );
        }

        /**
         * Get offset setting value
         *
         * @return int
         */
        static function get_offset_setting() {
            $offset = (int) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'offset', null, 0 );

            $sc_params = PT_CV_Functions::get_global_variable( 'shortcode_params' );
            if ( !empty( $sc_params[ 'offset' ] ) ) {
                $offset = intval( $sc_params[ 'offset' ] );
            }

            return ( $offset < 0 ) ? 0 : $offset;
        }

        /**
         * Filter View settings, for compatible with older versions
         *
         * @param array $args
         * @return array
         */
        static function filter_view_settings( $args ) {
            $view_version = !isset( $args[ PT_CV_PREFIX . 'version' ] ) ? 0 : ltrim( $args[ PT_CV_PREFIX . 'version' ], 'pro-' );

            if ( strpos( $view_version, 'free' ) !== false ) {
                $args[ PT_CV_PREFIX . 'scrollable-navigation' ]  = 'yes';
                $args[ PT_CV_PREFIX . 'scrollable-indicator' ]   = 'yes';
                $args[ PT_CV_PREFIX . 'scrollable-auto-cycle' ]  = 'yes';
                #$args[ PT_CV_PREFIX . 'field-excerpt-manual' ] = 'yes';
                $args[ PT_CV_PREFIX . 'field-excerpt-readmore' ] = 'yes';

                if ( !PT_CV_Functions::get_option_value( 'free_readmore_style' ) ) {
                    $args[ PT_CV_PREFIX . 'font-bgcolor-readmore' ]       = '#00aeef';
                    $args[ PT_CV_PREFIX . 'font-color-readmore' ]         = '#ffffff';
                    $args[ PT_CV_PREFIX . 'font-bgcolor-readmore:hover' ] = '#00aeef';
                    $args[ PT_CV_PREFIX . 'font-color-readmore:hover' ]   = '#ffffff';
                    $args[ PT_CV_PREFIX . 'font-bgcolor-more' ]           = '#00aeef';
                    $args[ PT_CV_PREFIX . 'font-color-more' ]             = '#ffffff';
                }

                $args[ PT_CV_PREFIX . 'font-weight-title' ] = 'bold';
            } else if ( $view_version && version_compare( $view_version, PT_CV_VERSION_PRO ) === -1 && apply_filters( PT_CV_PREFIX_ . 'backward_360', true ) ) {
                if ( !isset( $args[ PT_CV_PREFIX . 'advanced-settings' ] ) ) {
                    $args[ PT_CV_PREFIX . 'advanced-settings' ] = array();
                }

                if ( version_compare( $view_version, '3.6.0' ) === -1 ) {
                    $args[ PT_CV_PREFIX . 'advanced-settings' ][] = 'check_access_restriction';
                }

                if ( version_compare( $view_version, '3.6.3' ) === -1 ) {
                    if ( !empty( $args[ PT_CV_PREFIX . 'author-include-current' ] ) ) {
                        $args[ PT_CV_PREFIX . 'author-current-user' ] = 'include';
                    }
                    if ( !empty( $args[ PT_CV_PREFIX . 'author-not-include-current' ] ) ) {
                        $args[ PT_CV_PREFIX . 'author-current-user' ] = 'exclude';
                    }
                }

                if ( version_compare( $view_version, '3.7.1' ) === -1 ) {
                    $args[ PT_CV_PREFIX . 'custom-fields-enable-oembed' ]        = 'yes';
                    $args[ PT_CV_PREFIX . 'taxonomy-filter-trigger-pagination' ] = 'yes';
                }

                if ( version_compare( $view_version, '3.9.8' ) === -1 ) {
                    if ( !empty( $args[ PT_CV_PREFIX . 'post_parent-auto' ] ) ) {
                        $args[ PT_CV_PREFIX . 'post_parent-current' ] = 'yes';
                    }
                }

                if ( version_compare( $view_version, '3.9.9' ) === -1 ) {
                    if ( !empty( $args[ PT_CV_PREFIX . 'no-space' ] ) ) {
                        $args[ PT_CV_PREFIX . 'item-margin-value-top' ]    = '0';
                        $args[ PT_CV_PREFIX . 'item-margin-value-right' ]  = '0';
                        $args[ PT_CV_PREFIX . 'item-margin-value-bottom' ] = '0';
                        $args[ PT_CV_PREFIX . 'item-margin-value-left' ]   = '0';
                    }

                    if ( !empty( $args[ PT_CV_PREFIX . 'force-mask' ] ) ) {
                        $args[ PT_CV_PREFIX . 'anm-overlay-enable' ] = 'always';
                    } elseif ( !empty( $args[ PT_CV_PREFIX . 'anm-content-hover' ] ) ) {
                        $args[ PT_CV_PREFIX . 'anm-overlay-enable' ] = 'onhover';
                    }

                    if ( !empty( $args[ PT_CV_PREFIX . 'anm-overlay-enable' ] ) ) {
                        if ( empty( $args[ PT_CV_PREFIX . 'font-bgcolor-mask' ] ) ) {
                            $args[ PT_CV_PREFIX . 'font-bgcolor-mask' ] = 'rgba(51,51,51,0.6)';
                        }
                    }
                }

                if ( version_compare( $view_version, '4.1' ) === -1 ) {
                    $negative_fields = array(
                        'item-margin-value-bottom',
                        'item-padding-value-top',
                        'item-padding-value-right',
                        'item-padding-value-left',
                        'item-padding-value-bottom',
                        'margin-value-top',
                        'margin-value-right',
                        'margin-value-left',
                        'margin-value-bottom',
                    );

                    foreach ( $negative_fields as $field ) {
                        if ( isset( $args[ PT_CV_PREFIX . $field ] ) && (int) $args[ PT_CV_PREFIX . $field ] < 0 ) {
                            $args[ PT_CV_PREFIX . $field ] = 0;
                        }
                    }
                }

                if ( version_compare( $view_version, '4.1' ) === -1 ) {
                    if ( !empty( $args[ PT_CV_PREFIX . 'meta-fields-date-human' ] ) ) {
                        $args[ PT_CV_PREFIX . 'meta-fields-date-format-setting' ] = 'time_ago';
                    }
                }

                if ( version_compare( $view_version, '4.1' ) === -1 ) {
                    /**
                     * For very old Views which used background color of Content for Caption, Mask
                     */
                    if ( !empty( $args[ PT_CV_PREFIX . 'font-bgcolor-content' ] ) ) {
                        $rep = 0;
                        if ( $args[ PT_CV_PREFIX . 'view-type' ] === 'scrollable' ) {
                            $args[ PT_CV_PREFIX . 'font-bgcolor-carousel-caption' ] = $args[ PT_CV_PREFIX . 'font-bgcolor-content' ];
                            $rep++;
                        }

                        if ( !empty( $args[ PT_CV_PREFIX . 'anm-overlay-enable' ] ) ) {
                            $args[ PT_CV_PREFIX . 'font-bgcolor-mask' ] = $args[ PT_CV_PREFIX . 'font-bgcolor-content' ];
                            $rep++;
                        }

                        if ( $rep ) {
                            $args[ PT_CV_PREFIX . 'font-bgcolor-content' ] = '';
                        }
                    }
                }

                if ( version_compare( $view_version, '4.2' ) === -1 ) {
                    if ( !empty( $args[ PT_CV_PREFIX . 'enable-taxonomy-filter' ] ) ) {
                        $sf_type = !empty( $args[ PT_CV_PREFIX . 'taxonomy-filter-type' ] ) ? $args[ PT_CV_PREFIX . 'taxonomy-filter-type' ] : '';
                        if ( $sf_type ) {
                            $should_reset = $sf_type === 'breadcrumb' || $sf_type === 'group_by_taxonomy';

                            $props = array( 'color', 'bgcolor', 'family', 'style', 'size' );
                            foreach ( $props as $prop ) {
                                if ( !isset( $args[ PT_CV_PREFIX . "font-$prop-filter-bar" ] ) ) {
                                    continue;
                                }

                                if ( $sf_type != 'group_by_taxonomy' ) {
                                    $args[ PT_CV_PREFIX . "font-$prop-filter-bar-active" ] = $args[ PT_CV_PREFIX . "font-$prop-filter-bar" ];
                                } else {
                                    $args[ PT_CV_PREFIX . "font-$prop-filter-bar-heading" ] = $args[ PT_CV_PREFIX . "font-$prop-filter-bar" ];
                                }

                                if ( $should_reset ) {
                                    $args[ PT_CV_PREFIX . "font-$prop-filter-bar" ] = '';
                                }
                            }
                        }
                    }
                }

                if ( version_compare( $view_version, '4.2' ) === -1 ) {
                    foreach ( $args as $key => $value ) {
                        if ( strpos( $key, PT_CV_PREFIX . 'font-style' ) === 0 ) {
                            $font_weight = $font_style  = '';

                            // Get font style, weight
                            if ( $value === 'regular' ) {
                                $font_weight = '400';
                                $font_style  = 'normal';
                            } else {
                                if ( $value === 'italic' ) {
                                    $font_style = 'italic';
                                } else {
                                    $font_style = substr( $value, - 6 );
                                    if ( $font_style === 'italic' ) {
                                        $font_weight = substr( $value, 0, strlen( $value ) - 6 );
                                    } else {
                                        $font_weight = $value;
                                        $font_style  = '';
                                    }
                                }
                            }

                            $weight_key = str_replace( 'font-style-', 'font-weight-', $key );
                            if ( intval( $font_weight ) > 400 ) {
                                $args[ $weight_key ] = 'bold';
                            } else {
                                $args[ $weight_key ] = '';
                            }

                            if ( $font_style === 'italic' ) {
                                $args[ $key ] = $font_style;
                            } else {
                                $args[ $key ] = '';
                            }
                        }

                        if ( strpos( $key, PT_CV_PREFIX . 'font-decoration' ) === 0 ) {
                            $args[ $key ] = strtolower( $value );
                        }
                    }
                }

                # For very old hover animation
                if ( version_compare( $view_version, '4.2.1' ) === -1 ) {
                    if ( !empty( $args[ PT_CV_PREFIX . 'anm-overlay-enable' ] ) ) {
                        # Set white text if not set & mask bg is not white
                        if ( strpos( $args[ PT_CV_PREFIX . 'font-bgcolor-mask' ], '#fff' ) === false && empty( $args[ PT_CV_PREFIX . 'font-color-mask-text' ] ) ) {
                            $args[ PT_CV_PREFIX . 'font-color-mask-text' ] = '#ffffff';
                        }

                        # Remove item bg color if enabled overlay
                        if ( !empty( $args[ PT_CV_PREFIX . 'font-bgcolor-content-item' ] ) ) {
                            $args[ PT_CV_PREFIX . 'font-bgcolor-content-item' ] = '';
                        }
                    }
                }

                # Default font-weight bold for Title
                if ( version_compare( $view_version, '4.2.1' ) === -1 ) {
                    $args[ PT_CV_PREFIX . 'font-weight-title' ] = 'bold';
                }

                # Move Thumbnail to top if layout format is 2 columns (show thumbnail on left/right)
                if ( version_compare( $view_version, '4.2.1.1' ) === -1 && !empty( $args[ PT_CV_PREFIX . 'layout-format' ] ) ) {
                    if ( $args[ PT_CV_PREFIX . 'layout-format' ] === '2-col' ) {
                        # only 2 these layouts had different process for 2 columns format
                        if ( in_array( $args[ PT_CV_PREFIX . 'view-type' ], array( 'grid', 'collapsible' ) ) ) {
                            if ( !empty( $args[ PT_CV_PREFIX . 'show-field-thumbnail' ] ) ) {
                                $new_arr = array( PT_CV_PREFIX . 'show-field-thumbnail' => 'yes' );
                                unset( $args[ PT_CV_PREFIX . 'show-field-thumbnail' ] );
                                $args    = array_merge( $new_arr, $args );
                            }
                        }
                    }
                }

                # Exclude fields from overlay
                if ( version_compare( $view_version, '4.3.0.2' ) === -1 ) {
                    if ( !empty( $args[ PT_CV_PREFIX . 'anm-exclude-title' ] ) ) {
                        $args[ PT_CV_PREFIX . 'anm-exclude-fields' ] = array( 'title' );
                    }
                }

                # Grid border, set default values
                if ( version_compare( $view_version, '4.6.0' ) === -1 ) {
                    $arr = array(
                        'font-border-width-item-border' => 1,
                        'font-border-style-item-border' => 'solid',
                        'font-border-color-item-border' => '#ececec',
                    );

                    foreach ( $arr as $key => $value ) {
                        if ( empty( $args[ PT_CV_PREFIX . $key ] ) ) {
                            $args[ PT_CV_PREFIX . $key ] = $value;
                        }
                    }
                }

                # Images same size
                if ( version_compare( $view_version, '4.7.0' ) === -1 ) {
                    if ( !empty( $args[ PT_CV_PREFIX . 'field-thumbnail-same-width' ] ) || !empty( $args[ PT_CV_PREFIX . 'field-thumbnail-same-height' ] ) ) {
                        $args[ PT_CV_PREFIX . 'field-thumbnail-same-size' ] = 'yes';
                    }
                }

                # Sort by multi custom fields
                if ( version_compare( $view_version, '4.8.0' ) === -1 ) {
                    $fprefix = 'order-custom-field-';
                    $fields  = array( 'key', 'type', 'order', 'date-format' );
                    foreach ( $fields as $key ) {
                        # Convert single value to array
                        if ( !empty( $args[ PT_CV_PREFIX . $fprefix . $key ] ) ) {
                            $args[ PT_CV_PREFIX . $fprefix . $key ] = array( $args[ PT_CV_PREFIX . $fprefix . $key ] );
                        }
                    }
                }

                # Advanced Sort by Woocommerce Price
                if ( version_compare( $view_version, '4.8.0' ) === -1 ) {
                    if ( $args[ PT_CV_PREFIX . 'content-type' ] === 'product' && !empty( $args[ PT_CV_PREFIX . 'product-orderby' ] ) ) {
                        if ( !is_array( $args[ PT_CV_PREFIX . 'order-custom-field-key' ] ) ) {
                            $args[ PT_CV_PREFIX . 'order-custom-field-key' ]   = array( '_price' );
                            $args[ PT_CV_PREFIX . 'order-custom-field-type' ]  = array( 'NUMERIC' );
                            $args[ PT_CV_PREFIX . 'order-custom-field-order' ] = array( $args[ PT_CV_PREFIX . 'advanced-order' ] );
                        } else {
                            $args[ PT_CV_PREFIX . 'order-custom-field-key' ][]   = '_price';
                            $args[ PT_CV_PREFIX . 'order-custom-field-type' ][]  = 'NUMERIC';
                            $args[ PT_CV_PREFIX . 'order-custom-field-order' ][] = $args[ PT_CV_PREFIX . 'advanced-order' ];
                        }
                    }
                }

                if ( version_compare( $view_version, '4.8.1' ) === -1 ) {
                    if ( !empty( $args[ PT_CV_PREFIX . 'anm-overlay-enable' ] ) ) {
                        $args[ PT_CV_PREFIX . 'font-bgcolor-mask-hover' ] = $args[ PT_CV_PREFIX . 'font-bgcolor-mask' ];

                        if ( $args[ PT_CV_PREFIX . 'anm-overlay-enable' ] === 'always' ) {
                            $args[ PT_CV_PREFIX . 'font-bgcolor-mask' ] = 'rgba(0,0,0,.3)';
                        } else {
                            unset( $args[ PT_CV_PREFIX . 'font-bgcolor-mask' ] );
                        }
                    }
                }

                if ( version_compare( $view_version, '4.9.0' ) === -1 ) {
                    $args[ PT_CV_PREFIX . 'timeline-simulate-fb' ] = 'yes';

                    // The Hidden type is removed, so disable Live filter if selected that type
                    $taxonomies = PT_CV_Values::taxonomy_list();
                    foreach ( array_keys( $taxonomies ) as $taxonomy_slug ) {
                        if ( isset( $args[ PT_CV_PREFIX . $taxonomy_slug . '-live-filter-type' ] ) && $args[ PT_CV_PREFIX . $taxonomy_slug . '-live-filter-type' ] === 'hidden' ) {
                            unset( $args[ PT_CV_PREFIX . $taxonomy_slug . '-live-filter-enable' ] );
                        }
                    }
                }

                if ( version_compare( $view_version, '5.0' ) === -1 ) {
                    $args[ PT_CV_PREFIX . 'font-weight-gls-index' ]         = 'bold';
                    $args[ PT_CV_PREFIX . 'font-color-gls-index-active' ]   = '#fff';
                    $args[ PT_CV_PREFIX . 'font-bgcolor-gls-index-active' ] = '#ff5a5f';

                    $args[ PT_CV_PREFIX . 'search-live-filter-heading' ]   = __( 'Search', 'content-views-pro' );
                    $args[ PT_CV_PREFIX . 'livesort-live-filter-heading' ] = __( 'Sort by', 'content-views-pro' );
                }

                if ( version_compare( $view_version, '5.0.1' ) === -1 ) {
                    $sf_type = !empty( $args[ PT_CV_PREFIX . 'taxonomy-filter-type' ] ) ? $args[ PT_CV_PREFIX . 'taxonomy-filter-type' ] : '';
                    if ( $sf_type !== 'group_by_taxonomy' ) {
                        $args[ PT_CV_PREFIX . 'font-weight-filter-bar' ] = 'bold';
                    }
                }

                if ( version_compare( $view_version, '5.1.1' ) === -1 ) {
                    if ( isset( $args[ PT_CV_PREFIX . 'ctf-filter-live-filter-enable' ] ) ) {
                        $args[ PT_CV_PREFIX . 'ctf-filter-live-filter-hide-non-matching' ] = $args[ PT_CV_PREFIX . 'ctf-filter-live-filter-enable' ];
                    }
                }

                if ( version_compare( $view_version, '5.1.2' ) === -1 ) {
                    if ( isset( $args[ PT_CV_PREFIX . 's' ] ) ) {
                        $args[ PT_CV_PREFIX . 's' ] = str_replace( '+', ' ', $args[ PT_CV_PREFIX . 's' ] );
                    }
                }

                do_action( PT_CV_PREFIX_ . 'compatible_handle', $view_version, $args );
            }

            return $args;
        }

        /**
         * Filter regular orderby: Add meta key option
         *
         * @param array $args Array to filter
         *
         * @return array
         */
        static function filter_regular_orderby( $args ) {

            $args = array_merge(
            $args, array(
                'title_human'	 => __( 'Title (sort alphanumeric strings as human)', 'content-views-pro' ),
                'dragdrop'      => __( 'Drag & Drop', 'content-views-pro' ),
                'name'          => __( 'Post slug', 'content-views-pro' ),
                'post_type'     => __( 'Post type', 'content-views-pro' ),
                'rand'          => __( 'Random', 'content-views-pro' ),
                'comment_count' => __( 'Comment count', 'content-views-pro' ),
                'menu_order'    => __( 'Menu order', 'content-views-pro' ),
                'post_author'   => __( 'Author', 'content-views-pro' ),
                'relevance'     => __( 'Relevance to the searched keyword', 'content-views-pro' ),
            )
            );

            return $args;
        }

        /**
         * Filter total founds post
         *
         * @param int $args
         */
        public static function filter_found_posts( $args ) {
            $view_settings = PT_CV_Functions::get_global_variable( 'view_settings' );

            // Get offset
            $offset = self::get_offset_setting( $view_settings );

            // Ignore N posts (N = $offset)
            $args -= $offset;

            return $args;
        }

        /**
         * Count ads, to show enough number of pagination (include all limited/found posts + ads)
         *
         * @since 4.7.0
         * @param int $args
         * @return int
         */
        public static function filter_total_posts( $args ) {
            $args += CVP_ADVERT::count_ads();

            return $args;
        }

        /**
         * Filter post type
         *
         * @param string $args
         * @return string
         */
        public static function filter_post_type( $args ) {
            if ( $args === 'any' ) {
                $multi_post_types = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'multi-post-types' );
                $args             = is_array( $multi_post_types ) ? $multi_post_types : get_post_types( array( 'public' => true ) );
            }

            return $args;
        }

        /** Extend the parent page settings to any hierarchical post types
         * @since 5.7.1
         * @param array $args
         * @return array
         */
        public static function filter_hierarchical_post_type( $args ) {
            $post_types = get_post_types( array( 'public' => true, ), 'names' );
            foreach ( $post_types as $post_type ) {
                if ( !in_array( $post_type, $args ) && is_post_type_hierarchical( $post_type ) ) {
                    $args[] = $post_type;
                }
            }
            return $args;
        }

        /**
         * Filter post status to acquire
         *
         * @param string $args
         * @return string
         */
        public static function filter_post_status( $args ) {
            // Append 'future' status if querying by date 'Today and future'
            $advanced_settings = (array) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'advanced-settings' );
            if ( in_array( 'date', $advanced_settings ) && PT_CV_Functions::setting_value( PT_CV_PREFIX . 'post_date_value' ) === 'from_today' ) {
                if ( !in_array( 'future', $args ) ) {
                    $args[] = 'future';
                }
            }

            if ( in_array( PT_CV_Functions::get_global_variable( 'content_type' ), array( 'attachment', 'any' ) ) ) {
                $args[] = 'inherit';
            }

            return $args;
        }

        public static function filter_settings_args_limit( $args ) {
            $sc_params = PT_CV_Functions::get_global_variable( 'shortcode_params' );
            if ( !empty( $sc_params[ 'limit' ] ) ) {
                $args = intval( $sc_params[ 'limit' ] );
            }

            return $args;
        }

        /**
         * Filter offset for pagination
         *
         * @param int $offset The offset value
         */
        public static function filter_settings_args_offset( $offset ) {
            $view_settings = PT_CV_Functions::get_global_variable( 'view_settings' );
            $offset_option = self::get_offset_setting( $view_settings );
            $offset        += $offset_option;

            return $offset;
        }

        /**
         * Filter thumbnail output
         *
         * @param string $args  The dimensions (sizes) of thumbnail
         * @param array  $fargs The settings of this field
         *
         * @return array
         */
        public static function filter_field_thumbnail_dimensions( $args, $fargs ) {
            $size_to_get = null;

            if ( $fargs[ 'size' ] === PT_CV_PREFIX . 'custom' ) {
                $args = array( (int) $fargs[ 'size-custom-width' ], (int) $fargs[ 'size-custom-height' ] );

                if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-thumbnail-resize' ) !== 'soft' ) {
                    PT_CV_Functions::set_global_variable( 'hard_resize', true );
                } else {
                    $size_to_get = apply_filters( PT_CV_PREFIX_ . 'existing_size_for_soft_resize', 'full' );
                }
            }

            $exact_size = $args;
            if ( !PT_CV_Functions::get_global_variable( 'image_sizes' ) ) {
                // Get size from name: thumbnail, medium, large ...
                if ( count( $args ) == 1 ) {
                    $exact_size = PT_CV_Functions_Pro::get_dimensions_of_size( $args[ 0 ] );
                    $exact_size = array_values( $exact_size );
                }

                PT_CV_Functions::set_global_variable( 'image_sizes', $exact_size );
            }

            if ( PT_CV_Functions::get_global_variable( 'soft_resize' ) === null ) {
                if ( !empty( $exact_size[ 0 ] ) && !empty( $exact_size[ 1 ] ) ) {
                    $soft = false;

                    if ( !in_array( $fargs[ 'size' ], array( 'full', PT_CV_PREFIX . 'custom' ) ) && PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-thumbnail-same-size' ) ) {
                        $soft = true;
                    } else if ( $size_to_get ) {
                        $soft = true;
                    }

                    if ( $soft ) {
                        PT_CV_Functions::set_global_variable( 'soft_resize', true );
                        PT_CV_Functions::set_global_variable( 'hard_resize', false );
                    }
                }
            }

            return $size_to_get ? $size_to_get : $args;
        }

        /**
         * Resize featured image
         *
         * @param type $args
         * @param type $post_id
         * @param type $dimensions
         * @return type
         */
        public static function filter_field_thumbnail_image( $args, $post, $dimensions, $fargs ) {
            if ( PT_CV_Functions::get_global_variable( 'hard_resize' ) ) {
                $attachment_id = get_post_thumbnail_id( $post->ID );
                if ( $attachment_id ) {
                    self::resize_image_from_img_tag( $args, $attachment_id, $dimensions );
                }
            }

            return $args;
        }

        // Resize image from full img tag
        public static function resize_image_from_img_tag( &$args, $attachment_id, $dimensions ) {
            $image = wp_get_attachment_image_src( $attachment_id, $dimensions );
            if ( !empty( $image[ 0 ] ) ) {
                $resized_img = PT_CV_Functions_Pro::resize_img_by_url( $image[ 0 ], !empty( $dimensions[ 0 ] ) ? $dimensions[ 0 ] : null, !empty( $dimensions[ 1 ] ) ? $dimensions[ 1 ] : null );
                $prefix      = PT_CV_Functions::get_global_variable( 'do-lazy-load' ) ? 'data-cvpsrc="' : '';

                if ( $resized_img ) {
                    $args = preg_replace( '/width="[0-9]+"/', !empty( $dimensions[ 0 ] ) ? sprintf( 'width="%s"', $dimensions[ 0 ] ) : '', $args );
                    $args = preg_replace( '/height="[0-9]+"/', !empty( $dimensions[ 1 ] ) ? sprintf( 'height="%s"', $dimensions[ 1 ] ) : '', $args );
                    $args = preg_replace( '/' . $prefix . 'http[^\"]+/', $prefix . $resized_img, $args );
                }
            }
        }

        /**
         * Force replace featured image by image/audio/video in post content
         * @param boolean $args
         * @return boolean
         */
        public static function filter_force_replace_thumbnail( $args ) {
            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-thumbnail-role' ) ) {
                $args = true;
            }

            return $args;
        }

        /**
         * Filter thumbnail output when no thumbnail found
         *
         * @param string $args       HTML output of thumbnail field
         * @param object $post       The post object
         * @param array  $dimensions The dimensions of thumbnail
         * @param array  $gargs      The settings of get_the_post_thumbnail function
         *
         * @return array
         */
        public static function filter_field_thumbnail_not_found( $args, $post, $dimensions, $gargs ) {
            $dimensions = PT_CV_Functions::get_global_variable( 'image_sizes' );

            $dimensions_others = PT_CV_Functions::get_global_variable( 'image_sizes_others' );
            if ( $dimensions_others ) {
                $dimensions = $dimensions_others;
            }

            $dimension_ready = $dimensions && !empty( $dimensions[ 0 ] ) && !empty( $dimensions[ 1 ] );

            // Post type = Attachment
            if ( self::_is_attachment( $post ) ) {
                $attachment = wp_get_attachment_image( $post->ID, $dimension_ready ? $dimensions : 'full', true, $gargs );
                if ( $attachment ) {
					if ( PT_CV_Functions::get_global_variable( 'hard_resize' ) ) {
						self::resize_image_from_img_tag( $attachment, $post->ID, $dimensions );
					}
                    $args = apply_filters( PT_CV_PREFIX_ . 'attachment_thumbnail', $attachment, $post, $dimensions );
                    return $args;
                }
            }

            // Get image/audio/video from post content
            $original_html = $args;
            $found_image   = $found_video   = '';
            $display_what  = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-thumbnail-auto', null, 'image' );

            if ( $display_what === 'none' ) {
                $args = '';
                return $args;
            }

            $content = apply_filters( PT_CV_PREFIX_ . 'field_content_excerpt', $post->post_content, array(), $post );

            // Get image
            $first_img = self::get_inside_image( $post, $dimensions, $content );
            if ( !empty( $first_img ) ) {
                $width = $dimension_ready ? esc_attr( $dimensions[ 0 ] ) : '';
                $attr  = array(
                    'src'   => $first_img,
                    'class' => $gargs[ 'class' ] . ' cvp-substitute',
                    'alt'   => !empty( $post->cvp_img_alt ) ? esc_attr( $post->cvp_img_alt ) : esc_attr( $post->post_title ),
                    'title' => !empty( $post->cvp_img_title ) ? esc_attr( $post->cvp_img_title ) : '',
                );

                $found_image = PT_CV_Html_Pro::image_output( $width, 0, $attr );
            }

            // Get video
            $found_video = self::get_embed_video( $post, $dimensions, $content );

            switch ( $display_what ) {
                case 'video-audio':
                    $args = $found_video ? $found_video : apply_filters( PT_CV_PREFIX_ . 'video_audio_alternative', $found_image );
                    break;
                case 'image':
                case 'image-ctf':
                    $args = $found_image ? $found_image : apply_filters( PT_CV_PREFIX_ . 'image_alternative', $found_video );
                    break;
            }

            if ( empty( $args ) ) {
                if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-thumbnail-role' ) && $original_html ) {
                    // Use featured image
                    $args = $original_html;
                } else {
                    // Use default image
                    if ( !PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-thumbnail-nodefault' ) ) {
                        $width  = $dimension_ready ? intval( $dimensions[ 0 ] ) : '';
                        $height = $dimension_ready ? intval( $dimensions[ 1 ] ) : '';

                        $default_img = apply_filters( PT_CV_PREFIX_ . 'default_image', plugins_url( 'public/assets/images/default_image.png', PT_CV_FILE_PRO ) );

                        // Hard resize default image
                        if ( PT_CV_Functions::get_global_variable( 'hard_resize' ) ) {
                            $uploads = wp_upload_dir();

                            $dirname = 'content-views';
                            if ( !is_dir( $uploads[ 'basedir' ] . "/$dirname" ) ) {
                                wp_mkdir_p( $uploads[ 'basedir' ] . "/$dirname" );
                            }

                            $filename = $dirname . '/cvp_default_image.png';
                            $new_file = $uploads[ 'basedir' ] . "/$filename";
                            if ( !file_exists( $new_file ) ) {
                                // Use large image to serve all cases
                                @copy( plugin_dir_path( PT_CV_FILE_PRO ) . 'public/assets/images/default_image_large.png', $new_file );
                            }

                            // Ensure that new file really exists
                            if ( file_exists( $new_file ) ) {
                                $default_img = PT_CV_Functions_Pro::resize_image_by_url( $uploads[ 'baseurl' ] . "/$filename", $dimensions );
                            }
                        }

                        $attr = array(
                            'style' => $height ? "max-height: {$height}px;" : '',
                            'src'   => $default_img,
                            'class' => $gargs[ 'class' ] . ' not-found',
                            'alt'   => apply_filters( PT_CV_PREFIX_ . 'alt_for_image', $post->post_title ),
                        );

                        $args = PT_CV_Html_Pro::image_output( $width, $height, $attr );
                    }
                }
            }

            return $args;
        }

        /**
         * Get first image in post content
         *
         * @param object $post
         * @param array $dimensions
         * @param string $content
         * @return string
         */
        public static function get_inside_image( $post, $dimensions, $content ) {
            if ( isset( $post->cvp_first_image ) ) {
                return $post->cvp_first_image;
            }

            $img     = '';
            $matches = array();

            if ( preg_match( '/\[gallery[^\]]+\]/', $content ) ) {
                // Use this filter instead of do_shortcode, to help 'cvp_start_gallery_shortcode'
                $content = apply_filters( 'the_content', $content );
            }

            preg_match( '/<img[^>]+>/i', $content, $matches );
            if ( !empty( $matches[ 0 ] ) && function_exists( 'simplexml_load_string' ) ) {
				if ( $img_attrs = @simplexml_load_string( $matches[ 0 ] ) ) {
                    $img_attrs = (array) $img_attrs;
                    if ( !empty( $img_attrs[ '@attributes' ][ 'src' ] ) ) {
                        $img = $img_attrs[ '@attributes' ][ 'src' ];
                    }
                    if ( !empty( $img_attrs[ '@attributes' ][ 'alt' ] ) ) {
                        $post->cvp_img_alt = $img_attrs[ '@attributes' ][ 'alt' ];
                    }
                    if ( !empty( $img_attrs[ '@attributes' ][ 'title' ] ) ) {
                        $post->cvp_img_title = $img_attrs[ '@attributes' ][ 'title' ];
                    }
                }
            }

            if ( !$img ) {
                // Formal image
                preg_match_all( '/src=[\'"]([^\'"]+(\.(gif|png|jp(e|g|eg)|bmp|ico|webp|jxr|svg))[^\'"]*)[\'"]/i', $content, $matches );

                // Informal image
                if ( empty( $matches[ 1 ][ 0 ] ) ) {
                    preg_match_all( '/(?:<img[^>]*)src=[\'"]([^\'"]+)[\'"]/i', $content, $matches );
                }

                $img = isset( $matches[ 1 ][ 0 ] ) ? $matches[ 1 ][ 0 ] : '';
            }

            if ( $img ) {
                $img = PT_CV_Functions_Pro::resize_image_by_url( $img, $dimensions );
            }

            return $post->cvp_first_image = apply_filters( PT_CV_PREFIX_ . 'field_inside_image', $img, $matches, $content );
        }

        /**
         * Get embed video from post content
         *
         * @param object $post
         * @param string $dimensions
         * @return string
         */
        public static function get_embed_video( $post, $dimensions, $content ) {
            // Get Media URL: Youtube, Vimeo, Dailymotion, Soundcloud
            $media_url = self::extract_video_url( $content, $post );

            return self::embed_video( $media_url, $dimensions );
        }

        /**
         * Extract Video URL from content
         *
         * @param string $content
         * @param object $post
         * @return string
         */
        public static function extract_video_url( $content, $post ) {
            if ( !empty( $post->cvp_first_video ) ) {
                return $post->cvp_first_video;
            }

            $media_url = '';
            $matches   = array();
            preg_match_all( '|https?://[^\s"\']+|im', $content, $matches );

            // Add custom filter, to deal with URL, like httpv://...
            $matches = apply_filters( PT_CV_PREFIX_ . 'custom_media_thumbnail', $matches, $content );

            // Get URL to embed
            if ( isset( $matches[ 0 ] ) ) {
                foreach ( $matches[ 0 ] as $url ) {
                    // If is one of: Youtube, Vimeo, Dailymotion, Soundcloud
                    if ( preg_match( '(youtube\.com|youtu\.be|vimeo\.com|dailymotion\.com|soundcloud\.com|videopress\.com)', $url ) ) {
                        $media_url = $url;
                        break;
                    }
                }
            }

            if ( !empty( $media_url ) ) {
                $media_url = esc_url( trim( $media_url, '.' ) );

                // Youtube URL: make it embeddable
                if ( preg_match( '(youtube\.com|youtu\.be)', $media_url ) ) {
                    if ( strpos( $media_url, '/embed/videoseries' ) === false ) {
                        preg_match( '/^.*(youtu.be\/|v\/|e\/|u\/\w+\/|embed\/|v=)([^#\&\?]*).*/', $media_url, $matches );
                        if ( !empty( $matches[ 2 ] ) ) {
                            $media_url = 'http' . (is_ssl() ? 's' : '') . '://www.youtube.com/watch?v=' . $matches[ 2 ];
                        }
                    } else {
                        $media_url = str_replace( '/embed/videoseries', '/playlist', $media_url );
                    }
                }
            }

            return $post->cvp_first_video = $media_url;
        }

        /**
         * Return embed output from video url
         *
         * @param string $media_url
         * @param array $dimensions
         * @return string
         */
        public static function embed_video( $media_url, $dimensions ) {
            $args = '';

            // Embed url
            if ( !empty( $media_url ) ) {
                $args = wp_oembed_get( $media_url, !empty( $dimensions[ 0 ] ) ? array( 'width' => $dimensions[ 0 ] ) : array() );

                if ( PT_CV_Functions::get_global_variable( 'do-lazy-load' ) ) {
                    $iframe = str_replace( 'src=', 'data-cvpsrc=', $args );

                    $image = '';
                    global $cvp_oembed_data;
                    if ( is_object( $cvp_oembed_data ) && isset( $cvp_oembed_data->thumbnail_url, $cvp_oembed_data->title ) ) {
                        $width = !empty( $dimensions[ 0 ] ) ? intval( $dimensions[ 0 ] ) : '';
                        $attr  = array(
                            'src'   => $cvp_oembed_data->thumbnail_url,
                            'class' => '',
                            'alt'   => $cvp_oembed_data->title,
                        );

                        $play  = '<span class="cvp-play"></span>';
                        $image = $play . PT_CV_Html_Pro::image_output( $width, 0, $attr );

                        $cvp_oembed_data = null;
                    }

                    $args = $image . $iframe;
                }
            }

            return $args;
        }

        /**
         * Filter class of pagination button
         *
         * @param string $args          HTML output of thumbnail field
         * @param string $max_num_pages The total of pages
         * @param string $session_id    The session id of current view
         *
         * @return string
         */
        public static function filter_btn_more_html( $args, $max_num_pages, $session_id ) {
            $current_page = (int) PT_CV_Functions::get_global_variable( 'current_page' );
            if ( $current_page >= $max_num_pages ) {
                return $args;
            }

            global $cv_unique_id;

            $dargs            = PT_CV_Functions::get_global_variable( 'dargs' );
            $dargs_pagination = $dargs[ 'pagination-settings' ];

            // Get class of more button
            $more_class = apply_filters( PT_CV_PREFIX_ . 'btn_more_class', PT_CV_PREFIX . 'more' . ' ' . 'btn btn-primary btn-sm' );

            // Get text of more button
            $more_text = !empty( $dargs_pagination[ 'loadmore-text' ] ) ? trim( $dargs_pagination[ 'loadmore-text' ] ) : __( 'More', 'content-views-pro' );

            // Get next page
            $next_page = $current_page + 1;

            $args = sprintf(
            '<button class="%s" data-totalpages="%s" data-nextpages="%s" data-sid="%s" data-unid="%s">%s <span class="caret"></span></button>', esc_attr( $more_class ), esc_attr( $max_num_pages ), esc_attr( $next_page ), esc_attr( $session_id ), esc_attr( $cv_unique_id ), esc_html( $more_text )
            );

            // Convert button to anchor link to next page for SEO
            if ( method_exists( 'PT_CV_Functions', 'get_pagination_url' ) ) {
				$next_link	 = PT_CV_Functions::get_pagination_url( $next_page );
				$link		 = is_admin() ? '' : $next_link;
				$args		 = str_replace( array( '<button', '</button>' ), array( "<a href='$link' onclick='event.preventDefault()'", '</a>' ), $args );
			}

            return $args;
        }

        /**
         * Filter class for pagination
         *
         * @param string $args The HTML output of pagination
         */
        public static function filter_pagination_class( $args ) {
            $dargs            = PT_CV_Functions::get_global_variable( 'dargs' );
            $dargs_pagination = $dargs[ 'pagination-settings' ];
            $alignment        = isset( $dargs_pagination[ 'alignment' ] ) ? $dargs_pagination[ 'alignment' ] : 'left';
            $args             = sprintf( 'text-%s', esc_attr( $alignment ) );

            return $args;
        }

        public static function filter_field_href_class( $args, $oargs ) {
            if ( !isset( $oargs[ 'lightbox-enable-navigation' ] ) ) {
                $args[] = 'cvplbd';
            }

            if ( !empty( $args[ 1 ] ) ) {
                if ( strpos( $args[ 1 ], PT_CV_PREFIX . 'href-thumbnail' ) !== false ) {
                    if ( PT_CV_Functions::get_global_variable( 'do-lazy-load' ) ) {
                        $args[] = 'cvp-lazy-container';

                        global $post;
                        if ( !empty( $post->cvp_first_video ) ) {
                            $args[] = 'cvp-block';
                        }
                    }

                    if ( PT_CV_Functions::get_global_variable( 'soft_resize' ) ) {
                        $args[] = apply_filters( PT_CV_PREFIX_ . 'responsive_image_class', 'cvp-responsive-image' );
                        $args[] = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-thumbnail-style' );
                    }
                }
            }

            return $args;
        }

        /**
         * Filter class for <a> tag
         *
         * @param array  $custom_attr Custom attributes
         * @param string $open_in     Open in attribute
         * @param array  $oargs       The array of Other settings
         */
        public static function filter_field_href_attrs( $custom_attr, $open_in, $oargs = array() ) {
            // Open in
            $arr = array( PT_CV_PREFIX . 'window' => array( '600', '400' ), PT_CV_PREFIX . 'lightbox' => array( '75', '75' ) );
            if ( in_array( $open_in, array_keys( $arr ) ) ) {
                $open_type      = str_replace( PT_CV_PREFIX, '', $open_in );
                $width          = !empty( $oargs[ "$open_type-size-width" ] ) ? $oargs[ "$open_type-size-width" ] : $arr[ $open_in ][ 0 ];
                $height         = !empty( $oargs[ "$open_type-size-height" ] ) ? $oargs[ "$open_type-size-height" ] : $arr[ $open_in ][ 1 ];
                $custom_attr [] = sprintf( 'data-width="%s"', esc_attr( $width ) );
                $custom_attr [] = sprintf( 'data-height="%s"', esc_attr( $height ) );
                if ( isset( $oargs[ "$open_type-content-selector" ] ) ) {
                    $custom_attr[] = sprintf( 'data-content-selector="%s"', esc_attr( $oargs[ "$open_type-content-selector" ] ) );
                }
            }

            // Nofollow
            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'link-follow' ) ) {
                $custom_attr[] = 'rel="nofollow"';
            }

            // Background image
            if ( PT_CV_Functions::get_global_variable( 'soft_resize' ) && !in_array( PT_CV_Functions::get_global_variable( 'view_type' ), array( 'scrollable' ) ) ) {
                $dimensions = PT_CV_Functions::get_global_variable( 'image_sizes_others' );
                if ( !$dimensions ) {
                    $dimensions = PT_CV_Functions::get_global_variable( 'image_sizes' );
                }
                if ( isset( $dimensions[ 0 ], $dimensions[ 1 ] ) ) {
                    $custom_attr [] = sprintf( 'data-iw="%s"', esc_attr( $dimensions[ 0 ] ) );
                    $custom_attr [] = sprintf( 'data-ih="%s"', esc_attr( $dimensions[ 1 ] ) );
                }
            }

            return $custom_attr;
        }

        /**
         * Filter link of post
         * @param string $args
         * @param object $post
         * @return string
         */
        public static function filter_field_href( $args, $post ) {
            $dargs          = PT_CV_Functions::get_global_variable( 'dargs' );
            $other_settings = $dargs[ 'other-settings' ];

            if ( isset( $other_settings[ 'open-in' ] ) ) {
                if ( $other_settings[ 'open-in' ] === PT_CV_PREFIX . 'none' ) {
                    $args = 'javascript:void(0)';
                } else if ( $other_settings[ 'open-in' ] === PT_CV_PREFIX . 'lightbox-image' ) {
                    if ( !empty( $post->cvp_first_image ) ) {
                        return $post->cvp_first_image;
                    }

                    if ( !empty( $post->cvp_first_video ) ) {
                        return $post->cvp_first_video;
                    }
					
					if ( PT_CV_Functions::get_global_variable( 'display_what' ) === 'term_as_output' ) {
						return $args;
					}

                    $full_image = '';
                    $size       = apply_filters( PT_CV_PREFIX_ . 'media_file_size', !isset( $other_settings[ 'lightbox-full-image' ] ) ? array( 840, 560 ) : 'full' );

                    if ( !self::_is_attachment( $post ) ) {
                        if ( has_post_thumbnail( $post->ID ) ) {
                            $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size );
                            if ( $large_image_url ) {
                                $full_image = $large_image_url[ 0 ];
                            }
                        } else {
                            $content = apply_filters( PT_CV_PREFIX_ . 'field_content_excerpt', $post->post_content, array(), $post );

                            $full_image = self::get_inside_image( $post, 'full', $content );

                            if ( !$full_image ) {
                                $full_image = self::extract_video_url( $content, $post );
                            }
                        }
                    } else {
                        // Get URL of any attachment (image, video, pdf)
                        $media = wp_get_attachment_url( $post->ID );
                        if ( $media ) {
                            $full_image = $media;
                        }
                    }

                    if ( $full_image ) {
                        $args = $full_image;
                    }
                }
            }

            return $args;
        }

        /**
         * Filter HTML output of author
         *
         * @param string $args The HTML output of author
         * @param object $post The post object
         */
        public static function filter_field_meta_author_html( $args, $post ) {
            if ( PT_CV_Html_ViewType_Pro::ancient_timeline() || in_array( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'meta-fields-author-settings' ), array( 'author_avatar', 'avatar_name' ) ) ) {
                // Sets up global post data
                setup_postdata( $post );

                $author_id = get_the_author_meta( 'ID' );
                $avatar    = get_avatar( $author_id, apply_filters( PT_CV_PREFIX_ . 'author_avatar_size', 40 ) );
                if ( $avatar ) {
                    $url  = esc_url( get_author_posts_url( $author_id ) );
                    $name = get_the_author();
                    if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'meta-fields-author-settings' ) === 'avatar_name' ) {
                        $author_class = apply_filters( PT_CV_PREFIX_ . 'field_meta_class', 'author', 'author' );
                        $args         = sprintf( '<span class="%s"><a href="%s" rel="author">%s</a></span>', esc_attr( $author_class ), $url, $avatar . "<span>$name</span>" );
                    } else {
                        $args = sprintf( '<a href="%s" title="%s %s">%s</a>', $url, __( 'Posted by', 'content-views-pro' ), $name, $avatar );
                    }
                }
            }

            return $args;
        }

        /**
         * Merge fields, or let them as seperate items in array
         *
         * @param bool $args Whether or not to merge
         */
        public static function filter_field_meta_merge_fields( $args ) {
            if ( PT_CV_Html_ViewType_Pro::ancient_timeline() && !PT_CV_Functions_Pro::animate_activated_content_hover() ) {
                $args = false;
            }

            return $args;
        }

        /**
         * Remove seperator between meta fields
         *
         * @param string $args The seperator between meta fields
         */
        public static function filter_field_meta_seperator( $args ) {
            $dargs = PT_CV_Functions::get_global_variable( 'dargs' );

            if ( isset( $dargs[ 'field-settings' ][ 'meta-fields' ][ 'taxonomy-use-icons' ] ) || isset( $dargs[ 'field-settings' ][ 'meta-fields' ][ 'hide-slash' ] ) ) {
                $args = '';
            }

            return $args;
        }

        /**
         * Modify html output of meta fields
         * @param array $args
         * @return array
         */
        public static function filter_meta_field_html( $args ) {
            $special_field = PT_CV_Functions::get_global_variable( 'special-field' );
            if ( $special_field && isset( $args[ $special_field ] ) && PT_CV_Functions_Pro::check_dependences( 'special-field' ) ) {
                PT_CV_Functions::set_global_variable( 'special-field-html', $args[ $special_field ] );

                // Remove special field from this list, to display it in another place
                unset( $args[ $special_field ] );
            }

            return $args;
        }

        /**
         * Remove prefix text of meta fields
         *
         * @param string $args       The current prefix text of meta fields
         * @param string $meta_field The meta field name
         *
         * @return string
         */
        public static function filter_field_meta_prefix_text( $args, $meta_field ) {
            $dargs = PT_CV_Functions::get_global_variable( 'dargs' );

            // Use Icon
            if ( !empty( $dargs[ 'field-settings' ][ 'meta-fields' ][ 'taxonomy-use-icons' ] ) ) {
                $class = '';

                switch ( $meta_field ) {
                    case 'author':
                        $class = 'user';
                        break;
                    case 'date':
                        $class = 'calendar';
                        break;
                    case 'terms':
                        $class = 'folder-open';
                        break;
                    case 'comment':
                        $class = 'comment';
                        break;
                }

                $args = sprintf( '<span class="glyphicon glyphicon-%s"></span>', $class );
            }

            return $args;
        }

        /**
         * Filter datetime output
         *
         * @param string $args
         * @return string
         */
        public static function filter_field_meta_date_final( $args, $unix_time ) {
            $dargs = PT_CV_Functions::get_global_variable( 'dargs' );
            if ( isset( $dargs[ 'field-settings' ][ 'meta-fields' ][ 'date-format-setting' ] ) ) {
                $format = $dargs[ 'field-settings' ][ 'meta-fields' ][ 'date-format-setting' ];
                if ( $format === 'time_ago' ) {
                    $args = PT_CV_Functions_Pro::date_human( $unix_time );
                } elseif ( $format === 'custom_format' ) {
                    global $post;
                    $args = mysql2date( $dargs[ 'field-settings' ][ 'meta-fields' ][ 'date-format-custom' ], $post->post_date );
                }
            }

            return $args;
        }

        /**
         * Filter HTML output of a field (thumbnail, title, content, meta fields, Price)
         *
         * @param string $html   The output HTML
         * @param string $field_ The type of field
         * @param object $post   The post object
         */
        public static function filter_field_item_html( $html, $field_, $post ) {
            $post_type = get_post_type( $post );

            // Special field
            $special_html = PT_CV_Functions::get_global_variable( 'special-field-html' );

            switch ( $field_ ) {
                /**
                 * Show special field
                 * @since 3.4 : special field is Term
                 */
                case 'special-field':
                    if ( $special_html ) {
                        $special_position = apply_filters( PT_CV_PREFIX_ . 'meta_field_special_position', true );
                        $_class           = PT_CV_PREFIX . ( $special_position ? 'specialp' : 'anotherp');
                        $html             = apply_filters( PT_CV_PREFIX_ . 'meta_field_special_html', sprintf( '<div class="%s">%s</div>', $_class, $special_html ) );
                        PT_CV_Functions::set_global_variable( 'special-field-html', null );
                    }

                    break;

                // Show Format Icon
                case 'format-icon':
                    if ( $post_type === 'post' ) {
                        $format = get_post_format( $post->ID );
                        if ( !$format ) {
                            $format = 'standard';
                        }

                        $class = PT_CV_PREFIX . 'pficon';
                        $class .= $special_html ? ' ' . PT_CV_PREFIX . 'wspecialp' : '';
                        $html  = sprintf( '<span class="dashicons dashicons-format-%s %s"></span>', esc_attr( $format ), $class );

                        // Add filter to modify icon
						$html = apply_filters( PT_CV_PREFIX_ . 'change_format_icon', $html, $format, $post );
					}

                    break;

                // Show Price
                case 'price':
                    if ( $post_type === 'product' ) {
                        $html = do_shortcode( sprintf( '[add_to_cart id="%s" style=""]', $post->ID ) );
                    }

                    break;

                // Show Sale badge
                case 'woosale':
                    if ( $post_type === 'product' && function_exists( 'wc_get_product' ) ) {
                        $product = wc_get_product( $post->ID );
                        if ( $product->is_on_sale() ) {
                            $html = '<span class="woocommerce-onsale">' . apply_filters( PT_CV_PREFIX_ . 'woocommerce_sale_word', __( 'Sale', 'content-views-pro' ) ) . '</span>';
                        }
                    }

                    break;

                // Show EDD Purchase Link
                case 'edd-purchase':
                    if ( shortcode_exists( 'purchase_link' ) ) {
                        ob_start();
                        echo do_shortcode( '[purchase_link]' );
                        $html = ob_get_clean();
                    }

                    break;

                // Show Custom Fields
                case 'custom-fields':
                    $html = cvp_ctf_html( $post );
                    break;
            }

            return $html;
        }

        /**
         * Enable/Disable Read more button
         *
         * @param string $args  The readmore text
         * @param array  $fargs The settings of Content
         */
        public static function filter_field_content_readmore_enable( $args, $fargs ) {
            // not empty => true => show
            $args = !empty( $fargs[ 'readmore' ] );

            return $args;
        }

        /**
         * Filter Read more class
         *
         * @param string $args  Current class
         * @param array  $fargs The settings of Content
         */
        public static function filter_field_content_readmore_class( $args, $fargs ) {
            if ( !empty( $fargs[ 'content' ][ 'readmore-textlink' ] ) ) {
                $args = PT_CV_PREFIX . 'textlink';
            } else {
                if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'font-text-align-readmore' ) === 'center' ) {
                    $args .= ' cvprmct ';
                }
            }

            return $args;
        }

        /**
         * Filter Read more seperate tag
         *
         * @param string $args  Current class
         * @param array  $fargs The settings of Content
         */
        public static function filter_field_content_readmore_seperated( $args, $fargs ) {
            if ( !empty( $fargs[ 'content' ][ 'readmore-textlink' ] ) ) {
                $args = ' ';
            }

            return $args;
        }

        /**
         * Filter post title
         *
         * @param string $args  The excerpt output
         * @param array  $fargs The field display settings
         * @param int   $post_id Post ID
         *
         * @return string
         */
        public static function filter_field_title_result( $args, $fargs, $post_id ) {
            // Strip Title
            if ( isset( $fargs[ 'title' ] ) ) {
                if ( !empty( $fargs[ 'title' ][ 'length' ] ) ) {
                    $desired_length = intval( $fargs[ 'title' ][ 'length' ] );
                    // fix untrackable 500 error in hosting which doesn't enable/install relative module
                    $this_length    = function_exists( 'mb_strlen' ) ? mb_strlen( $args, CVP_ENCODING ) : strlen( $args );
                    if ( $desired_length < $this_length ) {
                        $sub_title = function_exists( 'mb_substr' ) ? mb_substr( $args, 0, $desired_length, CVP_ENCODING ) : substr( $args, 0, $desired_length );
                        $args      = $sub_title . '...';
                    }
                }
            }

            return $args;
        }

        public static function filter_tag_to_remove( $args ) {
            $var = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-excerpt-remove-tag' );
            if ( $var ) {
                $var  = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-excerpt-tag-to-remove' );
                $tags = explode( ',', sanitize_text_field( $var ) );
                $args = array_merge( $args, array_filter( $tags ) );
            }

            return $args;
        }

        /**
         * Allow all HTML tags in excerpt
         * @since 4.6.0
         * @param type $args
         * @return type
         */
        public static function filter_strip_tags( $args ) {
            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-excerpt-allow_html' ) === 'all-tags' ) {
                $args = false;
            }

            return $args;
        }

        /**
         * Filter post excerpt
         *
         * @param string $args  The excerpt output
         * @param type   $fargs The field display settings
         * @param type   $post  The post object
         *
         * @return string
         */
        public static function filter_field_content_excerpt( $args, $fargs, $post ) {
            // Prevent recursive call
            if ( empty( $fargs ) ) {
                return $args;
            }

            // Get manual excerpt
            if ( !empty( $fargs[ 'content' ][ 'manual' ] ) && !empty( $post->post_excerpt ) ) {
                $args = $post->post_excerpt;
                if ( $fargs[ 'content' ][ 'manual' ] === 'origin' ) {
                    $GLOBALS[ 'cv_excerpt_type' ] = 'manual';
                }
            }

            // Apply filters, do shortcodes
            if ( !empty( $fargs[ 'content' ][ 'enable_filter' ] ) ) {
                $args = apply_filters( 'the_content', $args );
            }

            // Final filter
            $args = apply_filters( PT_CV_PREFIX_ . 'field_manual_excerpt', $args, $fargs, $post );

            return $args;
        }

        /**
         * Append ... to Excerpt or not
         *
         * @param array $args
         */
        public static function filter_field_excerpt_dots( $args, $fargs ) {
            $args = empty( $fargs[ 'content' ][ 'hide_dots' ] );
            return $args;
        }

        /**
         * Modify assets folder of View type
         *
         * @param string $args      The path to assets folder of view type
         * @param string $view_type The view type
         */
        public static function filter_view_type_asset( $args, $view_type ) {
            $path = PT_CV_VIEW_TYPE_OUTPUT_PRO . $view_type;

            if ( is_dir( $path ) ) {
                $args = $path;
            }

            return $args;
        }

        /**
         * Modify the list of fields to get
         *
         * @param string $args      Array of fields
         * @param string $post_idx  Index of current post
         */
        public static function filter_dargs_others( $args, $post_idx ) {
            $view_type = PT_CV_Functions::get_global_variable( 'view_type' );

            // Simplify fields for other posts of "One and others" layout
            if ( $view_type === 'one_others' && $post_idx > 0 ) {
                $args[ 'layout-format' ] = '2-col';

                $show_fields    = $fields_to_show = isset( $args[ 'view-type-settings' ][ 'show-fields' ] ) ? $args[ 'view-type-settings' ][ 'show-fields' ] : array( 'thumbnail', 'title', 'meta-fields' );
                foreach ( $show_fields as $idx => $value ) {
                    foreach ( array( 'content', 'meta-fields' ) as $field ) {
                        if ( strpos( $value, $field ) !== false ) {
                            $show_fields[ $idx ] = $field;
                        }
                    }
                }
                $args[ 'fields' ] = apply_filters( PT_CV_PREFIX_ . 'one_others_fields', array_unique( $show_fields ) );

                if ( in_array( 'thumbnail', $fields_to_show ) ) {
                    $thumbnail_width  = !empty( $args[ 'view-type-settings' ][ 'thumbnail-width-others' ] ) ? (int) $args[ 'view-type-settings' ][ 'thumbnail-width-others' ] : 150;
                    $thumbnail_height = !empty( $args[ 'view-type-settings' ][ 'thumbnail-height-others' ] ) ? (int) $args[ 'view-type-settings' ][ 'thumbnail-height-others' ] : null;

                    $args[ 'field-settings' ][ 'thumbnail' ][ 'size' ]               = apply_filters( PT_CV_PREFIX_ . 'one_others_thumbnail_size', PT_CV_PREFIX . 'custom' );
                    $args[ 'field-settings' ][ 'thumbnail' ][ 'size-custom-width' ]  = apply_filters( PT_CV_PREFIX_ . 'one_others_thumbnail_size_width', $thumbnail_width );
                    $args[ 'field-settings' ][ 'thumbnail' ][ 'size-custom-height' ] = apply_filters( PT_CV_PREFIX_ . 'one_others_thumbnail_size_height', $thumbnail_height );

                    // Store this custom size
                    PT_CV_Functions::set_global_variable( 'image_sizes_others', array( $thumbnail_width, $thumbnail_height ) );

                    $args[ 'field-settings' ][ 'thumbnail' ][ 'position' ] = 'left';
                }

                // Excerpt
                if ( in_array( 'content', $fields_to_show ) ) {
                    $args[ 'field-settings' ][ 'content' ][ 'show' ]   = 'excerpt';
                    $args[ 'field-settings' ][ 'content' ][ 'length' ] = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-excerpt-length' );
                    unset( $args[ 'field-settings' ][ 'content' ][ 'readmore' ] );
                }

                if ( in_array( 'full-content', $fields_to_show ) ) {
                    $args[ 'field-settings' ][ 'content' ][ 'show' ] = 'full';
                    unset( $args[ 'field-settings' ][ 'content' ][ 'readmore' ] );
                }

                if ( in_array( 'readmore', $fields_to_show ) ) {
                    $args[ 'field-settings' ][ 'content' ][ 'readmore' ] = 'yes';
                    if ( !in_array( 'content', $fields_to_show ) ) {
                        $args[ 'fields' ][]                                = 'content';
                        $args[ 'field-settings' ][ 'content' ][ 'show' ]   = 'excerpt';
                        $args[ 'field-settings' ][ 'content' ][ 'length' ] = '0';
                    }
                }

                if ( in_array( 'meta-fields', $fields_to_show ) ) {
                    $args[ 'field-settings' ][ 'meta-fields' ][ 'date' ] = 'yes';
                }

                if ( in_array( 'meta-fields-taxonomy', $fields_to_show ) ) {
                    $args[ 'field-settings' ][ 'meta-fields' ][ 'taxonomy' ] = 'yes';
                }

                #ch986
                PT_CV_Functions::set_global_variable( 'soft_resize', true );
            }

            // Show special field
            if ( !empty( $args[ 'field-settings' ][ 'meta-fields' ][ 'taxonomy-special-place' ] ) ) {
                $args[ 'fields' ][] = 'special-field';
                PT_CV_Functions::set_global_variable( 'special-field', 'taxonomy' );
            }

            return $args;
        }

        /**
         * Filter directory of Pro View type
         *
         * @param string $args      The path to main folder of view type
         * @param string $view_type The view type
         *
         * @return string
         */
        public static function filter_view_type_dir( $args, $view_type ) {

            $view_types_pro = array_keys( PT_CV_Values_Pro::view_type_pro() );
            if ( in_array( $view_type, $view_types_pro ) ) {
                $args = PT_CV_VIEW_TYPE_OUTPUT_PRO;
            }

            return $args;
        }

        /**
         * Filter directory of Pro View type
         *
         * @param string $args      The path to main folder of view type
         * @param string $view_type The view type
         *
         * @return string
         */
        public static function filter_view_type_dir_special( $args, $view_type ) {
            if ( ($view_type == 'masonry' ) ) {
                $args = PT_CV_VIEW_TYPE_OUTPUT_PRO . 'pinterest';
            }

            return $args;
        }

        /**
         * Add toggle icon to Scrollable item
         *
         * @param string $args HTML of toggle icon
         *
         * @return string
         */
        public static function filter_scrollable_toggle_icon( $args ) {

            $args = '<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-plus"></i></span>';

            return $args;
        }

        /**
         * Filter interval for Scrollable List
         *
         * @param string $args The interval value
         */
        public static function filter_scrollable_interval( $args ) {
            $dargs = PT_CV_Functions::get_global_variable( 'dargs' );

            $carousel_settings = !empty( $dargs[ 'view-type-settings' ] ) ? $dargs[ 'view-type-settings' ] : array();
            $interval          = isset( $carousel_settings[ 'interval' ] ) ? (int) $carousel_settings[ 'interval' ] : 5;
            $args              = !isset( $carousel_settings[ 'auto-cycle' ] ) ? 'false' : $interval * 1000;

            return $args;
        }

        /**
         * Filter default value of setting options for Scrollable List
         *
         * @param string $args The default value
         */
        public static function filter_scrollable_fields_enable( $args ) {
            $args = 0;
            return $args;
        }

        // Remove the class w-img or wo-img and its CSS
        public static function filter_scrollable_caption_class( $args ) {
            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'scrollable-textbelow' ) ) {
                unset( $args[ 1 ] );
            }

            return $args;
        }

        /**
         * Filter custom data attributes for a page
         *
         * @param string $view_type     The view type
         * @param array  $content_items The items array
         */
        public static function filter_page_attr( $args, $view_type, $content_items ) {
            # Shuffle filter: Show all posts of term on pagination
            if ( PT_CV_Functions::get_global_variable( 'enable_shuffle_filter' ) ) {
                if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'enable-pagination' ) ) {
                    $args .= sprintf( ' data-sfpp="%s"', (int) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'pagination-items-per-page' ) );

                    if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-filter-show-all' ) ) {
                        $args .= ' data-sfshowall="1"';
                    }
                    if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-filter-trigger-pagination' ) ) {
                        $args .= ' data-sftp="1"';
                    }
                }

                if ( $tax_relation = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-relation' ) ) {
                    $args .= sprintf( ' data-sfop="%s"', esc_attr( strtolower( $tax_relation ) ) );
                }
            }

            if ( PT_CV_Functions::get_global_variable( 'view_type' ) === 'grid' && PT_CV_Functions::setting_value( PT_CV_PREFIX . 'grid-same-height' ) ) {
                $args .= ' data-cvct="' . (int) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'resp-tablet-number-columns' ) . '"';
                $args .= ' data-cvcm="' . (int) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'resp-number-columns' ) . '"';
            }

            if ( PT_CV_Functions::get_global_variable( 'collapsible_shuffle' ) ) {
                $args .= ' ' . sprintf( 'id="%s"', PT_CV_Html_Pro::collapsible_parent_id() );
            }

            return $args;
        }

        public static function filter_page_class( $args ) {
            if ( PT_CV_Functions::get_global_variable( 'collapsible_shuffle' ) ) {
                $args .= ' ' . 'panel-group';
            }

            return $args;
        }

        /**
         * Filter elements of Collapsible
         * @since 4.3
         *
         * @param type $args
         * @param type $params
         * @return type
         */
        public static function filter_collapsible_filters( $args, $params ) {
            if ( PT_CV_Functions::get_global_variable( 'collapsible_shuffle' ) ) {
                if ( !empty( $params[ 0 ] ) ) {
                    switch ( $params[ 0 ] ) {
                        case 'random_id':
                            $args = PT_CV_Html_Pro::collapsible_parent_id();
                            break;

                        case 'output':
                            $args = implode( "\n", $params[ 1 ] );
                            break;
                    }
                }
            }

            return $args;
        }

        /**
         * Whether or not to wrap items in a page
         *
         * @param bool $args Wrap or not
         */
        public static function filter_wrap_in_page( $args ) {
            $dargs = PT_CV_Functions::get_global_variable( 'dargs' );

            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'enable-pagination' ) ) {
                if ( $dargs[ 'pagination-settings' ][ 'type' ] === 'ajax' ) {
                    if ( isset( $dargs[ 'pagination-settings' ][ 'style' ] ) && in_array( $dargs[ 'pagination-settings' ][ 'style' ], array( 'loadmore', 'infinite' ) ) ) {
                        // Not wrap only if called by Ajax request. If access URL directly with ?_page=N, must wrap.
                        if ( defined( 'DOING_AJAX' ) && DOING_AJAX && !empty( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'pagination_request' ) {
                            $args = false;
                        }
                    }
                }
            }

            if ( $dargs[ 'view-type' ] === 'timeline' ) {
                $args = false;
            }

            return $args;
        }

        /**
         * Filter wrapper HTML of list of items by view type
         *
         * @param array $content       The output array
         * @param array $content_items The array of Raw HTML output (is not wrapped) of each item
         * @param int   $current_page  The current page
         * @param int   $post_per_page The number of posts per page
         */
        public static function filter_content_items_wrap( $content, $content_items, $current_page, $post_per_page ) {
            $view_type = PT_CV_Functions::get_global_variable( 'view_type' );

            if ( $view_type === 'pinterest' ) {
                $content = PT_CV_Html_ViewType_Pro::pinterest_wrapper( $content_items );
            } elseif ( $view_type === 'masonry' ) {
                $content = PT_CV_Html_ViewType_Pro::masonry_wrapper( $content_items );
            } elseif ( $view_type === 'timeline' ) {
                $content = PT_CV_Html_ViewType_Pro::timeline_wrapper( $content_items, $current_page, $post_per_page );
            } elseif ( $view_type === 'glossary' ) {
                $content = PT_CV_Html_ViewType_Pro::glossary_wrapper( $content_items, $current_page, $post_per_page );
            } elseif ( $view_type === 'one_others' ) {
                $content = PT_CV_Html_ViewType_Pro::one_others_wrapper( $content_items, $current_page, $post_per_page );
            }

            return $content;
        }

        /**
         * Filter display settings value
         *
         * @param array $args The settings array of Fields
         */
        public static function filter_all_display_settings( $args ) {
            $view_settings = PT_CV_Functions::get_global_variable( 'view_settings' );

            $args[ 'view-style' ]                   = array();
            $args[ 'view-style' ][ 'font' ]         = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'font-' );
            $args[ 'view-style' ][ 'margin' ]       = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'margin-value-' );
            $args[ 'view-style' ][ 'item-margin' ]  = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'item-margin-value-' );
            $args[ 'view-style' ][ 'item-padding' ] = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'item-padding-value-' );
            $args[ 'view-style' ][ 'others' ]       = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'style-' );

            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-thumbnail-style', $view_settings ) === 'img-rounded' ) {
                $args[ 'view-style' ][ 'border-radius' ] = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'thumbnail-border-radius', $view_settings );
            }

            $args[ 'taxonomy-filter' ] = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy', $view_settings );

            if ( PT_CV_Functions::get_global_variable( 'view_type' ) === 'scrollable' ) {
                // Only do this if has navigation or indicator, otherwise users can't see other posts
                if ( array_key_exists( 'navigation', $args[ 'view-type-settings' ] ) || array_key_exists( 'indicator', $args[ 'view-type-settings' ] ) || array_key_exists( 'auto-cycle', $args[ 'view-type-settings' ] ) ) {
                    if ( PT_CV_Functions_Pro::check_device( 'mobile' ) ) {
                        $mol_col = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'resp-number-columns', $view_settings );
                        if ( !empty( $mol_col ) ) {
                            $args[ 'number-columns' ] = $mol_col;
                        }
                    } elseif ( PT_CV_Functions_Pro::check_device( 'tablet' ) ) {
                        $tab_col = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'resp-tablet-number-columns', $view_settings );
                        if ( !empty( $tab_col ) ) {
                            $args[ 'number-columns' ] = $tab_col;
                        }
                    }
                }
            }

            return $args;
        }

        public static function filter_selected_terms( $terms, $taxonomy ) {
            // Get all IF no terms selected
            $view_settings = PT_CV_Functions::get_global_variable( 'view_settings' );
            if ( empty( $terms ) && PT_CV_Functions_Pro::taxonomy_custom_setting_enable( $view_settings, 'taxonomy-term-info', 'as_output' ) ) {
                $all_terms = array();
                PT_CV_Values::term_of_taxonomy( $taxonomy, $all_terms, array(), 'object' );
                $terms     = array_keys( $all_terms[ $taxonomy ] );
            }
            return $terms;
        }

        /**
         * Order settings args
         *
         * @param array $args
         */
        public static function filter_order_setting( $args ) {
            /**
             * Order by "View count"
             * Backward compatibility with CV < 1.8.9, CVP < 3.9.5
             */
            if ( $args[ 'orderby' ] == 'view_count' ) {
                $args[ 'orderby' ] = '';
                $args[ 'order' ]   = '';
            }

            // Order by "Custom field"
            $metadata_order = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'order-custom-field-' );
            if ( $metadata_order ) {
                if ( !empty( $metadata_order[ 'key' ] ) && is_array( $metadata_order[ 'key' ] ) ) {
                    // Get format of custom date field for sorting, before it is eliminated by following filter
                    self::sort_ctf_date_format( $metadata_order );

                    $metadata_order = apply_filters( PT_CV_PREFIX_ . 'custom_field_order_settings', $metadata_order );

                    $cvp_meta_query_order = $orderby              = array();
                    foreach ( $metadata_order[ 'key' ] as $idx => $field ) {
                        if ( $field ) {
                            $key  = CVP_CTF_ORDER_PREFIX . $field;
                            $type = $metadata_order[ 'type' ][ $idx ];

                            $cvp_meta_query_order[ $key ] = array(
                                'key'     => $field,
                                'compare' => 'EXISTS',
                                'type'    => $type === 'DECIMAL' ? 'DECIMAL(15,5)' : $type,
                            );

                            $orderby[ $key ] = $metadata_order[ 'order' ][ $idx ];
                        }
                    }

                    PT_CV_Functions::set_global_variable( 'meta_query_order', $cvp_meta_query_order );

                    if ( $orderby ) {
                        // If ordered by common field
                        if ( array_filter( $args ) ) {
                            $orderby[ $args[ 'orderby' ] ] = $args[ 'order' ];
                        }

                        /* @since 5.3.4 Append id desc to make the consistent results when there are many posts have same values of custom fields */
                        $orderby[ 'ID' ] = 'DESC';

                        $args = array(
                            'orderby' => $orderby
                        );
                    }
                }
            }

            if ( $args[ 'orderby' ] === 'dragdrop' ) {
                $args[ 'orderby' ] = '';
                $args[ 'order' ]   = '';
            }

            return $args;
        }

        /**
         * Get format of custom date field for sorting
         * @param array $metadata_order
         */
        public static function sort_ctf_date_format( $metadata_order ) {
            $cvp_orderby_dateformat     = $cvp_thousand_commas_fields = array();

            foreach ( $metadata_order[ 'key' ] as $idx => $field ) {
                if ( $field ) {
                    $type = $metadata_order[ 'type' ][ $idx ];
                    // Get date format to modify the MySQL orderby statement
                    if ( in_array( $type, array( 'DATE', 'DATETIME' ) ) ) {
                        $dfm = trim( $metadata_order[ 'date-format' ][ $idx ] );
                        if ( !empty( $dfm ) ) {
                            $cvp_orderby_dateformat[ $idx ] = $dfm;
                        }
                    }

                    if ( $type === 'NUMERIC' ) {
                        $tcm = isset( $metadata_order[ 'thousand-commas' ][ $idx ] ) ? trim( $metadata_order[ 'thousand-commas' ][ $idx ] ) : null;
                        if ( !empty( $tcm ) ) {
                            $cvp_thousand_commas_fields[ $idx ] = $tcm;
                        }
                    }
                }
            }

            PT_CV_Functions::set_global_variable( 'orderby_dateformat', $cvp_orderby_dateformat );
            PT_CV_Functions::set_global_variable( 'thousand_commas_fields', $cvp_thousand_commas_fields );
        }

        /**
         * Validate settings filter
         *
         * @param string $errors The error message
         * @param array  $args  The Query parameters array
         */
        public static function filter_validate_settings( $errors, $args ) {

            $dargs = PT_CV_Functions::get_global_variable( 'dargs' );

            // Prefix string for error message
            $messages = array(
                'field' => array(
                    'select' => __( 'Please select an option in', 'content-views-query-and-display-post-page' ) . ' : ',
                    'text'   => __( 'Please set value in', 'content-views-query-and-display-post-page' ) . ' : ',
                ),
                'tab'   => array(
                    'filter'  => __( 'Filter Settings', 'content-views-query-and-display-post-page' ),
                    'display' => __( 'Display Settings', 'content-views-query-and-display-post-page' ),
                ),
            );

            // View type
            if ( !empty( $dargs[ 'view-type' ] ) ) {
                switch ( $dargs[ 'view-type' ] ) {
                    case 'scrollable':
                        if ( empty( $dargs[ 'number-columns' ] ) ) {
                            $errors[] = $messages[ 'field' ][ 'text' ] . $messages[ 'tab' ][ 'display' ] . ' > ' . __( 'Layout', 'content-views-query-and-display-post-page' ) . ' > ' . __( 'Items per row', 'content-views-query-and-display-post-page' );
                        }
                        if ( empty( $dargs[ 'number-rows' ] ) ) {
                            $errors[] = $messages[ 'field' ][ 'text' ] . $messages[ 'tab' ][ 'display' ] . ' > ' . __( 'Layout', 'content-views-query-and-display-post-page' ) . ' > ' . __( 'Rows per slide', 'content-views-pro' );
                        }
                        break;

                    case 'pinterest':
                        if ( empty( $dargs[ 'number-columns' ] ) ) {
                            $errors[] = $messages[ 'field' ][ 'text' ] . $messages[ 'tab' ][ 'display' ] . ' > ' . __( 'Layout', 'content-views-query-and-display-post-page' ) . ' > ' . __( 'Items per row', 'content-views-query-and-display-post-page' );
                        }
                        break;
                }
            }

            return array_filter( $errors );
        }

        /**
         * Filter array of parameters for Wp_Query
         *
         * @param type $args The Query parameters array
         *
         * @return array $args
         */
        public static function filter_query_parameters( $args ) {
            $view_settings     = PT_CV_Functions::get_global_variable( 'view_settings' );
            $advanced_settings = (array) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'advanced-settings' );
            $content_type      = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'content-type', $view_settings );

            // Quick filter WooCommerce Product (featured/best seller/... products)
            if ( $content_type == 'product' ) {
                $products_list = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'products-list', $view_settings );
                $args          = array_merge( $args, PT_CV_WooCommerce::query_parameters( $products_list ) );
            }

            $args = CVP_Replace_Layout::modify_query_params( $args );

            PT_CV_Functions_Pro::filter_by_date( $args );
            $args = self::filter_by_custom_field( $args );
            $args = self::reuse_view( $args );
            $args = CVP_ADVERT::modify_params( $args );

            /**
             * @deprecated since version 3.9.3
             */
            if ( !empty( $view_settings[ PT_CV_PREFIX . 'include-current' ] ) ) {
                global $post;
                if ( !empty( $post->ID ) ) {
                    if ( !isset( $args[ 'post__in' ] ) ) {
                        $args[ 'post__in' ] = array();
                    }

                    $args[ 'post__in' ][] = $post->ID;
                }
            }

            if ( !empty( $view_settings[ PT_CV_PREFIX . 'exclude-current' ] ) ) {
                $current_post = (int) cvp_get_current_post_across_pagination();
                if ( $current_post ) {
                    if ( !isset( $args[ 'post__not_in' ] ) ) {
                        $args[ 'post__not_in' ] = array();
                    }

                    $args[ 'post__not_in' ][] = $current_post;
                }
            }

            if ( !empty( $view_settings[ PT_CV_PREFIX . 'exclude-pw-protected' ] ) ) {
                $args[ 'has_password' ] = false;
            }

            if ( !empty( $view_settings[ PT_CV_PREFIX . 'exclude-children-posts' ] ) ) {
                $args[ 'post_parent' ] = 0;
            }

            if ( empty( $args[ 'orderby' ] ) && !empty( $args[ 'post__in' ] ) ) {
                $args[ 'orderby' ] = 'post__in';
            }

            if ( in_array( 'order', $advanced_settings ) && !empty( $args[ 'orderby' ] ) ) {
                if ( $args[ 'orderby' ] == 'rand' ) {
                    // Random posts from "Include only"
                    if ( !empty( $args[ 'post__in' ] ) ) {
                        $limit = $args[ 'limit' ];
                        $count = count( $args[ 'post__in' ] );
                        if ( $count > $limit ) {
                            $args[ 'post__in' ] = array_rand( array_flip( $args[ 'post__in' ] ), min( $limit, $count ) );
                        } else {
                            shuffle( $args[ 'post__in' ] );
                        }
                    }

                    // Disable suppress_filters when order randomly & enable pagination
                    $pagination_enable = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'enable-pagination', $view_settings );
                    if ( !empty( $pagination_enable ) ) {
                        $args[ 'suppress_filters' ]   = false;
                        // Bug: duplicated posts when order randonly & pagination
                        $args[ PT_CV_PREFIX . 'orp' ] = 1;
                    }
                } elseif ( $args[ 'orderby' ] == 'title_human' ) {
                    $args[ 'orderby' ]                   = 'post_title';
                    $args[ 'suppress_filters' ]          = false;
                    $args[ PT_CV_PREFIX . 'human_sort' ] = 1;
                }
            }

            $cvp_orderby_dateformat = PT_CV_Functions::get_global_variable( 'orderby_dateformat' );
            if ( !empty( $cvp_orderby_dateformat ) ) {
                $args[ 'suppress_filters' ]            = false;
                $args[ PT_CV_PREFIX . 'ctf_sort_dfm' ] = $cvp_orderby_dateformat;
            }

            $fdf = PT_CV_Functions::get_global_variable( 'ctf_filter_dateformat' );
            if ( !empty( $fdf ) ) {
                $args[ 'suppress_filters' ]              = false;
                $args[ PT_CV_PREFIX . 'ctf_filter_dfm' ] = $fdf;
            }

            $cvp_tcm = PT_CV_Functions::get_global_variable( 'thousand_commas_fields' );
            if ( !empty( $cvp_tcm ) ) {
                $args[ 'suppress_filters' ]      = false;
                $args[ PT_CV_PREFIX . 'ctftcm' ] = $cvp_tcm;
            }

            // Post of current user
            if ( in_array( 'author', $advanced_settings ) && PT_CV_Functions::wp_version_compare( '3.7' ) ) {
                $author_current_user = !empty( $view_settings[ PT_CV_PREFIX . 'author-current-user' ] ) ? $view_settings[ PT_CV_PREFIX . 'author-current-user' ] : null;
                $cur_uid             = get_current_user_id();
                if ( $cur_uid ) {
                    if ( $author_current_user === 'include' || isset( $view_settings[ PT_CV_PREFIX . 'author-include-current' ] ) ) {
                        $args[ 'author__in' ]   = isset( $args[ 'author__in' ] ) ? $args[ 'author__in' ] : array();
                        $args[ 'author__in' ][] = $cur_uid;
                    } else if ( $author_current_user === 'exclude' || isset( $view_settings[ PT_CV_PREFIX . 'author-not-include-current' ] ) ) {
                        $args[ 'author__not_in' ]   = isset( $args[ 'author__not_in' ] ) ? $args[ 'author__not_in' ] : array();
                        $args[ 'author__not_in' ][] = $cur_uid;
                    }
                }
            }

            if ( PT_CV_Functions_Pro::has_translation_plugin() ) {
                $args[ 'suppress_filters' ] = false;
            }

            // For Sticky posts
            // @since 5.7.0
            $sticky_option = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'sticky-posts' );
            if ( $sticky_option === 'prepend' || $sticky_option == 'prepend-all' || $sticky_option == 'sticky-only' ) {
                $args[ 'suppress_filters' ] = false;
                add_filter( 'the_posts', array( __CLASS__, 'filter_posts_sticky' ), 999, 2 );
            }

            // Shuffle filter pagination
            $sf_custom_data = !empty( $_POST[ 'custom_data' ] ) ? $_POST[ 'custom_data' ] : '';
            if ( defined( 'PT_CV_DOING_PAGINATION' ) && isset( $sf_custom_data[ 'sf_taxo' ], $sf_custom_data[ 'sf_pids' ] ) ) {
                // Use escape function later to prevent added double quotations
                $sf_pid         = $sf_custom_data[ 'sf_pids' ];
                $taxo_terms     = json_decode( wp_unslash( $sf_custom_data[ 'sf_taxo' ] ), true );
                $taxo_operators = json_decode( wp_unslash( $sf_custom_data[ 'sf_opera' ] ), true );
                $view_id        = cv_sanitize_vid( $_POST[ 'sid' ] );

                $modified       = 0;
                $view_tt        = isset( $taxo_terms[ $view_id ] ) ? $taxo_terms[ $view_id ] : '';
                $view_operators = isset( $taxo_operators[ $view_id ] ) ? $taxo_operators[ $view_id ] : '';

                if ( is_array( $view_tt ) ) {
                    $subtax = array();
                    foreach ( $view_tt as $taxo => $terms ) {
                        if ( $terms !== 'all' && $terms !== '' ) {
                            $operator = 'IN';
                            if ( count( $terms ) > 1 ) {
                                if ( !empty( $view_operators[ $taxo ] ) && $view_operators[ $taxo ] === 'and' ) {
                                    $operator = 'AND';
                                }
                            }

                            $subtax[ $taxo ] = array(
                                'taxonomy'         => $taxo,
                                'field'            => 'id',
                                'terms'            => array_map( 'cv_esc_sql', str_replace( $taxo . '-', '', $terms ) ), //reverse shuffle_filter_key()
                                'include_children' => false,
                                'operator'         => $operator,
                            );
                        }
                    }
                    if ( $subtax ) {
                        $relation = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-relation' );

                        if ( $relation === 'AND' && !empty( $args[ 'tax_query' ] ) ) {
                            foreach ( $args[ 'tax_query' ] as $taxq ) {
                                if ( !empty( $taxq[ 'taxonomy' ] ) && !isset( $subtax[ $taxq[ 'taxonomy' ] ] ) ) {
                                    $subtax[ $taxq[ 'taxonomy' ] ] = $taxq;
                                }
                            }
                        }

                        $args[ 'tax_query' ] = $subtax;

                        if ( count( $subtax ) > 1 ) {
                            $args[ 'tax_query' ][ 'relation' ] = $relation;
                        }

                        $show_all                 = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-filter-show-all' );
                        $args[ 'posts_per_page' ] = !empty( $show_all ) ? 1000 : (int) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'pagination-items-per-page' ); // -1 will ignore offset value

                        $modified++;
                    }
                }

                // Exclude shown posts of this View
                $pids       = isset( $sf_pid[ $view_id ] ) ? (array) json_decode( wp_unslash( $sf_pid[ $view_id ] ), true ) : array();
                $to_exclude = array_filter( $pids );

                if ( !empty( $to_exclude ) ) {
                    $args[ 'post__not_in' ] = array_merge( (array) $args[ 'post__not_in' ], array_map( 'intval', $to_exclude ) );
                    $modified++;
                }

                if ( $modified ) {
                    $args[ 'offset' ] = 0;

                    define( 'PT_CV_SHUFFLE_PAGINATION', true );
                }

                $args = apply_filters( PT_CV_PREFIX_ . 'query_args_sf_pagination', $args );
            }

            return $args;
        }

        /** Must run this after live filters handle (modify_query) or any similar things
         * so the "filtered" custom fields are handled correctly, before merge with "sorted" custom fields
         */
        public static function filter_query_params( $args ) {
            /**
             * Order by multi custom fields: need to combine & link meta_query to orderby array
             * http://wordpress.stackexchange.com/a/246358/3687
             */
            $cvp_meta_query_order = PT_CV_Functions::get_global_variable( 'meta_query_order' );

            if ( $cvp_meta_query_order ) {
                if ( !isset( $args[ 'meta_query' ] ) ) {
                    $args[ 'meta_query' ] = $cvp_meta_query_order;
                } else {
                    // Remove key which existed in meta_query
                    foreach ( array_keys( $cvp_meta_query_order ) as $key_with_prefix ) {
                        $key = substr( $key_with_prefix, strlen( CVP_CTF_ORDER_PREFIX ) );

                        foreach ( $args[ 'meta_query' ] as $idx => $m_settings ) {
                            if ( isset( $m_settings[ 'key' ] ) && $m_settings[ 'key' ] === $key && $m_settings[ 'compare' ] === 'EXISTS' ) {
                                unset( $args[ 'meta_query' ][ $idx ] );
                            }
                        }
                    }

                    if ( count( $cvp_meta_query_order ) > 1 ) {
                        $cvp_meta_query_order[ 'relation' ] = 'AND';
                    }

                    $args[ 'meta_query' ] = array(
                        'relation' => 'AND',
                        $args[ 'meta_query' ],
                        $cvp_meta_query_order
                    );
                }
            }

            return $args;
        }

        /**
         * Whether or not to include posts of children taxonomies
         *
         * @param boolean $args
         * @return boolean
         */
        public static function filter_include_children( $args ) {
            // Only process if $args = true (default value)
            if ( $args === true ) {
                $view_settings = PT_CV_Functions::get_global_variable( 'view_settings' );
                $exclude       = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-' . 'exclude-children', $view_settings );
                $args          = !empty( $exclude ) ? false : true;

                /**
                 * @since 3.3
                 * If it is still true, make it false if shuffle-filter is enable
                 * to prevent posts of child terms from being retrieved
                 */
                if ( $args === true ) {
                    $shuffle_filter = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'enable-taxonomy-filter', $view_settings );
                    if ( $shuffle_filter === 'yes' ) {
                        $args = false;
                    }
                }
            }

            return $args;
        }

        /**
         * Filter kind of content of View
         *
         * @param string $args
         * @return string
         */
        public static function filter_display_what( $args ) {
            $view_settings = PT_CV_Functions::get_global_variable( 'view_settings' );

            // Show terms as output
            if ( PT_CV_Functions_Pro::taxonomy_custom_setting_enable( $view_settings, 'taxonomy-term-info', 'as_output' ) ) {
                $args = 'term_as_output';
            }

            // Get one post of each term
            else if ( PT_CV_Functions_Pro::taxonomy_custom_setting_enable( $view_settings, 'taxonomy-one-per-term' ) ) {
                $args = 'post_per_term';
            }

            return $args;
        }

        /**
         * Filter content of View
         *
         * @param string $args
         * @return string
         */
        public static function filter_view_content( $args ) {
            $display_what  = PT_CV_Functions::get_global_variable( 'display_what' );
            $query_args    = PT_CV_Functions::get_global_variable( 'args' );
            $view_type     = PT_CV_Functions::get_global_variable( 'view_type' );
            $for_replacing = isset( $query_args[ 'cvp_replace_layout_page' ] ) && PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-child-terms-auto' );

            if ( empty( $query_args[ 'tax_query' ] ) && !$for_replacing ) {
                cvp_preview_notice( 'Please select terms!' );
                return $args;
            }

            // Display terms as output
            if ( $display_what === 'term_as_output' ) {
                cvp_preview_notice( __( 'Some settings will NOT work when enables "Show terms as output"', 'content-views-pro' ) );

                if ( !$for_replacing ) {
                    $taxonomies = $include    = array();
                    foreach ( $query_args[ 'tax_query' ] as $tax_query ) {
                        if ( !isset( $tax_query[ 'taxonomy' ], $tax_query[ 'terms' ] ) ) {
                            continue;
                        }

                        $taxonomies[] = $tax_query[ 'taxonomy' ];
                        $include      = array_merge( $include, $tax_query[ 'terms' ] );
                    }

                    // Get terms
                    $args      = array();
                    $field     = PT_CV_Functions::get_global_variable( 'slug_to_id' ) ? 'include' : 'slug';
                    $term_args = array(
                        'taxonomy'   => $taxonomies,
                        $field       => $include,
                        'hide_empty' => apply_filters( PT_CV_PREFIX_ . 'hide_empty_tax', false ),
                    );
                } else {
                    $term_obj  = get_queried_object();
                    $term_args = array(
                        'taxonomy' => $term_obj->taxonomy,
                        'parent'   => $term_obj->term_id
                    );
                }

                $terms = get_terms( $term_args );

                if ( $terms ) {
                    PT_CV_Functions::set_global_variable( 'force_disable_theme_pagination', $for_replacing );

                    foreach ( $terms as $term ) {
                        $term_link = get_term_link( $term, $term->taxonomy );
                        $dargs     = PT_CV_Functions::get_global_variable( 'dargs' );
                        $term_data = array();

                        foreach ( $dargs[ 'fields' ] as $field ) {
                            $field_html = '';
                            switch ( $field ) {
                                case 'thumbnail':
                                    $thumb_size = $dargs[ 'field-settings' ][ 'thumbnail' ][ 'size' ];
                                    $term_img   = CVP_Term_Thumbnail::get_thumbnail_of_term( $term, $thumb_size );
                                    $term_img   = apply_filters( PT_CV_PREFIX_ . 'term_thumbnail', $term_img, $term );
                                    if ( $term_img ) {
                                        $css = array();
                                        if ( $thumb_size === PT_CV_PREFIX . 'custom' ) {
                                            foreach ( array( 'width', 'height' ) as $f ) {
                                                if ( !empty( $dargs[ 'field-settings' ][ 'thumbnail' ][ "size-custom-$f" ] ) ) {
                                                    $val       = absint( $dargs[ 'field-settings' ][ 'thumbnail' ][ "size-custom-$f" ] );
                                                    $css[ $f ] = "$f:{$val}px!important;";
                                                }
                                            }
                                        }

                                        if ( PT_CV_Functions_Pro::animate_activated_content_hover() ) {
                                            $css[ 'width' ] = "width:100%!important;";
                                        }

                                        if ( $css ) {
                                            $term_img = preg_replace( '/<img/', '<img style="' . implode( '', $css ) . '"', $term_img );
                                        }

                                        $field_html = PT_CV_Html_Pro::term_output_link( $term_link, $term_img, PT_CV_PREFIX . 'href-thumbnail' );
                                    }

                                    break;
                                case 'title':
                                    $name       = apply_filters( PT_CV_PREFIX_ . 'term_name', $term->name, $term );
                                    $field_html = PT_CV_Html_Pro::term_output_link( $term_link, esc_html( $name ), PT_CV_PREFIX . 'tao' );

                                    break;
                                case 'content':
                                    $content_setting = $dargs[ 'field-settings' ][ 'content' ];
                                    $full_content    = $content_setting[ 'show' ] === 'full';
                                    $content         = $full_content ? $term->description : wp_trim_words( $term->description, (int) $content_setting[ 'length' ], !empty( $content_setting[ 'hide_dots' ] ) ? '' : ' &hellip;' );

                                    $fargs = isset( $dargs[ 'field-settings' ] ) ? $dargs[ 'field-settings' ] : array();
                                    if ( $full_content || !empty( $fargs[ 'content' ][ 'enable_filter' ] ) ) {
                                        $content = do_shortcode( $content );
                                    }

                                    if ( !$full_content && PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-excerpt-readmore' ) ) {
                                        $content .= apply_filters( PT_CV_PREFIX_ . 'field_content_readmore_seperated', '<br/>', $fargs );
                                        $content .= PT_CV_Html_Pro::custom_readmore( $term_link );
                                    }
                                    $content = sprintf( '<div class="%s">%s</div>', PT_CV_PREFIX . 'content', $content );

                                    $field_html = $content;

                                    break;
                                case 'custom-fields':
                                    $field_html = cvp_ctf_html( $term, false );
                                    break;
                            }

                            if ( $field_html ) {
                                $term_data[ $field ] = $field_html;
                            }
                        }

                        if ( array_key_exists( 'thumbnail', $term_data ) ) {
                            $term_data = apply_filters( PT_CV_PREFIX_ . 'fields_html', $term_data, null );
                        }

                        $args[ PT_CV_Functions::term_slug_sanitize( $term->slug ) ] = sprintf( '<div class="%s">%s</div>', PT_CV_PREFIX . 'taso', implode( '', $term_data ) );
                    }

                    // Reorder by order of selected terms
                    if ( isset( $include ) ) {
                        $args = PT_CV_Functions_Pro::_array_replace( array_flip( $include ), $args );
                    }
                }

                if ( empty( $args ) ) {
                    cvp_preview_notice( 'No terms found to show as output!' );
                }
            }

            // Get N posts of each term
            else if ( $display_what === 'post_per_term' ) {
                // Get terms
                $new_tax_query = array();
                foreach ( (array) $query_args[ 'tax_query' ] as $tax_query ) {
                    if ( !isset( $tax_query[ 'taxonomy' ], $tax_query[ 'terms' ] ) ) {
                        continue;
                    }

                    foreach ( (array) $tax_query[ 'terms' ] as $term ) {
                        $new_tax_query[] = array(
                            'taxonomy'         => $tax_query[ 'taxonomy' ],
                            'field'            => PT_CV_Functions::get_global_variable( 'slug_to_id' ) ? 'term_id' : $tax_query[ 'field' ],
                            'terms'            => $term,
                            'include_children' => PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-exclude-children' ) ? false : true,
                        );
                    }
                }

                // Query X posts of each term
                $posts_limit   = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-number-per-term' );
                $content_items = array();
                foreach ( $new_tax_query as $tax_query ) {
                    $_args                     = $query_args;
                    $_args[ 'tax_query' ]      = array( $tax_query );
                    $_args[ 'posts_per_page' ] = $posts_limit ? (int) $posts_limit : 1;
                    $_args[ 'offset' ]         = 0;

                    do_action( PT_CV_PREFIX_ . 'post_of_term', $tax_query );

                    if ( !isset( $_args[ 'post__not_in' ] ) ) {
                        $_args[ 'post__not_in' ] = array();
                    }
                    $_args[ 'post__not_in' ] = array_merge( $_args[ 'post__not_in' ], array_keys( $content_items ) );

                    $pt_query = new WP_Query( $_args );
                    if ( $pt_query->have_posts() ) {
                        do_action( PT_CV_PREFIX_ . 'before_process_item' );

                        while ( $pt_query->have_posts() ) {
                            $pt_query->the_post();
                            global $post;

                            // Output HTML for this item
                            $content_items[ $post->ID ] = PT_CV_Html::view_type_output( $view_type, $post );
                        }

                        do_action( PT_CV_PREFIX_ . 'after_process_item' );
                    }

                    PT_CV_Functions::reset_query();
                }

                $args = apply_filters( PT_CV_PREFIX_ . 'content_items', $content_items, $view_type );

                if ( empty( $args ) ) {
                    cvp_preview_notice( 'No posts found for selected terms!' );
                }
            }

            return $args;
        }

        /**
         * Add parameters to filter by Custom Field
         *
         * @param array $args
         *
         * @return array
         */
        public static function filter_by_custom_field( $args ) {
            $advanced_settings = (array) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'advanced-settings' );

            if ( !in_array( 'custom_field', $advanced_settings ) ) {
                return $args;
            }

            $ctf_query      = array();
            $ctf_dateformat = array();
            $saved_ctf      = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'ctf-filter-', true );
            $fields_count   = isset( $saved_ctf[ 'key' ] ) ? count( $saved_ctf[ 'key' ] ) : 0;
            $operators      = array(
                'allow_empty'     => array( 'EXISTS', 'NOT EXISTS', 'TODAY', 'NOW_PAST', 'NOW_FUTURE', 'IN_PAST' ),
                'no_value'        => array( 'EXISTS', 'NOT EXISTS' ),
                'require_2values' => array( 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN' ),
            );

            $saved_ctf = apply_filters( PT_CV_PREFIX_ . 'filtered_ctf', $saved_ctf, $fields_count );

            for ( $idx = 0; $idx < $fields_count; $idx ++ ) {
                if ( !isset( $saved_ctf[ 'value' ][ $idx ] ) ) {
                    continue;
                }

                $value   = $saved_ctf[ 'value' ][ $idx ];
                $key     = $saved_ctf[ 'key' ][ $idx ];
                $compare = isset( $saved_ctf[ 'operator' ][ $idx ] ) ? $saved_ctf[ 'operator' ][ $idx ] : null; // do not use sanitize_text_field(), it will convert 'compare' < > to HTML entities
                $type    = sanitize_text_field( $saved_ctf[ 'type' ][ $idx ] );
                $arr_val = explode( ',', $value );

                // Value is not empty Or ...
                $allow_empty_value = in_array( $compare, $operators[ 'allow_empty' ] );
                if ( !empty( $key ) && ( $value !== '' || $allow_empty_value ) ) {
                    // Check if require array of value
                    $require_array = 0;

                    // Validate input which requires 2 values
                    if ( in_array( $compare, $operators[ 'require_2values' ] ) ) {
                        $require_array = 1;
                        if ( count( $arr_val ) <= 1 ) {
                            cvp_preview_notice( sprintf( __( '[Filter by Custom field] This custom field "%s" requires 2 different values (separate by comma)', 'content-views-pro' ), $key ) );
                        }
                    }

                    // Validate date value
                    if ( $type == 'DATE' || $type == 'DATETIME' ) {
                        $suffix = ($type == 'DATETIME') ? ' H:i:s' : '';

                        if ( !in_array( $compare, array( 'TODAY', 'NOW_PAST', 'NOW_FUTURE', 'IN_PAST' ) ) ) {
                            // If all dates are valid, convert to Ymd format
                            $arr_dates = array();
                            foreach ( $arr_val as $date ) {
                                /**
                                 * English textual datetime
                                 * @since 4.8.1
                                 */
                                if ( preg_match( '/[a-zA-Z]+/', $date ) ) {
                                    $converted_date = date( 'Y-m-d' . $suffix, strtotime( trim( $date ), current_time( 'timestamp' ) ) );
                                    if ( $converted_date ) {
                                        $arr_dates[] = $converted_date;
                                    } else {
                                        cvp_preview_notice( sprintf( __( '[Filter by Custom field] Value of this date field "%s" is invalid', 'content-views-pro' ), $key ) );
                                    }
                                } else {
                                    $date = DateTime::createFromFormat( 'Y/m/d' . $suffix, $date );
                                    // Support old version where datepicker's dateformat is m/d/Y
                                    if ( !$date ) {
                                        $date = DateTime::createFromFormat( 'm/d/Y', $date );
                                    }

                                    if ( $date ) {
                                        $arr_dates[] = $date->format( 'Y-m-d' . $suffix );
                                    } else if ( !$allow_empty_value ) {
                                        cvp_preview_notice( sprintf( __( '[Filter by Custom field] Value of this date field "%s" is invalid', 'content-views-pro' ), $key ) );
                                    }
                                }
                            }
                            $arr_val = $arr_dates;
                        } else {
                            if ( $compare == 'NOW_FUTURE' ) {
                                $compare = '>=';
                            } else if ( $compare == 'IN_PAST' ) {
                                $compare = '<';
                            } else if ( $compare == 'TODAY' ) {
                                $compare = '=';
                            } else if ( $compare == 'NOW_PAST' ) {
                                $compare = '<=';
                            }

                            $arr_val = array( current_time( 'Y-m-d' . $suffix ) );
                        }

                        // Get custom date format if set
                        $dfm = isset( $saved_ctf[ 'date-format' ][ $idx ] ) ? trim( $saved_ctf[ 'date-format' ][ $idx ] ) : null;
                        if ( !empty( $dfm ) ) {
                            $ctf_dateformat[ $idx ] = $dfm;
                        }
                    }

                    // Create query array for this custom field
                    $tmp_arr = array(
                        'key'     => $key,
                        'type'    => $type === 'DECIMAL' ? 'DECIMAL(15,5)' : $type,
                        'compare' => $compare,
                    );

                    # If value is not empty
                    if ( !in_array( $compare, $operators[ 'no_value' ] ) && isset( $arr_val, $arr_val[ 0 ] ) ) {
                        $tmp_arr[ 'value' ] = apply_filters( PT_CV_PREFIX_ . 'query_ctf_value', $require_array ? $arr_val : $arr_val[ 0 ], $key );
                    }
                    if ( $tmp_arr ) {
                        $ctf_query[] = $tmp_arr;
                    }
                }
            }

            PT_CV_Functions::set_global_variable( 'ctf_filter_dateformat', $ctf_dateformat );

            if ( count( $ctf_query ) > 1 ) {
                PT_CV_Functions::set_global_variable( 'meta_query_origin', $ctf_query );
                $ctf_query[ 'relation' ] = sanitize_text_field( $saved_ctf[ 'relation' ] );
            }

            $args = array_merge( $args, array( 'meta_query' => $ctf_query ) );

            return $args;
        }

        /**
         * Filter when get list of taxonomies
         *
         * @param array $args The settings array to get taxonomies
         */
        public static function filter_taxonomies_to_show( $args ) {

            $dargs = PT_CV_Functions::get_global_variable( 'dargs' );

            if ( !empty( $dargs[ 'field-settings' ][ 'meta-fields' ][ 'taxonomy-display-what' ] ) ) {
                if ( !empty( $dargs[ 'field-settings' ][ 'meta-fields' ][ 'taxonomy-display-custom' ] ) ) {
                    $args = (array) $dargs[ 'field-settings' ][ 'meta-fields' ][ 'taxonomy-display-custom' ];
                    PT_CV_Functions::set_global_variable( 'tax-to-show', $args );
                }
            }

            return $args;
        }

        public static function filter_post_term( $args, $term ) {
            $args = array(
                'key'   => PT_CV_Functions_Pro::shuffle_filter_key( $term ),
                'value' => $term,
            );

            return $args;
        }

        /**
         * Show terms in selected order of taxonomies
         */
        public static function filter_post_terms_output( $args, $links, $taxonomy_terms ) {
            $taxes = PT_CV_Functions::get_global_variable( 'tax-to-show' );
            if ( $taxes && count( $taxes ) > 1 ) {
                $new_args       = array();
                $taxonomy_terms = PT_CV_Functions_Pro::_array_replace( array_flip( $taxes ), $taxonomy_terms );
                foreach ( $taxonomy_terms as $taxonomy => $terms_html ) {
                    $terms_html            = array_filter( $terms_html );
                    $new_args[ $taxonomy ] = $terms_html ? implode( ', ', $terms_html ) : false;
                }
                $args = implode( ', ', array_filter( $new_args ) );
            }

            return $args;
        }

        /**
         * Filter taxonomy: Get all registered taxonomies
         *
         * @param array $args Array to filter
         *
         * @return boolean
         */
        public static function filter_taxonomy_query_args( $args ) {
            if ( isset( $args[ 'show_ui' ] ) ) {
                unset( $args[ 'show_ui' ] );
            }
            if ( isset( $args[ '_builtin' ] ) ) {
                unset( $args[ '_builtin' ] );
            }

            return $args;
        }

        /** Add Woocommerce hidden taxonomies to the list
         * @since 5.6.0
         *
         * @param type $args
         * @return type
         */
        public static function filter_tax_list( $args ) {
            if ( taxonomy_exists( 'product_visibility' ) ) {
                $args[ 'product_visibility' ] = __( 'Visibility', 'content-views-pro' );
            }

			// Get Woocommerce attributes taxonomies
			if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
				$attributes = wc_get_attribute_taxonomies();
				if ( !empty( $attributes ) ) {
					// Don't include all if too many attributes, that cause slow/unable saving
					if ( count( $attributes ) > 30 ) {
						$attributes = array_slice( $attributes, 0, 30, true );
					}

					foreach ( $attributes as $tax ) {
						$tslug = wc_attribute_taxonomy_name( $tax->attribute_name );
						if ( !array_key_exists( $tslug, $args ) ) {
							$args[ $tslug ] = $tax->attribute_name;
						}
						
					}
				}
			}

			return $args;
        }

        /**
         * Add parameters for View shortcode, used to reuse View
         *
         * @param array $args
         */
        public static function filter_shortcode_params( $args ) {
            $args[ 'limit' ]     = 0;
            $args[ 'offset' ]    = 0;
            $args[ 'field' ]     = 'slug';
            $args[ 'operator' ]  = $args[ 'operator2' ] = $args[ 'operator3' ] = $args[ 'operator4' ] = 'IN'; // IN, NOT IN, AND
            $args[ 'relation' ]  = 'AND'; // AND, OR

            $text_keys = array( 'reuse_tax_query', 'keyword', 'post_type', 'post_parent', 'post_id', 'author', 'cat', 'tag', 'taxonomy', 'taxonomy2', 'terms', 'terms2', 'custom_field_value' );
            $args      += array_fill_keys( $text_keys, '' );

            return $args;
        }

        /**
         * Add wrapper class of View
         *
         * @param array $args
         *
         * @return int
         */
        public static function filter_view_class( $args ) {
            $view_settings = PT_CV_Functions::get_global_variable( 'view_settings' );
            $view_type     = PT_CV_Functions::get_global_variable( 'view_type' );
            $dargs         = PT_CV_Functions::get_global_variable( 'dargs' );

            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'text-direction' ) === 'rtl' ) {
                $args[] = PT_CV_PREFIX . 'rtl';
            }
            if ( $view_type == 'masonry' ) {
                $args[] = PT_CV_PREFIX . 'pinterest';
            }

            if ( $view_type == 'pinterest' || $view_type == 'masonry' ) {
                $style  = PT_CV_Functions::setting_value( PT_CV_PREFIX . $view_type . '-box-style', $view_settings, 'shadow' );
                $args[] = esc_attr( PT_CV_PREFIX . $style );

                $no_bb = PT_CV_Functions::setting_value( PT_CV_PREFIX . $view_type . '-no-bb', $view_settings, 'bb' );
                if ( $no_bb ) {
                    $args[] = esc_attr( PT_CV_PREFIX . $no_bb );
                }

                if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'item-margin-value-bottom' ) === '0' ) {
                    $args[] = PT_CV_PREFIX . 'mb0';
                }
            }

            if ( $view_type == 'timeline' ) {
                if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'timeline-long-distance' ) ) {
                    $args[] = PT_CV_PREFIX . 'lmode';
                }
                if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'timeline-simulate-fb' ) ) {
                    $args[] = PT_CV_PREFIX . 'sifb';
                }
            }

            if ( $view_type == 'grid' ) {
                $fields = array( 'grid-same-height', 'post-border' );
                foreach ( $fields as $field ) {
                    if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . $field ) && !PT_CV_Functions::get_global_variable( 'enable_shuffle_filter' ) ) {
                        $args[] = PT_CV_PREFIX . str_replace( 'grid-', '', $field );
                    }
                }
            }

            if ( $overlay = PT_CV_Functions_Pro::animate_activated_content_hover() ) {
                $animation = PT_CV_Functions::get_global_variable( 'animation' );
                $args[]    = PT_CV_PREFIX . 'content-hover';

                if ( !empty( $animation[ 'box-clickable' ] ) ) {
                    $args[] = PT_CV_PREFIX . 'clickable';
                }

                if ( !empty( $animation[ 'disable-onmobile' ] ) ) {
                    $args[] = PT_CV_PREFIX . 'nohover';
                }

                if ( $overlay === 'onhover' ) {
                    $args[] = !empty( $animation[ 'content-animation' ] ) ? esc_attr( $animation[ 'content-animation' ] ) : 'effect-fi';
                }

                if ( $overlay === 'always' ) {
                    $args[] = PT_CV_PREFIX . 'force-mask';
                }

                $position = !empty( $animation[ 'overlay-position' ] ) ? $animation[ 'overlay-position' ] : 'middle';
                $args[]   = PT_CV_PREFIX . 'overlay-' . $position;
            }

            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'enable-pagination' ) ) {
                if ( isset( $dargs[ 'pagination-settings' ][ 'style' ] ) && $dargs[ 'pagination-settings' ][ 'type' ] === 'ajax' ) {
                    $class  = 'pg' . $dargs[ 'pagination-settings' ][ 'style' ];
                    $args[] = esc_attr( PT_CV_PREFIX . $class );
                }
            }

            if ( !empty( $dargs[ 'view-style' ][ 'others' ][ 'text-align' ] ) ) {
                $args[] = esc_attr( PT_CV_PREFIX . $dargs[ 'view-style' ][ 'others' ][ 'text-align' ] );
            }

            if ( PT_CV_Functions::get_global_variable( 'display_what' ) === 'term_as_output' ) {
                $args[] = PT_CV_PREFIX . 'show-taxonomy';
            }

            if ( PT_CV_Functions_Pro::check_device( 'mobile' ) ) {
                $args[] = PT_CV_PREFIX . 'mobile';
            }

            if ( PT_CV_Functions_Pro::check_device( 'mobile_tablet' ) ) {
                $args[] = PT_CV_PREFIX . 'mobile-tablet';
            }

            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'other-social-show', $view_settings ) && PT_CV_Functions::setting_value( PT_CV_PREFIX . 'other-social-count', $view_settings ) ) {
                $args[] = PT_CV_PREFIX . 'socialsc';
            }

            if ( $view_type == 'scrollable' && PT_CV_Functions::setting_value( PT_CV_PREFIX . 'scrollable-textbelow' ) ) {
                $args[] = PT_CV_PREFIX . 'textbelow';
            }

            if ( PT_CV_Functions::get_global_variable( 'reused_view' ) ) {
                $args[] = PT_CV_PREFIX . 'reused';
            }

            if ( PT_CV_Functions::get_global_variable( 'enable_shuffle_filter' ) ) {
                $args[] = PT_CV_PREFIX . 'sf';
            }

            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'layout-format' ) === '2-col' && PT_CV_Functions::setting_value( PT_CV_PREFIX . 'lf-alternate' ) ) {
                if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-thumbnail-position' ) === 'left' ) {
                    $args[] = PT_CV_PREFIX . 'alternate-right';
                } else {
                    $args[] = PT_CV_PREFIX . 'alternate-left';
                }
            }

            $view_classes = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'view-css-class' );
            if ( $view_classes ) {
                $args[] = implode( ' ', array_map( 'sanitize_html_class', array_filter( explode( ' ', $view_classes ) ) ) );
            }

            return $args;
        }

        /**
         * Filter asset files to include in Preview/Front-end
         *
         * @param array $args
         */
        public static function filter_assets_files( $args ) {
            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'text-direction' ) === 'rtl' ) {
                $args[ 'css' ][] = plugins_url( 'public/assets/css/rtl.css', PT_CV_FILE_PRO );
            }

            return $args;
        }

        /**
         * Add custom HTML before list of items
         *
         * @param string $args
         */
        public static function filter_before_output_html( $args ) {
            global $pt_cv_glb, $pt_cv_id;
            $view_settings = PT_CV_Functions::get_global_variable( 'view_settings' );
            $view_type     = PT_CV_Functions::get_global_variable( 'view_type' );

            // Showing live filter filters/results separately
            $sc_params              = PT_CV_Functions::get_global_variable( 'shortcode_params' );
            $output_separate_filter = !empty( $sc_params[ 'show' ] );
            if ( $output_separate_filter ) {
                $current_output = $args;
            }

            if ( !empty( $pt_cv_glb[ 'parent_page' ] ) ) {
                $show_what = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'post_parent-auto-info', $view_settings );
                if ( $show_what ) {
                    $parent       = get_post( $pt_cv_glb[ 'parent_page' ] );
                    $parent_title = esc_html( $parent->post_title );

                    if ( $show_what === 'title' ) {
                        $args = sprintf( '<h3 class="%s">%s</h3>', PT_CV_PREFIX . 'parent-title', $parent_title );
                    } else {
                        $args = sprintf( '<h3 class="%s"><a href="%s">%s</a></h3>', PT_CV_PREFIX . 'parent-title', get_permalink( $parent->ID ), $parent_title );
                    }
                }
            }

            // Show terms as heading
            if ( PT_CV_Functions_Pro::taxonomy_custom_setting_enable( $view_settings, 'taxonomy-term-info', 'as_heading' ) ) {
                $dargs = PT_CV_Functions::get_global_variable( 'dargs' );

                // Get selected taxonomy
                $taxonomies_to_get = isset( $dargs[ 'taxonomy-filter' ] ) ? $dargs[ 'taxonomy-filter' ] : NULL;

                // Get selected terms or all terms of selected taxonomies
                $selected_terms_of_taxonomies = (array) PT_CV_Functions_Pro::get_selected_terms( $taxonomies_to_get );

                if ( $selected_terms_of_taxonomies ) {
                    $first_taxonomy          = current( array_keys( $selected_terms_of_taxonomies ) );
                    $terms_of_first_taxonomy = array_shift( $selected_terms_of_taxonomies );

                    if ( $first_taxonomy && $terms_of_first_taxonomy ) {
                        $first_term = array_slice( $terms_of_first_taxonomy, 0, 1, true );
                        if ( $first_term ) {
                            $term      = current( $first_term );
                            $term_link = get_term_link( $term, $first_taxonomy );

                            if ( !is_wp_error( $term_link ) ) {
                                // Get term heading tag
                                $tag       = tag_escape( apply_filters( PT_CV_PREFIX_ . 'field_term_heading_tag', 'h3' ) );
                                $tag_class = esc_attr( apply_filters( PT_CV_PREFIX_ . 'field_term_heading_class', PT_CV_PREFIX . 'term-heading' ) );
                                $text      = apply_filters( PT_CV_PREFIX_ . 'field_term_heading_text', esc_html( $term->name ), $term );

                                $args = "<$tag class='$tag_class'><a href='" . esc_url( $term_link ) . "'>$text</a></$tag>";
                            }
                        }
                    }
                }
            }

            // Enable filter
            if ( PT_CV_Functions::get_global_variable( 'enable_shuffle_filter' ) ) {
                self::before_output_html_shuffle_filter( $args );
            }

            // For Glossary list
            if ( $view_type == 'glossary' ) {
                self::before_output_html_glossary_header( $args );
            }

            if ( $output_separate_filter ) {
                PT_CV_Functions::set_global_variable( 'before_output_not_filter', $args );
                $args = $current_output;
            }

            /**
             * Add edit button if:
             * in front-end
             * & is administrator or allowed role
             * & want to display this button (have option in Settings page)
             */
            $hide_edit_view = PT_CV_Functions::get_option_value( 'hide_edit_view' );
            if ( !is_admin() && PT_CV_Functions_Pro::user_can_manage_view() && empty( $hide_edit_view ) ) {
                $edit_link = PT_CV_Functions::view_link( $pt_cv_id );
                $edit_html = '<a href="' . esc_url( $edit_link ) . '" target="_blank" class="' . PT_CV_PREFIX . 'edit-view' . '">' . __( 'Edit View', 'content-views-query-and-display-post-page' ) . '</a><br>';
                $args      = $edit_html . $args;
            }

            return $args;
        }

        /**
         * Display Shuffle Filter Options
         *
         * @global array $view_settings
         * @global array $dargs
         * @global array $pt_cv_id
         * @global array $gl_view_styles
         * @global array $gl_view_styles
         * @param array $args
         * @return array
         */
        public static function before_output_html_shuffle_filter( &$args ) {
            global $pt_cv_glb, $pt_cv_id;
            $dargs = PT_CV_Functions::get_global_variable( 'dargs' );

            if ( !isset( $pt_cv_glb[ 'view_styles' ] ) ) {
                $pt_cv_glb[ 'view_styles' ] = array();
            }

            $sanitized_terms   = array();
            // Check if Taxonomy is selected in Advanced filters
            $advanced_settings = (array) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'advanced-settings' );
            if ( !in_array( 'taxonomy', $advanced_settings ) ) {
                return sprintf( '<div class="alert alert-danger">%s</div>', __( 'Please enable Taxonomy under Advanced filters section', 'content-views-pro' ) );
            }

            // Get selected taxonomy
            $taxonomies_to_get = isset( $dargs[ 'taxonomy-filter' ] ) ? $dargs[ 'taxonomy-filter' ] : NULL;
            if ( !is_array( $taxonomies_to_get ) ) {
                return sprintf( '<div class="alert alert-danger">%s</div>', __( 'Please select at least one taxonomy', 'content-views-pro' ) );
            }

            // Get selected terms or all terms of selected taxonomies
            $selected_terms_of_taxonomies = apply_filters( PT_CV_PREFIX_ . 'terms_to_filter', (array) PT_CV_Functions_Pro::get_selected_terms( $taxonomies_to_get ) );
            if ( !$selected_terms_of_taxonomies ) {
                return sprintf( '<div class="alert alert-info">%s</div>', __( 'There is no terms to filter', 'content-views-pro' ) );
            }

            foreach ( $selected_terms_of_taxonomies as $taxonomy => $terms ) {
                $this_term = array();
                foreach ( $terms as $term ) {
                    if ( empty( $term->name ) ) {
                        continue;
                    }

                    $this_term[ PT_CV_Functions_Pro::shuffle_filter_key( $term ) ] = apply_filters( PT_CV_PREFIX_ . 'sf_term_text', $term->name, $term );
                }
                $sanitized_terms[ $taxonomy ] = $this_term;
            }

            $sanitized_terms = apply_filters( PT_CV_PREFIX_ . 'shuffle_filter_extra', $sanitized_terms );

            // Get filter settings
            $prefix          = 'taxonomy-filter';
            $filter_settings = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . $prefix . '-' );

            $filter_class = PT_CV_PREFIX . 'filter-bar';
            $class        = implode( ' ', apply_filters( PT_CV_PREFIX_ . 'shuffle_filter_class', array( $filter_class ) ) );

            // Show Filter bar for each Taxonomy
            $output = array();

            $sfilter_type = apply_filters( PT_CV_PREFIX_ . 'sfilter_type', $filter_settings[ 'type' ] );

            // Single filter
            if ( $sfilter_type != 'group_by_taxonomy' ) {
                // Get position
                $position = $filter_settings[ 'position' ];

                switch ( $position ) {
                    case 'left':
                        $class .= ' pull-left';
                        break;
                    case 'center':
                        $class .= ' ' . PT_CV_PREFIX . 'center';
                        break;
                    case 'right':
                        $class .= ' pull-right';
                        break;
                }

                $idx_tax = 0;
                foreach ( $sanitized_terms as $idx => $selected_terms ) {
                    // Generate id for each filter bar
                    $filter_id = $filter_class . '-' . $pt_cv_id . '-' . $idx;

                    // Margin bottom
                    $margin_bottom = $filter_settings[ 'margin-bottom' ];
                    if ( isset( $margin_bottom ) ) {
                        $pt_cv_glb[ 'view_styles' ][] = sprintf( '#%s { margin-bottom: %spx !important; }', $filter_id, (int) $margin_bottom );
                    }

                    switch ( $sfilter_type ) {
                        case 'btn-group':
                            // Custom css
                            $space                        = $filter_settings[ 'space' ];
                            $pt_cv_glb[ 'view_styles' ][] = sprintf( '#%s .btn { margin-right: %spx !important; }', $filter_id, $space );

                            $output[] = PT_CV_Html_Pro::filter_html_btn_group( $class, $selected_terms, $filter_id, $idx_tax, false );
                            break;
                        case 'breadcrumb':
                            $output[] = PT_CV_Html_Pro::filter_html_breadcrumb( $class, $selected_terms, $filter_id, $idx_tax );
                            break;
                        case 'vertical-dropdown':
                            $output[] = PT_CV_Html_Pro::filter_html_vertical_dropdown( $class, $selected_terms, $filter_id, $idx_tax, false );
                            break;
                    }
                    $idx_tax++;
                }
            }
            // Filter by Group of terms
            else {
                $class .= ' ' . PT_CV_PREFIX . 'filter-group';

                // Group options by Taxonomy
                list( $columns, $span_width_last, $span_width, $span_class ) = PT_CV_Html_ViewType::process_column_width( count( $sanitized_terms ), false );

                // Get all current taxonomies
                $all_taxonomies = apply_filters( PT_CV_PREFIX_ . 'all_taxonomies', PT_CV_Values::taxonomy_list() );

                $row_html = array();
                $idx_tax  = 0;
                foreach ( $sanitized_terms as $taxonomy => $terms ) {
                    $column_html = array();

                    // Heading text
                    $filter_title_class = apply_filters( PT_CV_PREFIX_ . 'shuffle_title_class', PT_CV_PREFIX . 'filter-title' );
                    $heading_text       = PT_CV_Functions_Pro::shuffle_filter_group_setting( $idx_tax );
                    if ( $heading_text == __( 'All', 'content-views-pro' ) || empty( $heading_text ) ) {
                        $heading_text = $all_taxonomies[ $taxonomy ];
                    }
                    $column_html[] = sprintf( '<h2 class="%s" data-taxonomy="%s">%s</h2>', esc_attr( $filter_title_class ), esc_attr( $taxonomy ), apply_filters( PT_CV_PREFIX_ . 'shuffle_title_text', esc_html( $heading_text ) ) );

                    // Terms list
                    $terms_html = array();
                    foreach ( $terms as $key => $text ) {
                        $terms_html[] = sprintf( '<li><a href="#" class="%s" data-value="%s" data-sftype="group">%s</a></li>', PT_CV_PREFIX . 'filter-option', esc_attr( $key ), esc_html( $text ) );
                    }
                    $column_html[] = sprintf( '<ul>%s</ul>', implode( "\n", $terms_html ) );

                    // Operator for frontend
                    $sf_taxo_operator = PT_CV_Functions_Pro::shuffle_filter_group_setting( $idx_tax, 'operator' );
                    $operator_options = array();
                    foreach ( array( 'and' => __( 'AND', 'content-views-pro' ), 'or' => __( 'OR', 'content-views-pro' ) ) as $option => $text ) {
                        $operator_options[] = sprintf( '<label><input type="radio" value="%s" name="%s" %s></input>%s</label>', $option, 'cvp-filter-operator-' . $idx_tax, checked( $sf_taxo_operator, $option, false ), $text );
                    }
                    $operator_selection = sprintf( '<div>%s</div>', implode( '', $operator_options ) );
                    $label              = __( 'Operator', 'content-views-query-and-display-post-page' );                    
                    $column_html[]      = sprintf( '<div class="%s"><label>%s</label>%s</div>', PT_CV_PREFIX . 'filter-operator' . ' hidden', $label, $operator_selection );

                    // Get HTML of each column
                    $classes   = array( PT_CV_PREFIX . 'filter-egroup' );
                    $classes[] = $span_class . $span_width;
                    $classes[] = 'col-sm-' . ($span_width >= 3 ? $span_width : 6);
                    // By default, disable 2 columns for Mobile devices
                    if ( apply_filters( PT_CV_PREFIX_ . 'shuffle_2col_mobile', false ) ) {
                        $classes[] = 'col-xs-6';
                    }

                    $row_html[] = sprintf( '<div class="%s">%s</div>', esc_attr( implode( ' ', $classes ) ), implode( "\n", $column_html ) );

                    $idx_tax++;
                }

                // Wrap columns of Taxonomies group to a row
                $filter_id = $filter_class . '-' . $pt_cv_id;
                $output[]  = sprintf( '<div class="%s" id="%s">%s</div>', esc_attr( $class ), esc_attr( $filter_id ), implode( "\n", $row_html ) );
            }

            $args = implode( '', $output );
        }

        /**
         * Display Header text for Glossary list
         *
         * @global array $content_items
         * @param array $args
         */
        public static function before_output_html_glossary_header( &$args ) {
            if ( PT_CV_Functions::get_global_variable( 'no_post_found' ) ) {
                return;
            }

            $glb_content_items = PT_CV_Functions::get_global_variable( 'content_items' );

            // Get list of post objects, title as key
            $all_posts     = isset( $GLOBALS[ 'cv_posts' ] ) ? $GLOBALS[ 'cv_posts' ] : array();
            $content_items = array();
            foreach ( $glb_content_items as $pid => $item ) {
                $post                    = isset( $all_posts[ $pid ] ) ? $all_posts[ $pid ] : null;
                $title                   = isset( $post->post_title ) ? $post->post_title : strip_tags( $item );
                $title                   = apply_filters( PT_CV_PREFIX_ . 'glossary_from', $title, $post );
                $content_items[ $title ] = $item;
            }

            $glossary_list = array();
            foreach ( $content_items as $title => $item ) {
                /**
                 * Remove special chars before extract index
                 * @since 4.3
                 */
                $special_chars = array( "?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", "%", "+", chr( 0 ) );
                $title         = str_replace( $special_chars, '', $title );

                /**
                 * Remove stop words before extract index
                 * @since 4.3
                 */
                if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'glossary-stop-words' ) ) {
                    $words = explode( ',', PT_CV_Functions::setting_value( PT_CV_PREFIX . 'glossary-stop-words' ) );
                    $title = str_replace( $words, '', $title );
                }

                $title = trim( $title );

                // fix untrackable 500 error in hosting which doesn't enable/install relative module
                $st  = (function_exists( 'mb_strtoupper' ) && function_exists( 'mb_substr' )) ? mb_strtoupper( mb_substr( $title, 0, 1, CVP_ENCODING ) ) : strtoupper( substr( $title, 0, 1 ) );
                $key = apply_filters( PT_CV_PREFIX_ . 'glossary_key', $st, $title );
                if ( $key != '' ) {
                    if ( !isset( $glossary_list[ $key ] ) ) {
                        $glossary_list[ $key ] = array();
                    }
                    $glossary_list[ $key ][] = $item;
                }
            }

            // Get indexes
            $indexes = array_keys( $glossary_list );

            // Sort/Order indexes
            $locale_sort = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'glossary-locale-sort' );
            if ( $locale_sort && function_exists( 'collator_create' ) && function_exists( 'collator_sort' ) ) {
                collator_sort( collator_create( get_locale() ), $indexes );
            } else {
                natsort( $indexes );
            }

            // Restructure the list: index (in sorted order) => posts (no order change)
            $glossary_list = PT_CV_Functions_Pro::_array_replace( array_flip( $indexes ), $glossary_list );

            PT_CV_Functions::set_global_variable( 'glossary_list', $glossary_list );

            // Get HTML of Glossary menu
            $args = PT_CV_Html_Pro::glossary_menu( $indexes );
        }

        /**
         * Show data-type of each post
         *
         * @param string $args    The output HTML
         * @param string $post_id The post ID
         *
         * @return string
         */
        public static function filter_content_item_filter_value( $args, $post_id ) {
            if ( PT_CV_Functions::get_global_variable( 'enable_shuffle_filter' ) ) {

                $group = 0;
                if ( is_int( $post_id ) ) {
                    global $pt_cv_glb;
                    if ( empty( $pt_cv_glb[ 'item_terms' ][ $post_id ] ) ) {
                        PT_CV_Functions::post_terms( $post_id );
                    }
                    $terms_of_post = !empty( $pt_cv_glb[ 'item_terms' ][ $post_id ] ) ? $pt_cv_glb[ 'item_terms' ][ $post_id ] : array();
                    if ( $terms_of_post ) {
                        $sanitized_terms = array();
                        foreach ( $terms_of_post as $term ) {
                            $sanitized_terms[] = PT_CV_Functions_Pro::shuffle_filter_key( $term );
                        }

                        $group = implode( ' ', apply_filters( PT_CV_PREFIX_ . 'post_groups', $sanitized_terms, $post_id ) );
                        $args  .= sprintf( 'data-groups="%s"', esc_attr( $group ) );
                    }
                }
                // For posts which have no terms, or for none post item (advertisements)
                if ( !$group ) {
                    $args .= 'data-groups=""';
                }

                // [shuffle-pagination]
                if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'enable-pagination' ) && PT_CV_Functions::get_global_variable( 'current_page' ) > 1 ) {
                    // Hide post before append to output by shuffle animation
                    if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'pagination-type' ) === 'ajax' ) {
                        $args .= ' style="opacity:0"';
                    }
                }
            }

            // Show post ID
            $args .= sprintf( ' data-pid="%s"', $post_id );

            return $args;
        }

        public static function filter_content_no_post_found_text( $args ) {
            if ( PT_CV_Functions_Pro::user_can_manage_view() ) {
                $query_args = PT_CV_Functions::get_global_variable( 'args' );

                // Parent page
                if ( !empty( $query_args[ 'post_parent' ] ) ) {
                    $args .= '<br>' . sprintf( __( 'For Administrator only: %s Parent page %s setting might cause this result', 'content-views-pro' ), '<strong>', '</strong>.' );
                }

                // If enable Sort by custom field
                if ( !empty( $query_args[ 'orderby' ] ) && $query_args[ 'orderby' ] === 'meta_value' ) {
                    $args .= '<br>' . sprintf( __( 'For Administrator only: %s Sort by %s setting (using custom field %s) might cause this result', 'content-views-pro' ), '<strong>', '</strong>', " <strong>{$query_args[ 'meta_key' ]}</strong>" );
                }
            }

            return $args;
        }

        /**
         * Filter $content_items variable before display
         *
         * @param type $args
         */
        public static function filter_content_items( $args, $view_type ) {
            $args = CVP_ADVERT::insert_ads_to_page( $args, $view_type );
            $args = self::sort_post_dragdrop( $args );

            return $args;
        }

        /** Handle sticky posts options
         * @return array
         */
        public static function filter_posts_sticky( $posts, $query ) {
            remove_filter( 'the_posts', array( __CLASS__, 'filter_posts_sticky' ), 999, 2 );

            $sticky_post_ids = get_option( 'sticky_posts' );
            if ( $sticky_post_ids ) {
                if ( PT_CV_Functions::get_global_variable( 'current_page' ) === 1 ) {
                    $params        = array();
                    $sticky_option = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'sticky-posts' );
                    if ( $sticky_option == 'prepend-all' || $sticky_option == 'sticky-only' ) {
                        $params = array(
                            'post__in'     => $sticky_post_ids,
                            'post__not_in' => PT_CV_Functions::setting_value( PT_CV_PREFIX . 'post__not_in' ),
                            'post_type'    => PT_CV_Functions::get_global_variable( 'content_type' ),
                            'post_status'  => 'publish',
                            'nopaging'     => true,
                        );
                    } elseif ( $sticky_option === 'prepend' ) {
                        $params = array_merge( PT_CV_Functions::get_global_variable( 'args' ), array(
                            'post__in'    => $sticky_post_ids,
                            'post_status' => 'publish',
                            'nopaging'    => true,
                        ) );
                    }

                    $stickies = $params ? get_posts( $params ) : null;
                    if ( $stickies ) {
                        // Add sticky posts to the list
                        if ( $sticky_option == 'sticky-only' ) {
                            $posts = $stickies;
                        } else {
                            $sticky_offset = 0;
                            foreach ( $stickies as $sticky_post ) {
                                array_splice( $posts, $sticky_offset, 0, array( $sticky_post ) );
                                $sticky_offset++;
                            }
                        }

                        // Respect the Limit
                        if ( !PT_CV_Functions::setting_value( PT_CV_PREFIX . 'enable-pagination' ) ) {
                            $limit = (int) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'limit' );
                            if ( $limit > 0 && count( $posts ) > $limit ) {
                                $posts = array_slice( $posts, 0, $limit, true );
                            }
                        }
                    }
                }
            }
            return $posts;
        }

        private static function sort_post_dragdrop( $args ) {
            $rebuild = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'rebuild' );
            if ( PT_CV_Functions::get_global_variable( 'reused_view' ) || !empty( $rebuild ) ) {
                return $args;
            }

            $advanced_settings = (array) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'advanced-settings' );
            if ( in_array( 'order', $advanced_settings ) ) {
                $orderby = (array) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'orderby' );
                if ( $orderby[ 0 ] === 'dragdrop' ) {
                    $tpids        = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'order-dragdrop-pids' );
                    $apids        = json_decode( cvp_stripallslashes( $tpids ), true );
                    // Posts order for current page
                    $current_page = PT_CV_Functions::get_global_variable( 'current_page' );
                    if ( !empty( $apids[ "$current_page" ] ) ) {
                        $pids_here = array_map( 'intval', $apids[ "$current_page" ] );

                        // Reorder posts by drag&drop order
                        $args = PT_CV_Functions_Pro::_array_replace( array_flip( $pids_here ), $args, 'prepend' );
                    }
                }
            }

            return $args;
        }

        /**
         * Filter span with
         *
         * @param array $args
         * @param int $span_width
         *
         * @return array
         */
        public static function filter_item_col_class( $args, $span_width ) {
            $allow_xs = $allow_sm = 1;

            if ( in_array( PT_CV_PREFIX . 'omain', $args ) ) {
                $allow_xs = $allow_sm = 0;
            }

            if ( in_array( PT_CV_PREFIX . 'ocol', $args ) && PT_CV_Functions::get_global_variable( 'one_above' ) ) {
                $allow_xs = $allow_sm = 0;
            }

            if ( in_array( PT_CV_PREFIX . 'oothers', $args ) && PT_CV_Functions::get_global_variable( 'other_columns' ) == 1 ) {
                $allow_xs = $allow_sm = 0;
            }

            if ( $allow_sm ) {
                // One (on left) & others, respect the width proportion
                if ( in_array( PT_CV_PREFIX . 'ocol', $args ) ) {
                    $args[] = 'col-sm-' . $span_width;
                } else {
                    $tablet_col = (int) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'resp-tablet-number-columns' );
                    $args[]     = 'col-sm-' . (int) ( 12 / ($tablet_col ? $tablet_col : 2) );
                }
            }

            if ( $allow_xs ) {
                $mobile_col = (int) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'resp-number-columns' );
                $args[]     = 'col-xs-' . (int) ( 12 / ($mobile_col ? $mobile_col : 1) );
            }

            return $args;
        }

        public static function filter_collapsible_open_all( $args ) {
            $args = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'collapsible-open-all' );
            return $args;
        }

        /**
         * Exclude sticky posts completely
         *
         * @param int   $args
         * @param array $settings The settings array of View
         *
         * @return int
         */
        public static function filter_post__not_in( $args, $settings ) {
            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'sticky-posts' ) !== 'default' ) {
                $args = array_merge( (array) $args, get_option( 'sticky_posts' ) );
            }

            return $args;
        }

        /**
         * Filter parent page ID
         *
         * @param array $args
         */
        public static function filter_post_parent_id( $args ) {
            global $pt_cv_glb;

            $current_post = cvp_get_current_post_across_pagination( 'object' );
            $post_id      = !empty( $current_post->ID ) ? $current_post->ID : 0;
            $post_parent  = !empty( $current_post->post_parent ) ? $current_post->post_parent : 0;

            // Current page of WP front-end
            $pt_cv_glb[ 'current_post' ] = 0;
            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'post_parent-current' ) ) {
                $parent_page_opt = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'post_parent-auto' );
                if ( $current_post && !empty( $parent_page_opt ) ) {
                    switch ( $parent_page_opt ) {
                        case 'child-sib':
                        case 'yes':
                            $args = $post_parent ? $post_parent : $post_id;
                            break;
                        case 'siblings':
                            $args = $post_parent ? $post_parent : $args;
                            break;
                        case 'children':
                            $args = $post_id;
                            break;
                    }

                    if ( apply_filters( PT_CV_PREFIX_ . 'pp_exclude_current_post', true ) ) {
                        $pt_cv_glb[ 'current_post' ] = $post_id;
                    }
                }
            }

            if ( $args ) {
                $pt_cv_glb[ 'parent_page' ] = $args;
            }

            return $args;
        }

        /**
         * Show this post or not
         *
         * @param array $args
         *
         * @return array
         */
        public static function filter_show_this_post( $args ) {
            global $pt_cv_glb;

            if ( !empty( $pt_cv_glb[ 'current_post' ] ) && $args->ID === $pt_cv_glb[ 'current_post' ] ) {
                $args = 0;
                return $args;
            }

            $advanced_settings = (array) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'advanced-settings' );

            /**
             * Translation plugin: Hide posts if not translated
             */
            $translation_plugin = PT_CV_Functions_Pro::has_translation_plugin();
            if ( $translation_plugin ) {
                if ( $translation_plugin === 'Polylang' ) {
                    $language  = pll_current_language();
                    $post_lang = pll_get_post_language( $args->ID );
                    if ( $language && $post_lang && $post_lang !== $language ) {
                        $args = 0;
                    }
                } elseif ( $translation_plugin === 'qTranslate' ) {
                    if ( function_exists( 'qtranxf_getAvailableLanguages' ) ) {
                        $available_languages = qtranxf_getAvailableLanguages( $args->post_content );
                        if ( $available_languages !== false ) {
                            global $q_config;
                            if ( !in_array( $q_config[ 'language' ], $available_languages ) ) {
                                $args = 0;
                            }
                        }
                    }
                }
            }

            /**
             * 2. Content restriction plugin
             */
            $membership_plugin = PT_CV_Functions_Pro::has_access_restriction_plugin();
            if ( $args && $membership_plugin && in_array( 'check_access_restriction', $advanced_settings ) ) {

                if ( $membership_plugin === 'Members' ) {
                    if ( !members_can_current_user_view_post( $args->ID ) ) {
                        $args = 0;
                    }
                } elseif ( $membership_plugin === 'Paid Memberships Pro' ) {
                    $hasaccess = pmpro_has_membership_access( $args->ID, NULL, true );
                    if ( is_array( $hasaccess ) ) {
                        //returned an array to give us the membership level values
                        #$post_membership_levels_ids		 = $hasaccess[ 1 ];
                        #$post_membership_levels_names	 = $hasaccess[ 2 ];
                        $hasaccess = $hasaccess[ 0 ];
                    }

                    if ( !$hasaccess ) {
                        $args = 0;
                    }
                } elseif ( $membership_plugin === 'MemberMouse' ) {
                    if ( !mm_access_decision( array( "id" => $args->ID, "access" => "true" ) ) ) {
                        $args = 0;
                    }
                } elseif ( $membership_plugin === 'Restrict Content Pro' ) {
                    if ( !rcp_user_can_access( get_current_user_id(), $args->ID ) ) {
                        $args = 0;
                    }
                } elseif ( $membership_plugin === 's2Member' ) {
                    if ( !is_permitted_by_s2member( $args->ID ) ) {
                        $args = 0;
                    }
                } elseif ( $membership_plugin === 'MemberPress' ) {
                    if ( class_exists( 'MeprRule' ) && method_exists( 'MeprRule', 'is_locked' ) && MeprRule::is_locked( $args ) ) {
                        $args = 0;
                    }
                }
            }

            return $args;
        }

        /**
         * Add more fields to display, such as Social buttons...
         *
         * @param array $args
         * @param object $post Current post object
         */
        public static function filter_fields_html( $args, $post ) {
            $dargs = PT_CV_Functions::get_global_variable( 'dargs' );

            // Move special field to top
            if ( !empty( $args[ 'special-field' ] ) ) {
                $special_html = $args[ 'special-field' ];
                unset( $args[ 'special-field' ] );
                $args         = array_merge( array( 'special-field' => $special_html ), $args );
            }

            // Move thumbnail top top (if it is at bottom) to ensure that Format works
            if ( $dargs[ 'layout-format' ] === '2-col' ) {
                $sfields = array_keys( $args );
                if ( array_pop( $sfields ) === 'thumbnail' ) {
                    $thumb_html = $args[ 'thumbnail' ];
                    unset( $args[ 'thumbnail' ] );
                    $args       = array_merge( array( 'thumbnail' => $thumb_html ), $args );
                }
            }

            // Display social buttons
            $other_settings = $dargs[ 'other-settings' ];
            if ( isset( $other_settings[ 'social-show' ] ) && isset( $other_settings[ 'social-buttons' ] ) ) {
                $buttons_html = array();

                // Get post info
                $url   = apply_filters( PT_CV_PREFIX_ . 'social_url', get_permalink( $post ) );
                $title = urlencode( get_the_title( $post ) );

                // Get thumbnail
                $thumbnail_id = get_post_thumbnail_id( $post->ID );
                $media        = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
                $media_url    = is_array( $media ) ? $media[ 0 ] : '';
                $media_alt    = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
                $description  = $media_alt ? urlencode( $media_alt ) : $title;

                // Display selected buttons
                foreach ( (array) $other_settings[ 'social-buttons' ] as $button ) {
                    $social_link = '';

                    // Link
                    switch ( $button ) {
                        case 'facebook':
                            $social_link = sprintf( 'https://www.facebook.com/sharer/sharer.php?u=%s', $url );
                            break;
                        case 'twitter':
                            $social_link = sprintf( 'https://twitter.com/intent/tweet?url=%s&text=%s', $url, $title );
                            break;
                        case 'googleplus':
                            $social_link = sprintf( 'https://plus.google.com/share?url=%s', $url );
                            break;
                        case 'linkedin':
                            $social_link = sprintf( 'https://www.linkedin.com/shareArticle?mini=true&url=%s&title=%s&summary=&source=', $url, $title );
                            break;
                        case 'pinterest':
                            $social_link = sprintf( 'https://pinterest.com/pin/create/bookmarklet/?url=%s&media=%s&description=%s', $url, $media_url, $description );
                            break;
                    }

                    if ( $social_link ) {
                        $buttons_html[] = sprintf( '<a href="%s" class="%s" target="_blank"></a>', esc_url( $social_link ), PT_CV_PREFIX . 'social-' . $button );
                    }
                }

                $buttons_html = apply_filters( PT_CV_PREFIX_ . 'social_links', $buttons_html, $url, $title );

                $args[ 'social-buttons' ] = sprintf( '<div class="%s">%s</div>', PT_CV_PREFIX . 'social-buttons', implode( '', $buttons_html ) );
            }

            // Content on hover: Wrap title, content, meta fields... to a mask
            if ( PT_CV_Functions_Pro::animate_activated_content_hover() ) {
                global $pt_cv_glb, $pt_cv_id;
                $exclude_field = apply_filters( PT_CV_PREFIX_ . 'hover_exclude', array() );

                if ( !empty( $pt_cv_glb[ $pt_cv_id ][ 'animation' ][ 'exclude-fields' ] ) ) {
                    $exclude_field = $pt_cv_glb[ $pt_cv_id ][ 'animation' ][ 'exclude-fields' ];
                }

                if ( PT_CV_Functions::get_global_variable( 'view_type' ) === 'collapsible' ) {
                    $exclude_field[] = 'title';
                }

                $exclude_field = array_unique( $exclude_field );

                $mask_wrapper = array();
                $index        = 0;
                foreach ( $args as $field => $html ) {
                    $extra = $exclude_field ? !in_array( $field, (array) $exclude_field ) : true;

                    if ( $field != 'thumbnail' && $extra ) {
                        $index++;
                        // Add class to this field
                        $class          = PT_CV_PREFIX . (($index % 2 == 1) ? 'animation-left' : 'animation-right');
                        $html           = preg_replace( '/class="/', 'class="' . $class . ' ', $html, 1 );
                        $mask_wrapper[] = $html;
                        unset( $args[ $field ] );
                    }
                }

                if ( $mask_wrapper ) {
                    $mask_html   = sprintf( '<div class="%s">%s</div>', PT_CV_PREFIX . 'mask', implode( '', $mask_wrapper ) );
                    $extra_class = (PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-thumbnail-style' ) === 'img-circle') ? ' img-circle' : '';
                    $hover_html  = sprintf( '<div class="%s">%s</div>', PT_CV_PREFIX . 'hover-wrapper' . $extra_class, $args[ 'thumbnail' ] . $mask_html );

                    $position_order = array_keys( $args );
                    unset( $args[ 'thumbnail' ] );

                    $args = $args + array( 'thumbnail' => $hover_html );

                    // If title is always visible => Display Title in correct position with Thumbnail
                    if ( count( $position_order ) > 1 ) {
                        $args = PT_CV_Functions_Pro::_array_replace( array_flip( $position_order ), $args );
                    }
                }
            }

            return $args;
        }

        /**
         * Filter terms list in output
         *
         * @param mixed $args
         * @return bool
         */
        public static function filter_terms_to_filter( $args ) {

            if ( PT_CV_Functions::get_global_variable( 'enable_shuffle_filter' ) ) {
                // Hide filters of taxonomies
                $hide_taxos = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-filter-to-hide' );
                if ( !empty( $hide_taxos ) ) {
                    foreach ( $hide_taxos as $taxonomy ) {
                        unset( $args[ $taxonomy ] );
                    }
                }
            }

            /**
             * Sort taxonomies by selected order
             * @since 4.3
             */
            $sf_display_order = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-filter-display-order' );
            if ( count( $args ) > 1 && !empty( $sf_display_order ) ) {
                $args = PT_CV_Functions_Pro::_array_replace( array_flip( $sf_display_order ), $args );
            }

            return $args;
        }

        /**
         * Detect is mobile
         * @param bool $args
         * @return bool
         */
        public static function filter_is_mobile( $args ) {
            $args = PT_CV_Functions_Pro::check_device( 'mobile' );
            return $args;
        }

        public static function filter_public_localize_script_extra( $args ) {
            $args[ 'is_mobile_tablet' ] = PT_CV_Functions_Pro::check_device( 'mobile_tablet' );
            $args[ 'sf_no_post_found' ] = PT_CV_Html::no_post_found();
            return $args;
        }

        /**
         * Format 2 columns: Exclude fields from wrapping
         * @param type $args
         * @return type
         */
        public static function filter_2col_nowrap_fields( $args ) {
            if ( PT_CV_Html_ViewType_Pro::ancient_timeline() ) {
                $args[] = 'title';
                $args[] = 'meta-fields';
            }

            return $args;
        }

        public static function filter_posts_orderby( $args, $query ) {
            $query_args = PT_CV_Functions::get_global_variable( 'args' );
            if ( $query->get( 'by_contentviews' ) ) {
                $mto  = PT_CV_Functions::get_global_variable( 'meta_query_origin' );
                $cmto = is_array( $mto ) ? count( $mto ) : 0;

                if ( isset( $query_args[ PT_CV_PREFIX . 'orp' ] ) ) {
                    // Fix: duplicated posts when order randonly & pagination
                    global $pt_cv_id;
                    $transient = 'cvp_seed_' . $pt_cv_id;

                    // Reset seed on first page
                    if ( PT_CV_Functions::get_global_variable( 'current_page' ) === 1 ) {
                        delete_transient( $transient );
                    }

                    // Get seed
                    $seed = get_transient( $transient );
                    if ( empty( $seed ) ) {
                        $seed = rand();
                        set_transient( $transient, $seed, 30 * MINUTE_IN_SECONDS );
                    }

                    $args = "RAND($seed)";
                } elseif ( isset( $query_args[ PT_CV_PREFIX . 'ctf_sort_dfm' ] ) ) {
                    global $wpdb;
                    foreach ( $query_args[ PT_CV_PREFIX . 'ctf_sort_dfm' ] as $idx => $value ) {
                        $num     = $cmto + $idx;
                        $tb_name = ($num === 0) ? $wpdb->postmeta : "mt{$num}";
                        $args    = preg_replace( "/CAST\($tb_name\.meta_value AS (DATE|DATETIME)\)/", "STR_TO_DATE($tb_name.meta_value, '$value')", $args );
                    }
                } elseif ( isset( $query_args[ PT_CV_PREFIX . 'ctftcm' ] ) ) {
                    global $wpdb;
                    foreach ( $query_args[ PT_CV_PREFIX . 'ctftcm' ] as $idx => $value ) {
                        $num     = $cmto + $idx;
                        $tb_name = ($num === 0) ? $wpdb->postmeta : "mt{$num}";
                        $args    = preg_replace( "/CAST\($tb_name\.meta_value AS SIGNED\)/", "CAST(REPLACE($tb_name.meta_value,',','') AS SIGNED)", $args );
                    }
                } elseif ( isset( $query_args[ PT_CV_PREFIX . 'human_sort' ] ) ) {
                    global $wpdb;
                    $args = str_replace( "$wpdb->posts.post_title", "LENGTH($wpdb->posts.post_title), $wpdb->posts.post_title", $args );
                }
            }

            return $args;
        }

        public static function filter_posts_where( $args, $query ) {
            $query_args = PT_CV_Functions::get_global_variable( 'args' );
            if ( $query->get( 'by_contentviews' ) ) {
                if ( isset( $query_args[ PT_CV_PREFIX . 'ctf_filter_dfm' ] ) ) {
                    global $wpdb;
                    foreach ( $query_args[ PT_CV_PREFIX . 'ctf_filter_dfm' ] as $idx => $value ) {
                        $tb_name = ($idx === 0) ? $wpdb->postmeta : "mt{$idx}";
                        if ( $value === '_UNIX_TIMESTAMP_' ) {
                            $dfm  = '%Y-%m-%d' . (preg_match( "/CAST\($tb_name\.meta_value AS DATETIME\)/", $args ) ? ' %H-%i-%s' : '');
                            $args = preg_replace( "/CAST\($tb_name\.meta_value AS (DATE|DATETIME)\)/", "FROM_UNIXTIME($tb_name.meta_value, '$dfm')", $args );
                        } else {
                            $args = preg_replace( "/CAST\($tb_name\.meta_value AS (DATE|DATETIME)\)/", "STR_TO_DATE($tb_name.meta_value, '$value')", $args );
                        }
                    }
                }
            }

            return $args;
        }

        /**
         * Store data of embed video for lazy load
         */
        public static function filter_oembed_dataparse( $return, $data, $url ) {
            if ( PT_CV_Functions::get_global_variable( 'do-lazy-load' ) ) {
                global $cvp_oembed_data;
                $cvp_oembed_data = $data;
            }

            return $return;
        }

        /**
         * Make images lazy-loadable: replace src, srset attributes, add lazy class
         *
         * @param type $attr
         * @param type $attachment
         * @param type $size
         * @return string
         */
        public static function filter_wp_get_attachment_image_attributes( $attr, $attachment = null, $size = null ) {
            if ( empty( $GLOBALS[ 'cvp_prevent_lazyload' ] ) && PT_CV_Functions::get_global_variable( 'do-lazy-load' ) ) {
                $attr[ 'data-cvpsrc' ] = apply_filters( PT_CV_PREFIX_ . 'lazy_load_src', $attr[ 'src' ] );
                $attr[ 'src' ]         = plugins_url( 'public/assets/images/lazy_image.png', PT_CV_FILE_PRO );
                $attr[ 'class' ]       .= ' cvplazy';

                // a valid srcset must contain space
                if ( !empty( $attr[ 'srcset' ] ) && preg_match( '/\s+/', $attr[ 'srcset' ] ) ) {
                    $attr[ 'data-cvpset' ] = $attr[ 'srcset' ];
                    unset( $attr[ 'srcset' ] );
                    unset( $attr[ 'sizes' ] );
                }
            }

            /**
             * Asign post title for Featured image, if empty
             * @since 4.6.0
             */
            global $cvp_process_settings, $post;
            if ( $cvp_process_settings && empty( $attr[ 'alt' ] ) && !empty( $post->post_title ) ) {
                $attr[ 'alt' ] = apply_filters( PT_CV_PREFIX_ . 'alt_for_image', $post->post_title );
            }

            return $attr;
        }

        /**
         * Reuse a View
         * operator: IN (default), AND, NOT IN
         * relation: AND, OR
         *
         * [pt_view id="A" author=1]
         * [pt_view id="A" cat="foo,bar,content"]
         * [pt_view id="A" tag="foo,bar,content"]
         * [pt_view id="A" cat="1,2,3" field=id]
         * [pt_view id="A" tag="1,2,3" field=id]
         * [pt_view id="A" tag="666" field="slug"] # for numeric value
         * [pt_view id="A" taxonomy="testimonial" terms="foo,bar"]
         * [pt_view id="A" taxonomy="testimonial" terms="foo,bar" operator="NOT IN"]
         * [pt_view id="A" cat="foo,bar" tag="1,2" relation="AND" ] // don't support "operator" of multiple taxonomies
         * [pt_view id="A" taxonomy="testimonial" terms="foo,bar" taxonomy2="customer" terms2="boo,far"] @since 1.8.9
         *
         * @param array $args
         *
         * @return int
         */
        public static function reuse_view( $args ) {
            $sc_params = PT_CV_Functions::get_global_variable( 'shortcode_params' );
            if ( !$sc_params ) {
                return $args;
            }

            $cur_pid = get_queried_object_id();
            $reuse   = 0;

            // Store taxonomy filter query parameters
            $taxonomies = $terms      = array();

            if ( !empty( $sc_params[ 'cat' ] ) ) {
                $taxonomies[] = 'category';
                $terms[]      = explode( ',', trim( $sc_params[ 'cat' ] ) );
            }

            if ( !empty( $sc_params[ 'tag' ] ) ) {
                $taxonomies[] = 'post_tag';
                $terms[]      = explode( ',', trim( $sc_params[ 'tag' ] ) );
            }

            if ( !empty( $sc_params[ 'taxonomy' ] ) ) {
                $taxonomies[] = cv_esc_sql( $sc_params[ 'taxonomy' ] );
                $terms[]      = explode( ',', trim( $sc_params[ 'terms' ] ) );
            }

            if ( !empty( $sc_params[ 'taxonomy2' ] ) ) {
                $taxonomies[] = cv_esc_sql( $sc_params[ 'taxonomy2' ] );
                $terms[]      = explode( ',', trim( $sc_params[ 'terms2' ] ) );
            }

            if ( $taxonomies && $terms ) {
                $filter_taxonomies = array();

                // Get operator
                $operator = !empty( $sc_params[ 'operator' ] ) ? strtoupper( $sc_params[ 'operator' ] ) : 'IN';
                if ( !in_array( $operator, array( 'IN', 'NOT IN', 'AND' ) ) ) {
                    $operator = 'IN';
                }

                $_field = !empty( $sc_params[ 'field' ] ) ? $sc_params[ 'field' ] : 'slug';

                // Generate array of filter parameters
                foreach ( $taxonomies as $idx => $taxonomy ) {
                    // Term of taxonomy
                    $term = (array) $terms[ $idx ];

                    // Filter by id or slug
                    $terms_check = array_map( 'intval', $term );
                    $field       = $_field ? $_field : ( ( $terms_check[ 0 ] != 0 ) ? 'id' : 'slug' );

                    // Get terms of current post
                    if ( isset( $term[ 0 ] ) && $term[ 0 ] === 'GET_CURRENT' ) {
                        $term = cvp_get_same_terms( $taxonomy );
                        if ( $term ) {
                            $field = 'id';

                            if ( !empty( $cur_pid ) ) {
                                $args[ 'post__not_in' ] = array_merge( (array) $args[ 'post__not_in' ], array( $cur_pid ) );
                            }
                        }
                    }

                    // Get current term
                    if ( isset( $term[ 0 ] ) && $term[ 0 ] === 'GET_CURRENT_TERM' ) {
                        $qobj = get_queried_object();
                        if ( isset( $qobj->term_id ) ) {
                            $term  = $qobj->term_id;
                            $field = 'id';
                        }
                    }

                    // Able to use operator2, operator3, operator4
                    if ( $idx > 0 && !empty( $sc_params[ 'operator' . ($idx + 1) ] ) ) {
                        $operator = strtoupper( $sc_params[ 'operator' . ($idx + 1) ] );
                        if ( !in_array( $operator, array( 'IN', 'NOT IN', 'AND' ) ) ) {
                            $operator = 'IN';
                        }
                    }

                    $filter_taxonomies[] = array(
                        'taxonomy'         => $taxonomy,
                        'field'            => $field,
                        'terms'            => $term,
                        'operator'         => $operator,
                        'include_children' => apply_filters( PT_CV_PREFIX_ . 'include_children', $operator == 'AND' ? false : true )
                    );
                }

                // Multiple taxonomies filter
                if ( count( $taxonomies ) > 1 ) {
                    // Get relation
                    $relation = strtoupper( !empty( $sc_params[ 'relation' ] ) ? $sc_params[ 'relation' ] : 'AND' );

                    if ( !in_array( $relation, array( 'OR', 'AND' ) ) ) {
                        $relation = 'AND';
                    }

                    $filter_taxonomies[ 'relation' ] = $relation;
                }

                if ( $filter_taxonomies ) {
                    if ( empty( $sc_params[ 'reuse_tax_query' ] ) || empty( $args[ 'tax_query' ] ) ) {
                        $args[ 'tax_query' ] = $filter_taxonomies;
                    } else {
                        $args[ 'tax_query' ] = array_merge( $args[ 'tax_query' ], $filter_taxonomies );
                    }

                    $reuse++;
                }
            }

            if ( !empty( $sc_params[ 'post_id' ] ) ) {
                $values = explode( ',', trim( $sc_params[ 'post_id' ] ) );

                if ( $values[ 0 ] === 'GET_CURRENT' && !empty( $cur_pid ) ) {
                    $values = array( $cur_pid );
                }

                if ( is_array( $values ) ) {
                    $args[ 'post__in' ] = array_map( 'intval', $values );
                    $reuse++;
                }
            }

            if ( !empty( $sc_params[ 'author' ] ) ) {
                $values               = explode( ',', trim( $sc_params[ 'author' ] ) );
                $args[ 'author__in' ] = array_map( 'intval', $values );
                $reuse++;
            }

            if ( !empty( $sc_params[ 'post_type' ] ) ) {
                $args[ 'post_type' ] = $sc_params[ 'post_type' ];
                $reuse++;
            }

            if ( !empty( $sc_params[ 'post_parent' ] ) ) {
                $parent = $sc_params[ 'post_parent' ];
                if ( $parent === 'GET_CURRENT' && !empty( $cur_pid ) ) {
                    $parent = $cur_pid;
                }

                $args[ 'post_parent__in' ] = array_map( 'intval', explode( ',', $parent ) );
                unset( $args[ 'post_parent' ] );
                $reuse++;
            }

            if ( !empty( $sc_params[ 'keyword' ] ) ) {
                $args[ 's' ] = $sc_params[ 'keyword' ];
                $reuse++;
            }

            if ( !empty( $sc_params[ 'custom_field_value' ] ) ) {
                $values = explode( ',', $sc_params[ 'custom_field_value' ] );
                foreach ( $values as $idx => $value ) {
                    if ( isset( $args[ 'meta_query' ][ $idx ][ 'value' ] ) && $args[ 'meta_query' ][ $idx ][ 'value' ] !== '' ) {
                        $args[ 'meta_query' ][ $idx ][ 'value' ] = $value;
                        $reuse++;
                    }
                }
            }

            if ( !empty( $sc_params[ 'limit' ] ) || !empty( $sc_params[ 'offset' ] ) ) {
                $reuse++;
            }

            if ( $reuse ) {
                PT_CV_Functions::set_global_variable( 'reused_view', true );
            }

            do_action( PT_CV_PREFIX_ . 'custom_view_parameters' );

            return $args;
        }

        /**
         * Print style of views
         */
        public static function action_print_view_style() {
            $dargs = PT_CV_Functions::get_global_variable( 'dargs' );
            if ( !isset( $dargs ) ) {
                return '';
            }

            ob_start();

            $style_fonts = PT_CV_Html_Pro::view_styles( $dargs[ 'view-style' ] );

            // Print inline style (font family, font style, font size...)
            if ( !empty( $style_fonts[ 'css' ] ) ) {
                printf( PT_CV_Html::inline_style( $style_fonts[ 'css' ] ) );
            }

            // Attach link of google fonts if have
            if ( $style_fonts && is_array( $style_fonts[ 'links' ] ) ) {
                foreach ( $style_fonts[ 'links' ] as $link ) {
                    $view_fonts = (array) PT_CV_Functions::get_global_variable( 'included-fonts' );

                    if ( !in_array( $link, $view_fonts ) ) {
                        printf( "<link href='//fonts.googleapis.com/css?family=%s' rel='stylesheet' type='text/css'>", urlencode( $link ) );
                        $view_fonts[] = $link;
                        PT_CV_Functions::set_global_variable( 'included-fonts', $view_fonts );
                    }
                }
            }

            $view_style = ob_get_clean();

            if ( apply_filters( PT_CV_PREFIX_ . 'inline_view_style', 1 ) ) {
                echo $view_style;
            } else {
                global $cvp_view_css;
                if ( !$cvp_view_css ) {
                    $cvp_view_css = array();
                }
                $cvp_view_css[] = $view_style;
            }
        }

        /**
         * Filter before run query
         */
        public static function action_before_query() {
            $action = 'add_filter';
            self::_abq_product( $action );
        }

        /**
         * Filter after run query
         *
         */
        public static function action_after_query() {
            $action = 'remove_filter';
            self::_abq_product( $action );
        }

        private static function _abq_product( $function ) {
            $view_settings = PT_CV_Functions::get_global_variable( 'view_settings' );
            $content_type  = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'content-type', $view_settings );

            if ( $content_type === 'product' ) {
                $products_list = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'products-list', $view_settings );
                if ( $products_list === 'top_rated_products' ) {
                    $function( 'posts_clauses', array( 'PT_CV_WooCommerce', 'order_by_rating_post_clauses' ) );
                }
            }
        }

        /**
         * Add custom global variables
         */
        public static function action_add_global_variables() {
            $enabled_shuffle = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'enable-taxonomy-filter' ) && PT_CV_Functions_Pro::check_dependences( 'taxonomy-filter' );
            PT_CV_Functions::set_global_variable( 'enable_shuffle_filter', $enabled_shuffle );

            if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'show-field-format-icon' ) ) {
                PT_CV_Functions::set_global_variable( 'dashicons', 1 );
            }

            $do_lazy = apply_filters( PT_CV_PREFIX_ . 'do_lazy_image', PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-thumbnail-lazyload' ) );
            PT_CV_Functions::set_global_variable( 'do-lazy-load', $do_lazy );

            $collapsible_shuffle = $enabled_shuffle && PT_CV_Functions::get_global_variable( 'view_type' ) === 'collapsible';
            PT_CV_Functions::set_global_variable( 'collapsible_shuffle', $collapsible_shuffle );
        }

        /**
         * Enqueue special assets on the fly
         */
        public static function action_enqueue_assets() {
            if ( PT_CV_Functions::get_global_variable( 'dashicons' ) ) {
                wp_enqueue_style( 'dashicons' );
            }
        }

        /**
         * Append HTML to post title
         *
         * @param string $args  The excerpt output
         * @param int   $post Post object
         *
         * @return string
         */
        public static function action_item_extra_html( $post ) {
            echo PT_CV_Functions_Pro::show_edit_button( $post );
        }

        public static function action_view_process_start() {
            global $cvp_process_settings;
            $cvp_process_settings = true;
        }

        /**
         * Flush view data if not needed, or cause conflicts
         */
        public static function action_view_process_end() {
            PT_CV_Functions::set_global_variable( 'do-lazy-load', 0 );

            global $cvp_process_settings;
            $cvp_process_settings = false;
        }

        private static function _is_attachment( $post ) {
            return get_post_type( $post->ID ) === 'attachment';
        }

    }

}
