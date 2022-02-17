<?php
/**
 * Flash Theme Customizer.
 *
 * @package Flash
 */

/**
 * Configuration for Kirki Toolkit
 */
function flash_kirki_configuration() {
	return array( 'url_path' => get_template_directory_uri() . '/inc/kirki/' );
}

add_filter( 'kirki/config', 'flash_kirki_configuration' );

if ( ! class_exists( 'Kirki' ) ) {
	exit;
}

/** Flash Kirki Config */
Kirki::add_config(
	'flash_config',
	array(
		'capability'  => 'edit_theme_options',
		'option_type' => 'theme_mod',
	)
);

/** Panel Global **/
Kirki::add_panel(
	'flash_global',
	array(
		'title'    => esc_html__( 'Global', 'flash' ),
		'priority' => 10,
	)
);

/** Section Colors - Needs to be section. */
Kirki::add_panel(
	'flash_colors',
	array(
		'title'    => esc_html__( 'Colors', 'flash' ),
		'panel'    => 'flash_global',
		'priority' => 10,
	)
);

// Sub-section - Base Colors.
Kirki::add_section(
	'flash_base_colors',
	array(
		'title'      => esc_html__( 'Base Colors', 'flash' ),
		'panel'      => 'flash_colors',
		'capability' => 'edit_theme_options',
	)
);

// Sub-section - Heading Colors.
Kirki::add_section(
	'flash_heading_colors',
	array(
		'title'      => esc_html__( 'Heading Colors', 'flash' ),
		'panel'      => 'flash_colors',
		'capability' => 'edit_theme_options',
	)
);

/** Section Background - Needs to be section. */
Kirki::add_section(
	'flash_background',
	array(
		'title'      => esc_html__( 'Background', 'flash' ),
		'panel'      => 'flash_global',
		'capability' => 'edit_theme_options',
	)
);

/** Section Layout - Needs to be section. */
Kirki::add_panel(
	'flash_layout',
	array(
		'title'      => esc_html__( 'Layout', 'flash' ),
		'panel'      => 'flash_global',
		'capability' => 'edit_theme_options',
		'priority'   => 20,
	)
);

// Sub-section - Site Layout.
Kirki::add_section(
	'flash_site_layout',
	array(
		'title'      => esc_html__( 'Site Layout', 'flash' ),
		'panel'      => 'flash_layout',
		'capability' => 'edit_theme_options',
	)
);

// Setting - Flash site layout.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'radio-buttonset',
		'settings' => 'flash_site_layout',
		'label'    => esc_html__( 'Container Style', 'flash' ),
		'section'  => 'flash_site_layout',
		'default'  => 'wide',
		'priority' => 10,
		'multiple' => 1,
		'choices'  => array(
			'wide'  => esc_attr__( 'Wide Layout', 'flash' ),
			'boxed' => esc_attr__( 'Boxed Layout', 'flash' ),
		),
	)
);

// Sub-section - Sidebar Layout.
Kirki::add_section(
	'flash_sidebar_layout',
	array(
		'title'      => esc_html__( 'Sidebar Layout', 'flash' ),
		'panel'      => 'flash_layout',
		'capability' => 'edit_theme_options',
	)
);

// Setting - Page Layout.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'radio-image',
		'settings' => 'flash_page_layout',
		'label'    => esc_html__( 'Page', 'flash' ),
		'section'  => 'flash_sidebar_layout',
		'default'  => 'right-sidebar',
		'priority' => 10,
		'multiple' => 1,
		'choices'  => array(
			'right-sidebar'     => get_template_directory_uri() . '/images/right-sidebar.png',
			'left-sidebar'      => get_template_directory_uri() . '/images/left-sidebar.png',
			'full-width'        => get_template_directory_uri() . '/images/full-width.png',
			'full-width-center' => get_template_directory_uri() . '/images/full-width-center.png',
		),
	)
);

// Setting - Post Layout.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'radio-image',
		'settings' => 'flash_post_layout',
		'label'    => esc_html__( 'Single Post', 'flash' ),
		'section'  => 'flash_sidebar_layout',
		'default'  => 'right-sidebar',
		'priority' => 20,
		'multiple' => 1,
		'choices'  => array(
			'right-sidebar'     => get_template_directory_uri() . '/images/right-sidebar.png',
			'left-sidebar'      => get_template_directory_uri() . '/images/left-sidebar.png',
			'full-width'        => get_template_directory_uri() . '/images/full-width.png',
			'full-width-center' => get_template_directory_uri() . '/images/full-width-center.png',
		),
	)
);

// Setting - Blog/Archive Layout.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'radio-image',
		'settings' => 'flash_archive_layout',
		'label'    => esc_html__( 'Blog/Archive', 'flash' ),
		'section'  => 'flash_sidebar_layout',
		'default'  => 'right-sidebar',
		'priority' => 30,
		'multiple' => 1,
		'choices'  => array(
			'right-sidebar'     => get_template_directory_uri() . '/images/right-sidebar.png',
			'left-sidebar'      => get_template_directory_uri() . '/images/left-sidebar.png',
			'full-width'        => get_template_directory_uri() . '/images/full-width.png',
			'full-width-center' => get_template_directory_uri() . '/images/full-width-center.png',
		),
	)
);

/** Section - Typography - Needs to be section. */
Kirki::add_panel(
	'flash_typography',
	array(
		'title'      => esc_html__( 'Typography', 'flash' ),
		'panel'      => 'flash_global',
		'capability' => 'edit_theme_options',
		'priority'   => 30,
	)
);

// Sub-section - Base.
Kirki::add_section(
	'flash_base_typography',
	array(
		'title'      => esc_html__( 'Base', 'flash' ),
		'panel'      => 'flash_typography',
		'capability' => 'edit_theme_options',
	)
);

// Setting - Body Typography.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'typography',
		'settings' => 'flash_body_font',
		'label'    => esc_attr__( 'Body', 'flash' ),
		'section'  => 'flash_base_typography',
		'default'  => array(
			'font-family' => 'Montserrat',
			'variant'     => 'regular',
		),
		'priority' => 10,
		'output'   => array(
			array(
				'element' => array( 'body' ),
			),
		),
		'js_vars'  => array(
			array(
				'element' => array( 'body' ),
			),
		),
	)
);

/** Panel - Header **/
Kirki::add_panel(
	'flash_header',
	array(
		'title'    => esc_html__( 'Header', 'flash' ),
		'priority' => 20,
	)
);

/** Section - Site Identity - Needs to be section. */
Kirki::add_section(
	'title_tagline',
	array(
		'title'      => esc_html__( 'Site Identity', 'flash' ),
		'panel'      => 'flash_header',
		'capability' => 'edit_theme_options',
		'priority'   => 10,
	)
);

// Setting - Site Identity Visibility Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'custom',
		'settings' => 'flash_siteidentity_visibility_header',
		'section'  => 'title_tagline',
		'default'  => '<div style="margin-top: 15px; padding: 5px; text-align: center; background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'Visibility', 'flash' ) . '</div>',
		'priority' => 1,
	)
);

// Setting - Site Identity Site Logo Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'custom',
		'settings' => 'flash_siteidentity_site_logo_header',
		'section'  => 'title_tagline',
		'default'  => '<div style="margin-top: 15px; padding: 5px; text-align: center; background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'Site Logo', 'flash' ) . '</div>',
		'priority' => 5,
	)
);

// Setting - Transparent Logo - Customizer Options Using Kirki Toolkit.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'image',
		'settings' => 'flash_transparent_logo',
		'label'    => esc_html__( 'Transparent Logo', 'flash' ),
		'section'  => 'title_tagline',
		'default'  => '',
		'priority' => 10,
	)
);

// Setting - Retina Logo enable Option.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'checkbox',
		'settings' => 'flash_retina_logo',
		'label'    => esc_html__( 'Different Logo for Retina Devices?', 'flash' ),
		'section'  => 'title_tagline',
		'default'  => '0',
		'priority' => 20,
	)
);

// Setting - Retina Logo Upload.
Kirki::add_field(
	'flash_config',
	array(
		'type'            => 'image',
		'settings'        => 'flash_retina_logo_upload',
		'label'           => esc_html__( 'Retina Logo', 'flash' ),
		'section'         => 'title_tagline',
		'default'         => '',
		'priority'        => 30,
		'active_callback' => array(
			array(
				'setting'  => 'flash_retina_logo',
				'operator' => '==',
				'value'    => 1,
			),
		),
	)
);

// Setting - Site Identity Site Info Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'custom',
		'settings' => 'flash_siteidentity_site_info_header',
		'section'  => 'title_tagline',
		'default'  => '<div style="margin-top: 15px; padding: 5px; text-align: center; background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'Site Info', 'flash' ) . '</div>',
		'priority' => 30,
	)
);

/** Section - Header Media. */
Kirki::add_section(
	'header_image',
	array(
		'title'      => esc_html__( 'Header Media', 'flash' ),
		'panel'      => 'flash_header',
		'capability' => 'edit_theme_options',
	)
);

/** Section - Header Top Bar. */
Kirki::add_section(
	'flash_header_top_bar',
	array(
		'title'      => esc_html__( 'Header Top Bar', 'flash' ),
		'panel'      => 'flash_header',
		'capability' => 'edit_theme_options',
	)
);

// Setting - Enable/Disable.
Kirki::add_field(
	'flash_top_header',
	array(
		'type'     => 'toggle',
		'settings' => 'flash_top_header',
		'label'    => esc_html__( 'Enable', 'flash' ),
		'section'  => 'flash_header_top_bar',
		'default'  => '1',
		'priority' => 10,
	)
);

// Setting - Left Content.
Kirki::add_field(
	'flash_config',
	array(
		'type'            => 'select',
		'settings'        => 'flash_top_header_left',
		'label'           => esc_html__( 'Left Content', 'flash' ),
		'section'         => 'flash_header_top_bar',
		'default'         => 'disable',
		'priority'        => 20,
		'multiple'        => 1,
		'choices'         => array(
			'social-menu' => esc_attr__( 'Social Menu', 'flash' ),
			'header-text' => esc_attr__( 'Text', 'flash' ),
			'disable'     => esc_attr__( 'Disable', 'flash' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'flash_top_header',
				'operator' => '==',
				'value'    => 1,
			),
		),
	)
);

// Setting - Right Content.
Kirki::add_field(
	'flash_config',
	array(
		'type'            => 'select',
		'settings'        => 'flash_top_header_right',
		'label'           => esc_html__( 'Right Content', 'flash' ),
		'section'         => 'flash_header_top_bar',
		'default'         => 'disable',
		'priority'        => 30,
		'multiple'        => 1,
		'choices'         => array(
			'social-menu' => esc_attr__( 'Social Menu', 'flash' ),
			'header-text' => esc_attr__( 'Text', 'flash' ),
			'disable'     => esc_attr__( 'Disable', 'flash' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'flash_top_header',
				'operator' => '==',
				'value'    => 1,
			),
		),
	)
);

// Setting - Text.
Kirki::add_field(
	'flash_config',
	array(
		'type'            => 'editor',
		'settings'        => 'flash_top_header_text',
		'label'           => esc_html__( 'Top Header Text Content', 'flash' ),
		'section'         => 'flash_header_top_bar',
		'default'         => '',
		'priority'        => 40,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => '.header-top .left-content',
				'function' => 'html',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'flash_top_header',
				'operator' => '==',
				'value'    => 1,
			),
		),
	)
);

/** Section - Primary Header. */
Kirki::add_section(
	'flash_primary_header',
	array(
		'title'      => esc_html__( 'Primary Header', 'flash' ),
		'panel'      => 'flash_header',
		'capability' => 'edit_theme_options',
	)
);

// Setting - Header Style.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'radio-image',
		'settings' => 'flash_logo_position',
		'label'    => esc_html__( 'Style', 'flash' ),
		'section'  => 'flash_primary_header',
		'default'  => 'left-logo-right-menu',
		'priority' => 10,
		'multiple' => 1,
		'choices'  => array(
			'left-logo-right-menu'   => get_template_directory_uri() . '/images/left-logo.png',
			'right-logo-left-menu'   => get_template_directory_uri() . '/images/RIGHT.png',
			'center-logo-below-menu' => get_template_directory_uri() . '/images/center-below.png',
		),
	)
);

// Setting - Header Search Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'custom',
		'settings' => 'flash_header_search_header',
		'section'  => 'flash_primary_header',
		'default'  => '<div style="margin-top: 15px; padding: 5px; text-align: center; background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'Search', 'flash' ) . '</div>',
		'priority' => 20,
	)
);

// Setting - Header Search Icon.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'checkbox',
		'settings' => 'flash_header_search',
		'label'    => esc_html__( 'Disable', 'flash' ),
		'section'  => 'flash_primary_header',
		'default'  => '',
		'priority' => 30,
	)
);

// Setting - Header Cart Icon Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'            => 'custom',
		'settings'        => 'flash_header_cart_header',
		'section'         => 'flash_primary_header',
		'default'         => '<div style="margin-top: 15px; padding: 5px; text-align: center; background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'Cart', 'flash' ) . '</div>',
		'priority'        => 40,
		'active_callback' => 'flash_is_woocommerce_active',
	)
);

// Setting - Header Cart Icon.
Kirki::add_field(
	'flash_config',
	array(
		'type'            => 'checkbox',
		'settings'        => 'flash_header_cart',
		'label'           => esc_html__( 'Disable', 'flash' ),
		'section'         => 'flash_header_options',
		'default'         => '',
		'priority'        => 50,
		'active_callback' => 'flash_is_woocommerce_active',
	)
);

// Setting - Sticky Header Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'custom',
		'settings' => 'flash_header_sticky_header',
		'section'  => 'flash_primary_header',
		'default'  => '<div style="margin-top: 15px; padding: 5px; text-align: center; background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'Sticky Header', 'flash' ) . '</div>',
		'priority' => 60,
	)
);

// Setting - Sticky Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'toggle',
		'settings' => 'flash_sticky_header',
		'label'    => esc_html__( 'Enable', 'flash' ),
		'section'  => 'flash_primary_header',
		'default'  => '',
		'priority' => 70,
	)
);

/** Panel - Content **/
Kirki::add_panel(
	'flash_content',
	array(
		'title'    => esc_html__( 'Content', 'flash' ),
		'priority' => 30,
	)
);

// Section - Page Header.
Kirki::add_section(
	'flash_page_header',
	array(
		'title'      => esc_html__( 'Page Header', 'flash' ),
		'panel'      => 'flash_content',
		'capability' => 'edit_theme_options',
		'priority'   => 10,
	)
);

// Setting - Page Header General Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'custom',
		'settings' => 'flash_page_header_general_header',
		'section'  => 'flash_page_header',
		'default'  => '<div style="margin-top: 15px; padding: 5px; text-align: center; background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'General', 'flash' ) . '</div>',
		'priority' => 10,
	)
);

// Setting - Page Header Background Image.
Kirki::add_field( 'flash_config', array(
	'type'      => 'image',
	'settings'  => 'flash_pageheader_background_image',
	'label'     => esc_html__( 'Background Image', 'flash' ),
	'section'   => 'flash_page_header',
	'default'   => '',
	'priority'  => 20,
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.breadcrumb-trail.breadcrumbs',
			'function' => 'css',
			'property' => 'background-image',
		),
	),
	'output'    => array(
		array(
			'element'  => '.breadcrumb-trail.breadcrumbs',
			'function' => 'css',
			'property' => 'background-image',
		),
	),
)
);

// Setting - Page Header Breadcrumbs Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'custom',
		'settings' => 'flash_page_header_breadcrumb_header',
		'section'  => 'flash_page_header',
		'default'  => '<div style="margin-top: 15px; padding: 5px; text-align: center; background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'Breadcrumbs', 'flash' ) . '</div>',
		'priority' => 30,
	)
);

// Setting - Disable Breadcrumbs.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'checkbox',
		'settings' => 'flash_remove_breadcrumbs',
		'label'    => esc_html__( 'Disable', 'flash' ),
		'section'  => 'flash_page_header',
		'default'  => '',
		'priority' => 40,
	)
);

// Section - Blog/Archive.
Kirki::add_section(
	'flash_blog_archive',
	array(
		'title'      => esc_html__( 'Blog/Archive', 'flash' ),
		'panel'      => 'flash_content',
		'capability' => 'edit_theme_options',
		'priority'   => 20,
	)
);

// Setting - Blog Styles.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'radio-image',
		'settings' => 'flash_blog_style',
		'label'    => esc_html__( 'Style', 'flash' ),
		'section'  => 'flash_blog_archive',
		'default'  => 'classic-layout',
		'priority' => 10,
		'multiple' => 1,
		'choices'  => array(
			'classic-layout'     => get_template_directory_uri() . '/images/blog-style-classic.png',
			'full-width-archive' => get_template_directory_uri() . '/images/blog-style-classic-full.png',
			'grid-view'          => get_template_directory_uri() . '/images/blog-style-grid.png',
		),
	)
);

// Setting - Blog/Archive Post meta Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'custom',
		'settings' => 'flash_blog_post_meta_header',
		'section'  => 'flash_blog_archive',
		'default'  => '<div style="margin-top: 15px; padding: 5px; text-align: center; background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'Post Meta', 'flash' ) . '</div>',
		'priority' => 20,
	)
);

// Meta - Date.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'checkbox',
		'settings' => 'flash_remove_meta_date',
		'label'    => esc_html__( 'Disable Date', 'flash' ),
		'section'  => 'flash_blog_archive',
		'default'  => '',
		'priority' => 30,
	)
);

// Setting - Post Meta Author.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'checkbox',
		'settings' => 'flash_remove_meta_author',
		'label'    => esc_html__( 'Disable Author', 'flash' ),
		'section'  => 'flash_blog_archive',
		'default'  => '',
		'priority' => 40,
	)
);

// Setting - Post Meta Comment Count.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'checkbox',
		'settings' => 'flash_remove_meta_comment_count',
		'label'    => esc_html__( 'Disable Comment', 'flash' ),
		'section'  => 'flash_blog_archive',
		'default'  => '',
		'priority' => 50,
	)
);

// Setting - Post Meta Category.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'checkbox',
		'settings' => 'flash_remove_meta_category',
		'label'    => esc_html__( 'Disable Category', 'flash' ),
		'section'  => 'flash_blog_archive',
		'default'  => '',
		'priority' => 60,
	)
);

// Setting - Post Meta Tags.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'checkbox',
		'settings' => 'flash_remove_meta_tag',
		'label'    => esc_html__( 'Disable Tag', 'flash' ),
		'section'  => 'flash_blog_archive',
		'default'  => '',
		'priority' => 70,
	)
);

// Section - Single Post.
Kirki::add_section(
	'flash_single_post',
	array(
		'title'      => esc_html__( 'Single Post', 'flash' ),
		'panel'      => 'flash_content',
		'capability' => 'edit_theme_options',
		'priority'   => 30,
	)
);

// Setting - Single Post Related Post Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'custom',
		'settings' => 'flash_single_post_related_post_header',
		'section'  => 'flash_single_post',
		'default'  => '<div style="margin-top: 15px; padding: 5px; text-align: center; background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'Related Posts', 'flash' ) . '</div>',
		'priority' => 10,
	)
);

// Setting - Enable Related Posts.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'switch',
		'settings' => 'flash_related_post_option',
		'label'    => esc_html__( 'Enable', 'flash' ),
		'section'  => 'flash_single_post',
		'default'  => 0,
		'priority' => 20,
	)
);

// Setting - Post Related To.
Kirki::add_field(
	'flash_config',
	array(
		'type'            => 'radio',
		'settings'        => 'flash_related_post_option_display',
		'label'           => esc_html__( 'Posts Related To', 'flash' ),
		'section'         => 'flash_single_post',
		'default'         => 'categories',
		'choices'         => array(
			'categories' => esc_attr__( 'Categories', 'flash' ),
			'tags'       => esc_attr__( 'Tags', 'flash' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'flash_related_post_option',
				'operator' => '==',
				'value'    => 1,
			),
		),
		'priority'         => 30,
	)
);

// Setting - Single Post Author Bio Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'custom',
		'settings' => 'flash_author_bio_header',
		'section'  => 'flash_single_post',
		'default'  => '<div style="margin-top: 15px; padding: 5px; text-align: center; background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'Author Bio', 'flash' ) . '</div>',
		'priority' => 50,
	)
);

// Setting - Author Bio.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'checkbox',
		'settings' => 'flash_remove_single_bio',
		'label'    => esc_html__( 'Disable', 'flash' ),
		'section'  => 'flash_single_post',
		'default'  => '',
		'priority' => 50,
	)
);

// Setting - Single Post Post Navigation Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'custom',
		'settings' => 'flash_single_post_navigation_header',
		'section'  => 'flash_single_post',
		'default'  => '<div style="margin-top: 15px; padding: 5px; text-align: center; background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'Post Navigation', 'flash' ) . '</div>',
		'priority' => 60,
	)
);

// Setting - Disable Post Navigation.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'checkbox',
		'settings' => 'flash_remove_single_nav',
		'label'    => esc_html__( 'Disable', 'flash' ),
		'section'  => 'flash_single_post',
		'default'  => '',
		'priority' => 70,
	)
);

/** Panel Footer **/
Kirki::add_panel(
	'flash_footer',
	array(
		'title'    => esc_html__( 'Footer', 'flash' ),
		'priority' => 40,
	)
);

// Section - Footer Widgets Area.
Kirki::add_section(
	'flash_footer_widgets_area',
	array(
		'title'      => esc_html__( 'Footer Widgets Area', 'flash' ),
		'panel'      => 'flash_footer',
		'capability' => 'edit_theme_options',
		'priority'   => 10,
	)
);

// Footer Widget.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'radio-image',
		'settings' => 'flash_footer_widgets',
		'label'    => esc_html__( 'Style', 'flash' ),
		'section'  => 'flash_footer_widgets_area',
		'default'  => '4',
		'priority' => 10,
		'multiple' => 1,
		'choices'  => array(
			'1' => get_template_directory_uri() . '/images/col-1.png',
			'2' => get_template_directory_uri() . '/images/col-2.png',
			'3' => get_template_directory_uri() . '/images/col-3.png',
			'4' => get_template_directory_uri() . '/images/col-4.png',
		),
	)
);

