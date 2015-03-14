<?php
// thb latest Posts w/ Images
class widget_latestimages extends WP_Widget {
       function widget_latestimages() {
               /* Widget settings. */
               $widget_ops = array( 'description' => __('Display latest posts with images',THB_THEME_NAME) );

               /* Widget control settings. */
               $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'latestimages' );

               /* Create the widget. */
               $this->WP_Widget( 'latestimages', __('Fuel Themes - Latest Posts with Images',THB_THEME_NAME), $widget_ops, $control_ops );
       }

       function widget($args, $instance) {
               extract($args);
               $title = apply_filters('widget_title', $instance['title']);
               $show = $instance['show'];
               global $post, $wpdb;
               $themePath = THB_THEME_ROOT;
               $pop = new WP_Query();
               $pop->query('showposts='.$show.'');

               echo $before_widget;
               echo $before_title;
               echo $title;
               echo $after_title;
               echo '<ul>';
               while  ($pop->have_posts()) : $pop->the_post(); ?>
	           <li>
	           	   <figure>
	               <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
	               <?php if ( has_post_thumbnail() ) {
	               		the_post_thumbnail();
	               } else { ?>
	               		<img src="<?php echo THB_THEME_ROOT; ?>/assets/img/nothumb.jpg" alt="No Post Image for <?php the_title(); ?>" width="40" height="40" />
	               <?php } ?>
	               </a>
	               </figure>
	               <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>" class="postlink"><?php the_title(); ?></a>
	           </li>
	           <?php endwhile;
               echo '</ul>';
               echo $after_widget;
               
               wp_reset_query();
       }
       function update( $new_instance, $old_instance ) {
               $instance = $old_instance;

               /* Strip tags (if needed) and update the widget settings. */
               $instance['title'] = strip_tags( $new_instance['title'] );
               $instance['show'] = strip_tags( $new_instance['show'] );

               return $instance;
       }
       function form($instance) {
               $defaults = array( 'title' => 'Latest Posts', 'show' => '3' );
               $instance = wp_parse_args( (array) $instance, $defaults ); ?>

               <p>
                       <label for="<?php echo $this->get_field_id( 'title' ); ?>">Widget Title:</label>
                       <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
               </p>

               <p>
                       <label for="<?php echo $this->get_field_id( 'name' ); ?>">Number of Posts:</label>
                       <input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'show' ); ?>" value="<?php echo $instance['show']; ?>" style="width:100%;" />
               </p>
   <?php
       }
}
function widget_latestimages_init()
{
       register_widget('widget_latestimages');
}
add_action('widgets_init', 'widget_latestimages_init');

?>