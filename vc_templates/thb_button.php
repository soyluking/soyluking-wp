<?php function thb_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
       	'color'      => '',
       	'target_blank' => false,
       	'link'       => '#',
       	'rounded'      => '',
       	'size'			 => 'small',
       	'style'       => false,
       	'icon'			 => false,
       	'animation'	 => false
    ), $atts));
	
	if($icon) { $content = '<span class="icon"><i class="'.$icon.'"></i></span> '.$content; }
	
	$out = '<a class="btn '.$color.' '.$size.' '.$animation.' '.$style.' '.$rounded.'" href="'.$link.'" ' . ($target_blank ? ' target="_blank"' : '') .' role="button">' .$content. '</a>';
  
  return $out;
}
add_shortcode('thb_button', 'thb_button');
