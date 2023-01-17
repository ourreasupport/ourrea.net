<?php

namespace Maxcoach_Elementor;

use Elementor\Plugin;

defined( 'ABSPATH' ) || exit;

class Widget_Init {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function initialize() {
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );

		// Registered Widgets.
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		//add_action( 'elementor/widgets/widgets_registered', [ $this, 'remove_unwanted_widgets' ], 15 );

		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'after_register_scripts' ] );
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'after_register_styles' ] );

		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );

		add_filter( 'elementor/utils/get_the_archive_title', [ $this, 'change_portfolio_archive_title' ] );

		// Modify original widgets settings.
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/original/modify-base.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/original/section.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/original/column.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/original/accordion.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/original/animated-headline.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/original/counter.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/original/form.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/original/heading.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/original/icon-box.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/original/progress.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/original/countdown.php';
	}

	/**
	 * Register scripts for widgets.
	 */
	public function after_register_scripts() {
		// Fix Wordpress old version not registered this script.
		if ( ! wp_script_is( 'imagesloaded', 'registered' ) ) {
			wp_register_script( 'imagesloaded', MAXCOACH_THEME_URI . '/assets/libs/imagesloaded/imagesloaded.min.js', array( 'jquery' ), null, true );
		}

		wp_register_script( 'circle-progress', MAXCOACH_THEME_URI . '/assets/libs/circle-progress/circle-progress.min.js', array( 'jquery' ), null, true );
		wp_register_script( 'maxcoach-widget-circle-progress', MAXCOACH_ELEMENTOR_URI . '/assets/js/widgets/widget-circle-progress.js', array(
			'jquery',
			'circle-progress',
		), null, true );

		wp_register_script( 'maxcoach-swiper-wrapper', MAXCOACH_THEME_URI . '/assets/js/swiper-wrapper.js', array( 'swiper' ), MAXCOACH_THEME_VERSION, true );
		wp_register_script( 'maxcoach-group-widget-carousel', MAXCOACH_ELEMENTOR_URI . '/assets/js/widgets/group-widget-carousel.js', array(
			'jquery',
			'swiper',
			'maxcoach-swiper-wrapper',
		), null, true );
		$maxcoach_swiper_js = array(
			'prevText' => esc_html__( 'Prev', 'maxcoach' ),
			'nextText' => esc_html__( 'Next', 'maxcoach' ),
		);
		wp_localize_script( 'maxcoach-swiper-wrapper', '$maxcoachSwiper', $maxcoach_swiper_js );

		wp_register_script( 'isotope-masonry', MAXCOACH_THEME_URI . '/assets/libs/isotope/js/isotope.pkgd.js', array( 'jquery' ), MAXCOACH_THEME_VERSION, true );
		wp_register_script( 'isotope-packery', MAXCOACH_THEME_URI . '/assets/libs/packery-mode/packery-mode.pkgd.js', array( 'jquery' ), MAXCOACH_THEME_VERSION, true );

		wp_register_script( 'maxcoach-grid-layout', MAXCOACH_THEME_ASSETS_URI . '/js/grid-layout.js', array(
			'jquery',
			'imagesloaded',
			'matchheight',
			'isotope-masonry',
			'isotope-packery',
		), null, true );
		wp_register_script( 'maxcoach-grid-query', MAXCOACH_ELEMENTOR_URI . '/assets/js/widgets/grid-query.js', array( 'jquery' ), null, true );

		wp_register_script( 'maxcoach-widget-grid-post', MAXCOACH_ELEMENTOR_URI . '/assets/js/widgets/widget-grid-post.js', array( 'maxcoach-grid-layout' ), null, true );
		wp_register_script( 'maxcoach-group-widget-grid', MAXCOACH_ELEMENTOR_URI . '/assets/js/widgets/group-widget-grid.js', array( 'maxcoach-grid-layout' ), null, true );

		wp_register_script( 'maxcoach-widget-google-map', MAXCOACH_ELEMENTOR_URI . '/assets/js/widgets/widget-google-map.js', array( 'jquery' ), null, true );

		wp_register_script( 'vivus', MAXCOACH_ELEMENTOR_URI . '/assets/libs/vivus/vivus.js', array( 'jquery' ), null, true );
		wp_register_script( 'maxcoach-widget-icon-box', MAXCOACH_ELEMENTOR_URI . '/assets/js/widgets/widget-icon-box.js', array(
			'jquery',
			'vivus',
		), null, true );

		wp_register_script( 'maxcoach-widget-flip-box', MAXCOACH_ELEMENTOR_URI . '/assets/js/widgets/widget-flip-box.js', array(
			'jquery',
			'imagesloaded',
		), null, true );

		wp_register_script( 'maxcoach-widget-accordion', MAXCOACH_ELEMENTOR_URI . '/assets/js/widgets/widget-accordion.js', array(
			'jquery',
		), null, true );

		wp_register_script( 'anime', MAXCOACH_ELEMENTOR_URI . '/assets/libs/anime/anime.min.js', array(
			'jquery',
		), null, true );

		wp_register_script( 'maxcoach-vertical-carousel-3d', MAXCOACH_ELEMENTOR_URI . '/assets/js/widgets/vertical-carousel-3d.js', array(
			'anime',
		), null, true );

		wp_register_script( 'maxcoach-widget-testimonial-carousel-3d', MAXCOACH_ELEMENTOR_URI . '/assets/js/widgets/widget-testimonial-carousel-3d.js', array(
			'maxcoach-vertical-carousel-3d',
		), null, true );

		wp_register_script( 'maxcoach-widget-gallery-justified-content', MAXCOACH_ELEMENTOR_URI . '/assets/js/widgets/widget-gallery-justified-content.js', array(
			'justifiedGallery',
		), null, true );

		wp_register_script( 'count-to', MAXCOACH_ELEMENTOR_URI . '/assets/libs/countTo/jquery.countTo.min.js', array( 'jquery' ), null, true );
		wp_register_script( 'maxcoach-widget-counter', MAXCOACH_ELEMENTOR_URI . '/assets/js/widgets/widget-counter.js', array(
			'jquery',
			'count-to',
		), null, true );
	}

	/**
	 * enqueue scripts in editor mode.
	 */
	public function enqueue_editor_scripts() {
		wp_enqueue_script( 'maxcoach-elementor-editor', MAXCOACH_ELEMENTOR_URI . '/assets/js/editor.js', array( 'jquery' ), null, true );
	}

	/**
	 * Register styles for widgets.
	 */
	public function after_register_styles() {

	}

	/**
	 * @param \Elementor\Elements_Manager $elements_manager
	 *
	 * Add category.
	 */
	function add_elementor_widget_categories( $elements_manager ) {
		$elements_manager->add_category( 'maxcoach', [
			'title' => esc_html__( 'By Maxcoach', 'maxcoach' ),
			'icon'  => 'fa fa-plug',
		] );
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since  1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {

		// Include Widget files.
		require_once MAXCOACH_ELEMENTOR_DIR . '/module-query.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/base.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/form/form-base.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/posts/posts-base.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/carousel/carousel-base.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/carousel/posts-carousel-base.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/carousel/static-carousel.php';

		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/accordion.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/button.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/circle-progress-chart.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/counter.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/google-map.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/heading.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/typed-headline.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/icon.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/icon-box.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/image-box.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/image-layers.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/image-gallery.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/gallery-justified-content.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/banner.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/shapes.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/flip-box.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/attribute-list.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/gradation.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/timeline.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/list.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/pricing-table.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/twitter.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/team-member.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/social-networks.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/popup-video.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/separator.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/table.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/full-page.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/portfolio-details.php';

		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/grid/grid-base.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/grid/static-grid.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/grid/client-logo.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/grid/view-demo.php';

		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/posts/blog.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/posts/portfolio.php';

		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/testimonial-grid.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/testimonial-carousel-3d.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/carousel/testimonial-carousel.php';

		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/carousel/team-member-carousel.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/carousel/portfolio-carousel.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/carousel/image-carousel.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/carousel/modern-carousel.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/carousel/modern-carousel-02.php';
		require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/carousel/modern-slider.php';

		// Register Widgets.
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Accordion() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Button() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Client_Logo() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Circle_Progress_Chart() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Counter() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Google_Map() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Heading() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Typed_Headline() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Icon() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Icon_Box() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Image_Box() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Image_Layers() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Image_Gallery() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Image_Carousel() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Gallery_Justified_Content() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Banner() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Shapes() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Modern_Carousel() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Modern_Carousel_02() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Modern_Slider() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Flip_Box() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Blog() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Portfolio() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Portfolio_Carousel() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Portfolio_Details() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Attribute_List() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_List() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Gradation() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Timeline() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Pricing_Table() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Twitter() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Team_Member() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Team_Member_Carousel() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Testimonial_Carousel() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Testimonial_Carousel_3D() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Testimonial_Grid() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Social_Networks() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Popup_Video() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Separator() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Table() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Full_Page() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_View_Demo() );

		/**
		 * Include & Register Dependency Widgets.
		 */
		if ( \Maxcoach_Booking_Search_Box::instance()->is_activated() ) {
			require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/booking-form.php';

			Plugin::instance()->widgets_manager->register_widget_type( new Widget_Booking_Form() );
		}

		if ( \Maxcoach_Woo::instance()->is_activated() ) {
			require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/posts/product.php';
			require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/product-categories.php';

			Plugin::instance()->widgets_manager->register_widget_type( new Widget_Product() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widget_Product_Categories() );
		}

		if ( \Maxcoach_LP_Course::instance()->is_activated() ) {
			require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/carousel/course-carousel.php';
			require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/posts/course.php';
			require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/form/course-search-form.php';

			Plugin::instance()->widgets_manager->register_widget_type( new Widget_Course() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widget_Course_Carousel() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widget_Course_Search_Form() );
		}

		if ( \Maxcoach_Event::instance()->is_activated() ) {
			require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/posts/event.php';
			require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/carousel/event-carousel.php';

			Plugin::instance()->widgets_manager->register_widget_type( new Widget_Event() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widget_Event_Carousel() );
		}

		if ( \Maxcoach_Zoom_Meeting::instance()->is_activated() ) {
			require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/zoom-meeting.php';

			Plugin::instance()->widgets_manager->register_widget_type( new Widget_Zoom_Meeting() );
		}

		if ( defined( 'WPCF7_VERSION' ) ) {
			require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/form/contact-form-7.php';

			Plugin::instance()->widgets_manager->register_widget_type( new Widget_Contact_Form_7() );
		}

		if ( function_exists( 'mc4wp_get_forms' ) ) {
			require_once MAXCOACH_ELEMENTOR_DIR . '/widgets/form/mailchimp-form.php';

			Plugin::instance()->widgets_manager->register_widget_type( new Widget_Mailchimp_Form() );
		}
	}

	/**
	 * @param \Elementor\Widgets_Manager $widgets_manager
	 *
	 * Remove unwanted widgets
	 */
	function remove_unwanted_widgets( $widgets_manager ) {
		$elementor_widget_blacklist = array(
			'theme-site-logo',
		);

		foreach ( $elementor_widget_blacklist as $widget_name ) {
			$widgets_manager->unregister_widget_type( $widget_name );
		}
	}

	public function change_portfolio_archive_title( $title ) {
		if ( \Maxcoach_Portfolio::instance()->is_archive() ) {
			$title = \Maxcoach::setting( 'title_bar_archive_portfolio_title' );
		}

		if ( '' === $title ) {
			$title = 'Archive Title';
		}

		return $title;
	}
}

Widget_Init::instance()->initialize();
