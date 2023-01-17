<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'MywpAbstractSettingModule' ) ) {
  return false;
}

if ( ! class_exists( 'MywpSettingScreenAdminToolbar' ) ) :

final class MywpSettingScreenAdminToolbar extends MywpAbstractSettingToolbarModule {

  static protected $id = 'admin_toolbar';

  static protected $priority = 40;

  static private $menu = 'admin';

  static protected $post_type = 'mywp_admin_toolbar';

  static protected $hidden_child_items = array( 'menu-toggle' );

  protected static function default_item_convert( $item ) {

    return MywpAdminToolbar::default_item_convert( $item );

  }

  protected static function get_default_toolbar() {

    return MywpAdminToolbar::get_default_toolbar();

  }

  public static function mywp_setting_screens( $setting_screens ) {

    $setting_screens[ self::$id ] = array(
      'title' => __( 'Toolbar' , 'my-wp' ),
      'menu' => self::$menu,
      'controller' => 'admin_toolbar',
      'use_advance' => true,
      'document_url' => self::get_document_url( 'document/admin-toolbar/' ),
    );

    return $setting_screens;

  }

}

MywpSettingScreenAdminToolbar::init();

endif;
