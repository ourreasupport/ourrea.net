<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Maxcoach_Widgets' ) ) {
	class Maxcoach_Widgets {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function initialize() {
			// Register widget areas.
			add_action( 'widgets_init', array(
				$this,
				'register_sidebars',
			) );

			add_filter( 'insight_core_dynamic_sidebar_args', [ $this, 'change_sidebar_args' ] );
		}

		/**
		 * Change sidebar args of dynamic sidebar.
		 *
		 * @param $args
		 *
		 * @return array
		 */
		public function change_sidebar_args( $args ) {
			$args['before_title'] = '<p class="widget-title heading">';
			$args['after_title']  = '</p>';

			return $args;
		}

		public function get_default_sidebar_args() {
			return [
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<p class="widget-title heading">',
				'after_title'   => '</p>',
			];
		}

		/**
		 * Register widget area.
		 *
		 * @access public
		 * @link   https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
		 */
		public function register_sidebars() {
			$default_args = $this->get_default_sidebar_args();

			register_sidebar( array_merge( $default_args, array(
				'id'          => 'blog_sidebar',
				'name'        => esc_html__( 'Blog Sidebar', 'maxcoach' ),
				'description' => esc_html__( 'Add widgets here.', 'maxcoach' ),
			) ) );

			register_sidebar( array_merge( $default_args, array(
				'id'          => 'page_sidebar',
				'name'        => esc_html__( 'Page Sidebar', 'maxcoach' ),
				'description' => esc_html__( 'Add widgets here.', 'maxcoach' ),
			) ) );

			register_sidebar( array_merge( $default_args, array(
				'id'          => 'shop_sidebar',
				'name'        => esc_html__( 'Shop Sidebar', 'maxcoach' ),
				'description' => esc_html__( 'Add widgets here.', 'maxcoach' ),
			) ) );

			register_sidebar( array_merge( $default_args, array(
				'id'          => 'course_sidebar',
				'name'        => esc_html__( 'Course Sidebar', 'maxcoach' ),
				'description' => esc_html__( 'Add widgets here.', 'maxcoach' ),
			) ) );

			register_sidebar( array_merge( $default_args, array(
				'id'          => 'off_sidebar',
				'name'        => esc_html__( 'Off Sidebar', 'maxcoach' ),
				'description' => esc_html__( 'Add widgets here.', 'maxcoach' ),
			) ) );

			register_sidebar( array_merge( $default_args, array(
				'id'          => 'top_bar_widgets',
				'name'        => esc_html__( 'Top Bar Widgets', 'maxcoach' ),
				'description' => esc_html__( 'Add widgets here.', 'maxcoach' ),
			) ) );
		}
	}

	Maxcoach_Widgets::instance()->initialize();
}
