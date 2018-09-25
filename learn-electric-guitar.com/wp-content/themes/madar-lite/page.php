<?php 
get_header();?>
		<div class="content">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post();  ?>
        <?php get_template_part( 'template-parts/content', 'page' ); ?>
			    <?php 
				comments_template( '', true );
			endwhile; /* end loop */ ?>
		</div><!-- #content# -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>