<?php
/**
 * ACF custom actions/filters
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

if ( !class_exists( 'PT_CV_ACF' ) ) {

	/**
	 * @name PT_CV_ACF
	 * @todo Utility functions
	 */
	class PT_CV_ACF {

		/**
		 * Generate final output for ACF field
		 *
		 * @param array $field_object
		 *
		 * @return string
		 */
		public static function display_output( $field_object ) {
			if ( !$field_object ) {
				return '';
			}

			$value	 = $field_object[ 'value' ]; // Return Format = Value
			$type	 = $field_object[ 'type' ];

			// If value is empty, return
			if ( $type != 'true_false' && empty( $value ) ) {
				return '';
			}

			$separator = apply_filters( PT_CV_PREFIX_ . 'ctf_multi_val_separator', ', ' );

			switch ( $type ) {
				// Custom function
				case 'select':
				case 'checkbox':
				case 'radio':
					$result = array();
					foreach ( (array) $value as $key ) {
						$result[] = isset( $field_object[ 'choices' ][ $key ] ) ? $field_object[ 'choices' ][ $key ] : '';
					}
					$value = implode( $separator, $result );

					break;

				case 'true_false':
					$value = $value ? __( 'Yes', 'content-views-query-and-display-post-page' ) : __( 'No', 'content-views-query-and-display-post-page' );

					break;

				case 'date_picker':
					// Create date with 'date_format'
					if ( isset( $field_object[ 'date_format' ], $field_object[ 'display_format' ] ) ) {
						$date = DateTime::createFromFormat( self::date_js_to_php( $field_object[ 'date_format' ] ), $value );
						// Show date with 'display_format'
						if ( $date ) {
							$value = $date->format( self::date_js_to_php( $field_object[ 'display_format' ] ) );
						}
					}

					break;

				case 'color_picker':
					$value = sprintf( '<div class="%1$s" style="height:%2$s;width:%2$s;background:%3$s;"></div>', PT_CV_PREFIX . 'ctf-color', '25px', $value );

					break;

				case 'page_link':
					$value = sprintf( '<a href="%s">%s</a>', esc_url( $value ), __( 'Click here', 'content-views-pro' ) );

					break;

				case 'post_object':
					if ( !is_array( $value ) ) {
						$value = array( $value );
					}

					$result = array();
					foreach ( $value as $post_object ) {
						$output		 = sprintf( '<a href="%s">%s</a>', get_permalink( $post_object->ID ), apply_filters( PT_CV_PREFIX_ . 'acf_post_object_html', get_the_title( $post_object->ID ), $post_object ) );
						$result[]	 = apply_filters( PT_CV_PREFIX_ . 'acf_post_object_output', $output, $post_object );
					}
					$value = implode( $separator, $result );
					break;

				// Custom output from file
				case 'image':
				case 'file':
				case 'relationship':
				case 'taxonomy':
				case 'gallery':
					$file_path = PT_CV_PATH_PRO . sprintf( 'includes/support/acf-fields/%s.php', $field_object[ 'type' ] );

					if ( file_exists( $file_path ) ) {
						ob_start();
						include $file_path;
						$value = ob_get_clean();
					}

					break;
			}

			return $value;
		}

		/**
		 * Convert date format from JS to PHP
		 *
		 * @param string $date
		 *
		 * @return string
		 */
		static function date_js_to_php( $date ) {
			$jquery_date = array( 'dd', 'd', 'DD', 'D', 'mm', 'm', 'MM', 'M', 'yy', 'y', );
			$uni_date	 = array( 'f1', 'j', 'l', 'D', 'f2', 'n', 'F', 'M', 'Y', 'y', );
			$php_date	 = array( 'd', 'j', 'l', 'D', 'm', 'n', 'F', 'M', 'Y', 'y', );
			$date		 = str_replace( $jquery_date, $uni_date, $date );
			$date		 = str_replace( $uni_date, $php_date, $date );

			return $date;
		}

	}

}