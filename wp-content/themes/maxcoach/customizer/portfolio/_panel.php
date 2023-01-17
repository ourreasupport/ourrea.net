<?php
$panel    = 'portfolio';
$priority = 1;

Maxcoach_Kirki::add_section( 'archive_portfolio', array(
	'title'    => esc_html__( 'Archive', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Maxcoach_Kirki::add_section( 'single_portfolio', array(
	'title'    => esc_html__( 'Single', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );
