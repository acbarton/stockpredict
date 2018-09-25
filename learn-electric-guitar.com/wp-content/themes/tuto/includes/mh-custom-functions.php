<?php

/***** Add CSS classes to HTML tag *****/

if (!function_exists('tuto_add_html_class')) {
	function tuto_add_html_class() {
		$tuto_options = tuto_theme_options();
		isset($tuto_options['full_bg']) && $tuto_options['full_bg'] == 1 ? $fullbg = ' fullbg' : $fullbg = '';
		echo $fullbg;
	}
}
add_action('tuto_html_class', 'tuto_add_html_class');

/***** Add CSS classes to body tag *****/

if (!function_exists('tuto_add_body_class')) {
	function tuto_add_body_class($classes) {
		$tuto_options = tuto_theme_options();
		$classes[] = 'mh-' . $tuto_options['sb_position'] . '-sb';
		return $classes;
	}
}
add_filter('body_class', 'tuto_add_body_class');

/***** Add HTML markup for main site container *****/

if (!function_exists('tuto_boxed_container_open')) {
	function tuto_boxed_container_open() {
		echo '<div class="mh-container mh-container-outer">' . "\n";
	}
}
add_action('tuto_before_header', 'tuto_boxed_container_open');

if (!function_exists('tuto_boxed_container_close')) {
	function tuto_boxed_container_close() {
		tuto_before_container_close();
		echo '</div><!-- .mh-container-outer -->' . "\n";
	}
}
add_action('tuto_after_footer', 'tuto_boxed_container_close');

/***** Custom Header *****/

if (!function_exists('tuto_custom_header')) {
	function tuto_custom_header() {
		echo '<div class="mh-custom-header">' . "\n";
			if (get_header_image()) {
				echo '<a class="mh-header-image-link" href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name')) . '" rel="home">' . "\n";
					echo '<img class="mh-header-image" src="' . esc_url(get_header_image()) . '" height="' . esc_attr(get_custom_header()->height) . '" width="' . esc_attr(get_custom_header()->width) . '" alt="' . esc_attr(get_bloginfo('name')) . '" />' . "\n";
				echo '</a>' . "\n";
			}
			if (has_custom_logo() || display_header_text()) {
				echo '<div class="mh-site-logo" role="banner">' . "\n";
					if (function_exists('the_custom_logo')) {
						the_custom_logo();
					}
					if (display_header_text()) {
						if (get_header_textcolor() != get_theme_support('custom-header', 'default-text-color')) {
							echo '<style type="text/css" id="mh-header-css">';
								echo '.mh-header-title, .mh-header-tagline { color: #' . esc_attr(get_header_textcolor()) . '; }';
							echo '</style>' . "\n";
						}
						echo '<div class="mh-header-text">' . "\n";
							if (is_front_page()) {
								$header_title_before = '<h1 class="mh-header-title">';
								$header_title_after = '</h1>' . "\n";
								$header_tagline_before = '<h2 class="mh-header-tagline">';
								$header_tagline_after = '</h2>' . "\n";
							} else {
								$header_title_before = '<h2 class="mh-header-title">';
								$header_title_after = '</h2>' . "\n";
								$header_tagline_before = '<h3 class="mh-header-tagline">';
								$header_tagline_after = '</h3>' . "\n";
							}
							echo '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name')) . '" rel="home">' . "\n";
								if (get_bloginfo('name')) {
									echo $header_title_before . esc_attr(get_bloginfo('name')) . $header_title_after;
								}
								if (get_bloginfo('description')) {
									echo $header_tagline_before . esc_attr(get_bloginfo('description')) . $header_tagline_after;
								}
							echo '</a>' . "\n";
						echo '</div>' . "\n";
					}
				echo '</div>' . "\n";
			}
		echo '</div>' . "\n";
	}
}

/***** Post Meta *****/

