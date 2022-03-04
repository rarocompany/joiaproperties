<?php
/*
 * Basic list of images
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

$images = $value;
?>

<ul>
	<?php foreach ( $images as $image ): ?>
		<li>
			<a href="<?php echo $image[ 'url' ]; ?>">
				<img src="<?php echo $image[ 'sizes' ][ 'thumbnail' ]; ?>" alt="<?php echo $image[ 'alt' ]; ?>" />
			</a>

			<p><?php echo $image[ 'caption' ]; ?></p>
		</li>
	<?php endforeach; ?>
</ul>