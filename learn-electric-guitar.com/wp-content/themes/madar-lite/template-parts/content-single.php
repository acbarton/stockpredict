<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Madar Lite
 */

global $madarlite_pageArgs; ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="single-item">
				    <?php madarlite_includes('post-thumbnail');?>
					<div class="single-header">
				        <h1 class="single-title entry-title"><?php the_title(); ?></span></h1>
							<div class="comment"><?php 
								echo madarlite_getcomment_count(get_the_ID(), 'post');?>
							</div>	

						<div class="meta">
						    <?php _e('by', 'madar-lite'); ?><i class="fa fa-user"></i><?php the_author_posts_link() ?>
							<i class="fa fa-clock-o"></i><?php the_time('F j, Y'); ?>
							<span class="post-cats"><i class="fa fa-folder"></i><?php printf('%1$s', get_the_category_list( ', ' ) ); ?></span>
							<div class="clearfix"></div>
						</div>
						<div class="clearfix"></div>
					</div><!-- #single-header# -->
					<div class="single-content"> 
					<?php the_content(); wp_link_pages($madarlite_pageArgs); ?><div class="clearfix"></div>
					</div>
                </div><!-- #single-item# -->
	</article>
	<div class="post-tags"><?php the_tags('', ''); ?></div>