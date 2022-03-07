<?php
/**
 * @author PT Guy (https://www.contentviewspro.com/)
 * @copyright   Copyright (c) 2017, PT Guy
 * @since 4.3
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Contain information of each custom field
 *
 * @since 4.3
 */
class CVP_CTF {

	// Raw key of field
	public $key;
	// Current post/term object
	public $object;
	// Is current object post or not
	public $is_post;
	// Which is plugin which created current custom field
	public $which_plugin;
	// Nice field name
	public $field_name	 = '';
	// Field value
	public $field_value	 = '';
	// Type of field
	public $field_type	 = 'text';

	public function __construct( $key, $object, $is_post, $which_plugin ) {
		$this->key			 = $key;
		$this->object		 = $object;
		$this->is_post		 = $is_post;
		$this->which_plugin	 = $which_plugin;

		$this->show_output();
	}

	private function show_output() {
		if ( $this->which_plugin ) {
			$this->use_plugin( $this->which_plugin );
		} else {
			foreach ( array_keys( cvp_cft_supported_plugins() ) as $_plugin ) {
				$this->use_plugin( $_plugin, empty( $this->field_value ) );
			}
		}
	}

	// Which plugin to use to get output of current custom field
	private function use_plugin( $_plugin, $condition = true ) {
		if ( $condition ) {
			switch ( $_plugin ) {
				case '_pods':
					$this->output_plugin_pods();
					break;
				case '_wptypes':
					$this->output_plugin_wptypes();
					break;
				case '_acf':
					$this->output_plugin_acf();
					break;
			}
		}
	}

	// Output for custom field of Pods plugin
	private function output_plugin_pods() {
		if ( function_exists( 'pods' ) ) {
			if ( $this->is_post ) {
				$post_type	 = get_post_type( $this->object->ID );
				$mypod		 = pods( $post_type, $this->object->ID );
				if ( $mypod ) {
					$pod_html = $mypod->display( $this->key );
					if ( $pod_html ) {
						$this->field_value = $pod_html;
					}
				}
			} else {
				$mypod = pods( $this->object->taxonomy, $this->object->slug );
				if ( $mypod ) {
					$pod_field = $mypod->field( $this->key );
					if ( $pod_field ) {
						$this->field_value = $pod_field;
					}
				}
			}
		}
	}

	// Output for custom field of WP Types plugin
	private function output_plugin_wptypes() {
		if ( shortcode_exists( 'types' ) ) {
			$wpcfkey	 = str_replace( 'wpcf-', '', $this->key );
			$shortcode	 = apply_filters( PT_CV_PREFIX_ . 'types_sc', "[types field='$wpcfkey' separator=', ']", $wpcfkey, $this->object );
			$wpcfval	 = do_shortcode( $shortcode );
			if ( strcmp( $wpcfval, $shortcode ) !== 0 ) {
				$this->field_value = $wpcfval;
			}
		}
	}

	// Output for custom field of ACF plugin
	private function output_plugin_acf() {
		if ( function_exists( 'get_field_object' ) ) {
			if ( $field_object = get_field_object( $this->key, $this->object ) ) {
				$this->field_value	 = apply_filters( PT_CV_PREFIX_ . 'ctf_acf_value', PT_CV_ACF::display_output( $field_object ), $field_object );
				$this->field_type	 = $field_object[ 'type' ];
				$this->field_name	 = $field_object[ 'label' ];
			}
		}
	}

}

/**
 * Show HTML output of selected custom fields
 *
 * @param mixed $object Current post, or term
 * @param bool $is_post
 * @return string
 */
