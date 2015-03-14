<?php
// Do Shortcodes inside widgets
add_filter('widget_text', 'do_shortcode');

// thb Tag Cloud Size
function tag_cloud_filter($args = array()) {
   $args['smallest'] = 11;
   $args['largest'] = 11;
   $args['unit'] = 'px';
   $args['format']= 'list';
   return $args;
}

add_filter('widget_tag_cloud_args', 'tag_cloud_filter', 90);
add_filter('widget_product_tag_cloud_args', 'tag_cloud_filter', 90);

require_once("widgets/dribbble.php");
require_once("widgets/flickr.php");
require_once("widgets/subscribe.php");
require_once("widgets/twitter.php");
require_once("widgets/latest-posts-images.php");
?>