<?php
defined( 'ABSPATH' ) || exit;

/**
 * Theme Hook Alliance hook stub list.
 */

if ( ! class_exists( 'Maxcoach_THA' ) ) {

	class Maxcoach_THA {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function head_top() {
			do_action( 'maxcoach/head-top' );
		}

		function head_bottom() {
			do_action( 'maxcoach/head-bottom' );
		}

		function header_wrap_top() {
			do_action( 'maxcoach/header-wrap-top' );
		}

		function header_wrap_bottom() {
			do_action( 'maxcoach/header-wrap-bottom' );
		}

		function header_right_top() {
			do_action( 'maxcoach/header-right-top' );
		}

		function header_right_bottom() {
			do_action( 'maxcoach/header-right-bottom' );
		}

		function footer_before() {
			do_action( 'maxcoach/footer-before' );
		}

		function footer_after() {
			do_action( 'maxcoach/footer-after' );
		}

		function title_bar_heading_before() {
			do_action( 'maxcoach/title-bar-heading-before' );
		}

		function title_bar_heading_after() {
			do_action( 'maxcoach/title-bar-heading-after' );
		}

		function title_bar_meta() {
			do_action( 'maxcoach/title-bar-meta' );
		}
	}

}
