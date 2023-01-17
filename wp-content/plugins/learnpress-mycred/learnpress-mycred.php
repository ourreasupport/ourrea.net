<?php
/*
Plugin Name: LearnPress - myCRED Integration
Plugin URI: http://thimpress.com/learnpress
Description: Running with the point management system - myCRED.
Author: ThimPress
Version: 3.0.2
Author URI: http://thimpress.com
Tags: learnpress, lms, add-on, myCRED
Text Domain: learnpress-mycred
Domain Path: /languages/
*/

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

define( 'LP_ADDON_MYCRED_FILE', __FILE__ );
define( 'LP_ADDON_MYCRED_VER', '3.0.2' );
define( 'LP_ADDON_MYCRED_REQUIRE_VER', '3.0.0' );

/**
 * Class LP_Addon_MyCred_Preload
 */
class LP_Addon_MyCred_Preload {

	/**
	 * LP_Addon_MyCred_Preload constructor.
	 */
	public function __construct() {
		add_action( 'learn-press/ready', array( $this, 'load' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	 * Load addon
	 */
	public function load() {
		LP_Addon::load( 'LP_Addon_myCRED', 'inc/load.php', __FILE__ );
		remove_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	 * Admin notice
	 */
	public function admin_notices() {
		?>
        <div class="error">
            <p><?php echo wp_kses(
					sprintf(
						__( '<strong>%s</strong> addon version %s requires %s version %s or higher is <strong>installed</strong> and <strong>activated</strong>.', 'learnpress-mycred' ),
						__( 'LearnPress MyCred', 'learnpress-mycred' ),
						LP_ADDON_MYCRED_VER,
						sprintf( '<a href="%s" target="_blank"><strong>%s</strong></a>', admin_url( 'plugin-install.php?tab=search&type=term&s=learnpress' ), __( 'LearnPress', 'learnpress-mycred' ) ),
						LP_ADDON_MYCRED_REQUIRE_VER
					),
					array(
						'a'      => array(
							'href'  => array(),
							'blank' => array()
						),
						'strong' => array()
					)
				); ?>
            </p>
        </div>
		<?php
	}
}

new LP_Addon_MyCred_Preload();