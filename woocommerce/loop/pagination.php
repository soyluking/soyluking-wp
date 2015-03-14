<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) {
	return;
}
?>

<!-- PAGINATION -->
<div class="pagination">
<?php
	echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
		'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
		'format' 			=> '',
		'current' 		=> max( 1, get_query_var('paged') ),
		'total' 			=> $wp_query->max_num_pages,
		'prev_text' 	=> '<span>'.__( "<i class='fa fa-caret-left'></i> Previous", THB_THEME_NAME ).'</span>',
		'next_text' 	=> '<span>'.__( "Next <i class='fa fa-caret-right'></i>", THB_THEME_NAME ).'</span>',
		'type'				=> 'plain',
		'end_size'		=> 3,
		'mid_size'		=> 3
	) ) );
?>
</div>
<!-- end PAGINATION -->