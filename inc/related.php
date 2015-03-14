<?php
// Related Blog Posts
function get_blog_posts_related_by_taxonomy($post_id, $args=array()) {
  $tags = wp_get_post_tags($post_id);
  $query = new WP_Query();
  if (count($tags)) {
	  $tagIDs = array();
	  $tagcount = count($tags);
	  for ($i = 0; $i < $tagcount; $i++) {
	    $tagIDs[$i] = $tags[$i]->term_id;
	  }
	  $args = wp_parse_args($args,array(
	    'tag__in' => $tagIDs,
	    'post__not_in' => array($post_id),
	    'ignore_sticky_posts'=> 1,
	  	'showposts' => 3,
	  	'no_found_rows' => true
	  ));
	  $query = new WP_Query($args);
	  
	}
  return $query;
}
// Related Posts for portfolio
function get_posts_related_by_taxonomy($post_id,$taxonomy,$args=array()) {
 	$terms = wp_get_object_terms($post_id,$taxonomy);
  $query = new WP_Query();
  if (count($terms)) {
    // Assumes only one term for per post in this taxonomy
    $post_ids = get_objects_in_term($terms[0]->term_id,$taxonomy);
    $post = get_post($post_id);
    $post_id_array = array($post_id);
    $post_ids_excl = array_diff( $post_ids, $post_id_array ); 
    $args = wp_parse_args($args,array(
      'post_type' => $post->post_type, // The assumes the post types match
      'post__in' => $post_ids_excl,
      'taxonomy' => $taxonomy,
      'term' => $terms[0]->slug,
	  	'showposts' => 3,
	  	'no_found_rows' => true
    ));
    $query = new WP_Query($args);
  }
  return $query;
}
// Related Posts by Category
function get_blog_posts_related_by_category($post_id, $args=array()) {
	$post_categories = wp_get_post_categories( $post_id );
  $args = wp_parse_args($args,array(
    'category__in' => $post_categories,
    'post__not_in' => array($post_id),
    'ignore_sticky_posts'=> 1,
    'orderby' => 'rand',
  	'showposts' => 3,
  	'no_found_rows' => true
  ));
  $query = new WP_Query($args);
	  
  return $query;
}
?>