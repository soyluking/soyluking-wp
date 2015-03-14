<?php 

add_action('wp_ajax_thb_import_ajax', 'thb_import_data');

function thb_import_data() {

	// Load Importer API
	require_once ABSPATH . 'wp-admin/includes/import.php';
	$importerError = false;
  
  $file = get_template_directory() ."/inc/democontent/demo-content.xml";
	

	if ( !class_exists( 'WP_Importer' ) ) {
		$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		if ( file_exists( $class_wp_importer ) ) 
			require_once($class_wp_importer);
		else 
			$importerError = true;
	}
    
	
	if($importerError !== false) {
		echo ("The Auto importing script could not be loaded. Please use the wordpress importer and import the XML file that is located in your themes folder manually.");
	} else {
		
		if(class_exists('WP_Importer')){
			try{
				$importer = new WP_Import();
				$importer->fetch_attachments = true;
				$importer->import($file);
		         
			  thb_update_options();
			  thb_update_menus('Main Menu', 'nav-menu');
			  thb_import_theme_options();
			 // thb_update_widgets();
			  
		    die('Success!');
				
			} catch (Exception $e) {
				echo ("Error while importing");
			}
	
		}
		
	}
		
	die();
}
function thb_import_theme_options() {
	$file = get_template_directory_uri() ."/inc/democontent/theme-options.txt";
	$theme_options_txt = wp_remote_get( $file );

	$options = unserialize( ot_decode( $theme_options_txt['body'] ) );
	
	/* get settings array */
	$settings = get_option( ot_settings_id() );
	
  /* validate options */
  foreach( $settings['settings'] as $setting ) {
  
    if ( isset( $options[$setting['id']] ) ) {
      
      $content = ot_stripslashes( $options[$setting['id']] );
      
      $options[$setting['id']] = ot_validate_setting( $content, $setting['type'], $setting['id'] );
      
    }
  }
  
  /* update the option tree array */
  update_option( ot_options_id(), $options );
  
  $message = 'success';
	  
	
}
function thb_update_options() {
	global $options_presets;
	$home = get_page_by_title('Home');
	$blog = get_page_by_title('Blog');
	$myaccount = get_page_by_title('My Account');
	
	
	$shop = get_page_by_title('Shop');
	$cart = get_page_by_title('Cart');
	$checkout = get_page_by_title('Checkout');
	
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home->ID );
	update_option( 'page_for_posts', $blog->ID );
	
	update_option( 'woocommerce_myaccount_page_id', $myaccount->ID );
	update_option( 'woocommerce_shop_page_id', $shop->ID );
	update_option( 'woocommerce_cart_page_id', $cart->ID );
	update_option( 'woocommerce_checkout_page_id', $checkout->ID );
	update_option( 'yith_wcwl_button_position', 'shortcode');
	
	// We no longer need to install pages for WooCommerce
  delete_option( '_wc_needs_pages' );
  delete_transient( '_wc_activation_redirect' );

  // Flush rules after install
  flush_rewrite_rules();
}

function thb_update_menus($menuname = false, $menulocation = false){
	
	global $wpdb;
	
    $menuname = 'Main Menu';
	$menulocation = 'nav-menu';
	
	$tablename = $wpdb->prefix.'terms';
	$menu_ids = $wpdb->get_results(
	    "
	    SELECT term_id
	    FROM ".$tablename." 
	    WHERE name= '".$menuname."'
	    "
	);
	
	// results in array 
	foreach($menu_ids as $menu):
	    $menu_id = $menu->term_id;
	endforeach; 

  if( !has_nav_menu( $menulocation ) ){
      $locations = get_theme_mod('nav_menu_locations');
      $locations[$menulocation] = $menu_id;
      set_theme_mod( 'nav_menu_locations', $locations );
  }      
}

// Parsing Widgets Function
function thb_update_widgets() {
	$widgets_json = get_template_directory_uri() . "/inc/democontent/widget_data.json"; // widgets data file
	$widgets_json = wp_remote_get( $widgets_json );
	$widget_data = $widgets_json['body'];
	$import_widgets = thb_import_widget_data( $widget_data );
}

