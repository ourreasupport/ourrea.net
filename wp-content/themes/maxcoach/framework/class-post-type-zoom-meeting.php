<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Maxcoach_Zoom_Meeting' ) ) {
	class Maxcoach_Zoom_Meeting extends Maxcoach_Post_Type {

		protected static $instance = null;

		const    POST_TYPE                      = 'zoom-meetings';
		const    TAXONOMY_CATEGORY              = 'zoom-meeting';
		const    POST_META_MEETING_ZOOM_DETAILS = '_meeting_zoom_details';

		const    SIDEBAR_ID = 'zoom_meeting_sidebar';

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			// Do nothing if plugin not activated.
			if ( ! $this->is_activated() ) {
				return;
			}

			add_filter( 'maxcoach_custom_css_primary_color_selectors', [ $this, 'custom_css' ] );
			add_filter( 'maxcoach_customize_output_button_typography_selectors', [
				$this,
				'customize_output_button_typography_selectors',
			] );

			add_filter( 'maxcoach_customize_output_button_selectors', [
				$this,
				'customize_output_button_selectors',
			] );

			add_filter( 'maxcoach_customize_output_button_hover_selectors', [
				$this,
				'customize_output_button_hover_selectors',
			] );

			add_shortcode( 'tm_zoom_meeting', [ $this, 'shortcode_zoom_meeting' ] );

			add_action( 'pre_get_posts', array( $this, 'change_post_per_page' ) );

			// Register widget areas.
			add_action( 'widgets_init', [ $this, 'register_sidebars' ] );

			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 100 );
		}

		/**
		 * Check plugin activated.
		 *
		 * @return boolean true if plugin activated
		 */
		public function is_activated() {
			if ( defined( 'ZVC_PLUGIN_SLUG' ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Check if current page is category or tag pages
		 */
		function is_taxonomy() {
			return is_tax( get_object_taxonomies( self::POST_TYPE ) );
		}

		/**
		 * Check if current page is archive pages
		 */
		function is_archive() {
			return $this->is_taxonomy() || is_post_type_archive( self::POST_TYPE );
		}

		function is_single() {
			return is_singular( self::POST_TYPE );
		}

		/**
		 * Change number post per page of main query.
		 *
		 * @param WP_Query $query Query instance.
		 */
		public function change_post_per_page( $query ) {
			if ( $query->is_main_query() && $this->is_archive() && ! is_admin() ) {
				$number = Maxcoach::setting( 'zoom_meeting_archive_number_item', 9 );

				$query->set( 'posts_per_page', $number );
			}
		}

		public function register_sidebars() {
			$default_args = Maxcoach_Widgets::instance()->get_default_sidebar_args();

			register_sidebar( array_merge( $default_args, array(
				'id'          => self::SIDEBAR_ID,
				'name'        => esc_html__( 'Zoom Meeting Sidebar', 'maxcoach' ),
				'description' => esc_html__( 'Add widgets here.', 'maxcoach' ),
			) ) );
		}

		public function frontend_scripts() {
			wp_register_style( 'maxcoach-zoom-meetings', MAXCOACH_THEME_URI . '/video-conferencing-zoom.css', null, null );

			wp_enqueue_style( 'maxcoach-zoom-meetings' );
		}

		public function custom_css( $selectors ) {
			$selectors['color'][] = "
				.tm-zoom-meeting .zoom-countdown .countdown-content .number,
				.dpn-zvc-single-content-wrapper .dpn-zvc-sidebar-wrapper .dpn-zvc-timer .dpn-zvc-timer-cell
			";

			$selectors['background-color'][] = "
				.dpn-zvc-single-content-wrapper .dpn-zvc-sidebar-wrapper .dpn-zvc-timer .dpn-zvc-meeting-ended
			";

			return $selectors;
		}

		public function customize_output_button_typography_selectors( $selectors ) {
			$new_selectors = [ '.dpn-zvc-single-content-wrapper .dpn-zvc-sidebar-wrapper .dpn-zvc-sidebar-box .join-links .btn' ];

			$final_selectors = array_merge( $selectors, $new_selectors );

			return $final_selectors;
		}

		public function customize_output_button_selectors( $selectors ) {
			$new_selectors = [ '.dpn-zvc-single-content-wrapper .dpn-zvc-sidebar-wrapper .dpn-zvc-sidebar-box .join-links .btn' ];

			$final_selectors = array_merge( $selectors, $new_selectors );

			return $final_selectors;
		}

		public function customize_output_button_hover_selectors( $selectors ) {
			$new_selectors = [ '.dpn-zvc-single-content-wrapper .dpn-zvc-sidebar-wrapper .dpn-zvc-sidebar-box .join-links .btn:hover' ];

			$final_selectors = array_merge( $selectors, $new_selectors );

			return $final_selectors;
		}

		public function enqueue_scripts() {
			wp_register_script( 'countdown', MAXCOACH_THEME_ASSETS_URI . '/libs/jquery.countdown/js/jquery.countdown.min.js', [ 'jquery' ], '1.0.0', true );
			wp_register_script( 'maxcoach-zoom-meeting-countdown', MAXCOACH_THEME_ASSETS_URI . '/js/shortcodes/shortcode-zoom-meeting.js', [
				'jquery',
				'countdown',
			], '1.0.0', true );
		}

		public function shortcode_zoom_meeting( $atts ) {
			wp_enqueue_script( 'video-conferencing-with-zoom-api-moment' );
			wp_enqueue_script( 'video-conferencing-with-zoom-api-moment-locales' );
			wp_enqueue_script( 'video-conferencing-with-zoom-api-moment-timezone' );
			wp_enqueue_script( 'video-conferencing-with-zoom-api' );
			wp_enqueue_script( 'maxcoach-zoom-meeting-countdown' );

			extract( shortcode_atts( array(
				'meeting_id' => 'javascript:void(0);',
			), $atts ) );

			unset( $GLOBALS['vanity_uri'] );
			unset( $GLOBALS['zoom_meetings'] );

			ob_start();

			if ( empty( $meeting_id ) ) {
				echo '<h4 class="no-meeting-id"><strong style="color:red;">' . esc_html__( 'ERROR: ', 'maxcoach' ) . '</strong>' . esc_html__( 'No meeting id set in the shortcode', 'maxcoach' ) . '</h4>';

				return false;
			}

			$zoom_states = get_option( 'zoom_api_meeting_options' );
			if ( isset( $zoom_states[ $meeting_id ]['state'] ) && $zoom_states[ $meeting_id ]['state'] === "ended" ) {
				echo '<h3>' . esc_html__( 'This meeting has been ended by host.', 'maxcoach' ) . '</h3>';

				return;
			}

			$vanity_uri               = get_option( 'zoom_vanity_url' );
			$meeting                  = $this->fetch_meeting( $meeting_id );
			$GLOBALS['vanity_uri']    = $vanity_uri;
			$GLOBALS['zoom_meetings'] = $meeting;
			if ( ! empty( $meeting ) && ! empty( $meeting->code ) ) {
				?>
				<p class="dpn-error dpn-mtg-not-found"><?php echo $meeting->message; ?></p>
				<?php
			} else {
				if ( $meeting ) {
					//Get Template
					vczapi_get_template( 'shortcode/tm-zoom-meeting.php', true, false );
				} else {
					printf( esc_html__( 'Please try again ! Some error occured while trying to fetch meeting with id:  %d', 'maxcoach' ), $meeting_id );
				}
			}

			return ob_get_clean();
		}

		/**
		 * @see Zoom_Video_Conferencing_Shorcodes::fetch_meeting()
		 * @see Zoom_Video_Conferencing_Api::instance() zoom_conference()
		 * Get Meeting INFO
		 *
		 * @param $meeting_id
		 *
		 * @return bool|mixed|null
		 */
		public function fetch_meeting( $meeting_id ) {
			$transient_name = "zoom-us-fetch-meeting-id-{$meeting_id}";

			$meeting = get_transient( $transient_name );

			if ( false === $meeting ) {
				$meeting = json_decode( zoom_conference()->getMeetingInfo( $meeting_id ) );

				if ( ! empty( $meeting->error ) ) {
					return false;
				}

				set_transient( $transient_name, $meeting, apply_filters( 'maxcoach_zoom_us_fetch_meeting_cache_time', DAY_IN_SECONDS * 1 ) );
			}

			return $meeting;
		}

		/**
		 * @see    video_conference_zoom_shortcode_join_link()
		 * Generate join links
		 *
		 * @param $zoom_meetings
		 */
		public function zoom_shortcode_join_link( $zoom_meetings ) {
			if ( empty( $zoom_meetings ) ) {
				echo "<p>" . esc_html__( 'Meeting is not defined. Try updating this meeting', 'maxcoach' ) . "</p>";

				return;
			}

			$now               = new DateTime( 'now -1 hour', new DateTimeZone( $zoom_meetings->timezone ) );
			$closest_occurence = false;
			if ( ! empty( $zoom_meetings->type ) && $zoom_meetings->type === 8 && ! empty( $zoom_meetings->occurrences ) ) {
				foreach ( $zoom_meetings->occurrences as $occurrence ) {
					if ( $occurrence->status === "available" ) {
						$start_date = new DateTime( $occurrence->start_time, new DateTimeZone( $zoom_meetings->timezone ) );
						if ( $start_date >= $now ) {
							$closest_occurence = $occurrence->start_time;
							break;
						}
					}
				}
			} else if ( empty( $zoom_meetings->occurrences ) ) {
				$zoom_meetings->start_time = false;
			} else if ( ! empty( $zoom_meetings->type ) && $zoom_meetings->type === 3 ) {
				$zoom_meetings->start_time = false;
			}

			$start_time = ! empty( $closest_occurence ) ? $closest_occurence : $zoom_meetings->start_time;
			$start_time = new DateTime( $start_time, new DateTimeZone( $zoom_meetings->timezone ) );
			$start_time->setTimezone( new DateTimeZone( $zoom_meetings->timezone ) );
			if ( $now <= $start_time ) {
				unset( $GLOBALS['meetings'] );

				if ( ! empty( $zoom_meetings->password ) ) {
					$browser_join = vczapi_get_browser_join_shortcode( $zoom_meetings->id, $zoom_meetings->password, true );
				} else {
					$browser_join = vczapi_get_browser_join_shortcode( $zoom_meetings->id, false, true );
				}

				$join_url            = ! empty( $zoom_meetings->encrypted_password ) ? vczapi_get_pwd_embedded_join_link( $zoom_meetings->join_url, $zoom_meetings->encrypted_password ) : $zoom_meetings->join_url;
				$GLOBALS['meetings'] = array(
					'join_uri'    => apply_filters( 'vczoom_join_meeting_via_app_shortcode', $join_url, $zoom_meetings ),
					'browser_url' => apply_filters( 'vczoom_join_meeting_via_browser_disable', $browser_join ),
				);
				vczapi_get_template( 'shortcode/tm-join-links.php', true, false );
			}
		}
	}

	Maxcoach_Zoom_Meeting::instance()->initialize();
}
