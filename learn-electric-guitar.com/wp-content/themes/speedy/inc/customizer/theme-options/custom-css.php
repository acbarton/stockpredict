<?php
global $speedy_sections;
global $speedy_settings_controls;
global $speedy_repeated_settings_controls;
global $speedy_customizer_defaults;

/*defaults values*/
$speedy_customizer_defaults['speedy-custom-css'] = '';

$speedy_sections['speedy-custom-css'] =
    array(
        'priority'       => 120,
        'title'          => __( 'Custom CSS', 'speedy' ),
        'panel'          => 'speedy-theme-options'
    );

$speedy_settings_controls['speedy-custom-css'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-custom-css'],
        ),
        'control' => array(
            'label'                 =>  __( 'Custom CSS', 'speedy' ),
            'section'               => 'speedy-custom-css',
            'type'                  => 'textarea',
            'priority'              => 40,
        )
    );