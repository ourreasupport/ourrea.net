<?php
$section  = 'error404_page';
$priority = 1;
$prefix   = 'error404_page_';

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'background',
	'settings'    => 'error404_page_background_body',
	'label'       => esc_html__( 'Background', 'maxcoach' ),
	'description' => esc_html__( 'Controls outer background area in boxed mode.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => array(
		'background-color'      => '#111',
		'background-image'      => '',
		'background-repeat'     => 'no-repeat',
		'background-size'       => 'cover',
		'background-attachment' => 'fixed',
		'background-position'   => 'center center',
	),
	'output'      => array(
		array(
			'element' => '.error404',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'image',
	'settings' => 'error404_page_image',
	'label'    => esc_html__( 'Image', 'maxcoach' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => MAXCOACH_THEME_IMAGE_URI . '/page-404-image.png',
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => 'error404_page_title',
	'label'       => esc_html__( 'Title', 'maxcoach' ),
	'description' => esc_html__( 'Controls the title that display on error 404 page.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Looks like you are lost.', 'maxcoach' ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'textarea',
	'settings'    => 'error404_page_text',
	'label'       => esc_html__( 'Text', 'maxcoach' ),
	'description' => esc_html__( 'Controls the text that display below title', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'It looks like nothing was found at this location. You can either go back to the last page or go to homepage', 'maxcoach' ),
) );
