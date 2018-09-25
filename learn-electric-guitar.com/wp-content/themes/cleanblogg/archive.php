<?php get_header(); ?>
<?php $content_layout= get_theme_mod( 'cleanblog_content_layout', 'right'); ?>
<div class="cb-content <?php echo 'cb-'.$content_layout; ?>">
	<div class="container-fluid">
    	<div class="row">
    		<div class="cb-main <?php if($content_layout == 'full'){echo 'col-sm-12';} else {echo 'col-md-8';}?>">
				<div class="archive-title">
					<?php if ( is_day() ) : ?>
					<h1>
                    	<span><?php echo __( 'Daily Archives :',  'cleanblogg' );?></span>
						<?php printf( __( '%s',  'cleanblogg' ), get_the_date() );?> 
                    </h1>
					<?php elseif ( is_month() ) : ?>
					<h1>
                		<span><?php echo __( 'Monthly Archives :',  'cleanblogg' ); ?></span>
						<?php printf( __( '%s',  'cleanblogg' ), get_the_date( _x( 'F Y', 'monthly archives date format',  'cleanblogg' ) ) ); ?> 
                	</h1>
					<?php elseif ( is_year() ) : ?>
					<h1>
                		<span><?php echo __( 'Yearly Archives :',  'cleanblogg' ); ?> </span>
						<?php printf( __( '%s',  'cleanblogg' ), get_the_date( _x( 'Y', 'yearly archives date format',  'cleanblogg' ) ) );?>
                	</h1>
            		<?php elseif ( is_author() ) : ?>
					<h1>
                		<span><?php echo __( 'Author Archives :',  'cleanblogg' ); ?> </span>
						<?php printf( __( '%s',  'cleanblogg' ), get_the_author() );?>
                	</h1>
            		<?php elseif ( is_tag() ) : ?>
					<h1>
                		<span><?php echo __( 'Tag Archives :',  'cleanblogg' ); ?> </span>
						<?php printf( __( '%s',  'cleanblogg' ), single_tag_title() );?>
                	</h1>     
					<?php else : ?>
					<h1> <?php _e( 'Archives',  'cleanblogg' ); ?> </h1>
					<?php endif; ?>
				</div>
				<?php if ( have_posts() ) : 
				while ( have_posts() ) : the_post(); 
				get_template_part( 'content');
				endwhile;
				cleanblogg_pagination();
				else :
				get_template_part( 'content', 'none' ); 
				endif; ?>            
        	</div>
            <?php if($content_layout != 'full'): ?>
            <div class="cb-side-bar col-sm-4">
        		<?php get_sidebar(); ?>
        	</div>
            <?php endif; ?>
        </div>
    </div>	
</div>
<?php get_footer(); ?>