<?php
/**
 * Customize Upsellcontrol class.
 *
 * @package flash
 *
 * @see     WP_Customize_Control
 * @access  public
 */

/**
 * Class Flash_Customize_Upsell_Control
 */
class Flash_Customize_Upsell_Control extends Flash_Customize_Base_Control {

	/**
	 * Customize control type.
	 *
	 * @access public
	 * @var    string
	 */
	public $type = 'flash-upsell';

	/**
	 * Flash_Customize_Upsell_Control constructor.
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      An specific ID of the section.
	 * @param array                $args    Section arguments.
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {

		parent::__construct( $manager, $id, $args );

	}

	/**
	 * Enqueues scripts
	 */
	public function enqueue() {
		parent::enqueue();
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see    WP_Customize_Control::to_json()
	 * @access public
	 * @return void
	 */
	public function to_json() {

		parent::to_json();

	}

	/**
	 * Renders the Underscore template for this control.
	 *
	 * @see    WP_Customize_Control::print_template()
	 * @access protected
	 * @return void
	 */
	protected function content_template() {
		?>

		<div class="flash-upsell-wrapper">
			<ul class="upsell-features">
				<h3 class="upsell-heading"><?php esc_html_e( 'More Awesome Features', 'flash' ); ?></h3>
				<li class="upsell-feature"><span
						class="dashicons dashicons-yes"></span><?php esc_html_e( 'Advanced Header Options', 'flash' ); ?>
				</li>
				<li class="upsell-feature"><span
						class="dashicons dashicons-yes"></span><?php esc_html_e( 'Flexible Menu Designs', 'flash' ); ?>
				</li>
				<li class="upsell-feature"><span
						class="dashicons dashicons-yes"></span><?php esc_html_e( 'Classic, Full Width, Grid Blog', 'flash' ); ?>
				</li>
				<li class="upsell-feature"><span
						class="dashicons dashicons-yes"></span>
					<?php
					/* Translators: %1$u number of particular feature */
					echo sprintf( esc_html__( '%1$u+ Footer Layouts', 'flash' ), 10 );
					?>
				</li>
				<li class="upsell-feature"><span
						class="dashicons dashicons-yes"></span>
					<?php
					/* Translators: %1$u number of particular feature */
					echo sprintf( esc_html__( '%1$u+ Customizer Options', 'flash' ), 100 );
					?>
				</li>
				<li class="upsell-feature"><span
						class="dashicons dashicons-yes"></span><?php esc_html_e( 'Advanced Page Settings', 'flash' ); ?>
				</li>
				<li class="upsell-feature"><span
						class="dashicons dashicons-yes"></span>
					<?php
					/* Translators: %1$u number of particular feature */
					echo sprintf( esc_html__( '%1$u+ Starter Demos', 'flash' ), 14 );
					?>
				</li>
			</ul>

			<div class="launch-offer">
				<?php
				printf(
					/* translators: %1$s discount coupon code., %2$s discount percentage */
					esc_html__( 'Use the coupon code %1$s to get %2$s discount (limited time offer). Enjoy!', 'flash' ),
					'<span class="coupon-code">save10</span>',
					'10%'
				);
				?>
			</div>
		</div> <!-- /.flash-upsell-wrapper -->

		<a class="upsell-cta" target="_blank"
		   href="<?php echo esc_url( 'https://themegrill.com/flash-pricing/?utm_source=flash-dashboard-message&utm_medium=view-pricing-link&utm_campaign=upgrade' ); ?>"><?php esc_html_e( 'View Pricing', 'flash' ); ?></a>

		<?php
	}

	/**
	 * Render content is still called, so be sure to override it with an empty function in your subclass as well.
	 */
	protected function render_content() {

	}

}
