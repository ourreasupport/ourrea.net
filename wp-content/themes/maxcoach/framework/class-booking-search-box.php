<?php
defined( 'ABSPATH' ) || exit;
/**
 * Booking.com Official Search Box plugin.
 */
if ( ! class_exists( 'Maxcoach_Booking_Search_Box' ) ) {
	class Maxcoach_Booking_Search_Box {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			// Do nothing if plugin not activated.
			if ( ! $this->is_activated() ) {
				return;
			}

			add_filter( 'maxcoach_customize_output_button_typography_selectors', [
				$this,
				'customize_output_button_typography_selectors',
			] );

			add_filter( 'maxcoach_customize_output_form_input_focus_selectors', [
				$this,
				'customize_output_form_input_focus_selectors',
			] );

			add_action( 'wp_enqueue_scripts', [ $this, 'frontend_enqueue' ], 12 );
		}

		/**
		 * Check plugin activated.
		 *
		 * @return boolean true if plugin activated
		 */
		public function is_activated() {
			if ( defined( 'BOS_PLUGIN_VERSION' ) ) {
				return true;
			}

			return false;
		}

		public function frontend_enqueue() {
			/**
			 * Remove scripts & styles enqueue for all pages.
			 */
			wp_dequeue_style( 'bos_sb_main_css' );
			wp_dequeue_script( 'bos_main_js' );
			wp_dequeue_script( 'bos_date_js' );
		}

		public function customize_output_button_typography_selectors( $selectors ) {
			$new_selectors = [ '.maxcoach-booking-form #flexi_searchbox #b_searchboxInc .b_submitButton_wrapper .b_submitButton' ];

			$final_selectors = array_merge( $selectors, $new_selectors );

			return $final_selectors;
		}

		public function customize_output_form_input_focus_selectors( $selectors ) {
			$new_selectors = [ '.maxcoach-booking-form #flexi_searchbox #b_searchboxInc #b_destination:focus' ];

			$final_selectors = array_merge( $selectors, $new_selectors );

			return $final_selectors;
		}
	}

	Maxcoach_Booking_Search_Box::instance()->initialize();
}
