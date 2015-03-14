<?php function thb_iconbox( $atts, $content = null ) {
    extract(shortcode_atts(array(
    	'type'			 => '',
       	'image'      => '',
       	'color'      => '',
       	'icon'			 => 'fa fa-anchor',
       	'icon_color' => false,
       	'icon_bgcolor' => false,
       	'content_color' => false,
       	'heading'		 => '',
       	'heading_color' => false,
       	'animation'	 => false
    ), $atts));
	$btn = '';
	
	// Image & Icon
	if ($image) {
		$img_id = preg_replace('/[^\d]/', '', $image);
		$img = wp_get_attachment_image($img_id, 'full', false, array(
			'alt'   => trim(strip_tags( get_post_meta($img_id, '_wp_attachment_image_alt', true) )),
		));
	} else {
		$icon = '<i class="'.$icon.'"></i>';
	}

	// Content
	
	$out = '<div class="iconbox '.$type.' '.$animation.'">';

	$out .= '<span' . ($image ? ' class="img"' : '') .' style="' . ($icon_color ? 'color:'.$icon_color : '') .';' . ($icon_bgcolor ? 'background-color:'.$icon_bgcolor : '') .'">' . ($image ? $img : $icon) .'</span>';

	$out .= '<div class="content">';
	$out .= '<h6' . ($heading_color ? ' style="color: '.$heading_color.'"' : '').'>'.$heading.'</h6>';
	if (!strpos($type, 'type3')) {
	$out .= '<div' . ($content_color ? ' style="color: '.$content_color.'"' : '').'>'.$content.'</div>';
	}
	$out .= '</div>';
	
	$out .= '</div>';
  return $out;
}
add_shortcode('thb_iconbox', 'thb_iconbox');
