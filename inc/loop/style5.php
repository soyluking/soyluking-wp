<section class="blog-section style5">
	<?php $i = 0;?>
  	<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
  		<?php $color = (($i % 2 != 0) ? ' alternate' : ''); ?>
		<article itemscope itemtype="http://schema.org/BlogPosting" <?php post_class('post row no-padding style5' . $color); ?> id="post-<?php the_ID(); ?>" role="article" data-equal=">.columns">
			<div class="small-12 medium-4 columns">
				<?php
				    $image_id = get_post_thumbnail_id();
				    $image_link = wp_get_attachment_image_src($image_id,'full');
				    $image_title = esc_attr( get_the_title($post->ID) );
					$image = aq_resize( $image_link[0], 650, 660, true, false, true);
				?>
				<?php if ( has_post_thumbnail() ) { ?>
				<figure class="post-gallery" style="background-image: url('<?php echo $image[0]; ?>');">
					<div class="simple-overlay"></div>
				</figure>
				<?php } ?>
			</div>
			<div class="small-12 medium-8 columns">
				<div class="inner-padding">
					<header class="post-title">
						<h2 itemprop="headline"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					</header>
					<?php get_template_part( 'inc/postformats/post-meta' ); ?>
					
					<div class="post-content">
						<?php echo thb_excerpt(400, '...'); ?>
					</div>
					<a href="<?php the_permalink(); ?>" class="more-link"><?php _e( 'Read More', THB_THEME_NAME ); ?></a>
				</div>
			</div>
		</article>
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