<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Flash
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	$blog_style = get_theme_mod( 'flash_blog_style', 'classic-layout' );
	if ( !is_singular() ) {
		if( $blog_style == 'classic-layout' ) {
			$image_size = 'flash-square';
		} elseif( $blog_style == 'full-width-archive' ){
			$image_size = 'flash-big';
		} else {
			$image_size = 'flash-grid';
		}
	} else {
		$image_size = 'full';
	}
	?>
	<?php if( has_post_thumbnail() ) : ?>
	<div class="entry-thumbnail">
		<?php the_post_thumbnail( $image_size ); ?>
	</div>
	<?php endif; ?>

	<div class="entry-content-block">
		<header class="entry-header">
			<?php
			if ( !is_single() ) :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
			?>
		</header><!-- .entry-header -->

		<?php
		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php flash_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>

		<div class="entry-content">
			<?php if ( is_singular() ) : ?>
				<?php the_content(); ?>
			<?php else: ?>
				<?php the_excerpt(); ?>
			<?php endif; ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'flash' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php flash_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-## -->