if (!function_exists('tuto_post_meta')) {
	function tuto_post_meta() {
		echo '<p class="mh-meta entry-meta">' . "\n";
			echo '<span class="entry-meta-date updated"><i class="fa fa-clock-o"></i><a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . get_the_date() . '</a></span>' . "\n";
			echo '<span class="entry-meta-author author vcard"><i class="fa fa-user"></i><a class="fn" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>' . "\n";
			echo '<span class="entry-meta-categories"><i class="fa fa-folder-open-o"></i>' . get_the_category_list(', ', '') . '</span>' . "\n";
			echo '<span class="entry-meta-comments"><i class="fa fa-comment-o"></i><a class="mh-comment-scroll" href="' . esc_url(get_permalink() . '#mh-comments') . '">' . get_comments_number() . '</a></span>' . "\n";
		echo '</p>' . "\n";
	}
}
add_action('tuto_post_header', 'tuto_post_meta');

/***** Post Meta (Loop) *****/

if (!function_exists('tuto_loop_meta')) {
	function tuto_loop_meta() {
		echo '<span class="mh-meta-date updated"><i class="fa fa-clock-o"></i>' . get_the_date() . '</span>' . "\n";
		if (in_the_loop()) {
			echo '<span class="mh-meta-author author vcard"><i class="fa fa-user"></i><a class="fn" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>' . "\n";
		}
		echo '<span class="mh-meta-comments"><i class="fa fa-comment-o"></i>';
			tuto_comment_count();
		echo '</span>' . "\n";
	}
}

/***** Post Icon Header on Archives (Post Formats) *****/

if (!function_exists('tuto_post_icon_header')) {
	function tuto_post_icon_header() {
		$format = get_post_format();
		echo '<a href="' . esc_url(get_the_permalink()) . '" rel="bookmark">' . "\n";
			echo '<div class="mh-icon-header">' . "\n";
				if ($format === 'status') {
					echo '<i class="fa fa-pencil"></i>' . "\n";
				} elseif ($format === 'link') {
					echo '<i class="fa fa-link"></i>' . "\n";
				} elseif ($format === 'quote') {
					echo '<i class="fa fa-quote-left"></i>' . "\n";
				} elseif ($format === 'chat') {
					echo '<i class="fa fa-commenting-o"></i>' . "\n";
				}
			echo '</div>' . "\n";
		echo '</a>' . "\n";
	}
}

/***** Featured Image on Posts *****/

if (!function_exists('tuto_featured_image')) {
	function tuto_featured_image() {
		global $page, $post;
		if (has_post_thumbnail() && $page == '1' && !is_attachment()) {
			$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'tuto-content');
			echo "\n" . '<figure class="entry-thumbnail">' . "\n";
				echo '<img src="' . esc_url($thumbnail[0]) . '" alt="' . esc_attr(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) . '" title="' . esc_attr(get_post(get_post_thumbnail_id())->post_title) . '" />' . "\n";
				if (get_post(get_post_thumbnail_id())->post_excerpt) {
					echo '<i class="fa fa-info"></i>' . "\n";
					echo '<figcaption class="wp-caption-text">' . wp_kses_post(get_post(get_post_thumbnail_id())->post_excerpt) . '</figcaption>' . "\n";
				}
			echo '</figure>' . "\n";
		}
	}
}

/***** Author box *****/

if (!function_exists('tuto_author_box')) {
	function tuto_author_box() {
		$tuto_options = tuto_theme_options();
		$tuto_author_box_ID = get_the_author_meta('ID');
		if ($tuto_options['author_box'] == 'enable' && get_the_author_meta('description', $tuto_author_box_ID) && !is_attachment()) {
			get_template_part('content', 'author-box');
		}
	}
}
add_action('tuto_after_post_content', 'tuto_author_box');

/***** Post / Image Navigation *****/

