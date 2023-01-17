<?php
$banners = [];
if ( ! empty( $settings['banners'] ) ) {
	foreach ( $settings['banners'] as $banner ) {
		if ( empty( $banner['template_id'] ) ) {
			continue;
		}

		$banners[ $banner['position'] ] [] = $banner['template_id'];
	}
}

$loop_count = 1;

while ( $maxcoach_query->have_posts() ) :
	$maxcoach_query->the_post();
	$classes = array( 'grid-item', 'post-item' );

	$is_highlight_item = false;

	$size = Maxcoach_Image::elementor_parse_image_size( $settings, '480x302' );

	if ( $loop_count - 1 % 3 === 0 ) {
		$is_highlight_item = true;

		$classes[] = 'post-highlight-item';

		$size = Maxcoach_Image::elementor_parse_image_size( $settings, '570x570' );
	}
	?>
	<div <?php post_class( implode( ' ', $classes ) ); ?>
		<?php if ( $is_highlight_item ) : ?>
			data-width="2"
		<?php endif; ?>
	>
		<div class="post-wrapper maxcoach-box">

			<?php if ( has_post_thumbnail() ) { ?>
				<div class="post-feature post-thumbnail maxcoach-image">
					<a href="<?php the_permalink(); ?>">
						<?php
						Maxcoach_Image::the_post_thumbnail( array( 'size' => $size ) );
						?>
					</a>
					<?php if ( 'yes' === $settings['show_caption_category'] && ! $is_highlight_item ) : ?>
						<?php Maxcoach_Post::instance()->the_category(); ?>
					<?php endif; ?>
				</div>
			<?php } ?>
			<?php if ( 'yes' === $settings['show_caption'] ) : ?>
				<div class="post-caption">
					<?php if ( 'yes' === $settings['show_caption_category'] && $is_highlight_item ) : ?>
						<?php Maxcoach_Post::instance()->the_category(); ?>
					<?php endif; ?>

					<?php get_template_part( 'loop/blog/caption', 'masonry-02' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<?php
	if ( isset( $banners[ $loop_count ] ) ) {
		foreach ( $banners[ $loop_count ] as $template_id ) {
			if ( 'publish' !== get_post_status( $template_id ) ) {
				continue;
			}
			?>
			<div class="grid-item" data-width="2">
				<?php echo \ElementorPro\Plugin::elementor()->frontend->get_builder_content_for_display( $template_id ) ?>
			</div>
			<?php
		}
	}
	?>

	<?php $loop_count++; ?>
<?php endwhile;
