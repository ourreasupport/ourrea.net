<?php
/**
 * Template for displaying user profile cover image.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/profile/profile-cover.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$profile = LP_Profile::instance();

$user    = $profile->get_user();
$user_id = $user->get_id();
?>

<div id="learn-press-profile-header" class="lp-profile-header">
	<div class="row">
		<div class="col-md-5">
			<div class="lp-profile-cover">
				<?php echo '<div class="lp-profile-avatar">' . $user->get_profile_picture( '', 470 ) . '</div>'; ?>
			</div>
		</div>

		<div class="col-md-6 col-md-push-1">
			<div class="lp-profile-info">
				<?php echo '<h3 class="profile-name">' . $user->get_display_name() . '</h3>'; ?>

				<?php Maxcoach_Templates::get_author_meta_career( $user_id ); ?>

				<?php echo '<div class="author-bio">' . $user->get_description() . '</div>'; ?>

				<h5 class="profile-contact-info"><?php esc_html_e( 'Contact', 'maxcoach' ); ?></h5>
				<div class="profile-author-meta">

					<?php
					$phone_number = Maxcoach_Templates::get_author_meta_phone_number( $user_id );
					?>

					<?php if ( ! empty( $phone_number ) ): ?>
						<div class="meta-item profile-author-phone">
							<span><?php esc_html_e( 'Phone number:', 'maxcoach' ); ?></span>
							<div class="author-phone-number">
								<?php echo esc_html( $phone_number ); ?>
							</div>
						</div>
					<?php endif; ?>

					<div class="meta-item profile-author-email">
						<span><?php esc_html_e( 'Email:', 'maxcoach' ); ?></span>
						<?php Maxcoach_Templates::get_author_meta_email_template( $user_id ); ?>
					</div>
				</div>
				<?php Maxcoach_Templates::get_author_socials( $user_id ); ?>
			</div>
		</div>
	</div>
</div>


