<?php

class LP_Addon_Woo_Payment extends LP_Addon {
	/**
	 * @var string
	 */
	public $version = LP_ADDON_WOO_PAYMENT_VER;

	/**
	 * @var string
	 */
	public $require_version = LP_ADDON_WOO_PAYMENT_REQUIRE_VER;

	/**
	 * @var int flag to get the error
	 */
	protected static $_error = 0;

	/**
	 * Courses should not display purchase button
	 *
	 * @var array
	 */
	protected $_hide_purchase_buttons = array();

	/**
	 * @var bool
	 */
	protected $_single_purchase = false;

	/**
	 * @var array
	 */
	protected $_response = array();

	/**
	 * @var LP_Addon_Woo_Payment|null
	 *
	 * Hold the singleton of LP_Woo_Payment_Preload object
	 */
	protected static $_instance = null;

	/**
	 * LP_Woo_Payment_Preload constructor.
	 */
	public function __construct() {
	    parent::__construct();
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
	}

	public function plugins_loaded() {
		parent::__construct();
		$this->_includes();
		$this->_response['single_purchase'] = LP()->settings->get( 'woo_purchase_button' ) == 'single';
	}

	/**
	 * Include files needed
	 */
	protected function _includes() {
		// WooCommerce activated
		if ( $this->woo_actived() && function_exists( 'LP' ) ) {
			require_once LP_ADDON_WOO_PAYMENT_PATH . '/incs/functions.php';
			require_once LP_ADDON_WOO_PAYMENT_PATH . '/incs/admin/course.php';
			// Enabled payment and checkout
			if ( $this->is_enabled() && $this->woo_payment_enabled() || $this->woo_checkout_enabled() ) {
				require_once LP_ADDON_WOO_PAYMENT_PATH . '/incs/class-wc-product-lp-course.php';
			}
			// init hooks
			$this->init_hooks();
			$payment = LP_ADDON_WOO_PAYMENT_PATH . '/incs/class-lp-wc-payment.php';
			if ( file_exists( $payment ) ) {
				require_once $payment;
			}

			if ( $this->is_enabled() && $this->woo_checkout_enabled() ) {
				// WooCommerce checkout
				$checkout = require_once LP_ADDON_WOO_PAYMENT_PATH . '/incs/class-lp-wc-checkout.php';
				if ( file_exists( $checkout ) ) {
					require_once $checkout;
				}
			}
		} else {
			self::$_error = 1;
			add_action( 'admin_notices', array( __CLASS__, 'admin_notice' ) );
		}
	}

	/**
	 * Init hooks
	 */
	public function init_hooks() {
		if ( ! $this->is_enabled() ) {
			return;
		}
		add_filter( 'woocommerce_product_class', array( $this, 'product_class' ), 10, 4 );
		add_filter( 'woocommerce_cart_item_quantity', array( $this, 'disable_quantity_box' ), 10, 3 );
		add_filter( 'woocommerce_add_to_cart_handler', array( $this, 'add_to_cart_handler' ), 10, 2 );
		add_action( 'woocommerce_order_status_changed', array( $this, 'learnpress_update_order_status' ), 10, 3 );
		add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'create_order' ), 10, 2 );

		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
		add_filter( 'learn_press_purchase_course_login_redirect', '__return_false' );

		add_action( 'learn-press/before-course-buttons', array( $this, 'purchase_course_notice' ) );
		add_action( 'learn-press/after-course-buttons', array( $this, 'after_course_buttons' ) );

		add_action( 'learn-press/before-purchase-button', array( $this, 'before_purchase_button' ) );
		add_action( 'learn-press/after-purchase-button', array( $this, 'after_purchase_button' ) );
		add_action( 'learn-press/after-purchase-button', array( $this, 'add_to_cart' ) );


		add_action( 'admin_notices', array( $this, 'wc_order_notice' ), 99 );
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'order_item_line' ), 10, 4 );
		add_action( 'learn_press_add_to_cart', array( $this, 'add_to_woo' ), 100, 4 );

		add_action('learn-press/enroll-course-handler', array( $this, 'enroll_course_handler_callback' ), 9, 4 );
		add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'woocommerce_add_to_cart_course_validation' ), 100, 3 );
	}

	public function woocommerce_add_to_cart_course_validation( $passed, $product_id, $quantity ){
	        if( $quantity && get_post_type( $product_id ) === LP_COURSE_CPT){
	            $passed = true;
	        }

		return $passed;
	}


	public function add_to_woo( $course_id, $quantity, $item_data, $cart ) {
		if( LP_COURSE_CPT !== get_post_type($course_id)){
			return;
		}
		$course = learn_press_get_course( $course_id );
		if( $course->is_free() ) {
			return;
		}
		if ( $this->_response['single_purchase'] ) {
			WC()->cart->empty_cart();
		}
		WC()->cart->add_to_cart( $course_id );
	}



	function enroll_course_handler_callback( $course_id, $order_id, $action, $item_id = 0 ){

		$course = learn_press_get_course( $course_id );
		if( $course->is_free() ) {
			return;
		}

		wp_redirect(wc_get_checkout_url());
		exit();

	}

	/**
	 * @param $product_type
	 * @param $adding_to_cart
	 *
	 * @return mixed
	 */
	public function add_to_cart_handler( $product_type, $adding_to_cart ) {
		if ( $adding_to_cart instanceof WC_Product_LP_Course ) {
			$course = learn_press_get_course( $adding_to_cart->post->ID );
			$user = learn_press_get_current_user();
			if( $course->is_free() || $user->has_purchased_course( $course->get_id() ) ) {
				return ;
			}
			$this->_response['course_id'] = $course->get_id();

			$this->_response['single_purchase'] = learn_press_get_request( 'single-purchase' ) == 'yes';
			if ( $this->_response['single_purchase'] ) {
				WC()->cart->empty_cart();
			}
			add_action( 'woocommerce_add_to_cart', array( $this, 'added_to_cart' ), 10, 6 );
		}

		return $product_type;
	}

	/**
	 * @param $cart_item_key
	 * @param $product_id
	 * @param $quantity
	 * @param $variation_id
	 * @param $variation
	 * @param $cart_item_data
	 */
	public function added_to_cart( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
		if( LP_COURSE_CPT !== get_post_type($product_id)){
			return;
		}
		if ( $this->_response['single_purchase'] ) {
			$this->_response['redirect'] = wc_get_checkout_url();
		} elseif ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
			$this->_response['redirect'] = wc_get_cart_url();
		}
		add_filter( 'pre_option_woocommerce_cart_redirect_after_add', array(
			$this,
			'cart_redirect_after_add'
		), 1000, 2 );
		add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'add_to_cart_redirect' ), 1000 );
		ob_start();
		wc_add_to_cart_message( array( $product_id => $quantity ), true );
		wc_print_notices();
		$this->_response['message']       = ob_get_clean();
		$this->_response['added_to_cart'] = 'yes';
		add_action( 'shutdown', array( $this, 'shutdown' ), 100 );// worked in version 2.4.8.1
	}

	/**
	 * @param $a
	 * @param $b
	 *
	 * @return string
	 */
	public function cart_redirect_after_add( $a, $b ) {
		return 'no';
	}

	/**
	 * @param $a
	 *
	 * @return bool
	 */
	public function add_to_cart_redirect( $a ) {
		return false;
	}

	/**
	 *
	 */
	public function shutdown() {
		$output = ob_get_clean();
		$is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' );
		if ( $is_ajax && $this->_response ) {
			learn_press_send_json( $this->_response );
		}
	}

	/**
	 *
	 */
	public function wc_order_notice() {
		global $post, $pagenow;
		if ( $pagenow != 'post.php' || empty( $post ) || get_post_type( $post->ID ) != 'shop_order' ) {
			return;
		}
		if ( ! $lp_order_id = get_post_meta( $post->ID, '_learn_press_order_id', true ) ) {
			return;
		}
		?>
        <style type="text/css">
            .woo-payment-order-notice p {
                font-size: 24px;
            }
        </style>
        <div class="error woo-payment-order-notice">
            <p>
				<?php printf( __( 'This order is related to LearnPress order, so if you want to do anything with LearnPres please edit it <a href="%s">here</a>', 'learnpress-woo-payment' ), get_edit_post_link( $lp_order_id ) ); ?>
            </p>
        </div>
		<?php
	}

	/**
	 * Add item line meta data contains our course_id from product_id in cart.
	 * Since WC 3.x order item line product_id always is 0 if it is not a REAL product.
	 * Need to track course_id for creating LP order in WC hook after this action.
	 *
	 * @param $item
	 * @param $cart_item_key
	 * @param $values
	 * @param $order
	 */
	public function order_item_line( $item, $cart_item_key, $values, $order ) {
		if( LP_COURSE_CPT === get_post_type($values['product_id']) ) {
			$item->add_meta_data( '_course_id', $values['product_id'], true );
		}
	}

	/**
	 * Create LP order base on WC order data
	 *
	 * @param $wc_order_id
	 * @param $posted
	 */
	public function create_order( $wc_order_id, $posted ) {
		// Get LP order key related with WC order
		$lp_order_id = get_post_meta( $wc_order_id, '_learn_press_order_id' );
		if ( $lp_order_id && get_post_type($lp_order_id) === LP_ORDER_CPT ) {
			return;
		}

		// Get wc order
		$wc_order = wc_get_order( $wc_order_id );
		if ( ! $wc_order ) {
			return;
		}

		// Get wc order items
		$wc_items = $wc_order->get_items();
		if ( ! $wc_items ) {
			return;
		}
		$courses = array();
		// Find LP courses in WC order and preparing to create LP Order
		$order_items = array();
		$order_total = 0;
		$order_subtotal = 0;
		foreach ( $wc_items as $item ) {
			// WC before 3.x
			$course_id = ! empty( $item['product_id'] ) ? $item['product_id'] : 0;

			// WC 3.x: product_id is 0 if it is a course
			if ( ! $course_id ) {
				$course_id = ! empty( $item['course_id'] ) ? $item['course_id'] : 0;
			}

			// ignore item is not a course post type
			if ( LP_COURSE_CPT != get_post_type( $course_id ) ) {
				continue;
			}
			$courses[] 			= $course_id;
			$order_items[$course_id] 	= $item;
			$order_total 			+= floatval($item->get_total());
			$order_subtotal 		+= floatval($item->get_subtotal());
			if($item->get_tax_status() == 'taxable'){
				$order_total += floatval($item->get_total_tax());
				$order_subtotal += floatval($item->get_total_tax());
			}
		}

		// If there is no course in wc order
		if(!$courses || empty($courses)){
			return false;
		}

		# cretate lp_order
		$customer_note 	= method_exists( $wc_order, 'get_customer_note' ) ? $wc_order->get_customer_note() : $wc_order->customer_note;
		$user_id 		= learn_press_get_current_user_id();
		
		$order_data = array(
			'post_author' 	=> $user_id,
			'post_parent' 	=> '0',
			'post_type' 	=> LP_ORDER_CPT,
			'post_status' 	=> 'lp-'.$wc_order->get_status(),
			'ping_status' 	=> 'closed',
			'post_title' 	=> __( 'Order on', 'learnpress-woo-payment' ) . ' ' . current_time( "l jS F Y h:i:s A" ),
			'meta_input' => array(
				'_order_currency'		=> get_post_meta( $wc_order_id, '_order_currency', true ),
				'_prices_include_tax'		=> floatval($wc_order->get_total_tax()) > 0 ? 'yes':'no',
				'_user_ip_address'		=> learn_press_get_ip(),
				'_user_agent'			=> isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '',
				'_user_id'			=> get_post_meta( $wc_order_id, '_customer_user', true ),
				'_order_total'			=> $order_total,
				'_order_subtotal'		=> $order_subtotal,
				'_order_key'			=> apply_filters( 'learn_press_generate_order_key', uniqid( 'order' ) ),
				'_payment_method'		=> get_post_meta( $wc_order_id, '_payment_method', true ),
				'_payment_method_title'		=> get_post_meta( $wc_order_id, '_payment_method_title', true ),
				'_created_via'			=> 'wc',
				'_woo_order_id'			=> $wc_order_id,
				'user_note'			=> $customer_note,
			)
		);

		$order_id = wp_insert_post( $order_data );
		update_post_meta( $wc_order_id, '_learn_press_order_id', $order_id );

		$lp_order = learn_press_get_order( $order_id );
		foreach ( $order_items as $course_id => $order_item ) {
			$item = array(
				'item_id' 		=> $course_id
				, 'order_item_name' 	=> get_the_title( $course_id )
				, 'subtotal' 		=> $order_item->get_subtotal()
				, 'total' 		=> $order_item->get_total()
			);
			$lp_order->add_item( $item );
		}
		$lp_order->save();
		do_action( 'learn-press/checkout-order-processed', $order_id, null );
		return $order_id;
	}

	/**
	 * Display message if a course has already added into WooCommerce cart
	 */
	public function purchase_course_notice() {
		global $woocommerce;
		$course    = LP()->global['course'];
		$course_id = $course->get_id();
		$user = learn_press_get_current_user();

		if ( ! $this->is_added_in_cart( $course_id ) ) {
			return;
		}
		if( $user->has_purchased_course($course_id) ){
		    #@TODO: remove course from cart
		    return;
		}
		if ( $this->_response['single_purchase'] ) {
			if ( ! $woocommerce || version_compare( $woocommerce->version, '3.0.0', '>=' ) ) {
				add_filter( 'wc_add_to_cart_message_html', array( $this, 'custom_add_to_cart_message' ) );
			} else {
				add_filter( 'wc_add_to_cart_message', array( $this, 'custom_add_to_cart_message' ) );
			}
		}
		if ( ! isset( $_REQUEST['add-to-cart'] ) || ! $_REQUEST['add-to-cart'] ) {
			wc_add_to_cart_message( array( $course_id => 1 ) );
		}
		wc_print_notices();
		echo '<div class="hide-if-js hide">';
	}

	/**
	 * Replace 'View Cart' button with 'Checkout' button of WC message
	 * if our 'Single Purchase' option is selected
	 *
	 * @param $message
	 *
	 * @return mixed
	 */
	public function custom_add_to_cart_message( $message ) {
		if ( $this->_response['single_purchase'] ) {
			if ( preg_match( '~<a.*>(.*)</a>~', $message, $m ) ) {
				$link    = preg_replace( '~>(.*)<~', '>' . __( 'Checkout', 'learnpress-woo-payment' ) . '<', $m[0] );
				$link    = preg_replace( '~href=".*"~U', 'href="' . wc_get_checkout_url() . '"', $link );
				$message = str_replace( $m[0], $link, $message );
			}
		}

		return $message;
	}

	public function after_course_buttons() {
		$course = LP()->global['course'];
		if ( ! $this->is_added_in_cart( $course->get_id() ) ) {
			return;
		}
		echo '</div>';
	}

	/**
	 * Show Add-to-cart button if is enabled
	 */
	public function add_to_cart() {
		learn_press_wc_get_template( 'add-to-cart.php' );
	}

	/**
	 *
	 */
	public function before_purchase_button() {
	    $woopayment = LP()->settings()->get('woo-payment');
	    if( $woopayment['enable'] == 'yes' && $woopayment['purchase_button'] !== 'cart') {
			return;
		}
		echo '<div class="hide-if-js">';
	}

	public function after_purchase_button() {
	    $woopayment = LP()->settings()->get('woo-payment');
	    if( $woopayment['enable'] == 'yes' && $woopayment['purchase_button'] !== 'cart') {
	        return;
	    }
		echo '</div>';
	}

	/**
	 * Return true if a course is already added into WooCommerce cart
	 *
	 * @param $course_id
	 *
	 * @return bool
	 */
	public function is_added_in_cart( $course_id ) {
		if ( ! empty( $this->_hide_purchase_buttons[ $course_id ] ) ) {
			return true;
		}

		foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
			$_product   = $values['data'];
			$product_id = is_callable( array( $_product, 'get_id' ) ) ? $_product->get_id() : $_product->id;
			if ( $course_id == $product_id ) {
				$this->_hide_purchase_buttons[ $course_id ] = true;

				return true;
			}
		}

		return false;
	}

	function scripts() {
		$lp_assets = learn_press_assets();
		$lp_assets->enqueue_script( 'learnpress-woo-payment', plugins_url( '/', LP_ADDON_WOO_PAYMENT_FILE ) . 'assets/script.js' );
	}

	/**
	 * Get the product class name.
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param int
	 *
	 * @return string
	 */
	public function product_class( $classname, $product_type, $post_type, $product_id ) {
		if ( LP_COURSE_CPT == get_post_type( $product_id ) ) {
			$classname = 'WC_Product_LP_Course';
		}

		return $classname;
	}

	/**
	 * @param $course_id
	 * @param $quantity
	 * @param $item_data
	 *
	 * @return bool|string
	 */
	public function add_course_to_cart( $course_id, $quantity, $item_data ) {
		$cart          = WC()->cart;
		$cart_id       = $cart->generate_cart_id( $course_id, 0, array(), $item_data );
		$cart_item_key = $cart->find_product_in_cart( $cart_id );
		if ( $cart_item_key ) {
			$cart->remove_cart_item( $cart_item_key );
		}
		$cart_item_key = $cart->add_to_cart( absint( $course_id ), absint( $quantity ), 0, array(), $item_data );

		return $cart_item_key;
	}

	/**
	 * @param $id
	 */
	public function remove_course( $id ) {
		$cart = WC()->cart;
		if ( $cart_items = $cart->get_cart() ) {
			foreach ( $cart_items as $cart_item_key => $cart_item ) {
				if ( $id == $cart_item['product_id'] ) {
					$cart->remove_cart_item( $cart_item_key );
				}
			}
		}
	}

	/**
	 * Map meta keys from LearnPress order and WooCommerce order
	 *
	 * @return array
	 */
	public function get_meta_map() {
		// map LP order key with WC order key
		$map_keys = array(
			'_order_currency'       => '_order_currency',
			'_user_id'              => '_customer_user',
			'_order_subtotal'       => '_order_total',
			'_order_total'          => '_order_total',
			'_payment_method_id'    => '_payment_method',
			'_payment_method_title' => '_payment_method_title'
		);

		return apply_filters( 'learnpress_woo_meta_caps', $map_keys );
	}

	/**
	 * Update LearnPress order status when WooCommerce updated status
	 *
	 * @param type $order_id
	 * @param type $old_status
	 * @param type $new_status
	 */
	public function learnpress_update_order_status( $order_id, $old_status, $new_status ) {
		remove_action( 'woocommerce_order_status_changed', array( $this, 'learnpress_update_order_status' ), 10, 3 );
		$lp_order_id = $this->get_lp_order_id( $order_id);
		if ( $lp_order_id && get_post_type($lp_order_id) === LP_ORDER_CPT ) {
			$lp_order = learn_press_get_order( $lp_order_id );
			if( $lp_order ) {
				$lp_order->update_status( $new_status );
			}
		}
		add_action( 'woocommerce_order_status_changed', array( $this, 'learnpress_update_order_status' ), 10, 3 );
	}

	/**
	 * Disable select quantity product has post_type 'lp_course'
	 *
	 * @param int    $product_quantity
	 * @param string $cart_item_key
	 * @param array  $cart_item
	 *
	 * @return mixed
	 */
	public function disable_quantity_box( $product_quantity, $cart_item_key, $cart_item ) {
		return ( get_class( $cart_item['data'] ) === 'WC_Product_LP_Course' ) ? sprintf( '<span style="text-align: center; display: block">%s</span>', $cart_item['quantity'] ) : $product_quantity;
	}

	public function is_enabled() {
		return LP()->settings->get( 'woo-payment.enable' ) === 'yes';
	}

	/**
	 * If use woo checkout
	 * @return boolean
	 */
	public function woo_checkout_enabled() {
		return true;//$this->woo_actived() && LP()->settings->get( 'woo_payment_type' ) === 'checkout';
	}

	/**
	 * Payment is enabled
	 * @return boolean
	 */
	public function woo_payment_enabled() {
		return true;//LP()->settings->get( 'woo_payment_type' ) == 'payment' && $this->woo_actived();
	}

	/**
	 * WooCommercer is actived
	 * @return boolean
	 */
	public function woo_actived() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		return is_plugin_active( 'woocommerce/woocommerce.php' );
	}

	/**
	 * Add Admin notices
	 */
	public static function admin_notice() {
		switch ( self::$_error ) {
			case 1:
				echo '<div class="error">';
				echo '<p>' . sprintf( __( '<strong>WooCommerce Payment Gateways</strong> addon for <strong>LearnPress</strong> requires <a href="%s">WooCommerce</a> plugin is installed.', 'learnpress-woo-payment' ), 'http://wordpress.org/plugins/woocommerce' ) . '</p>';
				echo '</div>';
				break;
			case 2:
				?>
                <div class="error">
                    <p><?php printf( __( '<strong>WooCommerce</strong> addon version %s requires <strong>LearnPress</strong> version %s or higher', 'learnpress-woo-payment' ), LP_ADDON_WOO_PAYMENT_VER, LP_ADDON_WOO_PAYMENT_REQUIRE_VER ); ?></p>
                </div>
			<?php
				break;
			case 3:
				?>
                <div class="error">
                    <p><?php echo __( '<strong>WooCommerce</strong> add for LearnPress is not compatible with WooCommerce 3.0.0. Please temporary deactivate it. We are working for an update. We will try to finish it soon.', 'learnpress-woo-payment' ); ?></p>
                </div>
			<?php
		}
	}

	public function get_lp_order_id( $wc_order_id ){
		if(!isset($this->lp_order_ids[$wc_order_id])){
			$lp_order_id = learn_press_woo_payment_get_lp_order_id_from_woo( $wc_order_id );
			if($lp_order_id){
				$this->lp_order_ids[$wc_order_id] = $lp_order_id;
			} else {
				return false;
			}
		}
		return $this->lp_order_ids[$wc_order_id];
	}

}
