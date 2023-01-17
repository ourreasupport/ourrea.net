<?php
$section  = 'advanced';
$priority = 1;
$prefix   = 'advanced_';

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'smooth_scroll_enable',
	'label'       => esc_html__( 'Smooth Scroll', 'maxcoach' ),
	'description' => esc_html__( 'Smooth scrolling experience for websites.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 1,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'scroll_top_enable',
	'label'       => esc_html__( 'Go To Top Button', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to show go to top button.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 1,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'content_protected_enable',
	'label'       => esc_html__( 'Content Protected', 'maxcoach' ),
	'description' => esc_html__( 'Turn on to enable content protected feature.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 0,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => 'google_api_key',
	'label'       => esc_html__( 'Google Api Key', 'maxcoach' ),
	'description' => sprintf( wp_kses( __( 'Follow <a href="%s" target="_blank">this link</a> and click <strong>GET A KEY</strong> button.', 'maxcoach' ), array(
		'a'      => array(
			'href'   => array(),
			'target' => array(),
		),
		'strong' => array(),
	) ), esc_url( 'https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key' ) ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'AIzaSyDIx6UxZ-cL4yOtvlfTIyVXPV6gI7OAVZc',
	'transport'   => 'postMessage',
) );
