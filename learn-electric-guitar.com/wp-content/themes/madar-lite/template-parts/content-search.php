<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package EasyMag
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-item">
		<div class="post-header">
			<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		</div>
		<p class="post-meta"><?php _e('Written on ', 'madar-lite'); the_time('F j, Y'); _e(', by ', 'madar-lite'); the_author_posts_link(); ?></p>
		<div class="post-thumbnail"><?php echo madarlite_thumbnail('post'); ?></div>
		<div class="post-content"><?php the_excerpt(__('Read more', 'madar-lite'));?></div>
		<div class="post-footer"><p><?php comments_popup_link(__('No Comments', 'madar-lite'), '1 ' . __('Comment', 'madar-lite'), '% ' . __('Comments', 'madar-lite')); ?></p><p><?php _e('Categories: ', 'madar-lite'); the_category(', ') ?></p></div>
				<div class="clearfix"></div>
    </div>
</article>

