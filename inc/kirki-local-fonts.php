<?php

defined( 'ABSPATH' ) || exit;

function flash_kirki_local_fonts_writable() {
	$dir = WP_CONTENT_DIR . '/fonts';

	return file_exists( $dir ) ? wp_is_writable( $dir ) : wp_is_writable( WP_CONTENT_DIR );
}

function flash_kirki_skip_fonts_when_unwritable( $fonts ) {
	return flash_kirki_local_fonts_writable() ? $fonts : array();
}
add_filter( 'kirki_enqueue_google_fonts', 'flash_kirki_skip_fonts_when_unwritable' );

function flash_kirki_schedule_font_prewarm() {
	if ( ! flash_kirki_local_fonts_writable() ) {
		return;
	}

	if ( ! wp_next_scheduled( 'flash_kirki_prewarm_fonts' ) ) {
		wp_schedule_single_event( time() + 5, 'flash_kirki_prewarm_fonts' );
	}
}
add_action( 'customize_save_after', 'flash_kirki_schedule_font_prewarm' );

function flash_kirki_prewarm_fonts() {
	wp_remote_get( home_url( '/' ), array( 'timeout' => 15, 'sslverify' => false ) );
}
add_action( 'flash_kirki_prewarm_fonts', 'flash_kirki_prewarm_fonts' );
