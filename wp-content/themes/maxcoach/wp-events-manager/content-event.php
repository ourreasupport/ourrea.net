<?php
/**
 * The Template for displaying content events.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/content-event.php
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

/**
 * tp_event_before_loop_event hook
 *
 */
do_action( 'tp_event_before_loop_event' );

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}

$extra_classes = 'grid-item';
?>

<div id="event-<?php the_ID(); ?>" <?php post_class( $extra_classes ); ?>>

	<?php
	/**
	 * tp_event_before_loop_event_summary hook
	 *
	 * @hooked tp_event_show_event_sale_flash - 10
	 * @hooked tp_event_show_event_images - 20
	 */
	do_action( 'tp_event_before_loop_event_item' );
	?>

	<a href="<?php the_permalink() ?>" class="maxcoach-box link-secret">
		<div class="event-image maxcoach-image">
			<?php
			/**
			 * tp_event_single_event_thumbnail hook
			 */
			do_action( 'tp_event_single_event_thumbnail' );
			?>

			<div class="event-overlay-background"></div>

			<div class="event-overlay-content">
				<div class="inner">
					<div class="tm-button-wrapper">
						<div class="tm-button style-flat tm-button-xs event-get-ticket">
							<div class="button-content-wrapper">
								<span class="button-text"><?php esc_html_e( 'Get ticket', 'maxcoach' ); ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="event-caption">
			<div class="event-date primary-color">
				<?php $time_from = get_post_meta( get_the_ID(), 'tp_event_date_start', true ) ? strtotime( get_post_meta( get_the_ID(), 'tp_event_date_start', true ) ) : time(); ?>
				<?php echo wp_date( get_option( 'date_format' ), $time_from ); ?>
			</div>
			<h3 class="event-title"><?php the_title(); ?></h3>

			<?php $location = get_post_meta( get_the_ID(), Maxcoach_Event::POST_META_SHORT_LOCATION, true ); ?>
			<?php if ( $location ): ?>
				<div class="event-location">
					<span class="far fa-map-marker-alt"></span>
					<?php echo esc_html( $location ); ?>
				</div>
			<?php endif; ?>
		</div>
	</a>

	<?php
	/**
	 * tp_event_after_loop_event_item hook
	 *
	 * @hooked tp_event_show_event_sale_flash - 10
	 * @hooked tp_event_show_event_images - 20
	 */
	do_action( 'tp_event_after_loop_event_item' );
	?>
</div>

<?php do_action( 'tp_event_after_loop_event' ); ?>
