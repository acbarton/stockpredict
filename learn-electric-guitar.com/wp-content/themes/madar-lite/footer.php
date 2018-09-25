	<div class="clearfix"></div>
	</div><!-- #main-content -->
	</div><!-- Box -->
	<div class="clearfix"></div>
	<footer>
	<?php if ( get_theme_mod('gototop_enable') ) : ?>
		<p id="back-top">
			<a href="#top"><span class="arrow" ></span></a>
		</p>	
	<?php endif; ?>
		<div class="footer-border-top">	
			<div id="footer-container" role="complementary">
				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<div id="footer-first" class="footer-widgets">
					<?php dynamic_sidebar( 'footer-1'); ?>
					</div>
				<?php endif; ?>
			<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
				<div id="footer-second" class="footer-widgets" >
					<?php dynamic_sidebar( 'footer-2'); ?>
				</div>
			<?php endif; ?>				
			<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
				<div id="footer-third" class="footer-widgets">
					<?php dynamic_sidebar( 'footer-3'); ?>
				</div>
			<?php endif; ?>	
			<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
				<div id="footer-fourth" class="footer-widgets">
					<?php dynamic_sidebar( 'footer-4'); ?>
				</div>
			<?php endif; ?>	
				<div class="clearfix"></div>	
			</div>
		</div>
		<div class="footer-border-bottom">	
			<div class="footer-bottom">	
				<a class="simple-button switch-button" href="<?php echo esc_url( home_url( '/' ) ) . '/?device=desktop'; ?>"><?php _e('Switch to Desktop', 'madar-lite'); ?></a>
				<div class="left">
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'madar-lite' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'madar-lite' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %2$s by %1$s.', 'madar-lite' ), 'Retina Theme', '<a href="http://retina-theme.com/" rel="designer">Madar Lite</a>' ); ?>
				</div>
			  <div class="clearfix"></div>
			</div>
		</div>

	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>