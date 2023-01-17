<?php
$section  = 'header';
$priority = 1;
$prefix   = 'header_';

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'global_header',
	'label'       => esc_html__( 'Global Header Style', 'maxcoach' ),
	'description' => esc_html__( 'Select default header style for your site.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => MAXCOACH_IS_RTL ? '08' : '01',
	'choices'     => Maxcoach_Header::instance()->get_list(),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'global_header_overlay',
	'label'    => esc_html__( 'Global Header Overlay', 'maxcoach' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '0',
	'choices'  => array(
		'0' => esc_html__( 'No', 'maxcoach' ),
		'1' => esc_html__( 'Yes', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'global_header_skin',
	'label'    => esc_html__( 'Header Skin', 'maxcoach' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'dark',
	'choices'  => array(
		'dark'  => esc_html__( 'Dark', 'maxcoach' ),
		'light' => esc_html__( 'Light', 'maxcoach' ),
	),
) );
