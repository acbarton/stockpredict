<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>	
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php /* used for accessibility, particularly for screen reader applications */ ?>
	<div class="none">
		<p><a href="#main-content screen-reader-text"><?php _e('Skip to Content', 'madar-lite'); ?></a></p>
	</div>
	<?php //Set homepage size (boxed-full page)
		$pagesize = get_theme_mod('homepage_base');
		if ($pagesize == 'boxed') {
			$cols = 'boxed';
		} elseif ($pagesize == 'full') {
			$cols = 'full';
		} else {
			$cols = 'boxed';
		}
	?>
	<div id="<?php echo $cols; ?>" class="wrapper">
     <?php get_template_part( 'template-parts/topheader' ); ?>
	<div class="box">
	<header>
		<?php /* Title/Logo Section */ ?>
		<div id="title" class="header-container">
		<?php if ( get_theme_mod('site_logo') ) : ?>
		            <div class="logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo('name'); ?>"><img class="site-logo" src="<?php echo esc_url(get_theme_mod('site_logo')); ?>" alt="<?php bloginfo('name'); ?>" /></a>
					</div>
				        <?php else : ?>
				          <div class="logo-text">
                            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				          </div>        
				        <?php endif; ?>			
			<?php if ( get_theme_mod('topbanner_enable') ) : ?>			
  			<div class="top-banner">
				<a href="<?php echo esc_url(get_theme_mod('topbanner_url')); ?>"><img src="<?php echo esc_url(get_theme_mod('topbanner_img')); ?>"  alt=""/>
				</a>
			</div>
			<?php endif; ?>
		<div class="clearfix"></div>
		</div>

		<?php /* Main Menu Section */ ?>
		<div id="main-navigation-wrap" class="primary-navigation-wrap fixed-enabled">
				<nav id="main-navigation" class="primary-navigation navigation container clearfix" role="navigation">
					<?php 
						// Display Main Navigation
						wp_nav_menu( array(
							'theme_location' => 'header-menu', 
							'container' => false, 
							'menu_class' => 'main-navigation-menu', 
							'echo' => true, 
							'fallback_cb' => 'madarlite_nav_fallback')
						);
					?>
				</nav><!-- #main-navigation -->
		<div class="clearfix"></div>
		</div>
	<div class="clearfix"></div>
	</header>
<div id="main-content" class="container">