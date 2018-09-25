<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Madar Lite
 */

global $madarlite_pageArgs; ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="single-item"> 
			<?php  
			madarlite_breadcrumbs();
			madarlite_includes('post-thumbnail');?>
			<div class="single-header">
				<h1><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr_e( 'Permalink to %s', 'madar-lite' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					<div class="comment"><?php 
					echo madarlite_getcomment_count(get_the_ID(), 'post');?>
					</div><div class="meta"><?php madarlite_posted_on(); ?><div class="clearfix"></div></div>
						<div class="clearfix"></div>
			</div><!-- #single-header# -->
				<div class="single-content"><?php the_content(); wp_link_pages($madarlite_pageArgs); ?>
					<div class="clearfix"></div>
		        </div>
		</div><!-- #single-item# -->
	</article>
		<div class="post-tags">
		    <?php the_tags('', ''); ?>
		</div>