<?php
$section  = 'top_bar';
$priority = 1;
$prefix   = 'top_bar_';

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'global_top_bar',
	'label'    => esc_html__( 'Default Top Bar', 'maxcoach' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'none',
	'choices'  => Maxcoach_Top_Bar::instance()->get_list(),
) );

