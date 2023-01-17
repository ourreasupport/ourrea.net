<?php
$panel    = 'blog';
$priority = 1;

Maxcoach_Kirki::add_section( 'blog_archive', array(
	'title'    => esc_html__( 'Blog Archive', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Maxcoach_Kirki::add_section( 'blog_single', array(
	'title'    => esc_html__( 'Blog Single Post', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );
