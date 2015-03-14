<!-- Start Related Posts -->
<?php global $post; 
      $postId = $post->ID;
      $type = get_post_meta($postId, 'portfolio_type', true);
      
      if (is_singular('post')) {
      	$query = get_blog_posts_related_by_category($postId); 
      } elseif (is_singular('portfolio')) {
      	$query = get_posts_related_by_taxonomy($postId, 'project-category');
      }
?>
<?php if ($query->have_posts()) : ?>
<div class="row">
	<aside class="related small-12 large-10 large-centered columns text-center">
		<h6><?php _e( 'Related Works', THB_THEME_NAME ); ?></h6>
		<div class="row relatedposts hide-on-print no-padding">
		  <?php while ($query->have_posts()) : $query->the_post(); ?>             
		    <div class="small-12 medium-4 columns">
		      <article <?php post_class('post cf'); ?> id="post-<?php the_ID(); ?>">
		      	<?php
		      		$id = get_the_ID();
		      		$image_id = get_post_thumbnail_id();
		      		$image_link = wp_get_attachment_image_src($image_id,'full');
		      		$image = aq_resize( $image_link[0], 450, 380, true, false, true);
		      		$image_title = esc_attr( get_the_title($id) );
		      		$portfolio_type = get_post_meta($id, 'portfolio_type', true);
		      		$meta = get_the_term_list( $id, 'project-category', '<span>', '</span>, <span>', '</span>' ); 
		      		$meta = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $meta);
		      		?>
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
		      </article>
		    </div>
		    <?php endwhile; ?>
		</div>
	</aside>
</div>
<?php endif; ?>
<?php wp_reset_query(); ?>
<!-- End Related Posts -->