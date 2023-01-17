<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link    https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Maxcoach
 * @since   1.0
 */

get_header( 'blank' );

$image = Maxcoach::setting( 'error404_page_image' );
$title = Maxcoach::setting( 'error404_page_title' );
$text  = Maxcoach::setting( 'error404_page_text' );
?>
	<div class="page-404-content">
		<div class="container">
			<div class="row row-xs-center full-height">
				<div class="col-md-12">

					<?php if ( $image !== '' ): ?>
						<div class="error-image">
							<img src="<?php echo esc_url( $image ); ?>"
							     alt="<?php esc_attr_e( 'Not Found Image', 'maxcoach' ); ?>"/>
						</div>
					<?php endif; ?>

					<?php if ( $title !== '' ): ?>
						<h3 class="error-404-title">
							<?php echo wp_kses( $title, 'maxcoach-default' ); ?>
						</h3>
					<?php endif; ?>

					<?php if ( $text !== '' ): ?>
						<div class="error-404-text">
							<?php echo wp_kses( $text, 'maxcoach-default' ); ?>
						</div>
					<?php endif; ?>

					<div class="error-buttons">
						<?php
						Maxcoach_Templates::render_button( [
							'text' => esc_html__( 'Go back', 'maxcoach' ),
							'link' => [
								'url' => 'javascript:void(0)',
							],
							'icon' => 'far fa-history',
							'id'   => 'btn-go-back',
						] );

						Maxcoach_Templates::render_button( [
							'text' => esc_html__( 'Homepage', 'maxcoach' ),
							'link' => [
								'url' => esc_url( home_url( '/' ) ),
							],
							'icon' => 'far fa-home',
							'id'   => 'btn-return-home',
						] );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php get_footer( 'blank' );
