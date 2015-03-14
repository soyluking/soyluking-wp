<?php
/**
 * Login form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_user_logged_in() ) 
	return;
?>
<div id="customer_login">
	<form method="post" class="login" <?php if ( $hidden ) echo 'style="display:none;"'; ?>>
	
		<?php do_action( 'woocommerce_login_form_start' ); ?>
	
		<?php if ( $message ) echo '<div class="text-center"><h5>'.$message.'</h5></div>'; ?>
		
		<div class="row">
			<div class="small-12 medium-6 columns">
				<label for="username"><?php _e( 'Username or email', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="text" class="input-text full" name="username" id="username" />
			</div>
			<div class="small-12 medium-6 columns">
				<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input class="input-text full" type="password" name="password" id="password" />
			</div>
		
			<?php do_action( 'woocommerce_login_form' ); ?>
		
			<div class="small-6 columns">
				<div class="remember">
					<input name="rememberme" type="checkbox" id="rememberme" value="forever" class="custom_check"/> <label for="rememberme" class="checkbox custom_label"><?php _e( 'Remember me',THB_THEME_NAME ); ?></label>
				</div>
			</div>
			<div class="small-6 columns">
				<a class="lost_password" href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost Password?',THB_THEME_NAME ); ?></a>
			</div>
			<div class="small-12 columns text-center">
				<?php wp_nonce_field( 'woocommerce-login' ); ?>
				<input type="submit" class="button" name="login" value="<?php _e( 'Login',THB_THEME_NAME ); ?>" />
				<?php if($_SERVER['HTTP_HOST'] === 'notio.fuelthemes.net') {?>
				<p>Try our demo account -  <strong>username:</strong> demo <strong>password</strong> demo</p>
				<?php } ?>
			</div>
		</div>
		<?php do_action( 'woocommerce_login_form_end' ); ?>
	
	</form>
</div>