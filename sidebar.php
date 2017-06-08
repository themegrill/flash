<?php
/**
 * The sidebar containing the right widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Flash
 */

/* Show the sidebar based on selected layout */
$layout = flash_get_layout();

if ( ! is_active_sidebar( 'flash_right_sidebar' ) ) {
	return;
}

if($layout == 'right-sidebar') { ?>
<aside id="secondary" class="widget-area" role="complementary">

	<?php
	/**
	 * flash_before_sidebar hook
	 */
	do_action( 'flash_before_sidebar' ); ?>

	<?php dynamic_sidebar( 'flash_right_sidebar' ); ?>

	<?php
	/**
	 * flash_after_sidebar hook
	 */
	do_action( 'flash_after_sidebar' ); ?>

</aside><!-- #secondary -->
<?php } ?>