function cvp_ctf_html( $object, $is_post = true ) {
	$fkey				 = 'custom_field_' . $is_post ? 1 : 0;
	$custom_fields_st	 = PT_CV_Functions::get_global_variable( $fkey );
	if ( !$custom_fields_st ) {
		$custom_fields_st = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'custom-fields-' );
		PT_CV_Functions::set_global_variable( $fkey, $custom_fields_st );
	}

	$html = '';

	if ( $custom_fields_st && !empty( $custom_fields_st[ 'list' ] ) ) {
		$list				 = (array) $custom_fields_st[ 'list' ];
		$show_name			 = !empty( $custom_fields_st[ 'show-name' ] );
		$show_colon			 = !empty( $custom_fields_st[ 'show-colon' ] );
		$use_oembed			 = !empty( $custom_fields_st[ 'enable-oembed' ] );
		$ctf_plugin			 = cvp_ctf_multi_plugins() && !empty( $custom_fields_st[ 'ctf-plugin' ] ) ? $custom_fields_st[ 'ctf-plugin' ] : '';
		$custom_name_list	 = !empty( $custom_fields_st[ 'enable-custom-name' ] ) ? explode( ',', $custom_fields_st[ 'custom-name-list' ] ) : '';
		$result				 = array();

		// Get all meta data of this post
		$metadata	 = $is_post ? get_metadata( 'post', $object->ID ) : array();
		$wanted_keys = apply_filters( PT_CV_PREFIX_ . 'ctf_intersect', $is_post ) ? array_intersect( $list, array_keys( $metadata ) ) : $list;

		// Custom date format
		$ctf_date_format = $ctf_format_from = '';
		if ( !empty( $custom_fields_st[ 'date-custom-format' ] ) ) {
			$ctf_date_format = !empty( $custom_fields_st[ 'date-format' ] ) ? sanitize_text_field( $custom_fields_st[ 'date-format' ] ) : apply_filters( PT_CV_PREFIX_ . 'custom_field_date_format', get_option( 'date_format' ) );
			$ctf_format_from = !empty( $custom_fields_st[ 'date-format-from' ] ) ? sanitize_text_field( $custom_fields_st[ 'date-format-from' ] ) : false;
		}

		$keys_values = array();

		// Get (name) vaue of custom fields
		foreach ( $wanted_keys as $idx => $key ) {
			$ctf = new CVP_CTF( $key, $object, $is_post, $ctf_plugin );

			$field_value = $ctf->field_value;
			$field_name	 = $ctf->field_name;
			$field_type	 = $ctf->field_type;

			# WP Metadata
			if ( empty( $field_value ) && !empty( $metadata[ $key ] ) ) {
				$values		 = apply_filters( PT_CV_PREFIX_ . 'ctf_metadata_values', $metadata[ $key ], $key );
				$separator	 = apply_filters( PT_CV_PREFIX_ . 'ctf_multi_val_separator', ', ' );
				$field_value = implode( $separator, (array) $values );

				if ( is_serialized( $field_value ) ) {
					$field_value = implode( $separator, @unserialize( $field_value ) );
				}
			}

			// Better field output
			if ( in_array( $field_type, array( 'text', 'oembed', 'url', 'email' ) ) ) {
				$field_value = cvp_ctf_html_text( $field_value, $key, $use_oembed );
			}

			// Date value
			if ( !empty( $ctf_date_format ) ) {
				$try_convert = cvp_date_format( $field_value, PT_CV_ACF::date_js_to_php( $ctf_format_from ), 'Y-m-d H:i:s' );
				if ( $try_convert[ 1 ] === true ) {
					$field_value = mysql2date( $ctf_date_format, $try_convert[ 0 ] );
				}
			}

			// Run shortcode in value
			if ( $field_value && !empty( $custom_fields_st[ 'run-shortcode' ] ) ) {
				$field_value = do_shortcode( $field_value );
			}

			$field_value = apply_filters( PT_CV_PREFIX_ . 'ctf_value', $field_value, $key, $object );

			if ( empty( $field_value ) && !empty( $custom_fields_st[ 'hide-empty' ] ) ) {
				continue;
			}

			$value		 = '';
			$name_text	 = $key;
			if ( $show_name ) {
				$field_label = !empty( $custom_name_list[ $idx ] ) ? $custom_name_list[ $idx ] : PT_CV_Functions::string_slug_to_text( $field_name ? $field_name : esc_html( $key )  );
				$name_text	 = cvp_stripallslashes( $field_label ) . ( $show_colon ? ':' : '');
				$value .= sprintf( '<span class="%s">%s</span>', PT_CV_PREFIX . 'ctf-name', $name_text );
			}

			$field_value = !is_array( $field_value ) ? $field_value : implode( ',', array_map( 'implode', $field_value ) );

			// Store key & value
			$keys_values[ $name_text ] = $field_value;

			$value .= sprintf( '<div class="%s">%s</div>', PT_CV_PREFIX . 'ctf-value', $field_value );

			$result[] = sprintf( '<div class="%s">%s</div>', PT_CV_PREFIX . 'custom-fields' . ' ' . PT_CV_PREFIX . 'ctf-' . sanitize_html_class( $key ), $value );
		}

		// Generate Grid layout for custom-fields
		$ctf_columns = !empty( $custom_fields_st[ 'number-columns' ] ) ? abs( $custom_fields_st[ 'number-columns' ] ) : 0;
		$_data		 = '';
		if ( $ctf_columns ) {
			$grid		 = array();
			$span_class	 = apply_filters( PT_CV_PREFIX_ . 'span_class', 'col-md-' );
			$span_width	 = (int) ( 12 / $ctf_columns );

			foreach ( $result as $field ) {
				$grid[] = sprintf( '<div class="%s">%s</div>', esc_attr( $span_class . $span_width . ' ' . PT_CV_PREFIX . 'ctf-column' ), $field );
			}

			$result	 = $grid;
			$_data	 = sprintf( 'data-cvc="%s"', (int) $ctf_columns );
		}

		$html = sprintf( '<div class="%s" %s>%s</div>', PT_CV_PREFIX . 'ctf-list', $_data, apply_filters( PT_CV_PREFIX_ . 'ctf_final_html', implode( '', $result ), $keys_values ) );

		// Balance tags, do not balance each value as it takes many resources
		$html = force_balance_tags( $html );
	}

	return $html;
}

