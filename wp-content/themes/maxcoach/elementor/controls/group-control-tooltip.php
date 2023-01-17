<?php

namespace Maxcoach_Elementor;

use Elementor\Group_Control_Base;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor tooltip control.
 *
 * A base control for creating tooltip control.
 *
 * @since 1.0.0
 */
class Group_Control_Tooltip extends Group_Control_Base {

	protected static $fields;

	public static function get_type() {
		return 'tooltip';
	}

	protected function init_fields() {
		$fields = [];

		$fields['skin'] = [
			'label'   => esc_html__( 'Tooltip Skin', 'maxcoach' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				''        => esc_html__( 'Black', 'maxcoach' ),
				'white'   => esc_html__( 'White', 'maxcoach' ),
				'primary' => esc_html__( 'Primary', 'maxcoach' ),
			],
			'default' => '',
		];

		$fields['position'] = [
			'label'   => esc_html__( 'Tooltip Position', 'maxcoach' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'top'          => esc_html__( 'Top', 'maxcoach' ),
				'right'        => esc_html__( 'Right', 'maxcoach' ),
				'bottom'       => esc_html__( 'Bottom', 'maxcoach' ),
				'left'         => esc_html__( 'Left', 'maxcoach' ),
				'top-left'     => esc_html__( 'Top Left', 'maxcoach' ),
				'top-right'    => esc_html__( 'Top Right', 'maxcoach' ),
				'bottom-left'  => esc_html__( 'Bottom Left', 'maxcoach' ),
				'bottom-right' => esc_html__( 'Bottom Right', 'maxcoach' ),
			],
			'default' => 'top',
		];

		return $fields;
	}

	protected function get_default_options() {
		return [
			'popover' => [
				'starter_title' => _x( 'Tooltip', 'Tooltip Control', 'maxcoach' ),
				'starter_name'  => 'enable',
				'starter_value' => 'yes',
				'settings'      => [
					'render_type' => 'template',
				],
			],
		];
	}
}
