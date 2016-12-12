<?php
/**
 * Header Media Template Part with Support for Video Headers
 *
 */
if ( function_exists('the_custom_header_markup') ) {
	the_custom_header_markup();
} else {
	the_header_image_tag();
}
?>
