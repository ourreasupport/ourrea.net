<?php
/**
 * The template for displaying all single posts.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Maxcoach
 * @since   1.0
 */
?>
<div id="page-content" class="page-content">
	<div class="container">
		<div class="row">

			<?php Maxcoach_Templates::render_sidebar( 'left' ); ?>

			<div class="page-main-content">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content-rich-snippet' ); ?>

					<?php get_template_part( 'template-parts/blog-single/style', 'standard' ); ?>

				<?php endwhile; ?>
			</div>

			<?php Maxcoach_Templates::render_sidebar( 'right' ); ?>

		</div>
	</div>
</div>
