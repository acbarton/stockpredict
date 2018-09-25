<?php get_header(); ?>
<div class="mh-wrapper clearfix">
	<div class="mh-main clearfix">
		<div id="main-content" class="mh-content">
			<?php tuto_before_page_content(); ?>
			<header class="page-header">
				<h1 class="page-title mh-page-title">
					<?php esc_html_e('Oops! That page can&rsquo;t be found.', 'tuto'); ?>
				</h1>
			</header>
			<div class="entry-content">
				<div class="mh-box">
					<p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'tuto'); ?></p>
				</div>
				<div class="mh-widget mh-404-search">
					<div class="mh-widget-inner">
						<h4 class="mh-widget-title">
							<span class="mh-widget-title-inner mh-sidebar-widget-title-inner">
								<?php esc_html_e('Search', 'tuto'); ?>
							</span>
						</h4>
						<?php get_search_form(); ?>
					</div>
				</div>
			</div>
			<div class="404-recent-articles mh-widget-col-2"><?php
				$instance = array('title' => esc_html__('Recent Articles', 'tuto'), 'postcount' => '6', 'sticky' => 1);
				$args = array('before_widget' => '<div class="mh-widget"><div class="mh-widget-inner">', 'after_widget' => '</div></div>', 'before_title' => '<h4 class="mh-widget-title"><span class="mh-widget-title-inner mh-sidebar-widget-title-inner">', 'after_title' => '</span></h4>');
				the_widget('tuto_custom_posts_widget', $instance , $args); ?>
			</div>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>