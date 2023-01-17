<?php
$section  = 'color_';
$priority = 1;
$prefix   = 'color_';

Maxcoach_Kirki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'primary_color',
	'label'     => esc_html__( 'Primary Color', 'maxcoach' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'default'   => Maxcoach::PRIMARY_COLOR,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'secondary_color',
	'label'     => esc_html__( 'Secondary Color', 'maxcoach' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'default'   => Maxcoach::SECONDARY_COLOR,
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'color',
	'settings'    => 'body_color',
	'label'       => esc_html__( 'Text Color', 'maxcoach' ),
	'description' => esc_html__( 'Controls the default color of all text.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => Maxcoach::TEXT_COLOR,
	'output'      => array(
		array(
			'element'  => 'body, .gmap-marker-wrap',
			'property' => 'color',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => 'link_color',
	'label'       => esc_html__( 'Link Color', 'maxcoach' ),
	'description' => esc_html__( 'Controls the default color of all links.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__( 'Normal', 'maxcoach' ),
		'hover'  => esc_attr__( 'Hover', 'maxcoach' ),
	),
	'default'     => array(
		'normal' => '#696969',
		'hover'  => Maxcoach::PRIMARY_COLOR,
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => 'a',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '
			a:hover,
			a:focus,
			.maxcoach-map-overlay-info a:hover,
			.widget_rss li a:hover,
			.widget_recent_entries li a:hover,
			.widget_recent_entries li a:after
			',
			'property' => 'color',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'color',
	'settings'    => 'heading_color',
	'label'       => esc_html__( 'Heading Color', 'maxcoach' ),
	'description' => esc_html__( 'Controls the color of heading.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => Maxcoach::HEADING_COLOR,
	'output'      => array(
		array(
			'element'  => '
			h1,h2,h3,h4,h5,h6,caption,th,blockquote,
			.heading,
			.heading-color,
			.widget_rss li a,
			.maxcoach-grid-wrapper.filter-style-01 .btn-filter.current,
			.maxcoach-grid-wrapper.filter-style-01 .btn-filter:hover,
			.elementor-accordion .elementor-tab-title,
			.tm-table.style-01 td,
			.tm-table caption,
			.page-links > span, .page-links > a:hover, .page-links > a:focus,
			.comment-nav-links li .current,
			.page-pagination li .current,
			.comment-nav-links li > a:hover,
			.page-pagination li > a:hover,
			.page-numbers li > a:hover,
			.page-numbers li .current,
			.woocommerce nav.woocommerce-pagination ul li span.current,
			.woocommerce nav.woocommerce-pagination ul li a:hover,
			.dpn-zvc-single-content-wrapper .dpn-zvc-sidebar-wrapper .dpn-zvc-sidebar-tile h3,
			 .learn-press-pagination ul.page-numbers li .current,
			 .learn-press-pagination ul.page-numbers li a:hover,
			 .learnpress .question-numbers li.current a span,
			 .learnpress .question-numbers li a:hover span,
            .single-product form.cart .label > label,
            .single-product form.cart .quantity-button-wrapper > label,
            .single-product form.cart .wccpf_label > label,
            .learn-press-form .form-fields .form-field label,
            #learn-press-course-tabs ul.learn-press-nav-tabs .course-nav.active a,
            #learn-press-course-tabs ul.learn-press-nav-tabs .course-nav a:hover,
            .entry-course-info .meta-label,
            .entry-event-info .meta-label,
            .answer-options .answer-option .option-title .option-title-content,
            .comment-list .comment-actions a
			',
			'property' => 'color',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Button Color', 'maxcoach' ) . '</div>',
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => 'button_color',
	'label'       => esc_html__( 'Button Color', 'maxcoach' ),
	'description' => esc_html__( 'Controls the color of buttons.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'color'      => esc_attr__( 'Color', 'maxcoach' ),
		'background' => esc_attr__( 'Background', 'maxcoach' ),
		'border'     => esc_attr__( 'Border', 'maxcoach' ),
	),
	'default'     => array(
		'color'      => '#fff',
		'background' => Maxcoach::PRIMARY_COLOR,
		'border'     => Maxcoach::PRIMARY_COLOR,
	),
	'output'      => array(
		array(
			'choice'   => 'color',
			'element'  => Maxcoach_Helper::get_button_css_selector(),
			'property' => 'color',
		),
		array(
			'choice'   => 'border',
			'element'  => Maxcoach_Helper::get_button_css_selector(),
			'property' => 'border-color',
		),
		array(
			'choice'   => 'background',
			'element'  => Maxcoach_Helper::get_button_css_selector(),
			'property' => 'background-color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.wp-block-button.is-style-outline',
			'property' => 'color',
		),
		array(
			'choice'   => 'color',
			'element'  => '.maxcoach-booking-form #flexi_searchbox #b_searchboxInc .b_submitButton_wrapper .b_submitButton',
			'suffix'   => '!important',
			'property' => 'color',
		),
		array(
			'choice'   => 'border',
			'element'  => '.maxcoach-booking-form #flexi_searchbox #b_searchboxInc .b_submitButton_wrapper .b_submitButton',
			'suffix'   => '!important',
			'property' => 'border-color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.maxcoach-booking-form #flexi_searchbox #b_searchboxInc .b_submitButton_wrapper .b_submitButton',
			'suffix'   => '!important',
			'property' => 'background-color',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => 'button_hover_color',
	'label'       => esc_html__( 'Button Hover Color', 'maxcoach' ),
	'description' => esc_html__( 'Controls the color of buttons when hover.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'color'      => esc_attr__( 'Color', 'maxcoach' ),
		'background' => esc_attr__( 'Background', 'maxcoach' ),
		'border'     => esc_attr__( 'Border', 'maxcoach' ),
	),
	'default'     => array(
		'color'      => '#fff',
		'background' => Maxcoach::SECONDARY_COLOR,
		'border'     => Maxcoach::SECONDARY_COLOR,
	),
	'output'      => array(
		array(
			'choice'   => 'color',
			'element'  => Maxcoach_Helper::get_button_hover_css_selector(),
			'property' => 'color',
		),
		array(
			'choice'   => 'border',
			'element'  => Maxcoach_Helper::get_button_hover_css_selector(),
			'property' => 'border-color',
		),
		array(
			'choice'   => 'background',
			'element'  => Maxcoach_Helper::get_button_hover_css_selector(),
			'property' => 'background-color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.wp-block-button.is-style-outline .wp-block-button__link:hover',
			'property' => 'color',
		),
		array(
			'choice'   => 'color',
			'element'  => '.maxcoach-booking-form #flexi_searchbox #b_searchboxInc .b_submitButton_wrapper .b_submitButton:hover',
			'suffix'   => '!important',
			'property' => 'color',
		),
		array(
			'choice'   => 'border',
			'element'  => '.maxcoach-booking-form #flexi_searchbox #b_searchboxInc .b_submitButton_wrapper .b_submitButton:hover',
			'suffix'   => '!important',
			'property' => 'border-color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.maxcoach-booking-form #flexi_searchbox #b_searchboxInc .b_submitButton_wrapper .b_submitButton:hover',
			'suffix'   => '!important',
			'property' => 'background-color',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Form Color', 'maxcoach' ) . '</div>',
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => 'form_input_color',
	'label'       => esc_html__( 'Color', 'maxcoach' ),
	'description' => esc_html__( 'Controls the color of form inputs.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'color'      => esc_attr__( 'Color', 'maxcoach' ),
		'background' => esc_attr__( 'Background', 'maxcoach' ),
		'border'     => esc_attr__( 'Border', 'maxcoach' ),
	),
	'default'     => array(
		'color'      => '#7e7e7e',
		'background' => '#f5f5f5',
		'border'     => '#f5f5f5',
	),
	'output'      => array(
		array(
			'choice'   => 'color',
			'element'  => Maxcoach_Helper::get_form_input_css_selector(),
			'property' => 'color',
		),
		array(
			'choice'   => 'border',
			'element'  => Maxcoach_Helper::get_form_input_css_selector(),
			'property' => 'border-color',
		),
		array(
			'choice'   => 'background',
			'element'  => Maxcoach_Helper::get_form_input_css_selector(),
			'property' => 'background-color',
		),
		/**
		 * Style for checkbox & radio.
		 */
		array(
			'choice'   => 'border',
			'element'  => "
				input[type='checkbox']:before,
				input[type='radio']:before
			",
			'property' => 'border-color',
		),
		array(
			'choice'   => 'background',
			'element'  => "
				input[type='checkbox']:before,
				input[type='radio']:before
			",
			'property' => 'background-color',
		),
	),
) );

Maxcoach_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => 'form_input_focus_color',
	'label'       => esc_html__( 'Focus Color', 'maxcoach' ),
	'description' => esc_html__( 'Controls the color of form inputs when focus.', 'maxcoach' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'color'      => esc_attr__( 'Color', 'maxcoach' ),
		'background' => esc_attr__( 'Background', 'maxcoach' ),
		'border'     => esc_attr__( 'Border', 'maxcoach' ),
	),
	'default'     => array(
		'color'      => '#777',
		'background' => '#fff',
		'border'     => Maxcoach::PRIMARY_COLOR,
	),
	'output'      => array(
		array(
			'choice'   => 'color',
			'element'  => Maxcoach_Helper::get_form_input_focus_css_selector(),
			'property' => 'color',
		),
		array(
			'choice'   => 'border',
			'element'  => Maxcoach_Helper::get_form_input_focus_css_selector(),
			'property' => 'border-color',
		),
		array(
			'choice'   => 'background',
			'element'  => Maxcoach_Helper::get_form_input_focus_css_selector(),
			'property' => 'background-color',
		),
		/**
		 * Style for checkbox & radio.
		 */
		array(
			'choice'   => 'border',
			'element'  => "
				input[type='checkbox']:checked:before,
				input[type='checkbox']:hover:before,
				input[type='radio']:checked:before,
				input[type='radio']:hover:before
			",
			'property' => 'border-color',
		),
		array(
			'choice'   => 'border',
			'element'  => "
				input[type='checkbox']:after,
				input[type='radio']:after
			",
			'property' => 'background-color',
		),
		array(
			'choice'   => 'background',
			'element'  => "
				input[type='checkbox']:checked:before,
				input[type='radio']:checked:before
			",
			'property' => 'background-color',
		),
	),
) );
