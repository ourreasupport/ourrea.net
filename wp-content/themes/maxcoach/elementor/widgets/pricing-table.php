<?php

namespace Maxcoach_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || exit;

class Widget_Pricing_Table extends Base {

	public function get_name() {
		return 'tm-pricing-table';
	}

	public function get_title() {
		return esc_html__( 'Modern Pricing', 'maxcoach' );
	}

	public function get_icon_part() {
		return 'eicon-price-table';
	}

	public function get_keywords() {
		return [ 'modern', 'pricing', 'table' ];
	}

	protected function _register_controls() {
		$this->add_layout_section();

		$this->add_header_section();

		$this->add_pricing_section();

		$this->add_features_section();

		$this->add_footer_section();

		$this->add_ribbon_section();

		$this->register_common_button_style_section();
	}

	private function add_layout_section() {
		$this->start_controls_section( 'layout_section', [
			'label' => esc_html__( 'Layout', 'maxcoach' ),
		] );

		$this->add_control( 'style', [
			'label'        => esc_html__( 'Style', 'maxcoach' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				'01' => esc_html__( '01', 'maxcoach' ),
				'02' => esc_html__( '02', 'maxcoach' ),
			],
			'default'      => '01',
			'prefix_class' => 'maxcoach-pricing-style-',
		] );

		$this->end_controls_section();
	}

	private function add_header_section() {
		$this->start_controls_section( 'header_section', [
			'label' => esc_html__( 'Header', 'maxcoach' ),
		] );

		$this->add_control( 'heading', [
			'label'   => esc_html__( 'Title', 'maxcoach' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Enter your title', 'maxcoach' ),
		] );

		$this->add_control( 'sub_heading', [
			'label' => esc_html__( 'Description', 'maxcoach' ),
			'type'  => Controls_Manager::TEXT,
		] );

		$this->add_control( 'heading_tag', [
			'label'   => esc_html__( 'Heading Tag', 'maxcoach' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'h2' => 'H2',
				'h3' => 'H3',
				'h4' => 'H4',
				'h5' => 'H5',
				'h6' => 'H6',
			],
			'default' => 'h3',
		] );

		$this->end_controls_section();
	}

	private function add_pricing_section() {
		$this->start_controls_section( 'pricing_section', [
			'label' => esc_html__( 'Pricing', 'maxcoach' ),
		] );

		$this->add_control( 'currency', [
			'label'   => esc_html__( 'Currency', 'maxcoach' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '$',
		] );

		$this->add_control( 'price', [
			'label'   => esc_html__( 'Price', 'maxcoach' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '39.99',
		] );

		$this->add_control( 'period', [
			'label'   => esc_html__( 'Period', 'maxcoach' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Monthly', 'maxcoach' ),
		] );

		$this->end_controls_section();
	}

	private function add_features_section() {
		$this->start_controls_section( 'features_section', [
			'label' => esc_html__( 'Features', 'maxcoach' ),
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'text', [
			'label'       => esc_html__( 'Text', 'maxcoach' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => esc_html__( 'Text', 'maxcoach' ),
			'label_block' => true,
		] );

		$repeater->add_control( 'icon', [
			'label' => esc_html__( 'Icon', 'maxcoach' ),
			'type'  => Controls_Manager::ICONS,
		] );

		$this->add_control( 'features', [
			/*'label'       => esc_html__( 'Features', 'maxcoach' ),
			'show_label'  => false,*/
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'text' => esc_html__( 'List Item #1', 'maxcoach' ),
				],
				[
					'text' => esc_html__( 'List Item #2', 'maxcoach' ),
				],
				[
					'text' => esc_html__( 'List Item #3', 'maxcoach' ),
				],
			],
			'title_field' => '{{{ elementor.helpers.renderIcon( this, icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ text }}}',
		] );

		$this->end_controls_section();
	}

	private function add_footer_section() {
		$this->start_controls_section( 'footer_section', [
			'label' => esc_html__( 'Footer', 'maxcoach' ),
		] );

		$this->add_group_control( Group_Control_Button::get_type(), [
			'name' => 'button',
		] );

		$this->end_controls_section();
	}

	private function add_ribbon_section() {
		$this->start_controls_section( 'ribbon_section', [
			'label' => esc_html__( 'Ribbon', 'maxcoach' ),
		] );

		$this->add_control( 'show_ribbon', [
			'label' => esc_html__( 'Show', 'maxcoach' ),
			'type'  => Controls_Manager::SWITCHER,
		] );

		$this->add_control( 'ribbon_title', [
			'label'     => esc_html__( 'Title', 'maxcoach' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => esc_html__( 'Popular', 'maxcoach' ),
			'condition' => [
				'show_ribbon' => 'yes',
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'maxcoach-pricing' );

		$this->add_render_attribute( 'heading', 'class', 'title' );
		?>
		<div <?php $this->print_attributes_string( 'wrapper' ); ?>>
			<div class="inner">

				<?php $this->print_pricing_ribbon(); ?>

				<div class="maxcoach-pricing-header">
					<?php if ( ! empty( $settings['heading'] ) ) : ?>
						<div class="heading-wrap">
							<?php printf( '<%1$s %2$s>%3$s</%1$s>', $settings['heading_tag'], $this->get_render_attribute_string( 'heading' ), $settings['heading'] ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $settings['sub_heading'] ) ) : ?>
						<div class="sub-heading-wrap">
							<?php echo esc_html( $settings['sub_heading'] ); ?>
						</div>
					<?php endif; ?>
				</div>

				<?php $this->print_pricing(); ?>

				<div class="maxcoach-pricing-body">
					<?php if ( $settings['features'] && count( $settings['features'] ) > 0 ) { ?>
						<ul class="maxcoach-pricing-features">
							<?php foreach ( $settings['features'] as $item ) {
								$item_key = 'item_' . $item['_id'];
								$this->add_render_attribute( $item_key, 'class', 'item' );
								?>
								<li>
									<?php if ( ! empty( $item['icon']['value'] ) ) { ?>
										<div class="maxcoach-icon icon">
											<?php $this->render_icon( $settings, $item['icon'], [ 'aria-hidden' => 'true' ], false, 'icon' ); ?>
										</div>
									<?php } ?>
									<?php echo wp_kses( $item['text'], 'maxcoach-default' ); ?>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
				</div>

				<?php $this->print_pricing_footer(); ?>

			</div>
		</div>
		<?php
	}

	private function print_pricing_ribbon() {
		$settings = $this->get_settings_for_display();

		if ( 'yes' !== $settings['show_ribbon'] || empty( $settings['ribbon_title'] ) ) {
			return;
		}
		?>
		<div class="maxcoach-pricing-ribbon">
			<span><?php echo esc_html( $settings['ribbon_title'] ); ?></span>
		</div>
		<?php
	}

	private function print_pricing() {
		$settings = $this->get_settings_for_display();

		if ( ! isset( $settings['price'] ) || '' === $settings['price'] ) {
			return;
		}
		?>
		<div class="price-wrap">
			<div class="price-wrap-inner">

				<?php if ( ! empty( $settings['currency'] ) ) : ?>
					<div class="maxcoach-pricing-currency"><?php echo esc_html( $settings['currency'] ); ?></div>
				<?php endif; ?>

				<div class="maxcoach-pricing-price"><?php echo esc_html( $settings['price'] ); ?></div>

				<?php if ( ! empty( $settings['period'] ) && '02' !== $settings['style'] ) : ?>
					<div class="maxcoach-pricing-period"><?php echo esc_html( $settings['period'] ); ?></div>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $settings['period'] ) && '02' === $settings['style'] ) : ?>
				<div class="maxcoach-pricing-period"><?php echo esc_html( $settings['period'] ); ?></div>
			<?php endif; ?>
		</div>
		<?php
	}

	private function print_pricing_footer() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['button_text'] ) || empty( $settings['button_link'] ) ) {
			return;
		}
		?>
		<div class="maxcoach-pricing-footer">
			<?php $this->render_common_button(); ?>
		</div>
		<?php
	}
}
