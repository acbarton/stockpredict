<?php
global $speedy_panels;
global $speedy_sections;
global $speedy_settings_controls;
global $speedy_repeated_settings_controls;
global $speedy_customizer_defaults;

/*creating panel for general*/
$speedy_panels['speedy-colors'] =
    array(
        'title'          => __( 'Colors', 'speedy' ),
        'description'    => __( 'Customize colors of your site', 'speedy' ),
        'priority'       => 42,
    );

/*Default color*/
$speedy_sections['colors'] =
    array(
        'priority'       => 40,
        'title'          => __( 'Basic Colors Options', 'speedy' ),
        'panel'          => 'speedy-colors',
    );

/*defaults values*/
$speedy_customizer_defaults['speedy-h1-h6-color'] = '#212121';
$speedy_customizer_defaults['speedy-link-color'] = '#212121';
$speedy_customizer_defaults['speedy-link-hover-color'] = '#D7942A';
$speedy_customizer_defaults['speedy-site-identity-color'] = '#212121';

$speedy_customizer_defaults['speedy-color-reset'] = '';


/**
 * Reset color settings to default
 * @param  $input
 *
 * @since speedy 1.0
 */
if ( ! function_exists( 'speedy_color_reset' ) ) :
    function speedy_color_reset( $input ) {
        if ( $input == 1 ) {
            global $speedy_customizer_defaults;

            /*getting fields*/
            $speedy_customizer_saved_values = speedy_get_all_options();

            /*setting fields */
            $speedy_customizer_saved_values['speedy-h1-h6-color'] = $speedy_customizer_defaults['speedy-h1-h6-color'];
            $speedy_customizer_saved_values['speedy-link-color'] = $speedy_customizer_defaults['speedy-link-color'];
            $speedy_customizer_saved_values['speedy-link-hover-color'] = $speedy_customizer_defaults['speedy-link-hover-color'];
            $speedy_customizer_saved_values['speedy-site-identity-color'] = $speedy_customizer_defaults['speedy-site-identity-color'];

            $speedy_customizer_defaults['speedy-color-reset'] = '';

            /*resetting fields*/
            speedy_reset_options( $speedy_customizer_saved_values );
        }
        else {
            return '';
        }
    }
endif;

$speedy_settings_controls['speedy-site-identity-color'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-site-identity-color'],
        ),
        'control' => array(
            'label'                 =>  __( 'Site Identity Color', 'speedy' ),
            'description'           =>  __( 'Site title and tagline color', 'speedy' ),
            'section'               => 'colors',
            'type'                  => 'color',
            'priority'              => 40,
            'active_callback'       => ''
        )
    );

$speedy_settings_controls['speedy-link-color'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-link-color'],
        ),
        'control' => array(
            'label'                 =>  __( 'Link Color', 'speedy' ),
            'section'               => 'colors',
            'type'                  => 'color',
            'priority'              => 50,
            'active_callback'       => ''
        )
    );
$speedy_settings_controls['speedy-link-hover-color'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-link-hover-color'],
        ),
        'control' => array(
            'label'                 =>  __( 'Link Hover Color', 'speedy' ),
            'section'               => 'colors',
            'type'                  => 'color',
            'priority'              => 60,
            'active_callback'       => ''
        )
    );
$speedy_settings_controls['speedy-h1-h6-color'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-h1-h6-color'],
        ),
        'control' => array(
            'label'                 =>  __( 'Heading (H1-H6) Color', 'speedy' ),
            'section'               => 'colors',
            'type'                  => 'color',
            'priority'              => 70,
            'active_callback'       => ''
        )
    );

/*Speedy colors setting controls*/
$speedy_settings_controls['speedy-color-reset'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-color-reset'],
            'sanitize_callback'    => 'speedy_color_reset',
            'transport'            => 'postmessage',
        ),
        'control' => array(
            'label'                 =>  __( 'Speedy Colors Reset', 'speedy' ),
            'description'           =>  __( 'Caution: Reset all above color settings to default. Refresh the page after save to view the effects. ', 'speedy' ),
            'section'               => 'colors',
            'type'                  => 'checkbox',
            'priority'              => 220,
            'active_callback'       => ''
        )
    );