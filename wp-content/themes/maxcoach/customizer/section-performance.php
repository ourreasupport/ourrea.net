<?php
$section  = 'performance';
$priority = 1;
$prefix   = 'performance_';

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'disable_emoji',
	'label'       => esc_html__( 'Disable Emojis', 'maxcoach' ),
	'description' => esc_html__( 'Remove Wordpress Emojis functionality.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 1,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'disable_embeds',
	'label'       => esc_html__( 'Disable Embeds', 'maxcoach' ),
	'description' => esc_html__( 'Remove Wordpress Embeds functionality.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 1,
) );
