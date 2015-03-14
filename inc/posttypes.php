<?php
/*-----------------------------------------------------------------------------------*/
/*	Create a new post type called portfolios
/*-----------------------------------------------------------------------------------*/

function create_post_type_portfolios() 
{
	$labels = array(
		'name' => __( 'Portfolio',THB_THEME_NAME),
		'singular_name' => __( 'Portfolio',THB_THEME_NAME ),
		'rewrite' => array('slug' => __( 'portfolios',THB_THEME_NAME )),
		'add_new' => _x('Add New', 'portfolio', THB_THEME_NAME),
		'add_new_item' => __('Add New Portfolio',THB_THEME_NAME),
		'edit_item' => __('Edit Portfolio',THB_THEME_NAME),
		'new_item' => __('New Portfolio',THB_THEME_NAME),
		'view_item' => __('View Portfolio',THB_THEME_NAME),
		'search_items' => __('Search Portfolio',THB_THEME_NAME),
		'not_found' =>  __('No portfolios found',THB_THEME_NAME),
		'not_found_in_trash' => __('No portfolios found in Trash',THB_THEME_NAME), 
		'parent_item_colon' => ''
	  );
	  
	  $args = array(
		'labels' => $labels,
		'public' => true,
		'exclude_from_search' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail')
	  ); 
	  
	  register_post_type('portfolio',$args);
	  flush_rewrite_rules();
}

$category_labels = array(
	'name' => __( 'Project Categories', THB_THEME_NAME),
	'singular_name' => __( 'Project Category', THB_THEME_NAME),
	'search_items' =>  __( 'Search Project Categories', THB_THEME_NAME),
	'all_items' => __( 'All Project Categories', THB_THEME_NAME),
	'parent_item' => __( 'Parent Project Category', THB_THEME_NAME),
	'edit_item' => __( 'Edit Project Category', THB_THEME_NAME),
	'update_item' => __( 'Update Project Category', THB_THEME_NAME),
	'add_new_item' => __( 'Add New Project Category', THB_THEME_NAME),
  'menu_name' => __( 'Project Categories', THB_THEME_NAME)
); 	

register_taxonomy("project-category", 
		array("portfolio"), 
		array("hierarchical" => true, 
				'labels' => $category_labels,
				'show_ui' => true,
    			'query_var' => true,
				'rewrite' => array( 'slug' => 'project-category' )
));

/* Initialize post types */
add_action( 'init', 'create_post_type_portfolios' );
?>