<?php
/*
Plugin Name: Faster Pagination
Plugin URI: http://fasterthemes.com/
Description: Faster Pagination is a custom pagination plugin specially for themes developed by FasterThemes.
Version: 1.0
Author: FasterThemes
Author URI: http://fasterthemes.com/
*/
define('PAGINATION_URL', plugin_dir_url( __FILE__ ));

add_action('wp_enqueue_scripts' ,'enqueue_script_pagination');
function enqueue_script_pagination(){
  wp_enqueue_style('paginationstyle',PAGINATION_URL. 'assests/pagination.css',10,2);
}
function faster_pagination($pages = '', $range = 5)
{  
     $faster_showitems = ($range * 2)+1;  
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
     } echo '<div class="pagination">';  
     if(1 != $pages)
     {
		 
         echo "<ul>";
         if($paged > 2 && $paged > $range+1 && $faster_showitems < $pages) echo "<li class='pagination-previous-all'><a href='".get_pagenum_link(1)."'><span class='sprite previous-all-icon'><<</span></a></li>";
         if($paged > 1 && $faster_showitems < $pages) echo "<li class='pagination-previous'><a href='".get_pagenum_link($paged - 1)."'><span class='sprite previous-icon'><</span></a></li>";
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $faster_showitems ))
             {
                 echo ($paged == $i)? "<li class='active'><a href='#' >".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
             }
         }
         if ($paged < $pages && $faster_showitems < $pages) echo "<li class='pagination-next'><a href='".get_pagenum_link($paged + 1)."'><span class='sprite next-icon'>></span></a></li>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $faster_showitems < $pages) echo "<li class='pagination-next-all'><a href='".get_pagenum_link($pages)."'><span class='sprite next-all-icon'>>></span></a></li>";
         echo "</ul>\n";
     }
	echo '</div>';
}
?>