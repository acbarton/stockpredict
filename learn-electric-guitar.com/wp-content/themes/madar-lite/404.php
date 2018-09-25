<?php get_header(); ?>
	<div id="main-content" class="container">
		<div class="content">
			<div id="error404" class="post-list">
				<div class="pagetitle">
					<h2><?php _e('Error', 'madar-lite'); ?> <b>404</b> <?php _e('Not Found', 'madar-lite'); ?></h2>
					<p><?php _e('Apologies, but the page you requested could not be found. Perhaps options below will help.', 'madar-lite'); ?></p>
				<div class="clearfix"></div>
				</div>
				<div class="single-content">
						<?php get_search_form(); ?>
						<div class="separator" style="margin-top:10px;margin-bottom:10px;"></div>
						<h2><?php _e('Category', 'madar-lite'); ?></h2>
						<ol>
							<?php wp_list_categories('title_li='); ?>
						</ol>
						<h2><?php _e('Tags', 'madar-lite'); ?></h2>
						<ul><?php
							$tags = get_tags( array('name_like' => "a", 'order' => 'ASC') );
							foreach ( (array) $tags as $tag ) {
							echo '<li class="cattag-list"><a href="' . get_tag_link ($tag->term_id) . '" rel="tag">' . $tag->name . ' </a></li>';
							} ?>
						</ul>
						<h2><?php _e('Monthly Archive', 'madar-lite'); ?></h2>
						<ul>
							<?php wp_get_archives('type=monthly'); ?>
						</ul>
						<h2><?php _e('Recent Post', 'madar-lite'); ?></h2>
						<ul>
							<?php wp_get_archives(array( 'type' => 'postbypost', 'limit' => 10, 'format' => 'custom', 'before' => '<li>', 'after' => '</li>' )); ?>
						</ul>
				</div><!--.post-content-->
			</div>
		</div><!--#content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>