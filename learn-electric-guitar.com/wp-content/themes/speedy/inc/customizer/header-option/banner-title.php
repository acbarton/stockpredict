<?php
global $speedy_sections;
global $speedy_settings_controls;
global $speedy_repeated_settings_controls;
global $speedy_customizer_defaults;

/*defaults values*/
$speedy_customizer_defaults['speedy-banner-title'] = __('MAKE WEBSITE IN SPEEDY WAY!','speedy');
$speedy_customizer_defaults['speedy-home-banner-enable'] = 0;

/*creating setting control*/
$speedy_settings_controls['speedy-banner-title'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-banner-title'],
        ),
        'control' => array(
            'label'                 =>  __( 'Banner Title', 'speedy' ),
            'section'               => 'header_image',
            'type'                  => 'text',
            'priority'              => 70,
            'active_callback'       => ''
        )
    );

/*enable option for enable banner title in header*/
$speedy_settings_controls['speedy-home-banner-enable'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-home-banner-enable'],
        ),
        'control' => array(
            'label'                 =>  __( 'Enable Features', 'speedy' ),
            'description'           =>  __( 'This section will only appear on your front/home page', 'speedy' ),
            'section'               => 'header_image',
            'type'                  => 'checkbox',
            'priority'              => 8,
            'active_callback'       => ''
        )
    );
