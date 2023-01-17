<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Maxcoach_Event' ) ) {
	class Maxcoach_Event extends Maxcoach_Post_Type {

		protected static $instance = null;

		const    POST_TYPE                = 'tp_event';
		const    TAXONOMY_CATEGORY        = 'tp_event_category';
		const    TAXONOMY_TAGS            = 'tp_event_tag';
		const    TAXONOMY_SPEAKER         = 'tp_event_speaker';
		const    POST_META_STATUS         = 'tp_event_status';
		const    POST_META_LOCATION       = 'tp_event_location';
		const    POST_META_SHORT_LOCATION = 'tp_event_short_location';

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

			add_action( 'init', array( $this, 'register_tax_speaker' ), 1 );

			add_filter( 'maxcoach_custom_css_primary_color_selectors', [ $this, 'custom_css' ] );

			add_filter( 'tp_event_pagination_args', [ $this, 'change_pagination_args' ] );

			add_filter( 'pre_get_posts', [ $this, 'change_main_loop_query' ] );

			$this->change_single_components();

			add_action( 'wp_enqueue_scripts', [ $this, 'custom_enqueue' ], 99 );

			// Add extra field to metabox.
			add_action( 'tp_event_admin_event_metabox_after_fields', [
				$this,
				'add_extra_fields_to_metabox_settings',
			], 10, 2 );

			add_filter( 'tp_event_admin_event_tab_info', [ $this, 'add_event_speaker_to_tab' ] );
			add_filter( 'tp-event_admin_tabs_on_pages', [ $this, 'add_event_speaker_on_show_pages' ] );

			add_filter( 'tp_event_price_format', [ $this, 'add_wrapper_decimals_separator' ], 10, 3 );
		}

		/**
		 * Check The Events Calendar plugin activated.
		 *
		 * @return boolean true if plugin activated
		 */
		public function is_activated() {
			if ( class_exists( 'WPEMS' ) ) {
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
		 * @param WP_Query $query Query instance.
		 */
		public function change_main_loop_query( $query ) {
			if ( ! $query->is_main_query() || ! $this->is_archive() || is_admin() ) {
				return;
			}

			/**
			 * Change number post per page of main query.
			 */
			$number = Maxcoach::setting( 'event_archive_number_item', 9 );
			$query->set( 'posts_per_page', $number );

			// Custom filter by type
			$type = ! empty( $_GET['type'] ) ? $_GET['type'] : '';
			if ( ! empty( $type ) ) {
				switch ( $type ) {
					case 'happening':
					case 'upcoming':
					case 'expired':
						$query->set( 'meta_key', self::POST_META_STATUS );
						$query->set( 'meta_value', $type );
						$query->set( 'meta_compare', '=' );
						break;
				}
			}
		}

		public function change_pagination_args( $args ) {
			$args['prev_text'] = Maxcoach_Templates::get_pagination_prev_text();
			$args['next_text'] = Maxcoach_Templates::get_pagination_next_text();

			return $args;
		}

		public function get_filtering_type_options() {
			return [
				''          => esc_html__( 'All', 'maxcoach' ),
				'happening' => esc_html__( 'Happening', 'maxcoach' ),
				'upcoming'  => esc_html__( 'Upcoming', 'maxcoach' ),
				'expired'   => esc_html__( 'Expired', 'maxcoach' ),
			];
		}

		public function get_selected_type_option() {
			$type = ! empty( $_GET['type'] ) ? $_GET['type'] : '';

			return $type;
		}

		public function custom_enqueue() {
			wp_dequeue_script( 'wpems-owl-carousel-js' );
			wp_dequeue_style( 'wpems-owl-carousel-css' );

			wp_dequeue_script( 'wpems-magnific-popup-js' );
			wp_dequeue_style( 'wpems-magnific-popup-css' );

		}

		public function custom_css( $selectors ) {
			$selectors['color'][] = "
				.maxcoach-event-carousel .event-date,
				.maxcoach-event-carousel .tm-button.style-flat,
				.maxcoach-event .tm-button.style-flat,
				.maxcoach-event-grid .event-date--day,
				.maxcoach-event-grid.style-minimal .event-caption:before,
				.event-price,
				.event-register-message a,
				.maxcoach-event-grid.style-one-left-featured .normal-events .event-date,
				.tp_single_event .entry-meta .meta-icon
			";

			return $selectors;
		}

		public function change_single_components() {
			add_filter( 'maxcoach_title_bar_type', [ $this, 'remove_title_bar' ] );

			// Add gutenberg editor for single page.
			add_filter( 'register_post_type_args', [ $this, 'add_gutenberg_support' ], 10, 2 );
			add_filter( 'register_taxonomy_args', [ $this, 'add_gutenberg_support_for_taxonomy' ], 10, 2 );

			// Change map marker
			add_filter( 'tp-event-map-marker', [ $this, 'change_map_marker' ] );
		}

		public function remove_title_bar( $type ) {
			if ( $this->is_single() ) {
				return 'none';
			}

			return $type;
		}

		public function register_tax_speaker() {
			register_taxonomy( self::TAXONOMY_SPEAKER, self::POST_TYPE, [
				'hierarchical'      => false,
				'label'             => esc_html__( 'Speakers', 'maxcoach' ),
				'labels'            => array(
					'name' => _x( 'Speakers', 'taxonomy general name', 'maxcoach' ),
				),
				'public'            => true,
				'query_var'         => true,
				'show_ui'           => true,
				'show_in_admin_bar' => true,
				'show_in_rest'      => true,
				'rewrite'           => array( 'slug' => apply_filters( 'maxcoach_event_speaker_slug', 'event-speaker' ) ),
				'show_admin_column' => true,
			] );
		}

		public function add_event_speaker_to_tab( $tabs ) {
			$tabs[40] = [
				'link' => 'edit-tags.php?taxonomy=tp_event_speaker&post_type=tp_event',
				'name' => esc_html__( 'Speakers', 'maxcoach' ),
				'id'   => 'edit-tp_event_speaker',
			];

			return $tabs;
		}

		public function add_event_speaker_on_show_pages( $pages ) {
			// plugin missing.
			if ( ! in_array( $pages, [ 'edit-tp_event_tag' ], true ) ) {
				$pages[] = 'edit-tp_event_tag';
			}

			// custom by theme.
			if ( ! in_array( $pages, [ 'edit-tp_event_speaker' ], true ) ) {
				$pages[] = 'edit-tp_event_speaker';
			}

			return $pages;
		}

		public function add_gutenberg_support( $args, $post_type ) {
			if ( self::POST_TYPE === $post_type ) {
				$args['show_in_rest'] = true;
			}

			return $args;
		}

		public function add_gutenberg_support_for_taxonomy( $args, $taxonomy ) {
			if ( in_array( $taxonomy, [
				self::TAXONOMY_CATEGORY,
				self::TAXONOMY_TAGS,
			] ) ) {
				$args['show_in_rest'] = true;
			}

			return $args;
		}

		public function add_extra_fields_to_metabox_settings( $post, $prefix ) {
			$post_id        = $post->ID;
			$short_location = get_post_meta( $post_id, $prefix . 'short_location', true );
			?>
			<div class="option_group">
				<p class="form-field">
					<label for="_short_location"><?php esc_html_e( 'Short Location', 'maxcoach' ); ?></label>
					<input type="text" class="short" name="<?php echo esc_attr( $prefix ); ?>short_location"
					       id="_short_location"
					       value="<?php echo esc_attr( $short_location ); ?>">
				</p>
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
			?>
			<div class="entry-event-share">
				<div class="share-list">
					<?php Maxcoach_Templates::get_sharing_list(); ?>
				</div>
			</div>
			<?php
		}

		public function add_wrapper_decimals_separator( $price_format, $price, $with_currency ) {
			$price_decimals_separator = wpems_get_option( 'currency_separator', ',' );

			if ( ! empty( $price_decimals_separator ) ) {
				$price_format = str_replace( $price_decimals_separator, '<span class="decimals-separator">' . $price_decimals_separator, $price_format );
				$price_format .= '</span>';
			}

			return $price_format;
		}

		public function get_the_speakers_slider() {
			$terms = get_the_terms( get_the_ID(), self::TAXONOMY_SPEAKER );

			if ( empty( $terms ) || is_wp_error( $terms ) ) {
				return;
			}
			?>

			<div class="entry-speakers">
				<h3 class="entry-event-heading entry-event-heading-speakers"><?php esc_html_e( 'Our Speakers', 'maxcoach' ); ?></h3>

				<div class="tm-swiper tm-slider event-speakers-slider"
				     data-lg-items="5"
				     data-md-items="3"
				     data-sm-items="2"
				     data-lg-gutter="30"
				>
					<div class="swiper-inner">
						<div class="swiper-container">
							<div class="swiper-wrapper">
								<?php foreach ( $terms as $term ) : ?>

									<div class="swiper-slide">
										<div class="speaker-item">
											<?php if ( function_exists( 'get_term_thumbnail_id' ) ) : ?>
												<div class="speaker-thumbnail">
													<?php
													$term_thumbnail_id = get_term_thumbnail_id( $term->term_taxonomy_id );
													?>
													<?php Maxcoach_Image::the_attachment_by_id( [
														'id'   => $term_thumbnail_id,
														'size' => '200x200',
													] ); ?>
												</div>
											<?php endif; ?>
											<h6 class="speaker-name"><?php echo esc_html( $term->name ); ?></h6>
											<div
												class="speaker-description"><?php echo esc_html( $term->description ); ?></div>
										</div>
									</div>

								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>

				<?php
				$speaker_description = Maxcoach::setting( 'single_event_speaker_text' );
				?>
				<?php if ( ! empty( $speaker_description ) ) : ?>
					<div class="event-speakers-description">
						<?php echo esc_html( $speaker_description ); ?>
					</div>
				<?php endif; ?>
			</div>
			<?php
		}

		public function change_map_marker() {
			return MAXCOACH_THEME_IMAGE_URI . '/map-marker.png';
		}
	}

	Maxcoach_Event::instance()->initialize();
}
