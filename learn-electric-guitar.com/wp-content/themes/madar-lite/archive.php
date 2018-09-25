<?php get_header(); ?>
<div id="main-content" class="container">
	<div class="content">
		<div class="post-list">
			<?php madarlite_breadcrumbs();  ?>
			<div class="pagetitle" style="border-top:0;">
				<h2>
				<div class="page-rss"><a href="<?php echo home_url() . '/?feed=rss2'; ?>"><i class="fa fa-rss"></i></a>
					</div>
					<?php if ( is_day() ) : /* if day*/ ?>
						<?php _e('Daily Archives', 'madar-lite'); echo ': <span><b>' .  get_the_date() . '</b></span>'; ?>
					<?php elseif ( is_month() ) : /* if month */ ?>
						<?php _e('Monthly Archives', 'madar-lite'); echo ': <span>' . get_the_date('F Y') . '</span>'; ?>
					<?php elseif ( is_year() ) : /* if year */ ?>
						<?php _e('Yearly Archives', 'madar-lite'); echo ': <span>' . get_the_date('Y') . '</span>'; ?>
					<?php else : ?>
						<?php _e('Blog Archives', 'madar-lite'); ?>
					<?php endif; ?>
				</h2>
			<div class="clearfix"></div>
			</div>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<article class="post-item">
				<div class="post-header">
					<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				</div>
				<p class="post-meta"><?php _e('Written on ', 'madar-lite'); the_time('F j, Y'); _e(', by ', 'madar-lite'); the_author_posts_link(); ?></p>
				<div class="post-thumbnail">
					<?php echo madarlite_thumbnail('related'); ?>	
				</div>
				<div class="post-content">
					<?php the_excerpt(__('Read more', 'madar-lite'));?>
				</div>
						<div class="post-footer">
							<p><?php comments_popup_link(__('No Comments', 'madar-lite'), '1 ' . __('Comment', 'madar-lite'), '% ' . __('Comments', 'madar-lite')); ?></p>
							<p><?php _e('Categories: ', 'madar-lite'); the_category(', ') ?></p>
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