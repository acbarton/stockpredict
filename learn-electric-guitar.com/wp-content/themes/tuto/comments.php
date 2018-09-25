<?php /* Comments Template */

if (post_password_required()) {
	return;
}
if (have_comments()) {
	$comments_by_type = separate_comments($comments);
	if (!empty($comments_by_type['comment'])) {
		$comment_count = count($comments_by_type['comment']); ?>
		<div id="mh-comments" class="mh-comments-wrap">
			<h4 class="mh-section-title">
				<?php printf(_n('1 Comment Posted', '%1$s Comments Posted', $comment_count, 'tuto'), number_format_i18n($comment_count)); ?>
			</h4>
			<ol class="commentlist mh-comment-list">
				<?php echo wp_list_comments('callback=tuto_comments&type=comment'); ?>
			</ol>
		</div><?php
	}
	if (get_comments_number() > get_option('comments_per_page')) { ?>
		<nav class="mh-comments-pagination">
			<?php paginate_comments_links(array('prev_text' => esc_html__('&laquo;', 'tuto'), 'next_text' => esc_html__('&raquo;', 'tuto'))); ?>
		</nav><?php
	}
	if (!empty($comments_by_type['pings'])) {
		$pings = $comments_by_type['pings'];
		$ping_count = count($comments_by_type['pings']); ?>
		<h4 class="mh-section-title">
			<?php printf(__('%s Trackbacks & Pingbacks', 'tuto'), $ping_count); ?>
		</h4>
		<ol class="pinglist mh-ping-list">
        	<?php foreach ($pings as $ping) { ?>
				<li id="comment-<?php comment_ID() ?>" <?php comment_class('mh-ping-item'); ?>>
					<?php echo '<i class="fa fa-link"></i>' . get_comment_author_link($ping); ?>
				</li>
			<?php } ?>
        </ol><?php
	}
	if (!comments_open()) { ?>
		<p class="mh-section-title mh-no-comments">
			<?php _e('Comments are closed.', 'tuto'); ?>
		</p><?php
	}
}

if (comments_open()) {
	echo '<div id="mh-comments"></div>' . "\n";
	comment_form(array(
		'title_reply' => esc_html__('Leave a Reply', 'tuto'),
        'comment_notes_before' => '<p class="comment-notes">' . esc_html__('Your email address will not be published.', 'tuto') . '</p>',
        'comment_notes_after'  => '',
        'comment_field' => '<p class="comment-form-comment"><label for="comment">' . esc_html__('Comment', 'tuto') . '</label><br/><textarea id="comment" name="comment" cols="45" rows="5" aria-required="true"></textarea></p>'
	));
}

?>