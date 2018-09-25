<?php

?>

<?php get_header();
 if ( 'posts' == get_option( 'show_on_front' ) ) {
	
    include( get_home_template() );
	
} else {
    if ( get_theme_mod('breaking_enable') ) : 
        madarlite_breaking();
     endif; ?>
<div class="content">
    <?php 
	if ( get_theme_mod('slider_enable') ) : ?>
		<?php madarlite_flexslider(); ?>
    <?php endif; ?>
    <?php if ( get_theme_mod('recent-carousel') ) : ?>
		<?php get_template_part( 'template-parts/recentbox' ); ?>
    <?php endif; ?>
<?php 

 $madarlite_args = array(
 	'type'            => 'post',
    'orderby'         => 'post_date',
    'order'           => 'DESC',
    'post_status'     => 'publish',
	'ignore_sticky_posts'=> 1,
	'posts_per_page'  => 9,
	'suppress_filters' => true );
 
 $madarlite_query = new WP_Query($madarlite_args); $madarlite_counter = 0;
 if ($madarlite_query->have_posts()) : 
 while ( $madarlite_query->have_posts()) : $madarlite_query->the_post(); $madarlite_counter++; 
 
 if ( $madarlite_counter == 1 || $madarlite_counter == 2 ): ?>

<?php elseif ( $madarlite_counter == 3 ): ?>

<!-- Heading  -->
 <div class="home-box">
 	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
 		<a href="<?php the_permalink(); ?>"></a>
 			<div class="home-box-header">
				<h2><?php the_title();?></h2>						
				<div class="clearfix"></div>
			</div> 
 			<div class="entrytext">
			<?php echo madarlite_thumbnail('box'); ?>
			        <p class="post-meta">
						<i class="fa fa-clock-o"></i><?php the_time('F j, Y'); ?>
						<?php echo madarlite_getcomment_count(get_the_ID()); ?>
					</p>
			        <div class="box-excerpt">
							<?php $madarlite_excerptlength= '25';the_excerpt(); ?>
					</div>
 			</div>
        
    </div>
 </div>
 <!--  End of Heading --> 
<?php else: ?> 

<!-- Sub Heading  -->
 <?php if ( $madarlite_counter == 4 ): ?>
 <?php endif; ?>
 	<div class="fsubheading">
 		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>"> 
 			<a href="<?php the_permalink(); ?>">
 			<div class="home-box-header">
				<h2><?php the_title();?></h2>						
				<div class="clearfix"></div>
			</div>
 				<div class="entrytext"><?php echo madarlite_thumbnail('box'); ?>
					<p class="post-meta">
						<i class="fa fa-clock-o"></i><?php the_time('F j, Y'); ?>
						<?php echo madarlite_getcomment_count(get_the_ID()); ?>
					</p>
			        <div class="box-excerpt">
							<?php $madarlite_excerptlength= '30';the_excerpt(__('Read more', 'madar-lite')); ?>
				    </div>
				</div>
           	</a>
 		</div>
    </div>
    <?php if ( $madarlite_counter == 5 || $madarlite_counter == 7  ): ?><div class="clearfix"> </div><?php endif; ?>
 <?php if ( $madarlite_counter == 9 ): ?>
 <?php endif; ?>
 <?php endif; ?>
 <!--  End of Sub Heading -->
 
 <?php endwhile; endif; wp_reset_postdata(); ?>

 <!-- Categories -->
<?php 
$madarlite_cat_args = array(
	'type'                     => 'post',
	'child_of'                 => '',
	'parent'                   => '',
	'orderby'                  => 'slug',
	'order'                    => 'ASC',
	'hide_empty'               => 1,
	'hierarchical'             => 1,
	'depth'					   => 1,
	'walker' 				   => 'object',
	'exclude'                  => '',
	'include'                  => '',
	'number'                   => '',
	'taxonomy'                 => 'category',
	'pad_counts'               => false );
$madarlite_cats = get_categories($madarlite_cat_args);  $madarlite_countercc = 0;
foreach ($madarlite_cats as $madarlite_cat) :
if ($madarlite_cat->category_parent == 0 ) {

if ( $madarlite_countercc == 3 ): echo '<div class="clear-cat"></div>'; $madarlite_countercc = 1;  else: $madarlite_countercc++;  endif; 

echo '<div class="fpage-cat" >'; 

 $madarlite_args = array(
'orderby'         => 'post_date',
'order'           => 'DESC', 
'cat'             => $madarlite_cat->term_id
);

 $madarlite_query = new WP_Query( $madarlite_args); 

	 if ($madarlite_query->have_posts()) : $madarlite_counter = 0;
	 
	echo '<a href="'.get_category_link($madarlite_cat->cat_ID).'" target="_blank">
	 <div class="home-box-header"><h2>' . $madarlite_cat->name . '</h2><div class="clearfix"></div></div></a>';
	 
	 while (  $madarlite_query->have_posts()) :   $madarlite_query->the_post(); $madarlite_counter++;  ?>	
	
<?php if ($madarlite_counter == 1 ) : ?>
<a href="<?php the_permalink() ?>" ><?php echo madarlite_thumbnail('related'); ?>
<h3 class="fcpt"><?php the_title(); ?></h3>
<?php the_excerpt(); ?> </a> <?php else: ?>
<h4 class="fcpt"><li><a href="<?php the_permalink() ?>" ><?php the_title(); ?></a></li></h4></a>
<?php endif; endwhile; ?>
	<a class="read-more" href="<?php echo get_category_link($madarlite_cat->cat_ID); ?>" target="_blank"><?php echo __('Read All','madar-lite'); ?></a>
 	<?php else : 
		echo '<h2>'. __('No Posts for','madar-lite'). ' '.$madarlite_cat->name.' '. __('Category','madar-lite'). '</h2>';				
	 endif; 
	 
	 wp_reset_postdata(); 
	
echo '</div> <!--end of fpage-cat-->';
}
endforeach; ?>
</div><!--end of content-->
<?php get_sidebar(); ?>
<?php
}
get_footer(); ?>