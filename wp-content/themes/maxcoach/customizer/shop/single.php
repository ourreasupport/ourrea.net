<?php
$section  = 'shop_single';
$priority = 1;
$prefix   = 'single_product_';

$sidebar_positions   = Maxcoach_Helper::get_list_sidebar_positions();
$registered_sidebars = Maxcoach_Helper::get_registered_sidebars();

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Header', 'maxcoach' ) . '</div>',
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'product_single_header_type',
	'label'       => esc_html__( 'Header Style', 'maxcoach' ),
	'description' => esc_html__( 'Select default header style that displays on all single product pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '',
	'choices'     => Maxcoach_Header::instance()->get_list( true, esc_html__( 'Use Global Header Style', 'maxcoach' ) ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'product_single_header_overlay',
	'label'    => esc_html__( 'Header Overlay', 'maxcoach' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '',
	'choices'  => array(
		''  => esc_html__( 'Use Global', 'maxcoach' ),
		'0' => esc_html__( 'No', 'maxcoach' ),
		'1' => esc_html__( 'Yes', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'product_single_header_skin',
	'label'    => esc_html__( 'Header Skin', 'maxcoach' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '',
	'choices'  => array(
		''      => esc_html__( 'Use Global', 'maxcoach' ),
		'dark'  => esc_html__( 'Dark', 'maxcoach' ),
		'light' => esc_html__( 'Light', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Page Title Bar', 'maxcoach' ) . '</div>',
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'product_single_title_bar_layout',
	'label'       => esc_html__( 'Title Bar Style', 'maxcoach' ),
	'description' => esc_html__( 'Select default Title Bar that displays on all single product pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'choices'     => Maxcoach_Title_Bar::instance()->get_list( true, esc_html__( 'Use Global Title Bar', 'maxcoach' ) ),
	'default'     => '',
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Sidebar', 'maxcoach' ) . '</div>',
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'product_page_sidebar_1',
	'label'       => esc_html__( 'Sidebar 1', 'maxcoach' ),
	'description' => esc_html__( 'Select sidebar 1 that will display on single product pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'product_page_sidebar_2',
	'label'       => esc_html__( 'Sidebar 2', 'maxcoach' ),
	'description' => esc_html__( 'Select sidebar 2 that will display on single product pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'product_page_sidebar_position',
	'label'    => esc_html__( 'Sidebar Position', 'maxcoach' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'right',
	'choices'  => $sidebar_positions,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Others', 'maxcoach' ) . '</div>',
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'single_product_layout_style',
	'label'    => esc_html__( 'Layout Style', 'maxcoach' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'slider',
	'choices'  => array(
		'list'   => esc_html__( 'List', 'maxcoach' ),
		'slider' => esc_html__( 'Slider', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_product_sticky_enable',
	'label'       => esc_html__( 'Sticky Feature/Details Columns', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to enable sticky of product feature & details columns.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'maxcoach' ),
		'1' => esc_html__( 'On', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_product_categories_enable',
	'label'       => esc_html__( 'Categories', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to display the categories.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'maxcoach' ),
		'1' => esc_html__( 'On', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_product_tags_enable',
	'label'       => esc_html__( 'Tags', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to display the tags.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'maxcoach' ),
		'1' => esc_html__( 'On', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_product_sharing_enable',
	'label'       => esc_html__( 'Sharing', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to display the sharing.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'maxcoach' ),
		'1' => esc_html__( 'On', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_product_tabs_enable',
	'label'       => esc_html__( 'Product data tabs', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to display tabs.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'maxcoach' ),
		'1' => esc_html__( 'On', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_product_up_sells_enable',
	'label'       => esc_html__( 'Up-sells products', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to display the up-sells products section.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'maxcoach' ),
		'1' => esc_html__( 'On', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_product_related_enable',
	'label'       => esc_html__( 'Related products', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to display the related products section.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'maxcoach' ),
		'1' => esc_html__( 'On', 'maxcoach' ),
	),
) );
