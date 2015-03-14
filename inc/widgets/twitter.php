<?php
// thb Flickr Widget
class widget_thbtwitter extends WP_Widget { 
	function widget_thbtwitter() {
		/* Widget settings. */
		$widget_ops = array('description' => __('Display your Tweets', THB_THEME_NAME) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'thbtwitter' );

		/* Create the widget. */
		$this->WP_Widget( 'thbtwitter', __('Fuel Themes - Twitter Widget',THB_THEME_NAME), $widget_ops, $control_ops );
	}
	
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title'] );
		$notweets = $instance['notweets'];
		
		// Output
		echo $before_widget;
		echo $before_title . $title . $after_title;
	
		$username = ot_get_option('twitter_bar_username');
		?>
		<ul>
			<?php echo get_theme_tweets($username, ot_get_option('twitter_bar_consumerkey'), ot_get_option('twitter_bar_consumersecret'), ot_get_option('twitter_bar_accesstoken'), ot_get_option('twitter_bar_accesstokensecret'), $notweets); ?>
		</ul>
		<a href="http://twitter.com/<?php echo ot_get_option('twitter_bar_username'); ?>" class="btn small twitter" target="_blank"><i class="icon-budicon-841"></i> <?php _e('Follow <strong>@'.esc_attr($username).'</strong>', THB_THEME_NAME); ?> <i class="fa fa-twitter"></i></a>
		<?php
		echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance; 
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['notweets'] = $new_instance['notweets'];

		return $instance;
	}
	// Settings form
	function form($instance) {
		$defaults = array(
			'title' => 'Latest Tweets',
			'notweets' => '3'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
        
			<p>Please make sure you fill out the settings inside Theme Options -> Twitter Oauth</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'notweets' ); ?>"><?php _e('Number of Tweets', 'theme'); ?></label>
				<input id="<?php echo $this->get_field_id( 'notweets' ); ?>" name="<?php echo $this->get_field_name( 'notweets' ); ?>" value="<?php echo $instance['notweets']; ?>" class="widefat" />
			</p>
    <?php
	}
}
function widget_thbtwitter_init()
{
	register_widget('widget_thbtwitter');
}
add_action('widgets_init', 'widget_thbtwitter_init');

?>