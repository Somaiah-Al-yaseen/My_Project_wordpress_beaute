<?php
	if ( ! current_theme_supports( 'vamtam-cart-dropdown' ) ) {
		return;
	}
?>

<div class="cart-dropdown hidden">
	<div class="cart-dropdown-inner">
		<a class="vamtam-cart-dropdown-link" href="<?php echo esc_url( vamtam_wc_get_cart_url() ) ?>">
			<span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path d="M10.656 9.344v-2.688c0.192-3.456 2.048-5.28 5.376-5.28s5.152 1.824 5.312 5.312v2.656h2.656c1.472 0 2.656 1.184 2.656 2.656v16c0 1.472-1.184 2.656-2.656 2.656h-16c-1.472 0-2.656-1.184-2.656-2.656v-16c0-1.472 1.184-2.656 2.656-2.656h2.656zM12 9.344h8v-2.624c-0.096-2.72-1.376-4-3.968-4s-3.872 1.28-4.032 3.968v2.656zM10.656 10.656h-2.656c-0.736 0-1.344 0.608-1.344 1.344v16c0 0.736 0.608 1.344 1.344 1.344h16c0.736 0 1.344-0.608 1.344-1.344v-16c0-0.736-0.608-1.344-1.344-1.344h-2.656v3.872c0 0.384-0.288 0.672-0.672 0.672s-0.672-0.288-0.672-0.672v-3.872h-8v3.872c0 0.384-0.288 0.672-0.672 0.672-0.352 0-0.672-0.288-0.672-0.672v-3.872z"></path></svg></span>
			<span class="products cart-empty">...</span>
		</a>
		<div class="widget woocommerce widget_shopping_cart hidden">
			<div class="widget_shopping_cart_content"></div>
		</div>
	</div>
</div>
