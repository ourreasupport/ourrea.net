<?php
/**
 * Template for displaying loop course review.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/course-review/loop-review.php.
 *
 * @author  ThimPress
 * @package LearnPress/Course-Review/Templates
 * version  3.0.1
 */

// Prevent loading this file directly.
defined( 'ABSPATH' ) || exit;
?>

<li itemprop="review" itemscope itemtype="https://schema.org/Review" class="review">
	<div class="review-container">
		<div class="review-author">
			<?php echo get_avatar( $review->user_email ); ?>
		</div>
		<div class="review-content">
			<h4 class="user-name">
				<?php do_action( 'learn_press_before_review_username' ); ?>
				<?php echo $review->display_name; ?>
				<?php do_action( 'learn_press_after_review_username' ); ?>
			</h4>
			<?php learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $review->rate ) ); ?>
			<h3 class="review-title">
				<?php do_action( 'learn_press_before_review_title' ); ?>
				<?php echo $review->title ?>
				<?php do_action( 'learn_press_after_review_title' ); ?>
			</h3>
			<div class="review-text">
				<?php do_action( 'learn_press_before_review_content' ); ?>
				<?php echo $review->content ?>
				<?php do_action( 'learn_press_after_review_content' ); ?>
			</div>
		</div>
	</div>
</li>
