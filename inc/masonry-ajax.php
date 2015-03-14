<?php
add_action("wp_ajax_nopriv_thb_product_ajax", "load_products");
add_action("wp_ajax_thb_product_ajax", "load_products");
function load_more_posts() {
	$initial = $_POST['initial'];
	$count = $_POST['count'];
	$page = $_POST['page']; 
	$type = $_POST['type'];
	$style = isset($_POST['style']) ? $_POST['style'] : '';
	$categories =  isset($_POST['categories']) ? $_POST['categories'] : '';
	$offset = (($page - 1) * $count) + $initial;
	
	if ($type == 'post') {
		$args = array(
			'offset' 				 => $offset,
			'posts_per_page'	 => $count,
			'orderby'        => 'post_date',
			'order'          => 'DESC',
			'ignore_sticky_posts' => '1',
			'suppress_filters' => true
		);
	
		$query = new WP_Query( $args );
		
		if ( $query->have_posts() ) {
		    while ( $query->have_posts() ) { $query->the_post(); ?><article itemscope itemtype="http://schema.org/BlogPosting" <?php post_class('small-12 medium-6 large-3 item post columns style2'); ?> id="post-<?php the_ID(); ?>" role="article">
		    		<figure class="post-gallery">
		    			<?php
		    			    $image_id = get_post_thumbnail_id();
		    			    $image_link = wp_get_attachment_image_src($image_id,'full');
		    				$image = aq_resize( $image_link[0], 400, false, true, false, true);  // Blog
		    		
		    			?>
		    			<a href="<?php the_permalink(); ?>"><div class="simple-overlay"></div><img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php the_title(); ?>" /></a>
		    		</figure>
		    		<header class="post-title">
		    			<h2 itemprop="headline"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		    		</header>
		    		<aside class="post-meta cf">
		    			<ul>
		    				<li><?php _e("By", THB_THEME_NAME); ?> <?php the_author_posts_link(); ?></li>
		    				<li><time class="author" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo thb_human_time_diff_enhanced(); ?></time></li>
		    			</ul>
		    		</aside>
		    		
		    		<div class="post-content">
		    			<?php echo thb_excerpt(200, '...'); ?>
		    		</div>
		    		<a href="<?php the_permalink(); ?>" class="more-link"><?php _e( 'Read More', THB_THEME_NAME ); ?></a>
		    	</article><?php
		    }
		}
	}  else if ($type == 'portfolio') {
		$args = array(
			'offset' 				 => $offset,
			'posts_per_page'	 => $count,
			'post_type'=>'portfolio', 
			'post_status' => 'publish', 
			'ignore_sticky_posts' => 1,
			'tax_query' => array(
					array(
			    'taxonomy' => 'project-category',
			    'field' => 'id',
			    'terms' => explode(',',$categories),
			    'operator' => 'IN'
			   )
			 ) 
		);
		
		$query = new WP_Query( $args );
		
		if ( $query->have_posts() ) {
		    while ( $query->have_posts() ) { $query->the_post(); ?><?php 
			    $id = get_the_ID();
			    if ($style == 'style3') {
			    	$imagesize=array("600","450");
			    	$articlesize = 'small-12 medium-4';
			    } else {
				    $imagesize=array("450","430");
				    $articlesize = 'small-12 medium-3';
			    }
			    $font = 'medium';
			    $terms = get_the_terms( $id, 'project-category' );
			    $cats = '';
			    
			    $image_id = get_post_thumbnail_id();
			    $image_link = wp_get_attachment_image_src($image_id,'full');
			    $image = aq_resize( $image_link[0], $imagesize[0], $imagesize[1], true, false);
			    $image_title = esc_attr( get_the_title($id) );
			    $meta = get_the_term_list( $id, 'project-category', '<span>', '</span>, <span>', '</span>' ); 
			    $meta = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $meta);
			    
			    
			    
			    foreach ($terms as $term) { $cats .= ' '.strtolower($term->slug); }
			    
			    ?><article <?php post_class('post '.$articlesize.' columns item '.$cats); ?> id="post-<?php the_ID(); ?>">
			    	<figure class="post-gallery overlay-effect">
						<img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" title="<?php echo $image_title; ?>" />
						<div class="overlay">
							<div class="table">
								<div>
									<div class="child post-title">
										<h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a><hr></h4>
									</div>
									<div class="child categories">
										<aside class="post_categories"><?php echo $meta; ?></aside>
									</div>
								</div>
							</div>
						</div>
					</figure>
			    </article><?php
 		    }
 		}
	}
	die();
}
add_action("wp_ajax_nopriv_thb_ajax", "load_more_posts");
add_action("wp_ajax_thb_ajax", "load_more_posts");

function load_products() {
	$type = isset($_POST['type']) ? $_POST['type'] : "latest-products"; 
	if ($type == "latest-products") {
		
		$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'   => 1,
			'posts_per_page' => 6,
			'no_found_rows' => true,
			'suppress_filters' => 0
		);
	} else if ($type == "featured-products") {			
		$args = array(
	    	'post_type'	=> 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' => 6,
			'meta_query' => array(
				array(
					'key' => '_visibility',
					'value' => array('catalog', 'visible'),
					'compare' => 'IN'
				),
				array(
					'key' => '_featured',
					'value' => 'yes'
				)
			),
			'no_found_rows' => true,
			'suppress_filters' => 0
		);
	} else if ($type == "best-sellers") {
		$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'   => 1,
			'posts_per_page' => 6,
			'meta_key' 		 => 'total_sales',
			'orderby' 		 => 'meta_value',
			'meta_query' => array(
				array(
					'key' => '_visibility',
					'value' => array( 'catalog', 'visible' ),
					'compare' => 'IN'
				)
			),
			'no_found_rows' => true,
			'suppress_filters' => 0
		);
	} else {
		$category = get_term_by('id',$type,'product_cat'); 
		$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'   => 1,
			'product_cat' => $category->slug,
			'posts_per_page' => 6,
			'no_found_rows' => true,
			'suppress_filters' => 0
		);		
	}
	$products = new WP_Query( $args );
	

	$catalog_mode = ot_get_option('shop_catalog_mode', 'off');
	global $post;
	
	
	if ( $products->have_posts() ) { ?>
		<div class="carousel products no-padding owl row" data-columns="6" data-navigation="true">	
	    <?php while ( $products->have_posts() ) { $products->the_post(); ?>
	    	<?php $product = get_product( $products->post->ID ); ?>
	    	<article itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" <?php post_class("post small-6 medium-4 large-2 columns product"); ?>>
	    	
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
	    					
	    					<a class="quick quick-view" data-id="<?php echo $post->ID; ?>" href="#"><i class="icon-budicon-545"></i></a>
	    				</div>
	    				<div class="buttons">
	    					<?php echo thb_wishlist_button(); ?>
	    					<div class="post-title<?php if ($catalog_mode == 'on') { echo ' catalog-mode'; } ?>">
	    						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	    					</div>
	    					<?php if ($catalog_mode != 'on') { ?>
	    						<?php
	    							/**
	    							 * woocommerce_after_shop_loop_item_title hook
	    							 *
	    							 * @hooked woocommerce_template_loop_price - 10
	    							 */
	    							do_action( 'woocommerce_after_shop_loop_item_title' );
	    						?>
	    						<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	    					<?php } ?>
	    				</div>
	    			</figure>
	    	</article>
	    	
	    <?php } ?>
	    
		</div>
		<div class="ai-dotted ai-indicator"><span class="ai-inner1"></span><span class="ai-inner2"></span><span class="ai-inner3"></span></div>
	<?php
	}
	wp_reset_query();
	wp_reset_postdata();
	die();
}
 ?>