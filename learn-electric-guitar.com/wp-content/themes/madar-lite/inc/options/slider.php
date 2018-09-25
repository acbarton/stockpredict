<?php
// Create Slider
function madarlite_flexslider() {
	global $post, $madarlite_slider_width, $madarlite_slider_height;
	$madarlite_slider_width = 646;
	$madarlite_slider_height = 384;
		// Query Arguments
		       	//Get the user choices
		        $number     = get_theme_mod('slider_number','6');
		        $cat        = get_theme_mod('slider_cat');
		        $number     = ( ! empty( $number ) ) ? intval( $number ) : 6;
		        $cat        = ( ! empty( $cat ) ) ? intval( $cat ) : '';

				$args = array(
					'posts_per_page'		=> $number,
					'post_status'   		=> 'publish',
		            'cat'                   => $cat,
		            'ignore_sticky_posts'   => true			
				);
				$query = new WP_Query( $args );	
				if ( $query->have_posts() )  : ?>
<div class="slider-container">
			<div class="flexslider">
				<ul class="slides"> <?php
				while ( $query->have_posts() ) : $query->the_post(); ?>
					<li>
					<?php get_cat_name( $cat ) ?>
						<div class="slider-left-date">
						    <div class="slider-left-day"><?php the_time('d'); ?></div>
						    <div class="slider-left-month"><?php the_time('M'); ?> <?php the_time('Y'); ?></div>
					    </div>
						<a href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) { ?>
								<?php the_post_thumbnail('madar-slide', array('alt' => get_the_title(), 'title' => get_the_title()));?>
							<?php }else{?>
								<img src="<?php echo get_template_directory_uri() . '/images/handler.png';?>" width="<?php echo $madarlite_slider_width; ?>" height="<?php echo $madarlite_slider_height; ?>" title="<?php the_title() ?>" alt="<?php the_title() ?>"> 
							<?php }?>
						</a>
						<div class="flex-caption">
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<div class="clearfix"></div>
                      <em><?php echo esc_html( _e('Written by', 'madar-lite').' ' ); the_author_posts_link(); ?> 
						<?php echo esc_html( _e('on', 'madar-lite').' ' ); ?><?php the_time('F j, Y'); ?></em>
						</div>
						<div class="slider_readmore">
							<a href="<?php the_permalink(); ?>"><?php _e('Read More', 'madar-lite'); ?></a>
						</div>
					</li><?php 
				endwhile; ?>
				</ul>
			</div>
</div>
			<div class="clearfix"></div>
	<?php endif; ?>
<?php
	$post ;
	wp_reset_postdata();
}
?>