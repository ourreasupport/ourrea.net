<?php
/**
 * Template for displaying wrap start of archive course within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/loop/course/loop-begin.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>
<?php
$wrapper_classes = [
	'maxcoach-main-post',
	'maxcoach-grid-wrapper',
	'maxcoach-course',
	'maxcoach-animation-zoom-in',
];

$lg_columns = Maxcoach::setting( 'course_archive_lg_columns', 3 );
$md_columns = Maxcoach::setting( 'course_archive_md_columns' );
$sm_columns = Maxcoach::setting( 'course_archive_sm_columns' );

$grid_options = [
	'type'          => 'grid',
	'columns'       => $lg_columns,
	'columnsTablet' => $md_columns,
	'columnsMobile' => $sm_columns,
	'gutter'        => 30,
];
?>
<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>"
     data-grid="<?php echo esc_attr( wp_json_encode( $grid_options ) ); ?>"
>
	<div class="learn-press-courses maxcoach-grid">
		<div class="grid-sizer"></div>
