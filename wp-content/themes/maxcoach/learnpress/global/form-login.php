<?php
/**
 * Template for displaying template of login form.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/global/form-login.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$profile = LP_Global::profile();
$fields  = $profile->get_login_fields();
?>

<div class="learn-press-form-wrap learn-press-form-login-wrap col-md-5">

	<?php do_action( 'learn-press/before-form-login' ); ?>

	<div class="learn-press-form-login learn-press-form">

		<h3><?php echo _x( 'Login', 'login-heading', 'maxcoach' ); ?></h3>

		<form name="learn-press-login" method="post" action="">

			<?php do_action( 'learn-press/before-form-login-fields' ); ?>

			<ul class="form-fields">
				<?php foreach ( $fields as $field ) { ?>
					<li class="form-field">
						<?php LP_Meta_Box_Helper::show_field( $field ); ?>
					</li>
				<?php } ?>
			</ul>

			<?php do_action( 'learn-press/after-form-login-fields' ); ?>
			<div class="row">
				<div class="col-xs-6 remember-me-wrap">
					<p>
						<label>
							<input type="checkbox" name="rememberme"/>
							<?php esc_html_e( 'Remember me', 'maxcoach' ); ?>
						</label>
					</p>
				</div>
				<div class="col-xs-6 lost-your-password-wrap">
					<p>
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="lost-your-password"><?php esc_html_e( 'Lost your password?', 'maxcoach' ); ?></a>
					</p>
				</div>
			</div>
			<p>
				<input type="hidden" name="learn-press-login-nonce"
				       value="<?php echo wp_create_nonce( 'learn-press-login' ); ?>">
				<button type="submit"><?php esc_html_e( 'Log In', 'maxcoach' ); ?></button>
			</p>

			<?php do_action('oa_social_login'); ?>
		</form>
	</div>

	<?php do_action( 'learn-press/after-form-login' ); ?>
</div>
