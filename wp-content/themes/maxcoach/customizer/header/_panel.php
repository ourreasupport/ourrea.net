<?php
$panel    = 'header';
$priority = 1;

Maxcoach_Kirki::add_section( 'header', array(
	'title'       => esc_html__( 'General', 'maxcoach' ),
	'description' => '<div class="desc">
			<strong class="insight-label insight-label-info">' . esc_html__( 'IMPORTANT NOTE: ', 'maxcoach' ) . '</strong>
			<p>' . esc_html__( 'These settings can be overridden by settings from Page Options Box in separator page.', 'maxcoach' ) . '</p>
			<p><img src="' . esc_url( MAXCOACH_THEME_IMAGE_URI . '/customize/header-settings.jpg' ) . '" alt="' . esc_attr__( 'header-settings', 'maxcoach' ) . '"/></p>
			<strong class="insight-label insight-label-info">' . esc_html__( 'Powerful header control: ', 'maxcoach' ) . '</strong>
			<p>' . esc_html__( 'These header settings for whole website. If you want use different header style for different post or page. then please go to specific section.', 'maxcoach' ) . '</p>
		</div>',
	'panel'       => $panel,
	'priority'    => $priority++,
) );

Maxcoach_Kirki::add_section( 'header_sticky', array(
	'title'    => esc_html__( 'Header Sticky', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Maxcoach_Kirki::add_section( 'header_more_options', array(
	'title'    => esc_html__( 'Header More Options', 'maxcoach' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

$header_types = Maxcoach_Header::instance()->get_type();

foreach ( $header_types as $key => $name ) {
	$section_id = 'header_style_' . $key;

	Maxcoach_Kirki::add_section( $section_id, array(
		'title'    => $name,
		'panel'    => $panel,
		'priority' => $priority++,
	) );
}
