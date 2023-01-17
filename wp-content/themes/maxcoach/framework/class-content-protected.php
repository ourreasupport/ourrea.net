<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Maxcoach_Content_Protected' ) ) {
	class Maxcoach_Content_Protected {

		protected static $instance = null;

		static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_action( 'wp_footer', array( $this, 'output_template' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		}

		public function output_template() {
			$content_protected = Maxcoach::setting( 'content_protected_enable' );

			if ( ! $content_protected ) {
				return;
			}

			?>
			<div id="maxcoach-content-protected-box" class="maxcoach-content-protected-box">
				<?php printf( esc_html__(
					'%sAlert:%s You are not allowed to copy content or view source !!', 'maxcoach'
				), '<span class="alert-label">', '</span>' ); ?>
			</div>
			<?php
		}

		public function frontend_scripts() {
			$content_protected = Maxcoach::setting( 'content_protected_enable' );

			if ( ! $content_protected ) {
				return;
			}

			wp_register_script( 'maxcoach-content-protected', MAXCOACH_THEME_ASSETS_URI . '/js/content-protected.js', [ 'jquery' ], null, true );

			wp_enqueue_script( 'maxcoach-content-protected' );
		}
	}

	Maxcoach_Content_Protected::instance()->initialize();
}
