<?php
/**
 * The Template for displaying thumbnail in single event page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/loop/thumbnail.php
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( has_post_thumbnail() ): ?>

	<?php if ( is_singular( 'tp_event' ) ): ?>
		<div class="entry-thumbnail">
			<?php Maxcoach_Image::the_post_thumbnail( [
				'size' => '1920x700',
			] ); ?>
		</div>
	<?php else: ?>
		<div class="post-thumbnail">
			<?php Maxcoach_Image::the_post_thumbnail( [
				'size' => '480x298',
			] ); ?>
		</div>
	<?php endif; ?>

<?php endif; ?>
