<?php
/**
 * Migration scripts for Flash theme.
 *
 * @package    ThemeGrill
 * @subpackage Flash
 * @since      Flash 1.3.8
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Migrate all of the customize options.
 *
 * @since Flash 1.3.8
 */
function flash_page_header_bg_customize_migrate() {

	// Bail out if the migration is already done.
	if ( get_option( 'flash_page_header_bg_customize_migrate' ) ) {
		return;
	}

	$old_bg = get_theme_mod( 'flash_pageheader_background', '' );

	if ( $old_bg ) {
		set_theme_mod( 'flash_pageheader_background_image', $old_bg );
		remove_theme_mod( 'flash_pageheader_background' );
	}

	update_option( 'flash_page_header_bg_customize_migrate', true );
}
add_action( 'after_setup_theme', 'flash_page_header_bg_customize_migrate' );
