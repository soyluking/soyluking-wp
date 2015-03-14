<div class="table full-height-content text-center no-result">
	<div>
		<?php if( is_search()) { ?>
			<h4><?php _e( 'Sorry, but nothing matched your search criteria.', THB_THEME_NAME ); ?></h4>
		<?php } else { ?>
			<h4><?php _e( 'Please add posts from your WordPress admin page.', THB_THEME_NAME ); ?></h4>
		<?php } ?>
		<a href="<?php echo home_url(); ?>" class="btn large"><?php _e( 'Back to Home Page', THB_THEME_NAME ); ?></a>
	</div>
</div>