<?php function thb_post( $atts, $content = null ) {
    extract(shortcode_atts(array(
       	'carousel' => 'no',
       	'item_count' => '3',
       	'columns' => '3'
    ), $atts));
    
	$args = array(
		'showposts' => $item_count, 
		'nopaging' => 0, 
		'post_type'=>'post', 
		'post_status' => 'publish', 
		'ignore_sticky_posts' => 1,
		'no_found_rows' => true,
		'suppress_filters' => 0
	);
	
	$posts = new WP_Query( $args );
 	
 	ob_start();
 	
	if ( $posts->have_posts() ) { ?>
	  <?php switch($columns) {
	  	case 2:
	  		$col = 'large-6';
	  		$w = '570';
	  		break;
	  	case 3:
	  		$col = 'large-4';
	  		$w = '370';
	  		break;
	  	case 4:
	  		$col = 'large-3';
	  		$w = '270';
	  		break;
	  } ?>
		<?php if ($carousel == "yes") { ?>
			
				<div class="carousel posts owl row" data-columns="<?php echo $columns; ?>" data-navigation="true" data-bgcheck="false">				
					
					<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
						<article <?php post_class('post small-12 '.$col.' columns'); ?> id="post-<?php the_ID(); ?>">
							<?php
							  $masonry = 0;
							  include(locate_template( 'inc/postformats/image.php' ));
							?>
							  <div class="post-title">
							  	<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
							  </div>
							  <div class="post-content">
							  	<?php echo thb_ShortenText(get_the_content(), 200); ?>
							  </div>
								<?php get_template_part( 'inc/postformats/post-meta-masonry' ); ?>
						</article>
					<?php endwhile; // end of the loop. ?>	 
										
				</div>
			
		<?php } else {  ?> 
		<div class="masonry posts row" data-equal="article">
		
			<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
				<article <?php post_class('small-12 medium-6 '.$col.' columns post item grid-sizer'); ?> id="post-<?php the_ID(); ?>">
					<figure class="post-gallery">
						<?php
						    $image_id = get_post_thumbnail_id();
						    $image_link = wp_get_attachment_image_src($image_id,'full');
					
							$image = aq_resize( $image_link[0], 400, 150, true, false);  // Blog
					
						?>
						<a href="<?php the_permalink(); ?>"><img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" /></a>
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
				    	<?php echo thb_ShortenText(get_the_content(), 150); ?>
				    </div>
				    <a href="<?php the_permalink(); ?>" class="more-link"><?php _e( 'Read More', THB_THEME_NAME ); ?></a>
				</article>
			<?php endwhile; // end of the loop. ?>
		 
		</div>
		
		<?php } ?>
	   
	<?php }

   $out = ob_get_contents();
   if (ob_get_contents()) ob_end_clean();
   
   wp_reset_query();
   wp_reset_postdata();
     
  return $out;
}
add_shortcode('thb_post', 'thb_post');
