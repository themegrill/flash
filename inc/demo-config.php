<?php
/**
 * Functions for configuring demo importer.
 *
 * @package Importer/Functions
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Setup demo importer config.
 *
 * @deprecated 1.5.0
 *
 * @param  array $demo_config Demo config.
 *
 * @return array
 */
function flash_demo_importer_packages( $packages ) {
	$new_packages = array(
		'flash-default'         => array(
			'name'    => __( 'Flash Default', 'flash' ),
			'preview' => 'https://demo.themegrill.com/flash/',
		),
		'flash-onepage'         => array(
			'name'    => __( 'Flash OnePage', 'flash' ),
			'preview' => 'https://demo.themegrill.com/flash-one-page/',
		),
		'flash-food'            => array(
			'name'    => __( 'Flash Food', 'flash' ),
			'preview' => 'https://demo.themegrill.com/flash-food/',
		),
		'flash-construction'    => array(
			'name'    => __( 'Flash Construction', 'flash' ),
			'preview' => 'https://demo.themegrill.com/flash-construction/',
		),
		'flash-food-v2'         => array(
			'name'    => __( 'Flash Food V2', 'flash' ),
			'preview' => 'https://demo.themegrill.com/flash-food-v2/',
		),
		'flash-construction-v2' => array(
			'name'    => __( 'Flash Construction V2', 'flash' ),
			'preview' => 'https://demo.themegrill.com/flash-construction-v2/',
		),
		'flash-pro-default'     => array(
			'name'     => __( 'Flash Pro Default', 'flash' ),
			'preview'  => 'https://demo.themegrill.com/flash-pro/',
			'pro_link' => 'https://themegrill.com/themes/flash/',
		),
		'flash-pro-church'      => array(
			'name'     => __( 'Flash Pro Church', 'flash' ),
			'preview'  => 'https://demo.themegrill.com/flash-pro-church/',
			'pro_link' => 'https://themegrill.com/themes/flash/',
		),
		'flash-pro-education'   => array(
			'name'     => __( 'Flash Pro Education', 'flash' ),
			'preview'  => 'https://demo.themegrill.com/flash-pro-education/',
			'pro_link' => 'https://themegrill.com/themes/flash/',
		),
		'flash-pro-gym'         => array(
			'name'     => __( 'Flash Pro Gym', 'flash' ),
			'preview'  => 'https://demo.themegrill.com/flash-pro-gym/',
			'pro_link' => 'https://themegrill.com/themes/flash/',
		),
		'flash-pro-health'      => array(
			'name'     => __( 'Flash Pro Health', 'flash' ),
			'preview'  => 'https://demo.themegrill.com/flash-pro-health/',
			'pro_link' => 'https://themegrill.com/themes/flash/',
		),
		'flash-pro-store'       => array(
			'name'     => __( 'Flash Pro Store', 'flash' ),
			'preview'  => 'https://demo.themegrill.com/flash-pro-store/',
			'pro_link' => 'https://themegrill.com/themes/flash/',
		),
		'flash-pro-wedding'     => array(
			'name'     => __( 'Flash Pro Wedding', 'flash' ),
			'preview'  => 'https://demo.themegrill.com/flash-pro-wedding/',
			'pro_link' => 'https://themegrill.com/themes/flash/',
		),
		'flash-pro-agency'      => array(
			'name'     => __( 'Flash Pro Agency', 'flash' ),
			'preview'  => 'https://demo.themegrill.com/flash-pro-agency/',
			'pro_link' => 'https://themegrill.com/themes/flash/',
		),
		'flash-pro-band'        => array(
			'name'     => __( 'Flash Pro Band', 'flash' ),
			'preview'  => 'https://demo.themegrill.com/flash-pro-band/',
			'pro_link' => 'https://themegrill.com/themes/flash/',
		),
	);

	return array_merge( $new_packages, $packages );
}

add_filter( 'themegrill_demo_importer_packages', 'flash_demo_importer_packages' );

/**
 * Setup demo importer required plugins.
 *
 * @param  array $plugins
 *
 * @return array
 */
function flash_demo_importer_required_plugins( $plugins ) {
	$required_plugins = array(
		'flash-toolkit/flash-toolkit.php',
		'siteorigin-panels/siteorigin-panels.php',
	);

	return array_merge( $required_plugins, $plugins );
}

add_filter( 'themegrill_demo_importer_flash_required_plugins', 'flash_demo_importer_required_plugins' );

/**
 * Update taxonomies ids for restaurantpress
 *
 * @param  string $demo_id
 * @param  array  $demo_data
 */
function flash_restaurantpress_data_update( $demo_id, $demo_data ) {
	if ( ! empty( $demo_data['restaurantpress_data_update'] ) ) {
		foreach ( $demo_data['restaurantpress_data_update'] as $data_type => $data_value ) {
			$data = [];
			switch ( $data_type ) {
				case 'food_group':
					foreach ( $data_value as $group_name => $taxonomy_values ) {
						$group = get_page_by_title( $group_name, OBJECT, $data_type );
						foreach ( $taxonomy_values as $option_key => $taxonomy ) {
							$term = get_term_by( 'name', $taxonomy, 'food_menu_cat' );
							if ( is_object( $term ) && $term->term_id ) {
								$data[] = $term->term_id;
							}
						}

						update_post_meta( $group->ID, 'food_grouping', $data );
						unset( $data );
					}
					break;
			}
		}
	}
}

add_action( 'themegrill_ajax_demo_imported', 'flash_restaurantpress_data_update', 10, 2 );
