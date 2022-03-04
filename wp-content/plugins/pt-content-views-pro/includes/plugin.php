<?php
/**
 * Define activation, deactivation actions
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

if ( !class_exists( 'PT_CV_Plugin_Pro_Actions' ) ) {

	/**
	 * @name PT_CV_Plugin_Pro_Actions
	 * @todo Define activation, deactivation actions
	 */
	class PT_CV_Plugin_Pro_Actions {
		/**
		 * Fired when the plugin is activated.
		 *
		 * @since    1.0.0
		 *
		 * @param    boolean $network_wide       True if WPMU superadmin uses
		 *                                       "Network Activate" action, false if
		 *                                       WPMU is disabled or plugin is
		 *                                       activated on an individual blog.
		 */
		public static function activate( $network_wide ) {
			if ( function_exists( 'is_multisite' ) && is_multisite() ) {
				if ( $network_wide ) {
					$blog_ids = self::get_blog_ids();
					foreach ( $blog_ids as $blog_id ) {
						switch_to_blog( $blog_id );
						self::single_activate();
						restore_current_blog();
					}
				} else {
					self::single_activate();
				}
			} else {
				self::single_activate();
			}
		}

		/**
		 * Fired when the plugin is deactivated.
		 *
		 * @since    1.0.0
		 *
		 * @param    boolean $network_wide       True if WPMU superadmin uses
		 *                                       "Network Deactivate" action, false if
		 *                                       WPMU is disabled or plugin is
		 *                                       deactivated on an individual blog.
		 */
		public static function deactivate( $network_wide ) {
			if ( function_exists( 'is_multisite' ) && is_multisite() ) {
				if ( $network_wide ) {
					$blog_ids = self::get_blog_ids();
					foreach ( $blog_ids as $blog_id ) {
						switch_to_blog( $blog_id );
						self::single_deactivate();
						restore_current_blog();
					}
				} else {
					self::single_deactivate();
				}
			} else {
				self::single_deactivate();
			}
		}

		/**
		 * Get all blog ids of blogs in the current network that are:
		 * - not archived
		 * - not spam
		 * - not deleted
		 *
		 * @since    1.0.0
		 *
		 * @return   array|false    The blog ids, false if no matches.
		 */
		public static function get_blog_ids() {
			global $wpdb;

			// Get an array of blog ids
			$sql = "SELECT blog_id FROM $wpdb->blogs
				WHERE archived = '0' AND spam = '0'
				AND deleted = '0'";

			return $wpdb->get_col( $sql );
		}

		/**
		 * Fired for each blog when the plugin is activated.
		 *
		 * @since    1.0.0
		 */
		public static function single_activate() {
			update_option( PT_CV_OPTION_VERSION_PRO, PT_CV_VERSION_PRO );

			// Send Activate request
			self::request_cvpsys( 'activate' );
		}

		/**
		 * Fired for each blog when the plugin is deactivated.
		 *
		 * @since    1.0.0
		 */
		public static function single_deactivate() {
			delete_option( PT_CV_OPTION_VERSION_PRO );

			// Send Deactivate request
			self::request_cvpsys( 'deactivate' );
		}

		/**
		 * Call API when activate/deactivate
		 *
		 * @param string $action
		 */
		public static function request_cvpsys( $action ) {
			if ( empty( $action ) ) {
				return 'empty action';
			}

			if ( in_array( $_SERVER[ 'REMOTE_ADDR' ], array( '127.0.0.1', '::1' ) ) ) {
				return '';
			}

			if ( !method_exists( 'PT_CV_Functions', 'get_option_value' ) ) {
				return 'Please install Free plugin first!';
			}

			$license_key = PT_CV_Functions::get_option_value( 'license_key' );
			if ( empty( $license_key ) ) {
				return '';
			}

			// Send the request & save response to $resp
			$response = wp_remote_post( 'http://manager.contentviewspro.com/api/v1/public/' . $action, array(
				'method' => 'POST',
				'body'	 => array( 'license_key' => $license_key, 'site_url' => base64_encode( home_url() ), 'product_version' => PT_CV_VERSION_PRO ),
				)
			);

			if ( !is_wp_error( $response ) ) {
				$response = json_decode( $response[ 'body' ], true );
				if ( $response[ 'status' ] === 'success' ) {
					if ( $action === 'activate' ) {
						update_option( 'pt_cv_pro_activate', 1 );
					} else {
						delete_option( 'pt_cv_pro_activate' );
					}
				} else {
					set_transient( 'pt_cv_active_fail', 1, 12 * HOUR_IN_SECONDS );
					update_option( 'pt_cv_action_fail', (int) get_option( 'pt_cv_action_fail' ) + 1 );
				}
			}
		}

		/**
		 * Get license key in single site, or multisite network
		 * @return string
		 */
		public static function get_site_license() {
			$license = null;
			if ( is_multisite() ) {
				$blog_ids = self::get_blog_ids();
				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					$b_license = PT_CV_Functions::get_option_value( 'license_key' );
					restore_current_blog();

					if ( !empty( $b_license ) ) {
						$license = $b_license;
						break;
					}
				}
			} else {
				$license = PT_CV_Functions::get_option_value( 'license_key' );
			}

			return $license;
		}

	}

}