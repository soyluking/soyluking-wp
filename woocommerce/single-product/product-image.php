<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;
$attachment_ids = $product->get_gallery_attachment_ids();
?>
<?php if( $product->has_child() && $product->is_type( 'variable' )) { 
		$available_variations = $product->get_available_variations();
	}
?>
<div id="product-images" class="carousel owl product-images" data-navigation="true" data-pagination="true" data-autoplay="false" rel="gallery" data-columns="1">
            
		<?php if ( $attachment_ids ) {						
				
				foreach ( $attachment_ids as $attachment_id ) {
					$var_img = false;
					$image_link = wp_get_attachment_url( $attachment_id );
					$image_src_link = wp_get_attachment_image_src($attachment_id,'full');
					$src = wp_get_attachment_image_src( $attachment_id, false, '' );
					$src_small = wp_get_attachment_image_src( $attachment_id,  apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ));
					
					
					$image_title = esc_attr( get_the_title( $attachment_id ) );
					$attr = '';
					if (isset($available_variations)) {
						foreach($available_variations as $prod_variation) {
						  if ($image_src_link[0] == $prod_variation['image_link']) {
						  	$attr = implode(',', $prod_variation['attributes']);
						  }
						}
					}
					?>
						<figure itemprop="image" class="easyzoom" data-variation="<?php echo $attr; ?>">
							<?php if (get_option('woocommerce_enable_lightbox') == "yes") {  ?>
								<a href="<?php echo $src[0]; ?>" itemprop="image" class="fresco" data-fresco-options="fit: 'width', overflow: 'y'" data-fresco-group="product_images">
							<?php } ?>
								<img src="<?php echo $src_small[0]; ?>" title="<?php echo $image_title; ?>" />
							<?php if (get_option('woocommerce_enable_lightbox') == "yes") {  ?>
								</a>
							<?php } ?>
						</figure>
					
					<?php
				}
			}
		?>
</div>