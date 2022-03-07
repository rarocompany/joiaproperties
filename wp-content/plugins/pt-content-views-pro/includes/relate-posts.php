<?php
/**
 * @author PT Guy (https://www.contentviewspro.com/)
 * @copyright   Copyright (c) 2017, PT Guy
 * @since 4.4
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Get terms of current viewing post
 *
 * @param string $taxonomy Taxonomy slug
 */
function cvp_get_same_terms( &$taxonomy ) {
	global $post;

	// Get the first taxonomy of post, if don't want to set taxonomy of post
	if ( $taxonomy === 'GET_CURRENT' ) {
		$taxonomy_names = get_post_taxonomies( $post );
		if ( !empty( $taxonomy_names[ 0 ] ) ) {
			$taxonomy = $taxonomy_names[ 0 ];
		}
	}

	if ( !empty( $post->ID ) && !empty( $taxonomy ) ) {
		$terms = wp_get_post_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
		return !is_wp_error( $terms ) ? $terms : null;
	}

	return null;
}
