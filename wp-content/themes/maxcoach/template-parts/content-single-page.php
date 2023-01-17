<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Maxcoach
 * @since   1.0
 */

?>
<div id="page-content" class="page-content">
	<div class="container">
		<div class="row">

			<?php Maxcoach_Templates::render_sidebar( 'left' ); ?>

			<div id="page-main-content" class="page-main-content">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content-rich-snippet' ); ?>


					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h2 class="screen-reader-text"><?php echo esc_html( get_the_title() ); ?></h2>
						<?php
						the_content();

						Maxcoach_Templates::page_links();
						?>
					</article>

					<?php
					/**
					 * For some reasons LearnPress use page.php instead archive.php for tags.
					 * This make comments showing.
					 */
					if ( ! Maxcoach_LP_Course::instance()->is_tag() ) {
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					}
					?>
				<?php endwhile; ?>

			</div>

			<?php Maxcoach_Templates::render_sidebar( 'right' ); ?>

		</div>
	</div>
</div>
