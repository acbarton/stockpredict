<?php


// Extend WP_Widget with our widget.
class madarlite_random_post_widgets extends WP_Widget {
/*	Widget Setup
*/
	
	function __construct() {
		// Widget setup
		$widget_ops = array('classname' => 'madarlite_random_post_widgets', 'description' => 'Displays random post with thumbnail' );
		// Widget UI
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'madarlite_random_post_widgets' );
		// Widget name and description
		parent::__construct('madarlite_random_post_widgets', 'Madar : Random Post', $widget_ops);
	}
	
/*	Widget Settings
*/
	function form($instance) {
	/* Default Widget Settings */
	$defaults = array(
		'title' => 'Random Posts',
		'number' => '5'
	);
    $instance = wp_parse_args( (array) $instance, $defaults );
	
    /* Variable Widget Settings */
	$title = $instance['title']; 
	$number = $instance['number']; ?>
	
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">Title: </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('number'); ?>">Post Count: </label>
		<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
	</p>
	
	<?php
	}
  
/*	Update The Widget With New Options
*/
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
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
		
		// Before widget - as defined in your specific theme. */
		echo $before_widget;
		
		/* Display The Widget */
		// Widget code goes here (Edit if you want)
		if (!empty($title))
		
		echo $before_title . $title . $after_title;
				
		/* Create a new post query */
		$query = new WP_Query( array( 
			'posts_per_page' => $number, 
			'orderby' => 'rand', 
		));

		//Send our widget options to the query
			if( $query->have_posts() ) : ?>
				<ul class="madar-widget popular-widget image-widget">
					<?php echo madarlite_postlisting('random', $query) ?>	
				</ul>
			<?php endif;

		/* After widget - as defined in your specific theme. */
		echo $after_widget;
	}
 
}
?>