<?php $blog_header = ot_get_option('blog_header'); ?>
<?php if ($blog_header && !is_search()) { ?>
	<div class="header_content"><?php echo do_shortcode($blog_header); ?></div>	
<?php } ?>
<section class="blog-section blog-container style3 <?php if (!have_posts() && is_search()) { ?>no-results<?php } ?>">
	<?php $i = 0; $counter = range(0, 200, 4); ?>
  	<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
  		<?php if ($i % 4 == 0) { echo '<div class="row" data-equal=".post">'; } ?>
		<article itemscope itemtype="http://schema.org/BlogPosting" <?php post_class('small-12 medium-6 large-3 item post columns style2'); ?> id="post-<?php the_ID(); ?>" role="article">
			<?php if ( has_post_thumbnail() ) { ?>
			<figure class="post-gallery">
				<?php
				    $image_id = get_post_thumbnail_id();
				    $image_link = wp_get_attachment_image_src($image_id,'full');
				    $image_title = esc_attr( get_the_title($post->ID) );
				?>
				<?php
			
					$image = aq_resize( $image_link[0], 400, 340, true, false, true);  // Blog
			
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
		<?php if (in_array($i + 1, $counter)){ echo '</div>'; }   ?>
	<?php $i++; endwhile; else : ?>
		<?php get_template_part( 'inc/loop/notfound' ); ?>
	<?php endif; ?>
</section>
<?php if ( get_next_posts_link() || get_previous_posts_link()) { ?>
<div class="blog_nav row no-padding">
	<?php if ( get_next_posts_link() ) : ?>
		<a href="<?php echo next_posts(); ?>" class="next"><?php _e( 'Older', THB_THEME_NAME ); ?></a>
	<?php endif; ?>

	<?php if ( get_previous_posts_link() ) : ?>
		<a href="<?php echo previous_posts(); ?>" class="prev"><?php _e( 'Newer', THB_THEME_NAME ); ?></a>
	<?php endif; ?>
</div>
<?php } ?>