<?php
/**
 * Template for displaying archive course content.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-archive-course.php
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $post, $wp_query, $lp_tax_query, $wp_query;

/**
 * @deprecated
 */
do_action( 'learn_press_before_main_content' );

/**
 * @since 3.0.0
 */
do_action( 'learn-press/before-main-content' );

/**
 * @deprecated
 */
do_action( 'learn_press_archive_description' );

/**
 * @since 3.0.0
 */
do_action( 'learn-press/archive-description' );

if ( LP()->wp_query->have_posts() ) :
	/**
	 * @deprecated
	 */
	do_action( 'learn_press_before_courses_loop' );

	/**
	 * @since 3.0.0
	 */
	do_action( 'learn-press/before-courses-loop' );

	?>
	<div class="archive-row-actions course-actions row row-sm-center">
		<div class="archive-result-count course-result-count col-md-6">
			<?php
			$result_count = LP()->wp_query->found_posts;
			printf( _n( 'We found %s course available for you', 'We found %s courses available for you', $result_count, 'maxcoach' ), '<span class="count">' . $result_count . '</span>' );
			?>
		</div>
		<div class="col-md-6">
			<form id="archive-form-filtering" class="archive-form-filtering course-form-filtering" method="get">
				<?php
				$options         = Maxcoach_LP_Course::instance()->get_ordering_options();
				$selected        = Maxcoach_LP_Course::instance()->get_ordering_selected_option();
				$select_settings = [
					'fieldLabel' => esc_html__( 'Sort by:', 'maxcoach' ),
				];
				?>
				<select class="maxcoach-nice-select orderby" name="orderby"
				        data-select="<?php echo esc_attr( wp_json_encode( $select_settings ) ); ?>">
					<?php foreach ( $options as $value => $text ) : ?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $selected, $value ); ?> >
							<?php echo esc_html( $text ); ?>
						</option>
					<?php endforeach; ?>
				</select>
				<input type="hidden" name="paged" value="1">
			</form>
		</div>
	</div>
	<?php

	learn_press_begin_courses_loop();

	while ( LP()->wp_query->have_posts() ) : LP()->wp_query->the_post();

		learn_press_get_template_part( 'content', 'course' );

	endwhile;

	learn_press_end_courses_loop();

	/**
	 * @since 3.0.0
	 */
	do_action( 'learn_press_after_courses_loop' );

	/**
	 * @deprecated
	 */
	do_action( 'learn-press/after-courses-loop' );

	wp_reset_postdata();

else:
	learn_press_display_message( esc_html__( 'No course found.', 'maxcoach' ), 'error' );
endif;

/**
 * @since 3.0.0
 */
do_action( 'learn-press/after-main-content' );

/**
 * @deprecated
 */
do_action( 'learn_press_after_main_content' );
