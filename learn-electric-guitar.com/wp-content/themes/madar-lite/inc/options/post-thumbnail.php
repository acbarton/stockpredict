<?php
/*	ColourLine: Post Thumbnail
*/
function madarlite_post_thubmnail($data, $add='true'){ ?>
	<div class="single-thumbnail" id="thumb-handler">
	<?php {?>
		<?php if ( has_post_thumbnail() ) { 
			$image_url = '#';
			$image_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
			$image_name = basename($image_url ); 
			if($add == 'true')
				?>
			<?php the_post_thumbnail('madar-featured', array('class'=> "thumb-single",'alt' => get_the_title(), 'title' => get_the_title())); 
		} 
	} ?>
	</div><?php
} ?>