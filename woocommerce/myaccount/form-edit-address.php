<?php
/**
 * Edit address form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $current_user;

$page_title = ( $load_address == 'billing' ) ? __( 'Billing Address',THB_THEME_NAME ) : __( 'Shipping Address',THB_THEME_NAME );

get_currentuserinfo();

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
			<li><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
				<?php _e('Back to My Account', THB_THEME_NAME); ?>
			</a></li>
		</ul>
	</div>
	<div class="sidebar-page push">
		<div class="tab-pane active">
			<div class="largetitle"><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title ); ?></div>
			<?php wc_print_notices()  ?>
			
			<?php if (!$load_address) : ?>
			
				<?php wc_get_template('myaccount/my-address.php'); ?>
			
			<?php else : ?>
			
				<form method="post" class="edit-address-form">
			
					<?php
					foreach ($address as $key => $field) :
						woocommerce_form_field( $key, $field, ! empty( $_POST[ $key ] ) ? wc_clean( $_POST[ $key ] ) : $field['value'] );
					endforeach;
					?>
			
					<p>
						<input type="submit" class="button" name="save_address" value="<?php _e( 'Save Address',THB_THEME_NAME ); ?>" />
						<?php wp_nonce_field( 'woocommerce-edit_address' ); ?>
						<input type="hidden" name="action" value="edit_address" />
					</p>
			
				</form>
			
			<?php endif; ?>
		</div>
	</div>
</div>
