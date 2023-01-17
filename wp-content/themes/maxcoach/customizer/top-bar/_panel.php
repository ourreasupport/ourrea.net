<?php
$panel    = 'top_bar';
$priority = 1;

Maxcoach_Kirki::add_section( 'top_bar', array(
	'title'    => esc_html__( 'General', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Maxcoach_Kirki::add_section( 'top_bar_style_01', array(
	'title'    => esc_html__( 'Top Bar Style 01', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Maxcoach_Kirki::add_section( 'top_bar_style_02', array(
	'title'    => esc_html__( 'Top Bar Style 02', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );
