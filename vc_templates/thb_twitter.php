<?php function thb_twitter( $atts, $content = null ) {
    extract(shortcode_atts(array(
       	'username' => 'anteksiler',
       	'count' => '3',
       	'style' => 'dark'
    ), $atts));
 	ob_start();
 	
 	?>
 	<aside class="twitter_container <?php echo $style; ?>">
 		<i class="fa fa-twitter"></i>
		<div class="carousel owl <?php echo $style; ?>" data-columns="1" data-navigation="false" data-pagination="true">
	
				<?php echo get_theme_tweets($username, ot_get_option('twitter_bar_consumerkey'), ot_get_option('twitter_bar_consumersecret'), ot_get_option('twitter_bar_accesstoken'), ot_get_option('twitter_bar_accesstokensecret'), $count); ?>
		</div>
		<a href="http://twitter.com/<?php echo $username; ?>">@<?php echo $username; ?></a>
	</aside>
	<?php
   $out = ob_get_contents();
   if (ob_get_contents()) ob_end_clean();
  return $out;
}
add_shortcode('thb_twitter', 'thb_twitter');
