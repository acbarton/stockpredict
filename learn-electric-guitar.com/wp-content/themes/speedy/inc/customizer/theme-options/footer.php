<?php
global $speedy_sections;
global $speedy_settings_controls;
global $speedy_repeated_settings_controls;
global $speedy_customizer_defaults;

/*defaults values*/
$speedy_customizer_defaults['speedy-copyright-text'] = __('Copyright &copy; All right reserved','speedy');

$speedy_sections['speedy-footer-options'] =
    array(
        'priority'       => 60,
        'title'          => __( 'Footer Options', 'speedy' ),
        'panel'          => 'speedy-theme-options'
    );


$speedy_settings_controls['speedy-copyright-text'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-copyright-text'],
        ),
        'control' => array(
            'label'                 =>  __( 'Copyright Text', 'speedy' ),
            'section'               => 'speedy-footer-options',
            'type'                  => 'text_html',
            'priority'              => 20,
        )
    );
