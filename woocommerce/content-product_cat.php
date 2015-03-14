<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Increase loop count
$woocommerce_loop['loop']++;

if (isset($_GET['sidebar'])) { $sidebar = htmlspecialchars($_GET['sidebar']); } else { $sidebar = ot_get_option('shop_sidebar'); }
?>
<?php if($sidebar != 'no') { ?>
    <article class="post product item small-12 medium-6 large-4 columns">
<?php } else { ?>
		<article class="post product item small-12 medium-6 large-3 columns">
<?php } ?>
	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>
		<figure class="overlay-effect">
			<?php
				/**
				 * woocommerce_before_subcategory_title hook
				 *
				 * @hooked woocommerce_subcategory_thumbnail - 10
				 */
				do_action( 'woocommerce_before_subcategory_title', $category );
			?>
			<div class="overlay">
				<div class="table">
					<div>
						<div class="child post-title">
							<h4><a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>"><?php
								echo $category->name;
				
								if ( $category->count > 0 )
									echo apply_filters( 'woocommerce_subcategory_count_html', ' <span class="count">(' . $category->count . ')</span>', $category );
							?></a></h4>
							<?php
								/**
								 * woocommerce_after_subcategory_title hook
								 */
								do_action( 'woocommerce_after_subcategory_title', $category );
							?>
						</div>
					</div>
				</div>
			</div>
		
		</figure>

	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

</article>