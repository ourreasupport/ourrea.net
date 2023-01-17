<?php
$image = Maxcoach::setting( 'pre_loader_image' );
?>
<div>
	<?php if ( $image !== '' ): ?>
		<img src="<?php echo esc_url( $image ); ?>"
		     alt="<?php esc_attr_e( 'Maxcoach Preloader', 'maxcoach' ); ?>">
	<?php endif; ?>
</div>
