<?php
$panel    = 'course';
$priority = 1;

Maxcoach_Kirki::add_section( 'course_archive', array(
	'title'    => esc_html__( 'Course Archive', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Maxcoach_Kirki::add_section( 'course_single', array(
	'title'    => esc_html__( 'Course Single', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );
