<?php
/*
Plugin Name: Thememove Payment Add-ons for LearnPress
Description: Add stripe method for LearnPress
Author: Thememove
Version: 1.0.1
Author URI: https://thememove.com
Text Domain: thememove-payment
Domain Path: /languages/
*/

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'thememove_payment' ) ) {

	class thememove_payment {

		public function __construct() {
			// Check if LearnPress plugin installed and activated.
			if ( ! class_exists( 'LearnPress' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );

				return;
			}

			$this->define_constants();
			$this->load_textdomain();
			$this->includes();

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			// Filter
			add_filter( 'learn_press_payment_method', array( $this, 'custom_gateways' ) );

			// 3.0.0
			add_filter( 'learn-press/payment-methods', array( $this, 'custom_gateways' ) );
		}

		/**
		 *  Define constant
		 **/
		private function define_constants() {

			$plugin_dir_name = dirname( __FILE__ );
			$plugin_dir_name = str_replace( '\\', '/', $plugin_dir_name );
			$plugin_dir_name = explode( '/', $plugin_dir_name );
			$plugin_dir_name = end( $plugin_dir_name );

			if ( ! defined( 'THEMEMOVE_PLUGIN_FILE' ) ) {
				define( 'THEMEMOVE_PLUGIN_FILE', __FILE__ );
			}

			if ( ! defined( 'THEMEMOVE_PLUGIN_NAME' ) ) {
				define( 'THEMEMOVE_PLUGIN_NAME', $plugin_dir_name );
			}

			if ( ! defined( 'THEMEMOVE_PLUGIN_DIR' ) ) {
				define( 'THEMEMOVE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}
			if ( ! defined( 'THEMEMOVE_PLUGIN_URL' ) ) {
				define( 'THEMEMOVE_PLUGIN_URL', trailingslashit( plugins_url( THEMEMOVE_PLUGIN_NAME ) ) );
			}

			if ( ! defined( 'THEMEMOVE_PLUGIN_PREFIX' ) ) {
				define( 'THEMEMOVE_PLUGIN_PREFIX', 'thememove' );
			}

			if ( ! defined( 'THEMEMOVE_METABOX_PREFIX' ) ) {
				define( 'THEMEMOVE_METABOX_PREFIX', 'thememove-' );
			}

			if ( ! defined( 'THEMEMOVE_OPTIONS_NAME' ) ) {
				define( 'THEMEMOVE_OPTIONS_NAME', 'thememove-' );
			}

			if ( ! defined( 'THEMEMOVE_PLUGIN_VER' ) ) {
				define( 'THEMEMOVE_PLUGIN_VER', '1.0.0' );
			}

			if ( ! defined( 'THEMEMOVE_AJAX_URL' ) ) {
				$ajax_url = admin_url( 'admin-ajax.php', 'relative' );
				define( 'THEMEMOVE_AJAX_URL', $ajax_url );
			}
		}

		public function load_textdomain() {
			$mofile = THEMEMOVE_PLUGIN_DIR . 'languages/' . 'tm-payment-' . get_locale() . '.mo';

			if ( file_exists( $mofile ) ) {
				load_textdomain( 'tm-payment', $mofile );
			}
		}

		/**
		 * Register the JavaScript for the admin area.
		 */
		public function enqueue_scripts() {
			wp_register_script( 'thememove-payment-script', THEMEMOVE_PLUGIN_URL . 'assets/js/main.js', array(
				'jquery',
				'stripe-checkout',
			), THEMEMOVE_PLUGIN_VER, true );

			if ( learn_press_is_checkout() ) {
				wp_enqueue_script( 'thememove-payment-script' );
			}
		}

		/**
		 *  Includes
		 **/
		public function includes() {

			include_once( THEMEMOVE_PLUGIN_DIR . 'gateways/stripe/init.php' );

		}

		public function custom_gateways( $gateways = array() ) {
			$gateways['stripe'] = 'TM_Gateway_Stripe';

			return $gateways;
		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have LearnPress installed or activated.
		 *
		 * @since  1.0.1
		 *
		 * @access public
		 */
		public function admin_notice_missing_main_plugin() {

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				esc_html__( '%1$sThememove Payment Add-ons for LearnPress%2$s requires %1$sLearnPress%2$s version 3.0.0 or higher is %1$sinstalled%2$s and %1$sactivated%2$s.', 'thememove-payment' ),
				'<strong>', '</strong>'
			);

			printf( '<div class="error"><p>%1$s</p></div>', $message );

		}
	}

	new thememove_payment();
}
