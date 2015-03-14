<?php get_header(); ?>
<?php 
 	if (is_page()) {
 		$id = $wp_query->get_queried_object_id();
 		$sidebar = get_post_meta($id, 'sidebar_set', true);
 		$sidebar_pos = get_post_meta($id, 'sidebar_position', true);
 	}
?>
<?php if($post->post_content != "") { ?>
	<div class="page-container" data-equal=".sidebar, .sidebar-page">
		<?php if($sidebar) { get_sidebar('page'); } ?>
		<section class="<?php if($sidebar) { echo 'sidebar-page';} ?> <?php if ($sidebar && ($sidebar_pos == 'left'))  { echo 'push'; } else if ($sidebar && ($sidebar_pos == 'right')) { echo 'pull'; } ?>">
			<?php if($sidebar) { ?> <?php } ?>
		  <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
			  <article <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
				<div class="post-content">
					<?php the_content('Read More'); ?>
				</div>
			  </article>
		  <?php endwhile; else : endif; ?>
		</section>
	</div>
<?php } ?>
<?php get_footer(); ?>