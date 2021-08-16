<?php
/**
 * Flash functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Flash
 */

if ( ! function_exists( 'flash_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function flash_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Flash, use a find and replace
		 * to change 'flash' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'flash', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Image size
		 */
		add_image_size( 'flash-square', '300', '300', true );
		add_image_size( 'flash-big', '800', '400', true );
		add_image_size( 'flash-grid', '370', '270', true );

		/**
		 * Enable support for site Logo
		 */
		add_theme_support( 'custom-logo' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'flash' ),
			'social'  => esc_html__( 'Social', 'flash' ),
			'footer'  => esc_html__( 'Footer', 'flash' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/**
		 * Enable support for woocommerce and woocommerce 3.0 product gallery
		 */
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		/**
		 * Enable support for SiteOrigin Page Builder
		 */
		add_theme_support( 'siteorigin-panels', array(
			'margin-bottom'       => 0,
			'recommended-widgets' => false,
		) );

		/**
		 * Enable Support for selective refresh widgets in Customizer
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Gutenberg layout support.
		add_theme_support( 'align-wide' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

	    // Responsive embeds support.
		add_theme_support( 'responsive-embeds' );
	}
endif;

add_action( 'after_setup_theme', 'flash_setup' );

/**
 * Enqueue block editor styles.
 *
 * @since Flash 1.3.5
 */
function flash_block_editor_styles()
{
	wp_enqueue_style('flash-editor-googlefonts', '//fonts.googleapis.com/css?family=Montserrat:400,700&display=swap');
	wp_enqueue_style('flash-block-editor-styles', get_template_directory_uri() . '/style-editor-block.css');
}
add_action('enqueue_block_editor_assets', 'flash_block_editor_styles', 1, 1);

// Theme version.
$flash_theme = wp_get_theme();
define( 'FLASH_THEME_VERSION', $flash_theme->get( 'Version' ) );

if ( ! function_exists( 'flash_content_width' ) ) :
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * @global int $content_width
	 **/
	function flash_content_width() {
		$content_width = 780;

		$classes = flash_get_layout();
		if ( $classes == 'full-width' ) {
			$content_width = 1200;
		}

		$GLOBALS['content_width'] = apply_filters( 'flash_content_width', $content_width );
	}

	add_action( 'after_setup_theme', 'flash_content_width', 0 );
endif;

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function flash_widgets_init() {
	// Right Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'flash' ),
		'id'            => 'flash_right_sidebar',
		'description'   => esc_html__( 'Add widgets here for right sidebar.', 'flash' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	// Left Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar', 'flash' ),
		'id'            => 'flash_left_sidebar',
		'description'   => esc_html__( 'Add widgets here for left sidebar.', 'flash' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	// Footer 1
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar 1', 'flash' ),
		'id'            => 'flash_footer_sidebar1',
		'description'   => esc_html__( 'Add widgets here for footer sidebar 1.', 'flash' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	// Footer 2
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar 2', 'flash' ),
		'id'            => 'flash_footer_sidebar2',
		'description'   => esc_html__( 'Add widgets here for footer sidebar 2.', 'flash' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	// Footer 3
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar 3', 'flash' ),
		'id'            => 'flash_footer_sidebar3',
		'description'   => esc_html__( 'Add widgets here for footer sidebar 3.', 'flash' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	// Footer 4
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar 4', 'flash' ),
		'id'            => 'flash_footer_sidebar4',
		'description'   => esc_html__( 'Add widgets here for footer sidebar 4.', 'flash' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'flash_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function flash_scripts() {
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	// Font Awessome
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome' . $suffix . '.css', array(), false, false );
	// Swiper CSS
	wp_register_style( 'swiper', get_template_directory_uri() . '/css/swiper' . $suffix . '.css', array(), false, false );

	wp_enqueue_style( 'flash-style', get_stylesheet_uri() );
	wp_style_add_data( 'flash-style', 'rtl', 'replace' );

	// Responsive
	wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/responsive' . $suffix . '.css', array(), false, false );
	wp_style_add_data( 'responsive', 'rtl', 'replace' );
	wp_register_script( 'swiper', get_template_directory_uri() . '/js/swiper' . $suffix . '.js', array( 'jquery' ), '', true );

	if ( get_theme_mod( 'flash_sticky_header', '' ) == '1' ) {
		wp_enqueue_script( 'sticky', get_template_directory_uri() . '/js/jquery.sticky' . $suffix . '.js', array( 'jquery' ), '', true );
	}
	wp_register_script( 'isotope', get_template_directory_uri() . '/js/isotope.pkgd' . $suffix . '.js', array( 'jquery' ), '', true );

	wp_register_script( 'waypoints', get_template_directory_uri() . '/js/waypoints' . $suffix . '.js', array( 'jquery' ), '', true );

	wp_register_script( 'counterup', get_template_directory_uri() . '/js/jquery.counterup' . $suffix . '.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'nav', get_template_directory_uri() . '/js/jquery.nav' . $suffix . '.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'flash-custom', get_template_directory_uri() . '/js/flash' . $suffix . '.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'flash-navigation', get_template_directory_uri() . '/js/navigation' . $suffix . '.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'flash-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Replace main style for RTL.
	wp_style_add_data( 'flash-style', 'rtl', 'replace' );
}

add_action( 'wp_enqueue_scripts', 'flash_scripts' );

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Custom functions that act independently of the theme templates.
require get_template_directory() . '/inc/extras.php';

// Kirki Toolkit.
require get_template_directory() . '/inc/kirki/kirki.php';

// Customizer additions.
require get_template_directory() . '/inc/customizer.php';

// Load Metaboxes.
require get_template_directory() . '/inc/meta-boxes.php';

// Load Jetpack compatibility file.
require get_template_directory() . '/inc/jetpack.php';


// Load WooCommerce compatibility file.
require get_template_directory() . '/inc/woocommerce.php';

// Load SiteOrigin Panels compatibility file.
require get_template_directory() . '/inc/siteorigin-panels.php';

// Load required files for Flash notice in Admin page only.
if ( is_admin() ) {
	require get_template_directory() . '/inc/admin/class-flash-admin.php';
	require get_template_directory() . '/inc/admin/class-flash-notice.php';
	require get_template_directory() . '/inc/admin/class-flash-dashboard.php';
	require get_template_directory() . '/inc/admin/class-flash-welcome-notice.php';
	require get_template_directory() . '/inc/admin/class-flash-upgrade-notice.php';
	require get_template_directory() . '/inc/admin/class-flash-theme-review-notice.php';
}

// Migrating customize options.
require get_template_directory() . '/inc/migration.php';


/**
 * Fetch and set the typography value as Kirki defines within the theme.
 *
 * @since Flash 1.2.8
 */
function flash_font_family_change() {
	// Lets bail out if no 'theme_mods_flash' option found.
	if ( false === ( $mods = get_option( "theme_mods_flash" ) ) ) {
		return;
	}

	// Lets bail out if no 'flash_typography_transfer_free' option found.
	if ( get_option( 'flash_typography_transfer_free' ) ) {
		return;
	}

	// Assign the free theme body font family.
	$typography_options = get_theme_mod( 'flash_body_font', 'Montserrat:400,700' );

	$font_family = 'Montserrat';
	if ( $typography_options == 'Raleway:400,600,700' ) {
		$font_family = 'Raleway';
	} elseif ( $typography_options == 'Ruda:400,700' ) {
		$font_family = 'Ruda';
	}

	$value = array(
		'font-family'    => $font_family,
		'variant'        => 'regular',
	);

	// Update the 'flash_body_font' theme mod.
	set_theme_mod( 'flash_body_font', $value );

	// Set transfer as complete.
	update_option( 'flash_typography_transfer_free', 1 );
}

add_action( 'after_setup_theme', 'flash_font_family_change' );
