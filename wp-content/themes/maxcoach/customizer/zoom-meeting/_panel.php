<?php
$panel    = 'zoom_meeting';
$priority = 1;

Maxcoach_Kirki::add_section( 'zoom_meeting_archive', array(
	'title'    => esc_html__( 'Archive', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Maxcoach_Kirki::add_section( 'zoom_meeting_single', array(
	'title'    => esc_html__( 'Single', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );
