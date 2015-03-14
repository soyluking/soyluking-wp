<?php function thb_product( $atts, $content = null ) {
    extract(shortcode_atts(array(
       	'product_sort' => 'best-sellers',
       	'carousel' => 'no',
       	'item_count' => '4',
       	'columns' => '4',
       	'cat' => '',
       	'product_ids' => ''
    ), $atts));
	global $post, $product, $woocommerce, $woocommerce_loop;
			
	$args = array();
	
	if ($product_sort == "latest-products") {
		$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
				'posts_per_page' => $item_count
			);	    
	} else if ($product_sort == "featured-products") {			
		$args = array(
			    'post_type' => 'product',
			    'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
			    'meta_key' => '_featured',
			    'meta_value' => 'yes',
			    'posts_per_page' => $item_count
			);
	} else if ($product_sort == "top-rated") {
		add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
				
		$args = array(
		    'post_type' => 'product',
		    'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
		    'posts_per_page' => $item_count
		);
		$args['meta_query'] = $woocommerce->query->get_meta_query();
	
	} else if ($product_sort == "sale-products") {
		$args = array(
			    'post_type' => 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
				'posts_per_page' => $item_count,
				'meta_query'     => array(
	        'relation' => 'OR',
	        array( // Simple products type
	            'key'           => '_sale_price',
	            'value'         => 0,
	            'compare'       => '>',
	            'type'          => 'numeric'
	        ),
	        array( // Variable products type
	            'key'           => '_min_variation_sale_price',
	            'value'         => 0,
	            'compare'       => '>',
	            'type'          => 'numeric'
	        )
	    	)
			);
	} else if ($product_sort == "by-category"){
		$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
				'product_cat' => $cat,
				'posts_per_page' => $item_count
			);	    
	} else if ($product_sort == "by-id"){
		$product_id_array = explode(',', $product_ids);
		$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
				'post__in'		=> $product_id_array
			);	    
	} else {
		$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
				'posts_per_page' => $item_count,
				'meta_key' 		=> 'total_sales',
				'orderby' 		=> 'meta_value'
			);	    
	}
	$products = new WP_Query( $args );
  $woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', $columns ); 
 	
 	ob_start();
 	
 	switch($columns) {
 		case 2:
 			$col = 'medium-6';
 			break;
 		case 3:
 			$col = 'medium-4';
 			break;
 		case 4:
 			$col = 'medium-3';
 			break;
		case 6:
 			$col = 'medium-2';
 			break;
 	}
 	$catalog_mode = ot_get_option('shop_catalog_mode', 'off');
 	
	if ( $products->have_posts() ) { ?>
	   
		<?php if ($carousel == "yes") { ?>
			
			<div class="carousel-container">
				<div class="carousel products owl row" data-columns="<?php echo $columns; ?>" data-navigation="false" data-pagination="true">				
					
					<?php while ( $products->have_posts() ) : $products->the_post(); ?>
							<?php $product = get_product( $products->post->ID ); ?>
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
					
						<?php endwhile; // end of the loop. ?>
										
				</div>
			</div>
			
		<?php } else {  ?> 
			
		<div class="products row" data-equal="article">
		
			<?php while ( $products->have_posts() ) : $products->the_post(); ?>
				<?php $product = get_product( $products->post->ID ); ?>
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
		
			<?php endwhile; // end of the loop. ?>
		 
		</div>
		
		<?php } ?>
	   
	<?php }
	     
   $out = ob_get_contents();
   if (ob_get_contents()) ob_end_clean();
   
   wp_reset_query();
   wp_reset_postdata();
   remove_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
	   
  return $out;
}
add_shortcode('thb_product', 'thb_product');
