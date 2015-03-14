<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
?>
<li itemprop="reviews" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment-inner">
    	<div class="comment-container">
    	<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>
    		<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( __( 'Rated %d out of 5',THB_THEME_NAME ), $rating ) ?>">
    			<span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo $rating; ?></strong> <?php _e( 'out of 5',THB_THEME_NAME ); ?></span>
    		</div>
    	<?php endif; ?>
	    <div class="commentmeta">
	        <strong><?php comment_author_link(); ?></strong>
	        <span class="authorname">
	            <?php comment_date('M d, Y'); ?> - <?php comment_time('h:i A'); ?> <?php edit_comment_link( "Edit", ''); ?>
	        </span>
	    </div>
	    <div itemprop="description" class="comment-text">
	        <?php if ($comment->comment_approved == '0') : ?>
	            <em class="awaiting_moderation"><?php _e('Your comment is awaiting moderation.', THB_THEME_NAME) ?></em>
	        <?php endif; ?>
	        <?php comment_text(); ?>
	    </div>
    </div> 
	</div>