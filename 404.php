<?php get_header(); ?>
<section class="content404">
	<div class="table full-height-content">
		<div>
			<div class="row">
				<div class="small-12 medium-10 medium-centered large-8 columns text-center">
					<figure></figure>
					<h1><?php _e( "Page cannot be found.", THB_THEME_NAME ); ?></h1>
					<p><?php _e( "We are sorry. But the page you're looking for cannot be found. <br>
					You might try searching our site.", THB_THEME_NAME ); ?></p>
					
					<div class="small-12 medium-6 medium-centered columns">
						<?php get_search_form(); ?> 
					</div>
					<a href="<?php echo get_home_url(); ?>" class="btn"><?php _e('Back To Home', THB_THEME_NAME); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>