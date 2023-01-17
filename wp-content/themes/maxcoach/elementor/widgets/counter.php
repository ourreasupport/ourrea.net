<?php

namespace Maxcoach_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Utils;

defined( 'ABSPATH' ) || exit;

class Widget_Counter extends Base {

	public function get_name() {
		return 'tm-counter';
	}

	public function get_title() {
		return esc_html__( 'Modern Counter', 'maxcoach' );
	}

	public function get_icon_part() {
		return 'eicon-counter';
	}

	public function get_keywords() {
		return [ 'counter' ];
	}

	public function get_script_depends() {
		return [ 'maxcoach-widget-counter' ];
	}

	protected function _register_controls() {
		$this->add_content_section();

		$this->add_box_style_section();

		$this->add_number_style_section();

		$this->add_title_style_section();

		$this->add_description_style_section();

		$this->add_graphic_style_section();

		$this->add_icon_style_section();
	}

	private function add_content_section() {
		$this->start_controls_section( 'counter_section', [
			'label' => esc_html__( 'Counter', 'maxcoach' ),
		] );

		$this->add_control( 'style', [
			'label'        => esc_html__( 'Style', 'maxcoach' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				''   => esc_html__( 'None', 'maxcoach' ),
				'01' => '01',
			],
			'default'      => '',
			'prefix_class' => 'maxcoach-counter-style-',
		] );

		$this->add_control( 'number_heading', [
			'label'     => esc_html__( 'Number', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'starting_number', [
			'label'   => esc_html__( 'Starting Number', 'maxcoach' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 0,
			'dynamic' => [
				'active' => true,
			],
		] );

		$this->add_control( 'ending_number', [
			'label'   => esc_html__( 'Ending Number', 'maxcoach' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 100,
			'dynamic' => [
				'active' => true,
			],
		] );

		$this->add_control( 'prefix', [
			'label'       => esc_html__( 'Number Prefix', 'maxcoach' ),
			'type'        => Controls_Manager::TEXT,
			'dynamic'     => [
				'active' => true,
			],
			'default'     => '',
			'placeholder' => 1,
		] );

		$this->add_control( 'suffix', [
			'label'       => esc_html__( 'Number Suffix', 'maxcoach' ),
			'type'        => Controls_Manager::TEXT,
			'dynamic'     => [
				'active' => true,
			],
			'default'     => '',
			'placeholder' => esc_html__( 'Plus', 'maxcoach' ),
		] );

		$this->add_control( 'duration', [
			'label'   => esc_html__( 'Animation Duration', 'maxcoach' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 2000,
			'min'     => 100,
			'step'    => 100,
		] );

		$this->add_control( 'thousand_separator', [
			'label'     => esc_html__( 'Thousand Separator', 'maxcoach' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'yes',
			'label_on'  => esc_html__( 'Show', 'maxcoach' ),
			'label_off' => esc_html__( 'Hide', 'maxcoach' ),
		] );

		$this->add_control( 'thousand_separator_char', [
			'label'     => esc_html__( 'Separator', 'maxcoach' ),
			'type'      => Controls_Manager::SELECT,
			'condition' => [
				'thousand_separator' => 'yes',
			],
			'options'   => [
				''  => 'Default',
				'.' => 'Dot',
				' ' => 'Space',
			],
		] );

		$this->add_control( 'content_heading', [
			'label'     => esc_html__( 'Content', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'graphic_element', [
			'label'       => esc_html__( 'Graphic Element', 'maxcoach' ),
			'type'        => Controls_Manager::CHOOSE,
			'label_block' => false,
			'options'     => [
				'none'  => [
					'title' => esc_html__( 'None', 'maxcoach' ),
					'icon'  => 'eicon-ban',
				],
				'image' => [
					'title' => esc_html__( 'Image', 'maxcoach' ),
					'icon'  => 'fa fa-picture-o',
				],
				'icon'  => [
					'title' => esc_html__( 'Icon', 'maxcoach' ),
					'icon'  => 'eicon-star',
				],
			],
			'default'     => 'none',
		] );

		$this->add_control( 'image', [
			'label'     => esc_html__( 'Choose Image', 'maxcoach' ),
			'type'      => Controls_Manager::MEDIA,
			'default'   => [
				'url' => Utils::get_placeholder_image_src(),
			],
			'dynamic'   => [
				'active' => true,
			],
			'condition' => [
				'graphic_element' => 'image',
			],
		] );

		$this->add_group_control( Group_Control_Image_Size::get_type(), [
			'name'      => 'image', // Actually its `image_size`
			'default'   => 'thumbnail',
			'condition' => [
				'graphic_element' => 'image',
			],
		] );

		$this->add_control( 'icon', [
			'label'     => esc_html__( 'Icon', 'maxcoach' ),
			'type'      => Controls_Manager::ICONS,
			'default'   => [
				'value'   => 'fas fa-star',
				'library' => 'fa-solid',
			],
			'condition' => [
				'graphic_element' => 'icon',
			],
		] );

		$this->add_control( 'icon_view', [
			'label'        => esc_html__( 'View', 'maxcoach' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				'default' => esc_html__( 'Default', 'maxcoach' ),
				'stacked' => esc_html__( 'Stacked', 'maxcoach' ),
				'bubble'  => esc_html__( 'Bubble', 'maxcoach' ),
			],
			'default'      => 'default',
			'prefix_class' => 'maxcoach-view-',
			'condition'    => [
				'graphic_element' => 'icon',
				'icon[value]!'    => '',
			],
		] );

		$this->add_control( 'icon_shape', [
			'label'        => esc_html__( 'Shape', 'maxcoach' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				'circle' => esc_html__( 'Circle', 'maxcoach' ),
				'square' => esc_html__( 'Square', 'maxcoach' ),
			],
			'default'      => 'circle',
			'condition'    => [
				'graphic_element' => 'icon',
				'icon[value]!'    => '',
				'icon_view'       => [ 'stacked' ],
			],
			'prefix_class' => 'maxcoach-shape-',
		] );

		$this->add_control( 'graphic_position', [
			'label'        => esc_html__( 'Position', 'maxcoach' ),
			'type'         => Controls_Manager::CHOOSE,
			'default'      => 'top',
			'options'      => [
				'left'  => [
					'title' => esc_html__( 'Left', 'maxcoach' ),
					'icon'  => 'eicon-h-align-left',
				],
				'top'   => [
					'title' => esc_html__( 'Top', 'maxcoach' ),
					'icon'  => 'eicon-v-align-top',
				],
				'right' => [
					'title' => esc_html__( 'Right', 'maxcoach' ),
					'icon'  => 'eicon-h-align-right',
				],
			],
			'prefix_class' => 'maxcoach-graphic-position-',
			'toggle'       => false,
			'condition'    => [
				'graphic_element!' => 'none',
			],
		] );

		$this->add_control( 'graphic_vertical_alignment', [
			'label'        => esc_html__( 'Vertical Alignment', 'maxcoach' ),
			'type'         => Controls_Manager::CHOOSE,
			'options'      => Widget_Utils::get_control_options_vertical_alignment(),
			'default'      => 'top',
			'prefix_class' => 'maxcoach-graphic-ver-align-',
			'condition'    => [
				'graphic_element!'  => 'none',
				'graphic_position!' => 'top',
			],
		] );

		$this->add_control( 'title_text', [
			'label'       => esc_html__( 'Title', 'maxcoach' ),
			'type'        => Controls_Manager::TEXTAREA,
			'dynamic'     => [
				'active' => true,
			],
			'placeholder' => esc_html__( 'Cool Number', 'maxcoach' ),
			'separator'   => 'before',
		] );

		$this->add_control( 'description_text', [
			'label'     => esc_html__( 'Description', 'maxcoach' ),
			'type'      => Controls_Manager::TEXTAREA,
			'dynamic'   => [
				'active' => true,
			],
			'separator' => 'before',
		] );

		$this->end_controls_section();
	}

	private function add_box_style_section() {
		$this->start_controls_section( 'box_style_section', [
			'label' => esc_html__( 'Box', 'maxcoach' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'text_align', [
			'label'                => esc_html__( 'Alignment', 'maxcoach' ),
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_text_align_full(),
			'selectors_dictionary' => [
				'left'  => 'start',
				'right' => 'end',
			],
			'selectors'            => [
				'{{WRAPPER}} .maxcoach-box' => 'text-align: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'box_padding', [
			'label'      => esc_html__( 'Padding', 'maxcoach' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .maxcoach-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'box_max_width', [
			'label'      => esc_html__( 'Max Width', 'maxcoach' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'%'  => [
					'min' => 1,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 1600,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .maxcoach-box' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'box_horizontal_alignment', [
			'label'                => esc_html__( 'Horizontal Alignment', 'maxcoach' ),
			'label_block'          => true,
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_horizontal_alignment(),
			'default'              => 'center',
			'toggle'               => false,
			'selectors_dictionary' => [
				'left'  => 'flex-start',
				'right' => 'flex-end',
			],
			'selectors'            => [
				'{{WRAPPER}} .elementor-widget-container' => 'display: flex; justify-content: {{VALUE}}',
			],
		] );

		$this->start_controls_tabs( 'box_colors' );

		$this->start_controls_tab( 'box_colors_normal', [
			'label' => esc_html__( 'Normal', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'box',
			'selector' => '{{WRAPPER}} .maxcoach-box',
		] );

		$this->add_group_control( Group_Control_Advanced_Border::get_type(), [
			'name'     => 'box_border',
			'selector' => '{{WRAPPER}} .maxcoach-box',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box',
			'selector' => '{{WRAPPER}} .maxcoach-box',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'box_colors_hover', [
			'label' => esc_html__( 'Hover', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'box_hover',
			'selector' => '{{WRAPPER}} .maxcoach-box:before',
		] );

		$this->add_group_control( Group_Control_Advanced_Border::get_type(), [
			'name'     => 'box_hover_border',
			'selector' => '{{WRAPPER}} .maxcoach-box:hover',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_hover',
			'selector' => '{{WRAPPER}} .maxcoach-box:hover',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_icon_style_section() {
		$this->start_controls_section( 'icon_style_section', [
			'label'     => esc_html__( 'Icon', 'maxcoach' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'graphic_element' => 'icon',
				'icon[value]!'    => '',
			],
		] );

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab( 'icon_colors_normal', [
			'label' => esc_html__( 'Normal', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'icon',
			'selector' => '{{WRAPPER}} .icon',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'icon_colors_hover', [
			'label' => esc_html__( 'Hover', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'hover_icon',
			'selector' => '{{WRAPPER}} .maxcoach-box:hover .icon',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control( 'icon_size', [
			'label'     => esc_html__( 'Size', 'maxcoach' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 6,
					'max' => 300,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .maxcoach-icon-view, {{WRAPPER}} .maxcoach-icon' => 'font-size: {{SIZE}}{{UNIT}};',
			],
			'separator' => 'before',
		] );

		$this->add_control( 'icon_rotate', [
			'label'     => esc_html__( 'Rotate', 'maxcoach' ),
			'type'      => Controls_Manager::SLIDER,
			'default'   => [
				'unit' => 'deg',
			],
			'selectors' => [
				'{{WRAPPER}} .maxcoach-icon > svg, {{WRAPPER}} .maxcoach-icon > i' => 'transform: rotate({{SIZE}}{{UNIT}});',
			],
		] );

		// Icon View Settings.
		$this->add_control( 'icon_view_heading', [
			'label'     => esc_html__( 'Icon View', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'icon_view' => [ 'stacked', 'bubble' ],
			],
		] );

		$this->add_control( 'icon_padding', [
			'label'     => esc_html__( 'Padding', 'maxcoach' ),
			'type'      => Controls_Manager::SLIDER,
			'selectors' => [
				'{{WRAPPER}} .maxcoach-icon-view' => 'padding: {{SIZE}}{{UNIT}};',
			],
			'range'     => [
				'em' => [
					'min' => 0,
					'max' => 5,
				],
			],
			'condition' => [
				'icon_view' => [ 'stacked' ],
			],
		] );

		$this->add_control( 'icon_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'maxcoach' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .maxcoach-icon-view' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'icon_view' => [ 'stacked' ],
			],
		] );

		$this->start_controls_tabs( 'icon_view_colors', [
			'condition' => [
				'icon_view' => [ 'stacked', 'bubble' ],
			],
		] );

		$this->start_controls_tab( 'icon_view_colors_normal', [
			'label' => esc_html__( 'Normal', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'icon_view',
			'selector' => '{{WRAPPER}} .maxcoach-icon-view',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'icon_view',
			'selector' => '{{WRAPPER}} .maxcoach-icon-view',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'icon_view_colors_hover', [
			'label' => esc_html__( 'Hover', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'hover_icon_view',
			'selector' => '{{WRAPPER}} .maxcoach-box:hover .maxcoach-icon-view',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'hover_icon_view',
			'selector' => '{{WRAPPER}} .maxcoach-box:hover .maxcoach-icon-view',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_number_style_section() {
		$this->start_controls_section( 'number_style_section', [
			'label' => esc_html__( 'Number', 'maxcoach' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'number_position', [
			'label'        => esc_html__( 'Position', 'maxcoach' ),
			'type'         => Controls_Manager::CHOOSE,
			'default'      => 'top',
			'options'      => [
				'left'  => [
					'title' => esc_html__( 'Left', 'maxcoach' ),
					'icon'  => 'eicon-h-align-left',
				],
				'top'   => [
					'title' => esc_html__( 'Top', 'maxcoach' ),
					'icon'  => 'eicon-v-align-top',
				],
				'right' => [
					'title' => esc_html__( 'Right', 'maxcoach' ),
					'icon'  => 'eicon-h-align-right',
				],
			],
			'prefix_class' => 'maxcoach-counter-number-position-',
			'toggle'       => false,
		] );

		$this->add_control( 'number_vertical_alignment', [
			'label'        => esc_html__( 'Vertical Alignment', 'maxcoach' ),
			'type'         => Controls_Manager::CHOOSE,
			'options'      => Widget_Utils::get_control_options_vertical_alignment(),
			'default'      => 'top',
			'prefix_class' => 'maxcoach-counter-number-ver-align-',
			'condition'    => [
				'number_position!' => 'top',
			],
		] );

		$this->add_control( 'mobile_number_top_position', [
			'label'        => esc_html__( 'Mobile Top Position', 'maxcoach' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'condition'    => [
				'number_position!' => 'top',
			],
			'prefix_class' => 'maxcoach-counter-number-mobile-position-top-',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'number',
			'selector' => '{{WRAPPER}} .counter-number-wrap',
			'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
		] );

		$this->start_controls_tabs( 'number_colors' );

		$this->start_controls_tab( 'number_color_normal', [
			'label' => esc_html__( 'Normal', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'number',
			'selector' => '{{WRAPPER}} .counter-number-wrap',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'number_color_hover', [
			'label' => esc_html__( 'Hover', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'number_hover',
			'selector' => '{{WRAPPER}} .maxcoach-box:hover .counter-number-wrap',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_graphic_style_section() {
		$this->start_controls_section( 'graphic_style_section', [
			'label'     => esc_html__( 'Graphic Element', 'maxcoach' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'graphic_element!' => 'none',
			],
		] );

		$this->add_control( 'media_margin', [
			'label'      => esc_html__( 'Margin', 'maxcoach' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .maxcoach-graphic-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'media_wrap_height', [
			'label'     => esc_html__( 'Wrap Height', 'maxcoach' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 6,
					'max' => 300,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .maxcoach-graphic-wrap' => 'height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	private function add_title_style_section() {
		$this->start_controls_section( 'title_style_section', [
			'label' => esc_html__( 'Title', 'maxcoach' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'heading_margin', [
			'label'      => esc_html__( 'Margin', 'maxcoach' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .heading-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title',
			'selector' => '{{WRAPPER}} .counter-heading',
			'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
		] );

		$this->start_controls_tabs( 'title_colors' );

		$this->start_controls_tab( 'title_color_normal', [
			'label' => esc_html__( 'Normal', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'title',
			'selector' => '{{WRAPPER}} .counter-heading',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'title_color_hover', [
			'label' => esc_html__( 'Hover', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'title_hover',
			'selector' => '{{WRAPPER}} .maxcoach-box:hover .counter-heading',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_description_style_section() {
		$this->start_controls_section( 'description_style_section', [
			'label'     => esc_html__( 'Description', 'maxcoach' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'description_text!' => '',
			],
		] );

		$this->add_control( 'description_margin', [
			'label'      => esc_html__( 'Margin', 'maxcoach' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .description-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'description',
			'selector' => '{{WRAPPER}} .counter-description',
			'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
		] );

		$this->start_controls_tabs( 'description_colors' );

		$this->start_controls_tab( 'description_color_normal', [
			'label' => esc_html__( 'Normal', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'description',
			'selector' => '{{WRAPPER}} .counter-description',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'description_color_hover', [
			'label' => esc_html__( 'Hover', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'description_hover',
			'selector' => '{{WRAPPER}} .maxcoach-box:hover .counter-description',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'box', 'class', 'maxcoach-box tm-counter' );

		if ( ! isset( $settings['ending_number'] ) ) {
			return;
		}

		$starting_number = isset( $settings['starting_number'] ) ? intval( $settings['starting_number'] ) : 0;
		$ending_number   = intval( $settings['ending_number'] );
		$duration        = isset( $settings['duration'] ) ? intval( $settings['duration'] ) : 2000;
		$separator_char  = ! empty( $settings['thousand_separator_char'] ) ? $settings['thousand_separator_char'] : ',';

		$counter_options = [
			'from'      => $starting_number,
			'to'        => $ending_number,
			'duration'  => $duration,
			'separator' => $separator_char,
		];

		$this->add_render_attribute( 'box', 'data-counter', wp_json_encode( $counter_options ) );
		?>
		<div <?php $this->print_render_attribute_string( 'box' ); ?>>
			<?php if ( 'none' !== $settings['graphic_element'] ) : ?>
				<?php
				switch ( $settings['graphic_element'] ) {
					case 'image' :
						$this->print_graphic_image();
						break;
					case 'icon' :
						$this->print_graphic_icon();
						break;
				}
				?>
			<?php endif; ?>

			<div class="counter-content">
				<div class="counter-number-wrap">
					<span class="counter-number-prefix"><?php echo esc_html( $settings['prefix'] ); ?></span>
					<span class="counter-number"><?php echo esc_html( $starting_number ); ?></span>
					<span class="counter-number-suffix"><?php echo esc_html( $settings['suffix'] ); ?></span>
				</div>
				<div class="counter-caption">
					<?php $this->print_title(); ?>
					<?php $this->print_description(); ?>
				</div>
			</div>
		</div>
		<?php
	}

	private function print_graphic_image() {
		$settings = $this->get_settings_for_display();

		if ( 'image' !== $settings['graphic_element'] || empty( $settings['image']['url'] ) ) {
			return;
		}
		?>
		<div class="maxcoach-graphic-wrap image">
			<?php echo \Maxcoach_Image::get_elementor_attachment( [
				'settings'  => $settings,
				'image_key' => 'image',
			] ); ?>
		</div>
		<?php
	}

	private function print_graphic_icon() {
		$settings = $this->get_settings_for_display();

		if ( 'icon' !== $settings['graphic_element'] || empty( $settings["icon"]['value'] ) ) {
			return;
		}

		$icon_key = 'icon';

		$this->add_render_attribute( $icon_key, 'class', [
			'maxcoach-icon',
			'icon',
		] );

		$is_svg = isset( $settings['icon']['library'] ) && 'svg' === $settings['icon']['library'] ? true : false;

		if ( $is_svg ) {
			$this->add_render_attribute( $icon_key, 'class', 'maxcoach-svg-icon' );
		}

		if ( isset( $settings['icon_color_type'] ) && '' !== $settings['icon_color_type'] ) {
			switch ( $settings['icon_color_type'] ) {
				case 'gradient' :
					$this->add_render_attribute( $icon_key, 'class', 'maxcoach-gradient-icon' );
					break;
				case 'classic' :
					$this->add_render_attribute( $icon_key, 'class', 'maxcoach-solid-icon' );
					break;
			}
		}
		?>
		<div class="maxcoach-graphic-wrap maxcoach-icon-wrap">
			<div class="maxcoach-icon-view first">
				<div class="maxcoach-icon-view-inner">
					<div <?php $this->print_attributes_string( $icon_key ); ?>>
						<?php $this->render_icon( $settings, $settings['icon'], [ 'aria-hidden' => 'true' ], $is_svg, 'icon' ); ?>
					</div>
				</div>
			</div>

			<?php if ( 'bubble' === $settings['icon_view'] ) { ?>
				<div class="maxcoach-icon-view second"></div>
			<?php } ?>
		</div>
		<?php
	}

	private function print_title() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['title_text'] ) ) {
			return;
		}

		$title_text = wp_kses( $settings['title_text'], [
			'br'   => [],
			'span' => [
				'class' => [],
			],
			'mark' => [
				'class' => [],
			],
		] );

		$this->add_render_attribute( 'title', 'class', 'counter-heading' );
		?>
		<div class="heading-wrap">
			<?php printf( '<%1$s %2$s>%3$s</%1$s>', 'h3', $this->get_render_attribute_string( 'title' ), $title_text ); ?>
		</div>
		<?php
	}

	private function print_description() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['description_text'] ) ) {
			return;
		}

		$description_text = wp_kses( $settings['description_text'], [
			'br'   => [],
			'span' => [
				'class' => [],
			],
			'mark' => [
				'class' => [],
			],
		] );

		$this->add_render_attribute( 'description', 'class', 'counter-description' );
		?>
		<div class="description-wrap">
			<?php printf( '<%1$s %2$s>%3$s</%1$s>', 'div', $this->get_render_attribute_string( 'description' ), $description_text ); ?>
		</div>
		<?php
	}
}
