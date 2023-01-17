<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Maxcoach_Membership' ) ) {
	class Maxcoach_Membership {

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

			add_filter( 'maxcoach_custom_css_primary_color_selectors', [ $this, 'custom_css' ] );

			// Disable email confirm.
			add_filter( 'pmpro_checkout_confirm_email', '__return_false' );

			add_action( 'wp_enqueue_scripts', [ $this, 'custom_enqueue' ], 11 );
		}

		/**
		 * Check The Membership plugin activated.
		 *
		 * @return boolean true if plugin activated
		 */
		public function is_activated() {
			if ( function_exists( 'pmpro_activation' ) ) {
				return true;
			}

			return false;
		}

		public function custom_css( $selectors ) {
			$selectors['color'][] = "
				.lp-pmpro-membership-list .lp-price .amount,
				#pmpro_level_cost strong
			";

			$selectors['background-color'][] = "
				.pmpro_form table th
			";

			return $selectors;
		}

		public function custom_enqueue() {
			if ( function_exists( 'pmpro_is_checkout' ) && pmpro_is_checkout() ) {
				wp_enqueue_script( 'maxcoach-tab-panel' );
			}
		}

	}

	Maxcoach_Membership::instance()->initialize();
}
