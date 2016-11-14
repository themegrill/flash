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
