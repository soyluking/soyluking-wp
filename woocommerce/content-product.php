
<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $product, $woocommerce_loop;

$attachment_ids = $product->get_gallery_attachment_ids();

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
	
// Ensure visibilty
if ( ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

$catalog_mode = ot_get_option('shop_catalog_mode', 'off');
if (isset($_GET['sidebar'])) { $sidebar = htmlspecialchars($_GET['sidebar']); } else { $sidebar = ot_get_option('shop_sidebar'); }
?>

<?php if($sidebar != 'no') { ?>
    <article itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" <?php post_class("post small-12 medium-6 large-4 columns item grid-sizer"); ?>>
<?php } else { ?>
	<article itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" <?php post_class("post small-12 medium-6 large-3 columns item grid-sizer"); ?>>
<?php } ?>

<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<figure class="overlay-effect">
	
		<?php
			$image_html = "";
			
			do_action( 'thb_product_badge');

			if ( has_post_thumbnail() ) {
				$attachment_id = get_post_thumbnail_id();
				$image_html = wp_get_attachment_image( $attachment_id, 'shop_catalog' );

			}
		?>
		<?php echo $image_html; ?>			
		<div class="overlay">
			<div class="table">
				<div>
					<div class="child post-title<?php if ($catalog_mode == 'on') { echo ' catalog-mode'; } ?>">
						<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
						<hr>
					</div>
					<?php if ($catalog_mode != 'on') { ?>
					<div class="child buttons">
							<?php
								/**
								 * woocommerce_after_shop_loop_item_title hook
								 *
								 * @hooked woocommerce_template_loop_price - 10
								 */
								do_action( 'woocommerce_after_shop_loop_item_title' );
							?>
							<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</figure>
</article><!-- end product -->