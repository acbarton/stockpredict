<?php
function cleanblog_widgets()
{
    register_sidebar(array(
        'name' => __('Main Sidebar', 'cleanblogg'),
        'id' => 'cb-sidebar-widget',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Footer 1', 'cleanblogg'),
        'id' => 'cb-footer-widget1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '<hr /></h4>',
    ));
	register_sidebar(array(
        'name' => __('Footer 2', 'cleanblogg'),
        'id' => 'cb-footer-widget2',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '<hr /></h4>',
    ));
	register_sidebar(array(
        'name' => __('Footer 3', 'cleanblogg'),
        'id' => 'cb-footer-widget3',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '<hr /></h4>',
    ));
}
add_action('widgets_init', 'cleanblog_widgets');

////////////////////////////////////////////////////////////////////////////
// Social Icons Widget
////////////////////////////////////////////////////////////////////////////

class cleanblogg_Social_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'cleanblogg_social_widget',
            __( 'Social Icons (ClanBlogg)', 'cleanblogg' ),
            array(
                'classname'   => 'cleanblogg_social_widget',
                'description' => __( 'A widget that displays social icons', 'cleanblogg' )
                )
        );
    }
	public function widget( $args, $instance ) {    
        extract( $args );
        $cleanblogg_social_title      = apply_filters( 'widget_title', $instance['cleanblogg_social_title'] );
		$cleanblogg_socialw_rss      = $instance['cleanblogg_socialw_rss'];
        echo $before_widget;
        if ( $cleanblogg_social_title ) {
            echo $before_title . $cleanblogg_social_title . $after_title;
        } ?>
        <div class="cb-widget-social">
            	<?php if (get_theme_mod( 'cleanblog_fb' )!= "" ){ ?><a href="<?php echo esc_url(get_theme_mod( 'cleanblog_fb' )); ?>"><i class="fa fa-facebook"></i></a> <?php } ?>
                <?php if (get_theme_mod( 'cleanblog_twitter' )!= "" ){ ?><a href="<?php echo esc_url(get_theme_mod( 'cleanblog_twitter' )); ?>"><i class="fa fa-twitter"></i></a><?php } ?>
                <?php if (get_theme_mod( 'cleanblog_googleplus' )!= "" ){ ?><a href="<?php echo esc_url(get_theme_mod( 'cleanblog_googleplus' )); ?>"><i class="fa fa-google-plus"></i></a><?php } ?>
                <?php if (get_theme_mod( 'cleanblog_instagram' )!= "" ){ ?><a href="<?php echo esc_url(get_theme_mod( 'cleanblog_instagram' )); ?>"><i class="fa fa-instagram"></i></a><?php } ?>
                <?php if (get_theme_mod( 'cleanblog_pinterest' )!= "" ){ ?><a href="<?php echo esc_url(get_theme_mod( 'cleanblog_pinterest' )); ?>"><i class="fa fa-pinterest-p"></i></a><?php } ?>
                <?php if ((get_theme_mod( 'cleanblog_rss' )!= "") && ($cleanblogg_socialw_rss != true )){ ?><a href="<?php echo esc_url(get_theme_mod( 'cleanblog_rss' )); ?>"><i class="fa fa-rss"></i></a><?php } ?>
            </div>
       <?php
        echo $after_widget; 
    }
	public function update( $new_instance, $old_instance ) {        
        $instance = $old_instance;
        $instance['cleanblogg_social_title'] = strip_tags( $new_instance['cleanblogg_social_title'] );
		$instance['cleanblogg_socialw_rss'] = strip_tags( $new_instance['cleanblogg_socialw_rss'] );
        return $instance;
    }
	
	public function form( $instance ) {    
     $defaults = array( 'cleanblogg_social_title' => 'Follow Us','cleanblogg_socialw_rss' => false);
		$instance = wp_parse_args( (array) $instance, $defaults );
        $cleanblogg_social_title      = esc_attr( $instance['cleanblogg_social_title'] );
        $cleanblogg_socialw_rss      = esc_attr( $instance['cleanblogg_socialw_rss'] );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('cleanblogg_social_title'); ?>"><?php _e('Title:','cleanblogg'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('cleanblogg_social_title'); ?>" name="<?php echo $this->get_field_name('cleanblogg_social_title'); ?>" type="text" value="<?php echo $cleanblogg_social_title; ?>" />
        </p>
		<p>
        	<input type="checkbox" id="<?php echo $this->get_field_id( 'cleanblogg_socialw_rss' ); ?>" name="<?php echo $this->get_field_name( 'cleanblogg_socialw_rss' ); ?>" <?php checked( (bool) $instance['cleanblogg_socialw_rss'], true ); ?> />
			<label for="<?php echo $this->get_field_id( 'cleanblogg_socialw_rss' ); ?>"><?php _e('Hide RSS Icon','cleanblogg')?></label>
		</p>
        <p><strong><?php _e('Note:','cleanblogg')?></strong> <?php _e('Set your social links in the','cleanblogg')?> <br /><?php _e('Customizer &#187; Social Links','cleanblogg')?></p>
    <?php 
    }   
}
add_action( 'widgets_init', function(){
     register_widget( 'cleanblogg_Social_Widget' );
});

