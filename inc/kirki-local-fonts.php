<?php

defined( 'ABSPATH' ) || exit;

function flash_kirki_local_fonts_ready( $fonts = array() ) {
	$dir = WP_CONTENT_DIR . '/fonts';

	if ( ! file_exists( $dir ) ) {
		return wp_is_writable( WP_CONTENT_DIR );
	}

	if ( wp_is_writable( $dir ) ) {
		return true;
	}

	if ( empty( $fonts ) ) {
		return (bool) glob( $dir . '/*/*.*' );
	}

	foreach ( array_keys( $fonts ) as $family ) {
		$folder = $dir . '/' . sanitize_key( strtolower( str_replace( ' ', '-', $family ) ) );
		if ( ! glob( $folder . '/*.*' ) ) {
			return false;
		}
	}

	return true;
}

function flash_kirki_skip_fonts_when_unwritable( $fonts ) {
	if ( is_admin() || is_customize_preview() ) {
		return $fonts;
	}

	$local = array();

	foreach ( $fonts as $family => $weights ) {
		if ( flash_kirki_local_fonts_ready( array( $family => $weights ) ) ) {
			$local[ $family ] = $weights;
		} else {
			flash_kirki_enqueue_remote_font( $family, $weights );
		}
	}

	return $local;
}
add_filter( 'kirki_enqueue_google_fonts', 'flash_kirki_skip_fonts_when_unwritable' );

function flash_kirki_enqueue_remote_font( $family, $weights ) {
	foreach ( $weights as $key => $value ) {
		$weights[ $key ] = 'italic' === $value ? '400i' : str_replace( array( 'regular', 'bold', 'italic' ), array( '400', '', 'i' ), $value );
	}

	$url = 'https://fonts.googleapis.com/css?family=' . str_replace( ' ', '+', trim( $family ) ) . ':' . implode( ',', $weights ) . '&subset=cyrillic,cyrillic-ext,devanagari,greek,greek-ext,khmer,latin,latin-ext,vietnamese,hebrew,arabic,bengali,gujarati,tamil,telugu,thai&display=swap';

	wp_enqueue_style( 'flash-kirki-remote-' . sanitize_key( $family ), $url );
}

function flash_kirki_schedule_font_prewarm() {
	if ( ! flash_kirki_local_fonts_ready() ) {
		return;
	}

	if ( ! wp_next_scheduled( 'flash_kirki_prewarm_fonts' ) ) {
		wp_schedule_single_event( time(), 'flash_kirki_prewarm_fonts' );
	}

	if ( ! defined( 'DISABLE_WP_CRON' ) || ! DISABLE_WP_CRON ) {
		spawn_cron();
	}
}
add_action( 'customize_save_after', 'flash_kirki_schedule_font_prewarm' );

function flash_kirki_prewarm_fonts() {
	wp_remote_get( home_url( '/' ), array( 'timeout' => 15, 'sslverify' => false ) );
}
add_action( 'flash_kirki_prewarm_fonts', 'flash_kirki_prewarm_fonts' );
