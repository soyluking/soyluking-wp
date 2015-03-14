<?php function thb_instagram( $atts, $content = null ) {
    extract(shortcode_atts(array(
	   	'username'			=> '',
	   	'number' 			=> '',
		'columns' 			=> '6'
    ), $atts));
    
	switch($columns) {
		case 2:
			$col = 'medium-6';
			break;
		case 3:
			$col = 'medium-4';
			break;
		case 4:
			$col = 'medium-6 large-3';
			break;
		case 5:
			$col = 'thb-five';
			break;
		case 6:
			$col = 'medium-4 large-2';
			break;
	  }
 	$output = $out ='';
	$username = strtolower($username);

	if (false === ($instagram = get_transient('instagram-media-'.sanitize_title_with_dashes($username)))) {

		$remote = wp_remote_get('http://instagram.com/'.trim($username));

		if (is_wp_error($remote))
			return new WP_Error('site_down', __('Unable to communicate with Instagram.', THB_THEME_NAME));

		if ( 200 != wp_remote_retrieve_response_code( $remote ) )
			return new WP_Error('invalid_response', __('Instagram did not return a 200.', THB_THEME_NAME));

		$shards = explode('window._sharedData = ', $remote['body']);
		$insta_json = explode(';</script>', $shards[1]);
		$insta_array = json_decode($insta_json[0], TRUE);

		if (!$insta_array)
			return new WP_Error('bad_json', __('Instagram has returned invalid data.', THB_THEME_NAME));

		$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];

		$instagram = array();

		foreach ($images as $image) {

			if ($image['user']['username'] == $username) {

				$image['link']                          = preg_replace( "/^http:/i", "", $image['link'] );
				$image['images']['thumbnail']           = preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
				$image['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );

				$instagram[] = array(
					'description'   => $image['caption']['text'],
					'link'          => $image['link'],
					//'time'          => $image['created_time'],
					//'comments'      => $image['comments']['count'],
					//'likes'         => $image['likes']['count'],
					//'thumbnail'     => $image['images']['thumbnail'],
					//'type'          => $image['type'],
					'large'         => $image['images']['standard_resolution']
					
				);
			}
		}

		$instagram = base64_encode( serialize( $instagram ) );
		set_transient('instagram-media-'.sanitize_title_with_dashes($username), $instagram, apply_filters('null_instagram_cache_time', HOUR_IN_SECONDS*2));
	}

	$instagram = unserialize( base64_decode( $instagram ) );
	
	$media_array = array_slice($instagram, 0, $number);
	ob_start();
	?>
	<div class="row no-padding"><?php
				foreach ($media_array as $item) {
					echo '<figure class="small-12 '.$col.' columns"><a href="'. esc_url( $item['link'] ) .'" target="_blank"><img src="'. esc_url($item['large']['url']) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"/></a></figure>';
				}
				?>
	</div>
	<?php
	$out = ob_get_contents();
	if (ob_get_contents()) ob_end_clean();
	
	wp_reset_query();
	wp_reset_postdata();
	   
	return $out;
}
add_shortcode('thb_instagram', 'thb_instagram');
