<?php
/**
 * Template for displaying thumbnail of course within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/loop/course/thumbnail.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.1
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$course = LP_Global::course();

if ( ! $course ) {
	return;
}
?>

<div class="course-thumbnail maxcoach-image">
	<a href="<?php the_permalink(); ?>" class="course-permalink">
		<?php echo Maxcoach_LP_Course::instance()->get_course_image( $course->get_id(), '480x298' ); ?>
	</a>
</div>
