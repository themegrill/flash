<?php
/**
 * Flash Theme Customizer.
 *
 * @package Flash
 */

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Flash 1.0
 *
 * @see flash_header_style()
 */
function flash_custom_header_and_background() {
	$color_scheme             = flash_get_color_scheme();
	$default_background_color = trim( $color_scheme[0], '#' );
	$default_text_color       = trim( $color_scheme[2], '#' );

	/**
	 * Filter the arguments used when adding 'custom-background' support in Flash.
	 *
	 * @since Flash 1.0
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 *     @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'flash_custom_background_args', array(
		'default-color' => $default_background_color,
	) ) );


	/**
	* Filter the arguments used when adding 'customheader' support in Flash.
	*
	* @since Flash 1.0
	*
	* @param array $args {
	*     An array of customheader support arguments.
	*
	*     @type string $defaulttextcolor Default color of the header text.
	*     @type int      $width            Width in pixels of the custom header image. Default 1200.
	*     @type int      $height           Height in pixels of the custom header image. Default 280.
	*     @type bool     $flexheight      Whether to allow flexibleheight header images. Default true.
	*     @type callable $wpheadcallback Callback function used to style the header image and text
	*                                      displayed on the blog.
	* }
	*/
	add_theme_support( 'custom-header', apply_filters( 'flash_custom_header_args', array(
		'default-text-color'   => $default_text_color,
		'width'                => 1286,
		'height'               => 280,
		'flex-height'          => true,
		'header-text'          => true,
	) ) );
}
add_action( 'after_setup_theme', 'flash_custom_header_and_background' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function flash_customize_register( $wp_customize ) {
	// Custom Controls
	require_once get_template_directory() . '/inc/class-customizer-control-radio-image.php';

	$color_scheme = flash_get_color_scheme();

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Transparent Logo
	$wp_customize->add_setting(
		'flash_transparent_logo',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'flash_transparent_logo',
			array(
				'label'           => esc_html__( 'Transparent Logo' , 'flash' ),
				'priority'        => 8, // Place right after Site Logo Option
				'section'         => 'title_tagline',
			)
		)
	);

	// Add color scheme setting and control.
	$wp_customize->add_setting( 'color_scheme', array(
		'default'           => 'default',
		'sanitize_callback' => 'flash_sanitize_color_scheme',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'color_scheme', array(
		'label'    => esc_html__( 'Base Color Scheme', 'flash' ),
		'section'  => 'colors',
		'type'     => 'select',
		'choices'  => flash_get_color_scheme_choices(),
		'priority' => 1,
	) );

	// Remove the core header textcolor control, as it shares the main text color.
	$wp_customize->remove_control( 'header_textcolor' );

	// Add link color setting and control.
	$wp_customize->add_setting( 'link_color', array(
		'default'           => $color_scheme[1],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'label'       => esc_html__( 'Link Color', 'flash' ),
		'section'     => 'colors',
	) ) );

	// Add main text color setting and control.
	$wp_customize->add_setting( 'main_text_color', array(
		'default'           => $color_scheme[2],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_text_color', array(
		'label'       => esc_html__( 'Main Text Color', 'flash' ),
		'section'     => 'colors',
	) ) );

	// Add secondary text color setting and control.
	$wp_customize->add_setting( 'secondary_text_color', array(
		'default'           => $color_scheme[3],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_text_color', array(
		'label'       => esc_html__( 'Secondary Text Color', 'flash' ),
		'section'     => 'colors',
	) ) );

	/* Theme Options Panel */
	$wp_customize->add_panel(
		'flash_theme_options',
		array(
			'priority'       => 100,
			'capability'     => 'edit_theme_options',
			'title'          => esc_html__( 'Flash Theme Options', 'flash' ),
			'description'    => esc_html__( 'Customize options related to Flash theme', 'flash' ),
		)
	);


	// General Options
	$wp_customize->add_section(
		'flash_general_options',
		array(
			'title'         => esc_html__( 'General Settings', 'flash' ),
			'priority'      => 10,
			'panel'         => 'flash_theme_options',
			'description'   => esc_html__( '', 'flash' ),
		)
	);

	// Layout Option
	$wp_customize->add_setting(
		'flash_site_layout',
		array(
			'default'           => 'wide',
			'sanitize_callback' => 'flash_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'flash_site_layout',
		array(
			'type'        => 'select',
			'label'       => esc_html__( 'Site Layout', 'flash' ),
			'section'     => 'flash_general_options',
			'description' => esc_html__( 'Select site layout.', 'flash' ),
			'choices'     => array(
				'wide'     => esc_html__( 'Wide Layout', 'flash' ),
				'boxed'    => esc_html__( 'Boxed Layout', 'flash' ),
			),
		)
	);

	// Preloader
	$wp_customize->add_setting(
		'flash_disable_preloader',
		array(
			'default'           => '',
			'sanitize_callback' => 'flash_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'flash_disable_preloader',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__('Disable Preloader?', 'flash'),
			'section'     => 'flash_general_options',
			'description' => esc_html__('Check the box to disable preloader animation shown while opening the site.', 'flash'),
		)
	);

	// Back to top Button
	$wp_customize->add_setting(
		'flash_disable_back_to_top',
		array(
			'default'           => '',
			'sanitize_callback' => 'flash_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'flash_disable_back_to_top',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__('Disable Back to Top Button?', 'flash'),
			'section'     => 'flash_general_options',
			'description' => esc_html__('Check the box to disable back to top button.', 'flash'),
		)
	);

	// Top Header Options
	$wp_customize->add_section(
		'flash_top_header_options',
		array(
			'title'         => esc_html__( 'Top Header Settings', 'flash' ),
			'priority'      => 20,
			'panel'         => 'flash_theme_options',
			'description'   => esc_html__( 'Top Header Related Options', 'flash' ),
		)
	);

	$wp_customize->add_setting(
		'flash_top_header',
		array(
			'default'           => '1',
			'sanitize_callback' => 'flash_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'flash_top_header',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__('Enable Top Header', 'flash'),
			'section'     => 'flash_top_header_options',
			'description' => esc_html__('Check the box to show social menu and header contact info on top header section.', 'flash'),
		)
	);

	$wp_customize->add_setting(
		'flash_top_header_left',
		array(
			'default'           => 'disable',
			'sanitize_callback' => 'flash_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'flash_top_header_left',
		array(
			'type'        => 'select',
			'label'       => esc_html__('Top Header Left Content', 'flash'),
			'section'     => 'flash_top_header_options',
			'description' => esc_html__('Select content for Top Header Left Part.', 'flash'),
			'choices'     => array(
				'social-menu'    => esc_html__( 'Social Menu', 'flash' ),
				'header-text'    => esc_html__( 'Top Header Text', 'flash' ),
				'disable'        => esc_html__( 'Disable', 'flash' ),
			),
			'active_callback' => 'flash_top_header_active_filter',
		)
	);

	$wp_customize->add_setting(
		'flash_top_header_right',
		array(
			'default'           => 'disable',
			'sanitize_callback' => 'flash_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'flash_top_header_right',
		array(
			'type'        => 'select',
			'label'       => esc_html__('Top Header Right Content', 'flash'),
			'section'     => 'flash_top_header_options',
			'description' => esc_html__('Select content for Top Header Right Part.', 'flash'),
			'choices' => array(
				'social-menu'    => esc_html__( 'Social Menu', 'flash' ),
				'header-text'    => esc_html__( 'Top Header Text', 'flash' ),
				'disable'        => esc_html__( 'Disable', 'flash' ),
			),
			'active_callback' => 'flash_top_header_active_filter',
		)
	);

	// Header Text
	$wp_customize->add_setting(
		'flash_top_header_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'flash_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'flash_top_header_text',
		array(
			'type'            => 'textarea',
			'label'           => esc_html__('Top Header Text Content', 'flash'),
			'section'         => 'flash_top_header_options',
			'description'     => esc_html__('Add content for Top Header Text.', 'flash'),
			'active_callback' => 'flash_top_header_text_active_filter',
		)
	);

	// Header
	$wp_customize->add_section(
		'flash_header_options',
		array(
			'title'         => esc_html__( 'Header Settings', 'flash' ),
			'priority'      => 30,
			'panel'         => 'flash_theme_options',
		)
	);

	$wp_customize->add_setting(
		'flash_logo_position',
		array(
			'default'           => 'left-logo-right-menu',
			'sanitize_callback' => 'flash_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'flash_logo_position',
		array(
			'type'        => 'select',
			'label'       => esc_html__( 'Logo Position', 'flash' ),
			'section'     => 'flash_header_options',
			'description' => esc_html__('Select position for Header Menu.', 'flash'),
			'choices' => array(
				'left-logo-right-menu'     => esc_html__( 'Left Logo & Right Menu', 'flash' ),
				'right-logo-left-menu'     => esc_html__( 'Right Logo & Left Menu', 'flash' ),
				'center-logo-below-menu'   => esc_html__( 'Center Logo & Below Menu', 'flash' ),
			),
		)
	);

	// Header Search Icon
	$wp_customize->add_setting(
		'flash_header_search',
		array(
			'default'           => '',
			'sanitize_callback' => 'flash_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'flash_header_search',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Remove Header Search Box.', 'flash' ),
			'section'     => 'flash_header_options',
			'description' => esc_html__('Check the box to remove search icon near menu.', 'flash'),
		)
	);

	// Header Search Icon
	$wp_customize->add_setting(
		'flash_header_cart',
		array(
			'default'           => '',
			'sanitize_callback' => 'flash_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'flash_header_cart',
		array(
			'type'            => 'checkbox',
			'label'           => esc_html__( 'Remove Header Cart Icon.', 'flash' ),
			'section'         => 'flash_header_options',
			'description'     => esc_html__('Check the box to remove woocommerce cart icon near menu.', 'flash'),
			'active_callback' => 'flash_woocommerce_active_filter'
		)
	);

	// Header Search Icon
	$wp_customize->add_setting(
		'flash_sticky_header',
		array(
			'default'           => '',
			'sanitize_callback' => 'flash_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'flash_sticky_header',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Sticky Header', 'flash' ),
			'section'     => 'flash_header_options',
			'description' => esc_html__('Check the box to make the header section sticky when user scrolls down.', 'flash'),
		)
	);

	// Page Header
	$wp_customize->add_section(
		'flash_page_header_options',
		array(
			'title'         => esc_html__( 'Page Header Settings', 'flash' ),
			'priority'      => 30,
			'panel'         => 'flash_theme_options',
		)
	);

	// Breadcrumbs Option
	$wp_customize->add_setting(
		'flash_remove_breadcrumbs',
		array(
			'default'           => '',
			'sanitize_callback' => 'flash_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'flash_remove_breadcrumbs',
		array(
			'type'            => 'checkbox',
			'label'           => esc_html__( 'Remove breadcrumbs from page header', 'flash' ),
			'section'         => 'flash_page_header_options',
			'description'     => esc_html__('Check the box to remove breadcrumbs from page header.', 'flash'),
		)
	);

	// Pageheader background
	$wp_customize->add_setting(
		'flash_pageheader_background',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'flash_pageheader_background',
			array(
				'label'           => esc_html__( 'Pageheader background' , 'flash' ),
				'priority'        => 50,
				'section'         => 'flash_page_header_options',
			)
		)
	);

	// Blog Options
	$wp_customize->add_section(
		'flash_archive_options',
		array(
			'title'         => esc_html__( 'Archive Page Settings', 'flash' ),
			'priority'      => 40,
			'panel'         => 'flash_theme_options',
			'description'   => esc_html__( 'Blog Related Options', 'flash' ),
		)
	);

	$wp_customize->add_setting(
		'flash_blog_style',
		array(
			'default'           => 'classic-layout',
			'sanitize_callback' => 'flash_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'flash_blog_style',
		array(
			'type'        => 'select',
			'label'       => esc_html__( 'Blog Style', 'flash' ),
			'section'     => 'flash_archive_options',
			'description' => esc_html__( 'Select listing style for archive pages.', 'flash' ),
			'choices' => array(
				'classic-layout'      => esc_html__( 'Classic', 'flash' ),
				'full-width-archive'  => esc_html__( 'Classic Full Width Image', 'flash' ),
				'grid-view'           => esc_html__( 'Grid Layout', 'flash' ),
			),
		)
	);

	// Archive Layout
	$wp_customize->add_setting(
		'flash_archive_layout',
		array(
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'flash_sanitize_choices',
		)
	);

	// Add the layout control.
	$wp_customize->add_control(
		new Flash_Image_Radio_Control (
			$wp_customize,
			'flash_archive_layout',
			array(
				'label'   => esc_html__( 'Archive Page Layout', 'flash' ),
				'section' => 'flash_archive_options',
				'type'    => 'radio',
				'choices' => array(
					'right-sidebar'     => get_template_directory_uri() . '/images/right-sidebar.png',
					'left-sidebar'      => get_template_directory_uri() . '/images/left-sidebar.png',
					'full-width'        => get_template_directory_uri() . '/images/full-width.png',
					'full-width-center' => get_template_directory_uri() . '/images/full-width-center.png',
				)
			)
		)
	);

	// Post Meta Settings
	$wp_customize->add_setting(
		'flash_remove_meta_date',
		array(
			'default'           => '',
			'sanitize_callback' => 'flash_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'flash_remove_meta_date',
		array(
			'type'            => 'checkbox',
			'label'           => esc_html__( 'Remove date from post meta', 'flash' ),
			'section'         => 'flash_archive_options',
			'description'     => esc_html__('Check the box to remove date from post meta.', 'flash'),
		)
	);

	$wp_customize->add_setting(
		'flash_remove_meta_author',
		array(
			'default'           => '',
			'sanitize_callback' => 'flash_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'flash_remove_meta_author',
		array(
			'type'            => 'checkbox',
			'label'           => esc_html__( 'Remove author from post meta', 'flash' ),
			'section'         => 'flash_archive_options',
			'description'     => esc_html__('Check the box to remove author from post meta.', 'flash'),
		)
	);

	$wp_customize->add_setting(
		'flash_remove_meta_comment_count',
		array(
			'default'           => '',
			'sanitize_callback' => 'flash_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'flash_remove_meta_comment_count',
		array(
			'type'            => 'checkbox',
			'label'           => esc_html__( 'Remove comment count from post meta', 'flash' ),
			'section'         => 'flash_archive_options',
			'description'     => esc_html__('Check the box to remove comment count from post meta.', 'flash'),
		)
	);

	$wp_customize->add_setting(
		'flash_remove_meta_category',
		array(
			'default'           => '',
			'sanitize_callback' => 'flash_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'flash_remove_meta_category',
		array(
			'type'            => 'checkbox',
			'label'           => esc_html__( 'Remove category from post meta', 'flash' ),
			'section'         => 'flash_archive_options',
			'description'     => esc_html__('Check the box to remove category from post meta.', 'flash'),
		)
	);

	$wp_customize->add_setting(
		'flash_remove_meta_tag',
		array(
			'default'           => '',
			'sanitize_callback' => 'flash_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'flash_remove_meta_tag',
		array(
			'type'            => 'checkbox',
			'label'           => esc_html__( 'Remove tag from post meta', 'flash' ),
			'section'         => 'flash_archive_options',
			'description'     => esc_html__('Check the box to remove tag from post meta.', 'flash'),
		)
	);


	// Post Options
	$wp_customize->add_section(
		'flash_post_options',
		array(
			'title'         => esc_html__( 'Post Settings', 'flash' ),
			'priority'      => 50,
			'panel'         => 'flash_theme_options',
		)
	);

	// Post Layout
	$wp_customize->add_setting(
		'flash_post_layout',
		array(
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'flash_sanitize_choices',
		)
	);

	// Add the layout control.
	$wp_customize->add_control(
		new Flash_Image_Radio_Control (
			$wp_customize,
			'flash_post_layout',
			array(
				'label'   => esc_html__( 'Single Post Layout', 'flash' ),
				'section' => 'flash_post_options',
				'type'    => 'radio',
				'choices' => array(
					'right-sidebar'     => get_template_directory_uri() . '/images/right-sidebar.png',
					'left-sidebar'      => get_template_directory_uri() . '/images/left-sidebar.png',
					'full-width'        => get_template_directory_uri() . '/images/full-width.png',
					'full-width-center' => get_template_directory_uri() . '/images/full-width-center.png',
				)
			)
		)
	);

	$wp_customize->add_setting(
		'flash_remove_single_bio',
		array(
			'default'           => '',
			'sanitize_callback' => 'flash_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'flash_remove_single_bio',
		array(
			'type'            => 'checkbox',
			'label'           => esc_html__( 'Remove Author Bio from post', 'flash' ),
			'section'         => 'flash_post_options',
			'description'     => esc_html__('Check the box to remove Author Bio from post', 'flash'),
		)
	);

	$wp_customize->add_setting(
		'flash_remove_single_nav',
		array(
			'default'           => '',
			'sanitize_callback' => 'flash_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'flash_remove_single_nav',
		array(
			'type'            => 'checkbox',
			'label'           => esc_html__( 'Remove next/previous link from post', 'flash' ),
			'section'         => 'flash_post_options',
			'description'     => esc_html__('Check the box to remove next/previous link from post', 'flash'),
		)
	);

	// Page Options
	$wp_customize->add_section(
		'flash_page_options',
		array(
			'title'         => esc_html__( 'Page Settings', 'flash' ),
			'priority'      => 50,
			'panel'         => 'flash_theme_options',
		)
	);

		// Page Layout
	$wp_customize->add_setting(
		'flash_page_layout',
		array(
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'flash_sanitize_choices',
		)
	);

	// Add the layout control.
	$wp_customize->add_control(
		new Flash_Image_Radio_Control (
			$wp_customize,
			'flash_page_layout',
			array(
				'label'   => esc_html__( 'Page Layout', 'flash' ),
				'section' => 'flash_page_options',
				'type'    => 'radio',
				'choices' => array(
					'right-sidebar'     => get_template_directory_uri() . '/images/right-sidebar.png',
					'left-sidebar'      => get_template_directory_uri() . '/images/left-sidebar.png',
					'full-width'        => get_template_directory_uri() . '/images/full-width.png',
					'full-width-center' => get_template_directory_uri() . '/images/full-width-center.png',
				)
			)
		)
	);

	// Footer Options
	$wp_customize->add_section(
		'flash_footer_options',
		array(
			'title'         => esc_html__( 'Footer Settings', 'flash' ),
			'priority'      => 60,
			'panel'         => 'flash_theme_options',
			'description'   => esc_html__( 'Footer Related Options', 'flash' ),
		)
	);

	$wp_customize->add_setting(
		'flash_footer_widgets',
		array(
			'default'           => '4',
			'sanitize_callback' => 'flash_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'flash_footer_widgets',
		array(
			'type'        => 'select',
			'label'       => esc_html__( 'Footer Widget Area', 'flash' ),
			'section'     => 'flash_footer_options',
			'description' => esc_html__( 'Select Footer Widget Area Layout', 'flash' ),
			'choices' => array(
				'1'         => esc_html__( '1 Footer Widgets', 'flash' ),
				'2'         => esc_html__( '2 Footer Widgets', 'flash' ),
				'3'         => esc_html__( '3 Footer Widgets', 'flash' ),
				'4'         => esc_html__( '4 Footer Widgets', 'flash' ),
			),
		)
	);

	// Typography Options
	$flash_fonts_families = array(
		'flash_body_font' => array(
			'id'      => 'flash_body_font',
			'default' => 'Montserrat:400,700',
			'title'   => esc_html__( 'Body font. Default is "Montserrat".', 'flash' ),
		)
	);

	// Google Fonts Options
	$wp_customize->add_section(
		'flash_google_font_section',
		array(
			'priority' => 70,
			'title'    => esc_html__( 'Google Font Settings', 'flash' ),
			'panel'    => 'flash_theme_options'
		)
	);

	// Typography Options
	$flash_fonts_families = array(
		'flash_body_font' => array(
			'id'      => 'flash_body_font',
			'default' => 'Montserrat:400,700',
			'title'   => esc_html__( 'Body font. Default is "Montserrat".', 'flash' ),
		)
	);

	// Google Fonts Options
	$wp_customize->add_section(
		'flash_google_font_section',
		array(
			'priority' => 70,
			'title'    => esc_html__( 'Google Font Settings', 'flash' ),
			'panel'    => 'flash_theme_options'
		)
	);

	foreach ($flash_fonts_families as $flash_fonts_family) {

		$wp_customize->add_setting(
			$flash_fonts_family['id'],
			array(
				'default' => $flash_fonts_family['default'],
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'flash_fonts_sanitize'
			)
		);

		$flash_google_fonts_family = flash_google_fonts();

		$wp_customize->add_control($flash_fonts_family['id'],
			array(
				'label'   => $flash_fonts_family['title'],
				'type'    => 'select',
				'section' => 'flash_google_font_section',
				'setting' => $flash_fonts_family['id'],
				'choices' => $flash_google_fonts_family
			)
		);
	}

	// Advanced Options
	$wp_customize->add_section(
		'flash_advanced_section',
		array(
			'priority' => 80,
			'title'    => esc_html__( 'Advanced Settings', 'flash' ),
			'panel'    => 'flash_theme_options'
		)
	);

	$wp_customize->add_setting(
		'flash_custom_css',
		array(
			'default'              => '',
			'sanitize_callback'    => 'wp_filter_nohtml_kses',
			'sanitize_js_callback' => 'wp_filter_nohtml_kses'
		)
	);

	$wp_customize->add_control(
		'flash_custom_css',
		array(
			'type'            => 'textarea',
			'label'           => esc_html__('Custom CSS', 'flash'),
			'section'         => 'flash_advanced_section',
		)
	);
}
add_action( 'customize_register', 'flash_customize_register' );


// Sanitize Choices
function flash_sanitize_choices( $input, $setting ) {
	global $wp_customize;

	$control = $wp_customize->get_control( $setting->id );

	if ( array_key_exists( $input, $control->choices ) ) {
		return $input;
	} else {
		return $setting->default;
	}
}

// Sanitize Checkbox
function flash_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return '';
	}
}

// Sanitize Text
function flash_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

// Top Header Active callback
function flash_top_header_active_filter(){
	if ( ( get_theme_mod( 'flash_top_header', '' ) == '1' )  ) {
		return true;
	}
}

// Top Header Text Active Callback
function flash_top_header_text_active_filter() {
	if ( ( get_theme_mod( 'flash_top_header', '' ) == '1' )  ) {
		if( ( get_theme_mod( 'flash_top_header_left', 'disable' ) == 'header-text' ) || ( get_theme_mod( 'flash_top_header_right', 'disable' ) == 'header-text' ) ) {
			return true;
		}
	} else {
		return false;
	}
}

// Header Cart Icon Active Callback
function flash_woocommerce_active_filter() {
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		return true;
	} else {
		return false;
	}
}

function flash_pageheader_active_filter() {
	if ( ( get_theme_mod( 'flash_pageheader', '' ) == '1' )  ) {
		return true;
	}
}

// google fonts sanitize
function flash_fonts_sanitize( $input, $setting ) {
  // Get the list of choices from the control associated with the setting.
  $choices = $setting->manager->get_control( $setting->id )->choices;
  // If the input is a valid key, return it, else, return the default.
  return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}


/**
 * Registers color schemes for Flash.
 *
 * Can be filtered with {@see 'flash_color_schemes'}.
 *
 * The order of colors in a colors array:
 * 1. Main Background Color.
 * 2. Link Color.
 * 3. Main Text Color.
 * 4. Secondary Text Color.
 *
 * @since Flash 1.0
 *
 * @return array An associative array of color scheme options.
 */
function flash_get_color_schemes() {
	/**
	 * Filter the color schemes registered for use with Flash.
	 *
	 * The default schemes include 'default', 'dark', 'gray', 'red', and 'yellow'.
	 *
	 * @since Flash 1.0
	 *
	 * @param array $schemes {
	 *     Associative array of color schemes data.
	 *
	 *     @type array $slug {
	 *         Associative array of information for setting up the color scheme.
	 *
	 *         @type string $label  Color scheme label.
	 *         @type array  $colors HEX codes for default colors prepended with a hash symbol ('#').
	 *                              Colors are defined in the following order: Main background, page
	 *                              background, link, main text, secondary text.
	 *     }
	 * }
	 */
	return apply_filters( 'flash_color_schemes', array(
		'default' => array(
			'label'  => esc_html__( 'Default', 'flash' ),
			'colors' => array(
				'#ffffff',
				'#30AFB8',
				'#313b48',
				'#666666',
			),
		),
		'dark' => array(
			'label'  => esc_html__( 'Dark', 'flash' ),
			'colors' => array(
				'#272727',
				'#ffffff',
				'#ffffff',
				'#fefefe',
			),
		),
		'gray' => array(
			'label'  => esc_html__( 'Gray', 'flash' ),
			'colors' => array(
				'#616a73',
				'#c7c7c7',
				'#f2f2f2',
				'#f2f2f2',
			),
		),
		'red' => array(
			'label'  => esc_html__( 'Red', 'flash' ),
			'colors' => array(
				'#ffffff',
				'#F54337',
				'#333333',
				'#777777',
			),
		),
		'yellow' => array(
			'label'  => esc_html__( 'Yellow', 'flash' ),
			'colors' => array(
				'#ffffff',
				'#EFCA23',
				'#313b48',
				'#666666',
			),
		),
	) );
}

if ( ! function_exists( 'flash_get_color_scheme' ) ) :
/**
 * Retrieves the current Flash color scheme.
 *
 * Create your own flash_get_color_scheme() function to override in a child theme.
 *
 * @since Flash 1.0
 *
 * @return array An associative array of either the current or default color scheme HEX values.
 */
function flash_get_color_scheme() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );
	$color_schemes       = flash_get_color_schemes();

	if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
		return $color_schemes[ $color_scheme_option ]['colors'];
	}

	return $color_schemes['default']['colors'];
}
endif; // flash_get_color_scheme

if ( ! function_exists( 'flash_get_color_scheme_choices' ) ) :
/**
 * Retrieves an array of color scheme choices registered for Flash.
 *
 * Create your own flash_get_color_scheme_choices() function to override
 * in a child theme.
 *
 * @since Flash 1.0
 *
 * @return array Array of color schemes.
 */
function flash_get_color_scheme_choices() {
	$color_schemes                = flash_get_color_schemes();
	$color_scheme_control_options = array();

	foreach ( $color_schemes as $color_scheme => $value ) {
		$color_scheme_control_options[ $color_scheme ] = $value['label'];
	}

	return $color_scheme_control_options;
}
endif; // flash_get_color_scheme_choices


if ( ! function_exists( 'flash_sanitize_color_scheme' ) ) :
/**
 * Handles sanitization for Flash color schemes.
 *
 * Create your own flash_sanitize_color_scheme() function to override
 * in a child theme.
 *
 * @since Flash 1.0
 *
 * @param string $value Color scheme name value.
 * @return string Color scheme name.
 */
function flash_sanitize_color_scheme( $value ) {
	$color_schemes = flash_get_color_scheme_choices();

	if ( ! array_key_exists( $value, $color_schemes ) ) {
		return 'default';
	}

	return $value;
}
endif; // flash_sanitize_color_scheme


if ( ! function_exists( 'flash_google_fonts' ) ) :
/**
 * Custom google fonts.
 */
	function flash_google_fonts() {

		$flash_googlefonts = array(
			"Montserrat:400,700"    => "Montserrat",
			"Raleway:400,600,700"	=> "Raleway",
			"Ruda:400,700"          => "Ruda"
		);

	   return $flash_googlefonts;
	}
endif;


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function flash_customize_preview_scripts() {
	wp_enqueue_script( 'flash-customizer-js', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
	wp_enqueue_script( 'flash-color-scheme-control', get_template_directory_uri() . '/js/color-scheme-control.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '20160816', true );
	wp_localize_script( 'flash-color-scheme-control', 'colorScheme', flash_get_color_schemes() );
}
add_action( 'customize_controls_enqueue_scripts', 'flash_customize_preview_scripts', 99 );

/**
 * Enqueues front-end CSS for color scheme.
 *
 * @since Flash 1.0
 *
 * @see wp_add_inline_style()
 */
function flash_color_scheme_css() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );

	// Don't do anything if the default color scheme is selected.
	if ( 'default' === $color_scheme_option ) {
		return;
	}

	$color_scheme = flash_get_color_scheme();

	// Convert main text hex color to rgba.
	$color_textcolor_rgb = flash_hex2rgb( $color_scheme[2] );

	// If the rgba values are empty return early.
	if ( empty( $color_textcolor_rgb ) ) {
		return;
	}

	// If we get this far, we have a custom color scheme.
	$colors = array(
		'background_color'      => $color_scheme[0],
		'link_color'            => $color_scheme[1],
		'main_text_color'       => $color_scheme[2],
		'secondary_text_color'  => $color_scheme[3],
		'border_color'          => vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.2)', $color_textcolor_rgb ),

	);

	$color_scheme_css = flash_get_color_scheme_css( $colors );

	wp_add_inline_style( 'flash-style', $color_scheme_css );
}

/**
 * Returns CSS for the color schemes.
 *
 * @since Flash 1.0
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function flash_get_color_scheme_css( $colors ) {
	$colors = wp_parse_args( $colors, array(
		'background_color'      => '',
		'link_color'            => '',
		'main_text_color'       => '',
		'secondary_text_color'  => '',
		'border_color'          => '',
	) );

	return <<<CSS
	/* Color Scheme */

	/* Background Color */
	body {
		background-color: {$colors['background_color']};
	}

	/* Link Color */
	#site-navigation ul li:hover > a,#site-navigation ul li.current-menu-item > a,#site-navigation ul li.current_page_item  > a,#site-navigation ul.sub-menu li:hover > a,#site-navigation ul li ul.sub-menu li.menu-item-has-children ul li:hover > a,#site-navigation ul li ul.sub-menu li.menu-item-has-children:hover > .menu-item,body.transparent #masthead .header-bottom #site-navigation ul li:hover > .menu-item,body.transparent #masthead .header-bottom #site-navigation ul li:hover > a,body.transparent #masthead .header-bottom #site-navigation ul.sub-menu li:hover > a,body.transparent #masthead .header-bottom #site-navigation ul.sub-menu li.menu-item-has-children ul li:hover > a,body.transparent.header-sticky #masthead-sticky-wrapper #masthead .header-bottom #site-navigation ul.sub-menu li > a:hover,.tg-service-widget .service-title-wrap a:hover,.tg-service-widget .service-more,.feature-product-section .button-group button:hover ,.fun-facts-section .fun-facts-icon-wrap,.fun-facts-section .tg-fun-facts-widget.tg-fun-facts-layout-2 .counter-wrapper,.blog-section .row:nth-child(odd) .blog-content .entry-title a:hover,.blog-section .row:nth-child(even) .blog-content .entry-title a:hover ,.blog-section .tg-blog-widget-layout-2 .blog-content .read-more-container .read-more a,footer.footer-layout #top-footer .widget-title::first-letter,footer.footer-layout #top-footer .widget ul li a:hover,footer.footer-layout #bottom-footer .copyright .copyright-text a:hover,footer.footer-layout #bottom-footer .footer-menu ul li a:hover,.archive #primary .entry-content-block h2.entry-title a:hover,.blog #primary .entry-content-block h2.entry-title a:hover,#secondary .widget ul li a:hover,.woocommerce-Price-amount.amount,.team-wrapper .team-content-wrapper .team-social a:hover,.testimonial-container .testimonial-wrapper .testimonial-slide .testominial-content-wrapper .testimonial-icon,.footer-menu li a:hover,.tg-feature-product-filter-layout .button.is-checked:hover{
		color: {$colors['link_color']};
	}

	.feature-product-section .tg-feature-product-layout-2 .tg-container .tg-column-wrapper .tg-feature-product-widget .featured-image-desc, #respond #commentform .form-submit input:hover, .blog-section .tg-blog-widget-layout-1 .tg-blog-widget:hover,#scroll-up,.header-bottom .search-wrap .search-box .searchform .btn:hover,.header-bottom .cart-wrap .flash-cart-views a span,body.transparent #masthead .header-bottom #site-navigation ul li a::before,.tg-slider-widget.slider-dark .swiper-wrapper .slider-content .btn-wrapper a:hover,.section-title-wrapper .section-title:after,.about-section .about-content-wrapper .btn-wrapper a,.tg-service-widget .service-icon-wrap,.team-wrapper .team-content-wrapper .team-designation:after,.call-to-action-section .btn-wrapper a:hover,.blog-section .tg-blog-widget-layout-1:hover,.blog-section .tg-blog-widget-layout-2 .post-image .entry-date,.blog-section .tg-blog-widget-layout-2 .blog-content .post-readmore,.pricing-table-section .tg-pricing-table-widget:hover,.pricing-table-section .tg-pricing-table-widget.tg-pricing-table-layout-2 .pricing,.pricing-table-section .tg-pricing-table-widget.tg-pricing-table-layout-2 .btn-wrapper a,footer.footer-layout #top-footer .widget_tag_cloud .tagcloud a:hover,#secondary .widget-title:after,
#secondary .searchform .btn:hover,#primary .searchform .btn:hover,  #respond #commentform .form-submit input,.woocommerce ul.products li.product .onsale,.woocommerce ul.products li.product .button,.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt,.added_to_cart.wc-forward,.testimonial-container .swiper-pagination.testimonial-pager .swiper-pagination-bullet:hover, .testimonial-container .swiper-pagination.testimonial-pager .swiper-pagination-bullet.swiper-pagination-bullet-active  {
		background-color: {$colors['link_color']};
	}
	body.transparent.header-sticky #masthead-sticky-wrapper #masthead .header-bottom .search-wrap .search-icon:hover, body.transparent #masthead .header-bottom .search-wrap .search-icon:hover, .header-bottom .search-wrap .search-icon:hover {
	  border-color: {$colors['link_color']};
	}
	body.transparent.header-sticky #masthead-sticky-wrapper.is-sticky #masthead .header-bottom #site-navigation ul li.current-flash-item a,#site-navigation ul li.current-flash-item a, body.transparent.header-sticky #masthead-sticky-wrapper #masthead .header-bottom .search-wrap .search-icon:hover, body.transparent #masthead .header-bottom .search-wrap .search-icon:hover, .header-bottom .search-wrap .search-icon:hover {
	  color: {$colors['link_color']};
	}
	.tg-slider-widget.slider-dark .swiper-wrapper .slider-content .btn-wrapper a:hover,.call-to-action-section .btn-wrapper a:hover,footer.footer-layout #top-footer .widget_tag_cloud .tagcloud a:hover {
		border-color: {$colors['link_color']};
	}
	body.transparent.header-sticky #masthead-sticky-wrapper #masthead .header-bottom #site-navigation ul li:hover > a,body.transparent #masthead .header-bottom #site-navigation ul li:hover .sub-toggle{
		color: {$colors['link_color']};
	}

	.tg-service-widget .service-icon-wrap:after{
			border-top-color: {$colors['link_color']};
		}

	.feature-product-section .tg-feature-product-widget .featured-image-desc::before,.blog-section .row:nth-child(odd) .tg-blog-widget:hover .post-image::before,.blog-section .row:nth-child(2n) .tg-blog-widget:hover .post-image::before{
			border-right-color: {$colors['link_color']};
		}

	.feature-product-section .tg-feature-product-widget .featured-image-desc::before,.blog-section .row:nth-child(odd) .tg-blog-widget:hover .post-image::before,footer.footer-layout #top-footer .widget-title{
		border-left-color: {$colors['link_color']};
	}

	/* Main Text Color */
	.tg-slider-widget .swiper-button-next::before,.tg-slider-widget .swiper-button-prev::before,.tg-slider-widget .swiper-wrapper .slider-content .caption-title,.section-title-wrapper .section-title,.tg-service-widget .service-title-wrap a ,.team-wrapper .team-content-wrapper .team-title a,.testimonial-container .testimonial-wrapper .testimonial-slide .testimonial-client-detail .client-detail-block .testimonial-title,.blog-section .row:nth-child(odd) .blog-content .entry-title a,.blog-section .row:nth-child(even) .blog-content .entry-title a,.blog-section .tg-blog-widget:hover .blog-content .entry-title a:hover,.blog-section .tg-blog-widget-layout-2:hover .blog-content .entry-title a,.pricing-table-section .tg-pricing-table-widget .pricing-table-title ,.pricing-table-section .tg-pricing-table-widget .pricing,.pricing-table-section .tg-pricing-table-widget .btn-wrapper a,.pricing-table-section .tg-pricing-table-widget.standard .popular-batch,.single-post #primary .author-description .author-description-block .author-title,.section-title-wrapper .section-title,.tg-service-widget .service-title-wrap a,.tg-service-widget .service-title-wrap a {
		color: {$colors['main_text_color']};
	}

	.tg-slider-widget .swiper-wrapper .slider-content .btn-wrapper a,.tg-slider-widget .swiper-wrapper .slider-content .btn-wrapper a:hover {
		border-color: {$colors['main_text_color']};
	}

	.header-bottom .search-wrap .search-box .searchform .btn,.tg-slider-widget .swiper-wrapper .slider-content .btn-wrapper a:hover,.testimonial-container .swiper-pagination.testimonial-pager .swiper-pagination-bullet{
		background-color: {$colors['main_text_color']};
	}

	.feature-product-section .tg-feature-product-layout-2 .tg-container .tg-column-wrapper .tg-feature-product-widget .featured-image-desc::before{
		border-right-color: {$colors['main_text_color']};
	}

	/* Secondary Text Color */
	.tg-service-widget .service-content-wrap,.section-title-wrapper .section-description,.team-wrapper .team-content-wrapper .team-content,.testimonial-container .testimonial-wrapper .testimonial-slide .testominial-content-wrapper .testimonial-content,body, button, input, select, textarea,.archive #primary .entry-content-block .entry-content, .blog #primary .entry-content-block .entry-content {
		color: {$colors['secondary_text_color']};
	}
	@media(max-width: 980px){
		#site-navigation ul li.menu-item-has-children .sub-toggle{
			background-color: {$colors['link_color']};
		}
	}

	@media screen and (min-width: 56.875em) {
		.main-navigation li:hover > a,
		.main-navigation li.focus > a {
			color: {$colors['link_color']};
		}

		.main-navigation ul ul,
		.main-navigation ul ul li {
			border-color: {$colors['border_color']};
		}

		.main-navigation ul ul:before {
			border-top-color: {$colors['border_color']};
			border-bottom-color: {$colors['border_color']};
		}
	}

