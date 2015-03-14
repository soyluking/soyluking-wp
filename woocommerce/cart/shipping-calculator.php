<?php
/**
 * Shipping Calculator
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.8
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

if ( get_option('woocommerce_enable_shipping_calc')=='no' || ! $woocommerce->cart->needs_shipping() )
	return;
?>

<?php do_action( 'woocommerce_before_shipping_calculator' ); ?>



<aside class="shipping-calculator-button"><span>+</span> <?php _e( 'Calculate Shipping',THB_THEME_NAME ); ?></aside>

<form class="shipping_calculator" action="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" method="post">

	<section class="shipping-calculator-form">
		<div class="formrow">
			<div class="select-wrapper">
				<select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state expand" rel="calc_shipping_state">
					<option value=""><?php _e( 'Select a country&hellip;',THB_THEME_NAME ); ?></option>
					<?php
						foreach( $woocommerce->countries->get_allowed_countries() as $key => $value )
							echo '<option value="' . esc_attr( $key ) . '"' . selected( $woocommerce->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
					?>
				</select>
			</div>
		</div>

		<div class="formrow">
			<?php
				$current_cc = WC()->customer->get_shipping_country();
				$current_r  = WC()->customer->get_shipping_state();
				$states     = WC()->countries->get_states( $current_cc );

				// Hidden Input
				if ( is_array( $states ) && empty( $states ) ) {

					?><input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php _e( 'State / county',THB_THEME_NAME ); ?>" /><?php

				// Dropdown Input
				} elseif ( is_array( $states ) ) {

					?><div class="select-wrapper">
						<select name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php _e( 'State / county',THB_THEME_NAME ); ?>">
							<option value=""><?php _e( 'Select a state&hellip;',THB_THEME_NAME ); ?></option>
							<?php
								foreach ( $states as $ckey => $cvalue )
									echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . __( esc_html( $cvalue ),THB_THEME_NAME ) .'</option>';
							?>
						</select>
					</div><?php

				// Standard Input
				} else {

					?><input type="text" class="input-text" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php _e( 'State / county',THB_THEME_NAME ); ?>" name="calc_shipping_state" id="calc_shipping_state" /><?php

				}
			?>
		</div>

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ) : ?>

			<div class="formrow">
				<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php _e( 'City', THB_THEME_NAME ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
			</div>

		<?php endif; ?>

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>

			<div class="formrow">
				<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php _e( 'Postcode / Zip', 'woocommerce' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
			</div>

		<?php endif; ?>

		<div class="formrow"><button type="submit" name="calc_shipping" value="1" class="button outline full"><?php _e( 'Update Totals',THB_THEME_NAME ); ?></button></div>

		<?php wp_nonce_field( 'woocommerce-cart' ); ?>
	</section>
</form>

<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>