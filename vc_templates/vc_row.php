<?php
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = $parallax_class = $mouse = '';
extract(shortcode_atts(array(
	'el_class'				=> '',
    'bg_image'        => '',
    'bg_color'        => '',
    'bg_image_repeat' => '',
    'font_color'      => '',
    'padding'         => '',
    'margin_bottom'   => '',
    'column_padding'  => false,
    'max_width'		  => false,
    'full_height'	=> false,
    'vertical_center'	=> false,
    'enable_parallax'	=> '',
    'parallax_speed'	=> '',
    'bg_video_src_mp4' => '',
    'bg_video_src_ogv' => '',
    'bg_video_src_webm' => '',
    'bg_video_overlay_color' => '',
    'css' => '',
	'equal_height' => '',
    'row_id' => '',
    'mouse_scroll' => false
), $atts));


wp_enqueue_script( 'wpb_composer_front_js' );
wp_enqueue_style('js_composer_custom_css');
$el_class = $this->getExtraClass($el_class);

$nopadding = $column_padding ? 'no-padding ' : ''; 
$max_width = $max_width ? 'max_width ' : ''; 
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
$data = '';
$parallax = '';
$video = '';
$height = '';

// full height
if($full_height) {
	if ($vertical_center) {
		$height = " ";
	} else {
		$height = " full-height-content";
	}
}

// equal heights
if($equal_height == 'true') {
	
	$equal_height = ' data-equal=">.columns"';
	
} else {
	$equal_height = '';
}
// video bg
$bg_video = '';
$bg_video_args = array();

if ( $bg_video_src_mp4 ) {
	$bg_video_args['mp4'] = $bg_video_src_mp4;
}

if ( $bg_video_src_ogv ) {
	$bg_video_args['ogv'] = $bg_video_src_ogv;
}

if ( $bg_video_src_webm ) {
	$bg_video_args['webm'] = $bg_video_src_webm;
}


if ( !empty($bg_video_args) ) {
	$attr_strings = array(
		'loop="1"',
		'preload="1"'
	);

	if ( $bg_image && !in_array( $bg_image, array('none') ) ) {

		$attr_strings[] = 'poster="' . esc_url($bg_image) . '"';
	}
	
	
	$bg_video .= sprintf( '<video %s controls="controls" class="row-video-bg" autoplay>', join( ' ', $attr_strings ) );

	$source = '<source type="%s" src="%s" />';
	foreach ( $bg_video_args as $video_type=>$video_src ) {

		$video_type = wp_check_filetype( $video_src, wp_get_mime_types() );
		$bg_video .= sprintf( $source, $video_type['type'], esc_url( $video_src ) );

	}

	$bg_video .= '</video>';
	
	if ( $bg_video_overlay_color != '' ) {
		$bg_video .= '<div class="video_overlay" style="background-color: '.$bg_video_overlay_color .';"></div>';
	}
	
	$video = ' video_bg';
}

// Parallax
if ( $enable_parallax ) {
	if ( $parallax_speed == '' ) {
		$parallax_speed = 0.2;
	}
	$parallax_class = ' parallax_bg';
	$data = ' data-stellar-background-ratio="'.$parallax_speed.'"';
}
// Mouse Scroll
if($mouse_scroll == 'true') {
	$mouse .= 'mouse_scroll_row ';
}

$output .= '<div '.($row_id ? 'id="'.$row_id.'"' : '') .' class="row '.$mouse.$max_width.$nopadding.$parallax_class.$video.$height.$el_class.vc_shortcode_custom_css_class($css, ' ').'" '.$data.$equal_height.'>';
$output .= $bg_video;
	if($vertical_center && $full_height) {
	$output .= '<div class="table full-height-content"><div>';	
	}
$output .= wpb_js_remove_wpautop($content);
	if($vertical_center && $full_height) {
	$output .= '</div></div>';	
	}
if($mouse_scroll == 'true') {
	$output .= '<a class="mouse_scroll" href="#"></a>';
}
$output .= '</div>';
echo $output;