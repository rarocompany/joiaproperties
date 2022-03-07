<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Fix FB share wrong image
 * @since 3.9.4
 */
add_action( 'wp_head', 'cvp_troubleshoot_fb_share_wrong_img', 100 );
function cvp_troubleshoot_fb_share_wrong_img() {
    $fix_fb_share = PT_CV_Functions::get_option_value( 'fb_share_wrong_image' );
    if ( $fix_fb_share ) {
        global $post;
        $attachment_url = '';
        if ( is_singular() ) {
            $attachment_id  = is_attachment() ? $post->ID : get_post_thumbnail_id( $post->ID );
            $attachment_url = wp_get_attachment_url( $attachment_id );

            if ( empty( $attachment_url ) ) {
                $attachment_url = PT_CV_Hooks_Pro::get_inside_image( $post, 'full', $post->post_content );
            }
        }

        if ( $attachment_url ) {
            printf( '<meta property="og:image" content="%s"/>', esc_url( $attachment_url ) );
        }
    }
}

add_action( PT_CV_PREFIX_ . 'before_query', 'cvp_troubleshoot_action_before_query' );
add_action( PT_CV_PREFIX_ . 'after_query', 'cvp_troubleshoot_action_after_query' );
function cvp_troubleshoot_action_before_query() {
    cvp_troubleshoot_action___query( 'remove' );
}

function cvp_troubleshoot_action_after_query() {
    cvp_troubleshoot_action___query( 'add' );
}

function cvp_troubleshoot_action___query( $function ) {

	$hooks = array(
		// 'key' => array($tag, $function_to_add, $priority = 10, $accepted_args = 1)
		
		/* Fix: invalid output because of query was modified by plugin "Woocommerce Exclude Categories PRO"
		 * @since 4.2
		 */
		'a1' => array( 'pre_get_posts', 'wctm_pre_get_posts_query' ),

		/** Fix: The Events Calendar with WPML (when suppress filter = false), the event plugin injects code to show only upcoming events,
		 * which causes the View to show past events doesn't work
		 * @since 5.3.4
		 */
		'a2' => array( 'parse_query', array( 'Tribe__Events__Query', 'parse_query' ), 50 ),
		'a3' => array( 'pre_get_posts', array( 'Tribe__Events__Query', 'pre_get_posts' ), 50 ),

		/** Plugin Relevanssi causes "No posts found" in search page using replace layout
		 * @since 5.6.0
		 */
		'f1' => array( 'posts_request', 'relevanssi_prevent_default_request', 10, 2 ),
		'f2' => array( 'the_posts', 'relevanssi_query', 99, 2 ),
	);

	// List of hooks to add back
	global $cvp_removed_hooks;
	if ( !isset( $cvp_removed_hooks ) ) {
		$cvp_removed_hooks = array();
	}

	foreach ( $hooks as $idx => $arr ) {
		$priority = isset( $arr[ 2 ] ) ? $arr[ 2 ] : 10;

		// remove: if has_action/filter => remove_action() + backup to add back later
		if ( $function === 'remove' && false !== has_action( $arr[ 0 ], $arr[ 1 ] ) ) {
			remove_action( $arr[ 0 ], $arr[ 1 ], $priority );
			$cvp_removed_hooks[] = $idx;
		}

		// add: if existing in backup => add_action()
		if ( $function === 'add' && in_array( $idx, $cvp_removed_hooks ) ) {
			$accepted_args = isset( $arr[ 3 ] ) ? $arr[ 3 ] : 1;
			add_action( $arr[ 0 ], $arr[ 1 ], $priority, $accepted_args );
		}
	}
}

/**
 * Fix conflict with Photon feature of Jetpack plugin: thumbnail is not visible in mobile devices, when enable lazyload
 * @since 4.3.1
 */
add_filter( 'jetpack_photon_skip_for_url', 'cvp_jetpack_photon_skip_for_url', 100, 4 );
function cvp_jetpack_photon_skip_for_url( $skip, $image_url, $args, $scheme ) {
    if ( strpos( $image_url, 'lazy_image.png' ) !== false ) {
        $skip = true;
    }

    return $skip;
}

/**
 * "Search Everything" plugin
 * Issue: Replace Layout in Taxonomy Archives doesn't work
 * @since 4.6.0
 */
