<?php
$panel    = 'title_bar';
$priority = 1;

Maxcoach_Kirki::add_section( 'title_bar', array(
	'title'    => esc_html__( 'General', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Maxcoach_Kirki::add_section( 'title_bar_01', array(
	'title'    => esc_html__( 'Style 01', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Maxcoach_Kirki::add_section( 'title_bar_02', array(
	'title'    => esc_html__( 'Style 02', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Maxcoach_Kirki::add_section( 'title_bar_03', array(
	'title'    => esc_html__( 'Style 03', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );
