<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Flash
 */

if ( ! function_exists( 'flash_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function flash_posted_on() {
	$time_string = '<time class="date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
	$posted_on = sprintf(
		'<i class="fa fa-clock-o"></i><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
	$byline = sprintf(
		'<i class="fa fa-user"></i><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
	);

	if( (get_theme_mod( 'flash_remove_meta_date', '') != '1' ) ) {
		echo '<span class="entry-date">' . $posted_on . '</span>';
	}

	if( (get_theme_mod( 'flash_remove_meta_author', '') != '1' ) ) {
		echo '<span class="entry-author"> ' . $byline . '</span>';
	}

	if( (get_theme_mod( 'flash_remove_meta_comment_count', '') != '1' ) ) {
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link"><i class="fa fa-comments"></i>';
			/* translators: %s: post title */
			comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'flash' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
			echo '</span>';
		}
	}

}
endif;
if ( ! function_exists( 'flash_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function flash_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		if( (get_theme_mod( 'flash_remove_meta_category', '') != '1' ) ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'flash' ) );
			if ( $categories_list && flash_categorized_blog() ) {
				printf( '<span class="cat-links"><i class="fa fa-calendar"></i> %1$s </span>', $categories_list ); // WPCS: XSS OK.
			}
		}

		if( (get_theme_mod( 'flash_remove_meta_tag', '') != '1' ) ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'flash' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links"><i class="fa fa-tags"></i>' . esc_html__( '%1$s', 'flash' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'flash' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link"><i class="fa fa-edit"></i>',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function flash_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'flash_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'flash_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so flash_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so flash_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in flash_categorized_blog.
 */
function flash_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'flash_categories' );
}
add_action( 'edit_category', 'flash_category_transient_flusher' );
add_action( 'save_post',     'flash_category_transient_flusher' );
