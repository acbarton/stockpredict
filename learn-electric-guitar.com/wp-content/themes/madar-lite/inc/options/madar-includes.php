<?php
/*	@ Madar Includes Function
*/
function madarlite_includes($type, $data = '', $add = 'true'){
	switch ( $type ) :
		case "post-thumbnail": 
			echo madarlite_post_thubmnail($data, $add);
		break;
		case "related-post":
			echo madarlite_related_post();
		break;
		case "post-navigation":
			echo madarlite_post_navigation();
		break;
	endswitch;

} ?>