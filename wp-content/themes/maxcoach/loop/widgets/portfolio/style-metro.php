<?php
if ( isset( $settings['grid_metro_layout'] ) ) {
	$metro_layout = array();

	foreach ( $settings['grid_metro_layout'] as $key => $value ) {
		$metro_layout[] = $value['size'];
	}
} else {
	$metro_layout = array(
		'2:2',
		'1:1',
		'1:1',
		'1:1',
		'1:1',
		'1:1',
		'1:1',
		'1:1',
		'1:1',
		'2:2',
	);
}

if ( count( $metro_layout ) < 1 ) {
	return;
}

$metro_layout_count = count( $metro_layout );
$metro_item_count   = 0;
$count              = $maxcoach_query->post_count;

while ( $maxcoach_query->have_posts() ) : $maxcoach_query->the_post();
	$classes = array( 'grid-item portfolio-item' );

	$size   = $metro_layout[ $metro_item_count ];
	$ratio  = explode( ':', $size );
	$ratioW = $ratio[0];
	$ratioH = $ratio[1];

	$_image_width  = $settings['metro_image_size_width'];
	$_image_height = $_image_width * $settings['metro_image_ratio']['size'];
	if ( in_array( $ratioW, array( '2' ) ) ) {
		$_image_width *= 2;
	}

	if ( in_array( $ratioH, array( '1.3', '2' ) ) ) {
		$_image_height *= 2;
	}
	?>
	<div <?php post_class( implode( ' ', $classes ) ); ?>
		data-width="<?php echo esc_attr( $ratioW ); ?>"
		data-height="<?php echo esc_attr( $ratioH ); ?>"
	>
		<div class="post-wrapper maxcoach-box">
			<div class="post-thumbnail-wrapper maxcoach-image grid-item-height">
				<a href="<?php Maxcoach_Portfolio::instance()->the_permalink(); ?>"
				   class="post-permalink link-secret">
					<div class="post-thumbnail">
						<?php if ( has_post_thumbnail() ) { ?>
							<?php
							Maxcoach_Image::the_post_thumbnail( array(
								'size'   => 'custom',
								'width'  => $_image_width,
								'height' => $_image_height,
							) );
							?>
						<?php } else { ?>
							<?php Maxcoach_Templates::image_placeholder( 480, 480 ); ?>
						<?php } ?>
					</div>

					<?php if ( ! empty( $settings['overlay_style'] ) ) : ?>
						<?php get_template_part( 'loop/portfolio/overlay', $settings['overlay_style'] ); ?>
					<?php endif; ?>
				</a>
			</div>

			<?php if ( 'yes' === $settings['show_caption'] ) : ?>
				<?php get_template_part( 'loop/portfolio/caption', $settings['caption_style'] ); ?>
			<?php endif; ?>

		</div>
	</div>
	<?php
	$metro_item_count++;
	if ( $metro_item_count == $count || $metro_layout_count == $metro_item_count ) {
		$metro_item_count = 0;
	}
	?>
<?php endwhile; ?>
