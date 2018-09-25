<?php /* Template for displaying author box content */
$tuto_author_box_ID = get_the_author_meta('ID');
$username = get_the_author_meta('display_name', $tuto_author_box_ID);
$userposts = count_user_posts($tuto_author_box_ID); ?>
<div class="mh-author-box">
	<div class="mh-author-box-content clearfix">
		<figure class="mh-author-box-avatar">
			<?php echo get_avatar($tuto_author_box_ID, 100); ?>
		</figure>
		<div class="mh-author-box-header">
			<span class="mh-author-box-name">
				<?php printf(esc_html__('About %s', 'tuto'), $username); ?>
			</span>
			<?php if (!is_author()) { ?>
				<span class="mh-author-box-postcount">
					<a href="<?php echo esc_url(get_author_posts_url($tuto_author_box_ID)); ?>" title="<?php printf(esc_html__('More articles written by %s', 'tuto'), $username); ?>'">
						<?php esc_html(printf(_n('%s Article', '%s Articles', $userposts, 'tuto'), $userposts)); ?>
					</a>
				</span>
			<?php } ?>
		</div>
		<?php if (get_the_author_meta('description', $tuto_author_box_ID)) { ?>
			<div class="mh-author-box-bio">
				<?php echo wp_kses_post(get_the_author_meta('description', $tuto_author_box_ID)); ?>
			</div>
		<?php } ?>
	</div>
</div>