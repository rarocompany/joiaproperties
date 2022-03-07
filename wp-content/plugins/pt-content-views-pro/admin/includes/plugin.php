<?php
/**
 * Form, option group, option name, option fields
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

if ( !class_exists( 'PT_CV_Plugin_Pro' ) ) {

	/**
	 * @name PT_CV_Plugin_Pro
	 */
	class PT_CV_Plugin_Pro {

		/**
		 * Add custom filters/actions
		 */
		static function init() {
			// Filters
			add_filter( PT_CV_PREFIX_ . 'settings_page_section_one', array( __CLASS__, 'filter_settings_page_section_one' ) );
			add_filter( PT_CV_PREFIX_ . 'settings_page_section_two', array( __CLASS__, 'filter_settings_page_section_two' ) );
			// Add more settings to Frontend assets group
			add_filter( PT_CV_PREFIX_ . 'frontend_assets_fields', array( __CLASS__, 'filter_frontend_assets_fields' ) );
			// Add current class to list of class to looking for callback function for a setting option
			add_filter( PT_CV_PREFIX_ . 'defined_in_class', array( __CLASS__, 'filter_defined_in_class' ) );
			add_filter( PT_CV_PREFIX_ . 'settings_page_field_sanitize', array( __CLASS__, 'filter_settings_page_field_sanitize' ), 10, 2 );
		}

		/**
		 * Content Views Settings page : section 1
		 *
		 * @param string $text HTML settings for this section
		 *
		 * @return string HTML
		 */
		public static function filter_settings_page_section_one( $text ) {
			$file_path	 = PT_CV_PATH_PRO . 'admin/includes/templates/settings-section-one.php';
			$text		 = PT_CV_Functions::file_include_content( $file_path );

			return $text;
		}

		/**
		 * Content Views Settings page : section 2
		 *
		 * @param string $text HTML settings for this section
		 *
		 * @return string HTML
		 */
		public static function filter_settings_page_section_two( $text ) {
			$file_path	 = PT_CV_PATH_PRO . 'admin/includes/templates/settings-section-two.php';
			$text		 = PT_CV_Functions::file_include_content( $file_path );

			return $text;
		}

		/**
		 * Add more option to Frontend assets setting
		 *
		 * @param array $args Array of setting options
		 *
		 * @return array
		 */
		public static function filter_frontend_assets_fields( $args ) {
			$args[] = array(
				'id'	 => 'license_key',
				'title'	 => __( 'License key', 'content-views-pro' ),
			);

			$args[] = array(
				'id'	 => 'access_role',
				'title'	 => __( 'User role', 'content-views-pro' ),
			);

			$args[] = array(
				'id'	 => 'troubleshoot_problems',
				'title'	 => __( 'Troubleshooting', 'content-views-pro' ),
			);

			$args[] = array(
				'id'	 => 'hide_edit_view',
				'title'	 => __( 'Utility', 'content-views-pro' ),
			);

			$args[] = array(
				'id'	 => 'show_edit_post',
				'title'	 => '',
			);

			$args[] = array(
				'id'	 => 'custom_css',
				'title'	 => __( 'Custom code', 'content-views-pro' ),
			);

			return $args;
		}

		/**
		 * Add class which define callback function for setting option
		 *
		 * @param array $args Array of classes
		 *
		 * @return array
		 */
		public static function filter_defined_in_class( $args ) {
			$args[ 'custom_css' ]			 = __CLASS__;
			$args[ 'troubleshoot_problems' ] = __CLASS__;
			$args[ 'hide_edit_view' ]		 = __CLASS__;
			$args[ 'show_edit_post' ]		 = __CLASS__;
			$args[ 'access_role' ]			 = __CLASS__;
			$args[ 'license_key' ]			 = __CLASS__;

			return $args;
		}

		/**
		 * Filter field type before sanitize value
		 *
		 * @param string $args
		 * @param string $key
		 * @return string
		 */
		public static function filter_settings_page_field_sanitize( $args, $key ) {
			if ( in_array( $key, array( 'custom_css', 'custom_js' ) ) ) {
				$args = 'textarea';
			}
			return $args;
		}

		/**
		 * Add new setting Section
		 *
		 * @param string $section_slug
		 * @param array  $fields
		 */
		public static function _add_setting_section( $section_slug, $fields ) {
			// Add Section
			add_settings_section(
				$section_slug, '', array( __CLASS__, 'section_callback_' . $section_slug ), PT_CV_DOMAIN
			);

			// Register Account fields
			foreach ( $fields as $field ) {
				PT_CV_Plugin::field_register( $field, $section_slug, __CLASS__ );
			}
		}

		/**
		 * Show Edit view button
		 */
		public static function field_callback_hide_edit_view() {
			$field_name = 'hide_edit_view';

			PT_CV_Plugin::_field_print(
				$field_name, 'checkbox', sprintf( __( "Hide %s link in output", 'content-views-pro' ), sprintf( '<code>%s</code>', __( 'Edit View', 'content-views-query-and-display-post-page' ) ) ), ''
			);
		}

		/**
		 * Show Edit post button
		 */
		public static function field_callback_show_edit_post() {
			$field_name = 'show_edit_post';

			PT_CV_Plugin::_field_print(
				$field_name, 'checkbox', sprintf( __( "Show %s link (for each post) in output", 'content-views-pro' ), sprintf( '<code>%s</code>', __( 'Edit Post' ) ) ), ''
			);
		}

		/**
		 * User role field
		 */
		public static function field_callback_access_role() {
			$field_name = 'access_role';

			// Get saved value, if not, set the default value as 'administrator'
			$field_value = !empty( PT_CV_Plugin::$options[ $field_name ] ) ? esc_attr( PT_CV_Plugin::$options[ $field_name ] ) : 'administrator';

			ob_start();
			wp_dropdown_roles( $field_value );
			$options = ob_get_clean();

			self::_field_print_select( $field_name, $options );
		}

		/**
		 * License key field
		 */
		public static function field_callback_license_key() {
			$field_name = 'license_key';

			if ( !get_option( 'pt_cv_pro_activate' ) ) {
				$text = __( 'To update new version, please enter your license key', 'content-views-pro' );
			} else {
				$text = sprintf( '<a href="//www.contentviewspro.com/license-key-info/?license_key=%s" target="_blank" style="color:#ff5a5f;font-weight:600;text-decoration:underline">License Details</a>', urlencode( PT_CV_Functions::get_option_value( 'license_key' ) ) );
			}

			PT_CV_Plugin::_field_print( $field_name, 'text', '', $text );
		}

		/**
		 * License key field
		 */
		public static function field_callback_custom_css() {
			echo '<p class="cuscode">Custom CSS</p> <p class="cuscode">Custom JS</p>';

			self::_field_print_textarea( 'custom_css', '', __( 'Custom CSS', 'content-views-pro' ) );
			self::_field_print_textarea( 'custom_js', '', __( 'Custom JS', 'content-views-pro' ) );
		}

		public static function field_callback_troubleshoot_problems() {
			$field_name = 'free_readmore_style';

			PT_CV_Plugin::_field_print(
			$field_name, 'checkbox', __( 'For <code>Read More</code> button: do not automatically change its background color to Blue', 'content-views-pro' ), __( 'Select this option if you added custom CSS to style all "Read More" buttons, or want to keep Green background as the free version', 'content-views-pro' )
			);

			echo "<p style='margin: 10px 0;'></p>";
			
			$field_name = 'fb_share_wrong_image';

			PT_CV_Plugin::_field_print(
				$field_name, 'checkbox', __( 'Facebook share shows wrong image', 'content-views-pro' ), __( 'You may also reload the Facebook Share page to clear cached data', 'content-views-pro' )
			);
		}

		/**
		 * Print select field
		 *
		 * @param string $field_name The ID of field
		 * @param string $options    The HTML options of select box
		 */
		public static function _field_print_select( $field_name, $options ) {
			$field_id = esc_attr( $field_name );

			printf(
				'<select id="%1$s" name="%2$s[%1$s]">%3$s</select>', $field_id, PT_CV_OPTION_NAME, $options
			);

			printf( '<p class="description">%s</p>', __( 'This user role can add, edit, delete, duplicate View', 'content-views-pro' ) );
		}

		/**
		 * Display Textarea field
		 *
		 * @param string $field_name
		 * @param string $desc
		 * @param string $placeholder
		 */
		public static function _field_print_textarea( $field_name, $desc = '', $placeholder = '' ) {
			// Get Saved value
			$field_value = isset( PT_CV_Plugin::$options[ $field_name ] ) ? esc_attr( PT_CV_Plugin::$options[ $field_name ] ) : '';
			// Show new line in textarea
			$field_value = str_replace( '\r', '&#13;', $field_value );
			$field_value = str_replace( '\n', '&#10;', $field_value );

			$field_id = esc_attr( $field_name );

			// don't use esc_textarea for $field_value
			echo sprintf( '<textarea id="%1$s" name="%2$s[%1$s]" rows="6" placeholder="%4$s">%3$s</textarea> ', $field_id, PT_CV_OPTION_NAME, $field_value, $placeholder );

			// Show description
			if ( !empty( $desc ) ) {
				printf( '<p class="description">%s</p>', $desc );
			}
		}

	}

}