add_action( 'pre_get_posts', 'cvp_comp_plugin_searcheverything' );
function cvp_comp_plugin_searcheverything( $query ) {
    if ( $query->get( 'by_contentviews' ) && class_exists( 'SearchEverything' ) && !empty( $GLOBALS[ 'wp_filter' ][ 'posts_search' ][ 10 ] ) ) {
        $arr = (array) $GLOBALS[ 'wp_filter' ][ 'posts_search' ][ 10 ];
        foreach ( array_keys( $arr ) as $filter ) {
            if ( strpos( $filter, 'se_search_where' ) !== false ) {
                remove_filter( 'posts_search', $filter );
            }
        }
    }

    return $query;
}

/**
 * Prevent effect of Lazyload to [gallery]
 * Especially, when this shortcode was executed in 'field_content_excerpt' before get_inside_image()
 */
add_filter( 'the_content', 'cvp_start_gallery_shortcode', 1 );
add_filter( 'the_content', 'cvp_end_gallery_shortcode', 9999 );
function cvp_start_gallery_shortcode( $content ) {
    if ( preg_match( '/\[gallery[^\]]+\]/', $content ) ) {
        $GLOBALS[ 'cvp_prevent_lazyload' ] = true;
    }
    return $content;
}

function cvp_end_gallery_shortcode( $content ) {
    if ( preg_match( '/\[gallery[^\]]+\]/', $content ) ) {
        $GLOBALS[ 'cvp_prevent_lazyload' ] = false;
    }
    return $content;
}

/**
 * Fix issues caused by lazyload of theme or another plugin
 */
add_filter( 'wp_get_attachment_image_attributes', 'cvp_comp_prevent_other_lazyload', 9, 3 );
add_filter( 'cvp_get_attachment_image_attributes', 'cvp_comp_prevent_other_lazyload', 9, 3 );
function cvp_comp_prevent_other_lazyload( $attr, $attachment = null, $size = null ) {
	global $cvp_process_settings;
	if ( $cvp_process_settings ) {
		if ( function_exists( 'cv_is_active_plugin' ) && (cv_is_active_plugin( 'wp-rocket' ) || cv_is_active_plugin( 'litespeed-cache' )) ) {
			$attr[ 'data-no-lazy' ] = 1;
		}

		if ( strtolower( get_template() ) === 'enfold' ) {
			$attr[ 'class' ] .= ' noLightbox ';
		}

		if ( strtolower( get_template() ) === 'avada' ) {
			$attr[ 'class' ] .= ' lazyload ';
		}

		// Smush by WPMU DEV
		$attr[ 'class' ] .= ' no-lazyload ';
	}

	return $attr;
}

/**
 * Get image inside post content, for Visual Composer plugin
 * @since 4.7.1
 *
 * @5.7.1 Might remove below complex code, then use the solution as cv_comp_get_full_content()
 */
add_filter( PT_CV_PREFIX_ . 'field_content_excerpt', 'cvp_comp_plugin_visual_composer_image_content', 100, 3 );
function cvp_comp_plugin_visual_composer_image_content( $args, $fargs, $post ) {
    // Run only when extracting image in content
    if ( empty( $fargs ) ) {
        if ( class_exists( 'WPBMap' ) && method_exists( 'WPBMap', 'addAllMappedShortcodes' ) ) {
            // Prevent lazyload from applying to VC image, which makes lazyload get & show its lazy image instead of VC image
            $GLOBALS[ 'cvp_prevent_lazyload' ] = true;

            WPBMap::addAllMappedShortcodes();
            $args = do_shortcode( $args );

            $GLOBALS[ 'cvp_prevent_lazyload' ] = false;
        }
    }

    return $args;
}

/**
 * Woocommerce double read-more buttons, if product is not purchasable or out of stock
 */
add_filter( 'woocommerce_loop_add_to_cart_link', 'cvp_comp_plugin_woocommerce_double_readmore', 999, 2 );
function cvp_comp_plugin_woocommerce_double_readmore( $link, $product ) {
    global $cvp_process_settings;
    if ( $cvp_process_settings ) {
        if ( strpos( $link, __( 'Read more', 'woocommerce' ) ) !== false ) {
            $dargs = PT_CV_Functions::get_global_variable( 'dargs' );
            // Hide Woocommerce readmore, if enabled CVPRO readmore
            if ( !empty( $dargs[ 'field-settings' ][ 'content' ] ) && $dargs[ 'field-settings' ][ 'content' ][ 'show' ] === 'excerpt' && isset( $dargs[ 'field-settings' ][ 'content' ][ 'readmore' ] ) ) {
                $link = '';
            }
        }
    }

    return $link;
}

/** List of features which renders layout dynamically
 *
 * @return type
 */
