<?php
global $speedy_panels;
/*creating panel for fonts-setting*/
$speedy_panels['speedy-theme-options'] =
    array(
        'title'          => __( 'Theme Options', 'speedy' ),
        'priority'       => 200
    );

/*layout options */
require get_template_directory().'/inc/customizer/theme-options/layout-options.php';

/*footer options */
require get_template_directory().'/inc/customizer/theme-options/footer.php';

/*header options */
require get_template_directory().'/inc/customizer/theme-options/header.php';

/*custom css options */
require get_template_directory().'/inc/customizer/theme-options/custom-css.php';