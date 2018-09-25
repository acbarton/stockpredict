<?php
/**
 * evision themes init file
 *
 * @package eVision themes
 * @subpackage Speedy
 * @since Speedy 1.0.0
 */

/**
 * Customizer additions.
 */
require get_template_directory().'/inc/customizer/customizer.php';

/**
 * Include Functions
 */
require get_template_directory().'/inc/function/breadcrumb.php';

require get_template_directory().'/inc/function/words-count.php';

require get_template_directory().'/inc/function/header-logo.php';

/**
 * Include Hooks
 */
require get_template_directory().'/inc/hooks/excerpt.php';

require get_template_directory().'/inc/hooks/init.php';

require get_template_directory().'/inc/hooks/wp-head.php';

require get_template_directory().'/inc/hooks/header.php';

require get_template_directory().'/inc/hooks/footer.php';

require get_template_directory().'/inc/hooks/posts-navigation.php';

require get_template_directory().'/inc/hooks/homepage-service.php';

/**
 * Include sidebar widgets
 */
require get_template_directory().'/inc/sidebar-widget-init.php';