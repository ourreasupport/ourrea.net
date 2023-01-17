<?php
$section  = 'shop_general';
$priority = 1;
$prefix   = 'shop_general_';

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'shop_badge_new',
	'label'       => esc_html__( 'New Badge (Days)', 'maxcoach' ),
	'description' => esc_html__( 'If the product was published within the newness time frame display the new badge.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
	'choices'     => array(
		'0'  => esc_html__( 'None', 'maxcoach' ),
		'1'  => esc_html__( '1 day', 'maxcoach' ),
		'2'  => esc_html__( '2 days', 'maxcoach' ),
		'3'  => esc_html__( '3 days', 'maxcoach' ),
		'4'  => esc_html__( '4 days', 'maxcoach' ),
		'5'  => esc_html__( '5 days', 'maxcoach' ),
		'6'  => esc_html__( '6 days', 'maxcoach' ),
		'7'  => esc_html__( '7 days', 'maxcoach' ),
		'8'  => esc_html__( '8 days', 'maxcoach' ),
		'9'  => esc_html__( '9 days', 'maxcoach' ),
		'10' => esc_html__( '10 days', 'maxcoach' ),
		'15' => esc_html__( '15 days', 'maxcoach' ),
		'20' => esc_html__( '20 days', 'maxcoach' ),
		'25' => esc_html__( '25 days', 'maxcoach' ),
		'30' => esc_html__( '30 days', 'maxcoach' ),
		'60' => esc_html__( '60 days', 'maxcoach' ),
		'90' => esc_html__( '90 days', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'shop_badge_hot',
	'label'    => esc_html__( 'Hot Badge', 'maxcoach' ),
	'tooltip'  => esc_html__( 'Show a "hot" label when product set featured.', 'maxcoach' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '1',
	'choices'  => array(
		'0' => esc_html__( 'Hide', 'maxcoach' ),
		'1' => esc_html__( 'Show', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'shop_badge_sale',
	'label'    => esc_html__( 'Sale Badge', 'maxcoach' ),
	'tooltip'  => esc_html__( 'Show a "sale" or "sale percent" label when product on sale.', 'maxcoach' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '1',
	'choices'  => array(
		'0' => esc_html__( 'Hide', 'maxcoach' ),
		'1' => esc_html__( 'Show', 'maxcoach' ),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Colors', 'maxcoach' ) . '</div>',
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => 'shop_badge_new_color',
	'label'     => esc_html__( 'New Badge Color', 'maxcoach' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'choices'   => array(
		'color'      => esc_attr__( 'Color', 'maxcoach' ),
		'background' => esc_attr__( 'Background', 'maxcoach' ),
	),
	'default'   => array(
		'color'      => '#fff',
		'background' => '#E5B35D',
	),
	'output'    => array(
		array(
			'choice'   => 'color',
			'element'  => '.woocommerce .product-badges .new',
			'property' => 'color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.woocommerce .product-badges .new',
			'property' => 'background-color',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => 'shop_badge_hot_color',
	'label'     => esc_html__( 'Hot Badge Color', 'maxcoach' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'choices'   => array(
		'color'      => esc_attr__( 'Color', 'maxcoach' ),
		'background' => esc_attr__( 'Background', 'maxcoach' ),
	),
	'default'   => array(
		'color'      => '#fff',
		'background' => '#D0021B',
	),
	'output'    => array(
		array(
			'choice'   => 'color',
			'element'  => '.woocommerce .product-badges .hot',
			'property' => 'color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.woocommerce .product-badges .hot',
			'property' => 'background-color',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => 'shop_badge_sale_color',
	'label'     => esc_html__( 'Sale Badge Color', 'maxcoach' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'choices'   => array(
		'color'      => esc_attr__( 'Color', 'maxcoach' ),
		'background' => esc_attr__( 'Background', 'maxcoach' ),
	),
	'default'   => array(
		'color'      => '#fff',
		'background' => '#20AD96',
	),
	'output'    => array(
		array(
			'choice'   => 'color',
			'element'  => '.woocommerce .product-badges .onsale',
			'property' => 'color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.woocommerce .product-badges .onsale',
			'property' => 'background-color',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => 'shop_price_color',
	'label'     => esc_html__( 'Price Color', 'maxcoach' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'choices'   => array(
		'regular' => esc_attr__( 'Regular Price', 'maxcoach' ),
		'old'     => esc_attr__( 'Old Price', 'maxcoach' ),
		'sale'    => esc_attr__( 'Sale Price', 'maxcoach' ),
	),
	'default'   => array(
		'regular' => '#8C89A2',
		'old'     => '#8C89A2',
		'sale'    => '#20AD96',
	),
	'output'    => array(
		array(
			'choice'   => 'regular',
			'element'  => '
			.price,
			.amount,
			.tr-price,
			.woosw-content-item--price
			',
			'property' => 'color',
		),
		array(
			'choice'   => 'old',
			'element'  => '
			.price del,
			del .amount,
			.tr-price del,
			.woosw-content-item--price del
			',
			'property' => 'color',
		),
		array(
			'choice'   => 'sale',
			'element'  => 'ins .amount',
			'property' => 'color',
		),
	),
) );
