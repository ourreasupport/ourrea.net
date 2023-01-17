<?php
if ( ! isset( $settings ) ) {
	$settings = array();
}

while ( $maxcoach_query->have_posts() ) :
	$maxcoach_query->the_post();

	$course_id = get_the_ID();
	$course    = learn_press_get_course( $course_id );
	$classes   = array( 'course-item grid-item' );
	?>
	<div <?php post_class( implode( ' ', $classes ) ); ?>>
		<div class="course-wrapper maxcoach-box">
			<div class="course-thumbnail-wrapper maxcoach-image">
				<a href="<?php the_permalink(); ?>" class="course-permalink link-secret">
					<div class="course-thumbnail">
						<?php if ( has_post_thumbnail() ) { ?>
							<?php $size = Maxcoach_Image::elementor_parse_image_size( $settings, '480x298' ); ?>
							<?php Maxcoach_Image::the_post_thumbnail( array( 'size' => $size ) ); ?>
						<?php } else { ?>
							<?php Maxcoach_Templates::image_placeholder( 480, 298 ); ?>
						<?php } ?>
						<div class="course-overlay-bg"></div>
					</div>
				</a>
			</div>

			<?php if ( 'yes' === $settings['show_caption'] ) : ?>
				<?php get_template_part( 'loop/course/caption', $settings['caption_style'] ); ?>
			<?php endif; ?>

		</div>
	</div>
<?php endwhile; ?>
