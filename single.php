<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Flash
 */

get_header(); ?>

	<?php
	/**
	 * flash_before_body_content hook
	 */
	do_action( 'flash_before_body_content' ); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );
			get_template_part( 'template-parts/author-bio', '' );

			if ( get_theme_mod( 'flash_remove_single_nav', '') != '1' ) {
				get_template_part( 'template-parts/post-navigation', '' );
			}

			if ( get_theme_mod( 'flash_related_post_option', 0 ) == 1) {
				get_template_part( 'inc/related-posts' );
			}

			/**
			 * flash_before_comment_template hook
			 */
			do_action( 'flash_before_comment_template' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			/**
			 * flash_after_comment_template hook
			 */
			do_action( 'flash_after_comment_template' );

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php
	/**
	 * flash_after_body_content hook
	 */
	do_action( 'flash_after_body_content' ); ?>

<?php
get_sidebar();
get_sidebar( 'left' );
get_footer();
