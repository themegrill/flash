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
			add_action( 'wp_ajax_import_button', array( $this, 'flash_ajax_import_button_handler' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'flash_ajax_enqueue_scripts' ) );
		}

		/**
		 * Localize array for import button AJAX request.
		 */
		public function flash_ajax_enqueue_scripts() {
			wp_enqueue_script( 'updates' );
			wp_enqueue_script( 'flash-plugin-install-helper', get_template_directory_uri() . '/js/plugin-handle.js', array( 'jquery' ), 1, true );
			wp_localize_script(
				'flash-plugin-install-helper', 'flash_plugin_helper',
				array(
					'activating' => esc_html__( 'Activating ', 'flash' ),
				)
			);
			$translation_array = array(
				'uri'      => esc_url( admin_url( '/themes.php?page=demo-importer&browse=all&flash-hide-notice=welcome' ) ),
				'btn_text' => esc_html__( 'Processing...', 'flash' ),
				'nonce'    => wp_create_nonce( 'flash_demo_import_nonce' ),
			);
			wp_localize_script( 'flash-plugin-install-helper', 'flash_redirect_demo_page', $translation_array );
		}

		/**
		 * Handle the AJAX process while import or get started button clicked.
		 */
		public function flash_ajax_import_button_handler() {
			check_ajax_referer( 'flash_demo_import_nonce', 'security' );
			$state = '';
			if ( class_exists( 'themegrill_demo_importer' ) ) {
				$state = 'activated';
			} elseif ( file_exists( WP_PLUGIN_DIR . '/themegrill-demo-importer/themegrill-demo-importer.php' ) ) {
				$state = 'installed';
			}
			if ( 'activated' === $state ) {
				$response['redirect'] = admin_url( '/themes.php?page=demo-importer&browse=all&flash-hide-notice=welcome' );
			} elseif ( 'installed' === $state ) {
				$response['redirect'] = admin_url( '/themes.php?page=demo-importer&browse=all&flash-hide-notice=welcome' );
				if ( current_user_can( 'activate_plugin' ) ) {
					$result = activate_plugin( 'themegrill-demo-importer/themegrill-demo-importer.php' );
					if ( is_wp_error( $result ) ) {
						$response['errorCode']    = $result->get_error_code();
						$response['errorMessage'] = $result->get_error_message();
					}
				}
			} else {
				wp_enqueue_script( 'plugin-install' );
				$response['redirect'] = admin_url( '/themes.php?page=demo-importer&browse=all&flash-hide-notice=welcome' );
				/**
				 * Install Plugin.
				 */
				include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
				include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
				$api      = plugins_api( 'plugin_information', array(
					'slug'   => sanitize_key( wp_unslash( 'themegrill-demo-importer' ) ),
					'fields' => array(
						'sections' => false,
					),
				) );
				$skin     = new WP_Ajax_Upgrader_Skin();
				$upgrader = new Plugin_Upgrader( $skin );
				$result   = $upgrader->install( $api->download_link );
				if ( $result ) {
					$response['installed'] = 'succeed';
				} else {
					$response['installed'] = 'failed';
				}
				// Activate plugin.
				if ( current_user_can( 'activate_plugin' ) ) {
					$result = activate_plugin( 'themegrill-demo-importer/themegrill-demo-importer.php' );
					if ( is_wp_error( $result ) ) {
						$response['errorCode']    = $result->get_error_code();
						$response['errorMessage'] = $result->get_error_message();
					}
				}
			}
			wp_send_json( $response );
			exit();
		}
	}

endif;

return new Flash_Admin();
