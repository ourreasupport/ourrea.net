<?php
$panel    = 'navigation';
$priority = 1;

Maxcoach_Kirki::add_section( 'navigation', array(
	'title'    => esc_html__( 'Desktop Menu', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority ++,
) );

Maxcoach_Kirki::add_section( 'navigation_minimal_01', array(
	'title'    => esc_html__( 'Off Canvas Menu', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority ++,
) );

Maxcoach_Kirki::add_section( 'navigation_mobile', array(
	'title'    => esc_html__( 'Mobile Menu', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority ++,
) );
