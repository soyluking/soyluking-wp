<?php
/**
 * Display single product reviews (comments)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */
global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews">
	<?php
	
		if ( have_comments() ) :
			echo '<div id="comments">';
			
				$commenter = wp_get_current_commenter();
				
				
				echo '<div class="commentlist_container">';
				echo '<div class="row"><div class="small-12 medium-8 small-centered columns">';
				
				
					
					
					echo '<ol class="commentlist">';
			
					wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) );
			
					echo '</ol>';
			
					if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
						<div class="navigation">
							<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Previous', THB_THEME_NAME ) ); ?></div>
							<div class="nav-next"><?php next_comments_link( __( 'Next <span class="meta-nav">&rarr;</span>', THB_THEME_NAME ) ); ?></div>
						</div>
					<?php endif;
				
				echo '</div></div>';
				echo '</div>';
			echo '</div>';
		endif;
		
		$comment_form = array(
			'title_reply' => false,
			'comment_notes_before' => '',
			'comment_notes_after' => '',
			'fields' => array(
				'author' => '<div class="row"><div class="small-12 medium-6 columns">' .
				            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" class="placeholder" size="30" aria-required="true" placeholder="' . __( 'Your Name', THB_THEME_NAME ) . '" /></div>',
				'email'  => '<div class="small-12 medium-6 columns">' .
				            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" class="placeholder" placeholder="' . __( 'Your E-Mail', THB_THEME_NAME ) . '" /></div></div>',
			),
			'label_submit' => __( 'Submit Review', THB_THEME_NAME ),
			'logged_in_as' => '',
			'comment_field' => ''
		);
		
		if ( get_option('woocommerce_enable_review_rating') == 'yes' ) {
	
			$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Rating', THB_THEME_NAME ) .'</label><select name="rating" id="rating">
				<option value="">'.__( 'Rate&hellip;', THB_THEME_NAME ).'</option>
				<option value="5">'.__( 'Perfect', THB_THEME_NAME ).'</option>
				<option value="4">'.__( 'Good', THB_THEME_NAME ).'</option>
				<option value="3">'.__( 'Average', THB_THEME_NAME ).'</option>
				<option value="2">'.__( 'Not that bad', THB_THEME_NAME ).'</option>
				<option value="1">'.__( 'Very Poor', THB_THEME_NAME ).'</option>
			</select></p>';
	
		}
	
		$comment_form['comment_field'] .= '<div class="row"><div class="small-12 columns"><textarea id="comment" name="comment" class="placeholder" cols="45" rows="22" aria-required="true" placeholder="' . __( 'Your Review', THB_THEME_NAME ) . '"></textarea></div></div>';
	?>
	<div class="row">
		<div class="small-12 medium-8 small-centered columns text-left">
			<?php
				if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : 
				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) ); 
				else : ?>
				<div class="text-center">
					<p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', THB_THEME_NAME ); ?></p>
				</div>
			<?php endif;
			?>
		</div>
	</div>
</div>