CSS;
}

/**
 * Outputs an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 *
 * @since Flash 1.0
 */
function flash_color_scheme_css_template() {
	$colors = array(
		'background_color'      => '{{ data.background_color }}',
		'link_color'            => '{{ data.link_color }}',
		'main_text_color'       => '{{ data.main_text_color }}',
		'secondary_text_color'  => '{{ data.secondary_text_color }}',
		'border_color'          => '{{ data.border_color }}',
	);
	?>
	<script type="text/html" id="tmpl-flash-color-scheme">
		<?php echo flash_get_color_scheme_css( $colors ); ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'flash_color_scheme_css_template' );

/**
 * Enqueues front-end CSS for the link color.
 *
 * @since Flash 1.0
 *
 * @see wp_add_inline_style()
 */
function flash_link_color_css() {
	$color_scheme    = flash_get_color_scheme();
	$default_color   = $color_scheme[1];
	$link_color = get_theme_mod( 'link_color', $default_color );

	// Convert link color to rgba.
	$link_color_rgb = flash_hex2rgb( $link_color );

	// Generate Darker Color
	$link_color_dark = flash_darkcolor( $link_color, -20 );

	// If we get this far, we have a custom color scheme.
	$border_color = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.8)', $link_color_rgb );

	$css = '
	/* Link Color */
		#site-navigation ul li:hover > a,#site-navigation ul li.current-menu-item > a,#site-navigation ul li.current_page_item  > a,#site-navigation ul.sub-menu li:hover > a,#site-navigation ul li ul.sub-menu li.menu-item-has-children ul li:hover > a,#site-navigation ul li ul.sub-menu li.menu-item-has-children:hover > .menu-item,body.transparent #masthead .header-bottom #site-navigation ul li:hover > .menu-item,body.transparent #masthead .header-bottom #site-navigation ul li:hover > a,body.transparent #masthead .header-bottom #site-navigation ul.sub-menu li:hover > a,body.transparent #masthead .header-bottom #site-navigation ul.sub-menu li.menu-item-has-children ul li:hover > a,body.transparent.header-sticky #masthead-sticky-wrapper #masthead .header-bottom #site-navigation ul.sub-menu li > a:hover,.tg-service-widget .service-title-wrap a:hover,.tg-service-widget .service-more,.feature-product-section .button-group button:hover ,.fun-facts-section .fun-facts-icon-wrap,.fun-facts-section .tg-fun-facts-widget.tg-fun-facts-layout-2 .counter-wrapper,.blog-section .row:nth-child(odd) .blog-content .entry-title a:hover,.blog-section .row:nth-child(even) .blog-content .entry-title a:hover ,.blog-section .tg-blog-widget-layout-2 .blog-content .read-more-container .read-more a,footer.footer-layout #top-footer .widget-title::first-letter,footer.footer-layout #top-footer .widget ul li a:hover,footer.footer-layout #bottom-footer .copyright .copyright-text a:hover,footer.footer-layout #bottom-footer .footer-menu ul li a:hover,.archive #primary .entry-content-block h2.entry-title a:hover,.blog #primary .entry-content-block h2.entry-title a:hover,#secondary .widget ul li a:hover,.woocommerce-Price-amount.amount,.team-wrapper .team-content-wrapper .team-social a:hover,.testimonial-container .testimonial-wrapper .testimonial-slide .testominial-content-wrapper .testimonial-icon,.footer-menu li a:hover,.tg-feature-product-filter-layout .button.is-checked:hover{
		color: %1$s;
	}

	.blog-section .tg-blog-widget-layout-1 .tg-blog-widget:hover, #scroll-up,.header-bottom .search-wrap .search-box .searchform .btn:hover,.header-bottom .cart-wrap .flash-cart-views a span,body.transparent #masthead .header-bottom #site-navigation ul li a::before,.tg-slider-widget.slider-dark .swiper-wrapper .slider-content .btn-wrapper a:hover,.section-title-wrapper .section-title:after,.about-section .about-content-wrapper .btn-wrapper a,.tg-service-widget .service-icon-wrap,.team-wrapper .team-content-wrapper .team-designation:after,.call-to-action-section .btn-wrapper a:hover,.blog-section .tg-blog-widget-layout-1:hover,.blog-section .tg-blog-widget-layout-2 .post-image .entry-date,.blog-section .tg-blog-widget-layout-2 .blog-content .post-readmore,.pricing-table-section .tg-pricing-table-widget:hover,.pricing-table-section .tg-pricing-table-widget.tg-pricing-table-layout-2 .pricing,.pricing-table-section .tg-pricing-table-widget.tg-pricing-table-layout-2 .btn-wrapper a,footer.footer-layout #top-footer .widget_tag_cloud .tagcloud a:hover,#secondary .widget-title:after, #secondary .searchform .btn:hover,#primary .searchform .btn:hover,  #respond #commentform .form-submit input,.woocommerce ul.products li.product .onsale,.woocommerce ul.products li.product .button,.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt,.added_to_cart.wc-forward,.testimonial-container .swiper-pagination.testimonial-pager .swiper-pagination-bullet:hover, .testimonial-container .swiper-pagination.testimonial-pager .swiper-pagination-bullet.swiper-pagination-bullet-active  {
		background-color: %1$s;
	}
	.feature-product-section .tg-feature-product-layout-2 .tg-container .tg-column-wrapper .tg-feature-product-widget .featured-image-desc, .tg-team-widget.tg-team-layout-3 .team-wrapper .team-img .team-social {
		background-color: %2$s;
	}
	#respond #commentform .form-submit input:hover{
	background-color: %3$s;
	}

	.tg-slider-widget.slider-dark .swiper-wrapper .slider-content .btn-wrapper a:hover,.call-to-action-section .btn-wrapper a:hover,footer.footer-layout #top-footer .widget_tag_cloud .tagcloud a:hover {
		border-color: %1$s;
	}
	body.transparent.header-sticky #masthead-sticky-wrapper.is-sticky #masthead .header-bottom #site-navigation ul li.current-flash-item a, #site-navigation ul li.current-flash-item a, body.transparent.header-sticky #masthead-sticky-wrapper #masthead .header-bottom #site-navigation ul li:hover > a,body.transparent #masthead .header-bottom #site-navigation ul li:hover .sub-toggle{
			color: %1$s;
		}

	.tg-service-widget .service-icon-wrap:after{
			border-top-color: %1$s;
		}
	body.transparent.header-sticky #masthead-sticky-wrapper #masthead .header-bottom .search-wrap .search-icon:hover, body.transparent #masthead .header-bottom .search-wrap .search-icon:hover, .header-bottom .search-wrap .search-icon:hover {
	  border-color: %1$s;
	}
	body.transparent.header-sticky #masthead-sticky-wrapper #masthead .header-bottom .search-wrap .search-icon:hover, body.transparent #masthead .header-bottom .search-wrap .search-icon:hover, .header-bottom .search-wrap .search-icon:hover {
	  color: %1$s;
	}

	.feature-product-section .tg-feature-product-widget .featured-image-desc::before,.blog-section .row:nth-child(odd) .tg-blog-widget:hover .post-image::before{
			border-right-color: %1$s;
		}
	.feature-product-section .tg-feature-product-widget .featured-image-desc::before,.blog-section .row:nth-child(odd) .tg-blog-widget:hover .post-image::before,footer.footer-layout #top-footer .widget-title,.blog-section .row:nth-child(2n) .tg-blog-widget:hover .post-image::before{
		border-left-color: %1$s;
	}
	@media(max-width: 980px){
		#site-navigation ul li.menu-item-has-children .sub-toggle{
			background-color: %1$s;
		}
	}

		@media screen and (min-width: 56.875em) {
			.main-navigation li:hover > a,
			.main-navigation li.focus > a {
				color: %1$s;
			}
		}
	';

	wp_add_inline_style( 'flash-style', sprintf( $css, $link_color, $border_color, $link_color_dark ) );
}
add_action( 'wp_enqueue_scripts', 'flash_link_color_css', 11 );

