<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'CVPro_AutoUpdate' ) ) {

	class CVPro_AutoUpdate {

		var $api_url;
		var $plugin_path;
		var $plugin_slug;
		var $license_key;

		function __construct( $api_url, $plugin_path, $license_key = null ) {
			$this->api_url		 = $api_url;
			$this->plugin_path	 = $plugin_path;
			$this->license_key	 = $license_key;
			if ( strstr( $plugin_path, '/' ) ) {
				list ( $t1, $t2 ) = explode( '/', $plugin_path );
			} else {
				$t1 = $plugin_path;
			}
			$this->plugin_slug = $t1;

			add_filter( 'pre_set_site_transient_update_plugins', array( &$this, 'check_for_update' ) );
			add_filter( 'plugins_api', array( &$this, 'plugin_api_call' ), 10, 3 );
			add_action( 'in_plugin_update_message-' . $plugin_path, array( &$this, 'show_update_message' ), 10, 2 );

			// This is for testing only!
			//set_site_transient( 'update_plugins', null );
			// Show which variables are being requested when query plugin API
			//add_filter( 'plugins_api_result', array(&$this, 'debug_result'), 10, 3 );
		}

		function check_for_update( $transient ) {
			if ( empty( $transient->checked ) ) {
				return $transient;
			}

			$request_args = array(
				'slug'		 => $this->plugin_slug,
				'version'	 => isset( $transient->checked[ $this->plugin_path ] ) ? $transient->checked[ $this->plugin_path ] : PT_CV_VERSION_PRO
			);

			$request_string	 = $this->prepare_request( 'update_check', $request_args );
			$raw_response	 = wp_remote_post( $this->api_url, $request_string );

			$response = null;
			if ( !is_wp_error( $raw_response ) && ( $raw_response[ 'response' ][ 'code' ] == 200 ) ) {
				$response = @unserialize( $raw_response[ 'body' ] );
			}

			if ( is_object( $response ) && !empty( $response ) ) {
				// Feed the update data into WP updater
				$transient->response[ $this->plugin_path ] = $response;

				return $transient;
			}

			// Check to make sure there is not a similarly named plugin in the wordpress.org repository
			if ( isset( $transient->response[ $this->plugin_path ] ) ) {
				if ( strpos( $transient->response[ $this->plugin_path ]->package, 'wordpress.org' ) !== false ) {
					unset( $transient->response[ $this->plugin_path ] );
				}
			}

			return $transient;
		}

		function plugin_api_call( $def, $action, $args ) {
			if ( !isset( $args->slug ) || $args->slug != $this->plugin_slug ) {
				return $def;
			}

			$transient		 = get_site_transient( 'update_plugins' );
			$request_args	 = array(
				'slug'		 => $this->plugin_slug,
				'version'	 => isset( $transient->checked[ $this->plugin_path ] ) ? $transient->checked[ $this->plugin_path ] : PT_CV_VERSION_PRO
			);

			$request_string	 = $this->prepare_request( $action, $request_args );
			$raw_response	 = wp_remote_post( $this->api_url, $request_string );

			if ( is_wp_error( $raw_response ) ) {
				$res = new WP_Error( 'plugins_api_failed', __( 'An unknown error occurred' ), $raw_response->get_error_message() );
			} else {
				$res = @unserialize( $raw_response[ 'body' ] );
				if ( $res === false ) {
					$res = new WP_Error( 'plugins_api_failed', __( 'An unknown error occurred' ), $raw_response[ 'body' ] );
				}
			}

			return $res;
		}

		function prepare_request( $action, $args ) {
			global $wp_version;

			return array(
				'body'		 => array(
					'action'		 => $action,
					'license_key'	 => $this->license_key,
					'request'		 => serialize( $args ),
					'site_url'		 => base64_encode( home_url() ),
					'is_network'	 => is_multisite(),
				),
				'decompress' => false,
				'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url()
			);
		}

		function debug_result( $res, $action, $args ) {
			echo '<pre>' . print_r( $res, true ) . '</pre>';

			return $res;
		}

		function show_update_message( $plugin_data, $r ) {
			if ( empty( $plugin_data[ 'package' ] ) ) {
				if ( empty( $this->license_key ) ) {
					$url	 = 'https://docs.contentviewspro.com/wp-content/uploads/2017/05/Content-Views-Settings-add-license-key.png';
					$text	 = __( 'activate your license', 'content-views-pro' );
				} else {
					$url	 = esc_url( 'https://www.contentviewspro.com/license-key-info/?license_key=' . $this->license_key );
					$text	 = __( 'renew your license', 'content-views-pro' );
				}
				echo '<br><br>' . sprintf( __( 'Please %s for updates.', 'content-views-pro' ), sprintf( '<strong><a href="%s" target="_blank">%s</a></strong>', $url, $text ) );
			}
		}

	}

}