////////////////////////////////////////////////////////////////////////////
// Posts Widget
////////////////////////////////////////////////////////////////////////////

class cleanblogg_Posts_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'cleanblogg_posts_widget',
            __( 'Posts List (ClanBlogg)', 'cleanblogg' ),
            array(
                'classname'   => 'cleanblogg_posts_widget',
                'description' => __( 'A widget that displays Recent Posts, Popular Posts & Random Posts', 'cleanblogg' )
                )
        );
    }
	public function widget( $args, $instance ) {    
        extract( $args );
        $cleanblogg_posts_title      = apply_filters( 'widget_title', $instance['cleanblogg_posts_title'] );
        $cleanblogg_posts_number    = $instance['cleanblogg_posts_number'];
       	$cleanblogg_posts_order 	 = esc_attr($instance['cleanblogg_posts_order']); 
		$cleanblogg_posts_thumb 	 = esc_attr($instance['cleanblogg_posts_thumb']); 
		$cleanblogg_posts_category 	 = esc_attr($instance['cleanblogg_posts_category']); 
        echo $before_widget;
        if ( $cleanblogg_posts_title ) {
            echo $before_title . $cleanblogg_posts_title . $after_title;
        }
		$args = array(
		'post_type' => 'post',
		'order' => 'DESC',
		'orderby' => $cleanblogg_posts_order,
		'cat' => $cleanblogg_posts_category,
		'posts_per_page' => $cleanblogg_posts_number
		);		
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ): ?>
			<ul class="cb-posts-list">
			<?php
			while ( $the_query->have_posts() ) {
				$the_query->the_post(); ?>
				<li> 
				<?php if ( has_post_thumbnail() && ($cleanblogg_posts_thumb != true )) : ?>
				<div class="widget-post-media">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail("cleanblogg-mini-thumb"); ?></a>
				</div>
				<?php endif; ?>
				<div class="widget-post-content">
				<a href="<?php the_permalink(); ?>"><?php echo get_the_title() ?> </a>
				<span><?php the_time(); ?></span>
				</div>
				</li>
				<?php } ?>
			</ul>
		
			<?php
		else: 
			_e('No Posts Found','cleanblogg');
		endif;