/**
 * Enqueues front-end CSS for the main text color.
 *
 * @since Flash 1.0
 *
 * @see wp_add_inline_style()
 */
function flash_main_text_color_css() {
	$color_scheme    = flash_get_color_scheme();
	$default_color   = $color_scheme[2];
	$main_text_color = get_theme_mod( 'main_text_color', $default_color );

	// Convert main text hex color to rgba.
	$main_text_color_rgb = flash_hex2rgb( $main_text_color );

	// If the rgba values are empty return early.
	if ( empty( $main_text_color_rgb ) ) {
		return;
	}

	// If we get this far, we have a custom color scheme.
	$border_color = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.2)', $main_text_color_rgb );

	$css = '
		/* Main Text Color */
		.tg-slider-widget .swiper-button-next::before,.tg-slider-widget .swiper-button-prev::before,.tg-slider-widget .swiper-wrapper .slider-content .caption-title,.section-title-wrapper .section-title,.tg-service-widget .service-title-wrap a ,.team-wrapper .team-content-wrapper .team-title a,.testimonial-container .testimonial-wrapper .testimonial-slide .testimonial-client-detail .client-detail-block .testimonial-title,.blog-section .row:nth-child(odd) .blog-content .entry-title a,.blog-section .row:nth-child(even) .blog-content .entry-title a,.blog-section .tg-blog-widget:hover .blog-content .entry-title a:hover,.blog-section .tg-blog-widget-layout-2:hover .blog-content .entry-title a,.pricing-table-section .tg-pricing-table-widget .pricing-table-title ,.pricing-table-section .tg-pricing-table-widget .pricing,.pricing-table-section .tg-pricing-table-widget .btn-wrapper a,.pricing-table-section .tg-pricing-table-widget.standard .popular-batch,.single-post #primary .author-description .author-description-block .author-title,.section-title-wrapper .section-title,.tg-service-widget .service-title-wrap a,.tg-service-widget .service-title-wrap a {
			color: %1$s;
		}

		.tg-slider-widget .swiper-wrapper .slider-content .btn-wrapper a,.tg-slider-widget .swiper-wrapper .slider-content .btn-wrapper a:hover {
			border-color: %1$s;
		}

		.header-bottom .search-wrap .search-box .searchform .btn,.tg-slider-widget .swiper-wrapper .slider-content .btn-wrapper a:hover,.testimonial-container .swiper-pagination.testimonial-pager .swiper-pagination-bullet{
			background-color: %1$s;
		}

		.feature-product-section .tg-feature-product-layout-2 .tg-container .tg-column-wrapper .tg-feature-product-widget .featured-image-desc::before{
			border-right-color: %1$s;
		}

	';

	wp_add_inline_style( 'flash-style', sprintf( $css, $main_text_color, $border_color ) );
}
add_action( 'wp_enqueue_scripts', 'flash_main_text_color_css', 12 );

