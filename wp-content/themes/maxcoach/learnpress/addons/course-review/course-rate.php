<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course_id       = get_the_ID();
$course_rate_res = learn_press_get_course_rate( $course_id, false );
$course_rate     = $course_rate_res['rated'];
$total           = $course_rate_res['total'];

$total_rating = $total ? sprintf( _n( '%1$s rating', '%1$s ratings', $total, 'maxcoach' ), number_format_i18n( $total ) ) : __( '0 rating', 'maxcoach' );
$total_rating = "($total_rating)";
?>
<div class="course-rating">
	<h3 class="course-review-heading"><?php esc_html_e( 'Reviews', 'maxcoach' ); ?></h3>

	<div class="course-rating-content">
		<div class="average-rating" itemprop="aggregateRating" itemscope=""
		     itemtype="http://schema.org/AggregateRating">
			<p class="rating-title secondary-color"><?php esc_html_e( 'Average Rating', 'maxcoach' ); ?></p>

			<div class="rating-box">
				<div class="average-value primary-color"
				     itemprop="ratingValue">
					<?php echo ( $course_rate ) ? esc_html( number_format( (float) $course_rate, 2, '.', '' ) ) : 0; ?>
				</div>
				<div class="review-star">
					<?php Maxcoach_Templates::render_rating( $course_rate ); ?>
				</div>
				<div class="review-amount" itemprop="ratingCount">
					<?php echo esc_html( $total_rating ); ?>
				</div>
			</div>
		</div>
		<div class="detailed-rating">
			<p class="rating-title secondary-color"><?php esc_html_e( 'Detailed Rating', 'maxcoach' ); ?></p>

			<div class="rating-box">
				<?php
				if ( isset( $course_rate_res['items'] ) && ! empty( $course_rate_res['items'] ) ):
					foreach ( $course_rate_res['items'] as $item ):
						$css_percent = $item['percent'] . '%';
						?>
						<div class="rating-rated-item">
							<div class="rating-point">
								<?php Maxcoach_Templates::render_rating( $item['rated'] ); ?>
							</div>
							<div class="rating-progress maxcoach-progress style-02">
								<div class="single-progress-bar">
									<div class="progress-bar-wrap">
										<div class="progress-bar"
										     style="width: <?php echo esc_attr( $css_percent ); ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="rating-count"><?php echo esc_html( $item['total'] ); ?></div>
						</div>
					<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
	</div>
</div>