// Thanks to http://wordpress.org/plugins/widget-settings-importexport/
function thb_import_widget_data( $widget_data ) {
    $json_data = $widget_data;
    $json_data = json_decode( $json_data, true );

    $sidebar_data = $json_data[0];
    $widget_data = $json_data[1];

    foreach ( $widget_data as $widget_data_title => $widget_data_value ) {
        $widgets[ $widget_data_title ] = '';
        foreach( $widget_data_value as $widget_data_key => $widget_data_array ) {
            if( is_int( $widget_data_key ) ) {
                $widgets[$widget_data_title][$widget_data_key] = 'on';
            }
        }
    }
    unset($widgets[""]);

    foreach ( $sidebar_data as $title => $sidebar ) {
        $count = count( $sidebar );
        for ( $i = 0; $i < $count; $i++ ) {
            $widget = array( );
            $widget['type'] = trim( substr( $sidebar[$i], 0, strrpos( $sidebar[$i], '-' ) ) );
            $widget['type-index'] = trim( substr( $sidebar[$i], strrpos( $sidebar[$i], '-' ) + 1 ) );
            if ( !isset( $widgets[$widget['type']][$widget['type-index']] ) ) {
                unset( $sidebar_data[$title][$i] );
            }
        }
        $sidebar_data[$title] = array_values( $sidebar_data[$title] );
    }

    foreach ( $widgets as $widget_title => $widget_value ) {
        foreach ( $widget_value as $widget_key => $widget_value ) {
            $widgets[$widget_title][$widget_key] = $widget_data[$widget_title][$widget_key];
        }
    }

    $sidebar_data = array( array_filter( $sidebar_data ), $widgets );

    thb_parse_import_data( $sidebar_data );
}

function thb_parse_import_data( $import_array ) {
    global $wp_registered_sidebars;
    $sidebars_data = $import_array[0];
    $widget_data = $import_array[1];
    $current_sidebars = get_option( 'sidebars_widgets' );
    $new_widgets = array( );

    foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

        foreach ( $import_widgets as $import_widget ) :
            //if the sidebar exists
            if ( isset( $wp_registered_sidebars[$import_sidebar] ) ) :
                $title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
                $index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
                $current_widget_data = get_option( 'widget_' . $title );
                $new_widget_name = thb_get_new_widget_name( $title, $index );
                $new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

                if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
                    while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
                        $new_index++;
                    }
                }
                $current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
                if ( array_key_exists( $title, $new_widgets ) ) {
                    $new_widgets[$title][$new_index] = $widget_data[$title][$index];
                    $multiwidget = $new_widgets[$title]['_multiwidget'];
                    unset( $new_widgets[$title]['_multiwidget'] );
                    $new_widgets[$title]['_multiwidget'] = $multiwidget;
                } else {
                    $current_widget_data[$new_index] = $widget_data[$title][$index];
                    $current_multiwidget = $current_widget_data['_multiwidget'];
                    $new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
                    $multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
                    unset( $current_widget_data['_multiwidget'] );
                    $current_widget_data['_multiwidget'] = $multiwidget;
                    $new_widgets[$title] = $current_widget_data;
                }

            endif;
        endforeach;
    endforeach;

    if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
        update_option( 'sidebars_widgets', $current_sidebars );

        foreach ( $new_widgets as $title => $content )
            update_option( 'widget_' . $title, $content );

        return true;
    }

    return false;
}

function thb_get_new_widget_name( $widget_name, $widget_index ) {
    $current_sidebars = get_option( 'sidebars_widgets' );
    $all_widget_array = array( );
    foreach ( $current_sidebars as $sidebar => $widgets ) {
        if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
            foreach ( $widgets as $widget ) {
                $all_widget_array[] = $widget;
            }
        }
    }
    while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
        $widget_index++;
    }
    $new_widget_name = $widget_name . '-' . $widget_index;
    return $new_widget_name;
}