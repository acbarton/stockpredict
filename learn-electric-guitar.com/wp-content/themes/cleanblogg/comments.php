<div class="cb-comments" id="comments">
	<?php if ( comments_open() ) : ?>
    <h4 class="cb-second-title">
         <?php comments_number(__('No Comments', 'cleanblogg'), __('1 Comment', 'cleanblogg'), '% ' . __('Comments', 'cleanblogg') );?>
    </h4>
    <div class='comments'>
        <ul class="cb-comment-list">
		<?php wp_list_comments(array(
                'avatar_size'	=> 70,
                'max_depth'		=> 5,
                'style'			=> 'ul',
                'callback'		=> 'cleanblogg_comments',
                'type'			=> 'all'
            )); ?>
        </ul>
    </div>
    <div id='comments_pagination'>
		<?php paginate_comments_links(array('prev_text' => '&laquo;', 'next_text' => '&raquo;')); ?>
	</div>
	<?php
		$custom_comment_field = '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';  //label removed for cleaner layout
		comment_form(array(
			'comment_field'			=> $custom_comment_field,
			'comment_notes_after'	=> '',
			'logged_in_as' 			=> '',
			'comment_notes_before' 	=> '',
			'title_reply'			=> __('Leave a Comment',  'cleanblogg'),
			'cancel_reply_link'		=> __('Cancel Reply',  'cleanblogg'),
			'label_submit'			=> __('Submit Comment',  'cleanblogg')
		));
	 ?>
	<?php endif; ?>
</div>
