<?php
/**
 * The Template for displaying content single event.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/content-single-event.php
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<article id="tp_event-<?php the_ID(); ?>" <?php post_class( 'tp_single_event' ); ?>>
	<?php
	/**
	 * tp_event_before_single_event hook
	 *
	 */
	do_action( 'tp_event_before_single_event' );
	?>

	<div class="summary entry-summary">

		<div class="entry-header">
			<h3 class="entry-event-heading entry-event-heading-about"><?php esc_html_e( 'About The Event', 'maxcoach' ); ?></h3>

			<div class="entry-meta">
				<?php
				$date_start = get_post_meta( get_the_ID(), 'tp_event_date_start', true ) ? strtotime( get_post_meta( get_the_ID(), 'tp_event_date_start', true ) ) : time();
				$date_end   = get_post_meta( get_the_ID(), 'tp_event_date_end', true ) ? strtotime( get_post_meta( get_the_ID(), 'tp_event_date_end', true ) ) : time();
				$time_start = wpems_event_start( get_option( 'time_format' ) );
				$time_end   = wpems_event_end( get_option( 'time_format' ) );
				$location   = get_post_meta( get_the_ID(), Maxcoach_Event::POST_META_SHORT_LOCATION, true );

				$date_string = '';
				if ( $date_start === $date_end ) {
					$date_string = wp_date( get_option( 'date_format' ), $date_start );
				} else {
					$date_string = wp_date( get_option( 'date_format' ), $date_start ) . ' - ' . wp_date( get_option( 'date_format' ), $date_end );
				}
				?>
				<?php if ( $location ) : ?>
					<div class="meta-item">
						<i class="meta-icon fal fa-map-marker-alt"></i>
						<span><?php echo esc_html( $location ); ?></span>
					</div>
				<?php endif; ?>

				<div class="meta-item">
					<i class="meta-icon fal fa-calendar"></i>
					<span><?php echo esc_html( $date_string ); ?></span>
				</div>

				<div class="meta-item">
					<i class="meta-icon fal fa-clock"></i>
					<span><?php echo esc_html( $time_start . ' - ' . $time_end ); ?></span>
				</div>
			</div>
		</div>

		<div class="entry-details">
			<div class="row">
				<div class="col-md-8">
					<?php
					/**
					 * tp_event_loop_event_location hook
					 */
					do_action( 'tp_event_loop_event_location' );
					?>
				</div>
				<div class="col-md-4">
					<div class="entry-details-bar">
						<?php
						/**
						 * tp_event_after_single_event hook
						 *
						 * @hooked tp_event_after_single_event - 10
						 */
						do_action( 'tp_event_after_single_event' );
						?>

						<div class="entry-share">
							<?php Maxcoach_Event::instance()->entry_sharing(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<?php
				/**
				 * tp_event_single_event_content hook
				 */
				do_action( 'tp_event_single_event_content' );
				?>
			</div>
			<!--<div class="col-md-4"></div>-->
		</div>

		<?php Maxcoach_Event::instance()->get_the_speakers_slider(); ?>

	</div><!-- .summary -->
</article><!-- #product-<?php the_ID(); ?> -->
