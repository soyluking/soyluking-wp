<?php get_header(); ?>
<?php 
	$blog_type = (isset($_GET['blog_type']) ? htmlspecialchars($_GET['blog_type']) : ot_get_option('blog_style', 'style1')); 
?>
<?php get_template_part( 'inc/loop/'.$blog_type ); ?>
<?php get_footer(); ?>