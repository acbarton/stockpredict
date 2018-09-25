<?php get_header(); ?>
<div class="mh-wrapper clearfix">
	<div id="main-content" class="mh-content"><?php
		tuto_before_page_content();
		if (have_posts()) { ?>
			<header class="page-header">
				<h1 class="page-title mh-page-title">
					<?php printf(esc_html__('Search Results for: %s', 'tuto'), '<span>' . get_search_query() . '</span>'); ?>
				</h1>
			</header><?php
			while (have_posts()) : the_post();
				get_template_part('content', get_post_format());
			endwhile;
			tuto_pagination();
		} else {
			get_template_part('content', 'none');
		} ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>