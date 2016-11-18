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

add_filter( 'themegrill_demo_importer_config', 'flash_demo_importer_config' );

/**
 * Setup demo importer config.
 *
 * @param  array $demo_config
 * @return array
 */
function flash_demo_importer_config( $demo_config ) {
	$new_demo_config = array(
		'flash-default' => array(
			'name'         => __( 'Flash Default', 'flash' ),
			'demo_url'     => 'http://demo.themegrill.com/flash/',
			'demo_pack'    => true,
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
								'FT_Widget_Blog' => array(
									14 => array(
										'category' => 'Blog'
									)
								),
							),
							'portfolio_cat' => array(
								'FT_Widget_Portfolio' => array(
									4 => array(
										'categories' => 'portfolio'
									)
								),
							),
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
						'name' => __( 'Page Builder by SiteOrigin', 'flash' ),
						'slug' => 'siteorigin-panels/siteorigin-panels.php',
					),
					'flash-toolkit' => array(
						'name' => __( 'Flash Toolkit', 'flash' ),
						'slug' => 'flash-toolkit/flash-toolkit.php',
					),
				),
				'recommended' => array(
					'contact-form-7' => array(
						'name' => __( 'Contact Form', 'flash' ),
						'slug' => 'contact-form-7/contact-form-7.php',
					),
				)
			)
		),
		'flash-corporate' => array(
			'name'         => __( 'Flash Corporate', 'flash' ),
			'demo_url'     => 'http://demo.themegrill.com/flash-corporate/',
			'demo_pack'    => true,
			'core_options' => array(
				'blogname'       => 'Flash Corporate',
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
								'FT_Widget_Blog' => array(
									6 => array(
										'category' => 'building'
									)
								),
							),
							'portfolio_cat' => array(
								'FT_Widget_Portfolio' => array(
									4 => array(
										'categories' => 'portfolio'
									)
								),
							),
						)
					)
				)
			),
			'customizer_data_update' => array(
				'nav_menu_locations' => array(
					'primary' => 'Primary Menu',
				)
			),
			'plugins_list' => array(
				'required' => array(
					'siteorigin-panels' => array(
						'name' => __( 'Page Builder by SiteOrigin', 'flash' ),
						'slug' => 'siteorigin-panels/siteorigin-panels.php',
					),
					'flash-toolkit' => array(
						'name' => __( 'Flash Toolkit', 'flash' ),
						'slug' => 'flash-toolkit/flash-toolkit.php',
					),
				),
				'recommended' => array(
					'contact-form-7' => array(
						'name' => __( 'Contact Form', 'flash' ),
						'slug' => 'contact-form-7/contact-form-7.php',
					),
				)
			)
		),
		'flash-food' => array(
			'name'         => __( 'Flash Food', 'flash' ),
			'demo_url'     => 'http://demo.themegrill.com/flash-food/',
			'demo_pack'    => true,
			'core_options' => array(
				'blogname'       => 'Flash Food',
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
								'FT_Widget_Blog' => array(
									5 => array(
										'category' => 'Blog'
									)
								),
							),
							'portfolio_cat' => array(
								'FT_Widget_Portfolio' => array(
									4 => array(
										'categories' => 'portfolio'
									)
								),
							),
						)
					)
				)
			),
			'customizer_data_update' => array(
				'nav_menu_locations' => array(
					'primary'	=> 'Primary Menu',
					'social'	=> 'Social',
					'footer'	=> 'Footer Menu',
				)
			),
			'plugins_list' => array(
				'required' => array(
					'siteorigin-panels' => array(
						'name' => __( 'Page Builder by SiteOrigin', 'flash' ),
						'slug' => 'siteorigin-panels/siteorigin-panels.php',
					),
					'flash-toolkit' => array(
						'name' => __( 'Flash Toolkit', 'flash' ),
						'slug' => 'flash-toolkit/flash-toolkit.php',
					),
				),
				'recommended' => array(
					'contact-form-7' => array(
						'name' => __( 'Contact Form', 'flash' ),
						'slug' => 'contact-form-7/contact-form-7.php',
					),
				)
			)
		),
		'flash-construction' => array(
			'name'         => __( 'Flash Construction', 'flash' ),
			'demo_url'     => 'http://demo.themegrill.com/flash-construction/',
			'demo_pack'    => true,
			'core_options' => array(
				'blogname'       => 'Flash Construction',
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
								'FT_Widget_Blog' => array(
									9 => array(
										'category' => 'Blog'
									)
								),
							),
							'portfolio_cat' => array(
								'FT_Widget_Portfolio' => array(
									4 => array(
										'categories' => 'portfolio'
									)
								),
							),
						)
					)
				)
			),
			'customizer_data_update' => array(
				'nav_menu_locations' => array(
					'primary'	=> 'Main',
					'social'	=> 'Social',
					'footer'	=> 'Footer Menu',
				)
			),
			'plugins_list' => array(
				'required' => array(
					'siteorigin-panels' => array(
						'name' => __( 'Page Builder by SiteOrigin', 'flash' ),
						'slug' => 'siteorigin-panels/siteorigin-panels.php',
					),
					'flash-toolkit' => array(
						'name' => __( 'Flash Toolkit', 'flash' ),
						'slug' => 'flash-toolkit/flash-toolkit.php',
					),
				),
				'recommended' => array(
					'contact-form-7' => array(
						'name' => __( 'Contact Form', 'flash' ),
						'slug' => 'contact-form-7/contact-form-7.php',
					),
				)
			)
		),
	);

	return array_merge( $new_demo_config, $demo_config );
}