if (!function_exists('tuto_postnav')) {
	function tuto_postnav() {
		global $post;
		$tuto_options = tuto_theme_options();
		if ($tuto_options['post_nav'] == 'enable') {
			$parent_post = get_post($post->post_parent);
			$attachment = is_attachment();
			$previous = ($attachment) ? $parent_post : get_adjacent_post(false, '', true);
			$next = get_adjacent_post(false, '', false);

			if (!$next && !$previous)
			return;

			if ($attachment) {
				$attachments = get_children(array('post_type' => 'attachment', 'post_mime_type' => 'image', 'post_parent' => $parent_post->ID));
				$count = count($attachments);
			}
			echo '<nav class="mh-post-nav-wrap clearfix" role="navigation">' . "\n";
				if ($previous || $attachment) {
					echo '<div class="mh-post-nav-prev mh-post-nav">' . "\n";
						if ($attachment) {
							if (wp_attachment_is_image($post->id)) {
								if ($count == 1) {
									echo '<a href="' . esc_url(get_permalink($parent_post)) . '">' . esc_html__('Back to article', 'tuto') . '</a>';
								} else {
									previous_image_link('%link', esc_html__('Previous image', 'tuto'));
								}
							} else {
								echo '<a href="' . esc_url(get_permalink($parent_post)) . '">' . esc_html__('Back to article', 'tuto') . '</a>';
							}
						} else {
							previous_post_link('%link', esc_html__('Previous article', 'tuto'));
						}
					echo '</div>' . "\n";
				}
				if ($next || $attachment) {
					echo '<div class="mh-post-nav-next mh-post-nav">' . "\n";
						if ($attachment && wp_attachment_is_image($post->id)) {
							next_image_link('%link', esc_html__('Next image', 'tuto'));
						} else {
							next_post_link('%link', esc_html__('Next article', 'tuto'));
						}
					echo '</div>' . "\n";
				}
			echo '</nav>' . "\n";
		}
	}
}
add_action('tuto_after_post_content', 'tuto_postnav');

/***** Custom Excerpts *****/

if (!function_exists('tuto_excerpt_length')) {
	function tuto_excerpt_length($length) {
		$tuto_options = tuto_theme_options();
		$excerpt_length = absint($tuto_options['excerpt_length']);
		return $excerpt_length;
	}
}
add_filter('excerpt_length', 'tuto_excerpt_length', 999);

if (!function_exists('tuto_excerpt_more')) {
	function tuto_excerpt_more($more) {
		global $post;
		$tuto_options = tuto_theme_options();
		return ' <a class="mh-excerpt-more" href="' . esc_url(get_permalink($post->ID)) . '" title="' . the_title_attribute('echo=0') . '"><span>' . esc_attr($tuto_options['excerpt_more']) . '</span></a>';
	}
}
add_filter('excerpt_more', 'tuto_excerpt_more');

if (!function_exists('tuto_excerpt_markup')) {
	function tuto_excerpt_markup($excerpt) {
		$markup = '<div class="mh-excerpt">' . $excerpt . '</div>';
		return $markup;
	}
}
add_filter('the_excerpt', 'tuto_excerpt_markup');

/***** Custom Commentlist *****/

if (!function_exists('tuto_comments')) {
	function tuto_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID() ?>" <?php comment_class('mh-comment-item'); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="mh-comment-body">
				<footer class="mh-meta mh-comment-meta">
					<span class="vcard mh-comment-author">
						<figure class="mh-comment-gravatar">
							<?php echo get_avatar($comment->comment_author_email, 60); ?>
						</figure>
						<span class="fn"><?php echo get_comment_author_link(); ?></span>
					</span>
					<span class="mh-comment-meta-data">
						<a class="mh-comment-meta-date" href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
							<?php printf(esc_html__('%1$s at %2$s', 'tuto'), get_comment_date(),  get_comment_time()); ?>
						</a>
					</span>
				</footer>
				<?php if ($comment->comment_approved == '0') { ?>
					<div class="mh-comment-info">
						<?php _e('Your comment is awaiting moderation.', 'tuto') ?>
					</div>
				<?php } ?>
				<div class="mh-comment-content">
					<?php comment_text() ?>
				</div>
				<div class="mh-meta mh-comment-meta-links"><?php
					if (comments_open() && $args['max_depth'] != $depth) {
						comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'])));
					}
					edit_comment_link(esc_html__('Edit', 'tuto'),'  ',''); ?>
                </div>
			</article><?php
	}
}

