<?php
defined( 'ABSPATH' ) || exit;

/**
 * Initial OneClick import for this theme
 */
if ( ! class_exists( 'Maxcoach_Import' ) ) {
	class Maxcoach_Import {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_filter( 'insight_core_import_demos', array( $this, 'import_demos' ) );
			add_filter( 'insight_core_import_generate_thumb', array( $this, 'generate_thumbnail' ) );
		}

		public function import_demos() {
			$import_img_url = MAXCOACH_THEME_URI . '/assets/import';

			return array(
				'main'    => array(
					'screenshot' => MAXCOACH_THEME_URI . '/screenshot.jpg',
					'name'       => esc_html__( 'Main', 'maxcoach' ),
					'url'        => 'https://api.thememove.com/import/maxcoach/maxcoach-insightcore-main-2.0.0.zip',
				),
				'rtl'     => array(
					'screenshot' => $import_img_url . '/rtl/screenshot.jpg',
					'name'       => esc_html__( 'RTL', 'maxcoach' ),
					'url'        => 'https://api.thememove.com/import/maxcoach/maxcoach-insightcore-rtl-1.0.0.zip',
				),
				'landing' => array(
					'screenshot' => $import_img_url . '/landing/screenshot.jpg',
					'name'       => esc_html__( 'Landing Page', 'maxcoach' ),
					'url'        => 'https://api.thememove.com/import/maxcoach/maxcoach-insightcore-landing-1.0.0.zip',
				),
			);
		}

		/**
		 * Generate thumbnail while importing
		 */
		function generate_thumbnail() {
			return false;
		}
	}

	Maxcoach_Import::instance()->initialize();
}
