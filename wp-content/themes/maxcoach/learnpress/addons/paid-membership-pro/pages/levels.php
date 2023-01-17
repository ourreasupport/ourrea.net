<?php

global $current_user;
$levels       = lp_pmpro_get_all_levels();
$list_courses = lp_pmpro_list_courses( $levels );
asort( $list_courses );
?>
<?php do_action( 'learn_press_pmpro_before_levels' ); ?>
<table class="lp-pmpro-membership-list show-desktop">

	<thead>
	<tr class="lp-pmpro-header">
		<th class="header-list-main list-main"></th>
		<?php
		$class_count = ' has-' . count( $levels );

		foreach ( $levels as $index => $level ):
			$current_level = false;
			if ( isset( $current_user->membership_level->ID ) ) {
				if ( $current_user->membership_level->ID == $level->id ) {
					$current_level = true;
				}
			}
			?>

			<th class="header-item list-item<?php echo esc_attr( $class_count . ' position-' . $index ); ?>">
				<div class="lp-price">
					<span class="amount">
						<?php Maxcoach_LP_Course::instance()->get_membership_level_price( $level ); ?>
					</span>
				</div>

				<h2 class="lp-title"><?php echo esc_html( $level->name ); ?></h2>

				<?php
				if ( ! empty( $level->description ) ) {
					echo '<div class="lp-desc">' . $level->description . '</div>';
				}
				?>
			</th>
		<?php endforeach; ?>
	</tr>
	</thead>
	<tbody class="lp-pmpro-main">
	<tr class="item-row">
		<td class="list-main item-td item-desc"><?php esc_html_e( 'Number of courses', 'maxcoach' ); ?></td>
		<?php
		foreach ( $levels as $index => $level ) {
			$the_query = lp_pmpro_query_course_by_level( $level->id );
			$count     = count( $the_query->posts );
			echo '<td class="list-item item-td">' . esc_html( $count ) . '</td>';
		}
		?>
	</tr>

	<?php
	if ( ! empty( $list_courses ) ) {
		foreach ( $list_courses as $key => $course_item ) {
			$class_course = '';
			if ( isset( $_GET['course_id'] ) && ! empty( $_GET['course_id'] ) ) {
				$course_id = $_GET['course_id'];
				if ( absint( $course_id ) === $course_item['id'] ) {
					$class_course = apply_filters( 'learn-press-pmpro-levels-page-current-course', 'learn-press-course-current', $course_item, $course_id );

				}
			}
			?>
			<tr class="item-row <?php echo esc_attr( $class_course ); ?>">
				<?php
				echo apply_filters( 'learn_pres_pmpro_course_header_level', '<td class="list-main item-td">' . wp_kses_post( $course_item["link"] ) . '</td>', $course_item["link"], $course_item, $key );

				foreach ( $levels as $index => $level ) {
					if ( in_array( $level->id, $course_item['level'] ) ) {
						echo apply_filters( 'learn_press_pmpro_course_is_level', '<td class="list-item item-td item-check "><i class="fa fas fa-check"></i></td>', $level, $index, $course_item, $key );
					} else {
						echo apply_filters( 'learn_press_pmpro_course_is_not_level', '<td class="list-item item-td item-none"><i class="fa fas fa-times"></i></td>', $level, $index, $course_item, $key );
					}
				}

				?>
			</tr>
			<?php
		}
	}
	?>
	</tbody>

	<tfoot class="lp-pmpro-footer">
	<tr>
		<td class="footer-left-main list-main"></td>
		<?php foreach ( $levels as $index => $level ):
			$current_level = false;

			if ( isset( $current_user->membership_level->ID ) ) {
				if ( $current_user->membership_level->ID == $level->id ) {
					$current_level = true;
				}
			}
			?>
			<td class="list-item">
				<?php if ( empty( $current_user->membership_level->ID ) || ! $current_level ) { ?>
					<a class="pmpro_btn pmpro_btn-select"
					   href="<?php echo pmpro_url( 'checkout', '?level=' . $level->id, 'https' ); ?>">
						<?php esc_html_e( 'Get it now', 'maxcoach' ); ?>
					</a>
				<?php } elseif ( $current_level ) { ?>
					<?php if ( pmpro_isLevelExpiringSoon( $current_user->membership_level ) && $current_user->membership_level->allow_signups ) { ?>
						<a class="pmpro_btn pmpro_btn-select"
						   href="<?php echo pmpro_url( 'checkout', '?level=' . $level->id, 'https' ); ?>">
							<?php esc_html_e( 'Renew', 'maxcoach' ); ?>
						</a>
					<?php } else { ?>
						<a class="pmpro_btn disabled"
						   href="<?php echo pmpro_url( 'account' ); ?>">
							<?php esc_html_e( 'Your level', 'maxcoach' ); ?>
						</a>
					<?php } ?>
				<?php } ?>
			</td>
		<?php endforeach; ?>
	</tr>
	</tfoot>
