<?php
/**
 * The Template for displaying single events page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/single-event.php
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>

	<div class="entry-hero-section">
		<?php
		/**
		 * tp_event_single_event_thumbnail hook
		 */
		do_action( 'tp_event_single_event_thumbnail' );
		?>

		<div class="container entry-hero-content">
			<div class="row">
				<div class="col-md-12">
					<div class="entry-date">
						<?php
						$time = wpems_get_time( 'Y-m-d H:i', null, false );
						$date = wp_date( 'F d', strtotime( $time ) );

						echo esc_html( $date );
						?>
					</div>

					<?php
					/**
					 * tp_event_single_event_title hook
					 */
					do_action( 'tp_event_single_event_title' );

					/**
					 * tp_event_loop_event_countdown hook
					 */
					do_action( 'tp_event_loop_event_countdown' );
					?>
				</div>
			</div>
		</div>

	</div>

	<div id="page-content" class="page-content">
		<div class="container">
			<div class="row">

				<?php Maxcoach_Templates::render_sidebar( 'left' ); ?>

				<div class="page-main-content">
					<?php if ( have_posts() ) : ?>

						<?php while ( have_posts() ) : the_post(); ?>

							<?php wpems_get_template_part( 'content', 'single-event' ); ?>

							<?php
							// If comments are open or we have at least one comment, load up the comment template.
							if ( '1' === Maxcoach::setting( 'single_event_comment_enable' ) && ( comments_open() || get_comments_number() ) ) :
								comments_template();
							endif;
							?>
						<?php endwhile; ?>

						<?php the_posts_navigation(); ?>

					<?php else : ?>
						<?php get_template_part( 'template-parts/content', 'none' ); ?>
					<?php endif; ?>
				</div>

				<?php Maxcoach_Templates::render_sidebar( 'right' ); ?>

			</div>
		</div>
	</div>
<?php get_footer();
