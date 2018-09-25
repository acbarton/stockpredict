<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package EasyMag
 */

?>
<div class="post-list blog">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-header"><h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"rel="bookmark"><?php the_title(); ?></a></h2></div>
    <?php madarlite_author_meta(); ?>
    <div class="post-thumbnail"><?php echo madarlite_thumbnail('box'); ?></div>
    <div class="post-content"><?php madarlite_content(); ?></div>
    <?php madarlite_post_meta(); ?>
<div class="clearfix"></div>
</article><!-- #post-## -->
</div>