<?php
/**
 * Register customizer panels and sections.
 *
 * @package flash
 */

/**
 * Section: Flash Pro Upsell.
 */

$wp_customize->add_section(
	new Flash_Customize_Section(
		$wp_customize,
		'flash_customize_upsell_section',
		array(
			'title'    => esc_html__( 'View Pro Version', 'flash' ),
			'priority' => 5,
		)
	)
);

