<?php
/**
 * The template for displaying archive of meetings
 *
 * This template can be overridden by copying it to yourtheme/video-conferencing-zoom/archive-meetings.php.
 *
 * @author Deepen
 * @since  3.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
	<div id="page-content" class="page-content">
		<div class="container">
			<div class="row">

				<?php Maxcoach_Templates::render_sidebar( 'left' ); ?>

				<div id="page-main-content" class="page-main-content">

					<?php if ( have_posts() ) : ?>

						<?php
						$wrapper_classes = [
							'maxcoach-main-post',
							'maxcoach-grid-wrapper',
							'maxcoach-zoom-meetings',
							'maxcoach-animation-zoom-in',
						];

						$lg_columns = Maxcoach::setting( 'zoom_meeting_archive_lg_columns', 3 );
						$md_columns = Maxcoach::setting( 'zoom_meeting_archive_md_columns' );
						$sm_columns = Maxcoach::setting( 'zoom_meeting_archive_sm_columns' );

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
									<?php vczapi_get_template_part( 'content', 'meeting' );; ?>
								<?php endwhile; // end of the loop. ?>
							</div>

							<div class="maxcoach-grid-pagination">
								<?php Maxcoach_Templates::paging_nav(); ?>
							</div>
						</div>

					<?php endif; ?>
				</div>

				<?php Maxcoach_Templates::render_sidebar( 'right' ); ?>

			</div>
		</div>
	</div>
<?php
get_footer();
