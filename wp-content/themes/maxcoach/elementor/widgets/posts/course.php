<?php

namespace Maxcoach_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use ElementorPro\Modules\QueryControl\Module as Module_Query;

defined( 'ABSPATH' ) || exit;

class Widget_Course extends Posts_Base {

	public function get_name() {
		return 'tm-course';
	}

	public function get_title() {
		return esc_html__( 'Course', 'maxcoach' );
	}

	public function get_icon_part() {
		return 'eicon-posts-grid';
	}

	public function get_keywords() {
		return [ 'course' ];
	}

	protected function get_post_type() {
		return 'lp_course';
	}

	protected function get_post_category() {
		return 'course_category';
	}

	protected function get_query_author_object() {
		return Module_Query::QUERY_OBJECT_USER;
	}

	public function get_script_depends() {
		return [
			'maxcoach-grid-query',
			'maxcoach-widget-grid-post',
		];
	}

	protected function _register_controls() {
		$this->add_layout_section();

		$this->add_grid_section();

		$this->add_filter_section();

		$this->add_pagination_section();

		$this->add_sorting_section();

		$this->add_box_style_section();

		$this->add_thumbnail_style_section();

		$this->add_caption_style_section();

		$this->add_filter_style_section();

		$this->add_pagination_style_section();

		parent::_register_controls();
	}

	private function add_layout_section() {
		$this->start_controls_section( 'layout_section', [
			'label' => esc_html__( 'Layout', 'maxcoach' ),
		] );

		$this->add_control( 'layout', [
			'label'   => esc_html__( 'Layout', 'maxcoach' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'grid'    => esc_html__( 'Grid', 'maxcoach' ),
				'masonry' => esc_html__( 'Masonry', 'maxcoach' ),
				'zigzag'  => esc_html__( 'Zigzag', 'maxcoach' ),
				//'metro'   => esc_html__( 'Metro', 'maxcoach' ),
			],
			'default' => 'grid',
		] );

		$this->add_responsive_control( 'zigzag_height', [
			'label'     => esc_html__( 'Zigzag Height', 'maxcoach' ),
			'type'      => Controls_Manager::NUMBER,
			'step'      => 1,
			'condition' => [
				'layout' => 'masonry',
			],
		] );

		$this->add_control( 'zigzag_reversed', [
			'label'     => esc_html__( 'Zigzag Reversed?', 'maxcoach' ),
			'type'      => Controls_Manager::SWITCHER,
			'condition' => [
				'layout' => 'masonry',
			],
		] );

		$this->add_control( 'hover_effect', [
			'label'        => esc_html__( 'Hover Effect', 'maxcoach' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				''         => esc_html__( 'None', 'maxcoach' ),
				'zoom-in'  => esc_html__( 'Zoom In', 'maxcoach' ),
				'zoom-out' => esc_html__( 'Zoom Out', 'maxcoach' ),
			],
			'default'      => '',
			'prefix_class' => 'maxcoach-animation-',
		] );

		$this->add_caption_popover();

		$this->add_control( 'metro_image_size_width', [
			'label'     => esc_html__( 'Image Size', 'maxcoach' ),
			'type'      => Controls_Manager::NUMBER,
			'step'      => 1,
			'default'   => 480,
			'condition' => [
				'layout' => 'metro',
			],
		] );

		$this->add_control( 'metro_image_ratio', [
			'label'     => esc_html__( 'Image Ratio', 'maxcoach' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'max'  => 2,
					'min'  => 0.10,
					'step' => 0.01,
				],
			],
			'default'   => [
				'size' => 1,
			],
			'condition' => [
				'layout' => 'metro',
			],
		] );

