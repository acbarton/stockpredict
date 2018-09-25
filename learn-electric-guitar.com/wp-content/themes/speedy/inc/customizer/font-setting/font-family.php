<?php
global $speedy_panels;
global $speedy_sections;
global $speedy_settings_controls;
global $speedy_repeated_settings_controls;
global $speedy_customizer_defaults;

/*creating panel for fonts-setting*/
$speedy_panels['speedy-fonts'] =
    array(
        'title'          => __( 'Font Setting', 'speedy' ),
        'priority'       => 43
    );

/*font array*/
global $speedy_google_fonts;
$speedy_google_fonts = array(
    'Merriweather:400,400italic,700,300' => 'Merriweather',
    'Lato:400,300,700,400italic' => 'Lato',
    'Josefin+Sans:400,600,700' => 'Josefin Sans',
    'Montserrat' => 'Montserrat',
    'Arvo:400,400italic,700' => 'Arvo',
    'Raleway:400,300,500,600,700,900' => 'Raleway',
    'Inconsolata:400,700' => 'Inconsolata',
    'Yanone+Kaffeesatz:400,400italic,600,700' => 'Yanone Kaffeesatz',
    'Francois+One:400,400italic,600,700' => 'Francois One',
    'Architects+Daughter:400' => 'Architects Daughter',
    'Crete+Round:400' => 'Crete Round',
    'Lobster+Two:400,700' => 'Lobster Two',
    'Varela:400' => 'Varela',
    'Boogaloo:400' => 'Boogaloo',
    'Patrick+Hand:400' => 'Patrick Hand',
    'Homenaje:400' => 'Homenaje'
);

/*defaults values*/
$speedy_customizer_defaults['speedy-font-family-site-identity'] = 'Merriweather:400,400italic,700,300';
$speedy_customizer_defaults['speedy-font-family-h1-h6'] = 'Merriweather:400,400italic,700,300';
$speedy_customizer_defaults['speedy-font-family-body'] = 'Lato:400,300,700,400italic';


/*section*/
$speedy_sections['speedy-family'] =
    array(
        'priority'       => 20,
        'title'          => __( 'Font Family', 'speedy' ),
        'panel'          => 'speedy-fonts',
    );

/*setting - controls*/
$speedy_settings_controls['speedy-font-family-body'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-font-family-body'],
            'sanitize_callback'     => 'sanitize_text_field'
        ),
        'control' => array(
            'label'                 => __( 'Site Body/Paragraph Font Family', 'speedy' ),
            'description'           => __( 'Site Body or Paragraph Font family', 'speedy' ),
            'section'               => 'speedy-family',
            'type'                  => 'select',
            'choices'               => $speedy_google_fonts,
            'priority'              => 1,
            'active_callback'       => ''
        )
    );

$speedy_settings_controls['speedy-font-family-site-identity'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-font-family-site-identity'],
            'sanitize_callback'     => 'sanitize_text_field'
        ),
        'control' => array(
            'label'                 => __( 'Site Identity Font Family', 'speedy' ),
            'description'           => __( 'Site title and tagline font family', 'speedy' ),
            'section'               => 'speedy-family',
            'type'                  => 'select',
            'choices'               => $speedy_google_fonts,
            'priority'              => 2,
            'active_callback'       => ''
        )
    );

$speedy_settings_controls['speedy-font-family-h1-h6'] =
    array(
        'setting' =>     array(
            'default'              => $speedy_customizer_defaults['speedy-font-family-h1-h6'],
            'sanitize_callback'     => 'sanitize_text_field'
        ),
        'control' => array(
            'label'                 => __( 'H1-H6 Font Family', 'speedy' ),
            'section'               => 'speedy-family',
            'type'                  => 'select',
            'choices'               => $speedy_google_fonts,
            'priority'              => 10,
            'active_callback'       => ''
        )
    );

