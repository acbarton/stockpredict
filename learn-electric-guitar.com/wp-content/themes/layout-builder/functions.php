<?php
/**
 * Functions and definitions
 *
 * @package WordPress
 * @subpackage Layout Builder
 * @since Layout Builder 1.0
*/

/**
 * Layout Builder setup.
 *
 * @since Layout Builder 1.0
 */
 
define( 'SGWINDOWCHILD', 'SGLayout' );
  
function layoutbuilder_setup() {

	$defaults = sgwindow_get_defaults();

	load_child_theme_textdomain( 'layout-builder', get_stylesheet_directory() . '/languages' );
	
	$args = array(
		'default-image'          => get_stylesheet_directory_uri() . '/img/header.jpg',
		'header-text'            => true,
		'default-text-color'     => 'ffffff',
		'width'                  => absint( sgwindow_get_theme_mod( 'size_image' ) ),
		'height'                 => absint( sgwindow_get_theme_mod( 'size_image_height' ) ),
		'flex-height'            => true,
		'flex-width'             => true,
	);
	add_theme_support( 'custom-header', $args );
	
	remove_action( 'sgwindow_empty_sidebar_top-default', 'sgwindow_the_top_sidebar_default', 20 );
	remove_action( 'sgwindow_empty_sidebar_top-portfolio-page', 'sgwindow_the_top_sidebar_default', 20 );
	remove_action( 'sgwindow_empty_sidebar_before_footer-home', 'sgwindow_the_footer_sidebar_widgets', 20 );
	remove_action( 'sgwindow_empty_sidebar_top-home', 'sgwindow_the_top_sidebar_widgets', 20 );
	remove_action( 'sgwindow_empty_column_2-portfolio-page', 'sgwindow_right_sidebar_portfolio', 20 );
	remove_action( 'admin_menu', 'sgwindow_admin_page' );
	remove_action( 'widgets_init', 'sgwindow_register_items_portfolio_widgets' );
	
	if ( '' == sgwindow_get_theme_mod( 'are_we_saved', '' ) ) {
		add_action('sgwindow_empty_sidebar_top-home', 'layoutbuilder_the_top_sidebar_widgets', 20);
	}

}
add_action( 'after_setup_theme', 'layoutbuilder_setup' );

/**
 * Layot BuilderColors.
 *
 * @since Layout Builder 1.0
 */
   
function layoutbuilder_setup_colors() {
	
	/* colors */
	global $sgwindow_colors_class;
	
	$section_id = 'main_colors';
	$section_priority = 10;
	$p = 10;
	
	$i = 'link_color';
	
	$sgwindow_colors_class->add_color($i, $section_id, __('Link', 'layout-builder'), $p++, false);
	$sgwindow_colors_class->set_color($i, 0, '#1e73be');
	$sgwindow_colors_class->set_color($i, 1, '#1e73be');
	$sgwindow_colors_class->set_color($i, 2, '#1e73be');
	
	$i = 'heading_color';
	
	$sgwindow_colors_class->add_color($i, $section_id, __('H1-H6 heading', 'layout-builder'), $p++, false);
	$sgwindow_colors_class->set_color($i, 0, '#000000');
	$sgwindow_colors_class->set_color($i, 1, '#000000');
	$sgwindow_colors_class->set_color($i, 2, '#000000');
	
	$i = 'heading_link';
	
	$sgwindow_colors_class->add_color($i, $section_id, __('H1-H6 Link', 'layout-builder'), $p++, false);
	$sgwindow_colors_class->set_color($i, 0, '#000000');	
	$sgwindow_colors_class->set_color($i, 1, '#000000');	
	$sgwindow_colors_class->set_color($i, 2, '#1e73be');
	
	$i = 'description_color';
	
	$sgwindow_colors_class->add_color($i, $section_id, __('Description', 'layout-builder'), $p++, false);
	$sgwindow_colors_class->set_color($i, 0, '#ededed');	
	$sgwindow_colors_class->set_color($i, 1, '#ededed');	
	$sgwindow_colors_class->set_color($i, 2, '#ededed');	
	
	$i = 'hover_color';
	
	$sgwindow_colors_class->add_color($i, $section_id, __('Link Hover', 'layout-builder'), $p++, false, 'refresh');
	$sgwindow_colors_class->set_color($i, 0, '#000000');
	$sgwindow_colors_class->set_color($i, 1, '#000000');
	$sgwindow_colors_class->set_color($i, 2, '#000000');
}
add_action( 'after_setup_theme', 'layoutbuilder_setup_colors', 100 );

