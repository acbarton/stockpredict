<?php
global $speedy_sections;
global $speedy_settings_controls;
global $speedy_repeated_settings_controls;
global $speedy_customizer_defaults;

/*defaults values*/
$speedy_customizer_defaults['speedy-enable-social-icons'] = '';

$speedy_sections['speedy-header-options'] =
    array(
        'priority'       => 40,
        'title'          => __( 'Header Options', 'speedy' ),
        'panel'          => 'speedy-theme-options'
    );

$speedy_settings_controls['speedy-enable-social-icons'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-enable-social-icons'],
        ),
        'control' => array(
            'label'                 =>  __( 'Enable Social', 'speedy' ),
            'description'                 =>  __( 'Please add Social menus for enabling Social menus. Go to Menus for setting up', 'speedy' ),
            'section'               => 'speedy-header-options',
            'type'                  => 'checkbox',
            'priority'              => 30,
        )
    );