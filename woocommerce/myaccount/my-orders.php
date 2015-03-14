<?php
/**
 * My Orders
 *
 * Shows recent orders on the account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
	'numberposts' => $order_count,
	'meta_key'    => '_customer_user',
	'meta_value'  => get_current_user_id(),
	'post_type'   => wc_get_order_types( 'view-orders' ),
	'post_status' => array_keys( wc_get_order_statuses() )
) ) );
?>
<div class="largetitle"><?php echo apply_filters( 'woocommerce_my_account_my_orders_title', __( 'My Orders',THB_THEME_NAME ) ); ?></div>
<?php if ( $customer_orders ) { ?>
	<table class="shopping_bag">
	
		<thead>
			<tr>
				<th class="order-number"><span class="nobr"><?php _e( 'Order',THB_THEME_NAME ); ?></span></th>
				<th class="order-date"><span class="nobr"><?php _e( 'Date',THB_THEME_NAME ); ?></span></th>
				<th class="order-status"><span class="nobr"><?php _e( 'Status',THB_THEME_NAME ); ?></span></th>
				<th class="order-amount"><span class="nobr"><?php _e( 'Total', THB_THEME_NAME ); ?></span></th>
				<th class="order-actions"></th>
			</tr>
		</thead>
	
		<tbody><?php
			foreach ( $customer_orders as $customer_order ) {
				$order      = wc_get_order();
				$order->populate( $customer_order );
				$item_count = $order->get_item_count();
	
				?><tr>
					<td class="order-number">
						<a href="<?php echo $order->get_view_order_url(); ?>">
							<?php echo $order->get_order_number(); ?>
						</a>
					</td>
					<td class="order-date">
						<time datetime="<?php echo date( 'Y-m-d', strtotime( $order->order_date ) ); ?>" title="<?php echo esc_attr( strtotime( $order->order_date ) ); ?>"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></time>
					</td>
					<td class="order-status <?php echo wc_get_order_status_name( $order->get_status() ); ?>">
						<?php echo wc_get_order_status_name( $order->get_status() ); ?>
					</td>
					<td class="order-amount">
						<?php echo $order->get_formatted_order_total(); ?> <?php _e( 'for', THB_THEME_NAME ); ?> <?php echo $item_count; ?> <?php _e( 'item(s)', THB_THEME_NAME ); ?>
					</td>
					<td class="order-actions">
						<?php
							$actions = array();
	
							if ( in_array( $order->status, apply_filters( 'woocommerce_valid_order_statuses_for_payment', array( 'pending', 'failed' ), $order ) ) ) {
								$actions['pay'] = array(
									'url'  => $order->get_checkout_payment_url(),
									'name' => __( 'Pay',THB_THEME_NAME )
								);
							}
	
							if ( in_array( $order->status, apply_filters( 'woocommerce_valid_order_statuses_for_cancel', array( 'pending', 'failed' ), $order ) ) ) {
								$actions['cancel'] = array(
									'url'  => $order->get_cancel_order_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ),
									'name' => __( 'Cancel',THB_THEME_NAME )
								);
							}
	
							$actions['view'] = array(
								'url'  => $order->get_view_order_url(),
								'name' => __( 'View',THB_THEME_NAME )
							);
	
							$actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order );
	
							if ($actions) {
								foreach ( $actions as $key => $action ) {
									echo '<a href="' . esc_url( $action['url'] ) . '" class="' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
								}
							}
						?>
					</td>
				</tr><?php
			}
		?></tbody>
	
	</table>
<?php } else { ?>
	<div class="smalltitle"><?php _e('You have no orders at the moment.',THB_THEME_NAME ); ?></div>
<?php } ?>
