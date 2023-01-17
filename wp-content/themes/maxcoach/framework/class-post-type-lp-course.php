<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Maxcoach_LP_Course' ) ) {
	class Maxcoach_LP_Course extends Maxcoach_Post_Type {

		protected static $instance = null;
		const POST_TYPE            = 'lp_course';
		const TAXONOMY_CATEGORY    = 'course_category';
		const TAXONOMY_TAGS        = 'course_tag';
		const POST_META_STUDENTS   = '_lp_students';
		const POST_META_PRICE      = '_lp_price';
		const POST_META_SALE_PRICE = '_lp_sale_price';

		/**
		 * custom post meta, used for ordering on archive pages.
		 */
		const CUSTOM_POST_META_SORT_PRICE = '_lp_sort_price';

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			if ( ! $this->is_activated() ) {
				return;
			}

			$this->change_single_components();

			$this->change_archive_components();

			$this->change_become_a_teacher_components();

			$this->change_profile_components();

			/**
			 * Add more setting for password on register form.
			 */
			add_filter( 'learn-press/settings/profile', [ $this, 'add_user_profile_password_settings' ], 10, 1 );

			/**
			 * Changed validate with custom settings.
			 */
			add_filter( 'learn-press/register-validate-field', [ $this, 'better_register_validate_field' ], 20, 3 );

			/**
			 * Update password field description among settings.
			 */
			add_filter( 'learn-press/register-fields', [ $this, 'change_register_form_fields' ] );

			add_filter( 'learn_press_course_price_html_free', [ $this, 'change_course_free_price' ], 99, 2 );
			add_filter( 'learn_press_course_origin_price_html', [ $this, 'add_wrapper_decimals_separator' ], 99, 1 );
			add_filter( 'learn_press_course_price_html', [ $this, 'add_wrapper_decimals_separator' ], 99, 1 );

			add_filter( 'maxcoach_sidebar_1', [ $this, 'remove_sidebar_for_sticky_layout' ] );

			add_action( 'maxcoach/title-bar-meta', [ $this, 'add_title_bar_meta_course_instructor' ] );
			add_action( 'maxcoach/title-bar-meta', [ $this, 'add_title_bar_meta_course_duration' ] );
			add_action( 'maxcoach/title-bar-meta', [ $this, 'add_title_bar_meta_course_lesson' ] );
			add_action( 'maxcoach/title-bar-meta', [ $this, 'add_title_bar_meta_course_student' ] );

			// Remove learn paid membership css.
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 99 );

			// Remove css bundle.
			add_filter( 'learn-press/frontend-default-styles', [ $this, 'remove_css_bundle' ] );

			add_filter( 'learn_press_course_settings_meta_box_args', [ $this, 'add_fields_to_meta_box' ] );

			// Adds custom classes to the array of body classes.
			add_filter( 'body_class', [ $this, 'body_classes' ] );

			// Add gutenberg editor for course & lesson.
			//add_filter( 'register_post_type_args', [ $this, 'add_gutenberg_support' ], 10, 2 );

			add_filter( 'pre_get_posts', [ $this, 'change_main_loop_courses_query' ] );

			add_action( 'wp_ajax_lp_course_infinite_load', [ $this, 'infinite_load' ] );
			add_action( 'wp_ajax_nopriv_lp_course_infinite_load', [ $this, 'infinite_load' ] );

			/**
			 * Add course meta price sort.
			 * Used priority 9999 to sure run after cmb2 plugin, make sure post meta saved.
			 */
			add_action( 'save_post_' . self::POST_TYPE, [ $this, 'save_post' ], 9999, 1 );

			/**
			 * Remove adv from leanpress.
			 */
			remove_action( 'admin_footer', 'learn_press_footer_advertisement', -10 );

			// Change button back to class style.
			remove_action( 'learn-press/after-checkout-form', 'learn_press_back_to_class_button' );
			remove_action( 'learn-press/after-empty-cart-message', 'learn_press_back_to_class_button' );
			add_action( 'learn-press/after-checkout-form', [ $this, 'back_to_class_button' ] );
			add_action( 'learn-press/after-empty-cart-message', [ $this, 'back_to_class_button' ] );
		}

		/**
		 *
		 * Plugin return empty instead of Free text.
		 * @param $text
		 * @param $course
		 *
		 * @return string
		 */
		public function change_course_free_price( $text, $course ) {
			return esc_html__( 'Free', 'maxcoach' );
		}

		public function back_to_class_button() {
			$courses_link = learn_press_get_page_link( 'courses' );
			if ( ! $courses_link ) {
				return;
			}

			Maxcoach_Templates::render_button( [
				'link'          => [
					'url' => esc_url( $courses_link ),
				],
				'text'          => esc_html__( 'Back to class', 'maxcoach' ),
				'icon'          => 'fal fa-long-arrow-left',
				'wrapper_class' => 'btn-back-to-class',
			] );
			?>
			<?php
		}

		public function change_register_form_fields( $fields ) {
			if ( isset( $fields['reg_password'] ) ) {
				$password_length       = LP()->settings->get( 'enable_password_length', 'yes' );
				$password_capitalized  = LP()->settings->get( 'enable_password_capitalized_letter', 'yes' );
				$password_number       = LP()->settings->get( 'enable_password_number', 'yes' );
				$password_special_char = LP()->settings->get( 'enable_password_special_character', 'yes' );

				$password_description = '';

				if ( 'yes' === $password_length ) {
					$password_description .= __( ' at least twelve characters long,', 'maxcoach' );
				}

				if ( 'yes' === $password_capitalized ) {
					$password_description .= __( ' contain upper and lower case letters,', 'maxcoach' );
				}

				if ( 'yes' === $password_number ) {
					$password_description .= __( ' contain numbers,', 'maxcoach' );
				}

				if ( 'yes' === $password_special_char ) {
					$password_description .= __( ' contain symbols like ! " ? $ % ^ & ),', 'maxcoach' );
				}

				if ( ! empty( $password_description ) ) {
					$password_description = __( 'The password must be', 'maxcoach' ) . $password_description;

					$password_description = rtrim( $password_description, ',' );
					$password_description .= '.';
				}

				$fields['reg_password']['desc'] = $password_description;
			}

			return $fields;
		}

		public function better_register_validate_field( $name, $field, $value ) {
			$validate = empty( $value ) ? false : true;

			if ( $validate && $field['id'] === 'reg_password' ) {
				$password_length       = LP()->settings->get( 'enable_password_length', 'yes' );
				$password_capitalized  = LP()->settings->get( 'enable_password_capitalized_letter', 'yes' );
				$password_number       = LP()->settings->get( 'enable_password_number', 'yes' );
				$password_special_char = LP()->settings->get( 'enable_password_special_character', 'yes' );

				try {
					if ( 'yes' === $password_length && strlen( $value ) < 6 ) {
						throw new Exception( __( 'Password is too short!', 'maxcoach' ), 100 );
					}

					if ( preg_match( '#\s+#', $value ) ) {
						throw new Exception( __( 'Password can not have spacing!', 'maxcoach' ), 110 );
					}

					if ( ! preg_match( "#[a-zA-Z]+#", $value ) ) {
						throw new Exception( __( 'Password must include at least one letter!', 'maxcoach' ), 120 );
					}

					if ( 'yes' === $password_capitalized && ! preg_match( "#[A-Z]+#", $value ) ) {
						throw new Exception( __( 'Password must include at least one capitalized letter!', 'maxcoach' ), 125 );
					}

					if ( 'yes' === $password_number && ! preg_match( "#[0-9]+#", $value ) ) {
						throw new Exception( __( 'Password must include at least one number!', 'maxcoach' ), 125 );
					}

					if ( 'yes' === $password_special_char && ! preg_match( '#[~!@\#$%^&*()]#', $value ) ) {
						throw new Exception( __( 'Password must include at least one of these characters ~!@#$%^&*() !', 'maxcoach' ), 125 );
					}
				} catch ( Exception $ex ) {
					$validate = new WP_Error( $ex->getCode(), $ex->getMessage() );
				}
			}

			return $validate;
		}

		public function add_user_profile_password_settings( $settings ) {
			$new_settings = array(
				array(
					'title' => esc_html__( 'Password Strength', 'maxcoach' ),
					'type'  => 'heading',
					'desc'  => esc_html__( 'Controls the password strength on register form.', 'maxcoach' ),
				),
				array(
					'title'   => esc_html__( 'Password length', 'maxcoach' ),
					'desc'    => esc_html__( 'Force user register with password length greater than 6 letters.', 'maxcoach' ),
					'id'      => 'enable_password_length',
					'default' => 'yes',
					'type'    => 'yes-no',
				),
				array(
					'title'   => esc_html__( 'Password capitalized letter', 'maxcoach' ),
					'desc'    => esc_html__( 'Force user register with password at least one capitalized letter.', 'maxcoach' ),
					'id'      => 'enable_password_capitalized_letter',
					'default' => 'yes',
					'type'    => 'yes-no',
				),
				array(
					'title'   => esc_html__( 'Password number', 'maxcoach' ),
					'desc'    => esc_html__( 'Force user register with password at least one number.', 'maxcoach' ),
					'id'      => 'enable_password_number',
					'default' => 'yes',
					'type'    => 'yes-no',
				),
				array(
					'title'   => esc_html__( 'Password special character', 'maxcoach' ),
					'desc'    => esc_html__( 'Force user register with password at least one of these characters ~!@#$%^&*() ', 'maxcoach' ),
					'id'      => 'enable_password_special_character',
					'default' => 'yes',
					'type'    => 'yes-no',
				),
			);

			$settings = array_merge( $settings, $new_settings );

			return $settings;
		}

		public function enqueue_scripts() {
			wp_dequeue_style( 'learn-press-pmpro-style' );
		}

		public function change_profile_components() {
			/**
			 * Tab Dashboard.
			 */
			// Remove author bio.
			remove_action( 'learn-press/profile/dashboard-summary', 'learn_press_profile_dashboard_user_bio', 10 );

			add_action( 'learn-press/profile/dashboard-summary', [
				$this,
				'profile_dashboard_user_courses_count',
			], 10 );

			add_action( 'learn-press/profile/dashboard-summary', [
				$this,
				'profile_dashboard_user_courses_progress',
			], 20 );
		}

		public function profile_dashboard_user_courses_count() {
			/**
			 * @var LP_Profile          $profile
			 * @var LP_User_Item_Course $user_course
			 * @var LP_User_Item_Quiz   $user_quiz
			 */
			$profile = learn_press_get_profile();

			$completed_courses   = 0;
			$in_progress_courses = 0;
			$completed_quizzes   = 0;
			$in_progress_quizzes = 0;

			$courses_query = $profile->query_courses( 'purchased' );

			if ( ! empty( $courses_query['items'] ) ) {
				foreach ( $courses_query['items'] as $user_course ) {
					$course_status = $user_course->get_results( 'status' );

					switch ( $course_status ) {
						case 'in-progress' :
							$in_progress_courses++;
							break;
						case 'passed' :
							$completed_courses++;
							break;
					}
				}
			}

			$quizzes_query = $profile->query_quizzes();

			if ( ! empty( $quizzes_query['items'] ) ) {
				foreach ( $quizzes_query['items'] as $user_quiz ) {
					$quiz_status = $user_quiz->get_results( 'status' );

					switch ( $quiz_status ) {
						case 'started' :
							$in_progress_quizzes++;
							break;
						case 'completed' :
							$completed_quizzes++;
							break;
					}
				}
			}

			$completed_courses_number   = str_pad( $completed_courses, 2, '0', STR_PAD_LEFT );
			$in_progress_courses_number = str_pad( $in_progress_courses, 2, '0', STR_PAD_LEFT );
			$completed_quizzes_number   = str_pad( $completed_quizzes, 2, '0', STR_PAD_LEFT );
			$in_progress_quizzes_number = str_pad( $in_progress_quizzes, 2, '0', STR_PAD_LEFT );
			?>

			<div class="profile-progress-status">
				<div class="row">
					<div class="col-md-3 col-sm-6">
						<div class="status-box success courses-completed">
							<div class="status-number"><?php echo esc_html( $completed_courses_number ); ?></div>
							<h6 class="status-text"><?php esc_html_e( 'Courses Completed', 'maxcoach' ); ?></h6>
						</div>
					</div>
					<div class="col-md-3 col-sm-6">
						<div class="status-box warning courses-in-progress">
							<div class="status-number"><?php echo esc_html( $in_progress_courses_number ); ?></div>
							<h6 class="status-text"><?php esc_html_e( 'Courses In Progress', 'maxcoach' ); ?></h6>
						</div>
					</div>
					<div class="col-md-3 col-sm-6">
						<div class="status-box info quizzes-completed">
							<div class="status-number"><?php echo esc_html( $completed_quizzes_number ); ?></div>
							<h6 class="status-text"><?php esc_html_e( 'Quizzes Completed', 'maxcoach' ); ?></h6>
						</div>
					</div>
					<div class="col-md-3 col-sm-6">
						<div class="status-box error courses-completed">
							<div class="status-number"><?php echo esc_html( $in_progress_quizzes_number ); ?></div>
							<h6 class="status-text"><?php esc_html_e( 'Quizzes  In Progress', 'maxcoach' ); ?></h6>
						</div>
					</div>
				</div>
			</div>
			<?php
		}

		public function profile_dashboard_user_courses_progress() {
			/**
			 * @var LP_Profile          $profile
			 * @var LP_User_Item_Course $user_course
			 */
			$profile = learn_press_get_profile();

			$courses_query = $profile->query_courses( 'purchased' );

			if ( $courses_query['items'] ) {
				?>
				<div class="profile-courses-progress">
					<h3 class="profile-courses-heading"><?php esc_html_e( 'Courses progress', 'maxcoach' ); ?></h3>

					<div class="maxcoach-progress style-01">
						<?php
						foreach ( $courses_query['items'] as $user_course ) {
							// Setup.
							$course         = learn_press_get_course( $user_course->get_id() );
							$percent_result = $user_course->get_percent_result();
							?>

							<div class="single-progress-bar">
								<h4 class="progress-title"><?php echo esc_html( $course->get_title() ); ?></h4>
								<div class="progress-bar-wrap">
									<div class="progress-bar" style="width: <?php echo esc_attr( $percent_result ); ?>">
										<div class="progress-value"><?php echo esc_html( $percent_result ); ?></div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>

				</div>
				<?php
			}
		}

		/**
		 * Custom Become a teacher form.
		 */
		public function change_become_a_teacher_components() {
			// Remove form title.
			remove_action( 'learn-press/before-become-teacher-form', 'learn_press_become_teacher_heading', 10 );


			// Show form for all users.
			remove_action( 'learn-press/become-teacher-form', 'learn_press_become_teacher_form_fields', 5 );
			remove_action( 'learn-press/after-become-teacher-form', 'learn_press_become_teacher_button', 10 );

			add_action( 'learn-press/become-teacher-form', [ $this, 'become_teacher_form_fields' ], 5 );
			add_action( 'learn-press/after-become-teacher-form', [ $this, 'become_teacher_button' ], 10 );
		}

		public function become_teacher_form_fields() {
			learn_press_get_template( 'global/become-teacher-form/form-fields.php', array( 'fields' => learn_press_get_become_a_teacher_form_fields() ) );
		}

		public function become_teacher_button() {
			learn_press_get_template( 'global/become-teacher-form/button.php' );
		}

		public function infinite_load() {
			$source     = isset( $_POST['source'] ) ? $_POST['source'] : '';
			$query_vars = $_POST['query_vars'];

			if ( 'custom_query' === $source ) {
				$query_vars = $this->build_extra_terms_query( $query_vars, $query_vars['extra_tax_query'] );
			}

			$maxcoach_query = new WP_Query( $query_vars );

			$settings = isset( $_POST['settings'] ) ? $_POST['settings'] : array();

			$response = array(
				'max_num_pages' => $maxcoach_query->max_num_pages,
				'found_posts'   => $maxcoach_query->found_posts,
				'count'         => $maxcoach_query->post_count,
			);

			ob_start();

			if ( $maxcoach_query->have_posts() ) :
				learn_press_setup_user();
				set_query_var( 'maxcoach_query', $maxcoach_query );
				set_query_var( 'settings', $settings );

				get_template_part( 'loop/widgets/course/style', $settings['layout'] );

				wp_reset_postdata();
			endif;

			$template = ob_get_contents();
			ob_clean();

			$template = preg_replace( '~>\s+<~', '><', $template );

			$response['template'] = $template;

			echo json_encode( $response );

			wp_die();
		}

		public function get_setting( $name ) {
			/**
			 * @var LP_Settings $settings
			 */
			$settings = LP()->settings;

			$setting = $settings->get( $name );

			return $setting;
		}

		/**
		 * Add html tag wrap decimal separator.
		 *
		 * @param string $origin_price
		 *
		 * @return mixed
		 */
		public function add_wrapper_decimals_separator( $origin_price ) {
			$number_decimal     = intval( $this->get_setting( 'number_of_decimals' ) );
			$decimals_separator = $this->get_setting( 'decimals_separator' );

			if ( $number_decimal > 0 && ! empty( $decimals_separator ) ) {
				$dec_position = strpos( $origin_price, $decimals_separator );
				$dec_part     = substr( $origin_price, $dec_position, $number_decimal + 1 );
				$dec_template = '<span class="decimals-separator">' . $dec_part . '</span>';
				$origin_price = str_replace( $dec_part, $dec_template, $origin_price );
			}

			return $origin_price;
		}

		/**
		 * @param int $post_ID
		 */
		public function save_post( $post_ID ) {
			$sort_price = 0;
			$sale_price = get_post_meta( $post_ID, self::POST_META_SALE_PRICE, true );

			if ( '' !== $sale_price ) {
				$sort_price = $sale_price;

			} else {
				$price = get_post_meta( $post_ID, self::POST_META_PRICE, true );
				if ( '' !== $price ) {
					$sort_price = $price;
				}
			}

			update_post_meta( $post_ID, self::CUSTOM_POST_META_SORT_PRICE, $sort_price );
		}

		public function get_ordering_options() {
			return [
				'popularity' => esc_html__( 'Popularity', 'maxcoach' ),
				'date'       => esc_html__( 'Latest', 'maxcoach' ),
				'price'      => esc_html__( 'Price: low to high', 'maxcoach' ),
				'price-desc' => esc_html__( 'Price: high to low', 'maxcoach' ),
			];
		}

		public function get_ordering_selected_option() {
			$order_by = ! empty( $_GET['orderby'] ) ? $_GET['orderby'] : 'date';

			return $order_by;
		}

		/**
		 * @param WP_Query $query
		 */
		public function change_main_loop_courses_query( $query ) {
			if ( ! $query->is_main_query() || ! $this->is_archive() || is_admin() ) {
				return;
			}

			// Custom sort order.
			$orderby = isset( $_GET['orderby'] ) ? $_GET['orderby'] : false;
			if ( ! empty( $orderby ) ) {
				switch ( $orderby ) {
					case 'popularity':
						$query->set( 'meta_key', self::POST_META_STUDENTS );
						$query->set( 'orderby', 'meta_value' );
						$query->set( 'order', 'DESC' );
						break;
					case 'date':
						$query->set( 'orderby', 'date' );
						break;
					case 'price':
						$query->set( 'meta_key', self::CUSTOM_POST_META_SORT_PRICE );
						$query->set( 'orderby', 'meta_value title' );
						$query->set( 'order', 'ASC' );
						break;
					case 'price-desc':
						$query->set( 'meta_key', self::CUSTOM_POST_META_SORT_PRICE );
						$query->set( 'orderby', 'meta_value title' );
						$query->set( 'order', 'DESC' );
						break;
				}
			}
		}

		public function change_archive_components() {
			remove_action( 'learn-press/before-main-content', 'learn_press_search_form', 15 );

			/**
			 * @action learn-press/after-courses-loop-item
			 *
			 * @hooked
			 * @see    learn_press_courses_loop_item_begin_meta - 10
			 * @see    learn_press_courses_loop_item_price - 20
			 * @see    learn_press_courses_loop_item_instructor - 25
			 * @see    learn_press_courses_loop_item_end_meta - 30
			 * @see    learn_press_course_loop_item_buttons - 35
			 * @see    learn_press_course_loop_item_user_progress - 40
			 */
			// Move title into meta.
			remove_action( 'learn-press/courses-loop-item-title', 'learn_press_courses_loop_item_title', 15 );
			add_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_title', 21 );

			// Remove components
			remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_instructor', 25 );
			remove_action( 'learn-press/after-courses-loop-item', 'learn_press_course_loop_item_buttons', 35 );
			remove_action( 'learn-press/after-courses-loop-item', 'learn_press_course_loop_item_user_progress', 40 );

			// Add Extra components.
			add_action( 'learn-press/after-courses-loop-item', [ $this, 'add_loop_course_meta_open' ], 25 );
			add_action( 'learn-press/after-courses-loop-item', [ $this, 'add_loop_course_meta_lesson' ], 30 );
			add_action( 'learn-press/after-courses-loop-item', [ $this, 'add_loop_course_meta_student' ], 35 );
			add_action( 'learn-press/after-courses-loop-item', [ $this, 'add_loop_course_meta_close' ], 40 );

			// Move meta close tag to wrap all components.
			remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_end_meta', 30 );
			add_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_end_meta', 50 );

			add_filter( 'learn_press_pagination_args', [ $this, 'change_pagination_args' ] );
		}

		public function change_pagination_args( $args ) {
			$args['prev_text'] = Maxcoach_Templates::get_pagination_prev_text();
			$args['next_text'] = Maxcoach_Templates::get_pagination_next_text();

			return $args;
		}

		public function add_title_bar_meta_course_instructor() {
			/**
			 * @var LP_Course        $course
			 * @var LP_Abstract_User $instructor
			 */
			$course     = LP_Global::course();
			$instructor = $course->get_instructor();
			?>
			<div class="course-instructor post-author">
				<span class="meta-icon meta-image">
					<?php Maxcoach_Helper::e( $instructor->get_profile_picture( '', 32 ) ); ?>
				</span>
				<span class="meta-value"><?php echo ent2ncr( $instructor->get_display_name() ); ?></span>
			</div>
			<?php
		}

		public function add_title_bar_meta_course_duration() {
			$duration = $this->get_duration_translatable();

			if ( empty( $duration ) ) {
				return;
			}
			?>
			<div class="course-duration">
				<span class="meta-icon far fa-clock"></span>
				<span class="meta-value"><?php echo esc_html( $duration ); ?></span>
			</div>
			<?php
		}

		public function add_title_bar_meta_course_lesson() {
			$course      = LP_Global::course();
			$count_items = $course->count_items();

			if ( empty( $count_items ) ) {
				return;
			}

			$count_items = intval( $count_items );
			?>
			<div class="course-lesson">
				<span class="meta-icon far fa-file-alt"></span>
				<span class="meta-value">
					<?php
					printf( _n( '%s Lesson', '%s Lessons', $count_items, 'maxcoach' ), number_format_i18n( $count_items ) );
					?>
				</span>
			</div>
			<?php
		}

		public function add_title_bar_meta_course_student() {
			$course = LP_Global::course();
			if ( ! $course || ! $course->is_required_enroll() ) {
				return;
			}

			$count = intval( $course->count_students() );
			?>

			<div class="course-students">
				<span class="meta-icon far fa-user-alt"></span>
				<span class="meta-value">
					<?php printf( _n( '%s Student', '%s Students', $count, 'maxcoach' ), number_format_i18n( $count ) ); ?>
				</span>
			</div>
			<?php
		}

		public function body_classes( $classes ) {
			if ( is_singular( self::POST_TYPE ) ) {
				$layout = $this->get_single_layout();

				$classes[] = 'single-course-layout-' . $layout;
			}

			return $classes;
		}

		public function add_gutenberg_support( $args, $post_type ) {
			if ( in_array( $post_type, [ 'lp_course', 'lp_lesson', ] ) ) {
				$args['show_in_rest'] = true;
			}

			return $args;
		}

		/**
		 * Remove font awesome 4.x.x. rewrite style in theme.
		 *
		 * @param $handles
		 *
		 * @return mixed
		 */
		public function remove_css_bundle( $handles ) {
			if ( isset( $handles['learn-press-bundle'] ) ) {
				unset( $handles['learn-press-bundle'] );
			}

			return $handles;
		}

		/**
		 * Change components for single pages.
		 */
		public function change_single_components() {
			// Remove default breadcrumb.
			remove_action( 'learn-press/before-main-content', 'learn_press_breadcrumb', 10 );

			// Add title.
			add_action( 'learn-press/before-single-course', 'learn_press_course_title' );

			add_action( 'learn-press/single-course-summary', [ $this, 'entry_course_thumbnail' ], 1 );

			/**
			 * Move metas & button to custom hook.
			 */
			// Remove From Learning.
			remove_action( 'learn-press/content-learning-summary', 'learn_press_course_meta_start_wrapper', 10 );
			remove_action( 'learn-press/content-learning-summary', 'learn_press_course_students', 15 );
			remove_action( 'learn-press/content-learning-summary', 'learn_press_course_meta_end_wrapper', 20 );
			//remove_action( 'learn-press/content-learning-summary', 'learn_press_course_progress', 25 );
			//remove_action( 'learn-press/content-learning-summary', 'learn_press_course_remaining_time', 30 );
			remove_action( 'learn-press/content-learning-summary', 'learn_press_course_buttons', 40 );

			// Remove From Landing.
			remove_action( 'learn-press/content-landing-summary', 'learn_press_course_meta_start_wrapper', 5 );
			remove_action( 'learn-press/content-landing-summary', 'learn_press_course_students', 10 );
			remove_action( 'learn-press/content-landing-summary', 'learn_press_course_meta_end_wrapper', 15 );
			//add_action( 'learn-press/content-landing-summary', 'learn_press_course_tabs', 20 );
			remove_action( 'learn-press/content-landing-summary', 'learn_press_course_price', 25 );
			remove_action( 'learn-press/content-landing-summary', 'learn_press_course_buttons', 30 );

			// Then add to custom hook.


			/**
			 * For other layouts
			 */
			add_action( 'learn-press/after-single-course-summary', 'learn_press_course_buttons', 10 );

			/**
			 * For layout 01 Sticky Bar Features.
			 */
			add_action( 'learn-press/single-sticky-bar-features', 'learn_press_course_price', 5 );
			add_action( 'learn-press/single-sticky-bar-features', 'learn_press_course_meta_start_wrapper', 10 );
			add_action( 'learn-press/single-sticky-bar-features', [
				$this,
				'add_single_course_meta_instructor',
			], 20 );
			add_action( 'learn-press/single-sticky-bar-features', [ $this, 'add_single_course_meta_duration' ], 30 );
			add_action( 'learn-press/single-sticky-bar-features', [ $this, 'add_single_course_meta_lesson' ], 40 );
			/**
			 * @see learn_press_course_students()
			 */
			add_action( 'learn-press/single-sticky-bar-features', 'learn_press_course_students', 50 );
			add_action( 'learn-press/single-sticky-bar-features', [ $this, 'add_single_course_meta_language' ], 60 );
			add_action( 'learn-press/single-sticky-bar-features', [ $this, 'add_single_course_meta_time' ], 70 );
			add_action( 'learn-press/single-sticky-bar-features', 'learn_press_course_meta_end_wrapper', 80 );
			add_action( 'learn-press/single-sticky-bar-features', 'learn_press_course_buttons', 90 );
			add_action( 'learn-press/after-course-buttons', [ $this, 'entry_sharing' ] );
		}

		public function add_fields_to_meta_box( $meta_box ) {
			$fields = $meta_box['fields'];

			$fields[] = [
				'name' => esc_html__( 'Language', 'maxcoach' ),
				'id'   => 'maxcoach_course_language',
				'type' => 'text',
			];

			$fields[] = [
				'name' => esc_html__( 'Time', 'maxcoach' ),
				'id'   => 'maxcoach_course_time',
				'type' => 'text',
				'desc' => esc_html__( 'Show Time start and time end in course', 'maxcoach' ),
			];

			$meta_box['fields'] = $fields;

			return $meta_box;
		}

		public function add_single_course_meta_language() {
			$course_language = get_post_meta( get_the_ID(), 'maxcoach_course_language', true );
			if ( empty( $course_language ) ) {
				return;
			}
			?>
			<div class="course-language">
				<span class="meta-label">
					<i class="meta-icon far fa-language"></i>
					<?php esc_html_e( 'Language', 'maxcoach' ); ?>
				</span>
				<span class="meta-value"><?php echo ent2ncr( $course_language ); ?></span>
			</div>
			<?php
		}

		public function add_single_course_meta_time() {
			$course_time = get_post_meta( get_the_ID(), 'maxcoach_course_time', true );
			if ( empty( $course_time ) ) {
				return;
			}
			?>
			<div class="course-time">
				<span class="meta-label">
					<i class="meta-icon far fa-calendar"></i>
					<?php esc_html_e( 'Deadline', 'maxcoach' ); ?>
				</span>
				<span class="meta-value"><?php echo ent2ncr( $course_time ); ?></span>
			</div>
			<?php
		}

		public function add_single_course_meta_instructor() {
			$course     = LP_Global::course();
			$instructor = $course->get_instructor_name();
			?>
			<div class="course-instructor">
				<span class="meta-label">
					<i class="meta-icon far fa-chalkboard-teacher"></i>
					<?php esc_html_e( 'Instructor', 'maxcoach' ); ?>
				</span>
				<span class="meta-value"><?php echo ent2ncr( $instructor ); ?></span>
			</div>
			<?php
		}

		public function add_single_course_meta_duration() {
			$duration = $this->get_duration_translatable();

			if ( empty( $duration ) ) {
				return;
			}
			?>
			<div class="course-duration">
				<span class="meta-label">
					<i class="meta-icon far fa-clock"></i>
					<?php esc_html_e( 'Duration', 'maxcoach' ); ?>
				</span>
				<span class="meta-value"><?php echo esc_html( $duration ); ?></span>
			</div>
			<?php
		}

		/**
		 * Fix duration text can't be translatable.
		 *
		 * @return string translatable duration.
		 */
		public function get_duration_translatable() {
			$course        = LP_Global::course();
			$duration_text = $course->get_data( 'duration' );

			$duration_text_translatable = $duration_text;

			$duration_arr = explode( ' ', $duration_text );
			if ( count( $duration_arr ) === 2 ) {
				$duration_number = intval( $duration_arr[0] );
				$duration_time   = $duration_arr[1];

				switch ( $duration_time ) {
					case 'week' :
						$duration_text_translatable = sprintf( _n( '%s week', '%s weeks', $duration_number, 'maxcoach' ), number_format_i18n( $duration_number ) );
						break;
					case 'day' :
						$duration_text_translatable = sprintf( _n( '%s day', '%s days', $duration_number, 'maxcoach' ), number_format_i18n( $duration_number ) );
						break;
					case 'hour' :
						$duration_text_translatable = sprintf( _n( '%s hour', '%s hours', $duration_number, 'maxcoach' ), number_format_i18n( $duration_number ) );
						break;
					case 'minute' :
						$duration_text_translatable = sprintf( _n( '%s minute', '%s minutes', $duration_number, 'maxcoach' ), number_format_i18n( $duration_number ) );
						break;
				}
			}

			return $duration_text_translatable;
		}

		public function add_single_course_meta_lesson() {
			$course      = LP_Global::course();
			$count_items = $course->count_items();

			if ( empty( $count_items ) ) {
				return;
			}
			?>
			<div class="course-lectures">
				<span class="meta-label">
					<i class="meta-icon far fa-file-alt"></i>
					<?php esc_html_e( 'Lectures', 'maxcoach' ); ?>
				</span>
				<span class="meta-value"><?php echo ent2ncr( $count_items ); ?></span>
			</div>
			<?php
		}

		public function add_loop_course_meta_open() {
			echo '<div class="course-meta">';
		}

		public function add_loop_course_meta_close() {
			echo '</div>';
		}

		public function add_loop_course_meta_lesson() {
			$course      = LP_Global::course();
			$count_items = $course->count_items();

			if ( empty( $count_items ) ) {
				return;
			}

			$count_items = intval( $count_items );
			?>
			<div class="course-lesson">
				<span class="meta-icon far fa-file-alt"></span>
				<span class="meta-value">
					<?php
					printf( _n( '%s Lesson', '%s Lessons', $count_items, 'maxcoach' ), number_format_i18n( $count_items ) );
					?>
				</span>
			</div>
			<?php
		}

		public function add_loop_course_meta_student() {
			$course = LP_Global::course();
			if ( ! $course || ! $course->is_required_enroll() ) {
				return;
			}

			$count = intval( $course->count_students() );
			?>

			<div class="course-students">
				<span class="meta-icon far fa-user-alt"></span>
				<span class="meta-value">
					<?php printf( _n( '%s Student', '%s Students', $count, 'maxcoach' ), number_format_i18n( $count ) ); ?>
				</span>
			</div>
			<?php
		}

		public function entry_sharing() {
			if ( ! is_singular( self::POST_TYPE ) || ! class_exists( 'InsightCore' ) ) {
				return;
			}

			$social_sharing = Maxcoach::setting( 'social_sharing_item_enable' );
			if ( empty( $social_sharing ) ) {
				return;
			}

			$layout = $this->get_single_layout();
			?>
			<div class="entry-course-share">
				<div class="post-share style-02">
					<div class="share-media">

						<?php if ( '01' === $layout ) : ?>
							<div class="share-label">
								<?php esc_html_e( 'Share this course', 'maxcoach' ); ?>
							</div>
							<span class="share-icon far fa-share-alt"></span>

							<div class="share-list">
								<?php Maxcoach_Templates::get_sharing_list(); ?>
							</div>
						<?php else : ?>
							<?php Maxcoach_Templates::render_button( [
								'text'       => esc_html__( 'Share this course', 'maxcoach' ),
								'link'       => [
									'url' => 'javascript:void(0)',
								],
								'icon'       => 'far fa-share-alt',
								'icon_align' => 'right',
							] ); ?>

							<div class="share-list">
								<?php Maxcoach_Templates::get_sharing_list(); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Remove sidebar if single layout is layout '01 => Sticky Features Bar' style.
		 *
		 * @param $sidebar
		 *
		 * @return string
		 */
		public function remove_sidebar_for_sticky_layout( $sidebar ) {
			$layout = $this->get_single_layout();

			if ( is_singular( self::POST_TYPE ) && '01' === $layout ) {
				return 'none';
			}

			return $sidebar;
		}

		/**
		 * Get single course layout.
		 *
		 * @return string $layout
		 */
		public function get_single_layout() {
			$layout = Maxcoach_Helper::get_post_meta( 'single_course_layout', '' );

			if ( empty( $layout ) ) {
				$layout = Maxcoach::setting( 'single_course_layout' );
			}

			return $layout;
		}

		/**
		 * Check LearnPress plugin activated.
		 *
		 * @return boolean true if plugin activated
		 */
		public function is_activated() {
			if ( class_exists( 'LearnPress' ) ) {
				return true;
			}

			return false;
		}

		function get_categories( $args = array() ) {
			$defaults = array(
				'all' => true,
			);
			$args     = wp_parse_args( $args, $defaults );
			$terms    = get_terms( array(
				'taxonomy' => self::TAXONOMY_CATEGORY,
			) );
			$results  = array();

			if ( $args['all'] === true ) {
				$results['-1'] = esc_html__( 'All', 'maxcoach' );
			}

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$results[ $term->slug ] = $term->name;
				}
			}

			return $results;
		}

		function get_tags( $args = array() ) {
			$defaults = array(
				'all' => true,
			);
			$args     = wp_parse_args( $args, $defaults );
			$terms    = get_terms( array(
				'taxonomy' => self::TAXONOMY_TAGS,
			) );
			$results  = array();

			if ( $args['all'] === true ) {
				$results['-1'] = esc_html__( 'All', 'maxcoach' );
			}

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$results[ $term->slug ] = $term->name;
				}
			}

			return $results;
		}

		/**
		 * Check if current page is category or tag pages
		 */
		function is_taxonomy() {
			return is_tax( get_object_taxonomies( self::POST_TYPE ) );
		}

		/**
		 * Check if current page is tag pages
		 *
		 * @note
		 * For some reasons Learnpress didn't use archive template.
		 * So normal is tag will return wrong value.
		 * Instead of use constant from plugin.
		 *
		 */
		function is_tag() {
			//return is_tax( self::TAXONOMY_TAGS );
			return defined( 'LEARNPRESS_IS_TAG' ) && LEARNPRESS_IS_TAG;
		}

		/**
		 * Check if current page is category pages
		 */
		function is_category() {
			//return is_tax( self::TAXONOMY_CATEGORY );
			return defined( 'LEARNPRESS_IS_CATEGORY' ) && LEARNPRESS_IS_CATEGORY;
		}

		/**
		 * Check if current page is archive pages
		 */
		function is_archive() {
			return $this->is_taxonomy() || is_post_type_archive( self::POST_TYPE );
		}

		function has_tag() {
			if ( has_term( '', self::TAXONOMY_TAGS ) ) {
				return true;
			}

			return false;
		}

		function has_category() {
			if ( has_term( '', self::TAXONOMY_CATEGORY ) ) {
				return true;
			}

			return false;
		}

		public function the_loop_categories() {
			?>
			<div class="course-categories">
				<?php echo get_the_term_list( get_the_ID(), self::TAXONOMY_CATEGORY, '', ', ', '' ); ?>
			</div>
			<?php
		}

		public function the_loop_meta_categories() {
			?>
			<div class="meta-item course-categories">
				<span class="meta-icon far fa-folders"></span>
				<?php echo get_the_term_list( get_the_ID(), self::TAXONOMY_CATEGORY, '', ', ', '' ); ?>
			</div>
			<?php
		}

		public function the_loop_price() {
			$course          = LP_Global::course();
			$wrapper_classes = 'course-price';

			if ( $course->is_free() ) {
				$wrapper_classes .= ' course-free';
			}
			?>
			<div class="<?php echo esc_attr( $wrapper_classes ); ?>">
				<?php if ( $price_html = $course->get_price_html() ) { ?>
					<?php
					if ( $course->get_origin_price() != $course->get_price() ) {
						$origin_price_html = $course->get_origin_price_html();
						echo '<span class="origin-price">' . $origin_price_html . '</span>';
					}
					?>

					<?php echo '<span class="price">' . $price_html . '</span>'; ?>
				<?php } ?>
			</div>
			<?php
		}

		/**
		 * Custom price template used for caption style 01.
		 * Edit free price with value + badge.
		 */
		public function the_loop_custom_price() {
			$course = LP_Global::course();

			$price      = $course->get_price();
			$price      = learn_press_format_price( $price, true );
			$price_html = apply_filters( 'learn_press_course_price_html', $price, $course );
			?>

			<?php if ( $course->is_free() ): ?>
				<div class="course-price-badge">
					<?php
					$free_price = apply_filters( 'learn_press_course_price_html_free', __( 'Free', 'maxcoach' ), $course );
					echo esc_html( $free_price );
					?>
				</div>
			<?php endif; ?>

			<div class="course-price">
				<?php if ( $price_html ) { ?>
					<?php
					if ( $course->get_origin_price() != $course->get_price() ) {
						$origin_price_html = $course->get_origin_price_html();
						echo '<span class="origin-price">' . $origin_price_html . '</span>';
					}
					?>

					<?php echo '<span class="price">' . $price_html . '</span>'; ?>
				<?php } ?>
			</div>
			<?php
		}

		public function the_loop_duration() {
			$duration = $this->get_duration_translatable();

			if ( empty( $duration ) ) {
				return;
			}
			?>
			<div class="meta-item course-duration">
				<span class="meta-icon far fa-clock"></span>
				<span class="meta-value"><?php echo esc_html( $duration ); ?></span>
			</div>
			<?php
		}

		public function the_loop_lessons() {
			$course      = LP_Global::course();
			$count_items = $course->count_items();

			if ( empty( $count_items ) ) {
				return;
			}

			$count_items = intval( $count_items );
			?>
			<div class="meta-item course-lesson">
				<span class="meta-icon far fa-file-alt"></span>
				<span class="meta-value">
					<?php printf( _n( '%s Lesson', '%s Lessons', $count_items, 'maxcoach' ), number_format_i18n( $count_items ) ); ?>
				</span>
			</div>
			<?php
		}

		public function the_loop_students() {
			$course = LP_Global::course();
			if ( ! $course || ! $course->is_required_enroll() ) {
				return;
			}

			$count = intval( $course->count_students() );
			?>

			<div class="meta-item course-students">
				<span class="meta-icon far fa-user-alt"></span>
				<span class="meta-value">
					<?php printf( _n( '%s Student', '%s Students', $count, 'maxcoach' ), number_format_i18n( $count ) ); ?>
				</span>
			</div>
			<?php
		}

		public function the_loop_instructor() {
			/**
			 * @var LP_Course        $course
			 * @var LP_Abstract_User $instructor
			 */
			$course     = LP_Global::course();
			$instructor = $course->get_instructor();
			?>
			<div class="course-instructor">
				<span class="instructor-avatar">
					<?php Maxcoach_Helper::e( $instructor->get_profile_picture( '', 32 ) ); ?>
				</span>
				<span class="instructor-name"><?php echo ent2ncr( $instructor->get_display_name() ); ?></span>
			</div>
			<?php
		}

		public function the_loop_buttons() {
			if ( function_exists( 'learn_press_course_loop_item_buttons' ) ) {
				learn_press_course_loop_item_buttons();
			}
		}

		/**
		 * Get url account page
		 */
		public function get_login_page_url( $redirect_url = '' ) {
			$page = get_page_by_path( 'account' );
			if ( $page ) {
				return ! empty( $redirect_url ) ? add_query_arg( 'redirect_to', urlencode( $redirect_url ), get_permalink( $page[0] ) ) : get_permalink( $page->ID );
			}

			return wp_login_url();
		}

		/**
		 * Get membership level price
		 */

		/**
		 * Get membership level price
		 *
		 * @param mixed $level Membership level.
		 */
		public function get_membership_level_price( $level ) {
			if ( pmpro_isLevelFree( $level ) ): ?>
				<?php esc_html_e( 'Free', 'maxcoach' ); ?>
			<?php else: ?>
				<?php
				global $pmpro_currency, $pmpro_currency_symbol, $pmpro_currencies;

				$price = $level->initial_payment;
				//start with the price formatted with two decimals
				$formatted = number_format( (double) $price, 0 );

				//settings stored in array?
				if ( ! empty( $pmpro_currencies[ $pmpro_currency ] ) && is_array( $pmpro_currencies[ $pmpro_currency ] ) ) {
					//format number do decimals, with decimal_separator and thousands_separator
					$formatted = number_format( $price,
						( isset( $pmpro_currencies[ $pmpro_currency ]['decimals'] ) ? (int) $pmpro_currencies[ $pmpro_currency ]['decimals'] : 2 ),
						( isset( $pmpro_currencies[ $pmpro_currency ]['decimal_separator'] ) ? $pmpro_currencies[ $pmpro_currency ]['decimal_separator'] : '.' ),
						( isset( $pmpro_currencies[ $pmpro_currency ]['thousands_separator'] ) ? $pmpro_currencies[ $pmpro_currency ]['thousands_separator'] : ',' )
					);

					//which side is the symbol on?
					if ( ! empty( $pmpro_currencies[ $pmpro_currency ]['position'] ) && $pmpro_currencies[ $pmpro_currency ]['position'] == 'left' ) {
						$formatted = $pmpro_currency_symbol . $formatted;
					} else {
						$formatted = $formatted . $pmpro_currency_symbol;
					}
				} else {
					$formatted = $pmpro_currency_symbol . $formatted;
				}    //default to symbol on the left

				//filter
				$cost_text = apply_filters( 'pmpro_format_price', $formatted, $price, $pmpro_currency, $pmpro_currency_symbol );

				echo ent2ncr( $cost_text ); ?>
			<?php endif;
		}

		public function get_course_image( $course_id, $size ) {
			if ( ! $course = learn_press_get_course( $course_id ) ) {
				return '';
			}

			$image = '';

			if ( 'yes' !== LP()->settings->get( 'archive_course_thumbnail' ) && in_array( $size, learn_press_get_custom_thumbnail_sizes() ) ) {
				$size = '';
			}

			// Used thumbnail size setting.
			$image_size = LP()->settings->get( 'course_thumbnail_image_size' );

			if ( ! empty( $image_size ) && ( ! empty( $image_size['width'] ) || ! empty( $image_size['height'] ) ) ) {
				$image_size_width = $image_size_height = 9999;

				if ( ! empty( $image_size['width'] ) ) {
					$image_size_width = $image_size['width'];
				}

				if ( ! empty( $image_size['height'] ) ) {
					$image_size_height = $image_size['height'];
				}

				$size = "{$image_size_width}x{$image_size_height}";
			}

			if ( has_post_thumbnail( $course_id ) ) {
				$image = Maxcoach_Image::get_the_post_thumbnail( [
					'post_id' => $course_id,
					'size'    => $size,
				] );
			} elseif ( ( $parent_id = wp_get_post_parent_id( $course_id ) ) && has_post_thumbnail( $parent_id ) ) {
				$image = Maxcoach_Image::get_the_post_thumbnail( [
					'post_id' => $parent_id,
					'size'    => $size,
				] );
			}

			return $image;
		}

		public function entry_course_thumbnail() {
			$thumbnail_enable = Maxcoach::setting( 'single_course_featured_image_enable' );

			if ( '1' !== $thumbnail_enable || ! has_post_thumbnail() ) {
				return;
			}
			?>
			<div class="entry-course-thumbnail">
				<?php
				Maxcoach_Image::the_post_thumbnail( [
					'size' => '770x450',
				] );
				?>
			</div>
			<?php
		}

		public function get_the_categories() {
			$id    = get_the_ID();
			$terms = get_the_terms( $id, self::TAXONOMY_CATEGORY );

			return $terms;
		}

		public function get_the_tags() {
			$id    = get_the_ID();
			$terms = get_the_terms( $id, self::TAXONOMY_TAGS );

			return $terms;
		}

		public function get_related_courses( $args ) {
			$defaults = array(
				'post_id'      => '',
				'number_posts' => 3,
			);
			$args     = wp_parse_args( $args, $defaults );

			if ( $args['number_posts'] <= 0 || $args['post_id'] === '' ) {
				return false;
			}

			$related_by = Maxcoach::setting( 'course_related_by' );

			if ( empty( $related_by ) ) {
				return false;
			}

			$query_args = array(
				'post_type'      => self::POST_TYPE,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'posts_per_page' => $args['number_posts'],
				'post__not_in'   => array( $args['post_id'] ),
				'no_found_rows'  => true,
			);

			if ( in_array( 'category', $related_by, true ) ) {
				$terms = $this->get_the_categories();

				if ( $terms && ! is_wp_error( $terms ) ) {

					$term_ids = array();

					foreach ( $terms as $category ) {
						if ( $category->parent === 0 ) {
							$term_ids[] = $category->term_id;
						} else {
							$term_ids[] = $category->parent;
							$term_ids[] = $category->term_id;
						}
					}

					// Remove duplicate values from the array.
					$unique_term_ids = array_unique( $term_ids );

					if ( empty( $query_args['tax_query'] ) ) {
						$query_args['tax_query'] = [];
					}

					$query_args['tax_query'][] = array(
						'taxonomy'         => self::TAXONOMY_CATEGORY,
						'terms'            => $unique_term_ids,
						'include_children' => false,
					);
				}
			}

			if ( in_array( 'tags', $related_by, true ) ) {
				$terms = $this->get_the_tags();

				if ( $terms && ! is_wp_error( $terms ) ) {
					$term_ids = array();

					foreach ( $terms as $tag ) {
						if ( $tag->parent === 0 ) {
							$term_ids[] = $tag->term_id;
						} else {
							$term_ids[] = $tag->parent;
							$term_ids[] = $tag->term_id;
						}
					}

					// Remove duplicate values from the array.
					$unique_term_ids = array_unique( $term_ids );

					if ( empty( $query_args['tax_query'] ) ) {
						$query_args['tax_query'] = [];
					}

					$query_args['tax_query'][] = array(
						'taxonomy'         => self::TAXONOMY_TAGS,
						'terms'            => $unique_term_ids,
						'include_children' => false,
					);
				}
			}

			if ( count( $query_args['tax_query'] ) > 1 ) {
				$query_args['tax_query']['relation'] = 'OR';
			}

			$query = new WP_Query( $query_args );

			wp_reset_postdata();

			return $query;
		}
	}

	Maxcoach_LP_Course::instance()->initialize();
}
