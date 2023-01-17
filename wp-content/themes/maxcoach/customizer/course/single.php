<?php
$section  = 'course_single';
$priority = 1;
$prefix   = 'single_course_';

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
	'settings'    => 'course_single_header_type',
	'label'       => esc_html__( 'Header Style', 'maxcoach' ),
	'description' => esc_html__( 'Select default header style that displays on all single course pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '',
	'choices'     => Maxcoach_Header::instance()->get_list( true, esc_html__( 'Use Global Header Style', 'maxcoach' ) ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'course_single_header_overlay',
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
	'settings' => 'course_single_header_skin',
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
	'settings'    => 'course_single_title_bar_layout',
	'label'       => esc_html__( 'Title Bar Style', 'maxcoach' ),
	'description' => esc_html__( 'Select default Title Bar that displays on all single course pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'choices'     => Maxcoach_Title_Bar::instance()->get_list( true, esc_html__( 'Use Global Title Bar', 'maxcoach' ) ),
	'default'     => '01',
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
	'settings'    => 'course_page_sidebar_1',
	'label'       => esc_html__( 'Sidebar 1', 'maxcoach' ),
	'description' => esc_html__( 'Select sidebar 1 that will display on single course pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'course_sidebar',
	'choices'     => $registered_sidebars,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'course_page_sidebar_2',
	'label'       => esc_html__( 'Sidebar 2', 'maxcoach' ),
	'description' => esc_html__( 'Select sidebar 2 that will display on single course pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'course_page_sidebar_position',
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
	'type'        => 'select',
	'settings'    => 'single_course_layout',
	'label'       => esc_html__( 'Layout', 'maxcoach' ),
	'description' => esc_html__( 'Select default layout for single course pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '01',
	'choices'     => array(
		'01' => esc_attr__( 'Sticky Features Bar', 'maxcoach' ),
		'02' => esc_attr__( 'Standard', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_course_featured_image_enable',
	'label'       => esc_html__( 'Featured Image', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to display featured image on single course pages.', 'maxcoach' ),
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
	'settings'    => 'single_course_related_enable',
	'label'       => esc_html__( 'Related Course', 'maxcoach' ),
	'description' => esc_html__( 'Turn on this option to display related course section.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'maxcoach' ),
		'1' => esc_html__( 'On', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'            => 'multicheck',
	'settings'        => 'course_related_by',
	'label'           => esc_html__( 'Related By', 'maxcoach' ),
	'section'         => $section,
	'priority'        => $priority++,
	'default'         => array( 'category', 'tags' ),
	'choices'         => array(
		'category' => esc_html__( 'Category', 'maxcoach' ),
		'tags'     => esc_html__( 'Tags', 'maxcoach' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'single_course_related_enable',
			'operator' => '==',
			'value'    => '1',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'            => 'number',
	'settings'        => 'course_related_number',
	'label'           => esc_html__( 'Number related course', 'maxcoach' ),
	'description'     => esc_html__( 'Controls the number of related course', 'maxcoach' ),
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
			'setting'  => 'single_course_related_enable',
			'operator' => '==',
			'value'    => '1',
		),
	),
) );

/*Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_course_comment_enable',
	'label'       => esc_html__( 'Comments', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to display comments on single course pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'maxcoach' ),
		'1' => esc_html__( 'On', 'maxcoach' ),
	),
) );*/
