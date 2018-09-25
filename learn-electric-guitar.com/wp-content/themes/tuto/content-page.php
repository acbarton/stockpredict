<?php /* Default template for displaying page content */ ?>
<article id="page-<?php the_ID(); ?>" <?php post_class('mh-content-wrapper'); ?>>
	<header class="entry-header">
		<?php the_title('<h1 class="entry-title page-title">', '</h1>'); ?>
	</header>
	<div class="entry-content clearfix">
		<?php the_content(); ?>
	</div>
</article>