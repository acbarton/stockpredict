<?php
/**
 * Speedy functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Speedy
 */
/**
 * require speedy int.
 */

require get_template_directory().'/inc/init.php';

if ( ! function_exists( 'speedy_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function speedy_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Speedy, use a find and replace
	 * to change 'speedy' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'speedy', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'speedy' ),
		'social' => esc_html__( 'Social Menu', 'speedy' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	define( 'NO_HEADER_TEXT', true );
	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'speedy_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	/*implimenting new feature from 4.5*/
	add_theme_support( 'custom-logo', array(
	   'height'      => 50,
	   'width'       => 165,
	   'flex-width' => true
	) );
	
	add_theme_support( 'custom-logo', array(
	   'header-text' => array( 'site-title', 'site-description' ),
	) );

}
endif;
add_action( 'after_setup_theme', 'speedy_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function speedy_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'speedy_content_width', 640 );
}
add_action( 'after_setup_theme', 'speedy_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */

function speedy_scripts() {

	global $speedy_customizer_all_values;

	/*Bootstrap css*/
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/frameworks/bootstrap/css/bootstrap.css', array(), '3.3.4' );/*added*/

	/*google font*/
	$speedy_font_family_body = $speedy_customizer_all_values['speedy-font-family-body'];
	$speedy_font_family_h1_h6 = $speedy_customizer_all_values['speedy-font-family-h1-h6'];
	$speedy_font_family_site_identity = $speedy_customizer_all_values['speedy-font-family-site-identity'];

	wp_enqueue_style( 'speedy-googleapis-body', '//fonts.googleapis.com/css?family='.$speedy_font_family_body.'', array(), '' );/*added*/
	wp_enqueue_style( 'speedy-googleapis-heading', '//fonts.googleapis.com/css?family='.$speedy_font_family_h1_h6.'', array(), '' );/*added*/
	wp_enqueue_style( 'speedy-googleapis-site-identity', '//fonts.googleapis.com/css?family='.$speedy_font_family_site_identity.'', array(), '' );/*added*/
	wp_enqueue_style( 'speedy-googleapis-other-font-family', '//fonts.googleapis.com/css?family=Lato', array(), '' );/*added*/
	/*Font-Awesome-master*/
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/frameworks/Font-Awesome/css/font-awesome.min.css', array(), '4.4.0' );/*added*/

	/*animate css*/
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/frameworks/wow/css/animate.min.css', array(), '3.4.0' );/*added*/
	wp_enqueue_script('wow', get_template_directory_uri() . '/assets/frameworks/wow/js/wow.min.js', array('jquery'), '1.1.2', 1);

	/* mmenu */
	wp_enqueue_style( 'mmenu', get_template_directory_uri() . '/assets/frameworks/mmenu/css/jquery.mmenu.all.css' );/*added*/

	/*main style*/
    wp_enqueue_style( 'speedy-style', get_stylesheet_uri() );

    /*jquery start*/
	wp_enqueue_script( 'mmenu', get_template_directory_uri() . '/assets/frameworks/mmenu/js/jquery.mmenu.min.all.js', array('jquery'), '4.7.5', false );

	wp_enqueue_script('jquery-easing', get_template_directory_uri() . '/assets/frameworks/jquery.easing/jquery.easing.js', array('jquery'), '0.3.6', 1);
	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/frameworks/bootstrap/js/bootstrap.min.js', array('jquery'), '3.3.5', 1);

    wp_enqueue_script( 'speedy-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20130115', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) && !(is_front_page()) ) {
        wp_enqueue_script( 'comment-reply' );
    }

	/*custom js*/
	wp_enqueue_script('speedy-custom', get_template_directory_uri() . '/assets/js/speedy-custom.js', array('jquery'), '1.0.0', 1);
	// Load the html5 shiv and respond js.
	wp_enqueue_script( 'html5', get_template_directory_uri() . '/assets/frameworks/html5shiv/html5shiv.min.js', array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'respond', get_template_directory_uri() . '/assets/frameworks/respond/respond.min.js', array(), '1.4.2' );
	wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'speedy_scripts' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory().'/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory().'/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory().'/inc/jetpack.php';