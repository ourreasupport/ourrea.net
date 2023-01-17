<?php
/**
 * Template for displaying course content within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-single-course.php
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}

/**
 * @deprecated
 */
do_action( 'learn_press_before_main_content' );
do_action( 'learn_press_before_single_course' );
do_action( 'learn_press_before_single_course_summary' );

/**
 * @since 3.0.0
 */
do_action( 'learn-press/before-main-content' );

do_action( 'learn-press/before-single-course' );

$layout = Maxcoach_LP_Course::instance()->get_single_layout();
?>
<?php if ( '01' === $layout ) : ?>
	<div id="learn-press-course" class="course-summary row tm-sticky-parent">
		<div class="col-lg-8">
			<div class="tm-sticky-column">
				<?php
				/**
				 * @since 3.0.0
				 *
				 * @see   learn_press_single_course_summary()
				 */
				do_action( 'learn-press/single-course-summary' );
				?>
			</div>
		</div>

		<div class="col-lg-4">
			<div class="entry-course-info tm-sticky-column">
				<?php
				/**
				 * Custom hook by Maxcoach.
				 *
				 * @author  Maxcoach
				 * @package Maxcoach
				 * @since   1.0.0
				 */
				do_action( 'learn-press/single-sticky-bar-features' );
				?>
			</div>
		</div>
	</div>
<?php else: ?>
	<div id="learn-press-course" class="course-summary">
		<?php
		/**
		 * @since 3.0.0
		 *
		 * @see   learn_press_single_course_summary()
		 */
		do_action( 'learn-press/single-course-summary' );
		?>

		<?php
		/**
		 * Custom hook by Maxcoach.
		 *
		 * @author  Maxcoach
		 * @package Maxcoach
		 * @since   1.0.0
		 */
		do_action( 'learn-press/after-single-course-summary' );
		?>
	</div>
<?php endif; ?>
<?php

/**
 * @since 3.0.0
 */
do_action( 'learn-press/after-main-content' );

do_action( 'learn-press/after-single-course' );

/**
 * @deprecated
 */
do_action( 'learn_press_after_single_course_summary' );
do_action( 'learn_press_after_single_course' );
do_action( 'learn_press_after_main_content' );
