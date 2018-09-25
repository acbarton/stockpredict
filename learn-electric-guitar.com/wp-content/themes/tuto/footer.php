<?php tuto_before_footer(); ?>
<footer class="mh-footer clearfix">
	<?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) { ?>
		<div class="mh-container mh-container-inner clearfix">
			<div class="mh-footer-widgets mh-row clearfix">
				<?php if (is_active_sidebar('footer-1')) { ?>
					<div class="mh-col-1-3 mh-widget-col-1 mh-footer-area mh-footer-1">
						<?php dynamic_sidebar('footer-1'); ?>
					</div>
				<?php } ?>
				<?php if (is_active_sidebar('footer-2')) { ?>
					<div class="mh-col-1-3 mh-widget-col-1 mh-footer-area mh-footer-2">
						<?php dynamic_sidebar('footer-2'); ?>
					</div>
				<?php } ?>
				<?php if (is_active_sidebar('footer-3')) { ?>
					<div class="mh-col-1-3 mh-widget-col-1 mh-footer-area mh-footer-3">
						<?php dynamic_sidebar('footer-3'); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
	<div class="mh-container mh-container-inner mh-subfooter clearfix">
		<?php if (has_nav_menu('tuto_social_nav')) { ?>
			<nav class="mh-social-icons mh-social-nav mh-social-nav-footer clearfix">
				<?php wp_nav_menu(array('theme_location' => 'tuto_social_nav', 'link_before' => '<i class="fa fa-mh-social"></i><span class="screen-reader-text">', 'link_after' => '</span>')); ?>
			</nav>
		<?php } ?>
		<div class="mh-copyright-wrap">
			<span class="mh-copyright">
				<?php printf(__('Proudly powered by Tuto WordPress theme from %1$s', 'tuto'), '<a href="' . esc_url('http://www.mhthemes.com/') . '" rel="nofollow">MH Themes</a>'); ?>
			</span>
		</div>
	</div>
</footer>
<?php tuto_after_footer(); ?>
<?php wp_footer(); ?>
</body>
</html>