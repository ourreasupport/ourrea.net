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

	<?php Maxcoach_LP_Course::instance()->the_loop_price(); ?>

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

	<?php if ( ! empty( $settings['show_caption_meta'] ) ) : ?>
		<?php $meta = $settings['show_caption_meta']; ?>
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
	<?php endif; ?>

	<?php if ( 'yes' === $settings['show_caption_buttons'] && function_exists( 'learn_press_get_template' ) ) : ?>
		<div class="course-buttons">
			<?php Maxcoach_LP_Course::instance()->the_loop_buttons(); ?>
		</div>
	<?php endif; ?>
</div>
