<?php
$panel    = 'shop';
$priority = 1;

Maxcoach_Kirki::add_section( 'shop_general', array(
	'title'    => esc_html__( 'General', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Maxcoach_Kirki::add_section( 'shop_archive', array(
	'title'    => esc_html__( 'Shop Archive', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Maxcoach_Kirki::add_section( 'shop_single', array(
	'title'    => esc_html__( 'Shop Single', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Maxcoach_Kirki::add_section( 'shopping_cart', array(
	'title'    => esc_html__( 'Shopping Cart', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );
