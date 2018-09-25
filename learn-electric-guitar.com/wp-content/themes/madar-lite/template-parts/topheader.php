	<?php if ( get_theme_mod('topmenu_enable') ) : ?>
	<div class="top-container">
		<div class="top-wrap">
			<nav id="top-nav" class="top-navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'top-menu', 'menu_class' => 'top-menu','fallback_cb' => 'madarlite_nav_fallback' ) ); ?>
			</nav>
            <div class="date-header"><?php echo date('l, F jS, Y') ?></div>
			<a class="nav-box random" href="<?php echo esc_url(home_url() ) . '/?madarliterand=1'; ?>" title="Random Post" ><i class="fa fa-random"></i></a>
			   <div class="social-icons">
                     
                    <?php if ( '' !== get_theme_mod( 'rss_link' ) ) { ?>
		            <a href="<?php echo esc_url(get_theme_mod('rss_link','#feed')); ?>"title="RSS Feed">
						<i class="fa fa-rss"></i>
					</a>
                    <?php } ?>
                    <?php if ( '' !== get_theme_mod( 'fb_link' ) ) { ?>
					<a href="<?php echo esc_url(get_theme_mod('fb_link','#facebook')); ?>"title="Facebook">
						<i class="fa fa-facebook"></i>
					</a>
                    <?php } ?>   
                     <?php if ( '' !== get_theme_mod( 'twitt_link' ) ) { ?>
					<a href="<?php echo esc_url(get_theme_mod('twitt_link','#twitter')); ?>"title="Twitter">
						<i class="fa fa-twitter"></i>
					</a>
                     <?php } ?> 
                    <?php if ( '' !== get_theme_mod('gplus_link') ) { ?>
					<a href="<?php echo esc_url(get_theme_mod('gplus_link','#gplus')); ?>"title="Google+">
						<i class="fa fa-google-plus"></i>					
					</a>
                     <?php } ?>
                     <?php if ( '' !== get_theme_mod('pinterest_link') ) { ?>
					<a href="<?php echo esc_url(get_theme_mod('pinterest_link','#pinterest')); ?>"title="Pinterest">
						<i class="fa fa-pinterest"></i>					
					</a>
                     <?php } ?>
                    <?php if ( '' !== get_theme_mod('youtube_link') ) { ?>
					<a href="<?php echo esc_url(get_theme_mod('youtube_link','#youtube')); ?>"title="Youtube">
						<i class="fa fa-youtube"></i>						
				    </a>
                     <?php } ?> 
		     </div>
			
		<div class="clearfix"></div>
		</div>
	</div>
 <?php endif; ?>