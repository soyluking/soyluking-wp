<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page
 *
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version   2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>
<div class="your-order-header parallax_bg" data-stellar-background-ratio="0.2">
	<div class="row">
		<div class="small-12 medium-8 medium-centered columns" data-equal=".order-details">
			<div class="order-container">
				<?php _e( 'Order',THB_THEME_NAME ); ?><span><?php echo $order->get_order_number(); ?></span>
			</div>
			<div class="small-12 medium-4 columns order-details"><label><?php _e( 'Date',THB_THEME_NAME ); ?></label>
			<?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></div>
			<div class="small-12 medium-4 columns order-details"><label><?php _e( 'Total',THB_THEME_NAME ); ?></label>
			<?php echo $order->get_formatted_order_total(); ?></div>
			<div class="small-12 medium-4 columns order-details"><label><?php _e( 'Payment method',THB_THEME_NAME ); ?></label>
			<?php echo $order->payment_method_title; ?></div>
			
			<div class="status<?php if ( $order->has_status( 'failed' ) ) : ?> failed<?php endif; ?>">
				<h6><?php printf( __( 'Your order is currently <u>%s</u>.', 'woocommerce' ), wc_get_order_status_name( $order->get_status() ) ); ?></h6>
			</div>
		</div>
	</div>
</div>

<?php if ( $notes = $order->get_customer_order_notes() ) :
	?>
	<h2><?php _e( 'Order Updates', 'woocommerce' ); ?></h2>
	<ol class="commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
		<li class="comment note">
			<div class="comment_container">
				<div class="comment-text">
					<p class="meta"><?php echo date_i18n( __( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); ?></p>
					<div class="description">
						<?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
					</div>
	  				<div class="clear"></div>
	  			</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
	<?php
endif;

do_action( 'woocommerce_view_order', $order_id );
