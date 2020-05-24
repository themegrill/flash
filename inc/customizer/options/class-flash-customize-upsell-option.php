<?php
/**
 * Archive/ blog layout.
 *
 * @package     flash
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/*========================================== POST/PAGE/BLOG > ARCHIVE/ BLOG ==========================================*/
if ( ! class_exists( 'Flash_Customize_Upsell_Option' ) ) :

	/**
	 * Archive/Blog option.
	 */
	class Flash_Customize_Upsell_Option extends Flash_Customize_Base_Option {

		/**
		 * Arguments for options.
		 *
		 * @return array
		 */
		public function elements() {

			return array(

				'flash_upsell'        => array(
					'setting' => array(),
					'control' => array(
						'type'     => 'upsell',
						'priority' => 10,
						'section'  => 'flash_customize_upsell_section',
					),
				)


			);

		}

	}

	new Flash_Customize_Upsell_Option();

endif;
