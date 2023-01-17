<?php
/**
 * Template for displaying content of Recent Courses widget.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/widgets/recent-courses/default.php.
 *
 * @author   ThimPress
 * @category Widgets
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( ! isset( $courses ) ) {
	esc_html_e( 'No courses', 'maxcoach' );

	return;
}

global $post;
//widget instance
$instance = $this->instance;
?>

<div class="archive-course-widget-outer <?php echo esc_attr( $instance["css_class"] ); ?>">

	<div class="widget-body">
		<?php foreach ( $courses as $course_id ) {
			if ( empty( $course_id ) ) {
				continue;
			}
			$post = get_post( $course_id );
			setup_postdata( $post );
			$course = learn_press_get_course( $course_id );
			?>
			<div class="course-entry">

				<!-- course thumbnail -->
				<?php if ( ! empty( $instance['show_thumbnail'] ) && $image = $course->get_image( 'medium' ) ) { ?>
					<div class="course-cover">
						<a href="<?php echo esc_url( $course->get_permalink() ); ?>">
							<?php echo '' . $image; ?>
						</a>
					</div>
				<?php } ?>

				<div class="course-detail">
					<!-- price -->
					<?php if ( ! empty( $instance['show_price'] ) ) { ?>
						<?php echo '<div class="course-price course-meta-field">' . $course->get_price_html() . '</div>'; ?>
					<?php } ?>

					<!-- course title -->
					<a href="<?php echo esc_url( $course->get_permalink() ); ?>">
						<h3 class="course-title"><?php echo esc_html( $course->get_title() ); ?></h3>
					</a>

					<!-- course content -->
					<?php if ( ! empty( $instance['desc_length'] ) && ( $len = intval( $instance['desc_length'] ) ) > 0 ) { ?>
						<?php echo '<div class="course-description">' . $course->get_content( 'raw', $len, esc_html__( '...', 'maxcoach' ) ) . '</div>'; ?>
					<?php } ?>

					<div class="course-meta-data">
						<!-- number students -->
						<?php if ( ! empty( $instance['show_enrolled_students'] ) ) { ?>
							<?php echo '<div class="course-student-number course-meta-field">' . $course->get_students_html() . '</div>'; ?>
						<?php } ?>

						<!-- number lessons -->
						<?php if ( ! empty( $instance['show_lesson'] ) ) { ?>
							<div class="course-lesson-number course-meta-field">
								<?php
								$lesson_count = $course->count_items( LP_LESSON_CPT );

								echo esc_html( sprintf(
									'%s %s',
									$lesson_count,
									_n( 'lesson', 'lessons', $lesson_count, 'maxcoach' )
								) );
								?>
							</div>
						<?php } ?>

						<!-- instructor -->
						<?php if ( ! empty( $instance['show_teacher'] ) ) { ?>
							<?php echo '<div class="course-meta-field">' . $course->get_instructor_html() . '</div>'; ?>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>

	</div>

	<?php wp_reset_postdata(); ?>

	<div class="widget-footer">
		<?php if ( ! empty( $instance['bottom_link_text'] ) && ( $page_id = learn_press_get_page_link( 'courses' ) ) ) {
			$text = $instance['bottom_link_text'] ? $instance['bottom_link_text'] : get_the_title( $page_id );
			?>
			<a class="pull-right" href="<?php echo esc_url( learn_press_get_page_link( 'courses' ) ); ?>">
				<?php echo wp_kses_post( $text ); ?>
			</a>
		<?php } ?>
	</div>
</div>
