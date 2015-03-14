<?php
function thb_title($args = false, $id = false) {
	global $wp_query;
	if(!$id) { $id = $wp_query->get_queried_object_id(); }

	$defaults 	 = array(
		'title' 		=> get_the_title($id),
		'html'			=> "{title}"
	);


	// Parse incoming $args into an array and merge it with $defaults
	$args = wp_parse_args( $args, $defaults );

	// OPTIONAL: Declare each item in $args as its own variable i.e. $type, $before.
	extract( $args, EXTR_SKIP );
	$html = str_replace('{title}', $title, $html);

	return $html;
} 
function thb_breadcrumb() {
	global $post, $wp_query;
	$id = $wp_query->get_queried_object_id(); 
	
	echo '<aside class="breadcrumb">';
	if ( !is_front_page() ) {
	echo '<a href="';
	echo home_url();
	echo '">'.__('Home', THB_THEME_NAME);
	echo "</a>";
	}

	if(is_singular('portfolio')) {
			$portfolio_main = get_post_meta($post->ID, 'portfolio_main', TRUE);
			if ($portfolio_main) {
				$portfolio_link = get_permalink($portfolio_main);
			} else {
				$portfolio_link = get_portfolio_page_link(get_the_ID()); 
			}
	    echo '<span>/</span> <a href="' . $portfolio_link . '">' . __( 'Portfolio', THB_THEME_NAME ) . '</a>'; 
	    echo '<span>/</span>'.get_the_title(); 
	}
	
	if(is_home()) { echo '<span>/</span>'.__('Blog', THB_THEME_NAME); }
	if(is_page() && !is_front_page()) {
	    $parents = array();
	    $parent_id = $post->post_parent;
	    while ( $parent_id ) :
	        $page = get_page( $parent_id );
	            $parents[]  = '<span>/</span><a href="' . get_permalink( $page->ID ) . '" title="' . get_the_title( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
	        $parent_id  = $page->post_parent;
	    endwhile;
	    $parents = array_reverse( $parents );
	    echo join( ' ', $parents );
	    echo '<span>/</span>'.get_the_title();
	}
	
	if(is_single() && !is_singular('portfolio')) {
	    $categories = get_the_category();
	    if ( $categories ) :
	        foreach ( $categories as $cat ) :
	            $cats[] = '<a href="' . get_category_link( $cat->term_id ) . '" title="' . $cat->name . '">' . $cat->name . '</a>';
	        endforeach;
	        echo '<span>/</span>'.join( ', ', $cats );
	    endif;
	    echo '<span>/</span>'.thb_ShortenText(get_the_title(), 40);
	}
	
	if(is_archive()) { 
		if( class_exists( 'woocommerce' ) && is_woocommerce() && is_shop()) {
			echo '<span>/</span>'.get_the_title(wc_get_page_id('shop'));
		} else {
			echo '<span>/</span>'.thb_which_archive(); 
		}
	}
	
	if(is_search()) { 
			echo '<span>/</span>'.thb_which_archive(); 
	}
	echo '</aside>';
} 
function thb_which_archive() {
	$output = "";
	
	if ( is_category() )
	{
		$output = __('Archive for category:', THB_THEME_NAME)." ".single_cat_title('',false);
	}
	elseif (is_day())
	{
		$output = __('Archive for date:', THB_THEME_NAME)." ".get_the_time('F jS, Y');
	}
	elseif (is_month())
	{
		$output = __('Archive for month:', THB_THEME_NAME)." ".get_the_time('F, Y');
	}
	elseif (is_year())
	{
		$output = __('Archive for year:', THB_THEME_NAME)." ".get_the_time('Y');
	}
	elseif (is_search())
	{
		global $wp_query;
		if(!empty($wp_query->found_posts))
		{
			if($wp_query->found_posts > 1)
			{
				$output =  __('Search results for:', THB_THEME_NAME)." ".esc_attr( get_search_query() );
			}
			else
			{
				$output =  __('Search result for:', THB_THEME_NAME)." ".esc_attr( get_search_query() );
			}
		}
		else
		{
			if(!empty($_GET['s']))
			{
				$output = __('Search results for:', THB_THEME_NAME)." ".esc_attr( get_search_query() );
			}
			else
			{
				$output = __('To search the site please enter a valid term', THB_THEME_NAME);
			}
		}

	}
	elseif (is_author())
	{
		$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
		$output = __('Author Archive', THB_THEME_NAME)." ";

		if(isset($curauth->nickname)) $output .= __('for:', THB_THEME_NAME)." ".$curauth->nickname;

	}
	elseif (is_tag())
	{
		$output = __('Tag Archive for:', THB_THEME_NAME)." ".single_tag_title('',false);
	}
	elseif(is_tax())
	{
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$output = __('Archive for:', THB_THEME_NAME)." ".$term->name;
	}
	else
	{
		$output = __('Archives', THB_THEME_NAME)." ";
	}

	if (isset($_GET['paged']) && !empty($_GET['paged']))
	{
		$output .= " (".__('Page', THB_THEME_NAME)." ".$_GET['paged'].")";
	}

	return $output;
}
?>