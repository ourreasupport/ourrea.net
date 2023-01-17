<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Maxcoach_Course_Review' ) ) {
	class Maxcoach_Course_Review {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			if ( ! $this->is_activated() ) {
				return;
			}
		}

		/**
		 * Check LearnPress Review add-on plugin activated.
		 *
		 * @return boolean true if plugin activated
		 */
		public function is_activated() {
			if ( defined( 'LP_ADDON_COURSE_REVIEW_VER' ) ) {
				return true;
			}

			return false;
		}
	}

	Maxcoach_Course_Review::instance()->initialize();
}