// Setting - Footer Scroll to Top Footer Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'custom',
		'settings' => 'flash_scroll_to_top_fixed_header',
		'section'  => 'flash_footer_scroll_top',
		'default'  => '<div style="margin-top: 15px; padding: 5px; text-align: center; background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'Fixed', 'flash' ) . '</div>',
		'priority' => 20,
	)
);

// Section - Footer Scroll to Top.
Kirki::add_section(
	'flash_footer_scroll_top',
	array(
		'title'      => esc_html__( 'Scroll to Top', 'flash' ),
		'panel'      => 'flash_footer',
		'capability' => 'edit_theme_options',
		'priority'   => 40,
	)
);

// Setting - Footer Scroll to Top Footer Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'custom',
		'settings' => 'flash_scroll_to_top_fixed_header',
		'section'  => 'flash_footer_scroll_top',
		'default'  => '<div style="margin-top: 15px; padding: 5px; text-align: center; background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'Fixed', 'flash' ) . '</div>',
		'priority' => 10,
	)
);

// Setting - Scroll to Top button Options.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'checkbox',
		'settings' => 'flash_disable_back_to_top',
		'label'    => esc_html__( 'Disable', 'flash' ),
		'section'  => 'flash_footer_scroll_top',
		'default'  => '',
		'priority' => 20,
	)
);

/** Panel - Additional **/
Kirki::add_panel(
	'flash_additional',
	array(
		'title'    => esc_html__( 'Additional', 'flash' ),
		'priority' => 80,
	)
);

// Section - Integration.
Kirki::add_section(
	'flash_integration',
	array(
		'title'      => esc_html__( 'Integration', 'flash' ),
		'panel'      => 'flash_additional',
		'capability' => 'edit_theme_options',
		'priority'   => 10,
	)
);

// Setting - Custom CSS
if ( ! function_exists( 'wp_update_custom_css_post' ) ) {
	Kirki::add_field(
		'flash_config',
		array(
			'type'     => 'code',
			'settings' => 'flash_custom_css',
			'label'    => esc_html__( 'Custom CSS', 'flash' ),
			'section'  => 'flash_integration',
			'default'  => '',
			'priority' => 10,
			'choices'  => array(
				'language' => 'css',
				'theme'    => 'monokai',
				'height'   => 250,
			),
		)
	);
}

// Section - Optimization.
Kirki::add_section(
	'flash_optimization',
	array(
		'title'      => esc_html__( 'Optimization', 'flash' ),
		'panel'      => 'flash_additional',
		'capability' => 'edit_theme_options',
		'priority'   => 20,
	)
);

// Setting - Optimization Preloader Header.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'custom',
		'settings' => 'flash_preloader_header',
		'section'  => 'flash_optimization',
		'default'  => '<div style="margin-top: 15px; padding: 5px; text-align: center; background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'Preloader', 'flash' ) . '</div>',
		'priority' => 10,
	)
);

// Setting - Preloader Options.
Kirki::add_field(
	'flash_config',
	array(
		'type'     => 'checkbox',
		'settings' => 'flash_disable_preloader',
		'label'    => esc_html__( 'Disable', 'flash' ),
		'section'  => 'flash_optimization',
		'default'  => '',
		'priority' => 10,
	)
);

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Flash 1.0
 *
 * @see   flash_header_style()
 */
function flash_custom_header_and_background() {
	$color_scheme             = flash_get_color_scheme();
	$default_background_color = trim( $color_scheme[0], '#' );
	$default_text_color       = trim( $color_scheme[2], '#' );

	/**
	 * Filter the arguments used when adding 'custom-background' support in Flash.
	 *
	 * @param array $args    {
	 *                       An array of custom-background support arguments.
	 *
	 * @type string $default -color Default color of the background.
	 * }
	 * @since Flash 1.0
	 *
	 */
	add_theme_support(
		'custom-background',
		apply_filters(
			'flash_custom_background_args',
			array(
				'default-color' => $default_background_color,
			)
		)
	);

	/**
	 * Filter the arguments used when adding 'customheader' support in Flash.
	 *
	 * @param array   $args             {
	 *                                  An array of customheader support arguments.
	 *
	 * @type string   $defaulttextcolor Default color of the header text.
	 * @type int      $width            Width in pixels of the custom header image. Default 1200.
	 * @type int      $height           Height in pixels of the custom header image. Default 280.
	 * @type bool     $flexheight       Whether to allow flexibleheight header images. Default true.
	 * @type callable $wpheadcallback   Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 * @since Flash 1.0
	 *
	 */
	add_theme_support(
		'custom-header',
		apply_filters(
			'flash_custom_header_args',
			array(
				'default-text-color' => $default_text_color,
				'width'              => 1286,
				'height'             => 280,
				'flex-height'        => true,
				'flex-width'         => true,
				'header-text'        => true,
				'video'              => true,
			)
		)
	);
}

add_action( 'after_setup_theme', 'flash_custom_header_and_background' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function flash_customize_register( $wp_customize ) {

	// Custom customizer section classes.
	require_once get_template_directory() . '/inc/admin/class-flash-upsell-section.php';

	// Include control classes.

	$color_scheme = flash_get_color_scheme();

	$wp_customize->get_setting( 'blogname' )->transport           = 'postMessage';
	$wp_customize->get_control( 'blogname' )->priority            = 80;
	$wp_customize->get_setting( 'blogdescription' )->transport    = 'postMessage';
	$wp_customize->get_control( 'blogdescription' )->priority     = 85;
	$wp_customize->get_setting( 'header_textcolor' )->transport   = 'postMessage';
	$wp_customize->get_control( 'display_header_text' )->priority = 5;
	$wp_customize->get_control( 'background_color' )->section     = 'flash_background';
	$wp_customize->get_control( 'background_image' )->section     = 'flash_background';
	$wp_customize->get_control( 'header_video' )->description     = '';

	$wp_customize->remove_section( 'background_image' );

	// Add color scheme setting and control.
	$wp_customize->add_setting(
		'color_scheme',
		array(
			'default'           => 'default',
			'sanitize_callback' => 'flash_sanitize_color_scheme',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'color_scheme',
		array(
			'label'    => esc_html__( 'Scheme', 'flash' ),
			'section'  => 'flash_base_colors',
			'type'     => 'select',
			'choices'  => flash_get_color_scheme_choices(),
			'priority' => 1,
		)
	);

	// Remove the core header textcolor control, as it shares the main text color.
	$wp_customize->remove_control( 'header_textcolor' );

	// Add link color setting and control.
	$wp_customize->add_setting(
		'link_color',
		array(
			'default'           => $color_scheme[1],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_color',
			array(
				'label'   => esc_html__( 'Primary Color', 'flash' ),
				'section' => 'flash_base_colors',
			)
		)
	);

	// Add main text color setting and control.
	$wp_customize->add_setting(
		'main_text_color',
		array(
			'default'           => $color_scheme[2],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'main_text_color',
			array(
				'label'   => esc_html__( 'Headings', 'flash' ),
				'section' => 'flash_heading_colors',
			)
		)
	);

	// Add secondary text color setting and control.
	$wp_customize->add_setting(
		'secondary_text_color',
		array(
			'default'           => $color_scheme[3],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'secondary_text_color',
			array(
				'label'   => esc_html__( 'Text Color', 'flash' ),
				'section' => 'flash_base_colors',
			)
		)
	);

	/**
	 * Upsell.
	 */
	// Register `FLASH_Upsell_Section` type section.
	$wp_customize->register_section_type( 'FLASH_Upsell_Section' );

	// Add `FLASH_Upsell_Section` to display pro link.
	$wp_customize->add_section(
		new FLASH_Upsell_Section(
			$wp_customize,
			'flash_upsell_section',
			array(
				'title'      => esc_html__( 'View Pro version', 'flash' ),
				'url'        => 'https://themegrill.com/flash-pricing/?utm_source=flash-customizer&utm_medium=view-pricing-link&utm_campaign=upgrade',
				'capability' => 'edit_theme_options',
				'priority'   => 1,
			)
		)
	);
	/*
	 * Custom Scripts
	 */
	add_action( 'customize_controls_print_footer_scripts', 'flash_customizer_custom_scripts' );

	function flash_customizer_custom_scripts() {
		?>
		<style>
			/* Theme Instructions Panel CSS */
			li#accordion-section-flash_upsell_section h3.accordion-section-title {
				background-color: #30AFB8 !important;
				color: #fff !important;
				padding: 0;
			}

			#accordion-section-flash_upsell_section h3 a:after {
				content: '\f345';
				color: #fff;
				position: absolute;
				top: 12px;
				right: 10px;
				z-index: 1;
				font: 400 20px/1 dashicons;
				speak: none;
				display: block;
				-webkit-font-smoothing: antialiased;
				-moz-osx-font-smoothing: grayscale;
				text-decoration: none !important;
			}

			li#accordion-section-flash_upsell_section h3.accordion-section-title a {
				color: #fff;
				display: block;
				text-decoration: none;
				padding: 12px 15px 15px;
			}

			li#accordion-section-flash_upsell_section h3.accordion-section-title a:focus {
				box-shadow: none;
			}

			li#accordion-section-flash_upsell_section h3.accordion-section-title:hover {
				background-color: #1C9BA4 !important;
				color: #fff !important;
			}

			li#accordion-section-flash_upsell_section h3.accordion-section-title:after {
				color: #fff !important;
			}
		</style>

		<script>
			(
				function ( $, api ) {
					api.sectionConstructor['flash-upsell-section'] = api.Section.extend( {

						// No events for this type of section.
						attachEvents : function () {
						},

						// Always make the section active.
						isContextuallyActive : function () {
							return true;
						}
					} );
				}
			)( jQuery, wp.customize );

		</script>
		<?php
	}

	// Sanitization of links.
	function flash_links_sanitize() {
		return false;
	}
}

