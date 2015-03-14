<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<div class="table text-center cart-empty full-height-content">
	<div>
		<section>
			<figure></figure>
			<p class="message"><?php _e( 'Your cart is currently empty.', THB_THEME_NAME) ?></p>
			<?php do_action( 'woocommerce_cart_is_empty' ); ?>
			
			<p class="return-to-shop"><a class="button wc-backward" href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php _e( 'Return To Shop', THB_THEME_NAME ) ?></a></p>
		</section>
	</div>
</div>