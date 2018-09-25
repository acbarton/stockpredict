<?php $tuto_options = tuto_theme_options(); ?>
<?php get_header(); ?>
<div class="mh-wrapper clearfix">
	<div id="main-content" class="mh-content"><?php
		tuto_before_page_content();
		if (have_posts()) { ?>
			<header class="page-header"><?php
				the_archive_title('<h1 class="page-title mh-page-title">', '</h1>');
				the_archive_description('<div class="mh-loop-description">', '</div>'); ?>
			</header><?php
			if (is_author()) {
				tuto_author_box();
			}
			if ($tuto_options['magazine_layout'] === 'enable' && $paged < 2) {
				get_template_part('content', 'magazine');
			} else {
				while (have_posts()) : the_post();
					get_template_part('content', get_post_format());
				endwhile;
			}
			tuto_pagination();
		} else {
			get_template_part('content', 'none');
		} ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>