/***** Custom Comment Fields *****/

if (!function_exists('tuto_comment_fields')) {
	function tuto_comment_fields($fields) {
		$commenter = wp_get_current_commenter();
		$req = get_option('require_name_email');
		$aria_req = ($req ? " aria-required='true'" : '');
		$fields =  array(
			'author'	=>	'<p class="comment-form-author"><label for="author">' . esc_html__('Name ', 'tuto') . '</label>' . ($req ? '<span class="required">*</span>' : '') . '<br/><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
			'email' 	=>	'<p class="comment-form-email"><label for="email">' . esc_html__('Email ', 'tuto') . '</label>' . ($req ? '<span class="required">*</span>' : '' ) . '<br/><input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>',
			'url' 		=>	'<p class="comment-form-url"><label for="url">' . esc_html__('Website', 'tuto') . '</label><br/><input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></p>'
		);
		return $fields;
	}
}
add_filter('comment_form_default_fields', 'tuto_comment_fields');

/***** Comment Count Output *****/

if (!function_exists('tuto_comment_count')) {
	function tuto_comment_count() {
		echo '<a class="mh-comment-count-link" href="' . esc_url(get_permalink() . '#mh-comments') . '">' . get_comments_number() . '</a>';
	}
}

/***** Pagination *****/

if (!function_exists('tuto_pagination')) {
	function tuto_pagination() {
		global $wp_query;
	    $big = 9999;
	    $paginate_links = paginate_links(array(
	    	'base' 		=> str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
	    	'format' 	=> '?paged=%#%',
	    	'current' 	=> max(1, get_query_var('paged')),
	    	'prev_next' => true,
	    	'prev_text' => esc_html__('&laquo;', 'tuto'),
	    	'next_text' => esc_html__('&raquo;', 'tuto'),
	    	'total' 	=> $wp_query->max_num_pages)
	    );
		if ($paginate_links) {
	    	echo '<div class="mh-loop-pagination clearfix">';
				echo $paginate_links;
			echo '</div>';
		}
	}
}

/***** Pagination for paginated Posts *****/

if (!function_exists('tuto_paginated_posts')) {
	function tuto_paginated_posts($content) {
		if (is_singular() && in_the_loop()) {
			$content .= wp_link_pages(array('before' => '<div class="pagination clearfix">', 'after' => '</div>', 'link_before' => '<span class="pagelink">', 'link_after' => '</span>', 'nextpagelink' => esc_html__('&raquo;', 'tuto'), 'previouspagelink' => esc_html__('&laquo;', 'tuto'), 'pagelink' => '%', 'echo' => 0));
		}
		return $content;
	}
}
add_filter('the_content', 'tuto_paginated_posts', 1);

/***** Modify Appearance of WP Tag Cloud Widget *****/

if (!function_exists('tuto_custom_tag_cloud')) {
	function tuto_custom_tag_cloud($args) {
		$args['smallest'] = 12;
		$args['largest'] = 12;
		$args['unit'] = 'px';
		return $args;
	}
}
add_filter('widget_tag_cloud_args', 'tuto_custom_tag_cloud');

/***** Add Featured Image Size to Media Gallery Selection *****/

if (!function_exists('tuto_custom_image_size_choose')) {
	function tuto_custom_image_size_choose($sizes) {
		$custom_sizes = array('tuto-content' => 'Featured Image');
		return array_merge($sizes, $custom_sizes);
	}
}
add_filter('image_size_names_choose', 'tuto_custom_image_size_choose');

/***** Add CSS3 Media Queries Support for older versions of IE *****/

function tuto_media_queries() {
	echo '<!--[if lt IE 9]>' . "\n";
	echo '<script src="' . get_template_directory_uri() . '/js/css3-mediaqueries.js"></script>' . "\n";
	echo '<![endif]-->' . "\n";
}
add_action('wp_head', 'tuto_media_queries');

?>