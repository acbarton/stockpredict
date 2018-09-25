<?php
/**
 * evision themes Theme Customizer
 *
 * @package eVision themes
 * @subpackage speedy
 * @since speedy 1.0.0
 */
add_filter('evision_customizer_framework_url', 'speedy_customizer_framework_url');

if( ! function_exists( 'speedy_customizer_framework_url' ) ):

    function speedy_customizer_framework_url(){
        return trailingslashit( get_template_directory_uri() ) . 'inc/frameworks/evision-customizer/';
    }

endif;

add_filter('evision_customizer_framework_path', 'speedy_customizer_framework_path');

if( ! function_exists( 'speedy_customizer_framework_path' ) ):
    function speedy_customizer_framework_path(){
        return trailingslashit( get_template_directory() ) . 'inc/frameworks/evision-customizer/';
    }
endif;

/*define constant for coder-customizer-constant*/
if(!defined('EVISION_CUSTOMIZER_NAME')){
    define('EVISION_CUSTOMIZER_NAME','speedy-options');
}


/**
 * reset options
 * @param  array $reset_options
 * @return void
 *
 * @since speedy 1.0
 */
if ( ! function_exists( 'speedy_reset_options' ) ) :
    function speedy_reset_options( $reset_options ) {
        set_theme_mod( EVISION_CUSTOMIZER_NAME, $reset_options );
    }
endif;
/**
 * Customizer framework added.
 */
require get_template_directory().'/inc/frameworks/evision-customizer/evision-customizer.php';

global $speedy_panels;
global $speedy_sections;
global $speedy_settings_controls;
global $speedy_repeated_settings_controls;
global $speedy_customizer_defaults;

/******************************************
Modify Site Color sections
 *******************************************/
require get_template_directory().'/inc/customizer/colors/general.php';

/******************************************
Modify Banner Title sections
 *******************************************/
require get_template_directory().'/inc/customizer/header-option/banner-title.php';

/******************************************
Modify Custom Header sections
 *******************************************/
require get_template_directory().'/inc/customizer/header-option/custom-header.php';

/******************************************
Added font setting options
 *******************************************/
require get_template_directory().'/inc/customizer/font-setting/font-family.php';

/******************************************
Home page options
 *******************************************/
require get_template_directory().'/inc/customizer/home-options/home-options.php';

/******************************************
Theme options panel
 *******************************************/
require get_template_directory().'/inc/customizer/theme-options/option-panel.php';

/*Resetting all Values*/
/**
 * Reset color settings to default
 * @param  $input
 *
 * @since speedy 1.0
 */
$speedy_customizer_defaults['speedy-customizer-reset'] = '';
if ( ! function_exists( 'speedy_customizer_reset' ) ) :
    function speedy_customizer_reset( $input ) {
        if ( $input == 1 ) {
            global $speedy_customizer_defaults;

            $speedy_customizer_defaults['speedy-customizer-reset'] = '';
            /*resetting fields*/
            speedy_reset_options( $speedy_customizer_defaults );
        }
        else {
            return '';
        }
    }
endif;
$speedy_sections['speedy-customizer-reset'] =
    array(
        'priority'       => 999,
        'title'          => __( 'Reset All Options', 'speedy' )
    );
$speedy_settings_controls['speedy-customizer-reset'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-customizer-reset'],
            'sanitize_callback'    => 'speedy_customizer_reset',
            'transport'            => 'postmessage'
        ),
        'control' => array(
            'label'                 =>  __( 'Reset All Options', 'speedy' ),
            'description'           =>  __( 'Caution: Reset all options settings to default. Refresh the page after save to view the effects. ', 'speedy' ),
            'section'               => 'speedy-customizer-reset',
            'type'                  => 'checkbox',
            'priority'              => 10
        )
    );

/******************************************
Removing section setting control
 *******************************************/

$speedy_customizer_args = array(
    'panels'            => $speedy_panels, /*always use key panels */
    'sections'          => $speedy_sections,/*always use key sections*/
    'settings_controls' => $speedy_settings_controls,/*always use key settings_controls*/
    'repeated_settings_controls' => $speedy_repeated_settings_controls,/*always use key sections*/

);

/*registering panel section setting and control start*/
function speedy_add_panels_sections_settings() {
    global $speedy_customizer_args;
    return $speedy_customizer_args;
}
add_filter( 'evision_customizer_panels_sections_settings', 'speedy_add_panels_sections_settings' );
/*registering panel section setting and control end*/

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function speedy_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'speedy_customize_register' );
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function speedy_customize_preview_js() {
    wp_enqueue_script( 'speedy-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20160105', true );
}
add_action( 'customize_preview_init', 'speedy_customize_preview_js' );



/**
 * get all saved options
 * @param  null
 * @return array saved options
 *
 * @since speedy 1.0
 */
if ( ! function_exists( 'speedy_get_all_options' ) ) :
    function speedy_get_all_options( $merge_default = 0 ) {
        $speedy_customizer_saved_values = evision_customizer_get_all_values( );
        if( 1 == $merge_default ){
            global $speedy_customizer_defaults;
            if(is_array( $speedy_customizer_saved_values )){
                $speedy_customizer_saved_values = array_merge($speedy_customizer_defaults, $speedy_customizer_saved_values );
            }
            else{
                $speedy_customizer_saved_values = $speedy_customizer_defaults;
            }
        }
        return $speedy_customizer_saved_values;
    }
endif;