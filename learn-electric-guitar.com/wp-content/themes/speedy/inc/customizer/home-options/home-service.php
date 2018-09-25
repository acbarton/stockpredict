<?php
global $speedy_panels;
global $speedy_sections;
global $speedy_settings_controls;
global $speedy_repeated_settings_controls;
global $speedy_customizer_defaults;

/*defaults values*/
$speedy_customizer_defaults['speedy-home-service-page-icon'] = 'fa-desktop';
$speedy_customizer_defaults['speedy-home-service-pages'] = 0;
$speedy_customizer_defaults['speedy-home-service-enable'] = 0;

/*page selection*/
$speedy_sections['speedy-home-service-options'] =
    array(
        'priority'       => 190,
        'title'          => __( 'Home/Front Featured Options', 'speedy' ),
    );

/*creating setting control for speedy-home-service-page start*/
$speedy_settings_controls['speedy-home-service-enable'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-home-service-enable']
        ),
        'control' => array(
            'label'                 =>  __( 'Enable feature', 'speedy' ),
            'description'           =>  __( 'This section will only appear on your front/home page', 'speedy' ),
            'section'               => 'speedy-home-service-options',
            'type'                  => 'checkbox',
            'priority'              => 5,
            'active_callback'       => ''
        )
    );

$speedy_repeated_settings_controls['speedy-home-service-pages'] =
    array(
        'repeated' => 3,
        'speedy-home-service-page-icon' => array(
            'setting' =>     array(
                'default'              => $speedy_customizer_defaults['speedy-home-service-page-icon'],
            ),
            'control' => array(
                'label'                 =>  __( 'Icon %s', 'speedy' ),
                'section'               => 'speedy-home-service-options',
                'type'                  => 'text',
                'priority'              => 5,
                'description'           => sprintf( __( 'Use font awesome icon: Eg: %s. %sSee more here%s', 'speedy' ), 'fa-desktop','<a href="'.esc_url('http://fontawesome.io/cheatsheet/').'" target="_blank">','</a>' ),
            )
        ),
        'speedy-home-service-pages-ids' => array(
            'setting' =>     array(
                'default'              => $speedy_customizer_defaults['speedy-home-service-pages'],
            ),
            'control' => array(
                'label'                 =>  __( 'Select Page For feature %s', 'speedy' ),
                'section'               => 'speedy-home-service-options',
                'type'                  => 'dropdown-pages',
                'priority'              => 10,
                'description'           => ''
            )
        ),
        'speedy-home-service-pages-divider' => array(
            'control' => array(
                'section'               => 'speedy-home-service-options',
                'type'                  => 'message',
                'priority'              => 20,
                'description'           => '<br /><hr />'
            )
        )
    );
