<?php

/**
 * Add menu to Appearance screen
 *
 * @since SG Simple 1.0
 */
function layoutbuilder_admin_page() {
	add_theme_page( __( 'About theme', 'layout-builder' ), __( 'About SG Simple', 'layout-builder' ), 'edit_theme_options', 'layoutbuilder-page', 'layoutbuilder_about_page');
}
add_action( 'admin_menu', 'layoutbuilder_admin_page' );
 
 /**
 * Add css styles for admin page
 *
 * @since SG Simple 1.0.1
 */
function layoutbuilder_admim_style( $hook ) {
	if ( 'appearance_page_layoutbuilder-page' != $hook ) {
		return;
	}
	wp_enqueue_style( 'layoutbuilder-admin-page-style', get_stylesheet_directory_uri() . '/inc/css/admin-page.css', array(), null );
	wp_enqueue_style( 'layoutbuilder-admin-fonts', '//fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&#038;subset=latin%2Clatin-ext&#038', array(), null );
	
}
add_action( 'admin_enqueue_scripts', 'layoutbuilder_admim_style' );

/**
 * About theme page
 *
 * @since SG Simple 1.0
 */
function layoutbuilder_about_page() {
?>
	<div class="main-wrapper">
		<p class="sg-header"><?php esc_html_e( 'Main Info', 'layout-builder' ); ?></p>
		<ul class="sg-buttons">
			<li><a href="<?php echo esc_url( home_url() . '/wp-admin/customize.php' ); ?>"><?php esc_html_e( 'Theme Options', 'layout-builder' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url() .  '/wp-admin/customize.php?autofocus[panel]=widgets' ); ?>"><?php esc_html_e( 'Widgets', 'layout-builder' ); ?></a></li>
			<li><a href="<?php echo __( 'http://wpblogs.ru/themes/how-to-video-sg-window-theme/', 'layout-builder' ); ?>"><?php esc_html_e( 'How to use a theme (Video)', 'layout-builder' ); ?></a></li>
			<li><a href="<?php echo esc_url( 'https://wordpress.org/support/theme/layout-builder' ); ?>"><?php esc_html_e( 'Support forum', 'layout-builder' ); ?></a></li>
			<li><a href="<?php echo esc_url( 'https://wordpress.org/support/view/theme-reviews/layout-builder#postform' ); ?>"><?php esc_html_e( 'Rate on WordPress.org', 'layout-builder' ); ?></a></li>
			<?php if ( ! defined ( 'layout-builder' ) ) : ?>
			<li class="pro"><a href="<?php echo esc_url( 'http://wpblogs.ru/themes/sg-window-pro/' ); ?>"><?php esc_html_e( 'Update to Pro', 'layout-builder' ); ?></a></li>
			<?php endif; ?>
			</li>
		</ul>
		<div class="info-wrapper">
			<div class="icon-image">
				<img src="<?php echo get_stylesheet_directory_uri() . '/screenshot.png'; ?>"/>
			</div><!-- .icon-image -->
			<div class="info">
			<?php if ( ! defined ( 'layout-builder' ) ) : ?>
				<p><?php esc_html_e( 'You are using light version of SG Simple. Update to Pro to have even more features. For Example:', 'layout-builder' ); ?></p>
				<ul>
					<li><?php esc_html_e( 'Custom colors;', 'layout-builder' ); ?></li>
					<li><?php esc_html_e( 'Site/content width;', 'layout-builder' ); ?></li>
					<li><?php esc_html_e( 'Boxed/Full width layout;', 'layout-builder' ); ?></li>
					<li><?php esc_html_e( 'WooCommerce layouts;', 'layout-builder' ); ?></li>
					<li><?php esc_html_e( 'Footer text options.', 'layout-builder' ); ?></li>
				</ul>
			<?php else: 

			do_action( 'sgwindow_pro_version' ); 
			
			endif; ?>

			</div><!-- .info -->
			
		</div><!-- .info-wrapper -->
		<div class="more-info">
			<a href="<?php echo esc_url( 'http://wpblogs.ru/themes/sg-window-pro/' ); ?>"><?php esc_html_e( 'More Info', 'layout-builder' ); ?></a>
		</div><!-- .more-info -->
		
		<a alt="" href="http://wpblogs.ru/themes/blog/theme/sg-window/"><p class="parent-text"><?php esc_html_e( 'Parent theme', 'layout-builder' ); ?></p></a>
		<a  class="parent-img" alt="" href="http://wpblogs.ru/themes/blog/theme/sg-window/"><img src="<?php echo get_template_directory_uri() . '/screenshot.png'; ?>"/></a>

	</div><!-- .main-wrapper -->
<?php
}