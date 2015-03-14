<?php function thb_notification( $atts, $content = null ) {
    extract(shortcode_atts(array(
    		'type'			 => 'information'
    ), $atts));
	$btn = '';

	// Content
	$out = '<aside class="notification-box '.$type.' animation fade-in"><div class="icon"></div><div class="content">'.$content.'</div><a href="#" class="close">×</a></aside>';
  return $out;
}
add_shortcode('thb_notification', 'thb_notification');
