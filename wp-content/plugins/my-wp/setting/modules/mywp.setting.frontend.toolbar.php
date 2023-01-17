<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'MywpAbstractSettingModule' ) ) {
  return false;
}

if ( ! class_exists( 'MywpSettingScreenFrontendToolbar' ) ) :

final class MywpSettingScreenFrontendToolbar extends MywpAbstractSettingToolbarModule {

  static protected $id = 'frontend_toolbar';

  static protected $priority = 20;

  static private $menu = 'frontend';

  static protected $post_type = 'mywp_front_toolbar';

  static protected $hidden_child_items = array( 'search' );

  protected static function custom_after_init() {

    add_filter( 'mywp_setting_' . self::$id . '_get_item_icon_class' , array( __CLASS__ , 'frontend_get_item_icon_class' ) , 10 , 2 );

    add_action( 'mywp_setting_' . self::$id . '_custom_jquery_print_footer_scripts' , array( __CLASS__ , 'frontend_jquery_print_footer_scripts' ) );

    add_action( 'mywp_setting_screen_header_' . self::$id , array( __CLASS__ , 'frontend_refresh_button' ) );

  }

  public static function frontend_get_item_icon_class( $item_icon_class , $item ) {

    if( $item->id === 'edit' ) {

      $item_icon_class = 'dashicons-before dashicons-edit';

    }

    return $item_icon_class;

  }

  public static function frontend_jquery_print_footer_scripts() {

    ?>

    $('body.mywp-setting #setting-screen-setting-frontend-toolbar-item-refresh-button').on('click', function() {

      var $button = $(this);
      var $button_icon = $button.parent().find('.dashicons-update');
      var url = $button.attr('href');

      if( ! url ) {

        alert( mywp_admin_setting.not_found_update_url );

        return false;

      }

      $button_icon.addClass('spin');

      PostData = {
        mywp_regist_frontend_toolbar: 1
      };

      $.ajax({
        type: 'post',
        url: url,
        data: PostData,
        cache: false,
        timeout: 10000
      }).done( function( xhr ) {

        location.reload();

      }).fail( function( xhr ) {

        $button_icon.removeClass('spin');

        alert( mywp_admin_setting.error_try_again );

      });

      return false;

    });

    <?php

  }

  public static function frontend_refresh_button() {

    $available_toolbar_items = self::get_available_toolbar_items();

    $toolbar_items_link = home_url();

    ?>

    <?php if( empty( $available_toolbar_items ) ) : ?>

      <p class="mywp-error-message">

        <span class="dashicons dashicons-warning"></span>

        <?php printf( __( '%1$s: %2$s is not found. Please refresh the %2$s.' , 'my-wp' ) , __( 'Error' , 'my-wp' ) , __( 'Toolbar items' , 'my-wp' ) ); ?>

      </p>

    <?php endif; ?>

    <p>
      <a href="<?php echo esc_url( $toolbar_items_link ); ?>" class="button button-secondary button-small" id="setting-screen-setting-frontend-toolbar-item-refresh-button">
        <span class="dashicons dashicons-update"></span>
        <?php _e( 'Refresh Toolbar items' , 'my-wp' ); ?>
      </a>
    </p>

    <?php

  }

  protected static function default_item_convert( $item ) {

    return MywpFrontendToolbar::default_item_convert( $item );

  }

  protected static function get_default_toolbar() {

    return MywpFrontendToolbar::get_default_toolbar();

  }

  public static function mywp_setting_screens( $setting_screens ) {

    $setting_screens[ self::$id ] = array(
      'title' => __( 'Toolbar' , 'my-wp' ),
      'menu' => self::$menu,
      'controller' => 'frontend_toolbar',
      'use_advance' => true,
      'document_url' => self::get_document_url( 'document/frontend-toolbar/' ),
    );

    return $setting_screens;

  }

}

MywpSettingScreenFrontendToolbar::init();

endif;
