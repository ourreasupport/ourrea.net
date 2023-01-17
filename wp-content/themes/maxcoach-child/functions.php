<?php
defined( 'ABSPATH' ) || exit;

/**
 * Enqueue child scripts
 */
if ( ! function_exists( 'maxcoach_child_enqueue_scripts' ) ) {
	function maxcoach_child_enqueue_scripts() {
		wp_enqueue_style( 'maxcoach-child-style', get_stylesheet_directory_uri() . '/style.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'maxcoach_child_enqueue_scripts', 15 );


function rename_my_account( $title, $id = null ) {
    if ( $title=='My account' and is_user_logged_in()) {
        $current_user=wp_get_current_user();
        return $current_user->display_name;
    }
    return $title;
}
add_filter( 'the_title', 'rename_my_account', 10, 2 );

//Disable the new user notification sent to the site admin
function smartwp_disable_new_user_notifications() {
	//Remove original use created emails
	remove_action( 'register_new_user', 'wp_send_new_user_notifications' );
	remove_action( 'edit_user_created_user', 'wp_send_new_user_notifications', 10, 2 );
	
	//Add new function to take over email creation
	add_action( 'register_new_user', 'smartwp_send_new_user_notifications' );
	add_action( 'edit_user_created_user', 'smartwp_send_new_user_notifications', 10, 2 );
}
function smartwp_send_new_user_notifications( $user_id, $notify = 'user' ) {
	if ( empty($notify) || $notify == 'admin' ) {
	  return;
	}elseif( $notify == 'both' ){
    	//Only send the new user their email, not the admin
		$notify = 'user';
	}
	wp_send_new_user_notifications( $user_id, $notify );
}
add_action( 'init', 'smartwp_disable_new_user_notifications' );


//Disable all WordPress Notifications
function cvf_remove_wp_core_updates(){
    global $wp_version;
    return(object) array('last_checked' => time(),'version_checked' => $wp_version);
}

// Core Notifications
add_filter('pre_site_transient_update_core','cvf_remove_wp_core_updates');
// Plugin Notifications
add_filter('pre_site_transient_update_plugins','cvf_remove_wp_core_updates');
// Theme Notifications
add_filter('pre_site_transient_update_themes','cvf_remove_wp_core_updates');