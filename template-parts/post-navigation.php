<?php
/**
 * Template for displaying post navigation
 *
 * @package Flash
 */
the_post_navigation( array(
	'next_text' => '<span><i class="fa fa-angle-right"></i></span>
		<span class="entry-title">%title</span>',
	'prev_text' => '<span><i class="fa fa-angle-left"></i></span>
		<span class="entry-title">%title</span>',
) );