		$this->add_control( 'thumbnail_default_size', [
			'label'        => esc_html__( 'Use Default Thumbnail Size', 'maxcoach' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => '1',
			'return_value' => '1',
			'separator'    => 'before',
			'condition'    => [
				'layout!' => 'metro',
			],
		] );

		$this->add_group_control( Group_Control_Image_Size::get_type(), [
			'name'      => 'thumbnail',
			'default'   => 'full',
			'condition' => [
				'layout!'                 => 'metro',
				'thumbnail_default_size!' => '1',
			],
		] );

		$this->end_controls_section();
	}

	private function add_caption_popover() {
		$this->add_control( 'show_caption', [
			'label'        => esc_html__( 'Caption', 'maxcoach' ),
			'type'         => Controls_Manager::POPOVER_TOGGLE,
			'label_off'    => esc_html__( 'Default', 'maxcoach' ),
			'label_on'     => esc_html__( 'Custom', 'maxcoach' ),
			'return_value' => 'yes',
		] );

		$this->start_popover();

		$this->add_control( 'caption_style', [
			'label'        => esc_html__( 'Style', 'maxcoach' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				'01' => esc_html__( 'Style 01', 'maxcoach' ),
				'02' => esc_html__( 'Style 02', 'maxcoach' ),
				'03' => esc_html__( 'Style 03', 'maxcoach' ),
				'04' => esc_html__( 'Style 04', 'maxcoach' ),
				'05' => esc_html__( 'Style 05', 'maxcoach' ),
				'06' => esc_html__( 'Style 06', 'maxcoach' ),
				'07' => esc_html__( 'Style 07', 'maxcoach' ),
				'08' => esc_html__( 'Style 08', 'maxcoach' ),
				'09' => esc_html__( 'Style 09', 'maxcoach' ),
				'10' => esc_html__( 'Style 10', 'maxcoach' ),
				'11' => esc_html__( 'Style 11', 'maxcoach' ),
				'12' => esc_html__( 'Style 12', 'maxcoach' ),
				'13' => esc_html__( 'Style 13', 'maxcoach' ),
			],
			'default'      => '01',
			'prefix_class' => 'course-caption-style-',
			'render_type'  => 'template',
			'condition'    => [
				'layout!' => [ 'zigzag' ],
			],
		] );

		$this->add_control( 'show_caption_instructor', [
			'label'     => esc_html__( 'Instructor', 'maxcoach' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Show', 'maxcoach' ),
			'label_off' => esc_html__( 'Hide', 'maxcoach' ),
		] );

		$this->add_control( 'show_caption_date', [
			'label'     => esc_html__( 'Date', 'maxcoach' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Show', 'maxcoach' ),
			'label_off' => esc_html__( 'Hide', 'maxcoach' ),
		] );

		$this->add_control( 'show_caption_meta', [
			'label'       => esc_html__( 'Meta', 'maxcoach' ),
			'label_block' => true,
			'type'        => Controls_Manager::SELECT2,
			'multiple'    => true,
			'default'     => [
				'lessons',
				'students',
			],
			'options'     => [
				'lessons'  => esc_html__( 'Lessons', 'maxcoach' ),
				'students' => esc_html__( 'Students', 'maxcoach' ),
				'duration' => esc_html__( 'Duration', 'maxcoach' ),
				'category' => esc_html__( 'Category', 'maxcoach' ),
			],
		] );

		$this->add_control( 'show_caption_meta_icon', [
			'label'        => esc_html__( 'Meta Icon', 'maxcoach' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show', 'maxcoach' ),
			'label_off'    => esc_html__( 'Hide', 'maxcoach' ),
			'prefix_class' => 'course-caption-meta-icon-',
			'default'      => 'yes',
		] );

		$this->add_control( 'show_caption_excerpt', [
			'label'     => esc_html__( 'Excerpt', 'maxcoach' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Show', 'maxcoach' ),
			'label_off' => esc_html__( 'Hide', 'maxcoach' ),
		] );

		$this->add_control( 'excerpt_length', [
			'label'     => esc_html__( 'Excerpt Length', 'maxcoach' ),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 5,
			'condition' => [
				'show_caption_excerpt' => 'yes',
			],
		] );

		$this->add_control( 'show_caption_buttons', [
			'label'     => esc_html__( 'Buttons', 'maxcoach' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Show', 'maxcoach' ),
			'label_off' => esc_html__( 'Hide', 'maxcoach' ),
		] );

		$this->add_control( 'purchase_button_text', [
			'label'       => esc_html__( 'Purchase Button', 'maxcoach' ),
			'label_block' => true,
			'description' => esc_html__( 'Custom text for purchase button.', 'maxcoach' ),
			'type'        => Controls_Manager::TEXT,
			'condition'   => [
				'show_caption_buttons' => 'yes',
			],
		] );

		$this->end_popover();
	}

	private function add_grid_section() {
		$this->start_controls_section( 'grid_options_section', [
			'label' => esc_html__( 'Grid Options', 'maxcoach' ),
		] );

		$this->add_responsive_control( 'grid_columns', [
			'label'          => esc_html__( 'Columns', 'maxcoach' ),
			'type'           => Controls_Manager::NUMBER,
			'min'            => 1,
			'max'            => 12,
			'step'           => 1,
			'default'        => 3,
			'tablet_default' => 2,
			'mobile_default' => 1,
		] );

		$this->add_responsive_control( 'grid_gutter', [
			'label'   => esc_html__( 'Gutter', 'maxcoach' ),
			'type'    => Controls_Manager::NUMBER,
			'min'     => 0,
			'max'     => 200,
			'step'    => 1,
			'default' => 30,
		] );

		$metro_layout_repeater = new Repeater();

		$metro_layout_repeater->add_control( 'size', [
			'label'   => esc_html__( 'Item Size', 'maxcoach' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '1:1',
			'options' => Widget_Utils::get_grid_metro_size(),
		] );

		$this->add_control( 'grid_metro_layout', [
			'label'       => esc_html__( 'Metro Layout', 'maxcoach' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $metro_layout_repeater->get_controls(),
			'default'     => [
				[ 'size' => '2:2' ],
				[ 'size' => '1:1' ],
				[ 'size' => '1:1' ],
				[ 'size' => '1:1' ],
				[ 'size' => '2:2' ],
				[ 'size' => '1:1' ],
			],
			'title_field' => '{{{ size }}}',
			'condition'   => [
				'layout' => 'metro',
			],
		] );

		$this->end_controls_section();
	}

	private function add_box_style_section() {
		$this->start_controls_section( 'box_style_section', [
			'label' => esc_html__( 'Box', 'maxcoach' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'box_border_radius', [
			'label'     => esc_html__( 'Border Radius', 'maxcoach' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .maxcoach-box' => 'border-radius: {{SIZE}}{{UNIT}}',
			],
		] );

		$this->start_controls_tabs( 'box_style_tabs' );

		$this->start_controls_tab( 'box_style_normal_tab', [
			'label' => esc_html__( 'Normal', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'box_background',
			'selector' => '{{WRAPPER}} .maxcoach-box',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_box_shadow',
			'selector' => '{{WRAPPER}} .maxcoach-box',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'box_style_hover_tab', [
			'label' => esc_html__( 'Hover', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'box_hover_background',
			'selector' => '{{WRAPPER}} .maxcoach-box:hover',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_hover_box_shadow',
			'selector' => '{{WRAPPER}} .maxcoach-box:hover',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_thumbnail_style_section() {
		$this->start_controls_section( 'thumbnail_style_section', [
			'label' => esc_html__( 'Thumbnail', 'maxcoach' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'thumbnail_border_radius', [
			'label'     => esc_html__( 'Border Radius', 'maxcoach' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .maxcoach-image, {{WRAPPER}} .maxcoach-image img' => 'border-radius: {{SIZE}}{{UNIT}}',
			],
		] );

		$this->start_controls_tabs( 'thumbnail_effects_tabs' );

		$this->start_controls_tab( 'thumbnail_effects_normal_tab', [
			'label' => esc_html__( 'Normal', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'thumbnail_box_shadow',
			'selector' => '{{WRAPPER}} .maxcoach-image',
		] );

		$this->add_group_control( Group_Control_Css_Filter::get_type(), [
			'name'     => 'css_filters',
			'selector' => '{{WRAPPER}} .maxcoach-image img',
		] );

		$this->add_control( 'thumbnail_opacity', [
			'label'     => esc_html__( 'Opacity', 'maxcoach' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'max'  => 1,
					'min'  => 0.10,
					'step' => 0.01,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .maxcoach-image img' => 'opacity: {{SIZE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'thumbnail_effects_hover_tab', [
			'label' => esc_html__( 'Hover', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'thumbnail_box_shadow_hover',
			'selector' => '{{WRAPPER}} .maxcoach-box:hover .maxcoach-image',
		] );

		$this->add_group_control( Group_Control_Css_Filter::get_type(), [
			'name'     => 'css_filters_hover',
			'selector' => '{{WRAPPER}} .maxcoach-box:hover .maxcoach-image img',
		] );

		$this->add_control( 'thumbnail_opacity_hover', [
			'label'     => esc_html__( 'Opacity', 'maxcoach' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'max'  => 1,
					'min'  => 0.10,
					'step' => 0.01,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .maxcoach-box:hover .maxcoach-image img' => 'opacity: {{SIZE}};',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_caption_style_section() {
		$this->start_controls_section( 'caption_style_section', [
			'label'     => esc_html__( 'Caption', 'maxcoach' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'show_caption' => 'yes',
			],
		] );

		$this->add_responsive_control( 'caption_text_align', [
			'label'     => esc_html__( 'Alignment', 'maxcoach' ),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => Widget_Utils::get_control_options_text_align(),
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .course-info' => 'text-align: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'caption_padding', [
			'label'      => esc_html__( 'Padding', 'maxcoach' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .course-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_control( 'course_title_style_hr', [
			'label'     => esc_html__( 'Course Title', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'course_title_typography',
			'label'    => esc_html__( 'Typography', 'maxcoach' ),
			'selector' => '{{WRAPPER}} .course-info .course-title',
		] );

		$this->add_control( 'course_date_style_hr', [
			'label'     => esc_html__( 'Course Date', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'show_caption_date' => 'yes',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'course_date_typography',
			'label'     => esc_html__( 'Typography', 'maxcoach' ),
			'selector'  => '{{WRAPPER}} .course-info .course-date',
			'condition' => [
				'show_caption_date' => 'yes',
			],
		] );

		$this->add_responsive_control( 'course_date_margin', [
			'label'      => esc_html__( 'Margin', 'maxcoach' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .course-info .course-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'show_caption_date' => 'yes',
			],
		] );

		$this->add_control( 'course_meta_style_hr', [
			'label'     => esc_html__( 'Course Meta', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'course_meta_typography',
			'label'    => esc_html__( 'Typography', 'maxcoach' ),
			'selector' => '{{WRAPPER}} .course-info .course-meta',
		] );

		$this->add_responsive_control( 'course_meta_margin', [
			'label'      => esc_html__( 'Margin', 'maxcoach' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .course-info .course-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_control( 'course_instructor_style_hr', [
			'label'     => esc_html__( 'Course Instructor', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'show_caption_instructor' => 'yes',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'course_instructor_typography',
			'label'     => esc_html__( 'Typography', 'maxcoach' ),
			'selector'  => '{{WRAPPER}} .course-info .course-instructor',
			'condition' => [
				'show_caption_instructor' => 'yes',
			],
		] );

		$this->add_responsive_control( 'course_instructor_margin', [
			'label'      => esc_html__( 'Margin', 'maxcoach' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .course-info .course-instructor' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'show_caption_instructor' => 'yes',
			],
		] );

		$this->add_control( 'course_price_style_hr', [
			'label'     => esc_html__( 'Course Price', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'course_price_typography',
			'label'    => esc_html__( 'Typography', 'maxcoach' ),
			'selector' => '{{WRAPPER}} .course-info .course-price',
		] );

		$this->add_responsive_control( 'course_price_margin', [
			'label'      => esc_html__( 'Margin', 'maxcoach' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .course-info .course-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_control( 'course_excerpt_style_hr', [
			'label'     => esc_html__( 'Course Excerpt', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'show_caption_excerpt' => 'yes',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'course_excerpt_typography',
			'label'     => esc_html__( 'Typography', 'maxcoach' ),
			'selector'  => '{{WRAPPER}} .course-info .course-excerpt',
			'condition' => [
				'show_caption_excerpt' => 'yes',
			],
		] );

		$this->add_responsive_control( 'course_excerpt_margin', [
			'label'      => esc_html__( 'Margin', 'maxcoach' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .course-info .course-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'show_caption_excerpt' => 'yes',
			],
		] );

		$this->add_control( 'caption_colors_hr', [
			'label'     => esc_html__( 'Colors', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->start_controls_tabs( 'caption_colors_tabs' );

		$this->start_controls_tab( 'caption_colors_normal_tab', [
			'label' => esc_html__( 'Normal', 'maxcoach' ),
		] );

		$this->add_control( 'course_title_color', [
			'label'     => esc_html__( 'Title', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-info .course-title' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'caption_date_color', [
			'label'     => esc_html__( 'Date', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-info .course-date' => 'color: {{VALUE}};',
			],
			'condition' => [
				'show_caption_date' => 'yes',
			],
		] );

		$this->add_control( 'caption_meta_color', [
			'label'     => esc_html__( 'Meta', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-info .course-meta' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'caption_instructor_color', [
			'label'     => esc_html__( 'Instructor', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-info .course-instructor' => 'color: {{VALUE}};',
			],
			'condition' => [
				'show_caption_instructor' => 'yes',
			],
		] );

		$this->add_control( 'caption_price_color', [
			'label'     => esc_html__( 'Price', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-info .course-price' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'caption_excerpt_color', [
			'label'     => esc_html__( 'Excerpt', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-info .course-excerpt' => 'color: {{VALUE}};',
			],
			'condition' => [
				'show_caption_excerpt' => 'yes',
			],
		] );

		$this->add_control( 'caption_line_hr', [
			'label'     => esc_html__( 'Caption Line', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'caption_style' => [ '13' ],
			],
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'box_caption_line',
			'selector' => '{{WRAPPER}} .course-info:after',
			'condition' => [
				'caption_style' => [ '13' ],
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'caption_colors_hover_tab', [
			'label' => esc_html__( 'Hover', 'maxcoach' ),
		] );

		$this->add_control( 'course_title_hover_color', [
			'label'     => esc_html__( 'Title', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-info .course-title:hover' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'course_date_hover_color', [
			'label'     => esc_html__( 'Date', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-wrapper:hover .course-info .course-date' => 'color: {{VALUE}};',
			],
			'condition' => [
				'show_caption_date' => 'yes',
			],
		] );

		$this->add_control( 'course_meta_hover_color', [
			'label'     => esc_html__( 'Meta', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-wrapper .course-info .course-meta a:hover' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'course_instructor_hover_color', [
			'label'     => esc_html__( 'Instructor', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-wrapper:hover .course-info .course-instructor' => 'color: {{VALUE}};',
			],
			'condition' => [
				'show_caption_instructor' => 'yes',
			],
		] );

		$this->add_control( 'course_price_hover_color', [
			'label'     => esc_html__( 'Price', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-wrapper:hover .course-info .course-price' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'caption_excerpt_hover_color', [
			'label'     => esc_html__( 'Excerpt', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-wrapper:hover .course-info .course-excerpt' => 'color: {{VALUE}};',
			],
			'condition' => [
				'show_caption_excerpt' => 'yes',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->query_posts();
		/**
		 * @var $query \WP_Query
		 */
		$query     = $this->get_query();
		$post_type = $this->get_post_type();

		$this->add_render_attribute( 'wrapper', 'class', [
			'maxcoach-grid-wrapper maxcoach-course',
			'style-' . $settings['layout'],
		] );

		if ( 'metro' === $settings['layout'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'maxcoach-grid-metro' );
		}

		$this->add_render_attribute( 'content-wrapper', 'class', 'maxcoach-grid' );

		if ( $this->is_grid() ) {
			$grid_options = $this->get_grid_options( $settings );

			$this->add_render_attribute( 'wrapper', 'data-grid', wp_json_encode( $grid_options ) );

			$this->add_render_attribute( 'content-wrapper', 'class', 'lazy-grid' );
		}

		if ( 'current_query' === $settings['query_source'] ) {
			$this->add_render_attribute( 'wrapper', 'data-query-main', '1' );
		}

		if ( ! empty( $settings['pagination_type'] ) && $query->found_posts > $settings['query_number'] ) {
			$this->add_render_attribute( 'wrapper', 'data-pagination', $settings['pagination_type'] );
		}

		if ( ! empty( $settings['pagination_custom_button_id'] ) ) {
			$this->add_render_attribute( 'wrapper', 'data-pagination-custom-button-id', $settings['pagination_custom_button_id'] );
		}

		if ( ! empty( $settings['filter_style'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'filter-style-' . $settings['filter_style'] );
		}
		?>
		<div <?php $this->print_attributes_string( 'wrapper' ); ?>>
			<?php if ( $query->have_posts() ) : ?>
				<?php
				$maxcoach_grid_query['source']        = $settings['query_source'];
				$maxcoach_grid_query['action']        = "{$post_type}_infinite_load";
				$maxcoach_grid_query['max_num_pages'] = $query->max_num_pages;
				$maxcoach_grid_query['found_posts']   = $query->found_posts;
				$maxcoach_grid_query['count']         = $query->post_count;
				$maxcoach_grid_query['query_vars']    = $this->get_query_args();
				$maxcoach_grid_query['settings']      = $settings;
				$maxcoach_grid_query                  = htmlspecialchars( wp_json_encode( $maxcoach_grid_query ) );
				?>
				<input type="hidden"
				       class="maxcoach-query-input" <?php echo 'value="' . $maxcoach_grid_query . '"'; ?>/>

				<?php $this->print_result_count_and_sorting(); ?>

				<?php $this->print_filter( $query->found_posts ); ?>

				<div <?php $this->print_attributes_string( 'content-wrapper' ); ?>>
					<?php if ( $this->is_grid() ) : ?>
						<div class="maxcoach-grid-loader">
							<?php get_template_part( 'template-parts/preloader/style', 'circle' ); ?>
						</div>

						<div class="grid-sizer"></div>
					<?php endif; ?>

					<?php
					learn_press_setup_user();

					if ( 'yes' === $settings['show_caption_buttons'] && ! empty( $settings['purchase_button_text'] ) ) {
						add_filter( 'learn-press/purchase-course-button-text', [
							$this,
							'change_purchase_button_text',
						] );
					}

					set_query_var( 'maxcoach_query', $query );
					set_query_var( 'settings', $settings );

					get_template_part( 'loop/widgets/course/style', $settings['layout'] );

					remove_filter( 'learn-press/purchase-course-button-text', [
						$this,
						'change_purchase_button_text',
					] );
					?>
				</div>

				<?php $this->print_pagination( $query, $settings ); ?>

				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
		<?php
	}

	public function change_purchase_button_text( $text ) {
		$settings = $this->get_settings_for_display();

		$text = $settings['purchase_button_text'];

		return $text;
	}
}
