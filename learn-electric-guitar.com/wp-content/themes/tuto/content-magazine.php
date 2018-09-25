<?php /* Template for displaying posts on posts page and archives */
$counter = 1;
$max_posts = $wp_query->post_count;
while (have_posts()) : the_post();
	if ($counter === 1) :
		get_template_part('content', 'large');
	endif;
	if ($counter === 1 && $max_posts > 1) : ?>
		<div class="mh-loop-grid mh-row clearfix"><?php
	endif;
	if ($counter > 1 && $counter <= 4) :
		get_template_part('content', 'grid');
	endif;
	if ($counter === 5) : ?>
		</div>
		<div class="mh-loop-list clearfix"><?php
	endif;
	if ($counter >= 5) :
		get_template_part('content');
	endif;
	if ($counter > 1 && $counter === $max_posts) : ?>
		</div><?php
	endif;
$counter++;
endwhile; ?>