function _cvp_comp_common_dynamic_layout_features() {
    $view_type = PT_CV_Functions::get_global_variable( 'view_type' );
    $glp       = ('grid' === $view_type) && PT_CV_Functions::setting_value( PT_CV_PREFIX . 'grid-same-height' );
    return in_array( $view_type, array( 'pinterest', 'masonry' ) ) || PT_CV_Functions::setting_value( PT_CV_PREFIX . 'enable-taxonomy-filter' ) || $glp;
}

/**
 * Disable WP responsive image feature to prevent layout issues
 * @since 4.9.0
 */
add_filter( PT_CV_PREFIX_ . 'disable_responsive_image', 'cvp_comp_fix_pinterest_issue' );
function cvp_comp_fix_pinterest_issue( $args ) {
    if ( _cvp_comp_common_dynamic_layout_features() ) {
        $args = true;
    }

    return $args;
}

/**
 * Convert term slug to id, to be translated automatically
 * @since 4.9.0
 */
add_filter( PT_CV_PREFIX_ . 'query_parameters', 'cvp_comp_terms_slug_to_id', 9999 );
function cvp_comp_terms_slug_to_id( $params ) {
    $tplugin = PT_CV_Functions_Pro::has_translation_plugin();
    if ( !$tplugin ) {
        return $params;
    }

    if ( !empty( $params[ 'tax_query' ] ) ) {
        foreach ( $params[ 'tax_query' ] as $key => $tax ) {
            if ( !isset( $tax[ 'terms' ], $tax[ 'taxonomy' ] ) ) {
                continue;
            }

            if ( !is_array( $tax[ 'terms' ] ) ) {
                continue;
            }

            // Leverage the WP filter 'get_terms_args' to translate terms automatically
            $tids = array();
            foreach ( $tax[ 'terms' ] as $term ) {
                $gterm = cvp_get_term_by_slug( $term, $tax[ 'taxonomy' ] );
                if ( $gterm ) {
                    $tids[] = $gterm->term_id;
                }
            }

            if ( $tids ) {
                $terms = get_terms( array(
                    'taxonomy'   => $tax[ 'taxonomy' ],
                    'include'    => $tids,
                    'hide_empty' => false,
                ) );

                if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
                    $new_terms = array();
                    foreach ( $terms as $term ) {
                        $new_terms[ $term->term_id ] = $term->slug;
                    }
                    $params[ 'tax_query' ][ $key ][ 'terms' ]       = array_keys( $new_terms );
                    $params[ 'tax_query' ][ $key ][ 'terms_slugs' ] = array_values( $new_terms );
                    $params[ 'tax_query' ][ $key ][ 'field' ]       = 'term_id';
                    PT_CV_Functions::set_global_variable( 'slug_to_id', true );
                }
            }
        }
    }

    if ( $tplugin === 'WPML' ) {
        foreach ( array( 'post__in', 'post__not_in' ) as $key ) {
            if ( !empty( $params[ $key ] ) ) {
                $tran_ids = array();
                foreach ( $params[ $key ] as $pid ) {
                    $tran_ids[] = icl_object_id( $pid, 'any' );
                }
                $params[ $key ] = $tran_ids;
            }
        }
    }

    return $params;
}

function cvp_get_term_by_slug( $value, $taxonomy ) {
    global $wpdb;
    $_field     = 't.slug';
    $tax_clause = $wpdb->prepare( "AND tt.taxonomy = %s", $taxonomy );
    $term       = $wpdb->get_row( $wpdb->prepare( "SELECT t.*, tt.* FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id WHERE $_field = %s", $value ) . " $tax_clause LIMIT 1" );
    return $term;
}

/**
 * a3 Lazy Load (1.8.2) prevents images from showing
 */
add_filter( 'a3_lazy_load_skip_images_classes', 'cvp_comp_plugin_a3lazyload' );
function cvp_comp_plugin_a3lazyload( $classes ) {
    $classes .= ',' . PT_CV_PREFIX . 'thumbnail';
    return $classes;
}

// Fix: Visual Composer's shortcodes are visible in Live Filter result
add_action( PT_CV_PREFIX_ . 'before_content', 'cvp_comp_plugin_visualcomposer', 9 );
function cvp_comp_plugin_visualcomposer() {
    if ( defined( 'CVP_LIVE_FILTER_RELOAD' ) && class_exists( 'WPBMap' ) && method_exists( 'WPBMap', 'addAllMappedShortcodes' ) ) {
        WPBMap::addAllMappedShortcodes();
    }
}

