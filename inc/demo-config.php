<?php
/**
 * Functions for configuring demo importer.
 *
 * @author   ThemeGrill
 * @category Admin
 * @package  Importer/Functions
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup demo importer packages.
 *
 * @param  array $packages
 * @return array
 */
function flash_demo_importer_packages( $packages ) {
	$new_packages = array(
		'flash-default' => array(
			'name'    => __( 'Flash Default', 'flash' ),
			'preview' => 'http://demo.themegrill.com/flash/',
		),
		'flash-onepage' => array(
			'name'    => __( 'Flash OnePage', 'flash' ),
			'preview' => 'http://demo.themegrill.com/flash-one-page/',
		),
		'flash-food' => array(
			'name'    => __( 'Flash Food', 'flash' ),
			'preview' => 'http://demo.themegrill.com/flash-food/',
		),
		'flash-construction' => array(
			'name'    => __( 'Flash Construction', 'flash' ),
			'preview' => 'http://demo.themegrill.com/flash-construction/',
		),
	);

	return array_merge( $new_packages, $packages );
}
add_filter( 'themegrill_demo_importer_packages', 'flash_demo_importer_packages' );
