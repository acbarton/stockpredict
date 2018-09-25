<?php
/*
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Theme_Check
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses theme_check_header_style()
 */
function theme_check_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'theme_check_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '#414141',
		'width'                  => 1170,
		'height'                 => 470,
		'flex-height'            => true
	) ) );
}
add_action( 'after_setup_theme', 'theme_check_custom_header_setup' );
