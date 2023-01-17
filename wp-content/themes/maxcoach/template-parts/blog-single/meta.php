<div class="entry-post-meta">
	<?php if ( Maxcoach::setting( 'single_post_author_enable' ) === '1' ) : ?>
		<?php Maxcoach_Post::instance()->meta_author_template(); ?>
	<?php endif; ?>

	<?php if ( Maxcoach::setting( 'single_post_date_enable' ) === '1' ) : ?>
		<?php Maxcoach_Post::instance()->meta_date_template(); ?>
	<?php endif; ?>

	<?php if ( Maxcoach::setting( 'single_post_view_count_enable' ) === '1' ) : ?>
		<?php Maxcoach_Post::instance()->meta_view_count_template(); ?>
	<?php endif; ?>

	<?php if ( Maxcoach::setting( 'single_post_comment_count_enable' ) === '1' ) : ?>
		<?php Maxcoach_Post::instance()->entry_meta_comment_count_template(); ?>
	<?php endif; ?>
</div>
