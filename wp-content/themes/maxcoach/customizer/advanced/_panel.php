<?php
$panel    = 'advanced';
$priority = 1;

Maxcoach_Kirki::add_section( 'advanced', array(
	'title'    => esc_html__( 'Advanced', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority ++,
) );

Maxcoach_Kirki::add_section( 'light_gallery', array(
	'title'    => esc_html__( 'Light Gallery', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority ++,
) );
