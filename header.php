<?php global $woocommerce, $yith_wcwl; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=1">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta http-equiv="cleartype" content="on">
	<meta name="HandheldFriendly" content="True">
	<?php if( $favicon = ot_get_option('favicon')){ ?>
		<?php if (is_ssl()) {
		    $favicon_image_img = str_replace("http://", "https://", $favicon);
		} else {
		    $favicon_image_img = $favicon;
		}
		?>
	<link rel="shortcut icon" href="<?php echo $favicon_image_img; ?>">
	<?php } else {?>
	<link rel="shortcut icon" href="<?php echo THB_THEME_ROOT; ?>/assets/img/favicon.ico">
	<?php } ?>
	<?php do_action( 'thb_handhelded_devices' ); ?>
	<?php
		$id = get_queried_object_id();
		$page_menu = (get_post_meta($id, 'page_menu', true) !== '' ? get_post_meta($id, 'page_menu', true) : false);
		$header_style = (isset($_GET['header_style']) ? htmlspecialchars($_GET['header_style']) : ot_get_option('header_style', 'style1'));
		$menu_mobile_toggle_view = (isset($_GET['menu_style']) ? htmlspecialchars($_GET['menu_style']) : ot_get_option('menu_style', 'style1'));
		$footer_style = (isset($_GET['footer_style']) ? htmlspecialchars($_GET['footer_style']) : ot_get_option('footer_style', 'footer-standard'));
		$left_bar = sanitize_text_field(ot_get_option('left_bar'));
		$right_bar = sanitize_text_field(ot_get_option('right_bar'));
		$site_bars = (isset($_GET['site_bars']) ? htmlspecialchars($_GET['site_bars']) : ot_get_option('site_bars', 'on'));
		$header_cart = ot_get_option('header_cart');
		$header_search = ot_get_option('header_search');
		$menu_footer = ot_get_option('menu_footer');
		$smooth_scroll = (ot_get_option('smooth_scroll') != 'off' ? 'smooth_scroll' : '');
		if (get_post_meta($id, 'header_override', true) == 'on') {
			$header_cart = get_post_meta($id, 'header_cart', true);
			$header_search = get_post_meta($id, 'header_search', true);
		}
		$logo = (ot_get_option('logo') ? ot_get_option('logo') : THB_THEME_ROOT. '/assets/img/logo.png');
		$footer = ot_get_option('footer', 'on');
	?>
	<?php
		$class = array();
	 	if($site_bars == 'off') {
	 		array_push($class, 'site_bars_off');
	 	}
	 	if($footer == 'off') {
 			array_push($class, 'footer_off');
 		}
 		array_push($class, $footer_style);
		array_push($class, $smooth_scroll);
	?>
	<?php
		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
	?>
