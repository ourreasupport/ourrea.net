<?php
defined( 'ABSPATH' ) || exit;

/**
 * Enqueue child scripts
 */
if ( ! function_exists( 'maxcoach_child_enqueue_scripts' ) ) {
	function maxcoach_child_enqueue_scripts() {
		wp_enqueue_style( 'maxcoach-child-style', get_stylesheet_directory_uri() . '/style.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'maxcoach_child_enqueue_scripts', 15 );
