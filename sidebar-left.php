<?php
/**
 * The sidebar containing the left widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Flash
 */

/* Show the sidebar based on selected layout */
$layout = flash_get_layout();

if ( ! is_active_sidebar( 'flash_left_sidebar' ) ) {
	return;
}

if($layout == 'left-sidebar') { ?>
<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'flash_left_sidebar' ); ?>
</aside><!-- #secondary -->
<?php } ?>
