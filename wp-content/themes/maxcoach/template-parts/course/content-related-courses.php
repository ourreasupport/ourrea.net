<?php
$number_post = Maxcoach::setting( 'course_related_number' );
$results     = Maxcoach_LP_Course::instance()->get_related_courses( [
	'post_id'      => get_the_ID(),
	'number_posts' => $number_post,
] );

$settings = [
	'show_caption_instructor' => '',
	'show_caption_date'       => '',
	'show_caption_excerpt'    => '',
	'excerpt_length'          => 18,
	'show_caption_meta'       => [
		'lessons',
		'students',
	],
	'show_caption_buttons'    => '',
	'desktop_columns'         => 3,
	'tablet_columns'          => 2,
	'mobile_columns'          => 1,
	'desktop_gutter'          => 30,
];

if ( 'none' !== Maxcoach_Global::instance()->get_sidebar_status() ) {
	$settings['desktop_columns'] = 2;
}

$settings = apply_filters( 'maxcoach_related_courses_settings_args', $settings );

if ( $results !== false && $results->have_posts() ) : ?>
	<div
		class="related-courses maxcoach-animation-zoom-in course-caption-style-01">
		<h3 class="related-title">
			<?php esc_html_e( 'Related Courses', 'maxcoach' ); ?>
		</h3>
		<div class="maxcoach-course tm-swiper tm-slider pagination-style-01 bullets-v-align-below"
		     data-lg-items="<?php echo esc_attr( $settings['desktop_columns'] ); ?>"
		     data-md-items="<?php echo esc_attr( $settings['tablet_columns'] ); ?>"
		     data-sm-items="<?php echo esc_attr( $settings['mobile_columns'] ); ?>"
		     data-lg-gutter="<?php echo esc_attr( $settings['desktop_gutter'] ); ?>"
		     data-pagination="1"
		     data-auto-height="1"
		     data-slides-per-group="inherit"
		>
			<div class="swiper-inner">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<?php while ( $results->have_posts() ) : $results->the_post(); ?>
							<div class="swiper-slide course-item">
								<div class="course-wrapper maxcoach-box">

									<div class="course-thumbnail-wrapper maxcoach-image">
										<a href="<?php the_permalink(); ?>" class="course-permalink link-secret">
											<div class="course-thumbnail">
												<?php if ( has_post_thumbnail() ) { ?>
													<?php Maxcoach_Image::the_post_thumbnail( [ 'size' => '480x298' ] ); ?>
												<?php } else { ?>
													<?php \Maxcoach_Templates::image_placeholder( 480, 298 ); ?>
												<?php } ?>
											</div>
										</a>
									</div>

									<div class="course-info">
										<?php if ( 'yes' === $settings['show_caption_instructor'] ): ?>
											<?php Maxcoach_LP_Course::instance()->the_loop_instructor(); ?>
										<?php endif; ?>

										<?php Maxcoach_LP_Course::instance()->the_loop_custom_price(); ?>

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


								</div>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif;
wp_reset_postdata();
