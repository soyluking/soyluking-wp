<?php function thb_portfolio( $atts, $content = null ) {
    $a = shortcode_atts(array(
    	'style' => 'grid',
    	'masonry_style' => 'style1',
    	'columns' => '4',
       	'item_count' => '9',
       	'portfolio_sort' => 'by-category',
       	'portfolio_ids' => false,
       	'retrieve' => '3',
       	'categories' => false,
       	'color' => false,
       	'carousel' => false,
       	'loadmore' => false,
       	'add_filters' => false
    ), $atts);

    if ($a['portfolio_sort'] == 'by-category') {
		$args = array(
			'showposts' => $a['item_count'],
			'nopaging' => 0,
			'post_type'=>'portfolio',
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'no_found_rows' => true,
			'tax_query' => array(
					array(
			    'taxonomy' => 'project-category',
			    'field' => 'id',
			    'terms' => explode(',',$a['categories']),
			    'operator' => 'IN'
			   )
			 )
		);
    } else  if ($a['portfolio_sort'] == 'by-id') {
    	$portfolio_id_array = explode(',', $a['portfolio_ids']);
    	$args = array(
			'post_type' => 'portfolio',
			'post_status' => 'publish',
			'ignore_sticky_posts'   => 1,
			'post__in'		=> $portfolio_id_array,
			'no_found_rows' => true,
			'orderby'		=> 'post__in'
		);
    }
	$posts = new WP_Query( $args );
 	$rand = rand(0,1000);
 	ob_start();
 	?>
 	<?php if ($a['style'] == 'masonry') { ?>
 		<section class="thb-portfolio masonry row" data-loadmore="#loadmore-<?php echo $rand; ?>">
 			<?php if ($a['add_filters'] == 'true') { ?>
	 			<ul class="filters">
	 				<a href="#" class="thb-toggle"><h6><?php _e( 'Filters', THB_THEME_NAME ); ?></h6></a>
	 				<li><h6><a href="#" data-filter="*" class="all active"><?php _e( 'show all', THB_THEME_NAME ); ?></a></h6></li>
	 				<?php
	 				$cats = get_categories(array('taxonomy'=>'project-category', 'include' => $a['categories']));
	 				foreach($cats as $portfolio_category) {
	 					$args = array(
	 					    'post_type' => 'portfolio',
	 					    'post_status' => 'published',
	 					    'project-category' => $portfolio_category->slug,
	 					    'numberposts' => -1
	 					);

	 					echo '<li><h6><a href="#" data-filter=".' . $portfolio_category->slug . '">' . $portfolio_category->name . '</a></h6></li>';

	 				}
	 				?>
	 			</ul>
	 		<?php } ?>
 			<?php $i = 1; ?>
 			<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
 				<?php if ($a['masonry_style'] == 'style1') {
	 				switch($i) {
	 					case 1:
	 					case 6:
	 						$imagesize=array("900","860");
	 						$font = 'large';
	 						$articlesize = 'small-12 medium-6';
	 						break;
	 					case 2:
	 					case 3:
	 						$imagesize=array("900","430");
	 						$font = 'small';
	 						$articlesize = 'small-12 medium-6';
	 						break;
	 					case 4:
	 					case 5:
	 					case 7:
	 					case 8:
	 					default:
	 						$imagesize=array("450","430");
	 						$articlesize = 'small-12 medium-3 grid-sizer';
	 						$font = 'medium';
	 						break;

	 				}
 				} else if ($a['masonry_style'] == 'style2') {
 					switch($i) {
						case 2:
						case 7:
							$imagesize=array("450","860");
							$font = 'small';
							$articlesize = 'small-12 medium-3';
							break;
						default:
							$imagesize=array("450","430");
							$articlesize = 'small-12 medium-3 grid-sizer';
							$font = 'medium';
							break;

					}
 				} else if ($a['masonry_style'] == 'style3') {
 					switch($i) {
 						case 1:
 							$imagesize=array("1200","900");
							$font = 'large';
							$articlesize = 'small-12 medium-8';
 							break;
 						case 2:
 						case 4:
 						case 5:
 						case 6:
 						default:
 							$imagesize=array("600","450");
							$articlesize = 'small-12 medium-4 grid-sizer';
							$font = 'medium';
							break;
						case 3:
							$imagesize=array("600","900");
							$articlesize = 'small-12 medium-4';
							$font = 'medium';
							break;
 						case 7:
 							$imagesize=array("1200","450");
 							$font = 'small';
 							$articlesize = 'small-12 medium-8';
 							break;

 					}
 				}
 				?>
 				<?php
 				$id = get_the_ID();
 				$image_id = get_post_thumbnail_id();
 				$image_link = wp_get_attachment_image_src($image_id,'full');
 				$image = aq_resize( $image_link[0], $imagesize[0], $imagesize[1], true, false, true);
 				$image_title = esc_attr( get_the_title($id) );
 				$portfolio_type = get_post_meta($id, 'portfolio_type', true);
 				$meta = get_the_term_list( $id, 'project-category', '<span>', '</span>, <span>', '</span>' );
 				$meta = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $meta);
 				$terms = get_the_terms( $id, 'project-category' );
 				$cats = '';

 				foreach ($terms as $term) { $cats .= ' '.strtolower($term->slug); }
 				?>

 				<article <?php post_class('post '.$articlesize.' columns item '.$cats); ?> id="post-<?php the_ID(); ?>">

 					<a href="<?php the_permalink() ?>" rel="bookmark" class="post-gallery overlay-effect">
 						<img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php echo $image_title; ?>" />
 						<div class="overlay">
 							<div class="table">
 								<div>
 									<div class="child post-title">
 										<h4><?php the_title(); ?></h4>
 										<hr>
 									</div>
 									<div class="child categories">
 										<aside class="post_categories"><?php echo $meta; ?></aside>
 									</div>
 								</div>
 							</div>
 						</div>
 					</a>
 				</article>
 			<?php $i++; endwhile; // end of the loop. ?>


 		</section>
 		<?php if ($a['loadmore']) { ?>
 		<a class="masonry_btn" href="#" id="loadmore-<?php echo $rand; ?>" data-type="portfolio" data-loading="<?php _e( 'Loading Posts', THB_THEME_NAME ); ?>" data-nomore="<?php _e( 'No More Posts to Show', THB_THEME_NAME ); ?>" data-initial="<?php echo $a['item_count']; ?>" data-count="<?php echo $a['retrieve']; ?>" data-categories="<?php echo $a['categories']; ?>" data-masonry="<?php echo $a['masonry_style']; ?>"><?php _e( 'Load More', THB_THEME_NAME ); ?></a>
 		<?php } ?>
 	<?php } else if ($a['style'] == 'text1') { ?>
 		<?php $i = 1; ?>
 		<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
			<?php
			$id = get_the_ID();
			$image_id = get_post_thumbnail_id();
			$image_link = wp_get_attachment_image_src($image_id,'full');
			$image = aq_resize( $image_link[0], 1000, 500, true, false);
			$image_title = esc_attr( get_the_title($id) );
			?>
         <?php
            if ( $i === 1 )      { $color_work =   '#40BFBF'; }
            elseif ( $i === 2 )  { $color_work =   '#409FBF'; }
            elseif ( $i === 3 )  { $color_work =   '#407FBF'; }
            elseif ( $i === 4 )  { $color_work =   '#4060BF'; }
            elseif ( $i === 5 )  { $color_work =   '#4040BF'; }
            elseif ( $i === 6 )  { $color_work =   '#6040BF'; }
            elseif ( $i === 7 )  { $color_work =   '#7F40BF'; }
            elseif ( $i === 8 )  { $color_work =   '#9F40BF'; }
            elseif ( $i === 9 )  { $color_work =   '#BF40BF'; }
            elseif ( $i === 10 ) { $color_work =   '#BF409F'; }
            elseif ( $i === 11 ) { $color_work =   '#BF4080'; }
            elseif ( $i === 12 ) { $color_work =   '#BF4060'; }
         ?>
				<a href="<?php the_permalink(); ?>" class="portfolio-text-style" style="color: <?php echo $color_work; ?>;">
					<?php the_title(); ?>
					<span style="left:20px;top:37px"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></span>
					<figure>
						<img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php echo $image_title; ?>" />
					</figure>
				</a>
		<?php $i++; endwhile; // end of the loop. ?>
	<?php } else if ($a['style'] == 'text2') { ?>
		<div class="text-style-container">
		<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
			<?php
			$id = get_the_ID();
			$type = get_post_meta($id, 'portfolio_type', true);
			$meta = get_the_term_list( $id, 'project-category', '<span>', '</span>, <span>', '</span>' );
			$meta = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $meta);
			?>
				<a href="<?php the_permalink(); ?>" class="portfolio-text-style-2">
					<div class="table">
						<div>
							<h1><?php the_title(); ?></h1>
							<?php echo $meta; ?>
						</div>
					</div>
				</a>
		<?php endwhile; // end of the loop. ?>
		</div>
 	<?php } else if ($a['style'] == 'grid') { ?>

		<?php if ( $posts->have_posts() ) { ?>
			  <?php switch($a['columns']) {
			  	case 2:
			  		$col = 'medium-6';
			  		$w = '1170';
			  		$h = '1125';
			  		break;
			  	case 3:
			  		$col = 'medium-6 large-4';
			  		$w = '780';
			  		$h = '750';
			  		break;
			  	case 4:
			  		$col = 'medium-6 large-3';
			  		$w = '580';
			  		$h = '560';
			  		break;
			  	case 5:
			  		$col = 'thb-five';
			  		$w = '470';
			  		$h = '450';
			  		break;
			  	case 6:
			  		$col = 'medium-4 large-2';
			  		$w = '390';
			  		$h = '375';
			  		break;
			  } ?>
		  <?php if ($a['carousel']) { ?>

		  	<div class="carousel-container thb-portfolio shortcode">
		  		<div class="carousel owl row" data-columns="<?php echo $a['columns']; ?>" data-navigation="false" data-pagination="true">
		  <?php } else { ?>
				<div class="row thb-portfolio shortcode">
		  <?php } ?>
				<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
					<?php
					$id = get_the_ID();
					$image_id = get_post_thumbnail_id();
					$image_link = wp_get_attachment_image_src($image_id,'full');
					$image = aq_resize( $image_link[0], $w, $h, true, false);
					$image_title = esc_attr( get_the_title($id) );
					$type = get_post_meta($id, 'portfolio_type', true);
					$meta = get_the_term_list( $id, 'project-category', '<span>', '</span>, <span>', '</span>' );
					$meta = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $meta);
					?>
					<article <?php post_class('post small-12 '.$col.' columns'); ?> id="post-<?php the_ID(); ?>">
						<a href="<?php the_permalink() ?>" rel="bookmark" class="post-gallery overlay-effect">
							<img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php echo $image_title; ?>" />
							<div class="overlay">
								<div class="table">
									<div>
										<div class="child post-title">
											<h4><?php the_title(); ?></h4>
											<hr>
										</div>
										<div class="child categories">
											<aside class="post_categories"><?php echo $meta; ?></aside>
										</div>
									</div>
								</div>
							</div>
						</a>
					</article>
				<?php endwhile; // end of the loop. ?>

			<?php if ($a['carousel']) { ?>
					</div>
				</div>
			<?php } else { ?>
				</div>
			<?php } ?>

		<?php } ?>
	 <?php } else if ($a['style'] == 'horizontal') { ?>
	 	<?php if ( $posts->have_posts() ) { ?>
	 		<div class="row thb-portfolio horizontal shortcode">

	 			<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
	 				<?php
	 				$id = get_the_ID();
	 				$image_id = get_post_thumbnail_id();
	 				$image_link = wp_get_attachment_image_src($image_id,'full');
	 				$image = aq_resize( $image_link[0], false, 600, true, false, true);
	 				$image_title = esc_attr( get_the_title($id) );
	 				$type = get_post_meta($id, 'portfolio_type', true);
	 				$meta = get_the_term_list( $id, 'project-category', '<span>', '</span>, <span>', '</span>' );
	 				$meta = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $meta);
	 				?>
	 				<article <?php post_class('post small-12 columns'); ?> id="post-<?php the_ID(); ?>">
	 					<a href="<?php the_permalink() ?>" rel="bookmark" class="post-gallery overlay-effect" style="background-image: url('<?php echo $image[0]; ?>');">
	 						<img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php echo $image_title; ?>" />
	 						<div class="overlay">
	 							<div class="table">
	 								<div>
	 									<div class="child post-title">
	 										<h4><?php the_title(); ?></h4>
	 										<hr>
	 									</div>
	 									<div class="child categories">
	 										<aside class="post_categories"><?php echo $meta; ?></aside>
	 									</div>
	 								</div>
	 							</div>
	 						</div>
	 					</a>
	 				</article>
	 			<?php endwhile; // end of the loop. ?>

	 		</div>

	 	<?php } ?>
	 <?php } else if ($a['style'] == 'vertical') { ?>
	 	<?php if ( $posts->have_posts() ) { ?>
	 		<?php switch($a['columns']) {
	 			case 2:
	 				$col = 'large-6';
	 				$w = '400';
	 				break;
	 			case 3:
	 				$col = 'large-4';
	 				$w = '500';
	 				break;
	 			case 4:
	 				$col = 'large-3';
	 				$w = '600';
	 				break;
	 			case 5:
	 				$col = 'thb-five';
	 				$w = '450';
	 				break;
	 			case 6:
	 				$col = 'large-2';
	 				$w = '600';
	 				break;
	 		} ?>
	 		<?php if ($a['carousel']) { ?>

	 			<div class="carousel-container thb-portfolio vertical shortcode">
	 				<div class="carousel owl row" data-columns="<?php echo $a['columns']; ?>" data-navigation="false" data-pagination="true">
	 		<?php } else { ?>
	 				<div class="row thb-portfolio vertical shortcode">
	 		<?php } ?>

	 			<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
	 				<?php
	 				$id = get_the_ID();
	 				$image_id = get_post_thumbnail_id();
	 				$image_link = wp_get_attachment_image_src($image_id,'full');
	 				$image = aq_resize( $image_link[0], $w, 900, true, false);
	 				$image_title = esc_attr( get_the_title($id) );
	 				$type = get_post_meta($id, 'portfolio_type', true);
	 				$meta = get_the_term_list( $id, 'project-category', '<span>', '</span>, <span>', '</span>' );
	 				$meta = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $meta);
	 				?>
	 				<article <?php post_class('post small-12 medium-6 '.$col.' columns'); ?> id="post-<?php the_ID(); ?>">
	 					<a href="<?php the_permalink() ?>" rel="bookmark" class="post-gallery overlay-effect" style="background-image: url('<?php echo $image[0]; ?>');">
	 						<img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php echo $image_title; ?>" />
	 						<div class="overlay">
	 							<div class="table">
	 								<div>
	 									<div class="child post-title">
	 										<h4><?php the_title(); ?></h4>
	 										<hr>
	 									</div>
	 									<div class="child categories">
	 										<aside class="post_categories"><?php echo $meta; ?></aside>
	 									</div>
	 								</div>
	 							</div>
	 						</div>
	 					</a>
	 				</article>
	 			<?php endwhile; // end of the loop. ?>

	 		<?php if ($a['carousel']) { ?>
	 				</div>
	 			</div>
	 		<?php } else { ?>
	 			</div>
	 		<?php } ?>

	 	<?php } ?>
	 <?php } ?>

	<?php
   $out = ob_get_contents();
   if (ob_get_contents()) ob_end_clean();

   wp_reset_query();
   wp_reset_postdata();

  return $out;
}
add_shortcode('thb_portfolio', 'thb_portfolio');
