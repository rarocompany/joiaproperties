<?php
/**
 * @author PT Guy https://www.contentviewspro.com/
 * @since 4.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_admin() ) {
	add_filter( 'pll_get_post_types', 'cvp_pll_get_post_types', 999, 2 );
	add_action( 'edit_form_after_title', 'cvp_pll_action_edit_form_after_title', 999 );
	add_action( 'parse_query', 'cvp_pll_parse_query', 9 );
	add_filter( PT_CV_PREFIX_ . 'modify_post_url', 'cvp_pll_filter_modify_post_url' );
	add_filter( PT_CV_PREFIX_ . 'view_post_id', 'cvp_pll_filter_view_post_id' );
	add_filter( PT_CV_PREFIX_ . 'view_row_actions', 'cvp_pll_view_row_actions', 999, 2 );
}
function cvp_pll_is_activated() {
	return PT_CV_Functions_Pro::has_translation_plugin() === 'Polylang';
}

function cvp_pll_action_edit_form_after_title( $post ) {
	$post_type = PT_CV_Functions::admin_current_post_type();
	if ( $post_type === PT_CV_POST_TYPE && cvp_pll_is_activated() ) {
		if ( !empty( $_REQUEST[ 'post' ] ) ) {
			$extra_params	 = array();
			$view_id		 = get_post_meta( $post->ID, PT_CV_META_ID );

			if ( !empty( $view_id[ 0 ] ) ) {
				$extra_params[ 'id' ] = $view_id[ 0 ];
			} else {
				$extra_params[ 'post_id' ] = $post->ID;
			}
			$extra_params[ 'lang' ] = pll_get_post_language( $post->ID );

			$edit_link	 = admin_url( 'admin.php?page=' . PT_CV_DOMAIN . '-add' );
			$edit_link	 = add_query_arg( $extra_params, $edit_link );

			printf( '<br><center><a class="button button-primary button-large" href="%s">%s</a></center>', $edit_link, __( "[Content Views] Filter Posts Now", 'content-views-pro' ) );
		}
	}
}

/**
 * Issue:
 * Can't get $post_id (=> language) of translation View in cvp_pll_filter_view_link_args()
 * For example: /wp-admin/edit.php?post_type=pt_view&lang=en, In column of other languages, can get VIEW ID, but empty View language
 *
 * Effect:
 * When edit translation Views, CVP will not able to show saved settings
 *
 * @param type $query
 */
function cvp_pll_parse_query( $query ) {
	$post_type = PT_CV_Functions::admin_current_post_type();
	if ( $post_type === PT_CV_POST_TYPE && cvp_pll_is_activated() ) {
		$screen = get_current_screen();
		if ( isset( $screen->id ) && $screen->id === PT_CV_POST_TYPE ) {
			remove_action( 'parse_query', array( 'PLL_Admin_Filters_Post', 'parse_query' ), 10 );
		}
	}
}

function cvp_pll_filter_modify_post_url( $args ) {
	if ( cvp_pll_is_activated() ) {
		if ( !empty( $_REQUEST[ 'from_post' ] ) && !empty( $_REQUEST[ 'new_lang' ] ) ) {
			$args = false;
		}

		if ( !empty( $_REQUEST[ 'action' ] ) && $_REQUEST[ 'action' ] == 'editpost' ) {
			if ( !empty( $_REQUEST[ 'post_lang_choice' ] ) ) {
				$args = false;
			}
		}
	}

	return $args;
}

function cvp_pll_filter_view_post_id( $args ) {
	if ( !empty( $_REQUEST[ 'post_id' ] ) ) {
		$args = intval( $_REQUEST[ 'post_id' ] );
	}

	return $args;
}

function cvp_pll_view_row_actions( $args, $view_id ) {
	if ( cvp_pll_is_activated() ) {
		$post_id = PT_CV_Functions::post_id_from_meta_id( $view_id );
		if ( $post_id ) {
			$link					 = 'post.php?post=' . $post_id;
			$action					 = '&amp;action=edit';
			$link					 = admin_url( $link . $action );
			$args[ 'pll_edit_post' ] = '<a href="' . $link . '" target="_blank">' . __( 'Edit Language', 'content-views-pro' ) . '</a>';
		}
	}

	return $args;
}

# Add language to View link
add_filter( PT_CV_PREFIX_ . 'view_link_args', 'cvp_pll_filter_view_link_args' );
function cvp_pll_filter_view_link_args( $args ) {
	if ( cvp_pll_is_activated() ) {
		if ( !empty( $args[ 'id' ] ) ) {
			$post_id = PT_CV_Functions::post_id_from_meta_id( $args[ 'id' ] );
			if ( $post_id ) {
				$post_lang = pll_get_post_language( $post_id );
				if ( $post_lang ) {
					$args[ 'lang' ] = $post_lang;
				}
			}
		}
	}
	return $args;
}

# Show language columns in All Views page
function cvp_pll_get_post_types( $post_types, $is_settings ) {
	/**
	 * @since 5.7.0
	 * Fix View not found in Ajax pagination
	 */
	if ( !(defined( 'DOING_AJAX' ) && DOING_AJAX) ) {
		$post_types[] = PT_CV_POST_TYPE;
	}

	return $post_types;
}
