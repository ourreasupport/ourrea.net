<?php
$type       = Maxcoach_Global::instance()->get_top_bar_type();
$components = Maxcoach::setting( "top_bar_style_{$type}_components" );
?>
<div <?php Maxcoach_Top_Bar::instance()->get_wrapper_class(); ?>>
	<div class="container">
		<div class="row row-eq-height">
			<div class="col-md-12">
				<div class="top-bar-wrap">
					<?php Maxcoach_Top_Bar::instance()->print_component( $components ); ?>
				</div>
			</div>
		</div>
	</div>
</div>
