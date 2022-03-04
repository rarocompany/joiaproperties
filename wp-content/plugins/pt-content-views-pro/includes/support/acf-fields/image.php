<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_array( $value ) ) {
	$caption	 = $value[ 'caption' ];
	$thumb		 = $value[ 'url' ];
	$img_data	 = sprintf( "alt='%s'", esc_attr( $value[ 'alt' ] ) );
} else {
	$attachment	 = wp_get_attachment_url( $value );
	$thumb		 = $attachment ? $attachment : $value;
}

if ( !empty( $caption ) ) {
	echo '<div class="wp-caption">';
}
?>

<img src="<?php echo esc_url( $thumb ); ?>" <?php echo isset( $img_data ) ? $img_data : ''; ?> />

<?php
if ( !empty( $caption ) ) {
	printf( '<p class="wp-caption-text">%s</p></div>', $caption );
}