add_action( 'customize_register', 'flash_customize_register' );

// Header Cart Icon Active Callback.
function flash_is_woocommerce_active() {
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		return true;
	} else {
		return false;
	}
}

// Sanitize Google Font.
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
 * @return array An associative array of color scheme options.
 * @since Flash 1.0
 *
 */
function flash_get_color_schemes() {
	/**
	 * Filter the color schemes registered for use with Flash.
	 *
	 * The default schemes include 'default', 'dark', 'gray', 'red', and 'yellow'.
	 *
	 * @param array $schemes {
	 *                       Associative array of color schemes data.
	 *
	 * @type array  $slug    {
	 *         Associative array of information for setting up the color scheme.
	 *
	 * @type string $label   Color scheme label.
	 * @type array  $colors  HEX codes for default colors prepended with a hash symbol ('#').
	 *                              Colors are defined in the following order: Main background, page
	 *                              background, link, main text, secondary text.
	 *     }
	 * }
	 * @since Flash 1.0
	 *
	 */
	return apply_filters(
		'flash_color_schemes',
		array(
			'default' => array(
				'label'  => esc_html__( 'Default', 'flash' ),
				'colors' => array(
					'#ffffff',
					'#30AFB8',
					'#313b48',
					'#666666',
				),
			),
			'dark'    => array(
				'label'  => esc_html__( 'Dark', 'flash' ),
				'colors' => array(
					'#272727',
					'#ffffff',
					'#ffffff',
					'#fefefe',
				),
			),
			'gray'    => array(
				'label'  => esc_html__( 'Gray', 'flash' ),
				'colors' => array(
					'#616a73',
					'#c7c7c7',
					'#f2f2f2',
					'#f2f2f2',
				),
			),
			'red'     => array(
				'label'  => esc_html__( 'Red', 'flash' ),
				'colors' => array(
					'#ffffff',
					'#F54337',
					'#333333',
					'#777777',
				),
			),
			'yellow'  => array(
				'label'  => esc_html__( 'Yellow', 'flash' ),
				'colors' => array(
					'#ffffff',
					'#EFCA23',
					'#313b48',
					'#666666',
				),
			),
		)
	);
}

if ( ! function_exists( 'flash_get_color_scheme' ) ) :
	/**
	 * Retrieves the current Flash color scheme.
	 *
	 * Create your own flash_get_color_scheme() function to override in a child theme.
	 *
	 * @return array An associative array of either the current or default color scheme HEX values.
	 * @since Flash 1.0
	 *
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
	 * @return array Array of color schemes.
	 * @since Flash 1.0
	 *
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
	 * @param string $value Color scheme name value.
	 *
	 * @return string Color scheme name.
	 * @since Flash 1.0
	 *
	 */
	function flash_sanitize_color_scheme( $value ) {
		$color_schemes = flash_get_color_scheme_choices();

		if ( ! array_key_exists( $value, $color_schemes ) ) {
			return 'default';
		}

		return $value;
	}
endif; // flash_sanitize_color_scheme


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function flash_customize_preview_scripts() {
	wp_enqueue_script( 'flash-customizer-js', get_template_directory_uri() . '/js/customizer.js', array(
		'customize-preview',
		'jquery',
	), false, true );
	wp_enqueue_script( 'flash-color-scheme-control', get_template_directory_uri() . '/js/color-scheme-control.js', array(
		'customize-controls',
		'iris',
		'underscore',
		'wp-util',
	), '20160816', true );
	wp_localize_script( 'flash-color-scheme-control', 'colorScheme', flash_get_color_schemes() );
}

add_action( 'customize_controls_enqueue_scripts', 'flash_customize_preview_scripts', 99 );
add_action( 'customize_preview_init', 'flash_customize_preview_scripts', 99 );

/**
 * Enqueues front-end CSS for color scheme.
 *
 * @since Flash 1.0
 *
 * @see   wp_add_inline_style()
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
		'background_color'     => $color_scheme[0],
		'link_color'           => $color_scheme[1],
		'main_text_color'      => $color_scheme[2],
		'secondary_text_color' => $color_scheme[3],
		'border_color'         => vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.2)', $color_textcolor_rgb ),

	);

	$color_scheme_css = flash_get_color_scheme_css( $colors );

	wp_add_inline_style( 'flash-style', $color_scheme_css );
}

add_action( 'wp_enqueue_scripts', 'flash_color_scheme_css' );

/**
 * Returns CSS for the color schemes.
 *
 * @param array $colors Color scheme colors.
 *
 * @return string Color scheme CSS.
 * @since Flash 1.0
 *
 */
