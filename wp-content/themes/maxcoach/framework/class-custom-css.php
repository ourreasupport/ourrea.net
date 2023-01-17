<?php
defined( 'ABSPATH' ) || exit;

/**
 * Enqueue custom styles.
 */
if ( ! class_exists( 'Maxcoach_Custom_Css' ) ) {
	class Maxcoach_Custom_Css {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_action( 'wp_enqueue_scripts', [ $this, 'root_css' ] );

			add_action( 'wp_enqueue_scripts', array( $this, 'extra_css' ) );
		}

		public function root_css() {
			$primary_color      = Maxcoach::setting( 'primary_color' );
			$primary_color_rgb  = Maxcoach_Color::hex2rgb_string( $primary_color );
			$secondary_color    = Maxcoach::setting( 'secondary_color' );
			$text_color         = Maxcoach::setting( 'body_color' );
			$heading_color      = Maxcoach::setting( 'heading_color' );
			$link_color         = Maxcoach::setting( 'link_color' );

			$body_font        = Maxcoach::setting( 'typography_body' );
			$body_font_weight = $body_font['variant'];
			$body_font_weight = 'regular' === $body_font_weight ? 400 : $body_font_weight; // Fix regular is not valid weight.

			$heading_font        = Maxcoach::setting( 'typography_heading' );

			$heading_font_family = '' === $heading_font['font-family'] ? 'inherit' : $heading_font['font-family'];
			$heading_font_weight = $heading_font['variant'];
			$heading_font_weight = 'regular' === $heading_font_weight ? 400 : $heading_font_weight; // Fix regular is not valid weight.

			$css = ":root {
				--maxcoach-color-primary: {$primary_color};
				--maxcoach-color-primary-rgb: {$primary_color_rgb};
				--maxcoach-color-secondary: {$secondary_color};
				--maxcoach-color-text: {$text_color};
				--maxcoach-color-heading: {$heading_color};
				--maxcoach-color-link: {$link_color['normal']};
				--maxcoach-color-link-hover: {$link_color['hover']};
				--maxcoach-typography-body-font-family: {$body_font['font-family']};
				--maxcoach-typography-body-font-size: {$body_font['font-size']};
				--maxcoach-typography-body-font-weight: {$body_font_weight};
				--maxcoach-typography-body-line-height: {$body_font['line-height']};
				--maxcoach-typography-body-letter-spacing: {$body_font['letter-spacing']};
				--maxcoach-typography-headings-font-family: {$heading_font_family};
				--maxcoach-typography-headings-font-weight: {$heading_font_weight};
				--maxcoach-typography-headings-line-height: {$heading_font['line-height']};
				--maxcoach-typography-headings-letter-spacing: {$heading_font['letter-spacing']};
			}";

			wp_add_inline_style( 'maxcoach-style', html_entity_decode( $css, ENT_QUOTES ) );
		}

		/**
		 * Responsive styles.
		 *
		 * @access public
		 */
		public function extra_css() {
			$extra_style = '';

			$custom_logo_width        = Maxcoach_Helper::get_post_meta( 'custom_logo_width', '' );
			$custom_sticky_logo_width = Maxcoach_Helper::get_post_meta( 'custom_sticky_logo_width', '' );

			if ( $custom_logo_width !== '' ) {
				$extra_style .= ".branding__logo img { 
                    width: {$custom_logo_width} !important; 
                }";
			}

			if ( $custom_sticky_logo_width !== '' ) {
				$extra_style .= ".headroom--not-top .branding__logo .sticky-logo { 
                    width: {$custom_sticky_logo_width} !important; 
                }";
			}

			$site_width = Maxcoach_Helper::get_post_meta( 'site_width', '' );
			if ( $site_width === '' ) {
				$site_width = Maxcoach::setting( 'site_width' );
			}

			if ( $site_width !== '' ) {
				$extra_style .= "
				.boxed
				{
	                max-width: $site_width;
	            }";
			}

			$site_top_spacing = Maxcoach_Helper::get_post_meta( 'site_top_spacing', '' );

			if ( $site_top_spacing !== '' ) {
				$extra_style .= "
				.boxed
				{
	                margin-top: {$site_top_spacing};
	            }";
			}

			$site_bottom_spacing = Maxcoach_Helper::get_post_meta( 'site_bottom_spacing', '' );

			if ( $site_bottom_spacing !== '' ) {
				$extra_style .= "
				.boxed
				{
	                margin-bottom: {$site_bottom_spacing};
	            }";
			}

			$tmp = '';

			$site_background_color = Maxcoach_Helper::get_post_meta( 'site_background_color', '' );
			if ( $site_background_color !== '' ) {
				$tmp .= "background-color: $site_background_color !important;";
			}

			$site_background_image = Maxcoach_Helper::get_post_meta( 'site_background_image', '' );
			if ( $site_background_image !== '' ) {
				$site_background_repeat = Maxcoach_Helper::get_post_meta( 'site_background_repeat', '' );
				$tmp                    .= "background-image: url( $site_background_image ) !important; background-repeat: $site_background_repeat !important;";
			}

			$site_background_position = Maxcoach_Helper::get_post_meta( 'site_background_position', '' );
			if ( $site_background_position !== '' ) {
				$tmp .= "background-position: $site_background_position !important;";
			}

			$site_background_size = Maxcoach_Helper::get_post_meta( 'site_background_size', '' );
			if ( $site_background_size !== '' ) {
				$tmp .= "background-size: $site_background_size !important;";
			}

			$site_background_attachment = Maxcoach_Helper::get_post_meta( 'site_background_attachment', '' );
			if ( $site_background_attachment !== '' ) {
				$tmp .= "background-attachment: $site_background_attachment !important;";
			}

			if ( $tmp !== '' ) {
				$extra_style .= "body { $tmp; }";
			}

			$tmp = '';

			$content_background_color = Maxcoach_Helper::get_post_meta( 'content_background_color', '' );
			if ( $content_background_color !== '' ) {
				$tmp .= "background-color: $content_background_color !important;";
			}

			$content_background_image = Maxcoach_Helper::get_post_meta( 'content_background_image', '' );
			if ( $content_background_image !== '' ) {
				$content_background_repeat = Maxcoach_Helper::get_post_meta( 'content_background_repeat', '' );
				$tmp                       .= "background-image: url( $content_background_image ) !important; background-repeat: $content_background_repeat !important;";
			}

			$content_background_position = Maxcoach_Helper::get_post_meta( 'content_background_position', '' );
			if ( $content_background_position !== '' ) {
				$tmp .= "background-position: $content_background_position !important;";
			}

			if ( $tmp !== '' ) {
				$extra_style .= ".site { $tmp; }";
			}

			$extra_style .= $this->primary_color_css();
			$extra_style .= $this->secondary_color_css();
			$extra_style .= $this->header_css();
			$extra_style .= $this->sidebar_css();
			$extra_style .= $this->title_bar_css();
			$extra_style .= $this->light_gallery_css();
			$extra_style .= $this->off_canvas_menu_css();
			$extra_style .= $this->mobile_menu_css();

			$extra_style = Maxcoach_Minify::css( $extra_style );

			wp_add_inline_style( 'maxcoach-style', html_entity_decode( $extra_style, ENT_QUOTES ) );
		}

		function header_css() {
			$header_type = Maxcoach_Global::instance()->get_header_type();
			$css         = '';

			$nav_bg_type = Maxcoach::setting( "header_style_{$header_type}_navigation_background_type" );

			if ( $nav_bg_type === 'gradient' ) {

				$gradient = Maxcoach::setting( "header_style_{$header_type}_navigation_background_gradient" );
				$_color_1 = $gradient['from'];
				$_color_2 = $gradient['to'];

				$css .= "
				.header-$header_type .header-bottom {
					background: {$_color_1};
                    background: -webkit-linear-gradient(-136deg, {$_color_2} 0%, {$_color_1} 100%);
                    background: linear-gradient(-136deg, {$_color_2} 0%, {$_color_1} 100%);
				}";
			}

			return $css;
		}

		function sidebar_css() {
			$css = '';

			$page_sidebar1  = Maxcoach_Global::instance()->get_sidebar_1();
			$page_sidebar2  = Maxcoach_Global::instance()->get_sidebar_2();
			$sidebar_status = Maxcoach_Global::instance()->get_sidebar_status();

			if ( 'none' !== $page_sidebar1 ) {

				if ( $sidebar_status === 'both' ) {
					$sidebars_breakpoint = Maxcoach::setting( 'both_sidebar_breakpoint' );
				} else {
					$sidebars_breakpoint = Maxcoach::setting( 'one_sidebar_breakpoint' );
				}

				$sidebars_below = Maxcoach::setting( 'sidebars_below_content_mobile' );

				if ( 'none' !== $page_sidebar2 ) {
					$sidebar_width  = Maxcoach::setting( 'dual_sidebar_width' );
					$sidebar_offset = Maxcoach::setting( 'dual_sidebar_offset' );
					$content_width  = 100 - $sidebar_width * 2;
				} else {
					$sidebar_width  = Maxcoach::setting( 'single_sidebar_width' );
					$sidebar_offset = Maxcoach::setting( 'single_sidebar_offset' );

					if ( Maxcoach_Woo::instance()->is_product_archive() ) {
						$new_sidebar_width  = Maxcoach::setting( 'product_archive_single_sidebar_width' );
						$new_sidebar_offset = Maxcoach::setting( 'product_archive_single_sidebar_offset' );

						if ( '' !== $new_sidebar_width ) {
							$sidebar_width = $new_sidebar_width;
						}

						if ( '' !== $new_sidebar_offset ) {
							$sidebar_offset = $new_sidebar_offset;
						}
					}

					$content_width = 100 - $sidebar_width;
				}

				$css .= "
				@media (min-width: {$sidebars_breakpoint}px) {
					.page-sidebar {
						flex: 0 0 $sidebar_width%;
						max-width: $sidebar_width%;
					}
					.page-main-content {
						flex: 0 0 $content_width%;
						max-width: $content_width%;
					}
				}";

				if ( is_rtl() ) {
					$css .= "@media (min-width: 1200px) {
						.page-sidebar-left .page-sidebar-inner {
							padding-left: $sidebar_offset;
						}
						.page-sidebar-right .page-sidebar-inner {
							padding-right: $sidebar_offset;
						}
					}";
				} else {
					$css .= "@media (min-width: 1200px) {
						.page-sidebar-left .page-sidebar-inner {
							padding-right: $sidebar_offset;
						}
						.page-sidebar-right .page-sidebar-inner {
							padding-left: $sidebar_offset;
						}
					}";
				}

				$_max_width_breakpoint = $sidebars_breakpoint - 1;

				if ( $sidebars_below === '1' ) {
					$css .= "
					@media (max-width: {$_max_width_breakpoint}px) {
						.page-sidebar {
							margin-top: 100px;
						}
					
						.page-main-content {
							-webkit-order: -1;
							-moz-order: -1;
							order: -1;
						}
					}";
				}
			}

			return $css;
		}

		function title_bar_css() {
			$css = $title_bar_tmp = $overlay_tmp = '';

			$type    = Maxcoach_Global::instance()->get_title_bar_type();
			$bg_type = Maxcoach::setting( "title_bar_{$type}_background_type" );

			if ( 'gradient' === $bg_type ) {
				$gradient_color = Maxcoach::setting( "title_bar_{$type}_background_gradient" );
				$color1         = $gradient_color['color_1'];
				$color2         = $gradient_color['color_2'];

				$css .= "
					.page-title-bar-bg
					{
						background-color: $color1;
						background-image: linear-gradient(-180deg, {$color1} 0%, {$color2} 100%);
					}
				";
			}

			$bg_color   = Maxcoach_Helper::get_post_meta( 'page_title_bar_background_color', '' );
			$bg_image   = Maxcoach_Helper::get_post_meta( 'page_title_bar_background', '' );
			$bg_overlay = Maxcoach_Helper::get_post_meta( 'page_title_bar_background_overlay', '' );

			if ( $bg_color !== '' ) {
				$title_bar_tmp .= "background-color: {$bg_color}!important;";
			}

			if ( '' !== $bg_image ) {
				$title_bar_tmp .= "background-image: url({$bg_image})!important;";
			}

			if ( '' !== $bg_overlay ) {
				$overlay_tmp .= "background-color: {$bg_overlay}!important;";
			}

			if ( '' !== $title_bar_tmp ) {
				$css .= ".page-title-bar-bg{ {$title_bar_tmp} }";
			}

			if ( '' !== $overlay_tmp ) {
				$css .= ".page-title-bar-bg:before{ {$overlay_tmp} }";
			}

			$bottom_spacing = Maxcoach_Helper::get_post_meta( 'page_title_bar_bottom_spacing', '' );
			if ( '' !== $bottom_spacing ) {
				$css .= "#page-title-bar{ margin-bottom: {$bottom_spacing}; }";
			}

			return $css;
		}

		function primary_color_css() {
			$color_selectors = "
				mark,
                .primary-color.primary-color,
                .growl-close:hover,
                .tm-button.style-border,
                .tm-button.style-thick-border,
				.maxcoach-infinite-loader,
				.maxcoach-blog .post-title a:hover,
				.maxcoach-blog .post-categories a:hover,
				.maxcoach-blog-caption-style-03 .tm-button,
				.tm-portfolio .post-categories a:hover,
				.tm-portfolio .post-title a:hover,
				.maxcoach-pricing .price-wrap,
				.maxcoach-timeline.style-01 .title,
				.maxcoach-timeline.style-01 .timeline-dot,
				.tm-google-map .style-signal .animated-dot,
				.maxcoach-list .marker,
				.maxcoach-mailchimp-form-style-01 .form-submit,
				.maxcoach-pricing-style-02 .maxcoach-pricing .maxcoach-pricing-features li i,
				.tm-social-networks .link:hover,
				.tm-social-networks.style-solid-rounded-icon .link,
				.maxcoach-team-member-style-01 .social-networks a:hover,
				.elementor-widget-tm-testimonial .testimonial-quote-icon,
				.maxcoach-modern-carousel-style-02 .slide-button,
				.tm-slider a:hover .heading,
				.woosw-area .woosw-inner .woosw-content .woosw-content-bot .woosw-content-bot-inner .woosw-page a:hover,
				.woosw-continue:hover,
				.tm-menu .menu-price,
				.woocommerce-widget-layered-nav-list a:hover,
				.entry-post-tags a:hover,
				.post-share a:hover,
				.post-share.style-01 .share-media .share-icon,
				.blog-nav-links h6:before,
				.header-search-form .search-submit,
				.widget_search .search-submit,
				.widget_product_search .search-submit,
				.page-main-content .search-form .search-submit,
				.page-sidebar .widget_pages .current-menu-item > a,
				.page-sidebar .widget_nav_menu .current-menu-item > a,
				.page-sidebar .insight-core-bmw .current-menu-item > a,
				.comment-list .comment-actions a:hover,
				.portfolio-nav-links.style-01 .inner > a:hover,
				.portfolio-nav-links.style-02 .nav-list .hover,
				.maxcoach-main-post .course-price,
				.learn-press-content-protected-message a,
				body.single-lp_course.course-item-popup .course-item-nav a:before,
				body.single-lp_course.course-item-popup #learn-press-course-curriculum .toggle-content-item,
				.maxcoach-fake-select-wrap .maxcoach-fake-select li.selected:before,
				.maxcoach-course .course-info .course-price,
				.maxcoach-course .course-title a:hover,
				.learn-press-checkout .lp-list-table td.course-total, .learn-press-checkout .lp-list-table .cart-subtotal td, .learn-press-checkout .lp-list-table .order-total td,
				.single-lp_course .lp-single-course .course-author .author-social-networks a:hover,
				.single-lp_course .course-curriculum ul.curriculum-sections .section-content .course-item.has-status.passed .course-item-status,
				.widget_lp-widget-recent-courses .course-price,
				.widget_lp-widget-recent-courses .course-title:hover,
				.single-lp_course .lp-single-course .course-price,
				.entry-course-share .share-media,
				.single-course-layout-02 .lp-single-course .entry-course-share .tm-button,
				.elementor-widget-tm-icon-box.maxcoach-icon-box-style-01 .maxcoach-box:hover div.tm-button.style-text,
				.elementor-widget-tm-icon-box.maxcoach-icon-box-style-01 a.tm-button.style-text:hover,
				.tm-image-box.maxcoach-box:hover div.tm-button.style-text,
				.tm-image-box a.tm-button.style-text:hover";

			$bg_color_selectors = "
				.primary-background-color,			
				.wp-block-tag-cloud a:hover,
				.wp-block-calendar #today,
				.header-search-form .search-submit:hover,
				.maxcoach-fake-select-wrap .maxcoach-fake-select li:hover,
				.maxcoach-progress .progress-bar,
				.maxcoach-link-animate-border .heading-primary a mark:after,
                .tm-button.style-flat:before,
                .tm-button.style-border:after,
                .tm-button.style-thick-border:after,
                .maxcoach-tab-nav-buttons button:hover,
                .maxcoach-list .badge,
                .maxcoach-blog-caption-style-03 .tm-button.style-bottom-line .button-content-wrapper:after,
                .hint--primary:after,
                [data-fp-section-skin='dark'] #fp-nav ul li a span,
                [data-fp-section-skin='dark'] .fp-slidesNav ul li a span,
                .page-scroll-up,
                .top-bar-01 .top-bar-button,
				.tm-social-networks.style-flat-rounded-icon .link:hover,
				.tm-swiper .swiper-pagination-progressbar .swiper-pagination-progressbar-fill,
				.tm-social-networks.style-flat-rounded-icon .link,
				.tm-social-networks.style-solid-rounded-icon .link:hover,
				.portfolio-overlay-group-01.portfolio-overlay-colored-faded .post-overlay,
				.maxcoach-modern-carousel .slide-tag,
				.maxcoach-light-gallery .maxcoach-box .maxcoach-overlay,
				.maxcoach-accordion-style-02 .maxcoach-accordion .accordion-section.active .accordion-header,
				.maxcoach-accordion-style-02 .maxcoach-accordion .accordion-section:hover .accordion-header,
				.maxcoach-mailchimp-form-style-01 .form-submit:hover,
				.maxcoach-modern-carousel-style-02 .slide-button:after,
				.nav-links a:hover,
				.page-sidebar .insight-core-bmw li:hover a,
				.page-sidebar .insight-core-bmw li.current-menu-item a,
				.single-post .entry-post-feature.post-quote,
				.post-share.style-01 .share-media:hover .share-icon,
				.entry-portfolio-feature .gallery-item .overlay,
				.widget .tagcloud a:hover,
				.widget_calendar #today,
				.widget_search .search-submit:hover,
				.widget_product_search .search-submit:hover,
				.page-main-content .search-form .search-submit:hover,
				.woocommerce .select2-container--default .select2-results__option--highlighted[aria-selected],
				.select2-container--default .select2-results__option[aria-selected=true],
				.select2-container--default .select2-results__option[data-selected=true],
				.course-caption-style-02 .maxcoach-course .course-info .course-price,
				.course-caption-style-04 .maxcoach-course .course-info .course-price,
				.course-caption-style-05 .maxcoach-course .course-info .course-price,
				.course-caption-style-07 .maxcoach-course .course-info .course-price,
				.profile .author-social-networks a:hover,
				.profile #learn-press-profile-nav ul.tabs > li > a:after,
				.profile .lp-tab-sections .section-tab.active span:after,
				#learn-press-course-tabs ul.learn-press-nav-tabs .course-nav:after,
				body.single-lp_course.course-item-popup #learn-press-course-curriculum .toggle-content-item:hover,
				.single-lp_course .course-curriculum ul.curriculum-sections .section-content .course-item .course-item-meta .course-item-status,
				.learnpress .learn-press-progress .progress-bg .progress-active,
				.learnpress .learn-press-course-results-progress .items-progress .lp-course-status .grade.passed,
				.learnpress .learn-press-course-results-progress .course-progress .lp-course-status .grade.passed,
				body.single-lp_course.course-item-popup .course-item-nav a:hover,
				body.single-lp_course.course-item-popup .course-curriculum ul.curriculum-sections .section-content .course-item.current";

			$bg_color_important_selectors = "
				.primary-background-color-important,
				.lg-progress-bar .lg-progress
				";

			$border_color_selectors = "
				.wp-block-quote,
				.wp-block-quote.has-text-align-right,
				.wp-block-quote.has-text-align-right,
				.tm-button.style-border,
				.tm-button.style-thick-border,
				.maxcoach-tab-nav-buttons button:hover,
				.maxcoach-fake-select-wrap.focused .maxcoach-fake-select-current,
				.maxcoach-fake-select-wrap .maxcoach-fake-select-current:hover,
				.page-search-popup .search-field,
				.tm-social-networks.style-solid-rounded-icon .link,
				.tm-popup-video.type-button .video-play,
				.widget_pages .current-menu-item, 
				.widget_nav_menu .current-menu-item,
				.insight-core-bmw .current-menu-item,
				.page-sidebar .insight-core-bmw li:hover a,
				.page-sidebar .insight-core-bmw li.current-menu-item a,
				.course-caption-style-07 .maxcoach-course .course-wrapper:hover .course-thumbnail-wrapper,
				.course-caption-style-09 .maxcoach-course .course-wrapper:hover .course-info
			";

			$border_color_important_selectors = "
				.single-product .woo-single-gallery .maxcoach-thumbs-swiper .swiper-slide:hover img,
				.single-product .woo-single-gallery .maxcoach-thumbs-swiper .swiper-slide-thumb-active img,
				.lg-outer .lg-thumb-item.active, .lg-outer .lg-thumb-item:hover
			";

			$border_top_color_selectors = "
				.hint--primary.hint--top-left:before,
                .hint--primary.hint--top-right:before,
                .hint--primary.hint--top:before
			";

			$border_right_color_selectors = "
				.hint--primary.hint--right:before
			";

			$border_bottom_color_selectors = "
				.hint--primary.hint--bottom-left:before,
                .hint--primary.hint--bottom-right:before,
                .hint--primary.hint--bottom:before,
                .maxcoach-tabpanel.maxcoach-tabpanel-horizontal > .maxcoach-nav-tabs li.active a
			";

			$border_left_color_selectors = "
				.hint--primary.hint--left:before,
                .tm-popup-video.type-button .video-play-icon:before
			";

			$primary_selectors = [
				'color'                      => [ $color_selectors ],
				'background-color'           => [ $bg_color_selectors ],
				'background-color-important' => [ $bg_color_important_selectors ],
				'border-color'               => [ $border_color_selectors ],
				'border-color-important'     => [ $border_color_important_selectors ],
				'border-top-color'           => [ $border_top_color_selectors ],
				'border-right-color'         => [ $border_right_color_selectors ],
				'border-bottom-color'        => [ $border_bottom_color_selectors ],
				'border-left-color'          => [ $border_left_color_selectors ],
			];

			$primary_selectors = apply_filters( 'maxcoach_custom_css_primary_color_selectors', $primary_selectors );

			$color          = Maxcoach::setting( 'primary_color' );
			$color_alpha_80 = Maxcoach_Color::hex2rgba( $color, '0.8' );
			$color_alpha_70 = Maxcoach_Color::hex2rgba( $color, '0.7' );
			$color_alpha_10 = Maxcoach_Color::hex2rgba( $color, '0.1' );

			$css = "
				::-moz-selection { color: #fff; background-color: $color }
				::selection { color: #fff; background-color: $color }
			";

			foreach ( $primary_selectors as $key => $selectors ) {
				$css_selectors = implode( ',', $selectors );

				if ( ! empty( $css_selectors ) ) {
					$attr_name   = $key;
					$attr_suffix = '';

					if ( strpos( $key, 'important' ) !== false ) {
						$attr_name   = strstr( $key, '-important', true );
						$attr_suffix = '!important';
					}

					$css .= "{$css_selectors} { {$attr_name}: {$color}$attr_suffix; }";
				}
			}

			$css .= "
				.maxcoach-accordion-style-01 .maxcoach-accordion .accordion-section.active .accordion-header,
				.maxcoach-accordion-style-01 .maxcoach-accordion .accordion-section:hover .accordion-header
				{
					background-color: {$color_alpha_70};
				}";

			$css .= "
				.portfolio-overlay-group-01 .post-overlay
				{
					background-color: {$color_alpha_80};
				}";

			$css .= "
				.maxcoach-testimonial-style-07 .testimonial-item
				{
					background-color: {$color_alpha_10};
				}";

			return $css;
		}

		function secondary_color_css() {
			$color          = Maxcoach::setting( 'secondary_color' );
			$color_alpha_70 = Maxcoach_Color::hex2rgba( $color, '0.7' );
			$color_alpha_60 = Maxcoach_Color::hex2rgba( $color, '0.6' );
			$color_alpha_15 = Maxcoach_Color::hex2rgba( $color, '0.15' );


			// Color.
			$css = "
				.secondary-color,
				.elementor-widget-tm-icon-box.maxcoach-icon-box-style-01 .tm-icon-box .heading,
				.maxcoach-blog-zigzag .post-title,
				.maxcoach-event-grid.style-one-left-featured .featured-event .event-date .event-date--month,
				.course-caption-style-02 .maxcoach-course .course-title,
				.widget_lp-widget-recent-courses .course-title
				{
					color: {$color} 
				}";

			// Background Color.
			$css .= "
				.secondary-background-color,		
				.tm-button.style-flat:after,
				.hint--secondary:after,
				.course-caption-style-11 .course-price,
				.dpn-zvc-single-content-wrapper .dpn-zvc-sidebar-wrapper .dpn-zvc-sidebar-box .join-links .btn.btn-start-link
				{
					background-color: {$color};
				}";

			// Background Color.
			$css .= "
				.maxcoach-event .event-overlay-background,
				.maxcoach-event-carousel .event-overlay-background
				{
					background-color: {$color_alpha_60};
				}";

			// Background Color.
			$css .= "
				.tm-zoom-meeting .zoom-countdown .countdown-content .text
				{
					color: {$color_alpha_70};
				}";

			// Border Top.
			$css .= "
                .hint--secondary.hint--top-left:before,
                .hint--secondary.hint--top-right:before,
                .hint--secondary.hint--top:before
                {
					border-top-color: {$color};
				}";

			// Border Right.
			$css .= "
                .hint--secondary.hint--right:before
                {
					border-right-color: {$color};
				}";

			// Border Bottom.
			$css .= "
                .hint--secondary.hint--bottom-left:before,
                .hint--secondary.hint--bottom-right:before,
                .hint--secondary.hint--bottom:before
                {
					border-bottom-color: {$color};
				}";

			// Border Left.
			$css .= "
                .hint--secondary.hint--left:before
                {
                    border-left-color: {$color};
                }";

			$css .= "
				.secondary-border-color
                {
                    border-color: {$color};
                }
			";

			$css .= "
			.maxcoach-modern-carousel-02 .slide-decorate-text
			{
				color: {$color_alpha_15};
			}";

			return $css;
		}

		function light_gallery_css() {
			$css                    = '';
			$primary_color          = Maxcoach::setting( 'primary_color' );
			$secondary_color        = Maxcoach::setting( 'secondary_color' );
			$cutom_background_color = Maxcoach::setting( 'light_gallery_custom_background' );
			$background             = Maxcoach::setting( 'light_gallery_background' );

			$tmp = '';

			if ( $background === 'primary' ) {
				$tmp .= "background-color: {$primary_color} !important;";
			} elseif ( $background === 'secondary' ) {
				$tmp .= "background-color: {$secondary_color} !important;";
			} else {
				$tmp .= "background-color: {$cutom_background_color} !important;";
			}

			$css .= ".lg-backdrop { $tmp }";

			return $css;
		}

		function off_canvas_menu_css() {
			$css  = '';
			$type = Maxcoach::setting( 'navigation_minimal_01_background_type' );
			if ( $type === 'gradient' ) {
				$gradient = Maxcoach::setting( 'navigation_minimal_01_background_gradient_color' );

				$css .= ".popup-canvas-menu {
				    background-color: {$gradient['color_1']};
					background-image: linear-gradient(138deg, {$gradient['color_1']} 0%, {$gradient['color_2']} 100%);
				}";
			}

			return $css;
		}

		function mobile_menu_css() {
			$css  = '';
			$type = Maxcoach::setting( 'mobile_menu_background_type' );
			if ( $type === 'gradient' ) {
				$gradient = Maxcoach::setting( 'mobile_menu_background_gradient_color' );

				$css .= ".page-mobile-main-menu > .inner {
				    background-color: {$gradient['color_1']};
					background-image: linear-gradient(138deg, {$gradient['color_1']} 0%, {$gradient['color_2']} 100%);
				}";
			}

			return $css;
		}
	}

	Maxcoach_Custom_Css::instance()->initialize();
}
