<?php function thb_grid( $atts, $content = null ) {
    extract(shortcode_atts(array(
       	'type' => 'categories',
       	'style' => 'style1',
       	'cat' => '',
		'product_ids' => '',
		'animation' => 'animation fade-in'
    ), $atts));
	
	global $woocommerce, $woocommerce_loop, $product, $post;
			
	$args = $product_categories = $category_ids = array();
	$cats = explode(",", $cat);
	
	
	foreach ($cats as $cat) {
		$c = get_term_by('slug',$cat,'product_cat');
		
		if($c) {
			array_push($category_ids, $c->term_id);
		}
	}
	
	$args = array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => '0',
		'include'	=> $category_ids
	);
	
	$product_categories = get_terms( 'product_cat', $args );
 	ob_start();
 	$i = 1;
	?>
	<?php if ($type == "categories") { ?>
				<?php
					if ( $product_categories ) { ?>
							<div class="grid">
						<?php foreach ( $product_categories as $category ) {
							if ($style == "style1") {
								switch($i) {
									case 1:
									case 6:
									case 11:
									case 16:
										$imagesize=array("1440","800");
										$articlesize = 'small-12 medium-8';
										break;
									case 2:
									case 7:
									case 12:
									case 17:
										$imagesize=array("720","406");
										$articlesize = 'small-12 medium-4 grid-sizer';
										break;
									case 4:
									case 5:
									case 9:
									case 10:
									case 14:
									case 15:
										$imagesize=array("720","400");
										$articlesize = 'small-12 medium-4';
										break;
									case 3:
									case 8:
									case 13:
									case 18:
										$imagesize=array("720","800");
										$articlesize = 'small-12 medium-4';
										break;
								} 
							} else if($style == "style2") {
								
								switch($i) {
									case 1:
									case 13:
										$imagesize=array("720","798");
										$articlesize = 'small-12 medium-6';
										break;
									case 2:
									case 4:
									case 5:
									case 6:
									case 9:
									case 8:
									case 10:
									case 11:
									case 14:
									case 15:
										$imagesize=array("360","400");
										$articlesize = 'small-12 medium-3 grid-sizer';
										break;
									case 3:
									case 7:
									case 12:
										$imagesize=array("360","806");
										$articlesize = 'small-12 medium-3';
										break;
								}	
							}
							?>
							<article class="product-category item <?php echo $articlesize; ?> columns <?php echo $animation; ?>">
								<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">

									<?php
										$small_thumbnail_size    = apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' );
										$thumbnail_id        = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );

										if ( $thumbnail_id ) {
										  $image = wp_get_attachment_image_src( $thumbnail_id, 'full' );
										  $image_src = $image[0];
										  $image = aq_resize( $image_src, $imagesize[0], $imagesize[1], true, true, true);
										} else {
										  $image = wc_placeholder_img_src();
										}
										if ( $image_src ) {
											
											echo '<img src="' . $image. '" alt="' . esc_attr( $category->name ) . '" width="' . $imagesize[0] . '" height="' .$imagesize[1] . '" />';
										}
									?>

									<div class="title">
										<h2><?php
											echo $category->name;

											if ( $category->count > 0 )
												echo apply_filters( 'woocommerce_subcategory_count_html', ' <span class="count">(' . $category->count . ')</span>', $category );
										?></h2>
									</div>
								</a>
							</article>
							<?php 
							$i++;
						} ?>
						</div>
					<?php }
					woocommerce_reset_loop();  
				?>

	<?php } else {  ?> 
		<?php 
			$product_id_array = explode(',', $product_ids);
			$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
				'post__in'		=> $product_id_array,
				'posts_per_page' => "-1",
			);
			$products = new WP_Query( $args );
			if ( $products->have_posts() ) { ?>
			<div class="grid products"> <?php
			while ( $products->have_posts() ) : $products->the_post();
				if ($style == "style1") {
					switch($i) {
						case 1:
						case 6:
						case 11:
						case 16:
							$imagesize=array("1440","800");
							$articlesize = 'small-12 medium-8';
							break;
						case 2:
						case 7:
						case 12:
						case 17:
							$imagesize=array("720","406");
							$articlesize = 'small-12 medium-4 grid-sizer';
							break;
						case 4:
						case 5:
						case 9:
						case 10:
						case 14:
						case 15:
							$imagesize=array("720","400");
							$articlesize = 'small-12 medium-4';
							break;
						case 3:
						case 8:
						case 13:
						case 18:
							$imagesize=array("720","800");
							$articlesize = 'small-12 medium-4';
							break;
					} 
				} else if($style == "style2") {

					switch($i) {
						case 1:
						case 13:
							$imagesize=array("720","798");
							$articlesize = 'small-12 medium-6';
							break;
						case 2:
						case 4:
						case 5:
						case 6:
						case 9:
						case 8:
						case 10:
						case 11:
						case 14:
						case 15:
							$imagesize=array("360","400");
							$articlesize = 'small-12 medium-3 grid-sizer';
							break;
						case 3:
						case 7:
						case 12:
							$imagesize=array("360","806");
							$articlesize = 'small-12 medium-3';
							break;
					}	
				} 
				global $product, $post;
				$catalog_mode = ot_get_option('shop_catalog_mode', 'off');
				?>
				<article itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class($articlesize . ' columns post product item '. $animation.''); ?>>
					<?php if ( has_post_thumbnail() ) {
					
							$thumbnail_id = get_post_thumbnail_id();
							$image = wp_get_attachment_image_src( $thumbnail_id, 'full' );
							$image_src = $image[0];
							$image = aq_resize( $image_src, $imagesize[0], $imagesize[1], true, true, true);
						}
					?>
					<figure class="overlay-effect">
						<img src="<?php echo $image; ?>" width="<?php echo $imagesize[0]; ?>" height="<?php echo $imagesize[1]; ?>" />
						<div class="overlay">
							<div class="table">
								<div>
									<div class="child post-title<?php if ($catalog_mode == 'on') { echo ' catalog-mode'; } ?>">
										<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><hr></h4>
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
				</article>
			<?php
			$i++; 
			endwhile;
			?></div><?php
			}
		} ?>
	   
	<?php 
	     
   $out = ob_get_contents();
   if (ob_get_contents()) ob_end_clean();
   wp_reset_query();
   wp_reset_postdata();
	   
  return $out;
}
add_shortcode('thb_grid', 'thb_grid');
