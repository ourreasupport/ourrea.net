<?php
$section  = 'title_bar';
$priority = 1;
$prefix   = 'title_bar_';

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => $prefix . 'layout',
	'label'       => esc_html__( 'Global Title Bar', 'maxcoach' ),
	'description' => esc_html__( 'Select default title bar that displays on all pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '01',
	'choices'     => Maxcoach_Title_Bar::instance()->get_list(),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Heading', 'maxcoach' ) . '</div>',
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'search_title',
	'label'       => esc_html__( 'Search Heading', 'maxcoach' ),
	'description' => esc_html__( 'Enter text prefix that displays on search results page.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Search results for: ', 'maxcoach' ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'home_title',
	'label'       => esc_html__( 'Home Heading', 'maxcoach' ),
	'description' => esc_html__( 'Enter text that displays on front latest posts page.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Blog', 'maxcoach' ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'archive_category_title',
	'label'       => esc_html__( 'Archive Category Heading', 'maxcoach' ),
	'description' => esc_html__( 'Enter text prefix that displays on archive category page.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Category: ', 'maxcoach' ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'archive_tag_title',
	'label'       => esc_html__( 'Archive Tag Heading', 'maxcoach' ),
	'description' => esc_html__( 'Enter text prefix that displays on archive tag page.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Tag: ', 'maxcoach' ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'archive_author_title',
	'label'       => esc_html__( 'Archive Author Heading', 'maxcoach' ),
	'description' => esc_html__( 'Enter text prefix that displays on archive author page.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Author: ', 'maxcoach' ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'archive_year_title',
	'label'       => esc_html__( 'Archive Year Heading', 'maxcoach' ),
	'description' => esc_html__( 'Enter text prefix that displays on archive year page.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Year: ', 'maxcoach' ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'archive_month_title',
	'label'       => esc_html__( 'Archive Month Heading', 'maxcoach' ),
	'description' => esc_html__( 'Enter text prefix that displays on archive month page.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Month: ', 'maxcoach' ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'archive_day_title',
	'label'       => esc_html__( 'Archive Day Heading', 'maxcoach' ),
	'description' => esc_html__( 'Enter text prefix that displays on archive day page.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Day: ', 'maxcoach' ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'single_blog_title',
	'label'       => esc_html__( 'Single Blog Heading', 'maxcoach' ),
	'description' => esc_html__( 'Enter text that displays on single blog posts. Leave blank to use post title.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Blog', 'maxcoach' ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'archive_portfolio_title',
	'label'       => esc_html__( 'Archive Portfolio Heading', 'maxcoach' ),
	'description' => esc_html__( 'Enter text that displays on archive portfolio pages.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Portfolios', 'maxcoach' ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'single_portfolio_title',
	'label'       => esc_html__( 'Single Portfolio Heading', 'maxcoach' ),
	'description' => esc_html__( 'Enter text that displays on single portfolio pages. Leave blank to use portfolio title.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Portfolio', 'maxcoach' ),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'single_product_title',
	'label'       => esc_html__( 'Single Product Heading', 'maxcoach' ),
	'description' => esc_html__( 'Enter text that displays on single product pages. Leave blank to use product title.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Our Shop', 'maxcoach' ),
) );
