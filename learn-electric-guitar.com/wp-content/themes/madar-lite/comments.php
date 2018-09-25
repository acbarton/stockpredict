		<div id="comments">
<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'madar-lite' ); ?></p>
			</div><!-- #comments -->
<?php
		return;
	endif;
?>

<?php if ( have_comments() ) : ?>
			<h3 id="comments-title">
			<?php comments_number(__('No comments','madar-lite'), _e('One comment','madar-lite'), '% '._e('comments','madar-lite') );?>
			</h3>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :  ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( _e( '<span class="meta-nav">&larr;</span> Older Comments', 'madar-lite') ); ?></div>
				<div class="nav-next"><?php next_comments_link( _e( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'madar-lite') ); ?></div>
			</div> <!-- .navigation -->
<?php endif; ?>
			<?php $comments_by_type = separate_comments( $comments ); ?>
			<?php if ( !empty($comments_by_type['comment']) ) : ?>
				<ol class="commentlist"><?php wp_list_comments('type=comment&callback=madarlite_comments'); ?></ol>
			<?php endif; ?>    
			<?php $comment_counter = 0 ; ?>
			<?php if ( !empty($comments_by_type['pings']) ) : ?>
			<div id="pings" class="commentlist">
				<ol class="pinglist"><?php wp_list_comments('type=pings&trackback&pingback&callback=madarlite_pings'); ?></ol>
			</div>
			<?php endif; ?>	
<?php else : 
	if ( ! comments_open() ) :
	
	endif; ?>
<?php endif; ?>


<?php

$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );

$fields =  array(
	'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'madar-lite') . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
	            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
	'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'madar-lite') . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
	            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
	'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'madar-lite') . '</label>' .
	            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
);
$required_text = __(' Required fields are marked', 'madar-lite').' <span class="required">*</span>';
?>
<?php comment_form( array(
	'fields' => apply_filters( 'comment_form_default_fields', $fields ),
	'must_log_in' => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' , 'madar-lite'), wp_login_url( apply_filters( 'the_permalink', esc_url( get_permalink() ) ) ) ) . '</p>',
	'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>'  , 'madar-lite'), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', esc_url( get_permalink() ) ) ) ) . '</p>',
	'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.'  , 'madar-lite') . ( $req ? $required_text : '' ) . '</p>',
	'title_reply' => __( 'Leave a Reply'  , 'madar-lite'),
	'title_reply_to' => __( 'Leave a Reply to %s'  , 'madar-lite'),
	'cancel_reply_link' => __( 'Cancel reply'  , 'madar-lite'),
	'label_submit' => __( 'Post Comment'  , 'madar-lite')
)); ?>

</div><!-- #comments -->
