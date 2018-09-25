<?php
 $madarlite_args = array(
 	'type'            => 'post',
    'orderby'         => 'post_date',
    'order'           => 'DESC',
    'post_status'     => 'publish',
	'ignore_sticky_posts'=> 1,
	'posts_per_page'  => 9,
	'suppress_filters' => true );
				$madarlite_query = new WP_Query( $madarlite_args );	
				if ( $madarlite_query->have_posts() ) {
				?>
				<section class="one-column section">
                <div class="home-box">
				<div class="home-box-header">
						<h2><?php _e('Recent Posts', 'madar-lite'); ?></h2>						
				<div class="clearfix"></div>
				</div>
				<div id="cbp-qtrotator" class="cbp-qtrotator">
				<?php while ( $madarlite_query->have_posts() ) : $madarlite_query->the_post(); ?>
					<div class="cbp-qtcontent">
						<?php echo madarlite_thumbnail('rsmall'); ?>

						<div class="cbp">
			               <?php the_title( sprintf( '<h3><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
						<div class="box-excerpt">
							<?php the_excerpt(); ?>
						</div>
						  <p class="post-meta">
							<i class="fa fa-clock-o"></i><?php the_time('F j, Y'); ?>
							<?php echo madarlite_getcomment_count(get_the_ID()); ?>
						  </p>
						</div>
					</div>
                <?php endwhile;?>		
				</div>
                </div> 
				</section>
                <?php }
				wp_reset_postdata();
?>