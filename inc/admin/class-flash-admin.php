<?php
/**
 * Flash Admin Class.
 *
 * @author  ThemeGrill
 * @package flash
 * @since   1.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Flash_Admin' ) ) :

	/**
	 * Flash_Admin Class.
	 */
	class Flash_Admin {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Localize array for import button AJAX request.
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'flash-admin-style', get_template_directory_uri() . '/inc/admin/css/admin.css', array(), FLASH_THEME_VERSION );

			wp_enqueue_script( 'flash-plugin-install-helper', get_template_directory_uri() . '/inc/admin/js/plugin-handle.js', array( 'jquery' ), FLASH_THEME_VERSION, true );

			$welcome_data = array(
				'uri'      => esc_url( admin_url( '/themes.php?page=demo-importer&browse=all&flash-hide-notice=welcome' ) ),
				'btn_text' => esc_html__( 'Processing...', 'flash' ),
				'nonce'    => wp_create_nonce( 'flash_demo_import_nonce' ),
			);

			wp_localize_script( 'flash-plugin-install-helper', 'flashRedirectDemoPage', $welcome_data );
		}
	}

endif;

return new Flash_Admin();
