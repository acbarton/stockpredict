<?php


// Extend WP_Widget with our widget.
class madarlite_recent_comment_widgets extends WP_Widget {

/*	Widget Setup
*/
	
	function __construct() {
		// Widget setup
		$widget_ops = array('classname' => 'madarlite_recent_comment_widgets', 'description' => 'Displays recent comment with avatar' );
		// Widget UI
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'madarlite_recent_comment_widgets' );
		// Widget name and description
		parent::__construct('madarlite_recent_comment_widgets', 'Madar : Recent Comment Widget', $widget_ops);
	}
	
/*	Widget Settings
*/
	function form($instance) {
	/* Default Widget Settings */
	$defaults = array(
		'title' => 'Recent Comment',
		'number' => '3'
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
		<label for="<?php echo $this->get_field_id('number'); ?>">Comment Count: </label>
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
	global $wpdb;
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
				
		/* Create a new query */
		$query = "SELECT * from $wpdb->comments WHERE comment_approved= '1'
		ORDER BY comment_date DESC LIMIT 0, $number";
		$comments = $wpdb->get_results($query);

		//Send our widget options to the query
			if( $comments ) : ?>
				<ul class="madar-widget recent-comment image-widget">
					<?php foreach ($comments as $comment) : ?>
					<li>
					<div class="widget-thumb">
						<a href="<?php echo esc_url( get_permalink($comment->comment_post_ID) ) . '#comment-' . $comment->comment_ID ?>" title="<?php echo $comment->comment_author .' | '.get_the_title($comment->comment_post_ID); ?>" class="madar-thumb">
							<?php echo get_avatar( $comment->comment_author_email, 55);?>
						</a>
					</div>
					<h3>
						<a href="<?php echo esc_url( get_permalink($comment->comment_post_ID) ) . '#comment-' . $comment->comment_ID ?>" title="<?php echo $comment->comment_author .' | '.get_the_title($comment->comment_post_ID); ?>">
							<?php echo $comment->comment_author;?>
						</a>
					</h3>
					<div class="widget-meta">
						<?php echo madarlite_comment_excerpt( $comment->comment_ID ); ?>
					</div>
					</li>
					<?php endforeach; ?>
				</ul>
			<?php endif;
		echo $after_widget;
	}
 
}
?>