<?php

namespace Maxcoach_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

defined( 'ABSPATH' ) || exit;

class Widget_Event extends Posts_Base {

	public function get_name() {
		return 'tm-event-grid';
	}

	public function get_title() {
		return esc_html__( 'Event Grid', 'maxcoach' );
	}

	public function get_icon_part() {
		return 'eicon-posts-grid';
	}

	public function get_keywords() {
		return [ 'event', 'grid' ];
	}

	protected function get_post_type() {
		return 'tp_event';
	}

	protected function get_post_category() {
		return 'tp_event_category';
	}

	protected function _register_controls() {
		$this->add_content_section();

		$this->add_grid_options_section();

		$this->add_style_section();

		parent::_register_controls();
	}

	protected function add_grid_options_section() {
		$this->start_controls_section( 'grid_options_section', [
			'label'     => esc_html__( 'Grid Options', 'maxcoach' ),
			'condition' => [
				'layout' => [
					'minimal',
				],
			],
		] );

		$this->add_responsive_control( 'grid_columns', [
			'label'          => esc_html__( 'Columns', 'maxcoach' ),
			'type'           => Controls_Manager::NUMBER,
			'min'            => 1,
			'max'            => 12,
			'step'           => 1,
			'default'        => 2,
			'tablet_default' => 2,
			'mobile_default' => 1,
			'selectors'      => [
				'{{WRAPPER}} .modern-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
			],
		] );

		$this->add_responsive_control( 'grid_column_gutter', [
			'label'     => esc_html__( 'Column Gutter', 'maxcoach' ),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 0,
			'max'       => 200,
			'step'      => 1,
			'default'   => 30,
			'selectors' => [
				'{{WRAPPER}} .modern-grid' => 'grid-column-gap: {{VALUE}}px;',
			],
		] );

		$this->add_responsive_control( 'grid_row_gutter', [
			'label'     => esc_html__( 'Row Gutter', 'maxcoach' ),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 0,
			'max'       => 200,
			'step'      => 1,
			'default'   => 30,
			'selectors' => [
				'{{WRAPPER}} .modern-grid' => 'grid-row-gap: {{VALUE}}px;',
			],
		] );

		$this->add_responsive_control( 'grid_content_position', [
			'label'                => esc_html__( 'Content Position', 'maxcoach' ),
			'type'                 => Controls_Manager::SELECT,
			'default'              => '',
			'options'              => [
				''       => esc_html__( 'Default', 'maxcoach' ),
				'top'    => esc_html__( 'Top', 'maxcoach' ),
				'middle' => esc_html__( 'Middle', 'maxcoach' ),
				'bottom' => esc_html__( 'Bottom', 'maxcoach' ),
			],
			'selectors_dictionary' => [
				'top'    => 'flex-start',
				'middle' => 'center',
				'bottom' => 'flex-end',
			],
			'selectors'            => [
				'{{WRAPPER}} .modern-grid .grid-item' => 'align-items: {{VALUE}}',
			],
			'render_type'          => 'template',
		] );

		$this->add_responsive_control( 'grid_content_alignment', [
			'label'                => esc_html__( 'Content Alignment', 'maxcoach' ),
			'type'                 => Controls_Manager::SELECT,
			'default'              => '',
			'options'              => [
				''       => esc_html__( 'Default', 'maxcoach' ),
				'left'   => esc_html__( 'Left', 'maxcoach' ),
				'center' => esc_html__( 'Center', 'maxcoach' ),
				'right'  => esc_html__( 'Right', 'maxcoach' ),
			],
			'selectors_dictionary' => [
				'left'  => 'flex-start',
				'right' => 'flex-end',
			],
			'selectors'            => [
				'{{WRAPPER}} .modern-grid .grid-item' => 'justify-content: {{VALUE}}',
			],
			'render_type'          => 'template',
		] );

		$this->add_responsive_control( 'grid_content_padding', [
			'label'      => esc_html__( 'Item Padding', 'maxcoach' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'separator'  => 'after',
		] );

		$this->end_controls_section();
	}

	private function add_content_section() {
		$this->start_controls_section( 'content_section', [
			'label' => esc_html__( 'Content', 'maxcoach' ),
		] );

		$this->add_control( 'layout', [
			'label'   => esc_html__( 'Layout', 'maxcoach' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'minimal'           => esc_html__( 'Minimal', 'maxcoach' ),
				'one-left-featured' => esc_html__( '1 Left Featured', 'maxcoach' ),
				'alternate-grid'    => esc_html__( 'Grid Alternate (2 Columns)', 'maxcoach' ),
			],
			'default' => 'minimal',
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

		$this->add_group_control( Group_Control_Image_Size::get_type(), [
			'label'     => esc_html__( 'Image Size', 'maxcoach' ),
			'name'      => 'image',
			'default'   => 'full',
			'separator' => 'before',
		] );

		$this->end_controls_section();
	}

	private function add_style_section() {
		$this->start_controls_section( 'style_section', [
			'label' => esc_html__( 'Style', 'maxcoach' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'title_style_heading', [
			'label'     => esc_html__( 'Title', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'title_margin', [
			'label'      => esc_html__( 'Margin', 'maxcoach' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .event-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'label'    => esc_html__( 'Typography', 'maxcoach' ),
			'selector' => '{{WRAPPER}} .event-title',
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Color', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .event-title' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'title_hover_color', [
			'label'     => esc_html__( 'Hover Color', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .event-title:hover' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'date_style_heading', [
			'label'     => esc_html__( 'Date', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'date_typography',
			'label'    => esc_html__( 'Typography', 'maxcoach' ),
			'selector' => '{{WRAPPER}} .event-date',
		] );

		$this->add_control( 'date_color', [
			'label'     => esc_html__( 'Color', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .event-date-time' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'date_day_typography',
			'label'    => esc_html__( 'Day Typography', 'maxcoach' ),
			'selector' => '{{WRAPPER}} .event-date .event-date--day',
		] );

		$this->add_control( 'location_style_heading', [
			'label'     => esc_html__( 'Location', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'location_typography',
			'label'    => esc_html__( 'Typography', 'maxcoach' ),
			'selector' => '{{WRAPPER}} .event-location',
		] );

		$this->add_control( 'location_color', [
			'label'     => esc_html__( 'Color', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .event-location' => 'color: {{VALUE}};',
			],
		] );

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
			'maxcoach-grid-wrapper maxcoach-event-grid',
			'style-' . $settings['layout'],
		] );

		if ( 'current_query' === $settings['query_source'] ) {
			$this->add_render_attribute( 'wrapper', 'data-query-main', '1' );
		}
		?>
		<div <?php $this->print_attributes_string( 'wrapper' ); ?>>
			<?php if ( $query->have_posts() ) : ?>
				<?php
				set_query_var( 'maxcoach_query', $query );
				set_query_var( 'settings', $settings );

				get_template_part( 'loop/widgets/event/style', $settings['layout'] );
				?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
		<?php
	}
}
