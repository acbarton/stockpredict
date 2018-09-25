<?php

function tuto_customize_register($wp_customize) {

    /***** Add Panels *****/

	$wp_customize->add_panel('tuto_theme_options', array('title' => esc_html__('Theme Options', 'tuto'), 'description' => '', 'capability' => 'edit_theme_options', 'theme_supports' => '', 'priority' => 1));

	/***** Add Sections *****/

	$wp_customize->add_section('tuto_general', array('title' => esc_html__('General', 'tuto'), 'priority' => 1, 'panel' => 'tuto_theme_options'));
	$wp_customize->add_section('tuto_layout', array('title' => esc_html__('Layout', 'tuto'), 'priority' => 2, 'panel' => 'tuto_theme_options'));

    /***** Add Settings *****/

    $wp_customize->add_setting('tuto_options[excerpt_length]', array('default' => 25, 'type' => 'option', 'sanitize_callback' => 'tuto_sanitize_integer'));
    $wp_customize->add_setting('tuto_options[excerpt_more]', array('default' => esc_html__('Read More', 'tuto'), 'type' => 'option', 'sanitize_callback' => 'tuto_sanitize_text'));
    $wp_customize->add_setting('tuto_options[magazine_layout]', array('default' => 'enable', 'type' => 'option', 'sanitize_callback' => 'tuto_sanitize_select'));
    $wp_customize->add_setting('tuto_options[sb_position]', array('default' => 'right', 'type' => 'option', 'sanitize_callback' => 'tuto_sanitize_select'));
    $wp_customize->add_setting('tuto_options[author_box]', array('default' => 'enable', 'type' => 'option', 'sanitize_callback' => 'tuto_sanitize_select'));
    $wp_customize->add_setting('tuto_options[post_nav]', array('default' => 'enable', 'type' => 'option', 'sanitize_callback' => 'tuto_sanitize_select'));
    $wp_customize->add_setting('tuto_options[full_bg]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'tuto_sanitize_checkbox'));

    /***** Add Controls *****/

    $wp_customize->add_control('excerpt_length', array('label' => esc_html__('Custom excerpt length in words', 'tuto'), 'section' => 'tuto_general', 'settings' => 'tuto_options[excerpt_length]', 'priority' => 1, 'type' => 'text'));
    $wp_customize->add_control('excerpt_more', array('label' => esc_html__('Custom excerpt more text', 'tuto'), 'section' => 'tuto_general', 'settings' => 'tuto_options[excerpt_more]', 'priority' => 2, 'type' => 'text'));
    $wp_customize->add_control('magazine_layout', array('label' => esc_html__('Magazine Layout on Archives', 'tuto'), 'section' => 'tuto_layout', 'settings' => 'tuto_options[magazine_layout]', 'priority' => 1, 'type' => 'select', 'choices' => array('enable' => esc_html__('Enable', 'tuto'), 'disable' => esc_html__('Disable', 'tuto'))));
    $wp_customize->add_control('sb_position', array('label' => esc_html__('Position of default sidebar', 'tuto'), 'section' => 'tuto_layout', 'settings' => 'tuto_options[sb_position]', 'priority' => 2, 'type' => 'select', 'choices' => array('left' => esc_html__('Left', 'tuto'), 'right' => esc_html__('Right', 'tuto'))));
    $wp_customize->add_control('author_box', array('label' => esc_html__('Author Box', 'tuto'), 'section' => 'tuto_layout', 'settings' => 'tuto_options[author_box]', 'priority' => 3, 'type' => 'select', 'choices' => array('enable' => esc_html__('Enable', 'tuto'), 'disable' => esc_html__('Disable', 'tuto'))));
    $wp_customize->add_control('post_nav', array('label' => esc_html__('Post/Attachment Navigation', 'tuto'), 'section' => 'tuto_layout', 'settings' => 'tuto_options[post_nav]', 'priority' => 4, 'type' => 'select', 'choices' => array('enable' => esc_html__('Enable', 'tuto'), 'disable' => esc_html__('Disable', 'tuto'))));
	$wp_customize->add_control('full_bg', array('label' => esc_html__('Scale background image to full size', 'tuto'), 'section' => 'background_image', 'settings' => 'tuto_options[full_bg]', 'priority' => 99, 'type' => 'checkbox'));
}
add_action('customize_register', 'tuto_customize_register');

/***** Data Sanitization *****/

function tuto_sanitize_text($input) {
    return wp_kses_post(force_balance_tags($input));
}
function tuto_sanitize_integer($input) {
    return strip_tags($input);
}
function tuto_sanitize_checkbox($input) {
    if ($input == 1) {
        return 1;
    } else {
        return '';
    }
}
function tuto_sanitize_select($input) {
    $valid = array(
        'left' => esc_html__('Left', 'tuto'),
        'right' => esc_html__('Right', 'tuto'),
        'enable' => esc_html__('Enable', 'tuto'),
        'disable' => esc_html__('Disable', 'tuto'),
    );
    if (array_key_exists($input, $valid)) {
        return $input;
    } else {
        return '';
    }
}

/***** Return Theme Options / Set Default Options *****/

if (!function_exists('tuto_theme_options')) {
	function tuto_theme_options() {
		$theme_options = wp_parse_args(
			get_option('tuto_options', array()),
			tuto_default_options()
		);
		return $theme_options;
	}
}

if (!function_exists('tuto_default_options')) {
	function tuto_default_options() {
		$default_options = array(
			'excerpt_length' => 25,
			'excerpt_more' => esc_html__('Read More', 'tuto'),
			'magazine_layout' => 'enable',
			'sb_position' => 'right',
			'author_box' => 'enable',
			'post_nav' => 'enable',
			'full_bg' => ''
		);
		return $default_options;
	}
}

?>