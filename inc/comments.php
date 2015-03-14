<?php

/* Custom GRAvatar */
function thb_gravatar ($avatar_defaults) {
	$myavatar = THB_THEME_ROOT . '/assets/img/avatar.png';
	$avatar_defaults[$myavatar] = 'THB Gravatar';
	return $avatar_defaults;
}
add_filter('avatar_defaults', 'thb_gravatar');

/* Custom Comment Styling */
function enable_threaded_comments(){
	if (!is_admin()) {
		if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
			wp_enqueue_script('comment-reply');
		}
	}
}
add_action('get_header', 'enable_threaded_comments');

function mytheme_comment($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment-inner">
  	<figure class="vcard">
    	<?php echo get_avatar($comment,130); ?>
    </figure>
    <div class="comment-container">
	    <div class="commentmeta">
	        <strong>
	        	<?php comment_author_link(); ?>
	        </strong>
	        <span class="authorname">
	            <?php comment_date('M d, Y'); ?> - <?php comment_time('h:i A'); ?> <?php edit_comment_link( "Edit", ''); ?>
	        </span>
	        
	    </div>
	    <div class="comment-text">
	        <?php if ($comment->comment_approved == '0') : ?>
	            <em class="awaiting_moderation"><?php _e('Your comment is awaiting moderation.', THB_THEME_NAME) ?></em>
	        <?php endif; ?>
	        <?php comment_text() ?>
			<?php comment_reply_link(array_merge( $args, array('reply_text' => __('Reply', THB_THEME_NAME), 'depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => '<h6>', 'after' => '</h6>'))) ?>
	    </div>
    </div> 
	</div>
<?php } 
function list_pings($comment, $args, $depth) {
$GLOBALS['comment'] = $comment;
?>
<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php } 


/**
 * Modifies WordPress's built-in comments_popup_link() function to return a string instead of echo comment results
 */
function get_comments_popup_link( $zero = false, $one = false, $more = false, $css_class = '', $none = false ) {
    global $wpcommentspopupfile, $wpcommentsjavascript;
 
    $id = get_the_ID();
 
    if ( false === $zero ) $zero = __( 'No Comments', THB_THEME_NAME );
    if ( false === $one ) $one = __( '1 Comment', THB_THEME_NAME );
    if ( false === $more ) $more = __( '% Comments', THB_THEME_NAME );
    if ( false === $none ) $none = __( 'Comments Off', THB_THEME_NAME );
 
    $number = get_comments_number( $id );
 
    $str = '';
 
    if ( 0 == $number && !comments_open() && !pings_open() ) {
        $str = '<span' . ((!empty($css_class)) ? ' class="' . esc_attr( $css_class ) . '"' : '') . '>' . $none . '</span>';
        return $str;
    }
 
    if ( post_password_required() ) {
        $str = __('Enter your password to view comments.', THB_THEME_NAME);
        return $str;
    }
 
    $str = '<a href="';
    if ( $wpcommentsjavascript ) {
        if ( empty( $wpcommentspopupfile ) )
            $home = home_url();
        else
            $home = get_option('siteurl');
        $str .= $home . '/' . $wpcommentspopupfile . '?comments_popup=' . $id;
        $str .= '" onclick="wpopen(this.href); return false"';
    } else { // if comments_popup_script() is not in the template, display simple comment link
        if ( 0 == $number )
            $str .= get_permalink() . '#respond';
        else
            $str .= get_comments_link();
        $str .= '"';
    }
 
    if ( !empty( $css_class ) ) {
        $str .= ' class="'.$css_class.'" ';
    }
    $title = the_title_attribute( array('echo' => 0 ) );
 
    $str .= apply_filters( 'comments_popup_link_attributes', '' );
 
    $str .= ' title="' . esc_attr( sprintf( __('Comment on %s', THB_THEME_NAME), $title ) ) . '">';
    $str .= get_comments_number_str( $zero, $one, $more );
    $str .= '</a>';
     
    return $str;
}
 
/**
 * Modifies WordPress's built-in comments_number() function to return string instead of echo
 */
function get_comments_number_str( $zero = false, $one = false, $more = false, $deprecated = '' ) {
    if ( !empty( $deprecated ) )
        _deprecated_argument( __FUNCTION__, '1.3' );
 
    $number = get_comments_number();
 
    if ( $number > 1 )
        $output = str_replace('%', number_format_i18n($number), ( false === $more ) ? __('% Comments', THB_THEME_NAME) : $more);
    elseif ( $number == 0 )
        $output = ( false === $zero ) ? __('No Comments', THB_THEME_NAME) : $zero;
    else // must be one
        $output = ( false === $one ) ? __('1 Comment', THB_THEME_NAME) : $one;
 
    return apply_filters('comments_number', $output, $number);
}
?>