</head>
<body <?php body_class($class); ?> data-url="<?php echo esc_url(home_url()); ?>" data-cart-count="<?php if($woocommerce) { echo $woocommerce->cart->cart_contents_count; } ?>" data-sharrreurl="<?php echo THB_THEME_ROOT; ?>/inc/sharrre.php">
<div id="wrapper" class="open">

	<!-- Start Mobile Menu -->
	<nav id="mobile-menu">
		<div class="menu-container custom_scroll">
			<a href="#" class="panel-close"></a>
			<div class="menu-holder">
				<?php if ($page_menu) { ?>
					<?php wp_nav_menu( array( 'menu' => $page_menu, 'depth' => 2, 'container' => false, 'menu_class' => 'mobile-menu sf-menu', 'walker' => new thb_mobileDropdown  ) ); ?>
				<?php } else  if(has_nav_menu('nav-menu')) { ?>
				  <?php wp_nav_menu( array( 'theme_location' => 'nav-menu', 'depth' => 2, 'container' => false, 'menu_class' => 'mobile-menu sf-menu', 'walker' => new thb_mobileDropdown ) ); ?>
				<?php } else { ?>
					<ul class="mobile-menu">
						<li><a href="<?php echo get_admin_url().'nav-menus.php'; ?>">Please assign a menu from Appearance -> Menus</a></li>
					</ul>
				<?php } ?>
			</div>

			<div class="menu-footer">
				<?php echo do_shortcode($menu_footer); ?>
				<?php if (ot_get_option('menu_ls') == 'on') { do_action( 'thb_language_switcher' ); } ?>
			</div>
		</div>
		<div class="spacer"></div>
	</nav>
	<!-- End Mobile Menu -->

	<!-- Start Quick Cart -->
	<?php do_action( 'thb_side_cart' ); ?>
	<!-- End Quick Cart -->

		<!-- Start Loader -->
		<div class="preloader"></div>
		<!-- End Loader -->

		<!-- Start Header -->
		<header class="header row no-padding <?php echo $header_style; ?>" data-equal=">.columns" role="banner">
			<div class="small-7 medium-4 columns logo<?php if ($header_style == 'style1') { ?> show-for-large-up<?php } ?>">
				<?php if ($header_style == 'style2') { ?>
					<a href="<?php echo home_url(); ?>" class="logolink">
						<img src="<?php echo $logo; ?>" class="logoimg" alt="<?php bloginfo('name'); ?>"/>
					</a>
				<?php } ?>
			</div>
			<?php if ($header_style != 'style2') { ?>
			<div class="small-7 medium-4 columns logo">
				<?php if ($header_style == 'style1') { ?>
					<a href="<?php echo home_url(); ?>" class="logolink">
						<img src="<?php echo $logo; ?>" class="logoimg" alt="<?php bloginfo('name'); ?>"/>
					</a>
				<?php } ?>
			</div>
			<?php } ?>
			<div class="small-5 <?php if ($header_style == 'style2') { echo 'medium-8'; } else { echo 'medium-4';} ?> columns menu-holder">
				<?php $full_menu_true = ($menu_mobile_toggle_view == 'style2' && $header_style == 'style2');?>
				<?php if ($full_menu_true) { ?>
					<nav id="full-menu" role="navigation">
						<?php if ($page_menu) { ?>
							<?php wp_nav_menu( array( 'menu' => $page_menu, 'depth' => 2, 'container' => false, 'menu_class' => 'full-menu', 'walker' => new thb_mobileDropdown  ) ); ?>
						<?php } else  if(has_nav_menu('nav-menu')) { ?>
						  <?php wp_nav_menu( array( 'theme_location' => 'nav-menu', 'depth' => 2, 'container' => false, 'menu_class' => 'full-menu', 'walker' => new thb_mobileDropdown ) ); ?>
						<?php } else { ?>
							<ul class="full-menu">
								<li><a href="<?php echo get_admin_url().'nav-menus.php'; ?>">Please assign a menu from Appearance -> Menus</a></li>
							</ul>
						<?php } ?>
					</nav>
				<?php } ?>
				<?php if ($header_search != 'off') { do_action( 'thb_quick_search' ); } ?>
				<?php if ($header_cart != 'off') { do_action( 'thb_quick_cart' ); } ?>
				<a href="#" data-target="open-menu" class="mobile-toggle<?php if (!$full_menu_true) { ?> always<?php } ?>">
					<div>
						<span></span><span></span><span></span>
					</div>
				</a>
			</div>
		</header>
		<!-- End Header -->
		<!-- Start Quick Search -->
		<aside id="searchpopup">
			<div class="spacer"></div>
			<div class="vcenter">
				<div>
					<p><?php _e('SEARCH AND PRESS ENTER', THB_THEME_NAME); ?></p>
					<?php get_search_form(); ?>
				</div>
			</div>
		</aside>
		<!-- End Quick Search -->
		<?php if($site_bars != 'off') { ?>
		<!-- Start Left Bar -->
		<aside id="bar-left" class="bar-side"><div><?php echo $left_bar; ?></div></aside>
		<!-- End Left Bar -->

		<!-- Start Right Bar -->
		<aside id="bar-right" class="bar-side right-side"><div class="right-side"><?php echo $right_bar; ?></div></aside>
		<!-- End Right Bar -->
		<?php } ?>

		<div role="main" class="cf">