/** Support other plugins which require false suppress filters */
add_filter( PT_CV_PREFIX_ . 'query_parameters', 'cvp_comp_no_suppress_filters', 11 );
function cvp_comp_no_suppress_filters( $args ) {
    // Support Digital Access Pass (DAP) plugin, Ultimate Member plugin: Hide posts which users don't have access
    if ( shortcode_exists( 'DAP' ) || (function_exists( 'cv_is_active_plugin' ) && cv_is_active_plugin( 'ultimate-member' )) ) {
        $args[ 'suppress_filters' ] = false;
    }

    // Support CPT-onomies plugin: able to filter by taxonomies which created from post types
    if ( function_exists( 'cv_is_active_plugin' ) && cv_is_active_plugin( 'cpt-onomies' ) ) {
        $args[ 'suppress_filters' ] = false;
    }

    return $args;
}

/**
 * Fix: Shortcodes of Fresh Builder of Ark Theme is visible
 * (The theme registered only 4 shortcodes, other shortcodes are executed using custom function)
 *
 * @5.7.1 Might remove below complex code, then use the solution as cv_comp_get_full_content()
 */
add_filter( PT_CV_PREFIX_ . 'field_content_excerpt', 'cvp_comp_theme_ark', 999, 3 );
function cvp_comp_theme_ark( $content, $fargs, $post ) {
    if ( function_exists( 'ffContainer' ) && function_exists( 'getThemeFrameworkFactory' ) && function_exists( 'getThemeBuilderManager' ) && function_exists( 'renderButNotPrint' ) ) {
        $themeBuilderManager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderManager();
        $content             = $themeBuilderManager->renderButNotPrint( $content );
    }

    return $content;
}

/** Fix: When showing Media, its image is shown in full content, duplicate to thumbnail
 * @since 5.1.2
 */
add_action( PT_CV_PREFIX_ . 'before_content', 'cvp_comp_common_wp_attachment_in_content' );
function cvp_comp_common_wp_attachment_in_content() {
    remove_filter( 'the_content', 'prepend_attachment' );
}

/** Disable Jetpack modules
 * @since 5.1.2
 */
add_action( PT_CV_PREFIX_ . 'view_process_start', 'cvp_comp_disable_some_lazyload' );
function cvp_comp_disable_some_lazyload() {
    // Disable Jetpack carousel (which adds all image sizes to image data)
    add_filter( 'jp_carousel_maybe_disable', '__return_true' );

    // Disable Jetpack lazy-images (which causes blank thumbnail images)
    if ( class_exists( 'Jetpack_Lazy_Images' ) && method_exists( 'Jetpack_Lazy_Images', 'instance' ) ) {
        $jp = Jetpack_Lazy_Images::instance();
        $jp->remove_filters();
    }

    // Disable smart load of Hueman, Customizr theme which caused layout issue
    add_filter( 'hu_disable_img_smart_load', '__return_true', PHP_INT_MAX, 2 );
    add_filter( 'czr_disable_img_smart_load', '__return_true', PHP_INT_MAX, 2 );

    // Disable lazyload of Smush plugin
    // @since 5.7.0
    add_filter( 'smush_skip_image_from_lazy_load', '__return_true' );
}

/** Get thumbnail for the wpadverts plugin
 */
add_filter( PT_CV_PREFIX_ . 'field_content_excerpt', 'cvp_comp_plugin_wpadverts_get_thumbnail', 100, 3 );
function cvp_comp_plugin_wpadverts_get_thumbnail( $args, $fargs, $post ) {
    if ( empty( $fargs ) && function_exists( 'adverts_single_rslides' ) ) {
        ob_start();
        adverts_single_rslides( $post->ID );
        $args = ob_get_clean();
    }
    return $args;
}

/** Fix: With BJ Lazy Load plugin
 * @since 5.3
 */
add_action( PT_CV_PREFIX_ . 'add_global_variables', 'cvp_comp_plugin_bj_lazy_load', PHP_INT_MAX );
function cvp_comp_plugin_bj_lazy_load() {
    if ( PT_CV_Functions::get_global_variable( 'do-lazy-load' ) || _cvp_comp_common_dynamic_layout_features() ) {
        add_filter( 'bj_lazy_load_run_filter', '__return_false' );
    }
}

/** Force to reload live filter */
add_filter( PT_CV_PREFIX_ . 'extra_custom_js', 'cvp_comp_feature_lf_reload' );
function cvp_comp_feature_lf_reload( $args ) {
    // Live filter in reused View
    $lfrs = PT_CV_Functions::get_global_variable( 'reused_view' ) && PT_CV_Functions::get_global_variable( 'lf_enabled' );

    // Divi theme or plugin
    $divi = strtolower( get_template() ) === 'divi' || cv_is_active_plugin( 'divi-builder' );

    if ( $lfrs || $divi ) {
        $args = "window.cvp_lf_reload_url = true; \n" . $args;
    }
    return $args;
}

