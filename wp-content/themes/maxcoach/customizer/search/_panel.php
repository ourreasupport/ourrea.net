<?php
$panel    = 'search';
$priority = 1;

Maxcoach_Kirki::add_section( 'search_page', array(
	'title'    => esc_html__( 'Search Page', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority ++,
) );

Maxcoach_Kirki::add_section( 'search_popup', array(
	'title'    => esc_html__( 'Search Popup', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority ++,
) );
