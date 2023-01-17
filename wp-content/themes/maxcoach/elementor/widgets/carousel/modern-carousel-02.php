<?php

namespace Maxcoach_Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

defined( 'ABSPATH' ) || exit;

class Widget_Modern_Carousel_02 extends Carousel_Base {

	public function get_name() {
		return 'tm-modern-carousel-02';
	}

	public function get_title() {
		return esc_html__( 'Modern Carousel 02', 'maxcoach' );
	}

	public function get_icon_part() {
		return 'eicon-posts-carousel';
	}

	public function get_keywords() {
		return [ 'modern', 'carousel' ];
	}

	protected function _register_controls() {
		$this->add_content_section();

		$this->add_style_section();

		parent::_register_controls();

		$this->update_controls();
	}

	private function update_controls() {
		$this->update_responsive_control( 'swiper_items', [
			'default'        => '1',
			'tablet_default' => '1',
			'mobile_default' => '1',
		] );

		$this->update_responsive_control( 'swiper_gutter', [
			'default' => 30,
		] );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'maxcoach-modern-carousel-02' );
		?>
		<div <?php $this->print_attributes_string( 'wrapper' ); ?>>
			<?php $this->print_slider( $settings ); ?>
		</div>
		<?php
	}

	private function add_content_section() {
		$this->start_controls_section( 'content_section', [
			'label' => esc_html__( 'Content', 'maxcoach' ),
		] );

		$this->add_control( 'style', [
			'label'        => esc_html__( 'Style', 'maxcoach' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => array(
				'01' => '01',
			),
			'default'      => '01',
			'prefix_class' => 'maxcoach-modern-carousel-02-style-',
			'render_type'  => 'template',
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

		$this->add_control( 'link_click', [
			'label'   => esc_html__( 'Apply Link On', 'maxcoach' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'box'    => esc_html__( 'Whole Slide', 'maxcoach' ),
				'button' => esc_html__( 'Button Only', 'maxcoach' ),
			],
			'default' => 'button',
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'image', [
			'label'   => esc_html__( 'Image', 'maxcoach' ),
			'type'    => Controls_Manager::MEDIA,
			'default' => [
				'url' => Utils::get_placeholder_image_src(),
			],
		] );

		$repeater->add_control( 'title', [
			'label'       => esc_html__( 'Title', 'maxcoach' ),
			'type'        => Controls_Manager::TEXTAREA,
			'dynamic'     => [
				'active' => true,
			],
			'placeholder' => esc_html__( 'Enter your title', 'maxcoach' ),
			'default'     => esc_html__( 'Add Your Heading Text Here', 'maxcoach' ),
		] );

		$repeater->add_control( 'decorate_text', [
			'label' => esc_html__( 'Decorate Text', 'maxcoach' ),
			'type'  => Controls_Manager::TEXTAREA,
		] );

		$repeater->add_control( 'description', [
			'label' => esc_html__( 'Description', 'maxcoach' ),
			'type'  => Controls_Manager::TEXTAREA,
		] );

		$repeater->add_control( 'button_text', [
			'label' => esc_html__( 'Button Text', 'maxcoach' ),
			'type'  => Controls_Manager::TEXT,
		] );

		$repeater->add_control( 'link', [
			'label'       => esc_html__( 'Link', 'maxcoach' ),
			'type'        => Controls_Manager::URL,
			'dynamic'     => [
				'active' => true,
			],
			'placeholder' => esc_html__( 'https://your-link.com', 'maxcoach' ),
		] );

		$this->add_control( 'slides', [
			'label'       => esc_html__( 'Slides', 'maxcoach' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'title'       => 'Automatic Updates',
					'description' => 'Lorem ipsum dolor sit amet, consect etur elit. Suspe ndisse suscipit',
				],
				[
					'title'       => 'Flexible Options',
					'description' => 'Lorem ipsum dolor sit amet, consect etur elit. Suspe ndisse suscipit',
				],
				[
					'title'       => 'Lifetime Use',
					'description' => 'Lorem ipsum dolor sit amet, consect etur elit. Suspe ndisse suscipit',
				],
			],
			'title_field' => '{{{ title }}}',
		] );

		$this->end_controls_section();
	}

	private function add_style_section() {
		$this->start_controls_section( 'style_section', [
			'label' => esc_html__( 'Style', 'maxcoach' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'slide_wrapper_heading', [
			'label' => esc_html__( 'Wrapper', 'maxcoach' ),
			'type'  => Controls_Manager::HEADING,
		] );

		$this->add_responsive_control( 'text_align', [
			'label'       => esc_html__( 'Text Align', 'maxcoach' ),
			'label_block' => true,
			'type'        => Controls_Manager::CHOOSE,
			'options'     => Widget_Utils::get_control_options_text_align(),
			'default'     => '',
			'selectors'   => [
				'{{WRAPPER}} .slide-content' => 'text-align: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'slide_wrapper_padding', [
			'label'      => esc_html__( 'Padding', 'maxcoach' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .slide-layers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'box_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'maxcoach' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .maxcoach-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_control( 'image_style_heading', [
			'label'     => esc_html__( 'Image', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'image_border_color', [
			'label'     => esc_html__( 'Border Color', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .image-frame' => 'color: {{VALUE}};',
			],
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
				'{{WRAPPER}} .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
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

		$this->add_control( 'title_hover_color', [
			'label'     => esc_html__( 'Hover Color', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .title:hover' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'description_style_heading', [
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
			'label'     => esc_html__( 'Text Color', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .description' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'decorate_text_style_heading', [
			'label'     => esc_html__( 'Decorate', 'maxcoach' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'decorate_text_typography',
			'label'    => esc_html__( 'Typography', 'maxcoach' ),
			'selector' => '{{WRAPPER}} .slide-decorate-text',
		] );

		$this->add_control( 'decorate_text_color', [
			'label'     => esc_html__( 'Text Color', 'maxcoach' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .slide-decorate-text' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_section();
	}

	protected function print_slides( array $settings ) {

		foreach ( $settings['slides'] as $slide ) :
			$slide_id = $slide['_id'];
			$item_key = 'item_' . $slide_id;
			$box_key = 'box_' . $slide_id;
			$box_tag = 'div';

			$pattern_id = 'pattern_' . $slide_id;

			$this->add_render_attribute( $item_key, 'class', [
				'swiper-slide',
				'elementor-repeater-item-' . $slide_id,
			] );

			$this->add_render_attribute( $box_key, 'class', 'maxcoach-box slide-wrapper' );

			if ( ! empty( $slide['link']['url'] ) && 'box' === $settings['link_click'] ) {
				$box_tag = 'a';
				$this->add_render_attribute( $box_key, 'class', 'link-secret' );
				$this->add_link_attributes( $box_key, $slide['link'] );
			}
			?>
			<div <?php $this->print_attributes_string( $item_key ); ?>>
				<?php printf( '<%1$s %2$s>', $box_tag, $this->get_render_attribute_string( $box_key ) ); ?>
				<div class="slide-image maxcoach-image">
					<?php
					$image_url = \Maxcoach_Image::get_elementor_attachment( [
						'settings'      => $slide,
						'size_settings' => $settings,
						'url'           => true,
					] );
					?>
					<svg class="image-frame" width="470px" height="491px" viewBox="0 0 470 491" version="1.1"
					     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
						<path stroke="#BAD2DE" stroke-width="2" fill="none"
						      d="M386.030035,488.81143 C373.595816,488.437799 363.766055,487.34952 355.221231,486.40405 C347.412451,485.540022 340.668294,484.796172 333.99778,484.810981 C305.201413,484.874911 278.759269,486.081653 254.985173,487.166863 C231.658467,488.231651 210.90449,489.179931 193.020614,488.811191 C131.114472,487.534776 94.1406728,484.882428 82.115496,480.794963 L1,488.70867 L1,1.97325001 L52.9888668,9.82062614 C78.9518751,6.47880224 120.955768,4.81097882 179,4.81097882 C187.259705,4.81097882 195.43365,4.7949173 203.494372,4.77907764 C258.976038,4.6700538 309.088322,4.56626245 344.855201,9.80043989 C355.108391,11.3009068 367.189568,9.09377152 381.305656,6.48659928 C390.646953,4.76130753 400.889323,2.86849373 412.094354,1.80651754 C423.342547,0.740450573 442.31123,0.731456338 469.000012,1.77241485 L469.005761,488.82159 C428.358877,489.255382 400.700297,489.252251 386.030035,488.81143 Z"></path>
					</svg>
					<svg class="image-pattern" width="470px" height="491px" viewBox="0 0 470 491" version="1.1"
					     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
						<defs>
							<pattern id="<?php echo esc_attr( $pattern_id ); ?>" patternUnits="userSpaceOnUse"
							         width="100%" height="100%">
								<image
									xlink:href="<?php echo esc_url( $image_url ); ?>"
									x="0" y="0" width="100%" height="100%" preserveAspectRatio="xMinYMin slice"/>
							</pattern>
						</defs>
						<g stroke-width="0" fill="url(#<?php echo esc_attr( $pattern_id ); ?>)">
							<path
								d="M0,0.810978821 L53,8.81097882 C79,5.47764549 121,3.81097882 179,3.81097882 C244.169633,3.81097882 304,2.81097882 345,8.81097882 C361.968282,11.2941421 383.984123,3.46623196 412,0.810978821 C423.408973,-0.270326274 442.742306,-0.270326274 470,0.810978821 L470,489.810979 C428.795464,490.255562 400.795464,490.255562 386,489.810979 C362.23049,489.096738 347.953625,485.780001 334,485.810979 C276.934768,485.937668 229.119825,490.555717 193,489.810979 C131.262618,488.538043 94.2626177,485.871376 82,481.810979 L0,489.810979 L0,0.810978821 Z"></path>
						</g>
					</svg>
				</div>

				<div class="slide-content">
					<?php if ( ! empty( $slide['decorate_text'] ) ) : ?>
						<div class="slide-decorate-text">
							<?php echo esc_html( $slide['decorate_text'] ); ?>
						</div>
					<?php endif; ?>

					<div class="slide-layers">
						<?php if ( ! empty( $slide['title'] ) ) : ?>
							<div class="slide-layer-wrap title-wrap">
								<div class="slide-layer">
									<h3 class="title"><?php echo wp_kses( $slide['title'], 'maxcoach-default' ); ?></h3>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $slide['description'] ) ) : ?>
							<div class="slide-layer-wrap description-wrap">
								<div class="slide-layer">
									<div
										class="description"><?php echo esc_html( $slide['description'] ); ?></div>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $slide['button_text'] ) ) : ?>
							<div class="slide-layer-wrap button-wrap">
								<div class="slide-layer">
									<?php
									$button_args = [
										'text' => $slide['button_text'],
									];

									if ( ! empty( $slide['link']['url'] ) && 'button' === $settings['link_click'] ) {
										$button_args['link'] = [
											'url' => $slide['link']['url'],
										];
									}

									\Maxcoach_Templates::render_button( $button_args );
									?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<?php printf( '</%1$s>', $box_tag ); ?>
			</div>
		<?php endforeach;
	}
}
