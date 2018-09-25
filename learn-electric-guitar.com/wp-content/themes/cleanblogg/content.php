<?php 
if(is_archive() || is_search()){
$blog_style= get_theme_mod( 'cleanblog_archive_style');	
}
else{
$blog_style= get_theme_mod( 'cleanblog_content_style'); 	
} 
?>
<?php 
// Standard Layout
$cleanblog_list_featured_image_show = get_theme_mod( 'cleanblog_list_featured_image_show',true);
$cleanblog_list_date_show = get_theme_mod( 'cleanblog_list_date_show',true);
$cleanblog_list_category_show = get_theme_mod( 'cleanblog_list_category_show',true);
$cleanblog_list_author_show = get_theme_mod( 'cleanblog_list_author_show',true);
$cleanblog_list_comments_show = get_theme_mod( 'cleanblog_list_comments_show',true);

if ($blog_style == 'standard'):?>
<article id="post-<?php the_ID(); ?>" <?php post_class('cb-article-standard'); ?>>
  <?php if ($cleanblog_list_featured_image_show != false):?>
	<?php if ( has_post_thumbnail()) : ?>
    <div class="cb-post-media">
    <a href="<?php the_permalink(); ?>">
       <?php the_post_thumbnail("cleanblogg-full-thumb"); ?>
       </a>
    </div>
    <?php endif; ?>
    <?php endif; ?>
     <div class="cb-post-entry">
         <div class="cb-post-header">
              <?php if ($cleanblog_list_category_show != false):?><div class="cb-post-cat"><?php echo get_the_category_list(); ?></div><?php endif; ?>
                   <h2 class="cb-post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        <hr />
                        
                        </div>
                        <div class="cb-post-content">
    					<?php
							if( strpos( $post->post_content, '<!--more-->' ) ) {
								the_content('');
							}
							else {
								the_excerpt('');
							}
						?>
                        </div>
                    </div>
                    <div class="cb-post-footer">
                    <div class="cb-post-date">
          			<?php if ($cleanblog_list_date_show != false):?><span><?php echo get_the_date(); ?></span><?php endif; ?>
          			</div>
                    
              <div class="cb-post-more">
              <a href="<?php the_permalink(); ?><?php if( strpos( $post->post_content, '<!--more-->' ) ) { ?>#more-<?php the_ID(); }?>" rel="bookmark"><?php _e( 'Read More',  'cleanblogg' ); ?> </a>
              </div> 
              <div class="cb-post-meta">
                     <?php if ($cleanblog_list_author_show != false):
					 _e( 'By ',  'cleanblogg' ); the_author_posts_link(); ?> 
                      <?php if (($cleanblog_list_author_show != false) && ($cleanblog_list_comments_show != false) ): ?>|<?php endif; ?> <?php
					  endif; if ($cleanblog_list_comments_show != false):
					  comments_number( __('0 Comments',  'cleanblogg'), __('1 Comment',  'cleanblogg'), __('% Comments',  'cleanblogg') ); 
  					  endif; ?>
                    </div>
          
     </div>
</article>
<?php 
// List Layout
elseif($blog_style == 'list'): ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('cb-article-list'); ?>>
    <div class="cb-list">
    <?php if ($cleanblog_list_featured_image_show != false): ?>
    <?php if ( has_post_thumbnail()) : ?>
        <div class="cb-post-media">
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
           <?php the_post_thumbnail("cleanblogg-list-thumb"); ?>
        </a>
        <?php if ($cleanblog_list_date_show != false): ?>
           <span class="cb-post-date"><?php echo get_the_date(); ?></span>
        <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
        <div class="cb-list-content">
        	<?php if ($cleanblog_list_category_show != false): ?>
            <div class="cb-post-cat"><?php echo get_the_category_list(); ?></div>
            <?php endif; ?>
            <h2 class="cb-post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
            <hr />
            <div class="cb-list-entry"><?php the_excerpt(); ?></div>
            <a href="<?php the_permalink(); ?>" class="cb-more"><?php echo __( 'Read More &#187;',  'cleanblogg' ); ?></a>
            
        </div>
    </div>
</article>    
<?php 
// Grid Layout
else: ?>
<?php
$content_layout= get_theme_mod( 'cleanblog_content_layout');
if($content_layout == 'full'){
	$cb_ex_class = 'col-sm-4 cb-full-width';
	}
elseif($content_layout == 'left'){ 
	$cb_ex_class = 'col-sm-6 cb-sidebar-left';
	}
else{
	$cb_ex_class = 'col-sm-6 cb-sidebar-right';
	}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('cb-article-grid '.$cb_ex_class); ?>>
    <div class="cb-grid">
    <?php if ($cleanblog_list_featured_image_show != false): ?>
    <?php if ( has_post_thumbnail()) : ?>
        <div class="cb-post-media">
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
           <?php the_post_thumbnail("cleanblogg-grid-thumb"); ?>
        </a>
        <?php if ($cleanblog_list_date_show != false): ?>
           <span class="cb-post-date"><?php echo get_the_date(); ?></span>
        <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
        <div class="cb-grid-content">
        	<?php if ($cleanblog_list_category_show != false): ?>
            <div class="cb-post-cat"><?php echo get_the_category_list(); ?></div>
            <?php endif; ?>
            <h2 class="cb-post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
            <hr />
            <div class="cb-grid-entry"><?php the_excerpt(); ?></div>
            <a href="<?php the_permalink(); ?>" class="cb-more"><?php echo __( 'Read More &#187;',  'cleanblogg' ); ?></a>
            
        </div>
    </div>
</article>
<?php endif; ?>