/**
 * Enqueues front-end CSS for the secondary text color.
 *
 * @since Flash 1.0
 *
 * @see wp_add_inline_style()
 */
function flash_secondary_text_color_css() {
	$color_scheme    = flash_get_color_scheme();
	$default_color   = $color_scheme[3];
	$secondary_text_color = get_theme_mod( 'secondary_text_color', $default_color );

	$css = '
		/* Secondary Text Color */
		.tg-service-widget .service-content-wrap,.section-title-wrapper .section-description,.team-wrapper .team-content-wrapper .team-content,.testimonial-container .testimonial-wrapper .testimonial-slide .testominial-content-wrapper .testimonial-content,body, button, input, select, textarea,.archive #primary .entry-content-block .entry-content, .blog #primary .entry-content-block .entry-content {
			color: %1$s;
		}
	';

	wp_add_inline_style( 'flash-style', sprintf( $css, $secondary_text_color ) );
}
add_action( 'wp_enqueue_scripts', 'flash_secondary_text_color_css', 13 );
/**
 * Enqueues front-end CSS for the other settings.
 *
 * @since Flash 1.0
 *
 * @see wp_add_inline_style()
 */
function flash_frontend_css() {
	$pageheader_background = get_theme_mod( 'flash_pageheader_background', '' );
	$customizer_input_css  = get_theme_mod( 'flash_custom_css', '' );
	$css = '';
	// Don't do anything if the pageheader image is not uploaded.
	if ( $pageheader_background ) {
	$css .= '
		/* Pageheader Background */
		#flash-breadcrumbs {
			background-image: url('.esc_url($pageheader_background).');
			color: #fff;
		}
		#flash-breadcrumbs a,
		#flash-breadcrumbs span,
		.breadcrumb-trail.breadcrumbs .trail-items li span::before{
			color: #fff;
		}
	';
	}

	if ( !display_header_text() ) {
		$css .= '
		/* Site Title */
		.site-branding {
			margin: 0 auto 0 0;
		}

		.site-branding .site-title,
		.site-description {
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute !important;
			height: 1px;
			width: 1px;
			overflow: hidden;
		}
		';
	}

	if( $customizer_input_css ) {
		$css .= '
		/* Custom CSS */
		'.$customizer_input_css.'
		';
	}

	if( !empty( $css ) ) {
		wp_add_inline_style( 'flash-style', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'flash_frontend_css', 14 );
