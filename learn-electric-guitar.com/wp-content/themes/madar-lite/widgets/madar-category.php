<?php

// Extend WP_Widget with our widget.
class madarlite_category_widgets extends WP_Widget {
/*	Widget Setup
*/
	
	function __construct() {
		// Widget setup
		$widget_ops = array('classname' => 'madarlite_category_widgets', 'description' => 'Display post by category' );
		// Widget UI
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'madarlite_category_widgets' );
		// Widget name and description
		parent::__construct('madarlite_category_widgets', 'Madar : Post by Category', $widget_ops);
	}
	
/*	Widget Settings
*/
	function form($instance) {
	global $madarlite_wp_cats;
	/* Default Widget Settings */
	$defaults = array(
		'title' => 'By Category',
		'number' => '5'
	);
    $instance = wp_parse_args( (array) $instance, $defaults );
	
    /* Variable Widget Settings */
	$title = $instance['title']; 
	$category  	= isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
	$number = $instance['number']; ?>
	
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">Title: </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('number'); ?>">Post Count: </label>
		<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
	</p>
	<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Enter the slug for your category or leave empty to show posts from all categories.', 'madar-lite' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo $category; ?>" size="3" /></p>

	<?php
	}
  
/*	Update The Widget With New Options
*/
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category'] 	= strip_tags($new_instance['category']);
		$instance['number'] = strip_tags( $new_instance['number'] );
		return $instance;
	}
	
/*	Display The Widget To The Front End
*/
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
 			
		//Widget title, entered in the widget settings
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		
		/* Custom Options */
		$number = $instance['number'];
		$category 	= isset( $instance['category'] ) ? esc_attr($instance['category']) : '';
		
		// Before widget - as defined in your specific theme. */
		echo $before_widget;
		
		/* Display The Widget */
		// Widget code goes here (Edit if you want)
		if (!empty($title))
		
		echo $before_title . $title . $after_title;
				
		/* Create a new post query */
		$query = new WP_Query( array( 
			'posts_per_page' => $number, 
			'category_name' 	  => $category,
		));

		//Send our widget options to the query
			if( $query->have_posts() ) : ?>
				<ul class="madar-widget cat-widget image-widget">
					<?php echo madarlite_postlisting('category', $query) ?>	
				</ul>
			<?php endif;

		/* After widget - as defined in your specific theme. */
		echo $after_widget;
	}
 
}
?>