<?php /* The template for displaying image attachments. */ ?>
<?php get_header(); ?>
<div class="mh-wrapper clearfix">
	<div id="main-content" class="mh-content"><?php
		while (have_posts()) : the_post();
			tuto_before_post_content(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('mh-content-wrapper'); ?>>
				<header class="entry-header clearfix">
					<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
				</header>
				<figure class="entry-thumbnail">
					<?php $att_image = wp_get_attachment_image_src($post->id, 'full'); ?>
					<a href="<?php echo esc_url(wp_get_attachment_url($post->id)); ?>" title="<?php echo the_title_attribute(); ?>" rel="attachment" target="_blank">
						<img src="<?php echo esc_url($att_image[0]); ?>" width="<?php echo absint($att_image[1]); ?>" height="<?php echo absint($att_image[2]); ?>" class="attachment-medium" alt="<?php echo the_title_attribute(); ?>" />
					</a>
					<?php if (has_excerpt()) { ?>
						<i class="fa fa-info"></i>
						<figcaption class="wp-caption-text">
							<?php the_excerpt(); ?>
						</figcaption>
					<?php } ?>
				</figure>
				<div class="entry-content clearfix">
					<?php the_content(); ?>
				</div>
			</article><?php
			tuto_after_post_content();
			comments_template();
		endwhile; ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>