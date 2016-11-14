<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Flash
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function flash_body_classes( $classes ) {
	global $post;
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if( get_theme_mod( 'flash_site_layout', 'wide' ) == 'boxed') {
		$classes[] = 'boxed';
	}

	if( is_singular() ) {
		$post_specific_transparency = get_post_meta( $post->ID, 'flash_transparency', true );
		$classes[] = $post_specific_transparency;
	}

	if( get_theme_mod( 'flash_sticky_header', '' ) == '1') {
		$classes[] = 'header-sticky';
	}

	$logo_class = esc_attr( get_theme_mod( 'flash_logo_position', 'left-logo-right-menu' ) );
	$classes[]  = $logo_class;

	if( ( is_archive() || ( is_home() && !is_front_page() ) ) ) {
		$classes[] = esc_attr( get_theme_mod( 'flash_archive_layout', 'right-sidebar' ) );
		$classes[] = esc_attr( get_theme_mod( 'flash_blog_style', 'classic-layout' ) );
	}

	if( is_single() ) {
		$post_specific_layout = get_post_meta( $post->ID, 'flash_page_layout', true );
		if( empty($post_specific_layout) || $post_specific_layout == 'default-layout' ) {
			$classes[] = esc_attr( get_theme_mod( 'flash_post_layout', 'right-sidebar' ) );
		} else {
			$classes[] = esc_attr( $post_specific_layout );
		}
	}
	if( is_page() ) {
		$post_specific_layout = get_post_meta( $post->ID, 'flash_page_layout', true );
		if( empty($post_specific_layout) || $post_specific_layout == 'default-layout' ) {
			$classes[] = esc_attr( get_theme_mod( 'flash_page_layout', 'right-sidebar' ) );
		} else {
			$classes[] = esc_attr( $post_specific_layout );
		}
	}

	return $classes;
}
add_filter( 'body_class', 'flash_body_classes' );

if ( ! function_exists( 'flash_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @since Flash 1.0.0
 */
function flash_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

if ( ! function_exists( 'flash_top_header_content' ) ) :
/**
 * Content for Top Header Sections.
 *
 * @since Flash 1.0
 */
function flash_top_header_content( $position ) {

	if( ( get_theme_mod( $position ) == 'header-text' ) ) {
		$header_text = get_theme_mod( 'flash_top_header_text', '' );
		return wp_kses_post( $header_text );
	} elseif ( ( get_theme_mod( $position ) == 'social-menu' ) ) {
		$social_menu = wp_nav_menu( array( 'theme_location' => 'social', 'menu_class' => 'social-menu', 'fallback_cb' => false, 'link_before' => '<span class="screen-reader-text">', 'link_after' => '</span>', 'depth' => 1, ) );
		return $social_menu;
	}

}
endif;

if ( ! function_exists( 'flash_footer_copyright' ) ) :
/**
 * Footer Copyright Text.
 *
 * @since Flash 1.0
 */
function flash_footer_copyright() {
	?>
<div class="copyright">
	<span class="copyright-text">
	<?php esc_html_e( 'Copyright © 2015', 'flash' ); ?>
	<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'flash' ), 'Flash', '<a href="http://themegrill.com" rel="designer">ThemeGrill</a>' ); ?>
	<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'flash' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'flash' ), 'WordPress' ); ?></a>
	</span>
</div><!-- .copyright -->
<?php
}
endif;

add_action( 'flash_copyright_area', 'flash_footer_copyright' );

if ( ! function_exists( 'flash_breadcrumbs' ) ) :
/**
 * Breadcrumb for Flash
 *
 * @since Flash 1.0
 */
