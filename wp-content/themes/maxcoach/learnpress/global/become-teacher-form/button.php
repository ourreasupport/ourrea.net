<?php
/**
 * Template for displaying submit button of become teacher form.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/global/become-teacher-form/button.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<button type="submit" data-text="<?php esc_attr_e( 'Submitting', 'maxcoach' ); ?>"><?php esc_html_e( 'Get the learning program', 'maxcoach' ); ?></button>
