<?php
$panel    = 'event';
$priority = 1;

Maxcoach_Kirki::add_section( 'event_archive', array(
	'title'    => esc_html__( 'Event Archive', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Maxcoach_Kirki::add_section( 'event_single', array(
	'title'    => esc_html__( 'Event Single', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );
