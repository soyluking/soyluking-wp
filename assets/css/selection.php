<?php 
	$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
	require_once( $parse_uri[0] . 'wp-load.php' );
	require_once('../../inc/ot-functions.php');
	$id = (isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '');
	
	Header("Content-type: text/css");
?>
<?php 
echo thb_google_webfont();
?>
/* Options set in the admin page */
body { 
	<?php thb_typeecho(ot_get_option('body_type'), false, 'Source Code Pro'); ?>
	color: <?php echo ot_get_option('text_color'); ?>;
}
.header .logo .logoimg {
	max-height: <?php thb_measurementecho(ot_get_option('logo_height')); ?>;
}
<?php thb_linkcolorecho(ot_get_option('link_color'), '.post .post-content'); ?>

/* Header Height */
.header {
	height: <?php thb_measurementecho(ot_get_option('header_height')); ?>;
	<?php thb_paddingecho(ot_get_option('header_spacing')); ?>
}
@media only screen and (min-width: 40.063em) {
	#side-cart,
	#searchpopup,
	#mobile-menu,
	.share_container {
		margin-top: <?php thb_measurementecho(ot_get_option('header_height')); ?>;
	}
}
/* Title Typography */
<?php if(ot_get_option('title_type')) { ?>
.mont, h1, h2, h3, h4, h5, h6, .header .menu-holder #quick_cart .float_count, .bar-side, #searchpopup input, .widget.widget_top_rated_products ul li a, .widget.widget_products ul li a, .widget.widget_recently_viewed_products ul li a, .widget.widget_shopping_cart .widget_shopping_cart_content .total, input[type="text"].placeholder, input[type="password"].placeholder, input[type="date"].placeholder, input[type="datetime"].placeholder, input[type="email"].placeholder, input[type="number"].placeholder, input[type="search"].placeholder, input[type="tel"].placeholder, input[type="time"].placeholder, input[type="url"].placeholder, textarea.placeholder, label, .order-detail-page .customer_details dt, .select-wrapper select, .content404 figure, .menu-footer, .mobile-menu > li > a, #side-cart .buttons a, #side-cart .subtotal, #side-cart ul li .list_content, #comments #comment-title + .text-center a, .badge, .product-information .back_to_shop, .price > span, .shopping_bag, .cart_totals table, #customer_login .login-section + .login-section .or, .payment_methods li .custom_label, #my-account .account-user .user-name, #my-account #my-account-nav li a, .cart-empty .message, .your-order-header .order-container, .smalltitle, #checkout_thankyou h2, .mediumtitle, .largetitle, .extralargetitle, .btn, .button, input[type=submit], .thb_tabs .tabs dd a, .thb_tabs .tabs li a, .thb_tour .tabs dd a, .thb_tour .tabs li a, .notification-box {
	<?php thb_typeecho(ot_get_option('title_type')); ?>	
}
<?php } ?>

/* Header Icon Color */
<?php if ($header_icon_color = ot_get_option('header_icon_color')) { ?>
.header .menu-holder #quick_search #search_icon,
.header .menu-holder #quick_cart .change-handle {
	fill: <?php echo $header_icon_color; ?>;
	color: <?php echo $header_icon_color; ?>;
}
.mobile-toggle span {
	background: <?php echo $header_icon_color; ?>;
}
.header .menu-holder #quick_cart,
.header .menu-holder #quick_cart .float_count:hover {
	color: <?php echo $header_icon_color; ?>;	
}
.header .menu-holder #quick_cart .change-color {
	stroke: <?php echo $header_icon_color; ?>; 	
}
<?php } ?>

/* Accent Color */
<?php if (ot_get_option('accent_color')) { ?>
a:hover, .post .post-meta ul li a, .post .post-title a:hover, .widget ul.menu .current-menu-item > a, .widget.widget_recent_entries ul li .url, .widget.widget_recent_comments ul li .url, .widget.woocommerce.widget_layered_nav ul li .count, .pagination .page-numbers.current, .mobile-menu > li.current-menu-item > a, .mobile-menu > li.sfHover > a, .mobile-menu > li > a:hover, .mobile-menu ul.sub-menu li a:hover, #comments #reply-title small, .post .post-content .filters li h6 a:hover, .post .post-content .filters li h6 a.active, .product_meta p a, .shopping_bag tbody tr td.order-status.Approved, .shopping_bag tbody tr td.product-name .posted_in a, .shopping_bag tbody tr td.product-quantity .wishlist-in-stock, .shopping_bag.order_table tbody tr td h6, .price_slider_amount .button, .price_slider_amount .button:hover, .termscontainer a, ul.accordion > li.active div.title, .tabs .active a, .tabs .active a:hover, .thb_tabs .tabs dd.active a, .thb_tabs .tabs li.active a, .thb_tour .tabs dd.active a, .thb_tour .tabs li.active a, .notification-box a, .notification-box.success .content, .notification-box.success .icon, #full-menu .full-menu > li > a:hover, #full-menu .full-menu > li.current-menu-item > a, #full-menu .full-menu > li.sfHover > a {
  color: <?php echo ot_get_option('accent_color'); ?>;
}

.custom_check:checked + .custom_label:before, [class^="tag-link"]:hover, .post .post-content .portfolio-text-style-2:hover, .product-information .single_add_to_cart_button, #my-account #my-account-nav li.active, .price_slider .ui-slider-handle, .product-category > a:after, .chosen-container.chosen-with-drop .chosen-single, .chosen-container .chosen-drop, .btn.accent, .button.accent, input[type=submit].accent,.notification-box.success {
	border-color: <?php echo ot_get_option('accent_color'); ?>;
}

.content404 figure, [class^="tag-link"]:hover, #side-cart .buttons a:last-child, .post .post-content .portfolio-text-style-2:hover, .product-information .single_add_to_cart_button, #my-account #my-account-nav li.active, .price_slider .ui-slider-range, .demo_store, .your-order-header .status, .btn.accent, .button.accent, input[type=submit].accent, .thb_tabs .tabs dd a:after, .thb_tabs .tabs li a:after, .thb_tour .tabs dd a:after, .thb_tour .tabs li a:after, .post .post-content .iconbox.type2 > span, .highlight.accent {
	background: <?php echo ot_get_option('accent_color'); ?>;	
}

.mobile-menu li.menu-item-has-children a:hover .menu_icon {
 	fill: <?php echo ot_get_option('accent_color'); ?>;
}
<?php } ?>
<?php if ($overlay_color = ot_get_option('overlay_color')) { ?>
.overlay-effect .overlay,
.portfolio_nav a .overlay,
.post .post-gallery .simple-overlay {
	<?php 
		echo "background: ".$overlay_color."";
	?>
}
<?php } ?>

/* Menu */
<?php if ($menu_type= ot_get_option('menu_type')) { ?>
.mobile-menu > li > a,
#full-menu .full-menu > li > a {
	<?php thb_typeecho($menu_type); ?>	
}
<?php } ?>
<?php if ($menu_submenu_type = ot_get_option('menu_submenu_type')) { ?>
.mobile-menu ul.sub-menu li a,
#full-menu ul.sub-menu li a {
	<?php thb_typeecho($menu_submenu_type); ?>	
}
<?php } ?>

/* Shop Badges */
<?php if ($badge_sale = ot_get_option('badge_sale')) { ?>
.badge.onsale {
	background: <?php echo $badge_sale;?>;
}
<?php } ?>
<?php if ($badge_outofstock = ot_get_option('badge_outofstock')) { ?>
.badge.out-of-stock {
	background: <?php echo $badge_outofstock;?>;
}
<?php } ?>
<?php if ($badge_justarrived= ot_get_option('badge_justarrived')) { ?>
.badge.new{
	background: <?php echo $badge_justarrived;?>;
}
<?php } ?>

/* Backgrounds */
.page-id-<?php echo $id; ?> #wrapper,
.postid-<?php echo $id; ?> #wrapper {
	<?php thb_bgecho( get_post_meta($id, 'page_bg', true)); ?>
}
<?php if ($bar_bg = ot_get_option('bar_bg')) { ?>
.header,
.bar-side,
#footer {
	<?php thb_bgecho($bar_bg); ?>
}
<?php } ?>
<?php if ($search_bg = ot_get_option('search_bg')) { ?>
#searchpopup{
	<?php thb_bgecho($search_bg); ?>
}
<?php } ?>
<?php if ($menu_bg = ot_get_option('menu_bg')) { ?>
#mobile-menu {
	<?php thb_bgecho($menu_bg); ?>
}
<?php } ?>
<?php if ($cart_bg = ot_get_option('cart_bg')) { ?>
#side-cart {
	<?php thb_bgecho($cart_bg); ?>
}
<?php } ?>
<?php if ($preloader_bg = ot_get_option('preloader_bg')) { ?>
#wrapper .preloader {
	<?php thb_bgecho($preloader_bg); ?>
}
<?php } ?>
/* Extra CSS */
<?php 
echo ot_get_option('extra_css');
?>