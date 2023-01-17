<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Maxcoach_Title_Bar' ) ) {

	class Maxcoach_Title_Bar {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			// Adds custom classes to the array of body classes.
			add_filter( 'body_class', [ $this, 'body_classes' ] );
		}

		public function body_classes( $classes ) {
			$title_bar = Maxcoach_Global::instance()->get_title_bar_type();
			$classes[] = "title-bar-{$title_bar}";

			/**
			 * Add class to hide entry title if this title bar has post title also.
			 */
			// Title Bars support heading.
			if ( in_array( $title_bar, [ '01', '03' ], true ) && is_singular() ) {
				$post_type = get_post_type();
				$title     = '';

				switch ( $post_type ) {
					case 'post' :
						$title = Maxcoach::setting( 'title_bar_single_blog_title' );
						break;
					case 'portfolio' :
						$title = Maxcoach::setting( 'title_bar_single_portfolio_title' );
						break;
					case 'product' :
						$title = Maxcoach::setting( 'title_bar_single_product_title' );
						break;
				}

				if ( '' === $title ) {
					$classes[] = 'title-bar-has-post-title';
				}
			}

			return $classes;
		}

		public function get_list( $default_option = false, $default_text = '' ) {
			$options = array(
				'none' => esc_html__( 'Hide', 'maxcoach' ),
				'01'   => esc_html__( 'Style 01', 'maxcoach' ),
				'02'   => esc_html__( 'Style 02', 'maxcoach' ),
				'03'   => esc_html__( 'Style 03', 'maxcoach' ),
			);

			if ( $default_option === true ) {
				if ( $default_text === '' ) {
					$default_text = esc_html__( 'Default', 'maxcoach' );
				}

				$options = array( '' => $default_text ) + $options;
			}

			return $options;
		}

		public function the_wrapper_class() {
			$classes = array( 'page-title-bar' );

			$type = Maxcoach_Global::instance()->get_title_bar_type();

			$classes[] = "page-title-bar-{$type}";

			echo 'class="' . esc_attr( join( ' ', $classes ) ) . '"';
		}

		public function render() {
			$type = Maxcoach_Global::instance()->get_title_bar_type();

			if ( 'none' === $type ) {
				return;
			}

			get_template_part( 'template-parts/title-bar/title-bar', $type );
		}

		public function render_title() {
			$title     = '';
			$title_tag = 'h1';

			if ( Maxcoach_Portfolio::instance()->is_archive() ) {
				$title = Maxcoach::setting( 'title_bar_archive_portfolio_title' );
			} elseif ( Maxcoach_Event::instance()->is_activated() && Maxcoach_Event::instance()->is_archive() ) {
				$title = esc_html__( 'Events', 'maxcoach' );
			} elseif ( Maxcoach_LP_Course::instance()->is_tag() ) {
				$title = esc_html__( 'Courses', 'maxcoach' );
			} elseif ( is_post_type_archive() ) {
				if ( function_exists( 'is_shop' ) && is_shop() ) {
					$title = esc_html__( 'Shop', 'maxcoach' );
				} else {
					$title = sprintf( esc_html__( 'Archives: %s', 'maxcoach' ), post_type_archive_title( '', false ) );
				}
			} elseif ( is_home() ) {
				$title = Maxcoach::setting( 'title_bar_home_title' ) . single_tag_title( '', false );
			} elseif ( is_tag() ) {
				$title = Maxcoach::setting( 'title_bar_archive_tag_title' ) . single_tag_title( '', false );
			} elseif ( is_author() ) {
				$title = Maxcoach::setting( 'title_bar_archive_author_title' ) . '<span class="vcard">' . get_the_author() . '</span>';
			} elseif ( is_year() ) {
				$title = Maxcoach::setting( 'title_bar_archive_year_title' ) . get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'maxcoach' ) );
			} elseif ( is_month() ) {
				$title = Maxcoach::setting( 'title_bar_archive_month_title' ) . get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'maxcoach' ) );
			} elseif ( is_day() ) {
				$title = Maxcoach::setting( 'title_bar_archive_day_title' ) . get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'maxcoach' ) );
			} elseif ( is_search() ) {
				$title = Maxcoach::setting( 'title_bar_search_title' ) . '"' . get_search_query() . '"';
			} elseif ( is_category() || is_tax() ) {
				$title = Maxcoach::setting( 'title_bar_archive_category_title' ) . single_cat_title( '', false );
			} elseif ( is_singular() ) {
				$title = Maxcoach_Helper::get_post_meta( 'page_title_bar_custom_heading', '' );

				if ( '' === $title ) {
					$post_type = get_post_type();
					switch ( $post_type ) {
						case 'post' :
							$title = Maxcoach::setting( 'title_bar_single_blog_title' );
							break;
						case 'portfolio' :
							$title = Maxcoach::setting( 'title_bar_single_portfolio_title' );
							break;
						case 'product' :
							$title = Maxcoach::setting( 'title_bar_single_product_title' );
							break;
					}
				}

				if ( '' === $title ) {
					$title = get_the_title();
				} else {
					$title_tag = 'h2';
				}
			} else {
				$title = get_the_title();
			}
			?>
			<div class="page-title-bar-heading">
				<?php printf( '<%s class="heading">', $title_tag ); ?>
				<?php echo wp_kses( $title, array(
					'span' => [
						'class' => [],
					],
				) ); ?>
				<?php printf( '</%s>', $title_tag ); ?>
			</div>
			<?php
		}
	}

	Maxcoach_Title_Bar::instance()->initialize();
}