wp_reset_postdata();
        echo $after_widget;    
    }
	
	public function update( $new_instance, $old_instance ) {        
        $instance = $old_instance;
        $instance['cleanblogg_posts_title'] = strip_tags( $new_instance['cleanblogg_posts_title'] );
        $instance['cleanblogg_posts_number'] = strip_tags( $new_instance['cleanblogg_posts_number'] );
        $instance['cleanblogg_posts_order'] = strip_tags( $new_instance['cleanblogg_posts_order'] );
		$instance['cleanblogg_posts_thumb'] = strip_tags( $new_instance['cleanblogg_posts_thumb'] ); 
		$instance['cleanblogg_posts_category'] = strip_tags( $new_instance['cleanblogg_posts_category'] ); 
        return $instance;
    }
	public function form( $instance ) {    
     	$defaults = array( 'cleanblogg_posts_title' => __('Recent Posts','cleanblogg'),'cleanblogg_posts_number' => '5','cleanblogg_posts_order' => 'date','cleanblogg_posts_thumb' => false, 'cleanblogg_posts_category' => 'all' ); 
		$instance = wp_parse_args( (array) $instance, $defaults );
        $cleanblogg_posts_title      = esc_attr( $instance['cleanblogg_posts_title'] );
        $cleanblogg_posts_number    = esc_attr( $instance['cleanblogg_posts_number'] );
		$cleanblogg_posts_order 	 = esc_attr($instance['cleanblogg_posts_order']);
		$cleanblogg_posts_thumb 	 = esc_attr($instance['cleanblogg_posts_thumb']);
		$cleanblogg_posts_category 	 = esc_attr($instance['cleanblogg_posts_category']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('cleanblogg_posts_title'); ?>"><?php _e('Title:','cleanblogg'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('cleanblogg_posts_title'); ?>" name="<?php echo $this->get_field_name('cleanblogg_posts_title'); ?>" type="text" value="<?php echo $cleanblogg_posts_title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('cleanblogg_posts_number'); ?>"><?php _e('Number of posts to show:','cleanblogg'); ?></label> 
            <input id="<?php echo $this->get_field_id('cleanblogg_posts_number'); ?>" name="<?php echo $this->get_field_name('cleanblogg_posts_number'); ?>" type="text" size="3" value="<?php echo $cleanblogg_posts_number; ?>" />
        </p>
     	<p>
    		<label for="<?php echo $this->get_field_id('cleanblogg_posts_order'); ?>"><?php _e('Select Order:','cleanblogg'); ?></label> 
    		<select class="widefat" id="<?php echo $this->get_field_id('cleanblogg_posts_order'); ?>" name="<?php echo $this->get_field_name('cleanblogg_posts_order'); ?>" type="text">
        		<option value="date" <?php selected($instance['cleanblogg_posts_order'], 'date'); ?>><?php _e('Most Recent','cleanblogg');?></option>
        		<option value="comment_count" <?php selected($instance['cleanblogg_posts_order'], 'comment_count');?>><?php _e('Popular','cleanblogg');?></option>
        		<option value="rand" <?php selected($instance['cleanblogg_posts_order'], 'rand');?>><?php _e('Random','cleanblogg');?></option>
    		</select>
		</p>
    	<p>
    		<label for="<?php echo $this->get_field_id('cleanblogg_posts_category'); ?>"><?php _e('Select Category:','cleanblogg'); ?></label>
    			<select id="<?php echo $this->get_field_id('cleanblogg_posts_category'); ?>" name="<?php echo $this->get_field_name('cleanblogg_posts_category'); ?>" class="widefat">
    				<option value="all" <?php selected($instance['cleanblogg_posts_category'], 'all');?>><?php _e('All Categories','cleanblogg');?></option>
            <?php foreach(get_terms('category','hide_empty=0&depth=1&type=post') as $term) { ?>
            		<option <?php selected( $instance['cleanblogg_posts_category'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
            <?php } ?>      
        		</select>
		</p>
    	<p>
        	<input type="checkbox" id="<?php echo $this->get_field_id( 'cleanblogg_posts_thumb' ); ?>" name="<?php echo $this->get_field_name( 'cleanblogg_posts_thumb' ); ?>" <?php checked( (bool) $instance['cleanblogg_posts_thumb'], true ); ?> />
        	<label for="<?php echo $this->get_field_id( 'cleanblogg_posts_thumb' ); ?>"><?php _e('Hide Thumbnails','cleanblogg');?></label>
    	</p>
    <?php 
    } 
}
add_action( 'widgets_init', function(){
     register_widget( 'cleanblogg_Posts_Widget' );
});

////////////////////////////////////////////////////////////////////////////
// Posts Tab Widget
////////////////////////////////////////////////////////////////////////////

class cleanblogg_Posts_Tab_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'cleanblogg_posts_tab_widget',
            __( 'Posts Tab (ClanBlogg)', 'cleanblogg' ),
            array(
                'classname'   => 'cleanblogg_posts_tab_widget',
                'description' => __( 'A widget that displays Tab Posts widgets', 'cleanblogg' )
                )
        );
    }
	public function widget( $args, $instance ) {    
        extract( $args );
        $cleanblogg_tab_title      = apply_filters( 'widget_title', $instance['cleanblogg_tab_title'] );
        $cleanblogg_tab_number    = $instance['cleanblogg_tab_number']; 
		$cleanblogg_tab_thumbs 	 = esc_attr($instance['cleanblogg_tab_thumbs']); 
		$cleanblogg_tab_category 	 = esc_attr($instance['cleanblogg_tab_category']); 
		$cleanblogg_tab_active 	 = esc_attr($instance['cleanblogg_tab_active']); 
        echo $before_widget;
        if ( $cleanblogg_tab_title ) {
            echo $before_title . $cleanblogg_tab_title . $after_title;
        }
?>

        <ul class="widget-nav-tabs" role="tablist">
          <li role="presentation" class="<?php if($cleanblogg_tab_active == 'recent' ){ echo 'active'; }?>"><a href="#recent" aria-controls="recent" role="tab" data-toggle="tab"><?php _e('Recent Posts','cleanblogg') ?></a></li>
          <li class="<?php if($cleanblogg_tab_active == 'popular' ){ echo 'active'; }?>" role="presentation"><a href="#popular" aria-controls="popular" role="tab" data-toggle="tab"><?php _e('Popular Posts','cleanblogg') ?></a></li>
        </ul>

        <div class="tab-content">
          <div role="tabpanel" class="tab-pane fade <?php if($cleanblogg_tab_active == 'in recent' ){ echo 'active'; } if($cleanblogg_tab_active == 'recent'){echo 'active in';}?>" id="recent">
              <?php $args = array(
      			'post_type' => 'post',
      			'order' => 'DESC',
      			'cat' => $cleanblogg_tab_category,
      			'orderby' => 'date',
      			'posts_per_page' => $cleanblogg_tab_number
      			);		
      			$the_query = new WP_Query( $args );
      			if ( $the_query->have_posts() ): ?>
                <ul class="cleanblogg-posts-list">
                <?php
                while ( $the_query->have_posts() ) {
                    $the_query->the_post(); ?>
                        <li> 
                        <?php if ( has_post_thumbnail() && ($cleanblogg_tab_thumbs != true )) : ?>
                        <div class="widget-post-media">
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail("cleanblogg-mini-thumb"); ?></a>
                        </div>
                        <?php endif; ?>
                        <div class="widget-post-content">
                        <a href="<?php the_permalink(); ?>"><?php echo get_the_title() ?> </a>
                        <span><?php the_time(); ?></span>
                        </div>
                        </li>
                    <?php } ?>
                </ul>
          <?php else:
          _e('No Posts Found','cleanblogg');
          	endif;
      		wp_reset_postdata(); ?>
          </div>
          <div role="tabpanel" class="tab-pane fade <?php if($cleanblogg_tab_active == 'popular' ){ echo 'in active'; }?>" id="popular">
          <?php $args = array(
      'post_type' => 'post',
      'order' => 'DESC',
      'cat' => $cleanblogg_tab_category,
      'orderby' => 'comment_count',
      'posts_per_page' => $cleanblogg_tab_number
      );		
      $the_query = new WP_Query( $args );
      if ( $the_query->have_posts() ): ?>
          <ul class="cleanblogg-posts-list">
          <?php
          while ( $the_query->have_posts() ) {
              $the_query->the_post(); ?>
              <li> 
              <?php if ( has_post_thumbnail() && ($cleanblogg_tab_thumbs != true )) : ?>
              <div class="widget-post-media">
                  <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail("cleanblogg-mini-thumb"); ?></a>
              </div>
              <?php endif; ?>
              <div class="widget-post-content">
              <a href="<?php the_permalink(); ?>"><?php echo get_the_title() ?> </a>
              <span><?php the_time(); ?></span>
              </div>
              </li>
              <?php } ?>
          </ul>
          <?php else:
          _e('No Posts Found','cleanblogg');
          endif;
      		wp_reset_postdata(); ?>
          </div>
        </div>

    <?php
        echo $after_widget;
    }
	public function update( $new_instance, $old_instance ) {        
        $instance = $old_instance;
        $instance['cleanblogg_tab_title'] = strip_tags( $new_instance['cleanblogg_tab_title'] );
        $instance['cleanblogg_tab_number'] = strip_tags( $new_instance['cleanblogg_tab_number'] ); 
		$instance['cleanblogg_tab_thumbs'] = strip_tags( $new_instance['cleanblogg_tab_thumbs'] );
		$instance['cleanblogg_tab_category'] = strip_tags( $new_instance['cleanblogg_tab_category'] );
		$instance['cleanblogg_tab_active'] = strip_tags( $new_instance['cleanblogg_tab_active'] );
        return $instance;
    }
	public function form( $instance ) {    
     	$defaults = array( 'cleanblogg_tab_title' => __('Posts on Tab','cleanblogg'),'cleanblogg_tab_number' => '5','cleanblogg_tab_thumbs' => false,'cleanblogg_tab_category' => 'all', 'cleanblogg_tab_active' => 'recent'); 
		$instance = wp_parse_args( (array) $instance, $defaults );
        $cleanblogg_tab_title      = esc_attr( $instance['cleanblogg_tab_title'] );
        $cleanblogg_tab_number    = esc_attr( $instance['cleanblogg_tab_number'] );
		$cleanblogg_tab_thumbs 	 = esc_attr($instance['cleanblogg_tab_thumbs']);
		$cleanblogg_tab_category 	 = esc_attr($instance['cleanblogg_tab_category']);
		$cleanblogg_tab_active 	 = esc_attr($instance['cleanblogg_tab_active']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('cleanblogg_tab_title'); ?>"><?php _e('Title:','cleanblogg'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('cleanblogg_tab_title'); ?>" name="<?php echo $this->get_field_name('cleanblogg_tab_title'); ?>" type="text" value="<?php echo $cleanblogg_tab_title; ?>" />
        </p>
<p>
            <label for="<?php echo $this->get_field_id('cleanblogg_tab_number'); ?>"><?php _e('Number of posts to show:','cleanblogg'); ?></label> 
            <input id="<?php echo $this->get_field_id('cleanblogg_tab_number'); ?>" name="<?php echo $this->get_field_name('cleanblogg_tab_number'); ?>" type="text" size="3" value="<?php echo $cleanblogg_tab_number; ?>" />
        </p>
        <p>
    		<label for="<?php echo $this->get_field_id('cleanblogg_tab_active'); ?>"><?php _e('Activate a Tab:','cleanblogg'); ?></label> 
    		<select class="widefat" id="<?php echo $this->get_field_id('cleanblogg_tab_active'); ?>" name="<?php echo $this->get_field_name('cleanblogg_tab_active'); ?>" type="text">
        		<option value="recent" <?php selected($instance['cleanblogg_tab_active'], 'recent'); ?>>Recent Posts</option>
        		<option value="popular" <?php selected($instance['cleanblogg_tab_active'], 'popular');?>>Popular Posts</option>
    		</select>
		</p>
         <p>
    		<label for="<?php echo $this->get_field_id('cleanblogg_tab_category'); ?>"><?php _e('Select Category:','cleanblogg'); ?></label>
            <select id="<?php echo $this->get_field_id('cleanblogg_tab_category'); ?>" name="<?php echo $this->get_field_name('cleanblogg_tab_category'); ?>" class="widefat">
                <option value="all" <?php selected($instance['cleanblogg_tab_category'], 'all');?>>All Categories</option>
                <?php foreach(get_terms('category','hide_empty=0&depth=1&type=post') as $term) { ?>
                <option <?php selected( $instance['cleanblogg_tab_category'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                <?php } ?>      
            </select>
		</p>  
		<p>
        	<input type="checkbox" id="<?php echo $this->get_field_id( 'cleanblogg_tab_thumbs' ); ?>" name="<?php echo $this->get_field_name( 'cleanblogg_tab_thumbs' ); ?>" <?php checked( (bool) $instance['cleanblogg_tab_thumbs'], true ); ?> />
			<label for="<?php echo $this->get_field_id( 'cleanblogg_tab_thumbs' ); ?>"><?php _e('Hide Thumbnails','cleanblogg') ?></label>
		</p>
    <?php 
    }   
}
add_action( 'widgets_init', function(){
     register_widget( 'cleanblogg_Posts_Tab_Widget' );
});
?>