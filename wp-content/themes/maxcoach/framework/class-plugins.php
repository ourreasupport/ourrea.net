<?php
defined( 'ABSPATH' ) || exit;

/**
 * Plugin installation and activation for WordPress themes
 */
if ( ! class_exists( 'Maxcoach_Register_Plugins' ) ) {
	class Maxcoach_Register_Plugins {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function initialize() {
			add_filter( 'insight_core_tgm_plugins', array( $this, 'register_required_plugins' ) );
		}

		public function register_required_plugins( $plugins ) {
			/*
			 * Array of plugin arrays. Required keys are name and slug.
			 * If the source is NOT from the .org repo, then source is also required.
			 */
			$new_plugins = array(
				array(
					'name'     => esc_html__( 'Insight Core', 'maxcoach' ),
					'slug'     => 'insight-core',
					'source'   => 'https://api.thememove.com/download/insight-core-1.7.9-Ir5VJWPiQ4.zip',
					'version'  => '1.7.9',
					'required' => true,
				),
				array(
					'name'     => esc_html__( 'Elementor', 'maxcoach' ),
					'slug'     => 'elementor',
					'required' => true,
				),
				array(
					'name'     => esc_html__( 'Elementor Pro', 'maxcoach' ),
					'slug'     => 'elementor-pro',
					'source'   => 'https://api.thememove.com/download/elementor-pro-3.0.9-aSAhR9Z4n2.zip',
					'version'  => '3.0.9',
					'required' => true,
				),
				array(
					'name'    => esc_html__( 'Revolution Slider', 'maxcoach' ),
					'slug'    => 'revslider',
					'source'  => 'https://api.thememove.com/download/revslider-6.3.5-PmzBJ2rZ1n.zip',
					'version' => '6.3.5',
				),
				array(
					'name' => esc_html__( 'LearnPress – WordPress LMS Plugin', 'maxcoach' ),
					'slug' => 'learnpress',
				),
				array(
					'name' => esc_html__( 'LearnPress – Course Review', 'maxcoach' ),
					'slug' => 'learnpress-course-review',
				),
				array(
					'name'    => esc_html__( 'ThemeMove Payment Add-ons for LearnPress', 'maxcoach' ),
					'slug'    => 'thememove-payment',
					'source'  => 'https://www.dropbox.com/s/3lomuvla3h97xe3/thememove-payment-1.0.1.zip?dl=1',
					'version' => '1.0.1',
				),
				array(
					'name' => esc_html__( 'Paid Memberships Pro', 'maxcoach' ),
					'slug' => 'paid-memberships-pro',
				),
				array(
					'name'    => esc_html__( 'LearnPress - Paid Membership Pro Integration', 'maxcoach' ),
					'slug'    => 'learnpress-paid-membership-pro',
					'source'  => 'https://www.dropbox.com/s/ph6ddz1e0stsg54/learnpress-paid-membership-pro-3.1.9.zip?dl=1',
					'version' => '3.1.9',
				),
				array(
					'name' => esc_html__( 'WP Events Manager', 'maxcoach' ),
					'slug' => 'wp-events-manager',
				),
				array(
					'name' => esc_html__( 'Video Conferencing with Zoom', 'maxcoach' ),
					'slug' => 'video-conferencing-with-zoom-api',
				),
				array(
					'name'     => esc_html__( 'Taxonomy Thumbnail', 'maxcoach' ),
					'slug'     => 'sf-taxonomy-thumbnail',
					'required' => true,
				),
				array(
					'name' => esc_html__( 'Contact Form 7', 'maxcoach' ),
					'slug' => 'contact-form-7',
				),
				array(
					'name' => esc_html__( 'MailChimp for WordPress', 'maxcoach' ),
					'slug' => 'mailchimp-for-wp',
				),
				array(
					'name' => esc_html__( 'WooCommerce', 'maxcoach' ),
					'slug' => 'woocommerce',
				),
				array(
					'name' => esc_html__( 'WPC Smart Compare for WooCommerce', 'maxcoach' ),
					'slug' => 'woo-smart-compare',
				),
				array(
					'name' => esc_html__( 'WPC Smart Wishlist for WooCommerce', 'maxcoach' ),
					'slug' => 'woo-smart-wishlist',
				),
				array(
					'name' => esc_html__( 'WP-PostViews', 'maxcoach' ),
					'slug' => 'wp-postviews',
				),
				array(
					'name'    => esc_html__( 'Instagram Feed', 'maxcoach' ),
					'slug'    => 'elfsight-instagram-feed-cc',
					'source'  => 'https://api.thememove.com/download/elfsight-instagram-feed-cc-4.0.1-bfaRxLvWr9.zip',
					'version' => '4.0.1',
				),
			);

			$plugins = array_merge( $plugins, $new_plugins );

			return $plugins;
		}

	}

	Maxcoach_Register_Plugins::instance()->initialize();
}
