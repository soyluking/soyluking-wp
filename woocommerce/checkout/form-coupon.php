<?php
/**
 * Checkout coupon form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

if ( ! WC()->cart->coupons_enabled() ) {
	return;
}

$info_message = apply_filters( 'woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'woocommerce' ) );
$info_message .= ' <a href="#" class="showcoupon">' . __( 'Click here to enter your code', 'woocommerce' ) . '</a>';
?>
<aside class="coupon_box">
	<?php wc_print_notice( $info_message, 'notice' ); ?>
	<form class="checkout_coupon row" method="post" style="display:none">
		<div class="small-12 medium-10 medium-centered large-8 columns">
			<div class="row">
				<div class="small-12 medium-8 columns">
				<input type="text" name="coupon_code" class="input-text" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
				</div>
				<div class="small-12 medium-4 columns">
				<input type="submit" class="button outline apply_coupon" name="apply_coupon" value="<?php _e( 'Apply', 'woocommerce' ); ?>" />
				</div>
			</div>
		</div>
	</form>
</aside>