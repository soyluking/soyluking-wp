<?php function thb_teammember( $atts, $content = null ) {
    extract(shortcode_atts(array(
       	'image' 			=> '',
       	'name'			=> '',
       	'position'	=> '',
       	'text'		=> '',
       	'facebook'	=> '',
       	'twitter'	=> '',
       	'pinterest'	=> '',
       	'linkedin'	=> ''
    ), $atts));
	
	$out = '';
	
	$img_id = preg_replace('/[^\d]/', '', $image);
	$out .= '<aside class="team_member">';
	$out .= wp_get_attachment_image($img_id, 'full'); 
  	$out .= '<div class="overlay"><div class="relative">';
	$out .= ($name ? '<h5>'.$name.'</h5>' : '');
	$out .= ($position ? '<span>'.$position.'</span>' : '');

	if ($facebook || $pinterest || $twitter || $linkedin) {
		$out .= '<div class="social_links">';
			if ($facebook) {
				$out .= '<a href="'.$facebook.'" class="facebook"><i class="fa fa-facebook"></i></a>';
			}
			if ($twitter) {
				$out .= '<a href="'.$twitter.'" class="twitter"><i class="fa fa-twitter"></i></a>';
			}
			if ($pinterest) {
				$out .= '<a href="'.$pinterest.'" class="pinterest"><i class="fa fa-pinterest"></i></a>';
			}
			if ($linkedin) {
				$out .= '<a href="'.$linkedin.'" class="linkedin"><i class="fa fa-linkedin"></i></a>';
			}
		$out .= '</div>';
	}
	$out .= '</div>';
	$out .= '</div>';
	$out .= '</aside>';
  return $out;
}
add_shortcode('thb_teammember', 'thb_teammember');
