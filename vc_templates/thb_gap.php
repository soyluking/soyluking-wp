<?php function thb_gap( $atts, $content = null ) {
    extract(shortcode_atts(array(
       	'height' 	=> ''
    ), $atts));
	
	$out = '';
  $out .= '<aside class="gap cf" style="height:'.$height.'px;"></aside>';
  return $out;
}
add_shortcode('thb_gap', 'thb_gap');
