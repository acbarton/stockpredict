<!DOCTYPE html>
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">
	<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?> >
        <header class="cb-header">
            <div class="cb-top-bar">
                <div class="container-fluid">
                    <div class="cb-menu-toggle">
                    <i class="fa fa-bars"></i><i class="fa fa-times"></i>
                    </div>
					<?php if ( has_nav_menu( 'primary' ) ):  
                              $menuargs = array(
                              'theme_location'  => 'primary',
                              'menu'            => 'primary',
                              'container'       => 'nav',
                              'container_class' => 'cb-nav',
                              'menu_class'      => 'menu'
                              );
                              wp_nav_menu( $menuargs );
                          else:
                            _e('Set Primary menu by going to Appearance > Menus','cleanblogg');
                          endif;
                    ?>
            		<?php if (get_theme_mod( 'cleanblog_show_search')!= "hide" ): ?>
                        <div class="cb-top-search-btn">
                            <i class="fa fa-search"></i>
                        </div>
                        <div class="cb-top-search-form">
                            <?php get_search_form(); ?>
                        </div><?php  endif; ?> <!-- Header Social -->
						<?php 
                        $cb_fb = get_theme_mod( 'cleanblog_fb');
                        $cb_twitter = get_theme_mod( 'cleanblog_twitter');
                        $cb_googleplus = get_theme_mod( 'cleanblog_googleplus');
                        $cb_instagram = get_theme_mod( 'cleanblog_instagram');
                        $cb_pinterest = get_theme_mod( 'cleanblog_pinterest');
                        $cb_rss = get_theme_mod( 'cleanblog_rss');
                        ?>
            			<?php if (get_theme_mod( 'cleanblog_social_in_header')!= "hide" ): ?>
                            <div class="cb-top-social">
                                <?php if ($cb_fb != "" ){ ?><a href="<?php echo esc_url($cb_fb); ?>" target="_blank"><i class="fa fa-facebook"></i></a> <?php } ?>
                                <?php if ($cb_twitter!= "" ){ ?><a href="<?php echo esc_url($cb_twitter); ?>" target="_blank"><i class="fa fa-twitter"></i></a><?php } ?>
                                <?php if ($cb_googleplus != "" ){ ?><a href="<?php echo esc_url($cb_googleplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a><?php } ?>
                                <?php if ($cb_instagram != "" ){ ?><a href="<?php echo esc_url($cb_instagram); ?>" target="_blank"><i class="fa fa-instagram"></i></a><?php } ?>
                                <?php if ($cb_pinterest != "" ){ ?><a href="<?php echo esc_url($cb_pinterest); ?>" target="_blank"><i class="fa fa-pinterest-p"></i></a><?php } ?>
                                <?php if ($cb_rss != "" ){ ?><a href="<?php echo esc_url($cb_rss); ?>" target="_blank"><i class="fa fa-rss"></i></a><?php } ?>
                            </div>
						<?php endif; ?> <!-- Header Social -->
            
				</div>
			</div><!-- top bar -->
    		<div class="cb-logo">
    		<?php if ( is_home()): ?>
    			<h1 class="cb-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php if (get_theme_mod( 'cleanblog_logo' )!= "" ){ ?><img src="<?php echo get_theme_mod( 'cleanblog_logo' ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>"><?php } else {?><?php bloginfo('name'); ?><?php } ?></a></h1>
        		<h2 class="cb-tagline"><?php bloginfo('description'); ?></h2>
    		<?php else:?>
    		<h2 class="cb-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php if (get_theme_mod( 'cleanblog_logo' )!= "" ){ ?><img src="<?php echo get_theme_mod( 'cleanblog_logo' ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>"><?php } else {?><?php bloginfo('name'); ?><?php } ?></a></h2>
        	<h3 class="cb-tagline"><?php bloginfo('description'); ?></h3>
			<?php endif;?>
    		</div>
		</header><!-- header -->
		<?php if ( is_home()): ?>
		<?php if (get_theme_mod( 'cleanblog_slider_show')!= "hide" ): ?>
      	<?php
			$post_orderby = get_theme_mod( 'cleanblog_slider_posts', 'date');
			$posts_num = get_theme_mod( 'cleanblog_slider_posts_num', '10');
			$args = array( 
			'post_type' => 'post',
			'orderby' => $post_orderby,
			'order'   => 'DESC',
			'posts_per_page'=> $posts_num,
			);	   
			$the_query = new WP_Query( $args ); 
			if ( $the_query->have_posts() ) : ?>
              <section class="cb-slider">
                  <div class="container-fluid">
                    <ul>
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
							$image_id = get_post_thumbnail_id();
							$post_image_url = wp_get_attachment_image_src($image_id,'large', true); ?>
                          <li>
                              <div class="cb-slider-block" style="background-image:url('<?php echo $post_image_url[0]; ?>');">
                                  <div class="cb-slider-inner">
                                      <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                                      <span class="cb-slider-date"><?php echo get_the_date(); ?></span>
                                      <a href="<?php the_permalink(); ?>" class="cb-more"><?php echo __( 'Read More','cleanblogg' ); ?></a>
                                  </div>
                              </div>
                            </li>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
                    </ul>
                  </div>
              </section><!-- slider -->
			<?php endif; ?>
		<?php endif;?>
        <?php endif;?>