<?php
/**
 * The home template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Madar Lite
 */

get_header(); ?>
<div class="content">
 
					<?php
					if ( have_posts() ) :

						if ( is_home() && ! is_front_page() ) : ?>
                            							<?php
						endif;

						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
							get_template_part( 'template-parts/content', get_post_format() );

						endwhile;
 madarlite_page_nav(); 

 else: 
 get_template_part( 'template-parts/content', 'none' );

 endif; ?>
</div><!-- .content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>