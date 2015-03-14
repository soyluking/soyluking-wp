<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (ot_get_option('related_products', 'on') !== "off") {
	global $post, $product, $woocommerce_loop;
	
	$related = $product->get_related();
	
	if ( sizeof( $related ) == 0 ) return;
	
	$args = apply_filters('woocommerce_related_products_args', array(
		'post_type'				=> 'product',
		'ignore_sticky_posts'	=> 1,
		'no_found_rows' 		=> 1,
		'posts_per_page' 		=> 4,
		'orderby' 				=> $orderby,
		'post__in' 				=> $related,
		'post__not_in'			=> array($product->id)
	) );
	
	$products = new WP_Query( $args );
	
	$woocommerce_loop['columns'] 	= $columns;
	
	if ( $products->have_posts() ) : ?>
	
		<div class="related products">
	
			<div class="smalltitle text-center"><?php _e( 'Related Products',THB_THEME_NAME ); ?></div>
	
			<?php woocommerce_product_loop_start(); ?>
	
				<?php while ( $products->have_posts() ) : $products->the_post(); ?>
	
					<?php wc_get_template_part( 'content', 'product-small' ); ?>
	
				<?php endwhile; // end of the loop. ?>
	
			<?php woocommerce_product_loop_end(); ?>
	
		</div>
	
	<?php endif;
	
	wp_reset_postdata();

}