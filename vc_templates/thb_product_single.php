<?php function thb_product_single( $atts, $content = null ) {
    extract(shortcode_atts(array(
       	'product_id' => ''
    ), $atts));
	global $post, $product, $woocommerce, $woocommerce_loop;
			
	$args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'ignore_sticky_posts'   => 1,
		'p'		=> $product_id
	);
	$products = new WP_Query( $args );
 	
 	ob_start();
 	
 	$catalog_mode = ot_get_option('shop_catalog_mode', 'off');
 	
	if ( $products->have_posts() ) { while ( $products->have_posts() ) : $products->the_post(); ?>
		<?php $product = get_product( $products->post->ID ); ?>
		<div class="products">
		<article itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" <?php post_class("post small-12 $col columns"); ?>>
		
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		
			<figure class="overlay-effect">
			
				<?php
					$image_html = "";
					
					do_action( 'thb_product_badge');
		
					if ( has_post_thumbnail() ) {
						$image_html = wp_get_attachment_image( get_post_thumbnail_id(), 'shop_catalog' );					
					}
				?>
				<?php echo $image_html; ?>			
				<div class="overlay">
					<div class="table">
							<div>
								<div class="child post-title<?php if ($catalog_mode == 'on') { echo ' catalog-mode'; } ?>">
									<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								</div>
								<?php if ($catalog_mode != 'on') { ?>
									<div class="child buttons">
									<?php
										/**
										 * woocommerce_after_shop_loop_item_title hook
										 *
										 * @hooked woocommerce_template_loop_price - 10
										 */
										do_action( 'woocommerce_after_shop_loop_item_title' );
									?>
									<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
									</div>
								<?php } ?>
							</div>
						</div>
				</div>
			</figure>
		</article><!-- end product -->
		</div>
	<?php endwhile;  }
	     
   $out = ob_get_contents();
   if (ob_get_contents()) ob_end_clean();
   
   wp_reset_query();
   wp_reset_postdata();
   remove_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
	   
  return $out;
}
add_shortcode('thb_product_single', 'thb_product_single');
