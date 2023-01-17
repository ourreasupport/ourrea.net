<?php
$section  = 'navigation_minimal_01';
$priority = 1;
$prefix   = 'navigation_minimal_01_';

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'menu_title',
	'label'       => esc_html__( 'Menu Title', 'maxcoach' ),
	'description' => esc_html__( 'Input a text that displays next to open button.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => $prefix . 'background_type',
	'label'    => esc_html__( 'Background Type', 'maxcoach' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'solid',
	'choices'  => array(
		'solid'    => esc_html__( 'Solid', 'maxcoach' ),
		'gradient' => esc_html__( 'Gradient', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'            => 'background',
	'settings'        => $prefix . 'background',
	'label'           => esc_html__( 'Background', 'maxcoach' ),
	'description'     => esc_html__( 'Controls the background of canvas menu.', 'maxcoach' ),
	'section'         => $section,
	'priority'        => $priority++,
	'default'         => array(
		'background-color'      => '#fff',
		'background-image'      => '',
		'background-repeat'     => 'no-repeat',
		'background-size'       => 'cover',
		'background-attachment' => 'scroll',
		'background-position'   => 'center center',
	),
	'output'          => array(
		array(
			'element' => '.popup-canvas-menu',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'background_type',
			'operator' => '==',
			'value'    => 'solid',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'            => 'multicolor',
	'settings'        => $prefix . 'background_gradient_color',
	'label'           => esc_html__( 'Background Gradient', 'maxcoach' ),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'choices'         => array(
		'color_1' => esc_attr__( 'Color 1', 'maxcoach' ),
		'color_2' => esc_attr__( 'Color 2', 'maxcoach' ),
	),
	'default'         => array(
		'color_1' => '#000000',
		'color_2' => '#434343',
	),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'background_type',
			'operator' => '==',
			'value'    => 'gradient',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'close_button_color',
	'label'       => esc_html__( 'Close Button Color', 'maxcoach' ),
	'description' => esc_html__( 'Controls the color of close button.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#111',
	'output'      => array(
		array(
			'element'  => '.page-close-main-menu:before, .page-close-main-menu:after',
			'property' => 'background-color',
		),
	),
) );

/*--------------------------------------------------------------
# Level 1
--------------------------------------------------------------*/
Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Main Menu Level 1', 'maxcoach' ) . '</div>',
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'kirki_typography',
	'settings'    => $prefix . 'typography',
	'label'       => esc_html__( 'Typography', 'maxcoach' ),
	'description' => esc_html__( 'These settings control the typography for menu items.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => array(
		'font-family'    => '',
		'variant'        => '500',
		'line-height'    => '1.5',
		'letter-spacing' => '',
		'text-transform' => '',
	),
	'output'      => array(
		array(
			'element' => '.popup-canvas-menu .menu__container > li > a',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'item_color',
	'label'       => esc_html__( 'Color', 'maxcoach' ),
	'description' => esc_html__( 'Controls the color for main menu items.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#111',
	'output'      => array(
		array(
			'element'  => '.popup-canvas-menu .menu__container > li > a',
			'property' => 'color',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'item_hover_color',
	'label'       => esc_html__( 'Hover Color', 'maxcoach' ),
	'description' => esc_html__( 'Controls the color when hover for main menu items.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => Maxcoach::PRIMARY_COLOR,
	'output'      => array(
		array(
			'element'  => '
            .popup-canvas-menu .menu__container  > li > a:hover,
            .popup-canvas-menu .menu__container  > li > a:focus
            ',
			'property' => 'color',
		),
	),
) );

/*--------------------------------------------------------------
# Main Menu Dropdown Menu
--------------------------------------------------------------*/
Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Main Menu Dropdown', 'maxcoach' ) . '</div>',
) );

/*--------------------------------------------------------------
# Styling
--------------------------------------------------------------*/

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'color',
	'settings'    => $prefix . 'dropdown_link_color',
	'label'       => esc_html__( 'Color', 'maxcoach' ),
	'description' => esc_html__( 'Controls the color for dropdown menu items.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#777',
	'output'      => array(
		array(
			'element'  => '.popup-canvas-menu .menu__container .children a',
			'property' => 'color',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'color',
	'settings'    => $prefix . 'dropdown_link_hover_color',
	'label'       => esc_html__( 'Hover Color', 'maxcoach' ),
	'description' => esc_html__( 'Controls the color when hover for dropdown menu items.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => Maxcoach::PRIMARY_COLOR,
	'output'      => array(
		array(
			'element'  => '.popup-canvas-menu .menu__container .children a:hover',
			'property' => 'color',
		),
	),
) );
