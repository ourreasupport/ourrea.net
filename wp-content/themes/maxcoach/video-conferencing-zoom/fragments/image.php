<?php
/**
 * The template for displaying meeting featured image of zoom
 *
 * This template can be overridden by copying it to yourtheme/video-conferencing-zoom/fragments/image.php.
 */
?>

<?php if ( has_post_thumbnail() ): ?>
	<div class="deepn-zvc-single-featured-img">
		<?php Maxcoach_Image::the_post_thumbnail( [ 'size' => '770x400' ] ); ?>
	</div>
<?php
endif;
