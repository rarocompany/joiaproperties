<?php
/*
 * List of utility functions
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Get list of Views
 * @since 4.6.0
 */
function cvp_get_view_list( $default = false ) {
	$result = array( '' => $default ? $default : __( '(Select View)', 'content-views-pro' ) );

	$query1 = new WP_Query( array(
		'post_type'		 => PT_CV_POST_TYPE,
		'posts_per_page' => -1
		) );

	if ( $query1->have_posts() ) {
		while ( $query1->have_posts() ) {
			$query1->the_post();

			$view_id = get_post_meta( get_the_ID(), PT_CV_META_ID, true );
			if ( $view_id ) {
				$result[ $view_id ] = get_the_title();
			}
		}
	}

	wp_reset_postdata();

	return $result;
}

/**
 * Get selected terms of the View
 * Copied from view_get_advanced_settings()
 *
 * @since 4.6.0
 *
 * @param array $view_settings
 * @return array
 */
function cvp_get_selected_terms( $view_settings ) {
	$taxonomies		 = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy', $view_settings );
	$tax_settings	 = array();
	foreach ( (array) $taxonomies as $taxonomy ) {
		$terms = (array) PT_CV_Functions::setting_value( PT_CV_PREFIX . $taxonomy . '-terms', $view_settings );
		if ( $terms ) {
			$operator = PT_CV_Functions::setting_value( PT_CV_PREFIX . $taxonomy . '-operator', $view_settings, 'IN' );
			if ( $operator === 'AND' && count( $terms ) == 1 ) {
				$operator = 'IN';
			}

			$tax_settings[] = array(
				'taxonomy'			 => $taxonomy,
				'field'				 => 'slug',
				'terms'				 => $terms,
				'operator'			 => $operator,
				/**
				 * @since 1.7.2
				 * Bug: "No post found" when one of selected terms is hierarchical & operator is AND
				 */
				'include_children'	 => apply_filters( PT_CV_PREFIX_ . 'include_children', $operator == 'AND' ? false : true  )
			);
		}
	}

	if ( count( $tax_settings ) > 1 ) {
		$tax_settings[ 'relation' ] = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-relation', $view_settings, 'AND' );
	}

	return apply_filters( PT_CV_PREFIX_ . 'taxonomy_setting', $tax_settings );
}

/**
 * Get term meta
 * @since 4.6.0
 */
function cvp_get_term_meta( $term_id, $key, $single = true ) {
	return function_exists( 'get_term_meta' ) ? get_term_meta( $term_id, $key, $single ) : get_metadata( 'cvpro_term_meta', $term_id, $key, $single );
}

/**
 * Update term meta
 * @since 4.6.0
 */
function cvp_update_term_meta( $term_id, $meta_key, $meta_value, $prev_value = '' ) {
	return function_exists( 'update_term_meta' ) ? update_term_meta( $term_id, $meta_key, $meta_value, $prev_value ) : update_metadata( 'cvpro_term_meta', $term_id, $meta_key, $meta_value, $prev_value );
}

/**
 * Get current post ID
 *
 * @param string $return id, object
 * @return int
 */
function cvp_get_current_post_across_pagination( $return = 'id' ) {
	if ( defined( 'PT_CV_DOING_PREVIEW' ) ) {
		return 0;
	}

	$current_post = ($return == 'id') ? get_queried_object_id() : get_queried_object();
	if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'enable-pagination' ) && PT_CV_Functions::setting_value( PT_CV_PREFIX . 'pagination-type' ) === 'ajax' ) {
		global $pt_cv_id;
		$transient = 'cvp_current_post_' . $pt_cv_id;
		if ( PT_CV_Functions::get_global_variable( 'current_page' ) === 1 ) {
			set_transient( $transient, $current_post, 30 * MINUTE_IN_SECONDS );
		} else {
			$current_post = get_transient( $transient );
		}
	}

	return $current_post;
}

/**
 * Show notice in preview panel
 * @param string $message
 */
function cvp_preview_notice( $message ) {
	if ( defined( 'PT_CV_DOING_PREVIEW' ) ) {
		printf( '<p class="text-center cvp-highlight" style="padding:10px 5px;color:#111">%s</p>', $message );
	}
}

function cvp_sanitize_ctf_value( $value, $key ) {
	if ( !$value ) {
		return false;
	}

	if ( is_serialized( $value ) ) {
		$value = @unserialize( $value );

		$options = get_option( 'cvp_serialized__ctf', array() );
		if ( !in_array( $key, $options ) ) {
			$options[] = $key;
			update_option( 'cvp_serialized__ctf', $options );
		}
	}

	return (array) $value;
}

function cvp_in_option( $option_name, $value ) {
	$options = get_option( $option_name, array() );
	return in_array( $value, $options );
}

// Check if a string is a valid date
function cvp_date_parse_validate( $date, $stop = false ) {
	$date_obj	 = (object) date_parse( $date );
	$result		 = isset( $date_obj->error_count, $date_obj->month, $date_obj->day, $date_obj->year ) && $date_obj->error_count === 0 && checkdate( $date_obj->month, $date_obj->day, $date_obj->year );

	if ( !$result && !$stop ) {
		$new_str = '';

		if ( strpos( $date, '-' ) !== false ) {
			$new_str = str_replace( '-', '/', $date );
		} else if ( strpos( $date, '/' ) !== false ) {
			$new_str = str_replace( '/', '-', $date );
		}

		if ( $new_str ) {
			return cvp_date_parse_validate( $new_str, true );
		}
	}

	return $result ? $date_obj : false;
}

// Format a date string
function cvp_date_format( $str, $from_format, $new_format ) {
	$new_date	 = $str;
	$valid		 = false;

	if ( (int) $str > strtotime( '2010-01-01' ) ) {
		$new_date	 = date( $new_format, (int) $str );
		$valid		 = true;
	} else {
		$date_obj = cvp_date_parse_validate( $str );
		if ( $date_obj ) {
			if ( $from_format ) {
				if ( function_exists( 'date_create_from_format' ) ) {
					$date_from = date_create_from_format( $from_format, $str );
					if ( $date_from ) {
						$new_date	 = date_format( $date_from, $new_format );
						$valid		 = true;
					}
				} else {
					cvp_preview_notice( __( 'This web host is using an outdated PHP version (< 5.3.0), which is NOT able to convert date.', 'content-views-pro' ) );
				}
			} else {
				$hour	 = ($date_obj->hour ? $date_obj->hour : '00') . ':';
				$minute	 = ($date_obj->minute ? $date_obj->minute : '00') . ':';
				$second	 = ($date_obj->second ? $date_obj->second : '00');
				$time	 = strtotime( "{$date_obj->year}-{$date_obj->month}-{$date_obj->day} {$hour}{$minute}{$second}" );

				$new_date	 = date( $new_format, $time );
				$valid		 = true;
			}
		}
	}

	return array( $new_date, $valid );
}

/**
 * For WordPress 4.8.3 and after
 */
if ( !function_exists( 'cv_esc_sql' ) ) {
	function cv_esc_sql( $data ) {
		$result = esc_sql( $data );

		global $wpdb;
		if ( method_exists( $wpdb, 'remove_placeholder_escape' ) ) {
			return $wpdb->remove_placeholder_escape( $result );
		} else {
			return $result;
		}
	}

}
// Strip all slashes
function cvp_stripallslashes( $string ) {
	while ( strchr( $string, '\\' ) ) {
		$string = stripslashes( $string );
	}
	return $string;
}
