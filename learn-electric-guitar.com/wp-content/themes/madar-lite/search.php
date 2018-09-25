<?php get_header(); ?>
	<div class="content">
		<div class="post-list">
			<?php  madarlite_breadcrumbs(); ?>
			<div class="pagetitle" style="border-top:0;">
				<div class="page-rss"><a href="<?php echo home_url() . '/?feed=rss2&s=' . esc_html(get_search_query()); ?>"><i class="fa fa-rss"></i></a></div>
				<h2><?php _e('Search Result for', 'madar-lite'); ?> <?php echo esc_html(get_search_query()); ?></h2>
			<div class="clearfix"></div>
			</div>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                           <?php
							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );
							?>

			<?php endwhile; else: ?>
            <?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div><?php 
		global $post;
		if (isset($post) && function_exists("madarlite_pagination")) {
			madarlite_pagination($post->max_num_pages);
		} ?>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
