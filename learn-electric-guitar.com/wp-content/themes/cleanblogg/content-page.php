<article id="post-<?php the_ID(); ?>" <?php post_class('cb-single'); ?>>
	<?php if ( has_post_thumbnail()) : ?>
    <div class="cb-post-media">
       <?php the_post_thumbnail("cleanblogg-full-thumb"); ?>
    </div>
    <?php endif; ?>
    <div class="cb-post-entry">
          <div class="cb-post-header">
         		<h2 class="cb-post-title"><?php the_title(); ?></h2>
          </div>
          <div class="cb-post-content">
                <?php the_content(''); ?>
          </div>
    </div>
</article> 