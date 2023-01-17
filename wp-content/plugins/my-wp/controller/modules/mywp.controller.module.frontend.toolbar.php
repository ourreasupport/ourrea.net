<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'MywpControllerAbstractModule' ) ) {
  return false;
}

if ( ! class_exists( 'MywpControllerModuleFrontendToolbar' ) ) :

final class MywpControllerModuleFrontendToolbar extends MywpAbstractControllerToolbarModule {

  static protected $id = 'frontend_toolbar';

  static protected $post_type = 'mywp_front_toolbar';

  protected static function default_item_convert( $item ) {

    return MywpFrontendToolbar::default_item_convert( $item );

  }

  public static function mywp_wp_loaded() {

    if( is_admin() ) {

      return false;

    }

    if( ! self::is_do_controller() ) {

      return false;

    }

    add_action( 'wp_before_admin_bar_render' , array( __CLASS__ , 'remove_detault_menus' ) , 1000 );
    add_action( 'wp_before_admin_bar_render' , array( __CLASS__ , 'customize_admin_bar' ) , 1000 );
    add_action( 'wp_after_admin_bar_render' , array( __CLASS__ , 'wp_after_admin_bar_render' ) );

  }

  public static function wp_after_admin_bar_render() {

    global $wp_scripts;

    $toolbar = self::get_toolbar();

    if( empty( $toolbar ) ) {

      return false;

    }

    $wp_styles = wp_styles();

    printf( '<link rel="stylesheet" id="mywp_frontend_toolbar-css"  href="%sfrontend-toolbar.css?ver=%s" type="text/css" media="all" />' , esc_url( MywpApi::get_plugin_url( 'css' ) ) , $wp_styles->default_version );

    printf( '<script type="text/javascript" src="%sfrontend-toolbar.js?ver=%s"></script>' , esc_url( MywpApi::get_plugin_url( 'js' ) ) , $wp_styles->default_version );

    $setting_data = self::get_setting_data();

    if( ! empty( $setting_data['custom_menu_ui'] ) ) {

      printf( '<link rel="stylesheet" id="mywp_frontend_toolbar-custom-ui-css"  href="%sfrontend-toolbar-custom-ui.css?ver=%s" type="text/css" media="all" />' , esc_url( MywpApi::get_plugin_url( 'css' ) ) , MYWP_VERSION );

      printf( '<script type="text/javascript" src="%sfrontend-toolbar-custom-ui.js?ver=%s"></script>' , esc_url( MywpApi::get_plugin_url( 'js' ) ) , MYWP_VERSION );

    }

  }

}

MywpControllerModuleFrontendToolbar::init();

endif;
