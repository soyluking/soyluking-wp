<section class="blog-section">
  	<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
	<article itemscope itemtype="http://schema.org/BlogPosting" <?php post_class('post style1'); ?> id="post-<?php the_ID(); ?>" role="article">
		<?php if ( has_post_thumbnail() ) { ?>
		<figure class="post-gallery">
		
			<?php
			    $image_id = get_post_thumbnail_id();
			    $image_link = wp_get_attachment_image_src($image_id,'full');
			    $image_title = esc_attr( get_the_title($post->ID) );
		
				$image = aq_resize( $image_link[0], 1200, 400, true, false, true);  // Blog
		
			?>
			<a href="<?php the_permalink(); ?>"><img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php echo $image_title; ?>" /></a>
		</figure>
		<?php } ?>
		<div class="row">
			<div class="small-12 medium-10 large-6 medium-centered columns">
				<header class="post-title">
					<h2 itemprop="headline"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				</header>
				<?php get_template_part( 'inc/postformats/post-meta' ); ?>
				<div class="post-content">
					<?php echo thb_excerpt(500, '...'); ?>
				</div>
				<a href="<?php the_permalink(); ?>" class="more-link"><?php _e( 'Read More', THB_THEME_NAME ); ?></a>
			</div>
		</div>
	</article>
  <?php endwhile; else : ?>
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