/** Get thumbnail from some specific plugins which don't use featured image
 */
add_filter( PT_CV_PREFIX_ . 'field_inside_image', 'cvp_comp_feature_get_thumbnail', PHP_INT_MAX, 3 );
function cvp_comp_feature_get_thumbnail( $img, $matches, $content ) {
    global $post;
    if ( empty( $img ) && isset( $post->ID ) ) {
        $mfield = array();
        if ( cv_is_active_plugin( 'novelist' ) ) {
            $mfield[] = 'novelist_cover';
        }
        if ( cv_is_active_plugin( 'ultimate-auction-pro' ) ) {
            $mfield[] = 'wdm_auction_thumb';
        }
        foreach ( $mfield as $ctf ) {
            $cover_id = get_post_meta( $post->ID, $ctf, true );
            if ( $cover_id ) {
                $img = wp_get_attachment_url( $cover_id );
                break;
            }
        }
    }

    return $img;
}

/** Fix color picker issue: not work with WP < 4.9, or with Nextgen Gallery 3.0 in WP > 4.9 */
add_filter( PT_CV_PREFIX_ . 'public_localize_script_extra', 'cvp_comp_feature_color_picker' );
function cvp_comp_feature_color_picker( $args ) {
    if ( is_admin() ) {
        // The old expression in admin "color-picker.js" mistakes with Nextgen Gallery 3.0 (which adds localize for wpColorPickerL10n)
        $args[ 'wp_before_49' ] = version_compare( $GLOBALS[ 'wp_version' ], '4.9', '<' );
    }

    return $args;
}

/** Remove unwanted styles/scripts from View page */
add_action( PT_CV_PREFIX_ . 'remove_unwanted_assets', 'cvp_comp_remove_unwanted_assets' );
function cvp_comp_remove_unwanted_assets() {
    /* "insert-post-ads" plugin, it modifies Color picker
     * cause JS error, prevent editing View settings
     */
    wp_dequeue_script( 'insert-post-adschart-admin' );
}

add_action( 'save_post', 'cvp_comp_prevent_redirect_on_saving_post', 1, 3 );
function cvp_comp_prevent_redirect_on_saving_post( $post_id, $post, $updated ) {
    /** With Yoast SEO plugin:
     * Add a View which show products (show add-to-cart link) to a new page, click publish
     * The process won't complete and stop at /wp-admin/post.php
     */
    remove_shortcode( 'add_to_cart' );
}

/** Pinterest/ Shuffle filter not output correctly on page load, in some themes */
add_filter( PT_CV_PREFIX_ . 'extra_custom_js', 'cvp_comp_feature_shuffle' );
function cvp_comp_feature_shuffle( $args ) {
    // X theme
    if ( strtolower( get_template() ) === 'x' ) {
        $args = "window.cvp_sf_fixdropcol = true; \n" . $args;
    }
    return $args;
}

/** Visual Composer footer is missing when adding View shortcode
 * Reason: $GLOBALS[ 'post' ] is not the current post/page,
 * but the hidden post which VC uses to store header/footer/sidebar settings
 * Solution: not restore that value
 * @since 5.6.0
 */
add_action( PT_CV_PREFIX_ . 'flushed_output', 'cvp_comp_plugin_vc_not_restore' );
function cvp_comp_plugin_vc_not_restore() {
    if ( isset( $GLOBALS[ 'cv_gpost_bak' ], $GLOBALS[ 'cv_gpost_bak' ]->post_type ) ) {
        if ( in_array( $GLOBALS[ 'cv_gpost_bak' ]->post_type, array( 'vcv_headers', 'vcv_footers', 'vcv_sidebars' ) ) ) {
            // To not restore this as global post
            unset( $GLOBALS[ 'cv_gpost_bak' ] );
        }
    }
}

/** Fix post__in, post__not_in can't be combine in the same query
 * (post__not_in is ignored when produce the query)
 * Run after cvp_comp_terms_slug_to_id() so ids were translated
 * @since 5.7.1
 */
add_filter( PT_CV_PREFIX_ . 'query_parameters', 'cvp_comp_core_in_not_in', 999999 );
function cvp_comp_core_in_not_in( $args ) {
	if ( !empty( $args[ 'post__in' ] ) && !empty( $args[ 'post__not_in' ] ) ) {
		$diff = array_diff( $args[ 'post__in' ], $args[ 'post__not_in' ] );
		if ( !empty( $diff ) ) {
			$args[ 'post__in' ] = $diff;
			unset( $args[ 'post__not_in' ] );
		}
	}

	return $args;
}
