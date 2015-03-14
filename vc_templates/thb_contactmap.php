<?php function thb_contactmap( $atts, $content = null ) {
    $a = shortcode_atts(array(
    	'full_height' => false,
       	'height'      => ''
    ), $atts);
    $locations = ot_get_option('map_locations');
    ob_start(); ?>
	<div class="contact_map <?php if ($a['full_height']) {?>full-height-content<?php }?>" <?php if (!$a['full_height']) {?>style="height:<?php echo $a['height']; ?>px"<?php }?>>
		<div class="google_map" data-map-style="<?php echo ot_get_option('contact_map_style', 8); ?>" data-map-zoom="<?php echo ot_get_option('contact_zoom', 12); ?>" data-map-zoom="<?php echo ot_get_option('contact_zoom', 17); ?>" data-map-center-lat="<?php echo ot_get_option('map_center_lat', '59.93815'); ?>" data-map-center-long="<?php echo ot_get_option('map_center_long', '10.76537'); ?>" data-latlong='<?php echo json_encode($locations); ?>' data-pin-image="<?php echo ot_get_option('map_pin_image', THB_THEME_ROOT. '/assets/img/pin.png'); ?>"></div>
		<a href="#" class="expand"></a>
	</div>
  	
  	<?php 
  	$out = ob_get_contents();
  	if (ob_get_contents()) ob_end_clean();
  return $out;
}
add_shortcode('thb_contactmap', 'thb_contactmap');
