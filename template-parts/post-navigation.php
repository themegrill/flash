<?php
/**
 * Template for displaying post navigation
 *
 * @package Flash
 */

if (is_rtl()) {
	$next = "fa-angle-left";
	$prev = "fa-angle-right";
} else {
	$next = "fa-angle-right";
	$prev = "fa-angle-left";
}

the_post_navigation( array(
	'next_text' => '<span><i class="fa ' . $next . '"></i></span>
		<span class="entry-title">%title</span>',
	'prev_text' => '<span><i class="fa ' . $prev . '"></i></span>
		<span class="entry-title">%title</span>',
) );
