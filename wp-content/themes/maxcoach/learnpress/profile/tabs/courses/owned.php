<?php
/**
 * Template for displaying own courses in courses tab of user profile page.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/courses/own.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.11.2
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$profile       = learn_press_get_profile();
$filter_status = LP_Request::get_string( 'filter-status' );
$query         = $profile->query_courses( 'own', array( 'status' => $filter_status ) );
?>

<div class="learn-press-subtab-content">

	<h3 class="profile-heading">
		<?php esc_html_e( 'My Courses', 'maxcoach' ); ?>
	</h3>

	<?php if ( $filters = $profile->get_own_courses_filters( $filter_status ) ) { ?>
		<ul class="lp-sub-menu">
			<?php foreach ( $filters as $class => $link ) { ?>
				<li class="<?php echo esc_attr( $class ); ?>">
					<?php echo wp_kses( $link, [
						'a'    => [
							'href' => [],
						],
						'span' => [],
					] ); ?></li>
			<?php } ?>
		</ul>
	<?php } ?>

	<?php if ( ! $query['total'] ) {
		learn_press_display_message( __( 'No courses!', 'maxcoach' ) );
	} else { ?>


		<?php
		$wrapper_classes = [
			'maxcoach-main-post',
			'maxcoach-grid-wrapper',
			'maxcoach-course',
			'maxcoach-animation-zoom-in',
		];

		$grid_options = [
			'type'          => 'grid',
			'columns'       => 3,
			'columnsTablet' => 2,
			'columnsMobile' => 1,
			'gutter'        => 30,
		];
		?>
		<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>"
		     data-grid="<?php echo esc_attr( wp_json_encode( $grid_options ) ); ?>"
		>
			<div class="learn-press-courses profile-courses-list maxcoach-grid">
				<div class="grid-sizer"></div>
				<?php
				global $post;
				foreach ( $query['items'] as $item ) {
					$course = learn_press_get_course( $item );
					$post   = get_post( $item );
					setup_postdata( $post );
					learn_press_get_template( 'content-course.php' );
				}
				wp_reset_postdata();
				?>
			</div>
		</div>
		<?php $query->get_nav( '', true, $profile->get_current_url() ); ?>

	<?php } ?>
</div>
