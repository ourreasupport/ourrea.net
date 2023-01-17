<?php
/**
 * The Template for displaying archive events page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/archive-event.php
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

get_header(); ?>
<div id="page-content" class="page-content">
	<div class="container">
		<div class="row">

			<?php Maxcoach_Templates::render_sidebar( 'left' ); ?>

			<div class="page-main-content">
				<?php
				/**
				 * tp_event_before_main_content hook
				 *
				 * @hooked tp_event_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked tp_event_breadcrumb - 20
				 */
				do_action( 'tp_event_before_main_content' );
				?>

				<?php
				/**
				 * tp_event_archive_description hook
				 *
				 * @hooked tp_event_taxonomy_archive_description - 10
				 * @hooked tp_event_room_archive_description - 10
				 */
				do_action( 'tp_event_archive_description' );
				?>

				<?php if ( have_posts() ) : ?>

					<div class="archive-row-actions event-actions row row-sm-center">
						<div class="archive-result-count event-result-count col-md-6">
							<?php
							global $wp_query;
							$result_count = $wp_query->found_posts;

							printf( _n( 'We found %s event available for you', 'We found %s events available for you', $result_count, 'maxcoach' ), '<span class="count">' . $result_count . '</span>' );
							?>
						</div>
						<div class="col-md-6">
							<form id="archive-form-filtering" class="archive-form-filtering event-form-filtering"
							      method="get">
								<?php
								$options         = Maxcoach_Event::instance()->get_filtering_type_options();
								$selected        = Maxcoach_Event::instance()->get_selected_type_option();
								$select_settings = [
									'fieldLabel' => esc_html__( 'Event Type:', 'maxcoach' ),
								];
								?>
								<select class="maxcoach-nice-select event-type" name="type"
								        data-select="<?php echo esc_attr( wp_json_encode( $select_settings ) ); ?>">
									<?php foreach ( $options as $value => $text ) : ?>
										<option
											value="<?php echo esc_attr( $value ); ?>" <?php selected( $selected, $value ); ?> >
											<?php echo esc_html( $text ); ?>
										</option>
									<?php endforeach; ?>
								</select>
								<input type="hidden" name="paged" value="1">
							</form>
						</div>
					</div>

					<?php
					/**
					 * tp_event_before_event_loop hook
					 *
					 * @hooked tp_event_result_count - 20
					 * @hooked tp_event_catalog_ordering - 30
					 */
					do_action( 'tp_event_before_event_loop' );
					?>

					<?php
					$wrapper_classes = [
						'maxcoach-main-post',
						'maxcoach-grid-wrapper',
						'maxcoach-event',
						'maxcoach-animation-zoom-in',
					];

					$lg_columns = Maxcoach::setting( 'event_archive_lg_columns', 3 );
					$md_columns = Maxcoach::setting( 'event_archive_md_columns' );
					$sm_columns = Maxcoach::setting( 'event_archive_sm_columns' );

					$grid_options = [
						'type'          => 'grid',
						'columns'       => $lg_columns,
						'columnsTablet' => $md_columns,
						'columnsMobile' => $sm_columns,
						'gutter'        => 30,
					];
					?>
					<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>"
					     data-grid="<?php echo esc_attr( wp_json_encode( $grid_options ) ); ?>"
					>
						<div class="maxcoach-grid">
							<div class="grid-sizer"></div>

							<?php while ( have_posts() ) : the_post(); ?>
								<?php wpems_get_template_part( 'content', 'event' ); ?>
							<?php endwhile; // end of the loop. ?>
						</div>
					</div>

					<?php
					/**
					 * tp_event_after_event_loop hook
					 *
					 * @hooked tp_event_pagination - 10
					 */
					do_action( 'tp_event_after_event_loop' );
					?>

				<?php endif; ?>

				<?php
				/**
				 * tp_event_after_main_content hook
				 *
				 * @hooked tp_event_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action( 'tp_event_after_main_content' );
				?>

				<?php
				/**
				 * tp_event_sidebar hook
				 *
				 * @hooked tp_event_get_sidebar - 10
				 */
				do_action( 'tp_event_sidebar' );
				?>
			</div>

			<?php Maxcoach_Templates::render_sidebar( 'right' ); ?>

		</div>
	</div>
</div>
<?php get_footer(); ?>
