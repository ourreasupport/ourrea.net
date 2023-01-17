<div id="page-title-bar" <?php Maxcoach_Title_Bar::instance()->the_wrapper_class(); ?>>
	<div class="page-title-bar-inner">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php
			$featured_image = Maxcoach_Image::get_the_post_thumbnail_url();
			?>
			<div class="page-title-bar-bg" style="background-image: url(<?php echo esc_url( $featured_image ); ?>);">

			</div>
		<?php endif; ?>

		<div class="container">
			<div class="row row-xs-center">
				<div class="col-md-12">
					<?php Maxcoach_THA::instance()->title_bar_heading_before(); ?>

					<?php Maxcoach_Title_Bar::instance()->render_title(); ?>

					<?php Maxcoach_THA::instance()->title_bar_heading_after(); ?>

					<div class="page-title-bar-meta">
						<?php Maxcoach_THA::instance()->title_bar_meta(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php get_template_part( 'template-parts/breadcrumb' ); ?>
</div>
