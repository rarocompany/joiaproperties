<?php
/*
 * Move all custom code here, instead of requiring users to add to theme file
 * @since 4.5.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	die;
}

// Custom url for post
add_filter( 'pt_cv_field_href', 'cvp_cc_use_custom_url', 100, 2 );
function cvp_cc_use_custom_url( $href, $post ) {
	// If have not executed filter in theme
	if ( !has_filter( 'pt_cv_field_href', 'my_field_href' ) && apply_filters( PT_CV_PREFIX_ . 'enable_custom_url', true ) ) {
		if ( !isset( $post->cvp_custom_url ) ) {
			$meta = get_post_meta( $post->ID );

			$custom_href = 0;
			# WordPress, ACF
			if ( !empty( $meta[ 'cv_custom_url' ][ 0 ] ) ) {
				$custom_href = $meta[ 'cv_custom_url' ][ 0 ];
			}
			# Types
			if ( !$custom_href && !empty( $meta[ 'wpcf-cv_custom_url' ][ 0 ] ) ) {
				$custom_href = $meta[ 'wpcf-cv_custom_url' ][ 0 ];
			}

			$post->cvp_custom_url = $custom_href;
		}

		if ( !empty( $post->cvp_custom_url ) ) {
			# Add site URL to relative value, for example: /page1
			if ( !filter_var( $post->cvp_custom_url, FILTER_VALIDATE_URL ) ) {
				$post->cvp_custom_url = get_site_url() . $post->cvp_custom_url;
			}

			$href = esc_url( apply_filters( PT_CV_PREFIX_ . 'custom_href_url', $post->cvp_custom_url ) );
		}
	}

	return $href;
}

// Use custom field as thumbnail
add_filter( 'pt_cv_field_content_excerpt', 'cvp_cc_custom_field_as_thumbnail', 999, 3 );
function cvp_cc_custom_field_as_thumbnail( $args, $fargs, $post ) {
	$display_what	 = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-thumbnail-auto', null, 'image' );
	$custom_field	 = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-thumbnail-ctf' );
	if ( empty( $fargs ) && $display_what === 'image-ctf' && !empty( $custom_field ) ) {
		$fval = null;
		if ( class_exists( 'CVP_CTF' ) ) {
			$ctf = new CVP_CTF( $custom_field, $post, true, '' );
			if ( !empty( $ctf->field_value ) ) {
				$fval = $ctf->field_value;
			}
		}

		if ( empty( $fval ) ) {
			$meta = get_post_meta( $post->ID );
			if ( !empty( $meta[ $custom_field ][ 0 ] ) ) {
				$fval = $meta[ $custom_field ][ 0 ];
			}
		}

		if ( $fval ) {
			// Get image url from id
			if ( is_numeric( $fval ) ) {
				$image_url	 = wp_get_attachment_url( (int) $fval );
				$fval		 = $image_url ? $image_url : $fval;
			}

			$args = sprintf( "<img src='%s'>", $fval );
		}
	}

	return $args;
}
