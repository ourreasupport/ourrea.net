<?php
defined( 'ABSPATH' ) || exit;

/**
 * Custom functions, filters, actions for WooCommerce.
 */
if ( ! class_exists( 'Maxcoach_Woo' ) ) {
	class Maxcoach_Woo extends Maxcoach_Post_Type {

		protected static $instance = null;

		public static $product_image_size_width  = '';
		public static $product_image_size_height = '';
		public static $product_image_crop        = true;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			// Do nothing if Woo plugin not activated.
			if ( ! $this->is_activated() ) {
				return;
			}

			add_filter( 'maxcoach_custom_css_primary_color_selectors', [ $this, 'custom_css' ] );

			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'header_add_to_cart_fragment' ) );

			/**
			 * Move sale price before regular price.
			 */
			add_filter( 'formatted_woocommerce_price', [ $this, 'formatted_woocommerce_price' ], 10, 5 );

			add_filter( 'woocommerce_get_price_html', [ $this, 'simple_product_price_html' ], 100, 2 );
			add_filter( 'woocommerce_variation_sale_price_html', [ $this, 'product_price_html' ], 10, 2 );
			add_filter( 'woocommerce_variation_price_html', [ $this, 'product_price_html' ], 10, 2 );
			add_filter( 'woocommerce_variable_sale_price_html', [ $this, 'product_minmax_price_html' ], 10, 2 );
			add_filter( 'woocommerce_variable_price_html', [ $this, 'product_minmax_price_html' ], 10, 2 );

			/**
			 * Begin hooks for checkout page.
			 */
			add_filter( 'woocommerce_checkout_fields', array( $this, 'override_checkout_fields' ) );
			/**
			 * End hooks for checkout page.
			 */

			add_action( 'wp_head', array( $this, 'wp_init' ) );

			// Move nav count to link.
			add_filter( 'woocommerce_layered_nav_term_html', array(
				$this,
				'move_layered_nav_count_inside_link',
			), 10, 4 );

			/**
			 * Begin hooks for shop archive.
			 */
			add_filter( 'woocommerce_catalog_orderby', array( $this, 'custom_product_sorting' ) );

			add_filter( 'loop_shop_per_page', array( $this, 'loop_shop_per_page' ), 20 );

			add_filter( 'woocommerce_pagination_args', array( $this, 'override_pagination_args' ) );

			// Hide star rating.
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

			// Add link to the product title of loop.
			remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
			add_action( 'woocommerce_shop_loop_item_title', array(
				$this,
				'template_loop_product_title',
			), 10 );
			/**
			 * End hooks for shop archive.
			 */

			/**
			 * Begin hooks for single product.
			 */
			// Move product rating after product price.
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating' );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );

			// Add sharing list.
			add_action( 'woocommerce_share', array( $this, 'entry_sharing' ) );

			// Remove tab heading in on single product pages.
			add_filter( 'woocommerce_product_description_heading', '__return_empty_string' );
			add_filter( 'woocommerce_product_additional_information_heading', '__return_empty_string' );

			// Change review avatar size.
			add_filter( 'woocommerce_review_gravatar_size', array( $this, 'woocommerce_review_gravatar_size' ) );

			// Hide default smart compare & smart wishlist button.
			add_filter( 'woosw_button_position_archive', '__return_zero_string' );
			add_filter( 'woosw_button_position_single', '__return_zero_string' );
			add_filter( 'filter_wooscp_button_archive', '__return_zero_string' );
			add_filter( 'filter_wooscp_button_single', '__return_zero_string' );

			// Add compare & wishlist button again.
			add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'get_wishlist_button_template' ) );
			add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'get_compare_button_template' ) );

			add_action( 'woocommerce_before_quantity_input_field', array( $this, 'add_quantity_increase_button' ) );
			add_action( 'woocommerce_after_quantity_input_field', array( $this, 'add_quantity_decrease_button' ) );

			// Add div tag wrapper quantity.
			add_action( 'woocommerce_before_add_to_cart_quantity', array( $this, 'add_quantity_open_wrapper' ) );
			add_action( 'woocommerce_after_add_to_cart_quantity', array( $this, 'add_quantity_close_wrapper' ) );
			/**
			 * End hooks for single product.
			 */

			/**
			 * Begin hooks for cart page.
			 */
			// Check for empty-cart get param to clear the cart.
			add_action( 'init', array( $this, 'woocommerce_clear_cart_url' ) );

			// Edit cart empty messages.
			remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
			add_action( 'woocommerce_cart_is_empty', array( $this, 'change_empty_cart_messages' ), 10 );
			/**
			 * End hook for cart page.
			 */

			/**
			 * Begin ajax requests.
			 */
			// Load more for widget Product.
			add_action( 'wp_ajax_product_infinite_load', array( $this, 'product_infinite_load' ) );
			add_action( 'wp_ajax_nopriv_product_infinite_load', array( $this, 'product_infinite_load' ) );

			// Quick view feature.
			add_action( 'wp_ajax_product_quick_view', array( $this, 'get_quick_view_content' ) );
			add_action( 'wp_ajax_nopriv_product_quick_view', array( $this, 'get_quick_view_content' ) );
			/**
			 * End ajax requests.
			 */

			add_action( 'after_switch_theme', array( $this, 'change_product_image_size' ), 2 );
			add_action( 'after_setup_theme', array( $this, 'modify_theme_support' ), 10 );
		}

		/**
		 * Add span tag wrap around decimal separator
		 *
		 * @param $formatted_price
		 * @param $price
		 * @param $number_decimals
		 * @param $decimals_separator
		 * @param $thousand_separator
		 *
		 * @return mixed|string
		 */
		public function formatted_woocommerce_price( $formatted_price, $price, $number_decimals, $decimals_separator, $thousand_separator ) {
			if ( $number_decimals > 0 && ! empty( $decimals_separator ) ) {
				$origin_price = str_replace( $decimals_separator, '<span class="decimals-separator">' . $decimals_separator, $formatted_price );
				$origin_price .= '</span>';

				return $origin_price;
			}

			return $formatted_price;
		}

		/**
		 * Check woocommerce plugin active
		 *
		 * @return boolean true if plugin activated
		 */
		function is_activated() {
			if ( class_exists( 'WooCommerce' ) ) {
				return true;
			}

			return false;
		}

		public function custom_css( $selectors ) {
			$selectors['color'][] = "
				.widget_price_filter .ui-slider,
				.maxcoach-product .woocommerce-loop-product__title a:hover,
				.woocommerce .product-badges .onsale,
				.cart-collaterals .order-total .amount,
				.woocommerce-mini-cart__empty-message .empty-basket,
				.woocommerce .cart_list.product_list_widget a:hover,
				.woocommerce .cart.shop_table td.product-name a:hover,
				.woocommerce ul.product_list_widget li .product-title:hover,
				.entry-product-meta a:hover,
				.popup-product-quick-view .product_title a:hover
			";

			$selectors['background-color'][] = "
				.maxcoach-product.style-grid .woocommerce_loop_add_to_cart_wrap a:hover,
				.maxcoach-product.style-grid .quick-view-icon:hover,
				.maxcoach-product.style-grid .woosw-btn:hover,
				.maxcoach-product.style-grid .wooscp-btn:hover,
				.wishlist-btn.style-01 a:hover,
				.compare-btn.style-01 a:hover,
				.woocommerce-info, .woocommerce-message,
				.woocommerce-MyAccount-navigation .is-active a,
				.woocommerce-MyAccount-navigation a:hover
			";

			$selectors['border-color'][] = "
				.wishlist-btn.style-01 a:hover,
				.compare-btn.style-01 a:hover,
				body.woocommerce-cart table.cart td.actions .coupon .input-text:focus,
				.woocommerce div.quantity .qty:focus,
				.woocommerce div.quantity button:hover:before,
				.woocommerce.single-product div.product .images .thumbnails .item img:hover
			";

			$selectors['border-bottom-color'][] = "
				.mini-cart .widget_shopping_cart_content,
				.single-product .woocommerce-tabs li.active,
				.woocommerce .select2-container .select2-choice
			";

			return $selectors;
		}

		function custom_price_html( $price_amt, $regular_price, $sale_price ) {
			$html_price = '<p class="price">';
			// If product is in sale.
			if ( ( $price_amt == $sale_price ) && ( $sale_price != 0 ) ) {
				$html_price .= '<ins>' . wc_price( $sale_price ) . '</ins>';
				$html_price .= '<del>' . wc_price( $regular_price ) . '</del>';
			} // in sale but free.
			else if ( ( $price_amt == $sale_price ) && ( $sale_price == 0 ) ) {
				$html_price .= '<ins>' . esc_html__( 'Free!', 'maxcoach' ) . '</ins>';
				$html_price .= '<del>' . wc_price( $regular_price ) . '</del>';
			} // not is sale.
			else if ( ( $price_amt == $regular_price ) && ( $regular_price != 0 ) ) {
				$html_price .= '<ins>' . wc_price( $regular_price ) . '</ins>';
			} // for free product.
			else if ( ( $price_amt == $regular_price ) && ( $regular_price == 0 ) ) {
				$html_price .= '<ins>' . esc_html__( 'Free!', 'maxcoach' ) . '</ins>';
			}
			$html_price .= '</p>';

			return $html_price;
		}

		/**
		 * @param            $price
		 * @param WC_Product $product
		 *
		 * @return string
		 */
		public function simple_product_price_html( $price, $product ) {
			if ( $product->is_type( 'simple' ) ) {
				$regular_price = $product->get_regular_price();
				$sale_price    = $product->get_sale_price();
				$price_amt     = $product->get_price();

				return $this->custom_price_html( $price_amt, $regular_price, $sale_price );
			} else {
				return $price;
			}
		}

		public function product_price_html( $price, $variation ) {
			$variation_id = $variation->variation_id;
			//creating the product object
			$variable_product = new WC_Product( $variation_id );

			$regular_price = $variable_product->get_regular_price();
			$sale_price    = $variable_product->get_sale_price();
			$price_amt     = $variable_product->get_price();

			return $this->custom_price_html( $price_amt, $regular_price, $sale_price );
		}

		/**
		 * @param                     $price
		 * @param WC_Product_Variable $product
		 *
		 * @return string
		 */
		public function product_minmax_price_html( $price, $product ) {
			$variation_min_price         = $product->get_variation_price( 'min', true );
			$variation_max_price         = $product->get_variation_price( 'max', true );
			$variation_min_regular_price = $product->get_variation_regular_price( 'min', true );
			$variation_max_regular_price = $product->get_variation_regular_price( 'max', true );

			if ( ( $variation_min_price == $variation_min_regular_price ) && ( $variation_max_price == $variation_max_regular_price ) ) {
				$html_min_max_price = $price;
			} else {
				$html_price         = '<p class="price">';
				$html_price         .= '<ins>' . wc_price( $variation_min_price ) . '-' . wc_price( $variation_max_price ) . '</ins>';
				$html_price         .= '<del>' . wc_price( $variation_min_regular_price ) . '-' . wc_price( $variation_max_regular_price ) . '</del>';
				$html_min_max_price = $html_price;
			}

			return $html_min_max_price;
		}

		function woocommerce_clear_cart_url() {
			global $woocommerce;

			if ( isset( $_GET['empty-cart'] ) ) {
				$woocommerce->cart->empty_cart();
			}
		}

		function change_empty_cart_messages() {
			?>
			<div class="empty-cart-messages">
				<div class="empty-cart-icon">
					<span class="fal fa-shopping-cart"></span>
				</div>
				<h2 class="empty-cart-heading"><?php esc_html_e( 'Your cart is currently empty.', 'maxcoach' ); ?></h2>
				<p class="empty-cart-text"><?php esc_html_e( 'You may check out all the available products and buy some in the shop.', 'maxcoach' ); ?></p>
			</div>
			<?php
		}

		public function add_quantity_open_wrapper() {
			?>
			<div class="quantity-button-wrapper">
			<label><?php esc_html_e( 'Quantity', 'maxcoach' ); ?></label>
			<?php
		}

		public function add_quantity_close_wrapper() {
			global $product;

			echo wc_get_stock_html( $product ); // WPCS: XSS ok.
			?>
			</div>
			<?php
		}

		public function add_quantity_increase_button() {
			echo '<button type="button" class="increase"></button>';
		}

		public function add_quantity_decrease_button() {
			echo '<button type="button" class="decrease"></button>';
		}

		function entry_sharing() {
			if ( Maxcoach::setting( 'single_product_sharing_enable' ) === '1' && class_exists( 'InsightCore' ) ) :
				$social_sharing = Maxcoach::setting( 'social_sharing_item_enable' );
				if ( ! empty( $social_sharing ) ) {
					?>
					<div class="entry-product-share">
						<h6><?php esc_html_e( 'Share:', 'maxcoach' ); ?></h6>
						<div class="inner">
							<?php Maxcoach_Templates::get_sharing_list(); ?>
						</div>
					</div>
					<?php
				}
			endif;
		}

		/*
		 * Change woocommerce product image size on first time switch to this theme.
		 */
		public function change_product_image_size() {
			global $pagenow;

			if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
				return;
			}

			$count = get_option( 'maxcoach_switch_theme_count' );

			// Do it for first time.
			if ( ! $count || $count < 2 ) {
				// Update single image width
				//update_option( 'woocommerce_single_image_width', 760 );

				// Update thumbnail image width.
				update_option( 'woocommerce_thumbnail_image_width', 480 );

				// Update thumbnail cropping ratio.
				update_option( 'woocommerce_thumbnail_cropping', 'custom' );
				update_option( 'woocommerce_thumbnail_cropping_custom_width', 4 );
				update_option( 'woocommerce_thumbnail_cropping_custom_height', 5 );
			}
		}

		/**
		 * Modify image width theme support.
		 */
		function modify_theme_support() {
			/*$theme_support                          = get_theme_support( 'woocommerce' );
			$theme_support                          = is_array( $theme_support ) ? $theme_support[0] : array();
			$theme_support['single_image_width']    = 760;
			$theme_support['thumbnail_image_width'] = 400;

			remove_theme_support( 'woocommerce' );*/
			add_theme_support( 'woocommerce' );
		}

		/**
		 * Returns true if on a page which uses WooCommerce templates exclude single product (cart and checkout are standard pages with shortcodes and which are also included)
		 *
		 * @access public
		 * @return bool
		 */
		function is_woocommerce_page_without_product() {
			if ( function_exists( 'is_shop' ) && is_shop() ) {
				return true;
			}

			if ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) {
				return true;
			}

			if ( is_post_type_archive( 'product' ) ) {
				return true;
			}

			$the_id = get_the_ID();

			if ( $the_id !== false ) {
				$woocommerce_keys = array(
					'woocommerce_shop_page_id',
					'woocommerce_terms_page_id',
					'woocommerce_cart_page_id',
					'woocommerce_checkout_page_id',
					'woocommerce_pay_page_id',
					'woocommerce_thanks_page_id',
					'woocommerce_myaccount_page_id',
					'woocommerce_edit_address_page_id',
					'woocommerce_view_order_page_id',
					'woocommerce_change_password_page_id',
					'woocommerce_logout_page_id',
					'woocommerce_lost_password_page_id',
				);

				foreach ( $woocommerce_keys as $wc_page_id ) {
					if ( $the_id == get_option( $wc_page_id, 0 ) ) {
						return true;
					}
				}
			}

			return false;
		}

		/**
		 * Returns true if on a page which uses WooCommerce templates (cart and checkout are standard pages with shortcodes and which are also included)
		 *
		 * @access public
		 * @return bool
		 */
		function is_woocommerce_page() {
			if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
				return true;
			}

			$woocommerce_keys = array(
				"woocommerce_shop_page_id",
				"woocommerce_terms_page_id",
				"woocommerce_cart_page_id",
				"woocommerce_checkout_page_id",
				"woocommerce_pay_page_id",
				"woocommerce_thanks_page_id",
				"woocommerce_myaccount_page_id",
				"woocommerce_edit_address_page_id",
				"woocommerce_view_order_page_id",
				"woocommerce_change_password_page_id",
				"woocommerce_logout_page_id",
				"woocommerce_lost_password_page_id",
			);

			foreach ( $woocommerce_keys as $wc_page_id ) {
				if ( get_the_ID() == get_option( $wc_page_id, 0 ) ) {
					return true;
				}
			}

			return false;
		}

		/**
		 * Returns true if on a archive product pages.
		 *
		 * @access public
		 * @return bool
		 */
		function is_product_archive() {
			if ( is_post_type_archive( 'product' ) || ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Custom product title instead of default product title
		 *
		 * @see woocommerce_template_loop_product_title()
		 */
		function template_loop_product_title() {
			?>
			<h2 class="woocommerce-loop-product__title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>
			<?php
		}

		function loop_shop_per_page() {
			if ( isset( $_GET['shop_archive_preset'] ) && in_array( $_GET['shop_archive_preset'], [
					'left-sidebar',
					'right-sidebar',
				] ) ) {
				// Hard set post per page. because override preset settings run after init hook.
				$number = 9;
			} else {
				$number = Maxcoach::setting( 'shop_archive_number_item' );
			}

			return isset( $_GET['product_per_page'] ) ? wc_clean( $_GET['product_per_page'] ) : $number;
		}

		function override_pagination_args( $args ) {
			$args['prev_text'] = Maxcoach_Templates::get_pagination_prev_text();
			$args['next_text'] = Maxcoach_Templates::get_pagination_next_text();

			return $args;
		}

		function woocommerce_review_gravatar_size() {
			return Maxcoach::COMMENT_AVATAR_SIZE;
		}

		function wp_init() {
			if ( Maxcoach::setting( 'single_product_tabs_enable' ) === '0' ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			}

			if ( Maxcoach::setting( 'single_product_up_sells_enable' ) === '0' ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
			}

			if ( Maxcoach::setting( 'single_product_related_enable' ) === '0' ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			}

			// Remove Cross Sells from default position at Cart. Then add them back UNDER the Cart Table.
			remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
			if ( Maxcoach::setting( 'shopping_cart_cross_sells_enable' ) === '1' ) {
				add_action( 'woocommerce_after_cart_table', 'woocommerce_cross_sell_display' );
			}

			if ( Maxcoach::setting( 'shop_archive_sorting' ) !== '1' ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			} else {
				add_action( 'woocommerce_before_shop_loop', [ $this, 'add_shop_action_begin_wrapper' ], 15 );
				add_action( 'woocommerce_before_shop_loop', [ $this, 'add_shop_action_end_wrapper' ], 35 );
			}
		}

		function add_shop_action_begin_wrapper() {
			echo '<div class="archive-shop-actions row row-xs-center">';
		}

		function add_shop_action_end_wrapper() {
			echo '</div>';
		}

		public function custom_product_sorting( $sorting_options ) {
			if ( isset( $sorting_options['menu_order'] ) ) {
				$sorting_options['menu_order'] = esc_html__( 'Default', 'maxcoach' );
			}

			if ( isset( $sorting_options['popularity'] ) ) {
				$sorting_options['popularity'] = esc_html__( 'Popularity', 'maxcoach' );
			}

			if ( isset( $sorting_options['rating'] ) ) {
				$sorting_options['rating'] = esc_html__( 'Average rating', 'maxcoach' );
			}

			if ( isset( $sorting_options['date'] ) ) {
				$sorting_options['date'] = esc_html__( 'Latest', 'maxcoach' );
			}

			if ( isset( $sorting_options['price'] ) ) {
				$sorting_options['price'] = esc_html__( 'Price: low to high', 'maxcoach' );
			}

			if ( isset( $sorting_options['price-desc'] ) ) {
				$sorting_options['price-desc'] = esc_html__( 'Price: high to low', 'maxcoach' );
			}

			return $sorting_options;
		}

		/**
		 * Add placeholder for all fields.
		 *
		 * @param $fields
		 *
		 * @return mixed
		 */
		function override_checkout_fields( $fields ) {
			// Add placeholder for billing form.
			foreach ( $fields['billing'] as $field => $value ) {
				// If has label & not has placeholder.
				if ( ! empty( $fields['billing'][ $field ]['label'] ) && empty( $fields['billing'][ $field ]['placeholder'] ) ) {
					$fields['billing'][ $field ]['placeholder'] = $fields['billing'][ $field ]['label'];
				}
			}

			// Add placeholder for shipping form.
			foreach ( $fields['shipping'] as $field => $value ) {
				// If has label & not has placeholder.
				if ( ! empty( $fields['shipping'][ $field ]['label'] ) && empty( $fields['shipping'][ $field ]['placeholder'] ) ) {
					$fields['shipping'][ $field ]['placeholder'] = $fields['shipping'][ $field ]['label'];
				}
			}

			return $fields;
		}

		/**
		 * Ensure cart contents update when products are added to the cart via AJAX
		 * ========================================================================
		 *
		 * @param $fragments
		 *
		 * @return mixed
		 */
		function header_add_to_cart_fragment( $fragments ) {
			ob_start();
			$cart_html = $this->get_mini_cart();
			echo '' . $cart_html;
			$fragments['.mini-cart__button'] = ob_get_clean();

			return $fragments;
		}

		/**
		 * Get mini cart HTML
		 * ==================
		 *
		 * @return string
		 */
		function get_mini_cart() {
			global $woocommerce;
			$cart_url = '/cart';
			if ( isset( $woocommerce ) ) {
				$cart_url = wc_get_cart_url();
			}

			$cart_html = '';
			$qty       = WC()->cart->get_cart_contents_count();
			$cart_html .= '<a href="' . esc_url( $cart_url ) . '" class="mini-cart__button header-icon" title="' . esc_attr__( 'View your shopping cart', 'maxcoach' ) . '">';
			$cart_html .= '<span class="mini-cart-icon" data-count="' . $qty . '"></span>';
			$cart_html .= '</a>';

			return $cart_html;
		}

		function render_mini_cart() {
			$header_type = Maxcoach_Global::instance()->get_header_type();

			$enabled = Maxcoach::setting( "header_style_{$header_type}_cart_enable" );

			if ( $this->is_activated() && in_array( $enabled, array( '1', 'hide_on_empty' ) ) ) {
				$classes = 'mini-cart';
				if ( $enabled === 'hide_on_empty' ) {
					$classes .= ' hide-on-empty';
				}
				?>
				<div id="mini-cart" class="<?php echo esc_attr( $classes ); ?>">
					<?php echo '' . $this->get_mini_cart(); ?>
					<div class="widget_shopping_cart_content"></div>
				</div>
			<?php }
		}

		/**
		 * @return string
		 */
		function get_percentage_price() {
			global $product;

			if ( $product->is_type( 'simple' ) || $product->is_type( 'external' ) ) {
				$_regular_price = $product->get_regular_price();
				$_sale_price    = $product->get_sale_price();

				$percentage = round( ( ( $_regular_price - $_sale_price ) / $_regular_price ) * 100 );

				return "-{$percentage}%";
			} else {
				return esc_html__( 'Sale !', 'maxcoach' );
			}
		}

		function get_wishlist_button_template( $args = array() ) {
			if ( ( Maxcoach::setting( 'shop_archive_wishlist' ) !== '1' ) || ! class_exists( 'WPcleverWoosw' ) ) {
				return;
			}

			global $product;
			$product_id = $product->get_id();

			$defaults = array(
				'show_tooltip'     => true,
				'tooltip_position' => 'top',
				'tooltip_skin'     => 'primary',
				'style'            => '01',
			);
			$args     = wp_parse_args( $args, $defaults );

			$_wrapper_classes = "product-action wishlist-btn style-{$args['style']}";

			if ( $args['show_tooltip'] === true ) {
				$_wrapper_classes .= ' hint--bounce';
				$_wrapper_classes .= " hint--{$args['tooltip_position']}";
				$_wrapper_classes .= " hint--{$args['tooltip_skin']}";
			}
			?>
			<div class="<?php echo esc_attr( $_wrapper_classes ); ?>"
			     aria-label="<?php esc_attr_e( 'Add to wishlist', 'maxcoach' ) ?>">
				<?php echo do_shortcode( '[woosw id="' . $product_id . '" type="link"]' ); ?>
			</div>
			<?php
		}

		function get_compare_button_template( $args = array() ) {
			if ( Maxcoach::setting( 'shop_archive_compare' ) !== '1' || wp_is_mobile() || ! class_exists( 'WPcleverWooscp' ) ) {
				return;
			}

			global $product;
			$product_id = $product->get_id();

			$defaults = array(
				'show_tooltip'     => true,
				'tooltip_position' => 'top',
				'tooltip_skin'     => 'primary',
				'style'            => '01',
			);
			$args     = wp_parse_args( $args, $defaults );

			$_wrapper_classes = "product-action compare-btn style-{$args['style']}";

			if ( $args['show_tooltip'] === true ) {
				$_wrapper_classes .= ' hint--bounce';
				$_wrapper_classes .= " hint--{$args['tooltip_position']}";
				$_wrapper_classes .= " hint--{$args['tooltip_skin']}";
			}
			?>
			<div class="<?php echo esc_attr( $_wrapper_classes ); ?>"
			     aria-label="<?php esc_attr_e( 'Compare', 'maxcoach' ) ?>">
				<?php echo do_shortcode( '[wooscp id="' . $product_id . '" type="link"]' ); ?>
			</div>
			<?php
		}

		function get_quick_view_button_template( $args = array() ) {
			if ( ( Maxcoach::setting( 'shop_archive_quick_view' ) !== '1' ) || wp_is_mobile() ) {
				return;
			}

			global $product;
			$product_id = $product->get_id();

			$defaults = array(
				'show_tooltip'     => true,
				'tooltip_position' => 'top',
				'tooltip_skin'     => 'primary',
				'style'            => '01',
			);
			$args     = wp_parse_args( $args, $defaults );

			$_wrapper_classes = "product-action quick-view-btn style-{$args['style']}";

			if ( $args['show_tooltip'] === true ) {
				$_wrapper_classes .= ' hint--bounce';
				$_wrapper_classes .= " hint--{$args['tooltip_position']}";
				$_wrapper_classes .= " hint--{$args['tooltip_skin']}";
			}
			?>
			<div class="<?php echo esc_attr( $_wrapper_classes ); ?>"
			     aria-label="<?php echo esc_attr__( 'Quick view', 'maxcoach' ) ?>"
			     data-pid="<?php echo esc_attr( $product_id ); ?>"
			     data-pnonce="<?php echo wp_create_nonce( 'woo_quick_view' ); ?>">
				<a class="quick-view-icon" href="#"></a>
			</div>
			<?php
		}

		public function get_quick_view_content() {
			$productId = $_REQUEST['pid'];

			/*$product = wc_get_product( $productId );
			$post    = get_post( $productId );*/

			$post_object = get_post( $productId );

			setup_postdata( $GLOBALS['post'] =& $post_object );

			ob_start();
			wc_get_template_part( 'content', 'quick-view' );
			$template = ob_get_contents();
			ob_clean();

			$response['template'] = $template;

			echo json_encode( $response );

			wp_die();
		}

		public function product_infinite_load() {
			$source = isset( $_POST['source'] ) ? $_POST['source'] : '';

			if ( 'current_query' === $source ) {
				$query_vars                = $_POST['query_vars'];
				$query_vars['paged']       = $_POST['paged'];
				$query_vars['nopaging']    = false;
				$query_vars['post_status'] = 'publish';

				$maxcoach_query = new WP_Query( $query_vars );
			} else {
				$query_args = array(
					'post_type'      => $_POST['post_type'],
					'posts_per_page' => $_POST['posts_per_page'],
					'orderby'        => $_POST['orderby'],
					'order'          => $_POST['order'],
					'paged'          => $_POST['paged'],
					'post_status'    => 'publish',
				);

				if ( ! empty( $_POST['extra_taxonomy'] ) ) {
					$query_args = $this->build_extra_terms_query( $query_args, $_POST['extra_taxonomy'] );
				}

				$maxcoach_query = new WP_Query( $query_args );
			}

			$response = array(
				'max_num_pages' => $maxcoach_query->max_num_pages,
				'found_posts'   => $maxcoach_query->found_posts,
				'count'         => $maxcoach_query->post_count,
			);

			ob_start();

			if ( $maxcoach_query->have_posts() ) :

				while ( $maxcoach_query->have_posts() ) : $maxcoach_query->the_post();
					wc_get_template_part( 'content', 'product' );
				endwhile;

				wp_reset_postdata();

			endif;

			$template = ob_get_contents();
			ob_clean();

			$response['template'] = $template;

			echo json_encode( $response );

			wp_die();
		}

		function get_product_image( $args = array() ) {
			$defaults = array(
				'extra_class' => '',
			);

			$args = wp_parse_args( $args, $defaults );

			// Calculate product loop image size.
			if ( self::$product_image_size_width === '' ) {
				$width = 400;

				$shop_layout = Maxcoach::setting( 'shop_archive_layout' );
				if ( 'wide' === $shop_layout ) {
					$width = 540;
				}

				$cropping = get_option( 'woocommerce_thumbnail_cropping' );
				$height   = $width;

				if ( $cropping === 'custom' ) {
					$ratio_w = get_option( 'woocommerce_thumbnail_cropping_custom_width' );
					$ratio_h = get_option( 'woocommerce_thumbnail_cropping_custom_height' );

					$height = ( $width * $ratio_h ) / $ratio_w;
					$height = (int) $height;
				} elseif ( $cropping === 'uncropped' ) {
					self::$product_image_crop = false;
					$height                   = 9999;
				}

				self::$product_image_size_width  = $width;
				self::$product_image_size_height = $height;
			}

			$image_args = array(
				'id'     => $args['id'],
				'size'   => 'custom',
				'width'  => self::$product_image_size_width,
				'height' => self::$product_image_size_height,
				'crop'   => self::$product_image_crop,
			);

			if ( $args['extra_class'] !== '' ) {
				$image_args['class'] = $args['extra_class'];
			}

			Maxcoach_Image::the_attachment_by_id( $image_args );
		}

		function move_layered_nav_count_inside_link( $term_html, $term, $link, $count ) {
			if ( $count > 0 ) {
				$term_html = str_replace( '</a>', '', $term_html );
				$term_html = str_replace( '</span>', '</span></a>', $term_html );
			}

			return $term_html;
		}

		public function get_single_product_style() {
			$style = Maxcoach_Helper::get_post_meta( 'single_product_layout_style' );

			if ( empty( $style ) ) {
				$style = Maxcoach::setting( 'single_product_layout_style' );
			}

			return $style;
		}
	}

	Maxcoach_Woo::instance()->initialize();
}
