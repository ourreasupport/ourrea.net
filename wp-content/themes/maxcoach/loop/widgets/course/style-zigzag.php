<?php
if ( ! isset( $settings ) ) {
	$settings = array();
}

$column_count = 1;
while ( $maxcoach_query->have_posts() ) :
	$maxcoach_query->the_post();

	$classes = array( 'course-item grid-item' );

	$size = Maxcoach_Image::elementor_parse_image_size( $settings, '480x608' );

	if ( 3 === $column_count ) {
		$classes[] = 'highlight-item';
		$size      = '454x570';
	}
	?>
	<div <?php post_class( implode( ' ', $classes ) ); ?>>
		<div class="course-wrapper maxcoach-box">

			<?php if ( ! empty( $settings['show_caption_meta'] ) ) : ?>
				<?php $meta = $settings['show_caption_meta']; ?>
				<div class="course-info course-top-info">
					<div class="course-meta">
						<?php if ( in_array( 'lessons', $meta, true ) ): ?>
							<?php Maxcoach_LP_Course::instance()->the_loop_lessons(); ?>
						<?php endif; ?>

						<?php if ( in_array( 'students', $meta, true ) ): ?>
							<?php Maxcoach_LP_Course::instance()->the_loop_students(); ?>
						<?php endif; ?>

						<?php if ( in_array( 'duration', $meta, true ) ): ?>
							<?php Maxcoach_LP_Course::instance()->the_loop_duration(); ?>
						<?php endif; ?>

						<?php if ( in_array( 'category', $meta, true ) ): ?>
							<?php Maxcoach_LP_Course::instance()->the_loop_meta_categories(); ?>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="course-feature-wrap">
				<div class="course-thumbnail-wrapper maxcoach-image">
					<a href="<?php the_permalink(); ?>" class="course-permalink link-secret">
						<div class="course-thumbnail">
							<?php if ( has_post_thumbnail() ) { ?>
								<?php Maxcoach_Image::the_post_thumbnail( array( 'size' => $size ) ); ?>
							<?php } else { ?>
								<?php Maxcoach_Templates::image_placeholder( 480, 298 ); ?>
							<?php } ?>
							<div class="course-overlay-bg"></div>
						</div>
					</a>
				</div>

				<?php Maxcoach_LP_Course::instance()->the_loop_price(); ?>
			</div>

			<?php if ( 'yes' === $settings['show_caption'] ) : ?>
				<div class="course-info">
					<?php if ( 'yes' === $settings['show_caption_instructor'] ): ?>
						<?php Maxcoach_LP_Course::instance()->the_loop_instructor(); ?>
					<?php endif; ?>

					<?php if ( 'yes' === $settings['show_caption_date'] ) : ?>
						<div class="course-date"><?php echo get_the_date(); ?></div>
					<?php endif; ?>

					<h3 class="course-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>

					<?php if ( 'yes' === $settings['show_caption_excerpt'] ) : ?>
						<?php
						if ( empty( $settings['excerpt_length'] ) ) {
							$settings['excerpt_length'] = 18;
						}
						?>
						<div class="course-excerpt">
							<?php Maxcoach_Templates::excerpt( array(
								'limit' => $settings['excerpt_length'],
								'type'  => 'word',
							) ); ?>
						</div>
					<?php endif; ?>

					<?php if ( 'yes' === $settings['show_caption_buttons'] && function_exists( 'learn_press_get_template' ) ) : ?>
						<div class="course-buttons">
							<?php Maxcoach_LP_Course::instance()->the_loop_buttons(); ?>
						</div>
					<?php endif; ?>
				</div>

			<?php endif; ?>
		</div>
	</div>
	<?php
	$column_count++;

	if ( $column_count > 3 ) {
		$column_count = 1;
	}
endwhile;
