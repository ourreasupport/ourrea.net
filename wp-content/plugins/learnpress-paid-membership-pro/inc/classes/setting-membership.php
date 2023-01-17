<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class LP_Settings_PMPro_Membership extends LP_Abstract_Settings_Page {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->id   = 'membership';
		$this->text = __( 'Memberships', 'learnpress-paid-membership-pro' );

		parent::__construct();
	}

	public function output_section_general() {
		include LP_ADDON_PMPRO_PATH . '/inc/views/membership.php';
	}

	public function get_settings( $section = '', $tab = '' ) {
		$crojob_disabled = '';

		if ( ! LP_Addon_Paid_Memberships_Pro_Preload::$_WP_CRON_STATUS ) {
			$crojob_disabled = '<strong style="color: red">' . __( 'Cron job is disabled, please enable that', 'learnpress-paid-membership-pro' ) . '</strong>';
		}

		$desc_mode_run = __( '1. <strong>Auto</strong>: system will auto detected number courses of level and process', 'learnpress-paid-membership-pro' );
		$desc_mode_run .= '<br>' . __( '2. <strong>Normal</strong>: best for site small data', 'learnpress-paid-membership-pro' );
		$desc_mode_run .= '<br>' . __( '3. <strong>Background</strong>: run cron-job (best for site big data). After 10 second user subscription level, system LP wil update courses to LP order', 'learnpress-paid-membership-pro' );
		$desc_mode_run .= '<br>' . $crojob_disabled;

		$desc_auto_update_list_courses_on_level = __( 'LP Orders\'s users bought level PMS will update list courses when save level', 'learnpress-paid-membership-pro' );
		$desc_auto_update_list_courses_on_level .= '<br><span style="color: red">' . __( 'Note: when remove courses on list, all progress of those courses of users will lose', 'learnpress-paid-membership-pro' ) . '</span>';

		return array(
			array(
				'title' => __( 'Paid Memberships Pro add-on for LearnPress', 'learnpress-paid-membership-pro' ),
				'type'  => 'title'
			),
			array(
				'title'   => __( 'Always buy the course through membership', 'learnpress-paid-membership-pro' ),
				'id'      => 'buy_through_membership',
				'default' => 'no',
				'type'    => 'yes-no',
			),
			array(
				'title'      => __( 'Button Buy Course', 'learnpress-paid-membership-pro' ),
				'id'         => 'button_buy_course',
				'default'    => 'Buy Now',
				'type'       => 'text',
				'visibility' => array(
					'state'       => 'show',
					'conditional' => array(
						array(
							'field'   => 'buy_through_membership',
							'compare' => '!=',
							'value'   => 'yes'
						)
					)
				)
			),
			array(
				'title'   => __( 'Button Buy Membership', 'learnpress-paid-membership-pro' ),
				'id'      => 'button_buy_membership',
				'default' => 'Buy Membership',
				'type'    => 'text'
			),
			array(
				'title' => __( 'When membership access expires', 'learnpress-paid-membership-pro' ),
				'type'  => 'title'
			),
			//			array(
			//				'title'   => __( 'Preven access course', 'learnpress-paid-membership-pro' ),
			//				'id'      => 'pmpro_prevent_access_course',# mean cancel user order
			//				'default' => 'yes',
			//				'type'    => 'yes-no',
			//			),
			array(
				'title' => __( 'When membership level change', 'learnpress-paid-membership-pro' ),
				'type'  => 'title'
			),
			array(
				'title'   => __( 'Update access courses when level change list courses', 'learnpress-paid-membership-pro' ),
				'id'      => 'pmpro_update_access_course',
				'desc'    => $desc_auto_update_list_courses_on_level,
				'default' => 'no',
				'type'    => 'yes-no',
			),
			array(
				'title'   => __( 'Run mode', 'learnpress-paid-membership-pro' ),
				'id'      => 'pmpro_run_mode',
				'desc'    => $desc_mode_run,
				'default' => 'yes',
				'type'    => 'select',
				'options' => lp_pmpro_run_mode()
			),
		);
	}
}

return new LP_Settings_PMPro_Membership();