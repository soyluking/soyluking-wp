<?php $blog_header = ot_get_option('blog_header'); ?>
<?php $rand = rand(0,1000); ?>
<?php if ($blog_header) { ?>
	<div class="header_content"><?php echo do_shortcode($blog_header); ?></div>	
<?php } ?>
<div class="blog-container">
	<section class="blog-section row masonry style2" data-loadmore="#loadmore-<?php echo $rand; ?>" data-count="<?php echo get_option('posts_per_page'); ?>" data-total="<?php echo $wp_query->max_num_pages; ?>" data-type="style2">
	  	<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
		<article itemscope itemtype="http://schema.org/BlogPosting" <?php post_class('small-12 medium-6 large-3 grid-sizer item post columns style2'); ?> id="post-<?php the_ID(); ?>" role="article">
			<?php if ( has_post_thumbnail() ) { ?>
			<figure class="post-gallery">
				<?php
				    $image_id = get_post_thumbnail_id();
				    $image_link = wp_get_attachment_image_src($image_id,'full');
				    $image_title = esc_attr( get_the_title($post->ID) );
				?>
				<?php
			
					$image = aq_resize( $image_link[0], 400, false, true, false, true);  // Blog
			
				?>
				
				<a href="<?php the_permalink(); ?>"><div class="simple-overlay"></div><img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php echo $image_title; ?>" /></a>
			</figure>
			<?php } ?>
			<header class="post-title">
				<h2 itemprop="headline"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
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
		</article>
	  <?php endwhile; else : ?>
	    <?php get_template_part( 'inc/loop/notfound' ); ?>
	  <?php endif; ?>
	</section>
	<a class="masonry_btn" href="#" id="loadmore-<?php echo $rand; ?>" data-type="post" data-loading="<?php _e( 'Loading Posts', THB_THEME_NAME ); ?>" data-nomore="<?php _e( 'No More Posts to Show', THB_THEME_NAME ); ?>" data-initial="<?php echo get_option('posts_per_page');?>" data-count="<?php echo get_option('posts_per_page');?>"><?php _e( 'Load More', THB_THEME_NAME ); ?></a>
</div>