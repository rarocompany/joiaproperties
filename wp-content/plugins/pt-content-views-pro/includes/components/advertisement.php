<?php
/*
 * Advertisement feature
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	die;
}

class CVP_ADVERT {

	static function _enable_ads() {
		return PT_CV_Functions::setting_value( PT_CV_PREFIX . 'ads-enable' );
	}

	static function _get_ads_content() {
		$new_arr = PT_CV_Functions::get_global_variable( 'ads_to_show' );
		if ( !$new_arr ) {
			$ads_content = (array) PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'ads-content' );
			$ads_content = array_filter( $ads_content );

			$new_arr = $ads_content;

			// Repeat if set
			$times = (int) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'ads-repeat-times' );
			for ( $i = 1; $i < $times; $i++ ) {
				$new_arr = array_merge( $new_arr, $ads_content );
			}

			$new_arr = apply_filters( PT_CV_PREFIX_ . 'all_ads', $new_arr );

			PT_CV_Functions::set_global_variable( 'ads_to_show', $new_arr );
		}

		return $new_arr;
	}

	/**
	 * Insert partial array to specific position in another array
	 *
	 * @param array $args
	 * @param int $position
	 * @param array $insert
	 * @return array
	 */
	static function _array_insert( $args, $position, $insert ) {
		if ( $position >= 0 ) {
			return array_slice( $args, 0, $position, true ) + $insert + array_slice( $args, $position, null, true );
		}

		return $args;
	}

	// Count number of ads
	static function count_ads() {
		if ( self::_enable_ads() ) {
			$ads_content = self::_get_ads_content();
			return count( $ads_content );
		}

		return 0;
	}

	/**
	 * Modify parameters before query
	 * @since 4.7.0
	 * @param array $args
	 * @return array
	 */
	static function modify_params( $args ) {
		if ( self::_enable_ads() ) {
			$has_pagination	 = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'enable-pagination' );
			$current_page	 = PT_CV_Functions::get_global_variable( 'current_page' );
			$apply			 = $has_pagination && $current_page > 1;

			if ( $apply ) {
				$per_page		 = (int) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'ads-per-page' );
				$ads_content	 = self::_get_ads_content();
				$ads_count		 = count( $ads_content );
				$pages_has_ad	 = ceil( $ads_count / $per_page );

				if ( $current_page <= $pages_has_ad ) {
					$shown_ads = ($current_page - 1) * $per_page;
				} else {
					$shown_ads = $ads_count;
				}

				if ( $shown_ads > 0 ) {
					$args[ 'offset' ] -= $shown_ads;

					$args[ 'posts_per_page' ]	 = (int) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'pagination-items-per-page' );
					$remain						 = $args[ 'limit' ] - $args[ 'offset' ];
					if ( intval( $args[ 'posts_per_page' ] ) > $remain && $remain > 0 ) {
						$args[ 'posts_per_page' ] = $remain;
					}
				}
			}
		}

		return $args;
	}

	/**
	 * Insert ads between posts
	 *
	 * @param array $args The posts list
	 * @param string $view_type
	 * @return array
	 */
	static function insert_ads_to_page( $args, $view_type ) {
		if ( !self::_enable_ads() || defined( 'PT_CV_SHUFFLE_PAGINATION' ) ) {
			return $args;
		}

		$ads_settings = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'ads-' );

		$offset	 = 0;
		$all_ads = self::_get_ads_content();

		// What ads to show
		$possible_ads = $all_ads;

		$has_pagination = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'enable-pagination' );
		if ( $has_pagination ) {
			$per_page		 = (int) $ads_settings[ 'per-page' ];
			$current_page	 = PT_CV_Functions::get_global_variable( 'current_page' );

			if ( $current_page > 1 ) {
				$offset = ($current_page - 1) * $per_page;
			}
			if ( $per_page && $all_ads ) {
				$possible_ads = array_slice( $all_ads, $offset, $per_page );
			}
		}

		// What positions to show
		$ads_here = count( $possible_ads );
		if ( $ads_here ) {
			$positions_range = range( 0, count( $args ) - 1 );

			$manual_positions = isset( $ads_settings[ 'position' ] ) && $ads_settings[ 'position' ] === 'manual';
			if ( $manual_positions ) {
				$positions_to_insert = array_map( 'intval', explode( ',', trim( $ads_settings[ 'position-manual' ] ) ) );
			} else {
				$positions_to_insert = (array) array_rand( $positions_range, min( count( $positions_range ), $ads_here ) );
			}

			if ( $positions_to_insert ) {
				foreach ( $possible_ads as $key => $value ) {
					$value = str_replace( '\r\n', PHP_EOL, $value );
					while ( strchr( $value, '\\' ) ) {
						$value = stripslashes( $value );
					}

					if ( !empty( $ads_settings[ 'enable-shortcode' ] ) ) {
						$value = do_shortcode( $value );
					}

					$slot = current( $positions_to_insert );
					if ( $slot !== FALSE ) {
						$args = self::_array_insert( (array) $args, $manual_positions ? $slot - 1 : $slot, array( 'ad-' . $key => $value ) );
						next( $positions_to_insert );
					}
				}

				// Show only limited items
				$limit_this_page = (int) ($has_pagination ? PT_CV_Functions::setting_value( PT_CV_PREFIX . 'pagination-items-per-page' ) : PT_CV_Functions::setting_value( PT_CV_PREFIX . 'limit' ));
				if ( $limit_this_page && $args ) {
					$args = array_slice( $args, 0, $limit_this_page, true );
				}
			}
		}

		return $args;
	}

}