function flash_get_color_scheme_css( $colors ) {
	$colors = wp_parse_args(
		$colors,
		array(
			'background_color'     => '',
			'link_color'           => '',
			'main_text_color'      => '',
			'secondary_text_color' => '',
			'border_color'         => '',
		)
	);

	return <<<CSS
	/* Predefined Color Schemes CSS */

	/* Background Color */
	body {
		background-color: {$colors['background_color']};
	}

	/* Link Color */
	#site-navigation ul li:hover > a, #site-navigation ul li.current-menu-item > a, #site-navigation ul li.current_page_item > a, #site-navigation ul li.current_page_ancestor > a, #site-navigation ul li.current-menu-ancestor > a, #site-navigation ul.sub-menu li:hover > a,#site-navigation ul li ul.sub-menu li.menu-item-has-children ul li:hover > a,#site-navigation ul li ul.sub-menu li.menu-item-has-children:hover > .menu-item,body.transparent #masthead .header-bottom #site-navigation ul li:hover > .menu-item,body.transparent #masthead .header-bottom #site-navigation ul li:hover > a,body.transparent #masthead .header-bottom #site-navigation ul.sub-menu li:hover > a,body.transparent #masthead .header-bottom #site-navigation ul.sub-menu li.menu-item-has-children ul li:hover > a,body.transparent.header-sticky #masthead-sticky-wrapper #masthead .header-bottom #site-navigation ul.sub-menu li > a:hover,.tg-service-widget .service-title-wrap a:hover,.tg-service-widget .service-more,.feature-product-section .button-group button:hover ,.fun-facts-section .fun-facts-icon-wrap,.fun-facts-section .tg-fun-facts-widget.tg-fun-facts-layout-2 .counter-wrapper,.blog-section .tg-blog-widget-layout-2 .blog-content .read-more-container .read-more a,footer.footer-layout #top-footer .widget-title::first-letter,footer.footer-layout #top-footer .widget ul li a:hover,footer.footer-layout #bottom-footer .copyright .copyright-text a:hover,footer.footer-layout #bottom-footer .footer-menu ul li a:hover,.archive #primary .entry-content-block h2.entry-title a:hover,.blog #primary .entry-content-block h2.entry-title a:hover,#secondary .widget ul li a:hover,.woocommerce-Price-amount.amount,.team-wrapper .team-content-wrapper .team-social a:hover,.testimonial-container .testimonial-wrapper .testimonial-slide .testominial-content-wrapper .testimonial-icon,.footer-menu li a:hover,.tg-feature-product-filter-layout .button.is-checked:hover,.testimonial-container .testimonial-icon,#site-navigation ul li.menu-item-has-children:hover > .sub-toggle,#secondary .widget ul li a,#comments .comment-list article.comment-body .reply a,.tg-slider-widget .btn-wrapper a{
		color: {$colors['link_color']};
	}

	.feature-product-section .tg-feature-product-layout-2 .tg-container .tg-column-wrapper .tg-feature-product-widget .featured-image-desc, #respond #commentform .form-submit input:hover, .blog-section .tg-blog-widget-layout-1 .tg-blog-widget:hover,#scroll-up,.header-bottom .search-wrap .search-box .searchform .btn:hover,.header-bottom .cart-wrap .flash-cart-views a span,body.transparent #masthead .header-bottom #site-navigation ul li a::before,.tg-slider-widget.slider-dark .btn-wrapper a:hover,.section-title:after,.about-section .about-content-wrapper .btn-wrapper a,.tg-service-widget .service-icon-wrap,.team-wrapper .team-content-wrapper .team-designation:after,.call-to-action-section .btn-wrapper a:hover,.blog-section .tg-blog-widget-layout-1:hover,.blog-section .tg-blog-widget-layout-2 .post-image .entry-date,.blog-section .tg-blog-widget-layout-2 .blog-content .post-readmore,.pricing-table-section .tg-pricing-table-widget:hover,.pricing-table-section .tg-pricing-table-widget.tg-pricing-table-layout-2 .pricing,.pricing-table-section .tg-pricing-table-widget.tg-pricing-table-layout-2 .btn-wrapper a,footer.footer-layout #top-footer .widget_tag_cloud .tagcloud a:hover,#secondary .widget-title:after,#secondary .searchform .btn:hover,#primary .searchform .btn:hover,  #respond #commentform .form-submit input,.woocommerce ul.products li.product .onsale,.woocommerce ul.products li.product .button,.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt,.added_to_cart.wc-forward,.testimonial-container .swiper-pagination.testimonial-pager .swiper-pagination-bullet:hover, .testimonial-container .swiper-pagination.testimonial-pager .swiper-pagination-bullet.swiper-pagination-bullet-active,.header-bottom .searchform .btn,.navigation .nav-links a:hover, .bttn:hover, button, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover,.tg-slider-widget .btn-wrapper a:hover  {
		background-color: {$colors['link_color']};
	}
	body.transparent.header-sticky #masthead-sticky-wrapper #masthead .header-bottom .search-wrap .search-icon:hover, body.transparent #masthead .header-bottom .search-wrap .search-icon:hover, .header-bottom .search-wrap .search-icon:hover,#comments .comment-list article.comment-body .reply a::before,.tg-slider-widget .btn-wrapper a, .tg-slider-widget .btn-wrapper a:hover {
	  border-color: {$colors['link_color']};
	}
	body.transparent.header-sticky #masthead-sticky-wrapper.is-sticky #masthead .header-bottom #site-navigation ul li.current-flash-item a,#site-navigation ul li.current-flash-item a, body.transparent.header-sticky #masthead-sticky-wrapper #masthead .header-bottom .search-wrap .search-icon:hover, body.transparent #masthead .header-bottom .search-wrap .search-icon:hover, .header-bottom .search-wrap .search-icon:hover {
	  color: {$colors['link_color']};
	}
	.tg-slider-widget.slider-dark .btn-wrapper a:hover,.call-to-action-section .btn-wrapper a:hover,footer.footer-layout #top-footer .widget_tag_cloud .tagcloud a:hover {
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
	.tg-slider-widget .swiper-button-next::before,.tg-slider-widget .swiper-button-prev::before,.tg-slider-widget .caption-title,.section-title-wrapper .section-title,.tg-service-widget .service-title-wrap a ,.team-wrapper .team-content-wrapper .team-title a,.testimonial-container .testimonial-wrapper .testimonial-slide .testimonial-client-detail .client-detail-block .testimonial-title,.blog-section .row:nth-child(odd) .blog-content .entry-title a,.blog-section .row:nth-child(even) .blog-content .entry-title a,.blog-section .tg-blog-widget:hover .blog-content .entry-title a:hover,.blog-section .tg-blog-widget-layout-2 .tg-blog-widget:hover .blog-content .entry-title a,.pricing-table-section .tg-pricing-table-widget .pricing-table-title ,.pricing-table-section .tg-pricing-table-widget .pricing,.pricing-table-section .tg-pricing-table-widget .btn-wrapper a,.pricing-table-section .tg-pricing-table-widget.standard .popular-batch,.single-post #primary .author-description .author-description-block .author-title,.section-title-wrapper .section-title,.tg-service-widget .service-title-wrap a,.tg-service-widget .service-title-wrap a,.blog-section .tg-blog-widget-layout-2 .entry-title a,.entry-content-block .entry-title a,.blog #primary .entry-content-block .entry-content,.breadcrumb-trail.breadcrumbs .trail-title,#secondary .widget-title,#secondary .widget ul li,.archive #primary .entry-content-block .entry-content,.entry-content, .entry-summary,#comments .comments-title,#comments .comment-list article.comment-body .comment-content,.comment-reply-title,.search .entry-title a,.section-title,.blog-section .row:nth-child(odd) .entry-summary,.blog-section .row:nth-child(even) .entry-summary,.blog-wrapper .entry-title a,.tg-blog-widget-layout-3 .entry-title a,.feature-product-section .tg-feature-product-widget .feature-title-wrap a,.team-wrapper .team-title,.testimonial-container .testimonial-content{
		color: {$colors['main_text_color']};
	}

	.header-bottom .search-wrap .search-box .searchform .btn,.testimonial-container .swiper-pagination.testimonial-pager .swiper-pagination-bullet{
		background-color: {$colors['main_text_color']};
	}

	.feature-product-section .tg-feature-product-layout-2 .tg-container .tg-column-wrapper .tg-feature-product-widget .featured-image-desc::before{
		border-right-color: {$colors['main_text_color']};
	}

	/* Secondary Text Color */
	.tg-service-widget .service-content-wrap,.section-title-wrapper .section-description,.team-wrapper .team-content-wrapper .team-content,.testimonial-container .testimonial-wrapper .testimonial-slide .testominial-content-wrapper .testimonial-content, button, input, select, textarea,.entry-meta a,.cat-links a,.entry-footer a,.entry-meta span,.single .entry-content-block .entry-footer span a,.single .entry-content-block .entry-footer span,#comments .comment-list article.comment-body .comment-metadata a,#comments .comment-list article.comment-body .comment-author,#respond #commentform p,.testimonial-container .testimonial-degicnation,.fun-facts-section .fun-facts-title-wrap,.blog-section .row:nth-child(odd) .entry-meta a,.blog-section .row:nth-child(even) .entry-meta a,.tg-blog-widget-layout-2 .read-more-container .entry-author a,.blog-section .tg-blog-widget-layout-2 .read-more-container .entry-author,.tg-slider-widget .caption-desc {
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
		'background_color'     => '{{ data.background_color }}',
		'link_color'           => '{{ data.link_color }}',
		'main_text_color'      => '{{ data.main_text_color }}',
		'secondary_text_color' => '{{ data.secondary_text_color }}',
		'border_color'         => '{{ data.border_color }}',
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
 * @see   wp_add_inline_style()
 */
