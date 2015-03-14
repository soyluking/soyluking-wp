<?php
/**
 * Initialize the meta boxes. 
 */
add_action( 'admin_init', '_custom_meta_boxes' );

/**
 * Meta Boxes demo code.
 *
 * You can find all the available option types
 * in demo-theme-options.php.
 *
 * @return    void
 *
 * @access    private
 * @since     2.0
 */


function _custom_meta_boxes() {

  /**
   * Create a custom meta boxes array that we pass to 
   * the OptionTree Meta Box API Class.
   */
  
  $post_meta_box_sidebar_gallery = array(
    'id'        => 'meta_box_sidebar_gallery',
    'title'     => 'Gallery',
    'pages'     => array('post'),
    'context'   => 'side',
    'priority'  => 'low',
    'fields'    => array(
      array(
        'id' => 'pp_gallery_slider',
        'type' => 'gallery',
        'desc' => '',
        'post_type' => 'post'
      )
     )
   );
  $portfolio_metabox = array(
    'id'          => 'portfolio_metaboxes',
    'title'       => 'Portfolio Settings',
    'pages'       => array( 'portfolio' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
    	array(
    	  'label'       => 'Page Background',
    	  'id'          => 'page_bg',
    	  'type'        => 'background',
    	  'desc'        => 'Background settings for this page'
    	),
    	array(
    	  'label'       => 'Display Related Portfolio',
    	  'id'          => 'portfolio_related',
    	  'type'        => 'on_off',
    	  'desc'        => 'Would you like to display related portfolio at the bottom?',
    	  'std'         => 'on'
    	),
    	array(
    	  'label'       => 'Display Share Button',
    	  'id'          => 'portfolio_share',
    	  'type'        => 'on_off',
    	  'desc'        => 'Would you like to display the share button at the bottom?',
    	  'std'         => 'on'
    	),
    	array(
    	  'label'       => 'Display Portfolio Navigation',
    	  'id'          => 'portfolio_nav',
    	  'type'        => 'on_off',
    	  'desc'        => 'Would you like to display portfolio navigation at the bottom?',
    	  'std'         => 'on'
    	),
    	array(
    	  'label'       => 'Main Page Select',
    	  'id'          => 'portfolio_main',
    	  'type'        => 'page-select',
    	  'desc'        => 'Select where "Back to All Projects" link to',
    	  'condition'   => 'portfolio_nav:is(on)'
    	)
    )
  );
  $page_metabox = array(
    'id'          => 'post_metaboxes_combined',
    'title'       => 'Page Settings',
    'pages'       => array( 'page' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
    	array(
    	  'id'          => 'tab1',
    	  'label'       => 'Background',
    	  'type'        => 'tab'
    	),
    	array(
    	  'label'       => 'Page Background',
    	  'id'          => 'page_bg',
    	  'type'        => 'background',
    	  'desc'        => 'Background settings for this page'
    	),
		array(
		  'id'          => 'tab2',
		  'label'       => 'Sidebar',
		  'type'        => 'tab'
		),
		array(
		  'id'          => 'sidebar_set',
		  'label'       => 'Sidebar',
		  'type'        => 'sidebar_select',
		  'desc'        => 'Select a sidebar to display inside the page. <small>Blog pages automatically display the Blog sidebar</small>'
		),
		array(
		  'label'       => 'Sidebar Position',
		  'id'          => 'sidebar_position',
		  'type'        => 'radio',
		  'desc'        => 'Select where the sidebar should be positioned',
		  'choices'     => array(
		  	array(
		  	  'label'       => 'Left',
		  	  'value'       => 'left'
		  	),
		    array(
		      'label'       => 'Right',
		      'value'       => 'right'
		    )
		    
		  ),
		  'std'         => 'no',
		  'condition'   => 'sidebar_set:not()'
		),
    	array(
    	  'id'          => 'tab0',
    	  'label'       => 'Header Override',
    	  'type'        => 'tab'
    	),
    	array(
    	  'label'       => 'Override Global Variables?',
    	  'id'          => 'header_override',
    	  'type'        => 'on_off',
    	  'desc'        => 'You can override global bar styles here',
    	  'std'         => 'off'
    	),
    	array(
    	  'label'       => 'Header shopping cart',
    	  'id'          => 'header_cart',
    	  'type'        => 'on_off',
    	  'desc'        => 'Would you like to display the shopping cart icon inside the header?',
    	  'std'         => 'on',
    	  'condition'   => 'header_override:is(on)'
    	),
    	array(
    	  'label'       => 'Header search',
    	  'id'          => 'header_search',
    	  'type'        => 'on_off',
    	  'desc'        => 'Would you like to display the search icon inside the header?',
    	  'std'         => 'on',
    	  'condition'   => 'header_override:is(on)'
    	),
      array(
        'id'          => 'tab5',
        'label'       => 'Navigation',
        'type'        => 'tab'
      ),
      array(
        'label'       => 'Select Page Primary Menu',
        'id'          => 'page_menu',
        'type'        => 'menu_select',
        'desc'        => 'If you select a menu here, it will override the main navigation menu.'
      )
    )
  );
  
  /**
   * Register our meta boxes using the 
   * ot_register_meta_box() function.
   */
	ot_register_meta_box( $page_metabox );
  	ot_register_meta_box( $portfolio_metabox );
}