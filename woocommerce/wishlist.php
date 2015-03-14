<?php
/**
 * Wishlist page template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 1.0.0
 */
 
global $wpdb, $yith_wcwl, $woocommerce;

$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
$myaccount_page_url = "";
if ( $myaccount_page_id ) {
  $myaccount_page_url = get_permalink( $myaccount_page_id );
}

if( isset( $_GET['user_id'] ) && !empty( $_GET['user_id'] ) ) {
    $user_id = $_GET['user_id'];
} elseif( is_user_logged_in() ) {
    $user_id = get_current_user_id();
}

$current_page = 1;
$limit_sql = '';

if( is_user_logged_in() )
    { $wishlist = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `" . YITH_WCWL_TABLE . "` WHERE `user_id` = %s" . $limit_sql, $user_id ), ARRAY_A ); }
elseif( yith_usecookies() )
    { $wishlist = yith_getcookie( 'yith_wcwl_products' ); }
else
    { $wishlist = isset( $_SESSION['yith_wcwl_products'] ) ? $_SESSION['yith_wcwl_products'] : array(); }
?>

<?php wc_print_notices() ?>
<div class="largetitle"><?php echo apply_filters( 'woocommerce_my_account_my_orders_title', __( 'My Wishlist',THB_THEME_NAME ) ); ?></div>
<form id="yith-wcwl-form" action="<?php echo esc_url( $yith_wcwl->get_wishlist_url() ) ?>" method="post">
    <?php  do_action( 'yith_wcwl_before_wishlist' ); ?>
    <table class="shopping_bag wishlist">
    	<thead>
    		<tr>
    			<th class="product-name"><?php _e( 'Product', THB_THEME_NAME) ?></th>
    			<th class="product-price"><?php _e( 'Price', THB_THEME_NAME) ?></th>
    			<th class="product-quantity"><?php _e( 'Stock Status', THB_THEME_NAME ) ?></th>
		          <th class="product-add-to-bag"></th>
		          <th class="product-remove"></th>
    		</tr>
    	</thead>
        <tbody>
            <?php            
            if( count( $wishlist ) > 0 ) :
                foreach( $wishlist as $values ) :   
                    if( !is_user_logged_in() ) {
        				if( isset( $values['add-to-wishlist'] ) && is_numeric( $values['add-to-wishlist'] ) ) {
        					$values['prod_id'] = $values['add-to-wishlist'];
        					$values['ID'] = $values['add-to-wishlist'];
        				} else {
        					$values['prod_id'] = $values['product_id'];
        					$values['ID'] = $values['product_id'];
        				}
        			}
                                     
                    $product_obj = get_product( $values['prod_id'] );
                    
                    if( $product_obj !== false && $product_obj->exists() ) : ?>
                    <tr id="yith-wcwl-row-<?php echo $values['ID'] ?>">
                        <td class="product-name">
                            <h6><a href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $values['prod_id'] ) ) ) ?>"><?php echo apply_filters( 'woocommerce_in_cartproduct_obj_title', $product_obj->get_title(), $product_obj ) ?></a></h6>
                        </td>
                        <td class="product-price">
                            <?php
                            if( get_option( 'woocommerce_display_cart_prices_excluding_tax' ) == 'yes' )
                                { echo apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_obj->get_price_excluding_tax() ), $values, '' ); }
                            else
                                { echo apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_obj->get_price() ), $values, '' ); }    
                            ?>
                        </td>
                        <td class="product-quantity">
                            <?php
                            $availability = $product_obj->get_availability();
                            $stock_status = $availability['class'];
                            
                            if( $stock_status == 'out-of-stock' ) {
                                $stock_status = "Out";
                                echo '<span class="wishlist-out-of-stock">' . __( 'Out of Stock', THB_THEME_NAME ) . '';   
                            } else {
                                $stock_status = "In";
                                echo '<span class="wishlist-in-stock">' . __( 'In Stock', THB_THEME_NAME ) . '';
                            }
                            ?>
                        </td>
                        <td class="product-add-to-cart shop-buttons">
                            <?php echo YITH_WCWL_UI::add_to_cart_button( $values['prod_id'], $availability['class'] ) ?>
                        </td>
                        <td class="product-remove"><div><a href="javascript:void(0)" onclick="remove_item_from_wishlist( '<?php echo esc_url( $yith_wcwl->get_remove_url( $values['ID'] ) )?>', 'yith-wcwl-row-<?php echo $values['ID'] ?>');" class="remove" title="<?php _e( 'Remove this product', THB_THEME_NAME ) ?>"><i class="icon-budicon-543"></i></a></td>
                    </tr>
                    <?php
                    endif;
                endforeach;
            else: ?>
                <tr>
                    <td colspan="6" class="wishlist-empty"><?php _e( 'Your wishlist is currently empty.', THB_THEME_NAME ) ?></td>
                </tr>       
            <?php
            endif;
            
            if( isset( $page_links ) ) : ?>
            <tr>
                <td colspan="6"><?php echo $page_links ?></td>
            </tr>
            <?php endif ?>
        </tbody>
     </table>
     <?php do_action( 'yith_wcwl_after_wishlist' ); ?>
</form>