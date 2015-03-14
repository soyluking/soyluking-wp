<?php function thb_clients( $atts, $content = null ) {
    extract(shortcode_atts(array(
    		'carousel'		=> 'no',
       	'images'     	=> '',
       	'columns'			=> '4'
    ), $atts));
	$all_images = explode(',', $images);
	$output = '';
	
	switch($columns) {
		case 2:
			$col = 'medium-6';
			break;
		case 3:
			$col = 'medium-4';
			break;
		case 4:
			$col = 'medium-3';
			break;
		case 5:
			$col = 'thb-five';
			break;
		case 6:
			$col = 'medium-2';
			break;
	}
	
	if ($carousel == "yes") {
		$output .= '<div class="carousel-container"><div class="carousel clients owl row" data-columns="'.$columns.'" data-navigation="true">';
	} else {
		$output .= '<div class="clients row no-padding">';	
	}

	foreach($all_images as $img_id) {
		$img = wp_get_attachment_image($img_id, 'full');
	    $output .= '<div class="client small-6 '.$col.' columns">';
	    $output .= $img;
	    $output .= '</div>';
	}

	if ($carousel == "yes") {
		$output .= '</div></div>';
	} else {
		$output .= '</div>';	
	}
	return $output;

}
add_shortcode('thb_clients', 'thb_clients');
