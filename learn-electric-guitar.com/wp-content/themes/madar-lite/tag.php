<?php get_header(); ?>
	<div class="content">
		
		<div class="post-list">
			<?php  madarlite_breadcrumbs(); ?>
			<div class="pagetitle" style="border-top:0;">

					<div class="page-rss"><a href="<?php echo home_url() . '/?feed=rss2&tag=' . single_tag_title( '', false ); ?>"><i class="fa fa-rss" style="font-size:28px;height:28px;display: block;color:#ff8000"></i></a>
					</div>

				<h2><?php echo _e('Tag Archives:', 'madar-lite') . ' <span><b>' . single_tag_title( '', false ) . '</b></span>'; ?></h2>
				<?php echo tag_description();?>
			<div class="clearfix"></div>
			</div>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<article class="post-item">
					<div class="post-header">
						<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					</div>
					<p class="post-meta"><?php the_time('F j, Y'); _e(', by ', 'madar-lite'); the_author_posts_link(); ?></p>
					<div class="post-thumbnail">
						<?php echo madarlite_thumbnail('post'); ?>		
					</div>
					<div class="post-content">
						<?php the_excerpt(__('Read more', 'madar-lite'));?>
					</div>
					<div class="post-footer">
						<p><?php comments_popup_link(__('No Comments', 'madar-lite'), '1 ' . __('Comment', 'madar-lite'), '% ' . __('Comments', 'madar-lite')); ?></p>
						<p><?php __('Categories: ', 'madar-lite'); the_category(', ') ?></p>
					</div>
				<div class="clearfix"></div>
				</article>
			<?php endwhile; else: ?>
				<div class="no-results">
					<p><strong><?php _e('There has been an error.', 'madar-lite'); ?></strong></p>
					<p><?php _e('We apologize for any inconvenience, please hit back on your browser or use the search form below.', 'madar-lite'); ?></p>
					<?php get_search_form(); ?>
				</div>
			<?php endif; ?>
		</div><?php 
		if (function_exists("madarlite_pagination")) {
			madarlite_pagination($post->max_num_pages);
		} ?>

	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>