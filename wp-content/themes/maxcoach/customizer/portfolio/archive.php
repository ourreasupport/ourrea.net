<?php
$section  = 'archive_portfolio';
$priority = 1;
$prefix   = 'archive_portfolio_';

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
	'settings'    => 'portfolio_archive_header_type',
	'label'       => esc_html__( 'Header Style', 'maxcoach' ),
	'description' => esc_html__( 'Select default header style that displays on archive portfolio page.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '',
	'choices'     => Maxcoach_Header::instance()->get_list( true, esc_html__( 'Use Global Header Style', 'maxcoach' ) ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'portfolio_archive_header_overlay',
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
	'settings' => 'portfolio_archive_header_skin',
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
	'settings'    => 'portfolio_archive_title_bar_layout',
	'label'       => esc_html__( 'Title Bar Style', 'maxcoach' ),
	'description' => esc_html__( 'Select default Title Bar that displays on all archive portfolio pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'choices'     => Maxcoach_Title_Bar::instance()->get_list( true, esc_html__( 'Use Global Title Bar', 'maxcoach' ) ),
	'default'     => 'none',
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
	'settings'    => 'portfolio_archive_page_sidebar_1',
	'label'       => esc_html__( 'Sidebar 1', 'maxcoach' ),
	'description' => esc_html__( 'Select sidebar 1 that will display on portfolio archive pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'portfolio_archive_page_sidebar_2',
	'label'       => esc_html__( 'Sidebar 2', 'maxcoach' ),
	'description' => esc_html__( 'Select sidebar 2 that will display on portfolio archive pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'portfolio_archive_page_sidebar_position',
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
	'type'        => 'number',
	'settings'    => 'archive_portfolio_posts_per_page',
	'label'       => esc_html__( 'Number posts', 'maxcoach' ),
	'description' => esc_html__( 'Controls the number of portfolios per page', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 12,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => $prefix . 'external_url',
	'label'       => esc_html__( 'External Url', 'maxcoach' ),
	'description' => esc_html__( 'Go to external url instead of go to single portfolio pages from archive portfolio pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
	'choices'     => array(
		'0' => esc_html__( 'No', 'maxcoach' ),
		'1' => esc_html__( 'Yes', 'maxcoach' ),
	),
) );
