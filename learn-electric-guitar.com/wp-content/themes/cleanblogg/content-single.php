<?php
$cleanblog_single_featured_image_show = get_theme_mod( 'cleanblog_single_featured_image_show',true);
$cleanblog_single_category_show = get_theme_mod( 'cleanblog_single_category_show',true);
$cleanblog_single_author_show = get_theme_mod( 'cleanblog_single_author_show',true);
$leanblog_single_date_show = get_theme_mod( 'leanblog_single_date_show',true);
$cleanblog_single_comments_show = get_theme_mod( 'cleanblog_single_comments_show',true);
$cleanblog_single_tags_show = get_theme_mod( 'cleanblog_single_tags_show',true);
$cleanblog_single_author_bio_show = get_theme_mod( 'cleanblog_single_author_bio_show',false);
$cleanblog_single_relatedpost_show = get_theme_mod( 'cleanblog_single_relatedpost_show',false);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cb-single'); ?>>
	<?php if ($cleanblog_single_featured_image_show != false):?>
	<?php if (has_post_thumbnail()) : ?>
    <div class="cb-post-media">
       <?php the_post_thumbnail("cleanblogg-full-thumb"); ?>
    </div>
    <?php endif; ?>
    <?php endif; ?>
     <div class="cb-post-entry">
        <div class="cb-post-header">
          <?php if ($cleanblog_single_category_show != false):?><div class="cb-post-cat"><?php echo get_the_category_list(); ?></div><?php endif; ?>
          <h2 class="cb-post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <div class="cb-post-meta">
                <ul>
                    <?php if ($cleanblog_single_author_show != false): ?><li><?php echo __( 'By ',  'cleanblogg' ); the_author_posts_link(); ?></li><?php endif; ?>
                    <?php if ($leanblog_single_date_show != false):?><li><?php echo get_the_date(); ?></li><?php endif; ?>
                    <?php if ($cleanblog_single_comments_show != false):?><li><?php comments_number( __('0 Comments',  'cleanblogg'), __('1 Comment',  'cleanblogg'), __('% Comments',  'cleanblogg') ); ?></li><?php endif; ?>
                </ul>
            </div>
                    
        </div>
        <div class="cb-post-content">
            <?php the_content(''); ?>
        </div>
        <?php if ($cleanblog_single_tags_show != false):?><div class="cb-post-tags"><?php the_tags('','',''); ?> </div><?php endif; ?>
    </div>              
    <?php wp_link_pages( array( 'before' => '<div class="multi-page-links">',
 'after' => '</div>', 'next_or_number' => 'number','link_before' => '<span>',
		'link_after'       => '</span>',  ) );?>
 
</article>
<?php if ($cleanblog_single_author_bio_show != false):?>
<div class="cb-about-author">
	<div class="cb-author-avatar">
	<?php echo get_avatar( $post->post_author, 100 ); ?>
	</div>
    <div class="author-info">
		<h5><?php the_author_posts_link(); ?></h5>
		<p><?php the_author_meta('description'); ?></p>
	</div>
    <div class="clearfix"></div>
</div>
<?php endif; ?>
<?php if ($cleanblog_single_relatedpost_show != false):?>
	<div class="cb-related">
	<?php 
	$orig_post = $post;
	global $post;
	$categories = get_the_category($post->ID);
	if ($categories) :
		$category_ids = array();
		foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
		$args = array(
			'category__in'     => $category_ids,
			'post__not_in'     => array($post->ID),
			'posts_per_page'   => 3,
			'ignore_sticky_posts' => 1,
			'orderby' => 'rand'
		);
		$my_query = new wp_query( $args );
		if( $my_query->have_posts() ): ?>
			<h4 class="cb-second-title"><?php _e('You May Also Like',  'cleanblogg'); ?></h4>
			<?php while( $my_query->have_posts() ):
			$my_query->the_post();?>
			<div class="cb-related-grid">
				<?php if ( has_post_thumbnail()) : ?>			
				<div class="cb-post-media">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail("cleanblogg-grid-thumb"); ?>
				</a>
				</div>
				<?php endif; ?>
				<h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
				<span class="cb-post-date"><?php echo get_the_date(); ?></span>					
			</div>
			<?php
			endwhile;
		endif;
	endif;
	$post = $orig_post;
	wp_reset_postdata();
	?>
	<div class="clearfix"></div>
</div> <!-- Related Posts -->
<?php endif; ?>