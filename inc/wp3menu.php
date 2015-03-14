<?php
add_theme_support('nav-menus');
add_action('init','register_my_menus');

function register_my_menus() {
	register_nav_menus(
		array(
			'nav-menu' => __( 'Navigation Menu',THB_THEME_NAME )
		)
	);
}

/* CUSTOM NAV WALKER */
class thb_navDropdown extends Walker_Nav_Menu
{
	
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $display_depth = ($depth + 1);
        if($display_depth == '1'){$class_names = 'dropdown';}
        else {$class_names = 'dropdown-column';}
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=".$class_names."><ul>\n";
    }

    function end_lvl( &$output, $depth = 1, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }

    function start_el ( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

	    global $wp_query;
	    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	
	    $class_names = $value = '';
	
	    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
	    $classes[] = 'menu-item-' . $item->ID;
	
	    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
	    $class_names = ' class="' . esc_attr( $class_names ) . '"';
	
	    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
	    $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
	
	    $output .= $indent . '<li' . $id . $value . $class_names .'>';
	
	    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
	    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
	    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
	    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
	
			$heading = '';
	    if ( $depth == 0 ) {
	        if(strpos($class_names,'heading') !== false && $item->description !== ''){$heading = '<h6>'.$item->description.'</h6>';}
	    }
	
	    $description = '';
	    if(strpos($class_names,'image') !== false){$description = '<img src="'.$item->description.'" alt=" "/>';}
	

		    $item_output = $args->before;
		    $item_output .= '<a'. $attributes .'>';
		    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		    $item_output .= $heading.$description;
		    $item_output .= '</a>';
		    $item_output .= $args->after;
	
	    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  	} 

}
class thb_mobileDropdown extends Walker_Nav_Menu {

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class=" ' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		$children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$arrow = '<svg version="1.1" class="menu_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			 width="7.998px" height="4.707px" viewBox="0 0 7.998 4.707" enable-background="new 0 0 7.998 4.707" xml:space="preserve"><rect x="1.854" y="-0.475" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -0.9747 2.3534)" fill-rule="evenodd" clip-rule="evenodd" width="1" height="5.657"/><rect x="2.817" y="1.854" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -0.0107 4.6811)" fill-rule="evenodd" clip-rule="evenodd" width="5.657" height="1"/></svg>';
		/** This filter is documented in wp-includes/post-template.php */
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		if ($depth == 0) {
			$item_output .= (!empty($children) ? '<span>'.$arrow.'</span>' : '').'</a>';
		} else {
			$item_output .= '</a>';
		}
		$item_output .= $args->after;


		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}