<?php
$section  = 'navigation';
$priority = 1;
$prefix   = 'navigation_';

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Main Menu Dropdown', 'maxcoach' ) . '</div>',
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'kirki_typography',
	'settings'    => $prefix . 'dropdown_link_typography',
	'label'       => esc_html__( 'Typography', 'maxcoach' ),
	'description' => esc_html__( 'Controls the typography for all dropdown menu items.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => array(
		'font-family'    => '',
		'variant'        => '400',
		'line-height'    => '1.38',
		'letter-spacing' => '0em',
		'text-transform' => 'none',
	),
	'output'      => array(
		array(
			'element' => '
			.page-navigation .children > li > a,
			.page-navigation .children > li > a .menu-item-title
			',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'slider',
	'settings'    => $prefix . 'dropdown_link_font_size',
	'label'       => esc_html__( 'Font Size', 'maxcoach' ),
	'description' => esc_html__( 'Controls the font size for dropdown menu items.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 16,
	'transport'   => 'auto',
	'choices'     => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'      => array(
		array(
			'element'  => '.page-navigation .children > li > a',
			'property' => 'font-size',
			'units'    => 'px',
		),
	),
) );

/*--------------------------------------------------------------
# Styling
--------------------------------------------------------------*/

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'dropdown_bg_color',
	'label'       => esc_html__( 'Background', 'maxcoach' ),
	'description' => esc_html__( 'Controls the background color for dropdown menu', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#fff',
	'output'      => array(
		array(
			'element'  => array(
				'.page-navigation .children',
				'.primary-menu-sub-visual',
			),
			'property' => 'background-color',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'dropdown_border_bottom_color',
	'label'       => esc_html__( 'Border Bottom', 'maxcoach' ),
	'description' => esc_html__( 'Controls the border bottom color for dropdown menu', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => Maxcoach::PRIMARY_COLOR,
	'output'      => array(
		array(
			'element'  => array(
				'.desktop-menu .page-navigation .children:after',
				'.primary-menu-sub-visual:after',
			),
			'property' => 'background-color',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'dropdown_box_shadow',
	'label'       => esc_html__( 'Box Shadow', 'maxcoach' ),
	'description' => esc_html__( 'Input valid box-shadow for dropdown menu. For e.g: "0 0 37px rgba(0, 0, 0, .07)"', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0 2px 29px rgba(0, 0, 0, 0.05)',
	'output'      => array(
		array(
			'element'  => array(
				'.page-navigation .children',
				'.primary-menu-sub-visual',
			),
			'property' => 'box-shadow',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => $prefix . 'dropdown_link_color',
	'label'       => esc_html__( 'Link Color', 'maxcoach' ),
	'description' => esc_html__( 'Controls the color for dropdown menu items.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__( 'Normal', 'maxcoach' ),
		'hover'  => esc_attr__( 'Hover', 'maxcoach' ),
	),
	'default'     => array(
		'normal' => '#777',
		'hover'  => '#111',
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => '.page-navigation .children > li > a',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '
				.page-navigation .children > li:hover > a,
				.page-navigation .children > li.current-menu-item > a,
				.page-navigation .children > li.current-menu-ancestor > a
			',
			'property' => 'color',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'dropdown_link_hover_bg_color',
	'label'       => esc_html__( 'Hover Background', 'maxcoach' ),
	'description' => esc_html__( 'Controls the background color when hover for dropdown menu items.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => 'rgba(255, 255, 255, 0)',
	'output'      => array(
		array(
			'element'  => array(
				'.page-navigation .children > li:hover > a',
				'.page-navigation .children > li.current-menu-item > a',
				'.page-navigation .children > li.current-menu-ancestor > a',
			),
			'property' => 'background-color',
		),
	),
) );
