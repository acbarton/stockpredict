<?php
/*	Madar Lite: Post Navigation (Next Prev)
*/
function madarlite_post_navigation(){ ?>
		<div class="post-navigation">
			<div class="post-previous"><?php previous_post_link( '%link', '<span>'. _e( 'Previous', 'madar-lite').'</span> %title' ); ?></div>
			<div class="post-next"><?php next_post_link( '%link', '<span>'. _e( 'Next', 'madar-lite').'</span> %title' ); ?></div>
		</div><!-- .post-navigation -->
			<div class="clearfix"></div>

<?php 
}
?>