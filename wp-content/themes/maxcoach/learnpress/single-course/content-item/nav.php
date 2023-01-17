<?php
/**
 * Template for displaying next/prev item in course.
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) or die();

/**
 * @var LP_Course_Item $next_item
 * @var LP_Course_Item $prev_item
 */

if ( ! isset( $prev_item ) && ! isset( $next_item ) ) {
	return;
}
?>

<div class="course-item-nav">
	<div class="prev">
		<?php if ( $prev_item ) { ?>
			<a href="<?php echo esc_url( $prev_item->get_permalink() ); ?>">
				<?php echo esc_html( $prev_item->get_title() ); ?>
			</a>
		<?php } ?>
	</div>

	<div class="next">
		<?php if ( $next_item ) { ?>
			<a href="<?php echo esc_url( $next_item->get_permalink() ); ?>">
				<?php echo esc_html( $next_item->get_title() ); ?>
			</a>
		<?php } ?>
	</div>
</div>


