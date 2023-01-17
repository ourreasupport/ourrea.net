<div id="page-title-bar" <?php Maxcoach_Title_Bar::instance()->the_wrapper_class(); ?>>
	<div class="page-title-bar-inner">
		<div class="page-title-bar-bg"></div>

		<div class="container">
			<div class="row row-xs-center">
				<div class="col-md-12">
					<?php Maxcoach_THA::instance()->title_bar_heading_before(); ?>

					<?php Maxcoach_Title_Bar::instance()->render_title(); ?>

					<?php Maxcoach_THA::instance()->title_bar_heading_after(); ?>
				</div>
			</div>
		</div>

		<?php get_template_part( 'template-parts/breadcrumb' ); ?>
	</div>
</div>
