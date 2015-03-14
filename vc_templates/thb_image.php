<?php function thb_image( $atts, $content = null ) {
    extract(shortcode_atts(array(
       	'image'      => '',
       	'target_blank' => false,
       	'img_size'	 => 'full',
       	'img_link'       => '',
       	'img_link_target'       => '',
       	'alignment'	 => '',
       	'lightbox'	 => '',
       	'full_width' => false,
       	'size'			 => 'full',
       	'animation'	 => false
    ), $atts));
	
	$img_id = preg_replace('/[^\d]/', '', $image);
	
	$full = $full_width == 'true' ? 'full' : '';
	$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => $animation . ' ' . $alignment . ' '. $full ) );

	if ( $img == NULL ) $img['thumbnail'] = '<img src="http://placekitten.com/g/400/300" />';
  $link_to = $c_lightbox = '';
  if ($lightbox==true) {
      $link_to = wp_get_attachment_image_src( $img_id, 'large');
      $link_to = $link_to[0];
      $c_lightbox = ' class="fresco overlay-effect"';
  } else if (!empty($img_link)) {
      $link_to = $img_link;
  }
  if(!empty($link_to) && !preg_match('/^(https?\:\/\/|\/\/)/', $link_to)) $link_to = 'http://'.$link_to;
  $out = !empty($link_to) ? '<a '.$c_lightbox.' href="'.$link_to.'"'. ($target_blank == 'true' ? ' target="_blank"' : '') .'><div class="simple-overlay"></div>'.$img['thumbnail'].'</a>' : $img['thumbnail'];

  return $out;
}
add_shortcode('thb_image', 'thb_image');