function flash_breadcrumbs() {

	// Settings
	$separator          = '&gt;';
	$home_title         = esc_html__('Home', 'flash');

	// Get the query & post information
	global $post,$wp_query;

	// Do not display on the homepage
	if ( get_theme_mod( 'flash_remove_breadcrumbs', '' ) != '1' ) {

		// Build the breadcrums
		echo '<ul class="trail-items">';

		// Home page
		echo '<li class="trail-item trail-begin"><a class="trail-home" href="' . esc_html( get_home_url() ) . '" title="' . $home_title . '"><span>' . $home_title . '</span></a></li>';

		if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

			// If post is a custom post type
			$post_type = get_post_type();

			// If it is a custom post type display name and link
			if($post_type != 'post') {

				$post_type_object       = get_post_type_object($post_type);
				$post_type_archive_link = get_post_type_archive_link($post_type);

				echo '<li class="trail-item"><a class="item-taxonomy" href="' . esc_url( $post_type_archive_link ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '"><span>' . esc_html( $post_type_object->labels->name ) . '</span></a></li>';
			}

			$custom_taxonomy = get_queried_object()->name;
			echo '<li class="trail-item"><span>' . esc_html( $custom_taxonomy ) . '</span></li>';

		} else if ( is_single() ) {

			// If post is a custom post type
			$post_type = get_post_type();

			// If it is a custom post type display name and link
			if($post_type != 'post') {

				$post_type_object = get_post_type_object($post_type);
				$post_type_archive_link = get_post_type_archive_link($post_type);

				echo '<li class="trail-item"><a class="item-custom-post-type" href="' . esc_url( $post_type_archive_link ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '"><span>' . esc_html( $post_type_object->labels->name ) . '</span></a></li>';
			}

			// Get post category info
			$category = get_the_category();

			if(!empty($category)) {

				// Get last category post is in
				$slice_array   = array_slice($category, -1);
				$last_category = array_pop($slice_array);

				// Get parent any categories and create array
				$get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
				$cat_parents     = explode(',',$get_cat_parents);

				// Loop through parent categories and store in variable $cat_display
				$cat_display = '';
				foreach($cat_parents as $parents) {
					$cat_display .= '<li class="trail-item item-category"><span>'. $parents .'</span></li>';
				}

			}

			// Check if the post is in a category
			if(!empty($last_category)) {
				echo $cat_display;
				echo '<li class="trail-item"><span>' . esc_html( get_the_title() ) . '</span></li>';

			} else {

				echo '<li class="trail-item"><span>' . esc_html( get_the_title() ) . '</span></li>';

			}

		} else if ( is_category() ) {

			// Category page
			echo '<li class="trail-item"><span>' . single_cat_title('', false) . '</span></li>';

		} else if ( is_page() ) {

			// Standard page
			if( $post->post_parent ){

				// If child page, get parents
				$anc = get_post_ancestors( $post->ID );

				// Get parents in the right order
				$anc = array_reverse($anc);

				$parents = '';

				// Parent page loop
				foreach ( $anc as $ancestor ) {
					$parents .= '<li class="trail-item"><a class="item-parent" href="' . esc_url ( get_permalink($ancestor) ) . '" title="' . esc_attr( get_the_title($ancestor) ) . '"><span>' . esc_html( get_the_title($ancestor) ) . '</span></a></li>';
				}

				// Display parent pages
				echo $parents;

				// Current page
				echo '<li class="trail-item"><span>' . esc_html( get_the_title() ) . '</span></li>';

			} else {

				// Just display current page if not parents
				echo '<li class="trail-item"><span>' . esc_html( get_the_title() ) . '</span></li>';
			}

		} else if ( is_tag() ) {

			// Tag page

			// Get tag information
			$term_id        = get_query_var('tag_id');
			$taxonomy       = 'post_tag';
			$args           = 'include=' . $term_id;
			$terms          = get_terms( $taxonomy, $args );
			$get_term_id    = $terms[0]->term_id;
			$get_term_slug  = $terms[0]->slug;
			$get_term_name  = $terms[0]->name;

			// Display the tag name
			echo '<li class="trail-item"><span>' . esc_html( $get_term_name ) . '</span></li>';

		} elseif ( is_day() ) {

			// Day archive

			// Year link
			echo '<li class="trail-item"><a class="item-year" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'flash' ) ) ) ) . '" title="' . esc_attr( get_the_time( __( 'Y', 'flash' ) ) ). '"><span>' . esc_html( get_the_time( __( 'Y', 'flash' ) ) ) . '</span></a></li>';

			// Month link
			echo '<li class="trail-item"><a class="item-month" href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'flash' ) ), get_the_time( __( 'M', 'flash' ) ) ) ) . '" title="' . esc_attr( get_the_time( __( 'M', 'flash' ) ) ) . '"><span>' . esc_html( get_the_time( __( 'M', 'flash' ) ) ) . '</span></a></li>';

			// Day display
			echo '<li class="trail-item"><span>' . esc_html( gget_the_time( __( 'jS', 'flash' ) ) . get_the_time( __( 'M', 'flash' ) ) ) .'</span></li>';

		} else if ( is_month() ) {

			// Month Archive

			// Year link
			echo '<li class="trail-item"><a class="item-year" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'flash' ) ) ) ) . '" title="' . esc_attr( get_the_time( __( 'Y', 'flash' ) ) ). '"><span>' . esc_html( get_the_time( __( 'Y', 'flash' ) ) ) . '</span></a></li>';

			// Month link
			echo '<li class="trail-item"><span>' . esc_html( get_the_time( __( 'M', 'flash' ) ) ) . '</span></li>';

		} else if ( is_year() ) {

			// Display year archive
			echo '<li class="trail-item"><span>' . esc_html( get_the_time( __( 'Y', 'flash' ) ) ). '</span></li>';

		} else if ( is_author() ) {

			// Auhor archive

			// Get the author information
			global $author;
			$userdata = get_userdata( $author );

			// Display author name
			echo '<li class="trail-item"><span>' . esc_html( $userdata->display_name ). '</span></li>';

		} else if ( get_query_var('paged') ) {

			// Paginated archives
			echo '<li class="trail-item"><span>'.esc_html__( 'Page', 'flash' ) . esc_html( get_query_var('paged') ) . '</span></li>';

		} else if ( is_search() ) {

			// Search results page
			echo '<li class="trail-item"><span>' .esc_html__( 'Search results for: ', 'flash' ) . esc_html( get_search_query() ) . '</span></li>';

		} elseif ( is_404() ) {

			// 404 page
			echo '<li class="trail-item"><span>'.esc_html__('404 Error', 'flash').'</span></li>';
		}

		echo '</ul>';

	}

}
endif;

if ( ! function_exists( 'flash_page_title' ) ) :
/**
 * Title for page header
 *
 * @since Flash 1.0
 */
function flash_page_title() {
	if( is_archive() ) {
		$flash_header_title = get_the_archive_title();
	}
	elseif( is_404() ) {
		$flash_header_title = esc_html__( 'Page NOT Found', 'flash' );
	}
	elseif ( is_search() ) {
		$flash_header_title  = sprintf(esc_html__( 'Search Results for: %s', 'flash' ), esc_html( get_search_query() ) );
	}
	elseif( is_singular() ) {
		$flash_header_title = get_the_title();
	}
	elseif( is_home() ){
		$queried_id = get_option( 'page_for_posts' );
		$flash_header_title = get_the_title( $queried_id );
	}
	else {
		$flash_header_title = '';
	}

	echo '<h1 class="trail-title">';
	echo $flash_header_title;
	echo '</h1>';
}
endif;

if ( ! function_exists( 'flash_excerpt_length' ) ) :
/**
 * Flash Excerpt Length
 *
 * @since Flash 1.0
 */
function flash_excerpt_length( $length ) {
	return 20;
}
endif;
add_filter( 'excerpt_length', 'flash_excerpt_length' );

/**
 * Converts a HEX value to RGB.
 *
 * @since Flash 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function flash_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

/**
 * Regenerate darker color
 *
 * @since Flash 1.0
 *
 * @param string $color The original color, in hex form
 * @return string darker color
 */
function flash_darkcolor($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
        $color   = hexdec($color); // Convert to decimal
        $color   = max(0,min(255,$color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }

    return $return;
}

if ( ! function_exists( 'flash_get_layout' ) ) :
/**
 * Returns layout setting based on post meta and customizer setting.
 *
 * @since Flash 1.0
 */
function flash_get_layout() {
	global $post;

	$layout = get_theme_mod( 'flash_archive_options', 'right-sidebar' );


	// Front page displays in Reading Settings
	$page_for_posts = get_option('page_for_posts');

	// Get Layout meta
	if($post) {
		$post_specific_layout = get_post_meta( $post->ID, 'flash_page_layout', true );
	}
	// Home page if Posts page is assigned
	if( is_home() && !( is_front_page() ) ) {
		$queried_id  = get_option( 'page_for_posts' );
		$post_specific_layout = get_post_meta( $queried_id, 'flash_page_layout', true );

		if( !empty($post_specific_layout) && $post_specific_layout != 'default-layout' ) {
	 		$layout = get_post_meta( $queried_id, 'flash_page_layout', true );
		}
	}

	elseif( is_page() ) {
		$layout = get_theme_mod( 'flash_page_layout', 'right-sidebar' );
		if( !empty($post_specific_layout) && $post_specific_layout != 'default-layout' ) {
			$layout = get_post_meta( $post->ID, 'flash_page_layout', true );
		}
	}

	elseif( is_single() ) {
		$layout = get_theme_mod( 'flash_post_layout', 'right-sidebar' );
		if( !empty($post_specific_layout) && $post_specific_layout != 'default-layout' ) {
			$layout = get_post_meta( $post->ID, 'flash_page_layout', true );
		}
	}

	return $layout;
}
endif;

add_action('wp_head', 'flash_custom_fonts');
/**
 * Returns typography.
 *
 * @since Flash 1.0
 */
function flash_custom_fonts() {
	$flash_custom_fonts_values = '';
	$body_font = get_theme_mod( 'flash_body_font', 'Montserrat:400,700');
	$google_fonts = flash_google_fonts();
	$font_family = $google_fonts[ $body_font ];

	if( isset( $font_family ) ) {
		$flash_custom_fonts_values .= 'body { font-family: "'.$font_family.'"; }';
	}


	if( !empty( $flash_custom_fonts_values ) ) {
		?>
		<style type="text/css"><?php echo $flash_custom_fonts_values; ?></style>
		<?php
	}
}