/**
 * Check if there are more than 1 active custom field plugin: Pods, WP Types, ACF
 * @since 4.3
 */
function cvp_ctf_multi_plugins() {
	$count = 0;

	$count += (int) function_exists( 'pods' );
	$count += (int) shortcode_exists( 'types' );
	$count += (int) function_exists( 'get_field_object' );

	return $count > 1;
}

function cvp_cft_supported_plugins() {
	return array(
		'_pods'		 => 'Pods',
		'_wptypes'	 => 'WP Types',
		'_acf'		 => 'Advanced Custom Fields',
	);
}

/**
 * Generate final output for csutom field
 */
function cvp_ctf_html_text( $value, $key, $use_oembed ) {
	$output = false;

	if ( $use_oembed && !filter_var( $value, FILTER_VALIDATE_URL ) === false ) {
		$output = wp_oembed_get( $value );
	}

	if ( !$output && is_string( $value ) && apply_filters( PT_CV_PREFIX_ . 'wrap_ctf_value', true ) ) {
		$pathinfo	 = pathinfo( $value );
		$extension	 = isset( $pathinfo[ 'extension' ] ) ? strtolower( $pathinfo[ 'extension' ] ) : '';

		if ( is_email( $value ) ) {
			$output = sprintf( '<a href="mailto:%1$s">%1$s</a>', antispambot( $value ) );
		} else if ( preg_match( '/(gif|png|jp(e|g|eg)|bmp|ico|webp|jxr|svg)/i', $extension ) ) {
			$output = cvp_ctf_html_image( $value, $pathinfo[ 'filename' ] );
		} else if ( $extension == 'mp3' ) {
			$output = cvp_ctf_html_audio( $value );
		} else if ( $extension == 'mp4' ) {
			$output = cvp_ctf_html_video( $value );
		} else if ( !filter_var( $value, FILTER_VALIDATE_URL ) === false ) {
			$html	 = apply_filters( PT_CV_PREFIX_ . 'ctf_url_text', $value, $key );
			$output	 = sprintf( '<a href="%s">%s</a>', esc_url( $value ), esc_html( $html ) );
		}
	}

	return $output ? $output : $value;
}

function cvp_ctf_html_image( $value, $name ) {
	return sprintf( '<img class="%s" src="%s" alt="%s" style="width: 100%%">', PT_CV_PREFIX . 'ctf-image', esc_url( $value ), esc_attr( $name ) );
}

function cvp_ctf_html_audio( $value ) {
	return '<audio controls>
					<source src="' . esc_url( $value ) . '" type="audio/mpeg">
					Your browser does not support the audio element.
					</audio>';
}

function cvp_ctf_html_video( $value ) {
	return '<video controls>
					<source src="' . esc_url( $value ) . '" type="video/mp4">
					Your browser does not support HTML5 video.
					</video>';
}