function flash_link_color_css() {
	$color_scheme  = flash_get_color_scheme();
	$default_color = $color_scheme[1];
	$link_color    = get_theme_mod( 'link_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $link_color === $default_color ) {
		return;
	}

	// Convert link color to rgba.
	$link_color_rgb = flash_hex2rgb( $link_color );

	// Generate Darker Color
	$link_color_dark = flash_darkcolor( $link_color, - 20 );

	// If we get this far, we have a custom color scheme.
	$border_color = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.8)', $link_color_rgb );

	$css = '
	/* Custom Link Color */
	#site-navigation ul li:hover > a, #site-navigation ul li.current-menu-item > a, #site-navigation ul li.current_page_item > a, #site-navigation ul li.current_page_ancestor > a, #site-navigation ul li.current-menu-ancestor > a,#site-navigation ul.sub-menu li:hover > a,#site-navigation ul li ul.sub-menu li.menu-item-has-children ul li:hover > a,#site-navigation ul li ul.sub-menu li.menu-item-has-children:hover > .menu-item,body.transparent #masthead .header-bottom #site-navigation ul li:hover > .menu-item,body.transparent #masthead .header-bottom #site-navigation ul li:hover > a,body.transparent #masthead .header-bottom #site-navigation ul.sub-menu li:hover > a,body.transparent #masthead .header-bottom #site-navigation ul.sub-menu li.menu-item-has-children ul li:hover > a,body.transparent.header-sticky #masthead-sticky-wrapper #masthead .header-bottom #site-navigation ul.sub-menu li > a:hover,.tg-service-widget .service-title-wrap a:hover,.tg-service-widget .service-more,.feature-product-section .button-group button:hover ,.fun-facts-section .fun-facts-icon-wrap,.fun-facts-section .tg-fun-facts-widget.tg-fun-facts-layout-2 .counter-wrapper,.blog-section .tg-blog-widget-layout-2 .blog-content .read-more-container .read-more a,footer.footer-layout #top-footer .widget-title::first-letter,footer.footer-layout #top-footer .widget ul li a:hover,footer.footer-layout #bottom-footer .copyright .copyright-text a:hover,footer.footer-layout #bottom-footer .footer-menu ul li a:hover,.archive #primary .entry-content-block h2.entry-title a:hover,.blog #primary .entry-content-block h2.entry-title a:hover,#secondary .widget ul li a:hover,.woocommerce-Price-amount.amount,.team-wrapper .team-content-wrapper .team-social a:hover,.testimonial-container .testimonial-wrapper .testimonial-slide .testominial-content-wrapper .testimonial-icon,.footer-menu li a:hover,.tg-feature-product-filter-layout .button.is-checked:hover,.testimonial-container .testimonial-icon,#site-navigation ul li.menu-item-has-children:hover > .sub-toggle,.woocommerce-error::before, .woocommerce-info::before, .woocommerce-message::before,#primary .post .entry-content-block .entry-meta a:hover,#primary .post .entry-content-block .entry-meta span:hover,.entry-meta span:hover a,.post .entry-content-block .entry-footer span a:hover,#secondary .widget ul li a,#comments .comment-list article.comment-body .reply a,.tg-slider-widget .btn-wrapper a,.entry-content a, .related-posts-wrapper .entry-title a:hover,
		.related-posts-wrapper .entry-meta > span a:hover{
			color: %1$s;
	}

	.blog-section .tg-blog-widget-layout-1 .tg-blog-widget:hover, #scroll-up,.header-bottom .search-wrap .search-box .searchform .btn:hover,.header-bottom .cart-wrap .flash-cart-views a span,body.transparent #masthead .header-bottom #site-navigation ul li a::before,.tg-slider-widget.slider-dark .btn-wrapper a:hover, .section-title:after,.about-section .about-content-wrapper .btn-wrapper a,.tg-service-widget .service-icon-wrap,.team-wrapper .team-content-wrapper .team-designation:after,.call-to-action-section .btn-wrapper a:hover,.blog-section .tg-blog-widget-layout-1:hover,.blog-section .tg-blog-widget-layout-2 .post-image .entry-date,.blog-section .tg-blog-widget-layout-2 .blog-content .post-readmore,.pricing-table-section .tg-pricing-table-widget:hover,.pricing-table-section .tg-pricing-table-widget.tg-pricing-table-layout-2 .pricing,.pricing-table-section .tg-pricing-table-widget.tg-pricing-table-layout-2 .btn-wrapper a,footer.footer-layout #top-footer .widget_tag_cloud .tagcloud a:hover,#secondary .widget-title:after, #secondary .searchform .btn:hover,#primary .searchform .btn:hover,  #respond #commentform .form-submit input,.woocommerce span.onsale, .woocommerce ul.products li.product .onsale,.woocommerce ul.products li.product .button,.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt,.added_to_cart.wc-forward,.testimonial-container .swiper-pagination.testimonial-pager .swiper-pagination-bullet:hover, .testimonial-container .swiper-pagination.testimonial-pager .swiper-pagination-bullet.swiper-pagination-bullet-active,.header-bottom .searchform .btn,.navigation .nav-links a:hover, .bttn:hover, button, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover,.tg-slider-widget .btn-wrapper a:hover  {
		background-color: %1$s;
	}
	.feature-product-section .tg-feature-product-layout-2 .tg-container .tg-column-wrapper .tg-feature-product-widget .featured-image-desc, .tg-team-widget.tg-team-layout-3 .team-wrapper .team-img .team-social {
		background-color: %2$s;
	}
	#respond #commentform .form-submit input:hover{
	background-color: %3$s;
	}

	.tg-slider-widget.slider-dark .btn-wrapper a:hover,.call-to-action-section .btn-wrapper a:hover,footer.footer-layout #top-footer .widget_tag_cloud .tagcloud a:hover,.woocommerce-error, .woocommerce-info, .woocommerce-message,#comments .comment-list article.comment-body .reply a::before,.tg-slider-widget .btn-wrapper a, .tg-slider-widget .btn-wrapper a:hover {
		border-color: %1$s;
	}
	body.transparent.header-sticky #masthead-sticky-wrapper.is-sticky #site-navigation ul li.current-flash-item a, #site-navigation ul li.current-flash-item a, body.transparent.header-sticky #masthead-sticky-wrapper #site-navigation ul li:hover > a,body.transparent #site-navigation ul li:hover .sub-toggle{
			color: %1$s;
		}

	.tg-service-widget .service-icon-wrap:after{
			border-top-color: %1$s;
		}
	body.transparent.header-sticky #masthead-sticky-wrapper .search-wrap .search-icon:hover, body.transparent .search-wrap .search-icon:hover, .header-bottom .search-wrap .search-icon:hover {
	  border-color: %1$s;
	}
	body.transparent.header-sticky #masthead-sticky-wrapper .search-wrap .search-icon:hover, body.transparent #masthead .header-bottom .search-wrap .search-icon:hover, .header-bottom .search-wrap .search-icon:hover,.breadcrumb-trail.breadcrumbs .trail-items li:first-child span:hover,.breadcrumb-trail.breadcrumbs .trail-items li span:hover a {
	  color: %1$s;
	}
	.woocommerce ul.products li.product .button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,.added_to_cart.wc-forward:hover{
		background-color: %3$s;
	}

	.feature-product-section .tg-feature-product-widget .featured-image-desc::before,.blog-section .row:nth-child(odd) .tg-blog-widget:hover .post-image::before{
			border-right-color: %1$s;
		}
	.feature-product-section .tg-feature-product-widget .featured-image-desc::before,.blog-section .row:nth-child(odd) .tg-blog-widget:hover .post-image::before,footer.footer-layout #top-footer .widget-title,.blog-section .row:nth-child(2n) .tg-blog-widget:hover .post-image::before{
		border-left-color: %1$s;
	}
	.blog-section .tg-blog-widget-layout-2 .entry-title a:hover,
	.blog-section .tg-blog-widget-layout-2 .tg-blog-widget:hover .blog-content .entry-title a:hover,
	.tg-blog-widget-layout-2 .read-more-container .entry-author:hover a,
	.tg-blog-widget-layout-2 .read-more-container .entry-author:hover,
	.blog-section .tg-blog-widget-layout-2 .read-more-container .read-more:hover a{
			color: %3$s;
		}

	.tg-service-widget .service-more:hover{
		color: %3$s;
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
 * @see   wp_add_inline_style()
 */
function flash_main_text_color_css() {
	$color_scheme    = flash_get_color_scheme();
	$default_color   = $color_scheme[2];
	$main_text_color = get_theme_mod( 'main_text_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $main_text_color === $default_color ) {
		return;
	}

	// Convert main text hex color to rgba.
	$main_text_color_rgb = flash_hex2rgb( $main_text_color );

	// If the rgba values are empty return early.
	if ( empty( $main_text_color_rgb ) ) {
		return;
	}

	// If we get this far, we have a custom color scheme.
	$border_color = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.2)', $main_text_color_rgb );

	$css = '
		/* Custom Main Text Color */
		.tg-slider-widget .swiper-button-next::before,.tg-slider-widget .swiper-button-prev::before,.tg-slider-widget .caption-title,.section-title-wrapper .section-title,.tg-service-widget .service-title-wrap a ,.team-wrapper .team-content-wrapper .team-title a,.testimonial-container .testimonial-wrapper .testimonial-slide .testimonial-client-detail .client-detail-block .testimonial-title,.blog-section .row:nth-child(odd) .blog-content .entry-title a,.blog-section .row:nth-child(even) .blog-content .entry-title a,.blog-section .tg-blog-widget:hover .blog-content .entry-title a:hover,.blog-section .tg-blog-widget-layout-2 .tg-blog-widget:hover .blog-content .entry-title a,.pricing-table-section .tg-pricing-table-widget .pricing-table-title ,.pricing-table-section .tg-pricing-table-widget .pricing,.pricing-table-section .tg-pricing-table-widget .btn-wrapper a,.pricing-table-section .tg-pricing-table-widget.standard .popular-batch,.single-post #primary .author-description .author-description-block .author-title,.section-title-wrapper .section-title,.tg-service-widget .service-title-wrap a,.tg-service-widget .service-title-wrap a,.blog-section .tg-blog-widget-layout-2 .entry-title a,.entry-content-block .entry-title a,.blog #primary .entry-content-block .entry-content,.breadcrumb-trail.breadcrumbs .trail-title,#secondary .widget-title,#secondary .widget ul li,.archive #primary .entry-content-block .entry-content,.entry-content, .entry-summary,#comments .comments-title,#comments .comment-list article.comment-body .comment-content,.comment-reply-title,.search .entry-title a,.section-title,.blog-section .row:nth-child(odd) .entry-summary,.blog-section .row:nth-child(even) .entry-summary,.blog-wrapper .entry-title a,.tg-blog-widget-layout-3 .entry-title a,.feature-product-section .tg-feature-product-widget .feature-title-wrap a,.team-wrapper .team-title,.testimonial-container .testimonial-content{
			color: %1$s;
		}

		.header-bottom .search-wrap .search-box .searchform .btn,.testimonial-container .swiper-pagination.testimonial-pager .swiper-pagination-bullet{
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
 * @see   wp_add_inline_style()
 */
function flash_secondary_text_color_css() {
	$color_scheme         = flash_get_color_scheme();
	$default_color        = $color_scheme[3];
	$secondary_text_color = get_theme_mod( 'secondary_text_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $secondary_text_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Secondary Text Color */
		.tg-service-widget .service-content-wrap,.section-title-wrapper .section-description,.team-wrapper .team-content-wrapper .team-content,.testimonial-container .testimonial-wrapper .testimonial-slide .testominial-content-wrapper .testimonial-content, button, input, select, textarea,.entry-meta a,.cat-links a,.entry-footer a,.entry-meta span,.single .entry-content-block .entry-footer span a,.single .entry-content-block .entry-footer span,#comments .comment-list article.comment-body .comment-metadata a,#comments .comment-list article.comment-body .comment-author,#respond #commentform p,.testimonial-container .testimonial-degicnation,.fun-facts-section .fun-facts-title-wrap,.blog-section .row:nth-child(odd) .entry-meta a,.blog-section .row:nth-child(even) .entry-meta a,.tg-blog-widget-layout-2 .read-more-container .entry-author a,.blog-section .tg-blog-widget-layout-2 .read-more-container .entry-author,.tg-slider-widget .caption-desc  {
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
 * @see   wp_add_inline_style()
 */
function flash_frontend_css() {
	$pageheader_background = get_theme_mod( 'flash_pageheader_background_image', '' );
	$customizer_input_css  = get_theme_mod( 'flash_custom_css', '' );
	$css                   = '';

	// Don't do anything if the page header image is not uploaded.
	if ( $pageheader_background ) {
		$css .= '
		/* Page header Background. */
		.breadcrumb-trail.breadcrumbs {
			color: #fff;
		}

		#flash-breadcrumbs a,
		#flash-breadcrumbs span,
		.breadcrumb-trail.breadcrumbs .trail-items li span::before{
			color: #fff;
		}
	';
	}

	if ( ! display_header_text() ) {
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
		.logo .logo-text{
			padding: 0;
		}
		';
	}

	if ( $customizer_input_css ) {
		$css .= '
		/* Custom CSS */
		' . $customizer_input_css . '
		';
	}

	if ( ! empty( $css ) ) {
		wp_add_inline_style( 'flash-style', $css );
	}
}

add_action( 'wp_enqueue_scripts', 'flash_frontend_css', 14 );
