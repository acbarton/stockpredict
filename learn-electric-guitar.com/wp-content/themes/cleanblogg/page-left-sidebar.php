<?php
	/* Template Name: Left Sidebar Page */
?>
<?php get_header(); ?>
<div class="cb-content cb-left"> 
	<div class="container-fluid">
    	<div class="row">
            <div class="cb-main col-md-8">
			<?php if ( have_posts() ) : 
					while ( have_posts() ) : the_post();
						get_template_part( 'content','page');
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
				  	endwhile;
 				  endif; ?>
        	</div>
            <div class="cb-side-bar col-sm-4">
        		<?php get_sidebar(); ?>
        	</div>
        </div>
    </div>	
</div>
<?php get_footer(); ?>