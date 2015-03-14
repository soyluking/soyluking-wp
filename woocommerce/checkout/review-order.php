<?php
/**
 * Review order table
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section id="order_review">
	<div class="smalltitle"><?php _e( 'Your Order',THB_THEME_NAME ); ?></div>
	<table class="shopping_bag woocommerce-checkout-review-order-table order_table">
		<thead>
			<tr>
				<th class="product-name" colspan="3"><?php _e( 'Product',THB_THEME_NAME ); ?></th>
				<th class="product-subtotal"><?php _e( 'Total',THB_THEME_NAME ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				do_action( 'woocommerce_review_order_before_cart_contents' );
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						?>
						<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
							<td class="product-name" colspan="3">
								<h6><?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ); ?></h6>
								<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
								<?php echo WC()->cart->get_item_data( $cart_item ); ?>
							</td>
							<td class="product-total">
								<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
							</td>
						</tr>
						<?php
					}
				}
				do_action( 'woocommerce_review_order_after_cart_contents' );
			?>
		</tbody>
		<tfoot>
			<tr class="cart-subtotal">
				<th colspan="3"><?php _e( 'Cart Subtotal',THB_THEME_NAME ); ?></th>
				<td class="product-subtotal"><?php wc_cart_totals_subtotal_html(); ?></td>
			</tr>
			<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
				<tr class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
					<th colspan="3"><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
					<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
				</tr>
			<?php endforeach; ?>
				
			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
			
				<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
	
				<?php wc_cart_totals_shipping_html(); ?>
	
				<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
	
			<?php endif; ?>
				
			<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
				<tr class="fee">
					<th colspan="3"><?php echo esc_html( $fee->name ); ?></th>
					<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
				</tr>
			<?php endforeach; ?>
				
			<?php if ( WC()->cart->tax_display_cart === 'excl' ) : ?>
				<?php if ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) : ?>
					<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
						<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
							<th colspan="3"><?php echo esc_html( $tax->label ); ?></th>
							<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr class="tax-total">
						<th colspan="3"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
						<td><?php echo wc_price( WC()->cart->get_taxes_total() ); ?></td>
					</tr>
				<?php endif; ?>
			<?php endif; ?>
				
			<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>
			
			<tr class="order-total">
				<th colspan="3"><?php _e( 'Order Total', THB_THEME_NAME ); ?></th>
				<td><?php wc_cart_totals_order_total_html(); ?></td>
			</tr>
			
			<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
				
		</tfoot>
	</table>
</section>