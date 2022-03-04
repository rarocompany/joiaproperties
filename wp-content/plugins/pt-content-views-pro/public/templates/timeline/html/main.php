<?php
/**
 * Layout Name: Timeline
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy (http://www.contentviewspro.com/)
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

$html	 = array();
$layout	 = $dargs[ 'layout-format' ];
if ( !empty( $dargs[ 'view-type-settings' ][ 'simulate-fb' ] ) ) {
	// Prevent the case: there are 2 columns but have not setting for thumbnail position
	if ( $layout == '2-col' && !isset( $dargs[ 'field-settings' ][ 'thumbnail' ] ) ) {
		$layout = '1-col';
	}
	?>

	<div class="<?php echo esc_attr( PT_CV_PREFIX . 'tl-avatar' ); ?>">
		<?php
		// Get Meta fields
		$meta_fields = isset( $fields_html[ 'meta-fields' ] ) ? $fields_html[ 'meta-fields' ] : array();

		// Author
		$author	 = isset( $meta_fields[ 'author' ] ) ? $meta_fields[ 'author' ] : '';
		echo $author;
		?>
		<div class="<?php echo esc_attr( PT_CV_PREFIX . 'tl-heading' ); ?>">
			<?php
			// Tile
			$title	 = isset( $fields_html[ 'title' ] ) ? $fields_html[ 'title' ] : '';
			echo $title;
			unset( $fields_html[ 'title' ] );

			// Date
			$date	 = isset( $meta_fields[ 'date' ] ) ? $meta_fields[ 'date' ] : '';
			echo $date;
			?>
		</div>

	</div>
	<?php
	$content = isset( $fields_html[ 'content' ] ) ? $fields_html[ 'content' ] : '';
	$content .= isset( $fields_html[ 'social-buttons' ] ) ? $fields_html[ 'social-buttons' ] : '';

	$thumbnail = isset( $fields_html[ 'thumbnail' ] ) ? $fields_html[ 'thumbnail' ] : '';
	if ( !empty( $content ) || !empty( $thumbnail ) ) {
		switch ( $layout ) {
			case '1-col':
				$fields_name	 = array_keys( $fields_html );
				$content_idx	 = array_search( 'content', $fields_name );
				$thumbnail_idx	 = array_search( 'thumbnail', $fields_name );

				if ( $thumbnail_idx !== false ) {
					$html[ $thumbnail_idx ] = $thumbnail;
				}
				if ( $content_idx !== false ) {
					$html[ $content_idx ] = $content;
				}

				// Sort by keys, to show in right order
				ksort( $html );

				break;
			case '2-col':
				$html[]	 = $thumbnail;
				$html[]	 = $content;

				break;
		}

		echo implode( "\n", $html );
	}

	unset( $fields_html[ 'content' ] );
	unset( $fields_html[ 'social-buttons' ] );
	unset( $fields_html[ 'thumbnail' ] );
	?>
	<?php
	if ( $meta_fields ) {
		// Unset author, date in array
		unset( $meta_fields[ 'author' ] );
		unset( $meta_fields[ 'date' ] );

		if ( $meta_fields ) {
			$fields_html[ 'meta-fields' ] = PT_CV_Html::_field_meta_wrap( $meta_fields, '' );
		} else {
			unset( $fields_html[ 'meta-fields' ] );
		}
	}

	// Show other fields: Meta field, Custom fields...
	echo implode( "\n", $fields_html );
} else {
	echo implode( "\n", $fields_html );
}