</table>
<?php
/**
 * Added by Maxcoach.
 */
?>
<div class="lp-pmpro-membership-list show-mobile">
	<?php
	foreach ( $levels as $index => $level ) {
		$the_query = lp_pmpro_query_course_by_level( $level->id );
		$count     = count( $the_query->posts );

		$current_level = false;

		if ( isset( $current_user->membership_level->ID ) ) {
			if ( $current_user->membership_level->ID == $level->id ) {
				$current_level = true;
			}
		}
		?>
		<div class="maxcoach-membership-pricing">
			<div class="header-item">
				<div class="lp-price">
					<span class="amount">
						<?php Maxcoach_LP_Course::instance()->get_membership_level_price( $level ); ?>
					</span>
				</div>

				<h2 class="lp-title"><?php echo esc_html( $level->name ); ?></h2>

				<?php
				if ( ! empty( $level->description ) ) {
					echo '<div class="lp-desc">' . $level->description . '</div>';
				}
				?>
			</div>
			<div class="lp-pmpro-main">
				<ul class="features">
					<li><?php echo esc_html__( 'Number of courses: ', 'maxcoach' ) . ' ' . $count; ?></li>
					<?php
					if ( ! empty( $list_courses ) ) {
						foreach ( $list_courses as $key => $course_item ) {
							if ( ! in_array( $level->id, $course_item['level'] ) ) {
								continue;
							}
							$class_course = '';
							if ( isset( $_GET['course_id'] ) && ! empty( $_GET['course_id'] ) ) {
								$course_id = $_GET['course_id'];
								if ( absint( $course_id ) === $course_item['id'] ) {
									$class_course = apply_filters( 'learn-press-pmpro-levels-page-current-course', 'learn-press-course-current', $course_item, $course_id );
								}
							}
							?>
							<li class="item-row <?php echo esc_attr( $class_course ); ?>">
								<?php
								echo apply_filters( 'learn_pres_pmpro_course_header_level', '<div class="list-main item-td">' . wp_kses_post( $course_item["link"] ) . '</div>', $course_item["link"], $course_item, $key );
								?>
							</li>
							<?php
						}
					}
					?>
				</ul>
			</div>
			<div class="lp-pmpro-footer">
				<?php if ( empty( $current_user->membership_level->ID ) || ! $current_level ) { ?>
					<a class="pmpro_btn pmpro_btn-select"
					   href="<?php echo pmpro_url( 'checkout', '?level=' . $level->id, 'https' ); ?>">
						<?php esc_html_e( 'Get it now', 'maxcoach' ); ?>
					</a>
				<?php } elseif ( $current_level ) { ?>
					<?php
					if ( pmpro_isLevelExpiringSoon( $current_user->membership_level ) && $current_user->membership_level->allow_signups ) { ?>
						<a class="pmpro_btn pmpro_btn-select"
						   href="<?php echo pmpro_url( 'checkout', '?level=' . $level->id, 'https' ); ?>">
							<?php esc_html_e( 'Renew', 'maxcoach' ); ?>
						</a>
					<?php } else { ?>
						<a class="pmpro_btn disabled"
						   href="<?php echo pmpro_url( 'account' ); ?>">
							<?php esc_html_e( 'Your level', 'maxcoach' ); ?>
						</a>
					<?php } ?>
				<?php } ?>
			</div>
		</div>

	<?php } ?>
</div>
<?php do_action( 'learn_press_pmpro_after_levels' ); ?>
