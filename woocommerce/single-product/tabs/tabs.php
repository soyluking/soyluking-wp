<?php
/**
 * Single Product tabs / and sections
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() ); 
?>

<div class="thb_tabs product_tabs">
	<dl class="tabs">
		<?php foreach ( $tabs as $key => $tab ) : ?>
		
			<dd>
				<a href="#<?php echo $key ?>_tab"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
			</dd>
	
		<?php endforeach; ?>
	</dl>
	<?php $i = 0; ?>
	<ul class="tabs-content">
		<?php foreach ( $tabs as $key => $tab ) : ?>
			
			<li id="<?php echo $key ?>_tabTab"<?php if ($i == 0){?> class="active"<?php } ?>>
				<div class="content post-content"><?php call_user_func( $tab['callback'], $key, $tab ) ?></div>
			</li>
			<?php $i++; ?>
		<?php endforeach; ?>
	</ul>
</div>

