<?php
/**
 * The template for displaying meeting details of zoom
 *
 * This template can be overridden by copying it to yourtheme/video-conferencing-zoom/fragments/meeting-details.php.
 *
 * @author     Deepen.
 * @created_on 11/19/19
 * @modified   3.3.0
 */

global $zoom;

if ( ! empty( $zoom['user'] ) && ! empty( $zoom['user']->first_name ) ) {
	$hosted_by = $zoom['user']->first_name . ' ' . $zoom['user']->last_name;
} else {
	$hosted_by = get_the_author();
}
?>
<div class="dpn-zvc-sidebar-box box-style-02">
	<div class="dpn-zvc-sidebar-tile">
		<h3><?php esc_html_e( 'Details', 'maxcoach' ); ?></h3>
	</div>
	<div class="dpn-zvc-sidebar-content">
		<div class="dpn-zvc-sidebar-content-list">
			<span class="name heading"><?php esc_html_e( 'Hosted By', 'maxcoach' ); ?></span>
			<span class="value"><?php echo esc_html( $hosted_by ); ?></span>
		</div>
		<?php if ( ! empty( $zoom['start_date'] ) ) { ?>
			<div class="dpn-zvc-sidebar-content-list">
				<span class="name heading"><?php esc_html_e( 'Start', 'maxcoach' ); ?></span>
				<span
					class="value sidebar-start-time"><?php echo date( 'F j, Y @ g:i a', strtotime( $zoom['start_date'] ) ); ?></span>
			</div>
		<?php } ?>
		<?php if ( ! empty( $zoom['terms'] ) ) { ?>
			<div class="dpn-zvc-sidebar-content-list">
				<span class="name heading"><?php esc_html_e( 'Category', 'maxcoach' ); ?></span>
				<span class="value"><?php echo implode( ', ', $zoom['terms'] ); ?></span>
			</div>
		<?php } ?>
		<?php if ( ! empty( $zoom['duration'] ) ) { ?>
			<div class="dpn-zvc-sidebar-content-list">
				<span class="name heading"><?php esc_html_e( 'Duration', 'maxcoach' ); ?></span>
				<span
					class="value"><?php printf( '%s %s', $zoom['duration'], _n( 'minute', 'minutes', $zoom['duration'], 'maxcoach' ) ); ?></span>
			</div>
		<?php } ?>
		<?php if ( ! empty( $zoom['timezone'] ) ) { ?>
			<div class="dpn-zvc-sidebar-content-list">
				<span class="name heading"><?php esc_html_e( 'Timezone', 'maxcoach' ); ?></span>
				<span class="value"><?php echo $zoom['timezone']; ?></span>
			</div>
		<?php } ?>
		<p class="dpn-zvc-display-or-hide-localtimezone-notice"><?php printf( __( '%sNote%s: Countdown time is shown based on your local timezone.', 'maxcoach' ), '<strong class="heading-color">', '</strong>' ); ?></p>
	</div>
</div>
