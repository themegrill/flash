<?php $related_posts = flash_related_posts(); ?>

<?php if ( $related_posts->have_posts() ): ?>

	<div class="related-posts-wrapper">

		<h4 class="related-posts-main-title">
			<i class="fa fa-thumbs-up"></i><span><?php esc_html_e( 'You May Also Like', 'flash' ); ?></span>
		</h4>

		<div class="related-posts tg-column-wrapper clearfix">
			<?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
				<div class="tg-column-3">

					<?php if ( has_post_thumbnail() ): ?>
						<div class="post-thumbnails">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<?php the_post_thumbnail( 'flash-grid' ); ?>
							</a>
						</div>
					<?php endif; ?>

					<div class="wrapper">

						<h3 class="entry-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</h3><!--/.post-title-->

						<div class="entry-meta">
							<?php
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
							$posted_on   = '<i class="fa fa-clock-o"></i><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';
							$byline      = '<i class="fa fa-user"></i><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>';

							echo '<span class="entry-date">' . $posted_on . '</span>';

							echo '<span class="entry-author vcard author"> ' . $byline . '</span>';
							?>
						</div><!-- .entry-meta -->

					</div>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
			?>

		</div>
	</div>

<?php endif; ?>
