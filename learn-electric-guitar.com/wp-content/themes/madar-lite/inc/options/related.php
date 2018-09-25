<?php
/*	ColourLine: Related Post
*/
function madarlite_related_post(){ 
	global $post;
	$orig_post = $post;
	$related_query = 'tag';	
	$related_Args = array(
		'post__not_in' => array($post->ID),
		'posts_per_page'=> 3, // Number of related posts that will be shown. . "&orderby=rand"
		'ignore_sticky_posts'=> 1,
	);
				
	$my_query = new wp_query( $related_Args );
	if( $my_query->have_posts() ) { ?>
		<div id="related-posts" class="single-box">
			<h2><?php _e('Related Posts', 'madar-lite'); ?></h2>
			<ul><?php 
			while( $my_query->have_posts() ) {
			$my_query->the_post();?>
				<li>
					<div class="related-thumb">
						<?php echo madarlite_thumbnail('related'); ?>
					</div>
					<div class="related-content">
						<h3>
							<a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title();?></a>
						</h3>
					<?php the_time('M j, Y') ?>
					</div>
				</li><?php
			} ?>
			<div class="clearfix"></div>
			</ul>
		</div>
	<?php } else { echo '<span class="related-message">' . _e('There are no Related Post in Query', 'madar-lite') . '</span>'; }
	$post = $orig_post;
	wp_reset_postdata();
}
?>