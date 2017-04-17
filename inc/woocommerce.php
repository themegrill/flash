<?php
/**
 * WooCommerce Compatibilty File
 *
 * @package Flash
 */

if ( !class_exists('WooCommerce') )
	return;

// WooCommerce Wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'flash_wc_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'flash_wc_wrapper_end', 10);

// Remove WooCommerce Breadcrumbs
// It is being displayed along with page title above content section
// @see extras.php:148 flash_breadcrumbs()
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);

function flash_wc_wrapper_start() {
	echo '<div id="primary" class="content-area">';
		echo '<main id="main" class="site-main" role="main">';
}

function flash_wc_wrapper_end() {
		echo '</main>';
	echo '</div>';
}

// Ensure cart contents update when products are added to the cart via AJAX
add_filter( 'woocommerce_add_to_cart_fragments', 'flash_woocommerce_header_add_to_cart_fragment' );

function flash_woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	<div class="flash-cart-views">
		<a href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" class="wcmenucart-contents">
			<i class="fa fa-opencart"></i>
			<span class="cart-value"><?php echo wp_kses_data ( WC()->cart->get_cart_contents_count() ); ?></span>
		</a>
	</div>
	<?php

	$fragments['div.flash-cart-views'] = ob_get_clean();
	return $fragments;
}

/**
* Returns true if on a page which uses WooCommerce templates (cart and checkout are standard pages with shortcodes and which are also included)
*
* @access public
* @return bool
*/
function flash_is_woocommerce_page () {
	if(  function_exists ( 'is_woocommerce' ) && is_woocommerce()){
			return true;
	}
	$woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
									"woocommerce_terms_page_id" ,
									"woocommerce_cart_page_id" ,
									"woocommerce_checkout_page_id" ,
									"woocommerce_pay_page_id" ,
									"woocommerce_thanks_page_id" ,
									"woocommerce_myaccount_page_id" ,
									"woocommerce_edit_address_page_id" ,
									"woocommerce_view_order_page_id" ,
									"woocommerce_change_password_page_id" ,
									"woocommerce_logout_page_id" ,
									"woocommerce_lost_password_page_id" ) ;
	foreach ( $woocommerce_keys as $wc_page_id ) {
			if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
					return true ;
			}
	}
	return false;
}
