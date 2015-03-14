<?php
function theme_pagination($pages = '', $range = 1, $style = false)
{  
	$showitems = 2;
	
	global $paged;
	if(empty($paged)) $paged = 1;
	
	if($pages == '')
	{
	   global $wp_query;
	   $pages = $wp_query->max_num_pages;
	   if(!$pages)
	   {
	       $pages = 1;
	   }
	}   
	if(1 != $pages)
	{
	   echo '<aside class="pagination '.($style ? $style : "").'">';
	
	
	   if($paged > 1 && $showitems < $pages) echo '<a href="'.get_pagenum_link($paged - 1).'" class="prev page-numbers">'.__('<i class="fa fa-caret-left"></i> PREV', THB_THEME_NAME).'</a>';
	
	   for ($i=1; $i <= $pages; $i++)
	   {
	       if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
	       {
	           echo ($paged == $i)? "<span class='page-numbers current'>".$i."</span></li>":"<a href='".get_pagenum_link($i)."' class='page-numbers'>".$i."</a>";
	       }
	   }
	
	   if ($paged < $pages && $showitems < $pages) echo '<a href="'.get_pagenum_link($paged + 1).'" class="next page-numbers"><span>'. __('NEXT <i class="fa fa-caret-right"></i>', THB_THEME_NAME).'</span></a>';  
	   echo '</aside>';
	}
	
	if(1==2){paginate_links(); posts_nav_link(); next_posts_link(); previous_posts_link();}
}
?>