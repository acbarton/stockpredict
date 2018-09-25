<?php

/***** Register Widgets *****/

function tuto_register_widgets() {
	register_widget('tuto_custom_posts_widget');
}
add_action('widgets_init', 'tuto_register_widgets');

/***** Include Widgets *****/

require_once('widgets/mh-custom-posts.php');

?>