/**
 * Enqueue parent and child scripts
 *
 * @package WordPress
 * @subpackage Layout Builder
 * @since Layout Builder 1.0
*/

function layoutbuilder_styles() {
    wp_enqueue_style( 'sgwindow-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'layoutbuilder-style', get_stylesheet_uri(), array( 'sgwindow-style' ) );
	
	wp_enqueue_style( 'layoutbuilder-colors', get_stylesheet_directory_uri() . '/css/scheme-' . esc_attr( sgwindow_get_theme_mod( 'color_scheme' ) ) . '.css', array( 'sgwindow-style', 'sgwindow-colors' ) );
	
	// Adds JavaScript for handing the navigation menu 
	if ( '1' == sgwindow_get_theme_mod( 'is_sticky_second_menu' ) ) {
		wp_enqueue_script( 'sgwindow-sticky', get_stylesheet_directory_uri() . '/js/sticky.js', array( 'jquery' ), '201531', true );
	}
}
add_action( 'wp_enqueue_scripts', 'layoutbuilder_styles' );

/**
 * Set defaults
 *
 * @package WordPress
 * @subpackage Layout Builder
 * @since Layout Builder 1.0
*/

function layoutbuilder_defaults( $defaults ) {

	/* slider defaults */
	$defaults['slider_height'] = '60';
	$defaults['slider_margin'] = '15';
	$defaults['slider_play'] = '1';
	$defaults['slider_content_type'] = '0';
	$defaults['slider_speed'] = '500';
	$defaults['slider_delay'] = '4000';
	
	$defaults['is_thumbnail_empty_icon'] = '';
	
	$defaults['is_cat'] = '1';
	$defaults['is_author'] = '1';
	$defaults['is_date'] = '1';
	$defaults['is_views'] = '';
	$defaults['is_comments'] = '1';
	$defaults['blog_is_cat'] = '1';
	$defaults['blog_is_author'] = '1';
	$defaults['blog_is_date'] = '1';
	$defaults['blog_is_views'] = '';
	$defaults['blog_is_comments'] = '1';
	$defaults['blog_is_entry_meta'] = '1';

	$defaults['is_sticky_second_menu'] = '1';
	$defaults['site_style'] = 'full';
	$defaults['are_we_saved'] = '';
	$defaults['max_id'] = 0;
	
	$defaults['is_parallax_header'] = '1';

	$defaults['content_style'] = 'boxed';
	
	$defaults['is_show_top_menu'] = '';
	$defaults['is_show_footer_menu'] = '';
	$defaults['body_font'] = 'Alegreya';
	$defaults['heading_font'] = 'Josefin Slab';
	$defaults['header_font'] = 'Allerta Stencil';
	
	$defaults['body_font_size'] = '16';
	$defaults['heading_font_size'] = '36';
	
	$defaults['column_background_url'] = '';
	$defaults['logotype_url'] =  get_stylesheet_directory_uri() . '/img/logo.png';
	$defaults['post_thumbnail_size'] = '400';
	
	$defaults['width_site'] = '1920';
	$defaults['width_top_widget_area'] = '1100';
	$defaults['width_content_no_sidebar'] = '1100';	
	$defaults['width_content'] = '1100';
	$defaults['width_main_wrapper'] = '1100';
	$defaults['is_home_footer'] = '1';
	$defaults['front_page_style'] = 'no_content';
	
	/* portfolio: excerpt/content */
	$defaults['portfolio_style'] = 'no_content';
	
	/* Header Image size */
	$defaults['size_image'] = '1920';
	$defaults['size_image_height'] = '600';
	/* Header Image and top sidebar wrapper */
	$defaults['width_image'] = '1920';
		
	$defaults['width_column_1_left_rate'] = '33';
	$defaults['width_column_1_right_rate'] = '33';
	$defaults['width_column_1_rate'] = '22';
	$defaults['width_column_2_rate'] = '22';
	
	$defaults['scroll_button'] = 'right';
	
	$defaults['single_style'] = 'content';

	$defaults['defined_sidebars']['home'] = array(
											'use' => '1', 
											'callback' => 'is_front_page', 
											'param' => '', 
											'title' => __( 'Home', 'layout-builder' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '1',
											'column-1' => '1',
											'column-2' => '1', 
											);

	$defaults['footer_text'] = '<a href="' . __( 'http://wordpress.org/', 'layout-builder' ) . '">' . __( 'Powered by WordPress', 'layout-builder' ). '</a> | ' . __( 'theme ', 'layout-builder' ) . '<a href="' .  __( 'http://wpblogs.ru/themes/blog/theme/layout-builder/', 'layout-builder') . '">Layout Builder</a>';
	
	return $defaults;

}
add_filter( 'sgwindow_option_defaults', 'layoutbuilder_defaults' );

/** Set theme layout
 *
 * @since Layout Builder 1.0
 */
function layoutbuilder_layout( $layout ) {
	
	foreach( $layout as $id => $layouts ) {
		if ( 'layout_home' == $layouts['name'] ) {

			$layout[ $id ]['val'] = 'left-sidebar';
			
		}
		if ( 'layout_home' == $layouts['name'] || 'layout_blog' == $layouts['name'] || 'layout_archive' == $layouts['name'] ) {

			$layout[ $id ]['content_val'] = 'default';
			
		}	
	}
	return $layout;
}
add_filter( 'sgwindow_layout', 'layoutbuilder_layout' );

/**
 * Hook widgets into right sidebar at the front page
 *
 * @package WordPress
 * @subpackage Layout Builder
 * @since Layout Builder 1.0
*/

function layoutbuilder_home_right_column( $layouts ) {

	the_widget( 'WP_Widget_Search', 'title=' );
	the_widget( 'WP_Widget_Categories' );
	the_widget( 'WP_Widget_Tag_Cloud', 'title=' );
	the_widget( 'WP_Widget_Recent_Comments' );
	
}
add_action('sgwindow_empty_column_2-home', 'layoutbuilder_home_right_column', 20);
/**
 * Add widgets to the top sidebar on the home page
 *
 * @since Layout Builder 1.0.0
 */
function layoutbuilder_the_top_sidebar_widgets() {
	
	the_widget( 'sgwindow_side_bar', 'title='.__('Layout 1', 'layout-builder').
								'&count=4'.
								'&width_0=25'.
								'&width_1=25'.
								'&width_2=25'.
								'&width_3=25'.
								'&sidebar_id_0=0'.
								'&sidebar_id_1=1'.
								'&sidebar_id_2=2'.
								'&sidebar_id_3=3'
		);
		
	the_widget( 'sgwindow_side_bar', 'title='.__('Layout 2', 'layout-builder').
								'&count=2'.
								'&width_0=30'.
								'&width_1=70'.
								'&sidebar_id_0=0'.
								'&sidebar_id_1=1'
		);

}

/**
 * Register Sidebar
 *
 * @since SG Layout 1.0.0
 */
function layoutbuilder_register_sidebars() {
	
	for( $i = 0; $i < 6; $i++) {
		register_sidebar( array(
			'name' => __( 'Top', 'layout-builder' ) . ' ' . ( $i + 1),
			'id' => 's_' . $i,
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}
			
}
add_action( 'widgets_init', 'layoutbuilder_register_sidebars', 20 );
/**
 * Header
 *
 * @package WordPress
 * @subpackage Layout Builder
 * @since Layout Builder 1.0
*/

function layoutbuilder_header( $layouts ) {

?>
	<div id="sg-site-header" class="sg-site-header">
		<div class="menu-top">
			<!-- First Top Menu -->
			<div class="nav-container top-1-navigation">
				<div class="max-width">
					<?php if ( sgwindow_get_theme_mod( 'is_show_top_menu' ) == '1' ) : ?>
						<nav class="horisontal-navigation menu-1" role="navigation">
							<span class="toggle"><span class="menu-toggle"></span></span>
							<?php wp_nav_menu( array( 'theme_location' => 'top1', 'menu_class' => 'nav-horizontal' ) ); ?>
						</nav><!-- .menu-1 .horisontal-navigation -->
					<?php endif; ?>
					<div class="clear"></div>
				</div><!-- .max-width -->
			</div><!-- .top-1-navigation .nav-container -->
			
			<?php if ( get_header_image() 
				&& ( sgwindow_get_theme_mod( 'is_header_on_front_page_only' ) != '1' || is_front_page())) : ?>		
		
				<div class="sg-site-header-1 my-image widget">
					<?php if ( '1' == sgwindow_get_theme_mod( 'is_parallax_header' ) ) : ?>
					
						<div class="parallax-image <?php echo esc_attr( sgwindow_get_theme_mod( 'parallax_image_speed' ) ); ?> 0 0" style="background-image: url(<?php header_image(); ?>);">
						<div class="head-wrapper"></div>
						</div><!-- .parallax-image -->
						
					<?php else: ?>

						<div class="parallax-image 0 0 0" style="background-image: url(<?php header_image(); ?>);">
						<div class="head-wrapper"></div>
						</div><!-- .parallax-image -->
						
					<?php endif; ?>
													
					<div class="max-header-width">
					
						<?php if ( '' != sgwindow_get_theme_mod( 'logotype_url' ) ) : ?>
							<div class="logo-block">
								<a class="logo-section" href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>
									<img src='<?php echo esc_url( sgwindow_get_theme_mod( 'logotype_url' ) ); ?>' class="logo" alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
								</a><!-- .logo-section -->
							</div><!-- .logo-block -->
						<?php endif; ?>
						
						<div class="site-title">
							<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						</div><!-- .site-title -->
						<!-- Dscription -->
						<div class="site-description">
							<h2><?php echo bloginfo( 'description' ); ?></h2>
						</div><!-- .site-description -->
						
						<?php do_action( 'sgwindow_after_title' ); ?>
					
					</div><!-- .max-width -->
				</div><!-- .sg-site-header-1 -->
			
			<?php endif; ?>

			<!-- Second Top Menu -->	
			<?php if ( '1' == sgwindow_get_theme_mod( 'is_show_secont_top_menu') ) : ?>

				<div class="nav-container top-navigation">
					<div class="max-width">

						<nav class="horisontal-navigation menu-2" role="navigation">
							<?php if ( '' != sgwindow_get_theme_mod( 'logotype_url' ) ) : ?>
								<a class="small-logo" href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>
									<img src='<?php echo esc_url( sgwindow_get_theme_mod( 'logotype_url' ) ); ?>' class="menu-logo" alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
								</a><!-- .small-logo -->
							<?php endif; ?>	
							<span class="toggle"><span class="menu-toggle"></span></span>
							<?php wp_nav_menu( array( 'theme_location' => 'top2', 'menu_class' => 'nav-horizontal' ) ); ?>
						</nav><!-- .menu-2 .horisontal-navigation -->
						<div class="clear"></div>
					</div><!-- .max-width -->
				</div><!-- .top-navigation.nav-container -->
				
			<?php endif; ?>
		</div><!-- .menu-top  -->
	</div><!-- .sg-site-header -->
	
<?php
}
add_action('sgwindow_header_menu', 'layoutbuilder_header', 20);

/**
 * Hook widgets into right sidebar at the front page
 *
 * @package WordPress
 * @subpackage Layout Builder
 * @since Layout Builder 1.0
*/

function layoutbuilder_home_left_column( $layouts ) {

	the_widget( 'WP_Widget_Search', 'title=' );
	the_widget( 'WP_Widget_Categories' );
	the_widget( 'WP_Widget_Tag_Cloud', 'title=' );
	the_widget( 'WP_Widget_Recent_Comments' );
	
}
add_action('sgwindow_empty_column_1-home', 'layoutbuilder_home_left_column', 20);

/**
 * Add widgets to the right sidebar on portfolio pages
 *
 * @since Layout Builder 1.0
 */
function layoutbuilder_right_sidebar_portfolio() {

	the_widget( 'sgwindow_portfolio', 'title='.__('Recent Projects', 'layout-builder').
								'&count=8'.
								'&jetpack-portfolio-type=0'.
								'&columns=column-2'.
								'&is_background=1'.
								'&is_margin_0=1'.
								'&is_link=1'.
								'&effect_id_0=effect-1');
}
add_action('sgwindow_empty_column_2-portfolio-page', 'layoutbuilder_right_sidebar_portfolio', 20);

 /**
 * Add custom styles to the header.
 *
 * @since Layout Builder1.0.0
*/
function layoutbuilder_hook_css() {

?>
	<style type="text/css"> 
	
		.site .wide .widget.widget_text > div {
			max-width: <?php echo esc_attr(sgwindow_get_theme_mod('width_main_wrapper')); ?>px;
		}
	
		.logo-block,
		.max-header-width,
		.max-width,
		.sidebar-footer-content,
		.horisontal-navigation {
			max-width: <?php echo esc_attr(sgwindow_get_theme_mod('width_main_wrapper')); ?>px;
		}
		

		.wide .widget.sgwindow_slider {
			max-width: <?php echo esc_attr( sgwindow_get_theme_mod('width_main_wrapper') - 2 ); ?>px;
		}
		
		.widget.sgwindow_slider .widget-title,
		.widget.sgwindow_slider .widgettitle,
		.wide .widget.sgwindow_side_bar .widget-title,
		.wide .widget.sgwindow_side_bar .widgettitle {
			max-width: <?php echo esc_attr( sgwindow_get_theme_mod('width_main_wrapper') - 2 ); ?>px;
		}
		
		#page .my-image {
			height: <?php echo esc_attr( sgwindow_get_theme_mod( 'parallax_image_height' )/4 ); ?>px;
		}
		
		<?php if( sgwindow_get_theme_mod( 'is_header_on_front_page_only' ) == '1' && ! is_front_page() || ( is_front_page() && ! get_header_image() )  ) : ?>
			/* menu logo */
			#page .small-logo {
				opacity: 1;
			}
		<?php endif ?>		

		@media screen and (min-width: <?php echo esc_attr( (sgwindow_get_theme_mod( 'width_mobile_switch' ) + 40)/2 ); ?>px) {	
			#page .my-image {
				height: <?php echo esc_attr( sgwindow_get_theme_mod( 'parallax_image_height' )/2 ); ?>px;
			}
			
			#page .logo-section img {
				max-width: 100px;
			}
		}
		
		@media screen and (min-width: <?php echo esc_attr( (sgwindow_get_theme_mod( 'width_main_wrapper' ) + 40)/1.5 ); ?>px) {	
			#page .my-image {
				height: <?php echo esc_attr( sgwindow_get_theme_mod( 'parallax_image_height' ) ); ?>px;
			}
		}
		
		@media screen and (min-width: <?php echo esc_attr( sgwindow_get_theme_mod( 'width_main_wrapper' )) + 40; ?>px) {	

			.wide .widget.sgwindow_side_bar .widget-title,
			.wide .widget.sgwindow_side_bar .widgettitle,
			.max-width,
			.max-header-width {
				margin: 0 auto;
			}
			
			#page .site-title a {
				font-size: 64px;
			}
			
		}
		
		@media screen and (min-width: <?php echo esc_attr( sgwindow_get_theme_mod( 'width_mobile_switch' ) ); ?>px) {	
			
			.wide .widget {
				border-left: none;
				border-right: none;	
			}
			/* footer */
			
			.sidebar-footer-content {
					
				-webkit-flex-flow: nowrap;
				-ms-flex-flow: nowrap;
				flex-flow: nowrap;
				
				margin: 40px auto;
			}
			
			#page .sidebar-footer .widget .widgettitle:after,
			#page .sidebar-footer .widget .widget-title:after,
			#page .sidebar-footer .widget .widgettitle:before,
			#page .sidebar-footer .widget .widget-title:before {
				margin: 0;
			}
			
			/* widget-sidebar */
			.sidebar-footer-content,
			.site .widget-sidebar-wrapper {

				-webkit-flex-flow: nowrap;
				-ms-flex-flow: nowrap;
				flex-flow: nowrap;

			}
			
			#page .my-sidebar-layout {
				margin: 0 2px 0 2px;
			}
			
			#page .sidebar-1 {
				margin: 0 4px 0 0;
			}

			#page .sidebar-2 {
				margin: 0 0 0 4px;
			}
			
		}
		
		@media screen and (min-width: <?php echo esc_attr( sgwindow_get_theme_mod( 'width_main_wrapper' ) ); ?>px) {
			
			/* image widget */

			.wide .small.flex-column-2 .column-4 .element .entry-title,
			.wide .small.flex-column-2 .column-4 .element p,
			.wide .small.flex-column-2 .column-4 .element a,
			.wide .small.flex-column-2 .column-3 .element .entry-title,
			.wide .small.flex-column-2 .column-3 .element p,
			.wide .small.flex-column-2 .column-3 .element a {
				font-size: 14px;
			}
			
			.wide .small.flex-column-2 .column-2 .element .entry-title,
			.wide .small.flex-column-2 .column-1 .element .entry-title {
				display: block;
				font-size: 14px;
			}

			.wide .small.flex-column-2 .column-2 .element p,
			.wide .small.flex-column-2 .column-2 .element a,
			.wide .small.flex-column-2 .column-1 .element p,
			.wide .small.flex-column-2 .column-1 .element a {
				display: block;
				font-size: 14px;
			}
			
			.wide .small.flex-column-4 .column-2 .element .entry-title,
			.wide .small.flex-column-4 .column-1 .element .entry-title,
			.wide .small.flex-column-3 .column-2 .element .entry-title,
			.wide .small.flex-column-3 .column-2 .element .entry-title,
			.wide .small.flex-column-2 .column-2 .element .entry-title,
			.wide .small.flex-column-2 .column-1 .element .entry-title {
				display: block;
				font-size: 14px;
			}

			.wide .small.flex-column-4 .column-2 .element p,
			.wide .small.flex-column-4 .column-1 .element p,
			.wide .small.flex-column-3 .column-2 .element p,
			.wide .small.flex-column-3 .column-1 .element p {
				display: block;
				font-size: 12px;
			}
			
			.wide .small.flex-column-1 .column-4 .element .entry-title,
			.wide .small.flex-column-1 .column-3 .element .entry-title,
			.wide .small.flex-column-1 .column-4 .element .link,
			.wide .small.flex-column-1 .column-3 .element .link,
			.wide .small.flex-column-1 .column-4 .element p,
			.wide .small.flex-column-1 .column-3 .element p {
				font-size: 16px;
			}
			
			.wide .small.flex-column-1 .column-2 .element .entry-title,
			.wide .small.flex-column-1 .column-1 .element .entry-title,
			.wide .small.flex-column-1 .column-2 .element .link,
			.wide .small.flex-column-1 .column-1 .element .link,
			.wide .small.flex-column-1 .column-2 .element p,
			.wide .small.flex-column-1 .column-1 .element p {
				font-size: 18px;
			}
						
		}
		
	</style>
	<?php
}
add_action('wp_head', 'layoutbuilder_hook_css');

 /**
 * Create customizer control
 *
 * @since Layout Builder 1.0.0
*/
add_action( 'customize_register', 'layoutbuilder_create_controls', 999 );
function layoutbuilder_create_controls( $wp_customize ) {

	$wp_customize->add_section( 'check', array(
		'title'          => __( '--', 'layout-builder' ),
		'priority'       => 200,
		'panel'  => 'other',
	) );
	
	if ( '' == sgwindow_get_theme_mod( 'are_we_saved', '' ) ) {
	
		$wp_customize->add_setting( 'are_we_saved', array(
			'type'			 => 'theme_mod',
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sgwindow_sanitize_checkbox'
		) );

		$wp_customize->add_control( 'are_we_saved', array (
			'label'      => __( '--', 'layout-builder' ),
			'section'    => 'check',
			'settings'   => 'are_we_saved',
			'type'       => 'checkbox',
			'priority'   => 1,
		) );

	}
	
	$wp_customize->add_setting( 'max_id', array(
		'type'			 => 'theme_mod',
		'default'        => '0',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'max_id', array (
		'label'      => __( 'Max id', 'layout-builder' ),
		'section'    => 'check',
		'settings'   => 'max_id',
		'type'       => 'input',
	) );
	
	/* remove controls */
	$wp_customize->remove_control( 'is_show_top_menu' );
	$wp_customize->remove_control( 'is_show_footer_menu' );

}
 /**
 * Add custom js for the Customizer screen.
 *
 * @since Layout Builder 1.0.0
*/
function layoutbuilder_customize_controls_enqueue_scripts() {

	wp_enqueue_script( 'layoutbuilder-customize-control-js', get_stylesheet_directory_uri() . '/inc/js/customize.js', array( 'jquery' ), false, true );
	
}
add_action('customize_controls_enqueue_scripts', 'layoutbuilder_customize_controls_enqueue_scripts');

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Layout Builder 1.0.0
 */
function layoutbuilder_customize_preview_js() {
	wp_enqueue_script( 'layoutbuilder-customizer', get_stylesheet_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), time() . '11.12.2020', true );
}
add_action( 'customize_preview_init', 'layoutbuilder_customize_preview_js', 99 );

//admin page
require get_stylesheet_directory() . '/inc/admin-page.php';
//widget-sidebar
if( ! class_exists( 'sgwindow_side_bar' ) ) {
	require get_stylesheet_directory() . '/inc/widget-sidebar.php';
}
//portfolio
if( class_exists( 'Jetpack' ) && ! class_exists( 'sgwindow_portfolio' ) ) {
	require get_stylesheet_directory() . '/inc/widget-featured-portfolio.php';
}