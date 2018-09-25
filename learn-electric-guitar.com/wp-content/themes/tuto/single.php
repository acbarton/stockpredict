<?php get_header(); ?>
<div class="mh-wrapper clearfix">
	<div id="main-content" class="mh-content"><?php
		while (have_posts()) : the_post();
			tuto_before_post_content();
			get_template_part('content', 'single');
			tuto_after_post_content();
			comments_template();
		endwhile; ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>