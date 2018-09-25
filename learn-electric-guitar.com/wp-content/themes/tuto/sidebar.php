<aside class="mh-widget-col-1 mh-sidebar"><?php
	if (is_active_sidebar('sidebar')) {
		dynamic_sidebar('sidebar');
	} else { ?>
		<div class="mh-widget mh-sidebar-empty">
			<div class="mh-widget-inner">
				<h4 class="mh-widget-title">
					<span class="mh-widget-title-inner mh-sidebar-widget-title-inner">
						<?php esc_html_e('Sidebar', 'tuto') ?>
					</span>
				</h4>
				<div class="textwidget">
					<?php printf(esc_html__('Please navigate to %1s in your WordPress dashboard and add some widgets into the %1s widget area.', 'tuto'), '<strong>' . __('Appearance &#8594; Widgets', 'tuto') . '</strong>', '<em>' . esc_html__('Sidebar', 'tuto') . '</em>'); ?>
				</div>
			</div>
		</div><?php
	} ?>
</aside>