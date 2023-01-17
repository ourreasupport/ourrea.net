<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Maxcoach_LP_Lesson' ) ) {
	class Maxcoach_LP_Lesson extends Maxcoach_Post_Type {

		protected static $instance = null;

		const POST_META_VIDEO        = '_lp_video';
		const POST_META_ZOOM_MEETING = '_lp_zoom_meeting_id';

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			if ( ! Maxcoach_LP_Course::instance()->is_activated() ) {
				return;
			}

			add_filter( 'learn_press_lesson_meta_box_args', [ $this, 'add_lesson_settings' ] );

			// Add video icon to course section item meta.
			add_action( 'learn-press/course-section-item/after-lp_lesson-meta', [ $this, 'lesson_video_meta' ], 20 );
			add_action( 'learn-press/course-section-item/after-lp_lesson-meta', [
				$this,
				'lesson_zoom_meeting_meta',
			], 25 );

			// Add custom video, zoom meeting after lesson title.
			add_action( 'learn-press/before-content-item-summary/lp_lesson', [ $this, 'entry_video' ], 20 );
			add_action( 'learn-press/before-content-item-summary/lp_lesson', [ $this, 'entry_zoom_meeting' ], 30 );
		}

		public function add_lesson_settings( $settings ) {
			// Add new settings.
			$settings['fields'][] = [
				'name' => esc_html__( 'Lesson Video', 'maxcoach' ),
				'id'   => self::POST_META_VIDEO,
				'type' => 'file_input',
				'desc' => esc_html__( 'Please select a video file or paste video url here.', 'maxcoach' ),
			];

			if ( Maxcoach_Zoom_Meeting::instance()->is_activated() ) {
				$settings['fields'][] = [
					'name' => esc_html__( 'Zoom Meeting ID', 'maxcoach' ),
					'id'   => self::POST_META_ZOOM_MEETING,
					'type' => 'text',
					'desc' => esc_html__( 'Please input zoom meeting id.', 'maxcoach' ),
				];
			}

			return $settings;
		}

		/**
		 * @param LP_Lesson $item
		 */
		public function lesson_video_meta( $item ) {
			$item_id = $item->get_id();

			$video = get_post_meta( $item_id, self::POST_META_VIDEO, true );

			$video_host = array(
				'youtube.com',
				'wordpress.tv',
				'vimeo.com',
				'dailymotion.com',
				'hulu.com',
			);

			if ( ! empty( $video ) && ( Maxcoach_Helper::strposa( $video, $video_host ) ) ) {
				?>
				<span class="item-meta item-meta-icon video"><i class="far fa-video"></i></span>
				<?php
			}
		}

		/**
		 * @param LP_Lesson $item
		 */
		public function lesson_zoom_meeting_meta( $item ) {
			if ( ! Maxcoach_Zoom_Meeting::instance()->is_activated() ) {
				return;
			}

			$item_id = $item->get_id();

			$zoom_id = get_post_meta( $item_id, self::POST_META_ZOOM_MEETING, true );

			if ( ! empty( $zoom_id ) ) {
				?>
				<span class="item-meta item-meta-icon zoom-meeting"><i class="far fa-users-class"></i></span>
				<?php
			}
		}

		public function entry_video() {
			$item    = LP_Global::course_item();
			$item_id = $item->get_id();

			$video = get_post_meta( $item_id, self::POST_META_VIDEO, true );

			$video_host = array(
				'youtube.com',
				'wordpress.tv',
				'vimeo.com',
				'dailymotion.com',
				'hulu.com',
			);

			if ( ! empty( $video ) && ( Maxcoach_Helper::strposa( $video, $video_host ) ) ) {
				?>
				<div class="entry-lesson-video embed-responsive-16by9 embed-responsive">
					<?php if ( wp_oembed_get( $video ) ) { ?>
						<?php echo Maxcoach_Helper::w3c_iframe( wp_oembed_get( $video ) ); ?>
					<?php } else { ?>
						<?php Maxcoach_Helper::w3c_iframe( $video ); ?>
					<?php } ?>
				</div>
				<?php
			}
		}

		public function entry_zoom_meeting() {
			if ( ! Maxcoach_Zoom_Meeting::instance()->is_activated() ) {
				return;
			}

			$item    = LP_Global::course_item();
			$item_id = $item->get_id();

			$meeting_id = get_post_meta( $item_id, self::POST_META_ZOOM_MEETING, true );

			if ( empty( $meeting_id ) ) {
				return;
			}

			echo '<div class="entry-lesson-zoom-meeting">';
			echo do_shortcode( '[tm_zoom_meeting meeting_id="' . $meeting_id . '"]' );
			echo '</div>';
		}
	}

	Maxcoach_LP_Lesson::instance()->initialize();
}
