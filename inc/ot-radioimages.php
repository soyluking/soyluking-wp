<?php

function filter_radio_images( $array, $field_id ) {
  
  /* only run the filter where the field ID is my_radio_images */
  if ( $field_id == 'sidebar_position' ) {
    $array = array(
      array(
        'value'   => 'left-sidebar',
        'label'   => __( 'Left Sidebar', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/left-sidebar.png'
      ),
      array(
        'value'   => 'right-sidebar',
        'label'   => __( 'Right Sidebar', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/right-sidebar.png'
      )
    );
  }
  if ( $field_id == 'slider_position' ) {
    $array = array(
      array(
        'value'   => 'slider-left',
        'label'   => __( 'Left Aligned Slider', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/slider-left.png'
      ),
      array(
        'value'   => 'slider-right',
        'label'   => __( 'Right Aligned Slider', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/slider-right.png'
      )
    );
  }
  if ( $field_id == 'footer_columns' ) {
    $array = array(
      array(
        'value'   => 'fourcolumns',
        'label'   => __( 'Four Columns', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/four-columns.png'
      ),
      array(
        'value'   => 'threecolumns',
        'label'   => __( 'Three Columns', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/three-columns.png'
      ),
      array(
        'value'   => 'twocolumns',
        'label'   => __( 'Two Columns', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/two-columns.png'
      ),
      array(
        'value'   => 'doubleleft',
        'label'   => __( 'Double Left Columns', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/doubleleft-columns.png'
      ),
      array(
        'value'   => 'doubleright',
        'label'   => __( 'Double Right Columns', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/doubleright-columns.png'
      ),
      array(
        'value'   => 'fivecolumns',
        'label'   => __( 'Five Columns', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/five-columns.png'
      )
      
    );
  }
  
  if ( $field_id == 'portfolio_columns' ) {
    $array = array(
      array(
        'value'   => 'three',
        'label'   => __( 'Four Columns', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/four-columns.png'
      ),
      array(
        'value'   => 'four',
        'label'   => __( 'Three Columns', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/three-columns.png'
      ),
      array(
        'value'   => 'six',
        'label'   => __( 'Two Columns', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/two-columns.png'
      )
      
    );
  }
  return $array;
  
}
add_filter( 'ot_radio_images', 'filter_radio_images', 10, 2 );

function filter_options_name() {
	return __('Fuel Themes - Theme Options Page', THB_THEME_NAME);
}
add_filter( 'ot_header_version_text', 'filter_options_name', 10, 2 );


function filter_upload_name() {
	return __('Send to Theme Options', THB_THEME_NAME);
}
add_filter( 'ot_upload_text', 'filter_upload_name', 10, 2 );

function filter_typography_fields( $array, $field_id ) {

   if ( $field_id == "title_type" ) {
      $array = array( 'font-family');
   }

   return $array;

}

add_filter( 'ot_recognized_typography_fields', 'filter_typography_fields', 10, 2 );

function filter_typography_fields2( $array, $field_id ) {
	
   $fields = array('menu_left_type', 'menu_right_type');
   if ( in_array($field_id, $fields )) {
      $array = array('font-family', 'font-size', 'font-style', 'font-variant', 'font-weight', 'text-decoration', 'text-transform', 'line-height', 'letter-spacing');
   }

   return $array;

}

add_filter( 'ot_recognized_typography_fields', 'filter_typography_fields2', 10, 2 );