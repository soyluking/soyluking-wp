<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $yith_wcwl;

?>
<div class="page-container" id="my-account">
	<div class="sidebar my-account-menu full-height-content pull">
		<div class="account-user">
			<?php 
			 	 $current_user = wp_get_current_user();
			 	 $user_id = $current_user->ID;
				echo get_avatar( $user_id, 100 );
			?>
			
			<span class="user-name"><?php _e( 'Welcome,', THB_THEME_NAME ); ?> <?php echo $current_user->display_name; ?></span>
			<p><?php _e( 'You can manage your orders and edit your account here.', THB_THEME_NAME ); ?></p>
		</div>
		<ul id="my-account-nav">
			<li class="active"><a href="#my-orders" class="account-icon-box">
				<?php _e("MY ORDERS", THB_THEME_NAME); ?>
			</a></li>
			<?php if ($yith_wcwl) { ?>
			<li><a href="#my-wishlist" class="account-icon-box">
				<?php _e("MY WISHLIST", THB_THEME_NAME); ?>
			</a></li>
			<?php } ?>
			<?php if ( $downloads = WC()->customer->get_downloadable_products() ) { ?>
			<li><a href="#my-downloads" class="account-icon-box">
				<?php _e("MY DOWNLOADS", THB_THEME_NAME); ?>
			</a></li>
			<?php } ?>
			<?php if (class_exists('WC_Subscriptions')) { ?>
			<li><a href="#my-subscriptions" class="account-icon-box">
				<?php _e("MY SUBSCRIPTIONS", THB_THEME_NAME); ?>
			</a></li>
			<?php } ?>
			<li><a href="#address-book" class="account-icon-box">
				<?php _e("MY ADDRESSES", THB_THEME_NAME); ?>
			</a></li>
			<li><a href="#edit-account" class="account-icon-box">
				<?php _e("MY ACCOUNT", THB_THEME_NAME); ?>
			</a></li>
			<li><a href="<?php echo wp_logout_url(); ?>" class="account-icon-box">
				<?php _e("LOGOUT", THB_THEME_NAME); ?>
			</a></li>
		</ul>
	</div>
	<div class="sidebar-page push">
		<div class="tab-pane active" id="my-orders">
		
			
			<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>
		
		</div>
		
		<div class="tab-pane" id="address-book">
		
			
			<?php wc_get_template( 'myaccount/my-address.php' ); ?>
		
		</div>	
		
		<div class="tab-pane" id="edit-account">
		
			
			<?php wc_get_template( 'myaccount/form-edit-account.php' ); ?>
		
		</div>
		<?php if ($yith_wcwl) { ?>
		<div class="tab-pane" id="my-wishlist">
		
			
			<?php wc_get_template( 'wishlist.php' ); ?>
		
		</div>
		<?php } ?>
		<div class="tab-pane" id="my-downloads">
		
			
			<?php wc_get_template( 'myaccount/my-downloads.php' ); ?>
		
		</div>
		<?php if (class_exists('WC_Subscriptions')) { ?>
		<div class="tab-pane" id="my-subscriptions">
		
			
			<?php if (class_exists('WC_Subscriptions')) { WC_Subscriptions::get_my_subscriptions_template(); } ?>
		
		</div>
		<?php } ?>
	</div>
</div>

