<?php
/**
 * Additional Information tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
?>
<div class="row">
	<div class="small-12 medium-10 large-8 medium-centered columns">
		<?php $product->list_attributes(); ?>
	</div>
</div>