<?php
function madarlite_breaking() {
					$args = array(
					'posts_per_page'		=> 5,
					'post_status'   		=> 'publish',
		            'ignore_sticky_posts'   => true			
				);
				$query = new WP_Query( $args );	
				if ( $query->have_posts() ) {
				?>
	<div id="breaking-container" class="breaking">
		<div class="breaking-header"><i class="fa fa-bell faa-ring animated"></i><?php _e('Breaking News', 'madar-lite'); ?></div>
		<?php if( $query->have_posts() ) : ?>
			<ul id="ticker">
				<?php while($query->have_posts()) : $query->the_post(); ?>
					<li><span><?php the_time('F j, Y'); ?></span><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>	
				<?php endwhile; ?>
			</ul>
		<?php  endif; ?>
		<div class="clearfix"></div>
	</div><?php
} wp_reset_postdata();
}
?>