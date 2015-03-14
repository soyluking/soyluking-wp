<?php
/**
 * Checkout login form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) return; ?>


<?php
	$info_message  = apply_filters( 'woocommerce_checkout_login_message', __( 'Returning customer?',THB_THEME_NAME ) );
	$info_message .= ' <a href="#" class="showlogin">' . __( 'Click here to login',THB_THEME_NAME ) . '</a>';
	wc_print_notice( $info_message, 'notice' );
?>
<div class="row no-padding">
	<div class="small-12 medium-10 medium-centered columns">
		<?php
			woocommerce_login_form(
				array(
					'message'  => __( 'If you have shopped with us before, please enter your details in the boxes below.',THB_THEME_NAME ),
					'redirect' => get_permalink( wc_get_page_id( 'checkout' ) ),
					'hidden'   => true
				)
			);
		?>
	</div>
</div>