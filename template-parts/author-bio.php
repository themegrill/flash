<?php
// Get Author Data
$author             = get_the_author();
$author_description = get_the_author_meta( 'description' );
$author_url         = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
$author_avatar      = get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'flash_author_bio_avatar_size', 75 ) );

// Only display if author has a description
if ( $author_description && get_theme_mod( 'flash_remove_single_bio', '') != '1' ) : ?>

<div id="author-bio" class="author-description clearfix">
	<?php if ( $author_avatar ) { ?>
	<figure class="author-img">
		<?php echo $author_avatar; ?>
	</figure>
	<?php } ?>
	<div class="author-description-block">
		<div class="author-title"><a href="<?php echo esc_url( $author_url ); ?>" rel="author"><?php echo esc_html( $author ); ?></a></div>
		<div class="author-summary"><?php echo wp_kses_post( $author_description ); ?></div>
	</div>
</div><!-- #author-bio -->

<?php endif; ?>
