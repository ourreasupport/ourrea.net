<?php

namespace Maxcoach_Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || exit;

//@todo Not compatible with WPML.

class Widget_Gradation extends Base {

	public function get_name() {
		return 'tm-gradation';
	}

	public function get_title() {
		return esc_html__( 'Gradation', 'maxcoach' );
	}

	public function get_icon_part() {
		return 'eicon-navigation-horizontal';
	}

	public function get_keywords() {
		return [ 'gradation', 'step' ];
	}

	protected function _register_controls() {
		$this->start_controls_section( 'layout_section', [
			'label' => esc_html__( 'Layout', 'maxcoach' ),
		] );

		$this->add_control( 'style', [
			'label'        => esc_html__( 'Style', 'maxcoach' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				'01' => esc_html__( 'Style 01', 'maxcoach' ),
				'02' => esc_html__( 'Style 02', 'maxcoach' ),
				'03' => esc_html__( 'Style 03', 'maxcoach' ),
			],
			'default'      => '01',
			'prefix_class' => 'maxcoach-gradation-style-',
		] );

		$this->add_control( 'layout', [
			'label'        => esc_html__( 'Layout', 'maxcoach' ),
			'label_block'  => false,
			'type'         => Controls_Manager::CHOOSE,
			'default'      => 'inline',
			'options'      => [
				'block'  => [
					'title' => esc_html__( 'Default', 'maxcoach' ),
					'icon'  => 'eicon-editor-list-ul',
				],
				'inline' => [
					'title' => esc_html__( 'Inline', 'maxcoach' ),
					'icon'  => 'eicon-ellipsis-h',
				],
			],
			'prefix_class' => 'maxcoach-gradation-layout-',
		] );

		$this->add_control( 'starting_number', [
			'label'   => esc_html__( 'Starting Number', 'maxcoach' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 1,
			'min'     => 1,
			'step'    => 1,
			'dynamic' => [
				'active' => true,
			],

		] );

		$this->add_control( 'show_leading_zero', [
			'label' => esc_html__( 'Leading Zero', 'maxcoach' ),
			'type'  => Controls_Manager::SWITCHER,
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'title', [
			'label'       => esc_html__( 'Title', 'maxcoach' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => esc_html__( 'Title', 'maxcoach' ),
			'label_block' => true,
		] );

		$repeater->add_control( 'description', [
			'label' => esc_html__( 'Description', 'maxcoach' ),
			'type'  => Controls_Manager::TEXTAREA,
		] );

		$this->add_control( 'items', [
			'label'       => esc_html__( 'Items', 'maxcoach' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'title'       => esc_html__( 'Step #1', 'maxcoach' ),
					'description' => esc_html__( 'Suspe ndisse suscipit sagittis leo sit met condimentum estibulum issim Lorem ipsum dolor sit amet, consectetur cium', 'maxcoach' ),
				],
				[
					'title'       => esc_html__( 'Step #2', 'maxcoach' ),
					'description' => esc_html__( 'Suspe ndisse suscipit sagittis leo sit met condimentum estibulum issim Lorem ipsum dolor sit amet, consectetur cium', 'maxcoach' ),
				],
				[
					'title'       => esc_html__( 'Step #3', 'maxcoach' ),
					'description' => esc_html__( 'Suspe ndisse suscipit sagittis leo sit met condimentum estibulum issim Lorem ipsum dolor sit amet, consectetur cium', 'maxcoach' ),
				],
				[
					'title'       => esc_html__( 'Step #4', 'maxcoach' ),
					'description' => esc_html__( 'Suspe ndisse suscipit sagittis leo sit met condimentum estibulum issim Lorem ipsum dolor sit amet, consectetur cium', 'maxcoach' ),
				],
			],
			'title_field' => '{{{ title }}}',
		] );

		$this->end_controls_section();

		$this->add_styling_section();
	}

	private function add_styling_section() {
		$this->start_controls_section( 'styling_section', [
			'label' => esc_html__( 'Styling', 'maxcoach' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'text_align', [
			'label'     => esc_html__( 'Text Align', 'maxcoach' ),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => Widget_Utils::get_control_options_text_align(),
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .item' => 'text-align: {{VALUE}};',
			],
		] );

		$this->add_control( 'title_heading', [
			'label'     => esc_html__( 'Title', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'label'    => esc_html__( 'Typography', 'maxcoach' ),
			'selector' => '{{WRAPPER}} .title',
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Color', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .title' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'description_heading', [
			'label'     => esc_html__( 'Description', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'description_typography',
			'label'    => esc_html__( 'Typography', 'maxcoach' ),
			'selector' => '{{WRAPPER}} .description',
		] );

		$this->add_control( 'description_color', [
			'label'     => esc_html__( 'Color', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .description' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'count_number_hr', [
			'label'     => esc_html__( 'Count Number', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'count_number_typography',
			'label'    => esc_html__( 'Typography', 'maxcoach' ),
			'selector' => '{{WRAPPER}} .count',
		] );

		$this->add_control( 'count_number_color', [
			'label'     => esc_html__( 'Color', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .count' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'tm-gradation' );

		$starting_number = isset( $settings['starting_number'] ) && '' !== $settings['starting_number'] ? intval( $settings['starting_number'] ) : 1;
		?>
		<div <?php $this->print_attributes_string( 'wrapper' ); ?>>
			<?php if ( $settings['items'] && count( $settings['items'] ) > 0 ) : ?>
				<?php foreach ( $settings['items'] as $key => $item ) : ?>
					<?php
					$number_html = $starting_number;
					if ( ! empty( $settings['show_leading_zero'] ) ) {
						$number_html = str_pad( $starting_number, 2, '0', STR_PAD_LEFT );
					}
					?>
					<div class="item">
						<div class="count-wrap">
							<div class="count"><?php echo esc_html( $number_html ); ?></div>
							<div class="line"></div>
						</div>

						<div class="content-wrap">
							<?php if ( ! empty( $item['title'] ) ) : ?>
								<h5 class="title"><?php echo esc_html( $item['title'] ); ?></h5>
							<?php endif; ?>

							<?php if ( ! empty( $item['description'] ) ) : ?>
								<div class="description"><?php echo esc_html( $item['description'] ); ?></div>
							<?php endif; ?>
						</div>
					</div>
					<?php $starting_number++; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<?php
	}
}
