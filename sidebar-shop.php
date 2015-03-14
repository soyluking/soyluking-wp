<?php if (isset($_GET['sidebar'])) { $sidebar_pos = htmlspecialchars($_GET['sidebar']); } else { $sidebar_pos = ot_get_option('shop_sidebar'); }  ?>

<aside class="sidebar woo<?php if ($sidebar_pos == 'left') { echo ' pull'; }?> equal" role="complementary">
	<?php 
	
		##############################################################################
		# Shop Page Sidebar
		##############################################################################
	
	 	?>
	<?php dynamic_sidebar('shop'); ?>
</aside>