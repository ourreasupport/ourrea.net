<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Maxcoach_Metabox' ) ) {
	class Maxcoach_Metabox {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_filter( 'insight_core_meta_boxes', array( $this, 'register_meta_boxes' ) );
		}

		/**
		 * Register Metabox
		 *
		 * @param $meta_boxes
		 *
		 * @return array
		 */
		public function register_meta_boxes( $meta_boxes ) {
			$page_registered_sidebars = Maxcoach_Helper::get_registered_sidebars( true );

			$general_options = array(
				array(
					'title'  => esc_attr__( 'Layout', 'maxcoach' ),
					'fields' => array(
						array(
							'id'      => 'site_layout',
							'type'    => 'select',
							'title'   => esc_html__( 'Layout', 'maxcoach' ),
							'desc'    => esc_html__( 'Controls the layout of this page.', 'maxcoach' ),
							'options' => array(
								''      => esc_attr__( 'Default', 'maxcoach' ),
								'boxed' => esc_attr__( 'Boxed', 'maxcoach' ),
								'wide'  => esc_attr__( 'Wide', 'maxcoach' ),
							),
							'default' => '',
						),
						array(
							'id'    => 'site_width',
							'type'  => 'text',
							'title' => esc_html__( 'Site Width', 'maxcoach' ),
							'desc'  => esc_html__( 'Controls the site width for this page. Enter value including any valid CSS unit. For e.g: 1200px. Leave blank to use global setting.', 'maxcoach' ),
						),
						array(
							'id'    => 'site_top_spacing',
							'type'  => 'text',
							'title' => esc_html__( 'Site Top Spacing', 'maxcoach' ),
							'desc'  => esc_html__( 'Controls the top spacing of this page. Enter value including any valid CSS unit. For e.g: 50px. Leave blank to use global setting.', 'maxcoach' ),
						),
						array(
							'id'    => 'site_bottom_spacing',
							'type'  => 'text',
							'title' => esc_html__( 'Site Bottom Spacing', 'maxcoach' ),
							'desc'  => esc_html__( 'Controls the bottom spacing of this page. Enter value including any valid CSS unit. For e.g: 50px. Leave blank to use global setting.', 'maxcoach' ),
						),
						array(
							'id'    => 'site_class',
							'type'  => 'text',
							'title' => esc_html__( 'Body Class', 'maxcoach' ),
							'desc'  => esc_html__( 'Add a class name to body then refer to it in custom CSS.', 'maxcoach' ),
						),
					),
				),
				array(
					'title'  => esc_attr__( 'Background', 'maxcoach' ),
					'fields' => array(
						array(
							'id'      => 'site_background_message',
							'type'    => 'message',
							'title'   => esc_html__( 'Info', 'maxcoach' ),
							'message' => esc_html__( 'These options controls the background on boxed mode.', 'maxcoach' ),
						),
						array(
							'id'    => 'site_background_color',
							'type'  => 'color',
							'title' => esc_html__( 'Background Color', 'maxcoach' ),
							'desc'  => esc_html__( 'Controls the background color of the outer background area in boxed mode of this page.', 'maxcoach' ),
						),
						array(
							'id'    => 'site_background_image',
							'type'  => 'media',
							'title' => esc_html__( 'Background Image', 'maxcoach' ),
							'desc'  => esc_html__( 'Controls the background image of the outer background area in boxed mode of this page.', 'maxcoach' ),
						),
						array(
							'id'      => 'site_background_repeat',
							'type'    => 'select',
							'title'   => esc_html__( 'Background Repeat', 'maxcoach' ),
							'desc'    => esc_html__( 'Controls the background repeat of the outer background area in boxed mode of this page.', 'maxcoach' ),
							'options' => array(
								'no-repeat' => esc_attr__( 'No repeat', 'maxcoach' ),
								'repeat'    => esc_attr__( 'Repeat', 'maxcoach' ),
								'repeat-x'  => esc_attr__( 'Repeat X', 'maxcoach' ),
								'repeat-y'  => esc_attr__( 'Repeat Y', 'maxcoach' ),
							),
						),
						array(
							'id'      => 'site_background_attachment',
							'type'    => 'select',
							'title'   => esc_html__( 'Background Attachment', 'maxcoach' ),
							'desc'    => esc_html__( 'Controls the background attachment of the outer background area in boxed mode of this page.', 'maxcoach' ),
							'options' => array(
								''       => esc_attr__( 'Default', 'maxcoach' ),
								'fixed'  => esc_attr__( 'Fixed', 'maxcoach' ),
								'scroll' => esc_attr__( 'Scroll', 'maxcoach' ),
							),
						),
						array(
							'id'    => 'site_background_position',
							'type'  => 'text',
							'title' => esc_html__( 'Background Position', 'maxcoach' ),
							'desc'  => esc_html__( 'Controls the background position of the outer background area in boxed mode of this page.', 'maxcoach' ),
						),
						array(
							'id'    => 'site_background_size',
							'type'  => 'text',
							'title' => esc_html__( 'Background Size', 'maxcoach' ),
							'desc'  => esc_html__( 'Controls the background size of the outer background area in boxed mode of this page.', 'maxcoach' ),
						),
						array(
							'id'      => 'content_background_message',
							'type'    => 'message',
							'title'   => esc_html__( 'Info', 'maxcoach' ),
							'message' => esc_html__( 'These options controls the background of main content on this page.', 'maxcoach' ),
						),
						array(
							'id'    => 'content_background_color',
							'type'  => 'color',
							'title' => esc_html__( 'Background Color', 'maxcoach' ),
							'desc'  => esc_html__( 'Controls the background color of main content on this page.', 'maxcoach' ),
						),
						array(
							'id'    => 'content_background_image',
							'type'  => 'media',
							'title' => esc_html__( 'Background Image', 'maxcoach' ),
							'desc'  => esc_html__( 'Controls the background image of main content on this page.', 'maxcoach' ),
						),
						array(
							'id'      => 'content_background_repeat',
							'type'    => 'select',
							'title'   => esc_html__( 'Background Repeat', 'maxcoach' ),
							'desc'    => esc_html__( 'Controls the background repeat of main content on this page.', 'maxcoach' ),
							'options' => array(
								'no-repeat' => esc_attr__( 'No repeat', 'maxcoach' ),
								'repeat'    => esc_attr__( 'Repeat', 'maxcoach' ),
								'repeat-x'  => esc_attr__( 'Repeat X', 'maxcoach' ),
								'repeat-y'  => esc_attr__( 'Repeat Y', 'maxcoach' ),
							),
						),
						array(
							'id'    => 'content_background_position',
							'type'  => 'text',
							'title' => esc_html__( 'Background Position', 'maxcoach' ),
							'desc'  => esc_html__( 'Controls the background position of main content on this page.', 'maxcoach' ),
						),
					),
				),
				array(
					'title'  => esc_html__( 'Header', 'maxcoach' ),
					'fields' => array(
						array(
							'id'      => 'top_bar_type',
							'type'    => 'select',
							'title'   => esc_html__( 'Top Bar Type', 'maxcoach' ),
							'desc'    => esc_html__( 'Select top bar type that displays on this page.', 'maxcoach' ),
							'default' => '',
							'options' => Maxcoach_Top_Bar::instance()->get_list( true ),
						),
						array(
							'id'      => 'header_type',
							'type'    => 'select',
							'title'   => esc_attr__( 'Header Type', 'maxcoach' ),
							'desc'    => wp_kses(
								sprintf(
									__( 'Select header type that displays on this page. When you choose Default, the value in %s will be used.', 'maxcoach' ),
									'<a href="' . admin_url( '/customize.php?autofocus[section]=header' ) . '">Customize</a>'
								), 'maxcoach-a' ),
							'default' => '',
							'options' => Maxcoach_Header::instance()->get_list( true ),
						),
						array(
							'id'      => 'header_overlay',
							'type'    => 'select',
							'title'   => esc_attr__( 'Header Overlay', 'maxcoach' ),
							'default' => '',
							'options' => array(
								''  => esc_html__( 'Default', 'maxcoach' ),
								'0' => esc_html__( 'No', 'maxcoach' ),
								'1' => esc_html__( 'Yes', 'maxcoach' ),
							),
						),
						array(
							'id'      => 'header_skin',
							'type'    => 'select',
							'title'   => esc_attr__( 'Header Skin', 'maxcoach' ),
							'default' => '',
							'options' => array(
								''      => esc_html__( 'Default', 'maxcoach' ),
								'dark'  => esc_html__( 'Dark', 'maxcoach' ),
								'light' => esc_html__( 'Light', 'maxcoach' ),
							),
						),
						array(
							'id'      => 'menu_display',
							'type'    => 'select',
							'title'   => esc_html__( 'Primary menu', 'maxcoach' ),
							'desc'    => esc_html__( 'Select which menu displays on this page.', 'maxcoach' ),
							'default' => '',
							'options' => Maxcoach_Nav_Menu::get_all_menus(),
						),
						array(
							'id'      => 'menu_one_page',
							'type'    => 'switch',
							'title'   => esc_attr__( 'One Page Menu', 'maxcoach' ),
							'default' => '0',
							'options' => array(
								'0' => esc_attr__( 'Disable', 'maxcoach' ),
								'1' => esc_attr__( 'Enable', 'maxcoach' ),
							),
						),
						array(
							'id'      => 'custom_dark_logo',
							'type'    => 'media',
							'title'   => esc_html__( 'Custom Dark Logo', 'maxcoach' ),
							'desc'    => esc_html__( 'Select custom dark logo for this page.', 'maxcoach' ),
							'default' => '',
						),
						array(
							'id'      => 'custom_light_logo',
							'type'    => 'media',
							'title'   => esc_html__( 'Custom Light Logo', 'maxcoach' ),
							'desc'    => esc_html__( 'Select custom light logo for this page.', 'maxcoach' ),
							'default' => '',
						),
						array(
							'id'      => 'custom_logo_width',
							'type'    => 'text',
							'title'   => esc_html__( 'Custom Logo Width', 'maxcoach' ),
							'desc'    => esc_html__( 'Controls the width of logo. For e.g: 150px', 'maxcoach' ),
							'default' => '',
						),
						array(
							'id'      => 'custom_sticky_logo_width',
							'type'    => 'text',
							'title'   => esc_html__( 'Custom Sticky Logo Width', 'maxcoach' ),
							'desc'    => esc_html__( 'Controls the width of sticky logo. For e.g: 150px', 'maxcoach' ),
							'default' => '',
						),
					),
				),
				array(
					'title'  => esc_html__( 'Page Title Bar', 'maxcoach' ),
					'fields' => array(
						array(
							'id'      => 'page_title_bar_layout',
							'type'    => 'select',
							'title'   => esc_html__( 'Layout', 'maxcoach' ),
							'default' => '',
							'options' => Maxcoach_Title_Bar::instance()->get_list( true ),
						),
						array(
							'id'    => 'page_title_bar_bottom_spacing',
							'type'  => 'text',
							'title' => esc_html__( 'Spacing', 'maxcoach' ),
							'desc'  => esc_html__( 'Controls the bottom spacing of title bar of this page. Enter value including any valid CSS unit. For e.g: 50px. Leave blank to use global setting.', 'maxcoach' ),
						),
						array(
							'id'      => 'page_title_bar_background_color',
							'type'    => 'color',
							'title'   => esc_html__( 'Background Color', 'maxcoach' ),
							'default' => '',
						),
						array(
							'id'      => 'page_title_bar_background',
							'type'    => 'media',
							'title'   => esc_html__( 'Background Image', 'maxcoach' ),
							'default' => '',
						),
						array(
							'id'      => 'page_title_bar_background_overlay',
							'type'    => 'color',
							'title'   => esc_html__( 'Background Overlay', 'maxcoach' ),
							'default' => '',
						),
						array(
							'id'    => 'page_title_bar_custom_heading',
							'type'  => 'text',
							'title' => esc_html__( 'Custom Heading Text', 'maxcoach' ),
							'desc'  => esc_html__( 'Insert custom heading for the page title bar. Leave blank to use default.', 'maxcoach' ),
						),
					),
				),
				array(
					'title'  => esc_html__( 'Sidebars', 'maxcoach' ),
					'fields' => array(
						array(
							'id'      => 'page_sidebar_1',
							'type'    => 'select',
							'title'   => esc_html__( 'Sidebar 1', 'maxcoach' ),
							'desc'    => esc_html__( 'Select sidebar 1 that will display on this page.', 'maxcoach' ),
							'default' => 'default',
							'options' => $page_registered_sidebars,
						),
						array(
							'id'      => 'page_sidebar_2',
							'type'    => 'select',
							'title'   => esc_html__( 'Sidebar 2', 'maxcoach' ),
							'desc'    => esc_html__( 'Select sidebar 2 that will display on this page.', 'maxcoach' ),
							'default' => 'default',
							'options' => $page_registered_sidebars,
						),
						array(
							'id'      => 'page_sidebar_position',
							'type'    => 'switch',
							'title'   => esc_html__( 'Sidebar Position', 'maxcoach' ),
							'desc'    => wp_kses(
								sprintf(
									__( 'Select position of Sidebar 1 for this page. If sidebar 2 is selected, it will display on the opposite side. If you set as "Default" then the value in %s will be used.', 'maxcoach' ),
									'<a href="' . admin_url( '/customize.php?autofocus[section]=sidebars' ) . '">Customize -> Sidebar</a>'
								), 'maxcoach-a' ),
							'default' => 'default',
							'options' => Maxcoach_Helper::get_list_sidebar_positions( true ),
						),
					),
				),
				array(
					'title'  => esc_html__( 'Sliders', 'maxcoach' ),
					'fields' => array(
						array(
							'id'      => 'revolution_slider',
							'type'    => 'select',
							'title'   => esc_html__( 'Revolution Slider', 'maxcoach' ),
							'desc'    => esc_html__( 'Select the unique name of the slider.', 'maxcoach' ),
							'options' => Maxcoach_Helper::get_list_revslider(),
						),
						array(
							'id'      => 'slider_position',
							'type'    => 'select',
							'title'   => esc_html__( 'Slider Position', 'maxcoach' ),
							'default' => 'below',
							'options' => array(
								'above' => esc_attr__( 'Above Header', 'maxcoach' ),
								'below' => esc_attr__( 'Below Header', 'maxcoach' ),
							),
						),
					),
				),
				array(
					'title'  => esc_html__( 'Footer', 'maxcoach' ),
					'fields' => array(
						array(
							'id'      => 'footer_enable',
							'type'    => 'select',
							'title'   => esc_html__( 'Footer Enable', 'maxcoach' ),
							'default' => '',
							'options' => array(
								''     => esc_html__( 'Yes', 'maxcoach' ),
								'none' => esc_html__( 'No', 'maxcoach' ),
							),
						),
					),
				),
			);

			// Page
			$meta_boxes[] = array(
				'id'         => 'insight_page_options',
				'title'      => esc_html__( 'Page Options', 'maxcoach' ),
				'post_types' => array( 'page' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'fields'     => array(
					array(
						'type'  => 'tabpanel',
						'items' => $general_options,
					),
				),
			);

			// Post
			$meta_boxes[] = array(
				'id'         => 'insight_post_options',
				'title'      => esc_html__( 'Page Options', 'maxcoach' ),
				'post_types' => array( 'post' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'fields'     => array(
					array(
						'type'  => 'tabpanel',
						'items' => array_merge( array(
							array(
								'title'  => esc_html__( 'Post', 'maxcoach' ),
								'fields' => array(
									array(
										'id'    => 'post_gallery',
										'type'  => 'gallery',
										'title' => esc_html__( 'Gallery Format', 'maxcoach' ),
									),
									array(
										'id'    => 'post_video',
										'type'  => 'text',
										'title' => esc_html__( 'Video URL', 'maxcoach' ),
										'desc'  => esc_html__( 'Input the url of video vimeo or youtube. For e.g: https://www.youtube.com/watch?v=9No-FiEInLA', 'maxcoach' ),
									),
									array(
										'id'    => 'post_audio',
										'type'  => 'textarea',
										'title' => esc_html__( 'Audio Format', 'maxcoach' ),
									),
									array(
										'id'    => 'post_quote_text',
										'type'  => 'text',
										'title' => esc_html__( 'Quote Format - Source Text', 'maxcoach' ),
									),
									array(
										'id'    => 'post_quote_name',
										'type'  => 'text',
										'title' => esc_html__( 'Quote Format - Source Name', 'maxcoach' ),
									),
									array(
										'id'    => 'post_quote_url',
										'type'  => 'text',
										'title' => esc_html__( 'Quote Format - Source Url', 'maxcoach' ),
									),
									array(
										'id'    => 'post_link',
										'type'  => 'text',
										'title' => esc_html__( 'Link Format', 'maxcoach' ),
									),
								),
							),
						), $general_options ),
					),
				),
			);

			// Product
			$meta_boxes[] = array(
				'id'         => 'insight_product_options',
				'title'      => esc_html__( 'Page Options', 'maxcoach' ),
				'post_types' => array( 'product' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'fields'     => array(
					array(
						'type'  => 'tabpanel',
						'items' => array_merge( array(
							array(
								'title'  => esc_html__( 'Product', 'maxcoach' ),
								'fields' => array(
									array(
										'id'      => 'single_product_layout_style',
										'type'    => 'select',
										'title'   => esc_html__( 'Single Product Style', 'maxcoach' ),
										'desc'    => esc_html__( 'Select style of this single product page.', 'maxcoach' ),
										'default' => '',
										'options' => array(
											''       => esc_html__( 'Default', 'maxcoach' ),
											'list'   => esc_html__( 'List', 'maxcoach' ),
											'slider' => esc_html__( 'Slider', 'maxcoach' ),
										),
									),
								),
							),
						), $general_options ),
					),
				),
			);

			// Portfolio
			$meta_boxes[] = array(
				'id'         => 'insight_portfolio_options',
				'title'      => esc_html__( 'Page Options', 'maxcoach' ),
				'post_types' => array( 'portfolio' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'fields'     => array(
					array(
						'type'  => 'tabpanel',
						'items' => array_merge( array(
							array(
								'title'  => esc_html__( 'Portfolio', 'maxcoach' ),
								'fields' => array(
									array(
										'id'      => 'portfolio_site_skin',
										'type'    => 'select',
										'title'   => esc_html__( 'Site Skin', 'maxcoach' ),
										'desc'    => esc_html__( 'Select skin of this single portfolio page.', 'maxcoach' ),
										'default' => '',
										'options' => array(
											''      => esc_html__( 'Default', 'maxcoach' ),
											'dark'  => esc_html__( 'Dark', 'maxcoach' ),
											'light' => esc_html__( 'Light', 'maxcoach' ),
										),
									),
									array(
										'id'      => 'portfolio_layout_style',
										'type'    => 'select',
										'title'   => esc_html__( 'Single Portfolio Style', 'maxcoach' ),
										'desc'    => esc_html__( 'Select style of this single portfolio page.', 'maxcoach' ),
										'default' => '',
										'options' => array(
											''                => esc_html__( 'Default', 'maxcoach' ),
											'blank'           => esc_html__( 'Blank (Build with Elementor)', 'maxcoach' ),
											'image-list'      => esc_html__( 'Image List', 'maxcoach' ),
											'image-list-wide' => esc_html__( 'Image List - Wide', 'maxcoach' ),
										),
									),
									array(
										'id'      => 'portfolio_pagination_style',
										'type'    => 'select',
										'title'   => esc_html__( 'Pagination Style', 'maxcoach' ),
										'desc'    => esc_html__( 'Select style of pagination for this single portfolio page.', 'maxcoach' ),
										'default' => '',
										'options' => array(
											''     => esc_html__( 'Default', 'maxcoach' ),
											'none' => esc_html__( 'None', 'maxcoach' ),
											'01'   => esc_html__( '01', 'maxcoach' ),
											'02'   => esc_html__( '02', 'maxcoach' ),
											'03'   => esc_html__( '03', 'maxcoach' ),
										),
									),
									array(
										'id'    => 'portfolio_gallery',
										'type'  => 'gallery',
										'title' => esc_html__( 'Gallery', 'maxcoach' ),
									),
									array(
										'id'    => 'portfolio_video_url',
										'type'  => 'text',
										'title' => esc_html__( 'Video URL', 'maxcoach' ),
										'desc'  => esc_html__( 'Input the url of video vimeo or youtube. For e.g: https://www.youtube.com/watch?v=9No-FiEInLA', 'maxcoach' ),
									),
									array(
										'id'    => 'portfolio_client',
										'type'  => 'text',
										'title' => esc_html__( 'Client', 'maxcoach' ),
									),
									array(
										'id'    => 'portfolio_date',
										'type'  => 'text',
										'title' => esc_html__( 'Date', 'maxcoach' ),
									),
									array(
										'id'    => 'portfolio_url',
										'type'  => 'text',
										'title' => esc_html__( 'Url', 'maxcoach' ),
									),
									array(
										'id'      => 'portfolio_overlay_colored_faded_message',
										'type'    => 'message',
										'title'   => esc_html__( 'Info', 'maxcoach' ),
										'message' => esc_html__( 'These settings for Overlay Colored Faded Style.', 'maxcoach' ),
									),
									array(
										'id'    => 'portfolio_overlay_colored_faded_background',
										'type'  => 'color',
										'title' => esc_html__( 'Background Color', 'maxcoach' ),
										'desc'  => esc_html__( 'Controls the background color of overlay colored faded style.', 'maxcoach' ),
									),
									array(
										'id'      => 'portfolio_overlay_colored_faded_text_skin',
										'type'    => 'select',
										'title'   => esc_html__( 'Text Skin', 'maxcoach' ),
										'desc'    => esc_html__( 'Controls the text skin of overlay colored faded style.', 'maxcoach' ),
										'default' => 'light',
										'options' => array(
											'dark'  => esc_html__( 'Dark', 'maxcoach' ),
											'light' => esc_html__( 'Light', 'maxcoach' ),
										),
									),
								),
							),
						), $general_options ),
					),
				),
			);

			// Course
			$meta_boxes[] = array(
				'id'         => 'insight_course_options',
				'title'      => esc_html__( 'Page Options', 'maxcoach' ),
				'post_types' => array( 'lp_course' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'fields'     => array(
					array(
						'type'  => 'tabpanel',
						'items' => array_merge( array(
							array(
								'title'  => esc_html__( 'Course', 'maxcoach' ),
								'fields' => array(
									array(
										'id'      => 'single_course_layout',
										'type'    => 'select',
										'title'   => esc_html__( 'Single Course Layout', 'maxcoach' ),
										'desc'    => esc_html__( 'Select layout of this course.', 'maxcoach' ),
										'default' => '',
										'options' => array(
											''   => esc_html__( 'Default', 'maxcoach' ),
											'01' => esc_html__( 'Sticky Features Bar', 'maxcoach' ),
											'02' => esc_html__( 'Standard', 'maxcoach' ),
										),
									),
								),
							),
						), $general_options ),
					),
				),
			);

			return $meta_boxes;
		}

	}

	Maxcoach_Metabox::instance()->initialize();
}
