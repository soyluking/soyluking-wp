<?php function thb_iconlist( $atts, $content = null ) {
    extract(shortcode_atts(array(
       	'color'      => '',
       	'icon'			 => 'fa fa-anchor',
       	'animation'	 => false
    ), $atts));
	
	if($icon) { $sicon = ' <i class="'.$icon.'" '. ($color ? ' style="color:'.$color.'"' : '') .'></i>'; } else { $sicon = ''; }
	
	$list_items = explode(",", $content);
	$out = '<ul class="iconlist '.$animation.'">';
	foreach($list_items as $list_item) {
		$out .= '<li>'.$sicon. $list_item.'</li>';
	}
	
	$out .= '</ul>';
	
	return $out;
}
add_shortcode('thb_iconlist', 'thb_iconlist');
