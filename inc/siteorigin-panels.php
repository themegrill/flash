<?php
/**
 * Flash Theme Customizer.
 *
 * @package Flash
 */

function flash_widget_style_attributes( $attributes, $args ) {
    if( !empty( $args['font_color'] ) ) {
        array_push($attributes['class'], 'flash_inherit_color');
    }

    return $attributes;
}

add_filter('siteorigin_panels_widget_style_attributes', 'flash_widget_style_attributes', 10, 2);
