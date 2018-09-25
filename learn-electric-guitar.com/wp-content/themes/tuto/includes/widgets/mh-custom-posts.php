<?php

/***** MH Custom Posts *****/

class tuto_custom_posts_widget extends WP_Widget {
    function __construct() {
		parent::__construct(
			'tuto_custom_posts', esc_html_x('MH Custom Posts', 'widget name', 'tuto'),
			array(
				'classname' => 'tuto_custom_posts',
				'description' => esc_html__('Custom Posts Widget to display posts based on categories or tags.', 'tuto'),
				'customize_selective_refresh' => true
			)
		);
	}
    function widget($args, $instance) {
	    $defaults = array('title' => '', 'category' => 0, 'tags' => '', 'postcount' => 5, 'offset' => 0, 'sticky' => 1);
		$instance = wp_parse_args($instance, $defaults);
	   	$query_args = array();
	   	if (0 !== $instance['category']) {
			$query_args['cat'] = $instance['category'];
		}
		if (!empty($instance['tags'])) {
			$tag_slugs = explode(',', $instance['tags']);
			$tag_slugs = array_map('trim', $tag_slugs);
			$query_args['tag_slug__in'] = $tag_slugs;
		}
		if (!empty($instance['postcount'])) {
			$query_args['posts_per_page'] = $instance['postcount'];
		}
		if (0 !== $instance['offset']) {
			$query_args['offset'] = $instance['offset'];
		}
		if (1 === $instance['sticky']) {
			$query_args['ignore_sticky_posts'] = true;
		}
		$widget_loop = new WP_Query($query_args);
        echo $args['before_widget'];
        	if (!empty($instance['title'])) {
				echo $args['before_title'];
					if ($instance['category'] != 0) {
						echo '<a href="' . esc_url(get_category_link($instance['category'])) . '" class="mh-widget-title-link">';
					}
					echo esc_html(apply_filters('widget_title', $instance['title']));
					if ($instance['category'] != 0) {
						echo '</a>';
					}
				echo $args['after_title'];
			} ?>
			<ul class="mh-custom-posts-widget clearfix"><?php
				while ($widget_loop->have_posts()) : $widget_loop->the_post(); ?>
					<li class="mh-custom-posts-item mh-custom-posts-small clearfix">
						<div class="mh-custom-posts-thumb">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php
								if (has_post_thumbnail()) {
									the_post_thumbnail('tuto-small');
								} else {
									echo '<img class="mh-image-placeholder" src="' . get_template_directory_uri() . '/images/placeholder-small.png' . '" alt="' . esc_html__('No Image', 'tuto') . '" />';
								} ?>
							</a>
						</div>
						<header class="mh-custom-posts-header">
							<p class="mh-custom-posts-small-title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php the_title(); ?>
								</a>
							</p>
							<div class="mh-meta mh-custom-posts-meta">
								<?php tuto_loop_meta(); ?>
							</div>
						</header>
					</li><?php
				endwhile;
				wp_reset_postdata(); ?>
        	</ul><?php
        echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();
        if (!empty($new_instance['title'])) {
			$instance['title'] = sanitize_text_field($new_instance['title']);
		}
        if (0 !== absint($new_instance['category'])) {
			$instance['category'] = absint($new_instance['category']);
		}
		if (!empty($new_instance['tags'])) {
			$tag_slugs = explode(',', $new_instance['tags']);
			$tag_slugs = array_map('sanitize_title', $tag_slugs);
			$instance['tags'] = implode(', ', $tag_slugs);
		}
		if (0 !== absint($new_instance['postcount'])) {
			if (absint($new_instance['postcount']) > 50) {
				$instance['postcount'] = 50;
			} else {
				$instance['postcount'] = absint($new_instance['postcount']);
			}
		}
		if (0 !== absint($new_instance['offset'])) {
			if (absint($new_instance['offset']) > 50) {
				$instance['offset'] = 50;
			} else {
				$instance['offset'] = absint($new_instance['offset']);
			}
		}
		$instance['sticky'] = (!empty($new_instance['sticky'])) ? 1 : 0;
        return $instance;
    }
    function form($instance) {
	    $defaults = array('title' => '', 'category' => 0, 'tags' => '', 'postcount' => 5, 'offset' => 0, 'sticky' => 1);
        $instance = wp_parse_args($instance, $defaults); ?>
		<p>
        	<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'tuto'); ?></label>
			<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php esc_html_e('Select a Category:', 'tuto'); ?></label>
            <select id="<?php echo esc_attr($this->get_field_id('category')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('category')); ?>">
            	<option value="0" <?php selected(0, $instance['category']); ?>><?php esc_html_e('All', 'tuto'); ?></option><?php
            		$categories = get_categories();
            		foreach ($categories as $cat) { ?>
            			<option value="<?php echo absint($cat->cat_ID); ?>" <?php selected($cat->cat_ID, $instance['category']); ?>><?php echo esc_html($cat->cat_name) . ' (' . absint($cat->category_count) . ')'; ?></option><?php
            		} ?>
            </select>
            <small><?php _e('Select a category to display posts from.', 'tuto'); ?></small>
		</p>
		<p>
        	<label for="<?php echo esc_attr($this->get_field_id('tags')); ?>"><?php esc_html_e('Filter Posts by Tags (e.g. lifestyle):', 'tuto'); ?></label>
			<input class="widefat" type="text" value="<?php echo esc_attr($instance['tags']); ?>" name="<?php echo esc_attr($this->get_field_name('tags')); ?>" id="<?php echo esc_attr($this->get_field_id('tags')); ?>" />
	    </p>
        <p>
        	<label for="<?php echo esc_attr($this->get_field_id('postcount')); ?>"><?php esc_html_e('Post Count (max. 50):', 'tuto'); ?></label>
			<input class="widefat" type="text" value="<?php echo absint($instance['postcount']); ?>" name="<?php echo esc_attr($this->get_field_name('postcount')); ?>" id="<?php echo esc_attr($this->get_field_id('postcount')); ?>" />
	    </p>
	    <p>
        	<label for="<?php echo esc_attr($this->get_field_id('offset')); ?>"><?php esc_html_e('Skip Posts (max. 50):', 'tuto'); ?></label>
			<input class="widefat" type="text" value="<?php echo absint($instance['offset']); ?>" name="<?php echo esc_attr($this->get_field_name('offset')); ?>" id="<?php echo esc_attr($this->get_field_id('offset')); ?>" />
	    </p>
        <p>
			<input id="<?php echo esc_attr($this->get_field_id('sticky')); ?>" name="<?php echo esc_attr($this->get_field_name('sticky')); ?>" type="checkbox" value="1" <?php checked(1, $instance['sticky']); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('sticky')); ?>"><?php esc_html_e('Ignore Sticky Posts', 'tuto'); ?></label>
		</p><?php
    }
}

?>