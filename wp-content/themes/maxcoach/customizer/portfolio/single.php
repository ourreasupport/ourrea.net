<?php
$section  = 'single_portfolio';
$priority = 1;
$prefix   = 'single_portfolio_';

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
	'settings'    => 'portfolio_single_header_type',
	'label'       => esc_html__( 'Header Style', 'maxcoach' ),
	'description' => esc_html__( 'Select default header style that displays on all single portfolio pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '',
	'choices'     => Maxcoach_Header::instance()->get_list( true, esc_html__( 'Use Global Header Style', 'maxcoach' ) ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'portfolio_single_header_overlay',
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
	'settings' => 'portfolio_single_header_skin',
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
	'settings'    => 'portfolio_single_title_bar_layout',
	'label'       => esc_html__( 'Page Title Bar', 'maxcoach' ),
	'description' => esc_html__( 'Select default Title Bar that displays on all single portfolio pages.', 'maxcoach' ),
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
	'settings'    => 'portfolio_page_sidebar_1',
	'label'       => esc_html__( 'Sidebar 1', 'maxcoach' ),
	'description' => esc_html__( 'Select sidebar 1 that will display on single portfolio pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'portfolio_page_sidebar_2',
	'label'       => esc_html__( 'Sidebar 2', 'maxcoach' ),
	'description' => esc_html__( 'Select sidebar 2 that will display on single portfolio pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'portfolio_page_sidebar_position',
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
	'type'        => 'radio-buttonset',
	'settings'    => 'single_portfolio_sticky_detail_enable',
	'label'       => esc_html__( 'Sticky Detail Column', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to enable sticky of detail column.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'maxcoach' ),
		'1' => esc_html__( 'On', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'single_portfolio_site_skin',
	'label'       => esc_html__( 'Site Skin', 'maxcoach' ),
	'description' => esc_html__( 'Select skin of all single portfolio post pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'light',
	'choices'     => array(
		'dark'  => esc_html__( 'Dark', 'maxcoach' ),
		'light' => esc_html__( 'Light', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'single_portfolio_style',
	'label'       => esc_html__( 'Single Portfolio Style', 'maxcoach' ),
	'description' => esc_html__( 'Select style of all single portfolio post pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'image-list',
	'choices'     => array(
		'blank'           => esc_html__( 'Blank (Build with Elementor)', 'maxcoach' ),
		'image-list'      => esc_html__( 'Image List', 'maxcoach' ),
		'image-list-wide' => esc_html__( 'Image List - Wide', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'single_portfolio_video_enable',
	'label'       => esc_html__( 'Video', 'maxcoach' ),
	'description' => esc_html__( 'Controls the video visibility on portfolio post pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => array(
		'none'  => esc_html__( 'Hide', 'maxcoach' ),
		'above' => esc_html__( 'Show Above Feature Image', 'maxcoach' ),
		'below' => esc_html__( 'Show Below Feature Image', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_portfolio_feature_caption',
	'label'       => esc_html__( 'Image Caption', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to display comments on single portfolio posts.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Hide', 'maxcoach' ),
		'1' => esc_html__( 'Show', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_portfolio_comment_enable',
	'label'       => esc_html__( 'Comments', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to display comments on single portfolio posts.', 'maxcoach' ),
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
	'settings'    => 'single_portfolio_categories_enable',
	'label'       => esc_html__( 'Categories', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to display categories on single portfolio posts.', 'maxcoach' ),
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
	'settings'    => 'single_portfolio_tags_enable',
	'label'       => esc_html__( 'Tags', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to display tags on single portfolio posts.', 'maxcoach' ),
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
	'settings'    => 'single_portfolio_share_enable',
	'label'       => esc_html__( 'Share', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to display Share list on single portfolio posts.', 'maxcoach' ),
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
	'settings'    => 'single_portfolio_related_enable',
	'label'       => esc_html__( 'Related Portfolio', 'maxcoach' ),
	'description' => esc_html__( 'Turn on this option to display related portfolio section.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'maxcoach' ),
		'1' => esc_html__( 'On', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'            => 'text',
	'settings'        => 'portfolio_related_title',
	'label'           => esc_html__( 'Related Title Section', 'maxcoach' ),
	'section'         => $section,
	'priority'        => $priority++,
	'default'         => esc_html__( 'Related Projects', 'maxcoach' ),
	'active_callback' => array(
		array(
			'setting'  => 'single_portfolio_related_enable',
			'operator' => '==',
			'value'    => '1',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'            => 'multicheck',
	'settings'        => 'portfolio_related_by',
	'label'           => esc_attr__( 'Related By', 'maxcoach' ),
	'section'         => $section,
	'priority'        => $priority++,
	'default'         => array( 'portfolio_category' ),
	'choices'         => array(
		'portfolio_category' => esc_html__( 'Portfolio Category', 'maxcoach' ),
		'portfolio_tags'     => esc_html__( 'Portfolio Tags', 'maxcoach' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'single_portfolio_related_enable',
			'operator' => '==',
			'value'    => '1',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'            => 'number',
	'settings'        => 'portfolio_related_number',
	'label'           => esc_html__( 'Number related portfolio', 'maxcoach' ),
	'description'     => esc_html__( 'Controls the number of related portfolio', 'maxcoach' ),
	'section'         => $section,
	'priority'        => $priority++,
	'default'         => 5,
	'choices'         => array(
		'min'  => 3,
		'max'  => 30,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'single_portfolio_related_enable',
			'operator' => '==',
			'value'    => '1',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'single_portfolio_pagination',
	'label'       => esc_html__( 'Previous/Next Pagination', 'maxcoach' ),
	'description' => esc_html__( 'Select type of previous/next portfolio pagination on single portfolio posts.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '01',
	'choices'     => array(
		'none' => esc_html__( 'None', 'maxcoach' ),
		'01'   => esc_html__( 'Style 01', 'maxcoach' ),
		'02'   => esc_html__( 'Style 02', 'maxcoach' ),
		'03'   => esc_html__( 'Style 03', 'maxcoach' ),
	),
) );
