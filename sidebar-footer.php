<?php
/**
 * The Sidebar containing the footer widget areas.
 *
 * @package ThemeGrill
 * @subpackage flash
 * @since flash 1.0
 */

/**
 * The footer widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
if( !is_active_sidebar( 'flash_footer_sidebar1' ) &&
   !is_active_sidebar( 'flash_footer_sidebar2' ) &&
   !is_active_sidebar( 'flash_footer_sidebar3' ) &&
   !is_active_sidebar( 'flash_footer_sidebar4' ) ) {
   return;
}
?>
<div id="top-footer">
	<div class="tg-container">
		<div class="tg-column-wrapper">

			<?php

			do_action( 'flash_before_footer_sidebar' );

			$footer_sidebar_count = get_theme_mod('flash_footer_widgets', '4');
			$footer_sidebar_class = 'tg-column-'. absint($footer_sidebar_count);

			for ($i = 1; $i <= $footer_sidebar_count; $i++ ) {
				?>
				<div class="<?php echo esc_attr($footer_sidebar_class); ?> footer-block">

				<?php
				if ( is_active_sidebar( 'flash_footer_sidebar'.$i) ) {

					dynamic_sidebar( 'flash_footer_sidebar'.$i);
				}
				?>
				</div>

			<?php }

			do_action( 'flash_after_footer_sidebar' );
			?>
		</div>
	</div>
</div>
