<?php 
/* 	Madar Lite's Index Page to Show Blog Posts

*/
get_header(); ?>
<div class="content">
 
					<?php
					if ( have_posts() ) :

						/* Start the Loop */
						while ( have_posts() ) : the_post(); ?>
                            <?php
							/*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
							get_template_part( 'template-parts/content', get_post_format() );?>

 <?php endwhile; madarlite_page_nav(); 

 else: 
 get_template_part( 'template-parts/content', 'none' );

 endif; ?>
</div><!-- .content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>