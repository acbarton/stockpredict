<?php
//Pagination
function cleanblogg_pagination(){
?>
    <div class="cb-pagination">
        <div class="cb-next-posts"><?php next_posts_link(); ?></div>
        <div class="cb-previous-posts"><?php previous_posts_link(); ?></div>
    </div>
<?php	
	}
	
// Excerpt
function cleanblogg_excerpt_length( $length ) {
	return 60;
}
add_filter( 'excerpt_length', 'cleanblogg_excerpt_length', 999 );
function cleanblogg_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'cleanblogg_excerpt_more' );

// Search Filter
function cleanblogg_search_filter($query) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
}
add_filter('pre_get_posts','cleanblogg_search_filter');	

//Time Hook
 function cleanblogg_ago_time() {
   global $post;
   $date = $post->post_date;
   $time = get_post_time('G', true, $post);
   $cbtime = time() - $time;
   if($cbtime < 60){
     $cbtimestamp = __('Just now','cleanblogg');
   }else{
     $cbtimestamp = sprintf(__('%s ago','cleanblogg'), human_time_diff($time));
   }
   return $cbtimestamp;
 }
add_filter('the_time', 'cleanblogg_ago_time');
 
//Comments
function cleanblogg_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		<div class="cb-comment">	
			<div class="author-img">
				<?php echo get_avatar($comment,$args['avatar_size']); ?>
			</div>
			<div class="comment-text">
				<span class="author"><?php echo get_comment_author_link(); ?></span>
				<span class="date"><?php printf(__('%1$s at %2$s', 'cleanblogg'), get_comment_date(),  get_comment_time()) ?></span>
				<?php if ($comment->comment_approved == '0') : ?>
					<em><i class="icon-info-sign"></i> <?php _e('Comment awaiting approval', 'cleanblogg'); ?></em>
				<?php endif; ?>
				<p class="comment-text"><?php comment_text(); ?></p>
				<span class="reply">
					<?php comment_reply_link(array_merge( $args, array('reply_text' => __('Reply', 'cleanblogg'), 'depth' => $depth, 'max_depth' => $args['max_depth'])), $comment->comment_ID); ?>
					<?php edit_comment_link(__('Edit', 'cleanblogg')); ?>
				</span>
			</div>	
		</div>
		<div class="clearfix"></div>
	</li>
	<?php 
	}
?>