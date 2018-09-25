<?php
global $speedy_sections;
global $speedy_settings_controls;
global $speedy_repeated_settings_controls;
global $speedy_customizer_defaults;

/*defaults values*/
$speedy_customizer_defaults['speedy-default-layout'] = 'right-sidebar';


$speedy_sections['speedy-layout-options'] =
    array(
        'priority'       => 20,
        'title'          => __( 'Layout Options', 'speedy' ),
        'panel'          => 'speedy-theme-options',
    );

/*layout-options option responsive lodader start*/
$speedy_settings_controls['speedy-default-layout'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-default-layout'],
        ),
        'control' => array(
            'label'                 =>  __( 'Default Layout', 'speedy' ),
            'description'           =>  __( 'Layout for all archives, single posts and pages', 'speedy' ),
            'section'               => 'speedy-layout-options',
            'type'                  => 'select',
            'choices'               => array(
                'right-sidebar' => __( 'Content - Primary Sidebar', 'speedy' ),
                'left-sidebar' => __( 'Primary Sidebar - Content', 'speedy' ),
                'no-sidebar' => __( 'No Sidebar', 'speedy' )
            ),
            'priority'              => 20,
            'active_callback'       => ''
        )
    );