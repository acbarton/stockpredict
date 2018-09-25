<?php /* Loop Template used for large content on archives */ ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('mh-loop-item mh-loop-large-item clearfix'); ?>><?php
	$format = get_post_format();
	if ($format === 'status' || $format === 'link' || $format === 'quote' || $format === 'chat') {
		tuto_post_icon_header();
	} else { ?>
		<a class="mh-loop-thumb-link" href="<?php the_permalink(); ?>">
			<figure class="mh-loop-thumb mh-loop-large-thumb"><?php
				if (has_post_thumbnail()) {
					the_post_thumbnail('tuto-content');
				} else {
					echo '<img class="mh-image-placeholder" src="' . get_template_directory_uri() . '/images/placeholder-content.png' . '" alt="' . esc_html__('No Image', 'tuto') . '" />';
				} ?>
			</figure>
		</a><?php
	} ?>
	<div class="mh-loop-content mh-loop-large-content clearfix">
		<div class="mh-loop-content-inner">
			<header class="mh-loop-header mh-loop-large-header">
				<h2 class="entry-title mh-loop-title mh-loop-large-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark">
						<?php the_title(); ?>
					</a>
				</h2>
				<div class="mh-meta mh-loop-meta mh-loop-large-meta">
					<?php tuto_loop_meta(); ?>
				</div>
			</header>
			<div class="mh-loop-excerpt mh-loop-large-excerpt">
				<?php the_excerpt(); ?>
			</div>
		</div>
	</div>
</article>