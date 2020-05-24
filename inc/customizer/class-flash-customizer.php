<?php
/**
 * Flash Customizer Class
 *
 * @package flash
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Flash_Customizer' ) ) :

	/**
	 * Flash Customizer class
	 */
	class Flash_Customizer {
		/**
		 * Constructor - Setup customizer
		 */
		public function __construct() {

			add_action( 'customize_register', array( $this, 'flash_register_panel' ) );
			add_action( 'customize_register', array( $this, 'flash_customize_register' ) );
			add_action( 'after_setup_theme', array( $this, 'flash_customize_options' ) );

		}

		/**
		 * Register custom controls
		 *
		 * @param WP_Customize_Manager $wp_customize Manager instance.
		 */
		public function flash_register_panel( $wp_customize ) {

			// Load customizer options extending classes.
			require get_template_directory() . '/inc/customizer/extend-customizer/class-flash-customize-section.php';
			require get_template_directory() . '/inc/customizer/extend-customizer/class-flash-customize-upsell-section.php';

			// Register extended classes.
			$wp_customize->register_section_type( 'Flash_Customize_Section' );

			// Load base class for controls.
			require_once get_template_directory() . '/inc/customizer/controls/php/class-flash-customize-base-control.php';
			// Load custom control classes.
			require_once get_template_directory() . '/inc/customizer/controls/php/class-flash-customize-upsell-control.php';

			// Register JS-rendered control types.
			$wp_customize->register_control_type( 'Flash_Customize_Upsell_Control' );

		}

		/**
		* Add postMessage support for site title and description for the Theme Customizer.
		*
		* @param WP_Customize_Manager $wp_customize Manager instance.
		*/
		public function flash_customize_register( $wp_customize ) {

			// Register panels and sections.
			require get_template_directory() . '/inc/customizer/register-panels-and-sections.php';

		}

		/**
		 * Include customizer options.
		 */
		public function flash_customize_options() {
			/**
			 * Base class.
			 */
			require get_template_directory() . '/inc/customizer/options/class-flash-customize-base-option.php';

			/**
			 * Child option classes.
			 */

			require get_template_directory() . '/inc/customizer/options/class-flash-customize-upsell-option.php';
		}

	}
endif;

new Flash_Customizer();
