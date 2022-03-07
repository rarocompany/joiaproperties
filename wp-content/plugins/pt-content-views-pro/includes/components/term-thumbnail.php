<?php
/*
 * All codes to add & show thumbnail of category, tag, taxonomy term
 * @since 5.5.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	die;
}

add_action( 'admin_init', array( 'CVP_Term_Thumbnail', 'show_field_and_save' ) );

class CVP_Term_Thumbnail {

	static $term_field = 'cvp_term_thumbnail';

	public static function show_field_and_save() {
		$taxes = get_taxonomies( array( 'public' => true ) );

		foreach ( $taxes as $tax ) {
			// Use default WooCommerce category instead
			if ( $tax === 'product_cat' && cv_is_active_plugin( 'woocommerce' ) ) {
				continue;
			}

			add_action( $tax . '_edit_form_fields', array( __CLASS__, 'show_thumbnail_option_for_term' ), 999, 2 );
			add_action( 'edit_term', array( __CLASS__, 'save_thumbnail_for_term' ), 999, 3 );
		}
	}

	static function show_thumbnail_option_for_term( $term, $taxonomy ) {

		// Enqueue media uploader
		wp_enqueue_media();

		$thumb_id	 = (int) cvp_get_term_meta( $term->term_id, self::$term_field, true );
		$thumb_url	 = $thumb_id ? wp_get_attachment_url( $thumb_id ) : '';
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e( 'Thumbnail', 'content-views-pro' ); ?></label></th>
			<td>
				<div>
					<img id='cvp-term-thumb-url' src='<?php echo $thumb_url; ?>' height='100' />
				</div>
				<input id="cvp-term-thumb-upload" type="button" class="button" value="<?php _e( 'Upload image', 'content-views-pro' ); ?>" />
				<input id="cvp-term-thumb-remove" type="button" class="button" value="<?php _e( 'Remove image', 'content-views-pro' ); ?>" />
				<input type='hidden' name='<?php echo self::$term_field; ?>' id='cvp-term-thumb-id' value='<?php echo $thumb_id; ?>' />

				<p class="description">
					<?php _e( 'Select the thumbnail while showing term by "Content Views Pro" plugin.', 'content-views-pro' ); ?>
				</p>
			</td>

		<script type='text/javascript'>
			jQuery( document ).ready( function ( $ ) {
				var file_frame;

				// Upload
				$( '#cvp-term-thumb-upload' ).on( 'click', function ( event ) {
					event.preventDefault();

					if ( file_frame ) {
						file_frame.open();
						return;
					}

					file_frame = wp.media( { multiple: false } );

					file_frame.on( 'select', function () {
						attachment = file_frame.state().get( 'selection' ).first().toJSON();
						$( '#cvp-term-thumb-url' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
						$( '#cvp-term-thumb-id' ).val( attachment.id );
					} );

					file_frame.open();
				} );

				// Remove
				$( '#cvp-term-thumb-remove' ).on( 'click', function ( event ) {
					$( '#cvp-term-thumb-url' ).attr( 'src', '' );
					$( '#cvp-term-thumb-id' ).val( '' );
				} );
			} );
		</script>
		</tr>
		<?php
	}

	static function save_thumbnail_for_term( $term_id, $tt_id = '', $taxonomy = '' ) {
		if ( isset( $_POST[ self::$term_field ] ) ) {
			cvp_update_term_meta( $term_id, self::$term_field, intval( $_POST[ self::$term_field ] ) );
		}
	}

	static function get_thumbnail_of_term( $term, $thumb_size ) {
		$term_img = '';

		// Backward compatibility for "sf-taxonomy-thumbnail" plugin
		if ( function_exists( 'get_term_thumbnail' ) ) {
			$term_img = get_term_thumbnail( $term->term_id, apply_filters( PT_CV_PREFIX_ . 'tao_image_size', $thumb_size ) );
		}

		// WooCommerce category thumbnail
		if ( $term->taxonomy === 'product_cat' && function_exists( 'get_term_meta' ) ) {
			$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
			if ( $thumbnail_id ) {
				$term_img = wp_get_attachment_image( $thumbnail_id, $thumb_size );
			}
		}

		// CVP thumbnail
		if ( !$term_img ) {
			$thumb_id = (int) cvp_get_term_meta( $term->term_id, self::$term_field, true );
			if ( $thumb_id ) {
				$term_img = wp_get_attachment_image( $thumb_id, $thumb_size );
			}
		}

		return $term_img;
	}

}
