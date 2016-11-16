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

add_filter( 'themegrill_demo_importer_config', 'tg_demo_importer_config' );

/**
 * Setup demo importer config.
 *
 * @param  array $demo_config
 * @return array
 */
function tg_demo_importer_config( $demo_config ) {
	$new_demo_config = array(
		'flash-default' => array(
			'name'         => __( 'Flash Default', 'flash' ),
			'demo_url'     => 'http://demo.themegrill.com/flash/',
			'demo-pack'    => false,
			'core_options' => array(
				'blogname'       => 'Flash',
				'page_on_front'  => 'Home',
				'page_for_posts' => 'Blog',
			),
			'siteorigin_panels_data_update' => array(
				'homepage' => array(
				   'post_title'  => 'Home',
				   'data_update' => array(

					/**
					 * Dropdown Categories - Handles widgets Category ID.
					 *
					 * A. Core Post Category:
					 *    1. themegrill_flash_portfolio
					 *    2. themegrill_flash_blog
					 *
					 * Note: Supported Taxonomy:
					 *    A. Core Post Category - category
					 */
					'dropdown_categories' => array(
						'category' => array (
							'themegrill_flash_blog' => array(
							   18 => array(
								  'category' => 'Blog'
							   )
							),
						),
						'portfolio_cat' => array(
							'themegrill_flash_portfolio' => array(
								5 => array(
									'categories' => 'portfolio'
								)
							),
						)
					  )
				   )
				)
			),
			'customizer_data_update' => array(
				'nav_menu_locations' => array(
					'primary' => 'Primary Menu',
					'social'  => 'Social',
				)
			),
			'plugins_list' => array(
				'required' => array(
					'siteorigin-panels' => array(
						'name' => __( 'Page Builder', 'flash' ),
						'slug' => 'siteorigin-panels/siteorigin-panels.php',
						'link' => 'https://wordpress.org/plugins/siteorigin-panels/'
					),
					'flash-toolkit' => array(
						'name' => __( 'Flash Toolkit', 'flash' ),
						'slug' => 'flash-toolkit/flash-toolkit.php',
						'link' => 'https://wordpress.org/plugins/flash-toolkit/'
					),
				),
				'recommended' => array(
					'contact-form-7' => array(
						'name' => __( 'Contact Form', 'flash' ),
						'slug' => 'contact-form-7/contact-form-7.php',
						'link' => 'https://wordpress.org/plugins/contact-form-7/'
					),
				)
			)
		),
	);

	return array_merge( $new_demo_config, $demo_config );
}
