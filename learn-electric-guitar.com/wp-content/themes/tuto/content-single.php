<?php /* Default template for displaying content. */ ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php tuto_featured_image(); ?>
	<div class="mh-content-wrapper">
		<header class="entry-header clearfix"><?php
			the_title('<h1 class="entry-title">', '</h1>');
			tuto_post_header(); ?>
		</header>
		<div class="entry-content clearfix">
			<?php the_content(); ?>
		</div>
		<footer class="entry-footer clearfix">
			<?php the_tags('<div class="entry-tags clearfix"><ul><li>','</li><li>','</li></ul></div>'); ?>
		</footer>
	</div>
</article>