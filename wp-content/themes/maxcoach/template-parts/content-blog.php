<?php
/**
 * Template part for displaying blog content in home.php, archive.php.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Maxcoach
 * @since   1.0
 */
$style   = Maxcoach::setting( 'blog_archive_style', 'grid' );
$classes = [
	'maxcoach-main-post',
	'maxcoach-grid-wrapper',
	'maxcoach-blog',
	'maxcoach-animation-zoom-in',
	'maxcoach-blog-caption-style-02',
	"maxcoach-blog-" . $style,
];

if ( in_array( $style, array( 'grid' ) ) ) {
	$lg_columns = Maxcoach::setting( 'blog_archive_lg_columns' );
	$md_columns = Maxcoach::setting( 'blog_archive_md_columns' );
	$sm_columns = Maxcoach::setting( 'blog_archive_sm_columns' );

	$grid_options = [
		'type'          => 'masonry',
		'columns'       => $lg_columns,
		'columnsTablet' => $md_columns,
		'columnsMobile' => $sm_columns,
		'gutter'        => 30,
		'gutterTablet'  => 30,
	];
}

if ( have_posts() ) : ?>
	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
	     data-grid="<?php echo esc_attr( wp_json_encode( $grid_options ) ); ?>"
	>
		<div class="maxcoach-grid">
			<div class="grid-sizer"></div>

			<?php while ( have_posts() ) : the_post();
				$classes = array( 'grid-item', 'post-item' );
				?>
				<div <?php post_class( implode( ' ', $classes ) ); ?>>
					<div class="post-wrapper maxcoach-box">

						<?php if ( has_post_thumbnail() ) { ?>
							<div class="post-feature post-thumbnail maxcoach-image">
								<a href="<?php the_permalink(); ?>">
									<?php Maxcoach_Image::the_post_thumbnail( array( 'size' => '480x325' ) ); ?>
								</a>
							</div>
						<?php } ?>

						<div class="post-caption">
							<?php $post_title = get_the_title(); ?>
							<?php if ( empty( $post_title ) ) : ?>
								<div class="post-excerpt">
									<a href="<?php the_permalink(); ?>">
										<?php Maxcoach_Templates::excerpt( array(
											'limit' => 24,
											'type'  => 'word',
										) ); ?>
									</a>
								</div>
							<?php else: ?>
								<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
							<?php endif; ?>

							<div class="post-meta">
								<div class="inner">
									<?php Maxcoach_Post::instance()->meta_date_template(); ?>
									<?php Maxcoach_Post::instance()->meta_view_count_template(); ?>
								</div>
							</div>
						</div>

					</div>
				</div>
			<?php endwhile; ?>


		</div>

		<div class="maxcoach-grid-pagination">
			<?php Maxcoach_Templates::paging_nav(); ?>
		</div>
	</div>

<?php else : get_template_part( 'template-parts/content', 'none' ); ?>
<?php endif; ?>
