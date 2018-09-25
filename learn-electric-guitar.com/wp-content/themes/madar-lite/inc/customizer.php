<?php

/**
 * Madar Lite Theme Customizer
 *
 *  
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function madarlite_theme_cutomizer ($wp_customize){	
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->get_section( 'title_tagline' )->priority = '9';
    $wp_customize->get_section( 'title_tagline' )->title = __('Site title/tagline', 'madar-lite');   
		class MadarLite_Categories_Dropdown extends WP_Customize_Control {
        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'              => '_customize-dropdown-categories-' . $this->id,
                    'echo'              => 0,
                    'show_option_none'  => __( '&mdash; Select &mdash;', 'madar-lite' ),
                    'option_none_value' => '0',
                    'selected'          => $this->value(),
                )
            );
 
            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
 
            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );
        }
    }
		    class madarlite_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
            <h3 style="margin-top:30px;border:1px solid;padding:5px;color:#16a1e7;text-transform:uppercase;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }

    //___Colors___//
    $wp_customize->add_setting(
        'primary_color',
        array(
            'default'           => '#007fff',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            array(
                'label'         => __('Primary color', 'madar-lite'),
                'section'       => 'colors',
                'settings'      => 'primary_color',
            )
        )
    );
    //___Layout Settings___//
    $wp_customize->add_section(
        'homepage-settings',
        array(
            'title' => __('Layout Settings', 'madar-lite'),
            'priority' => 11,
        )
    );

    $wp_customize->add_setting(
        'homepage_base',
        array(
            'default'           => '',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'madarlite_sanitize_blog',
        )
    );
    $wp_customize->add_control(
        'homepage_base',
        array(
            'type'      => 'radio',
            'label'     => __('Homepage layout', 'madar-lite'),
            'section'   => 'homepage-settings',
            'priority'  => 11,
            'choices'   => array(
                ''             => __( 'Boxed Page', 'madar-lite' ),
                'full'         => __( 'Full Page', 'madar-lite' )
            ),
        )
    ); 
    //___Header Settings___//
    $wp_customize->add_section(
        'header-settings',
        array(
            'title' => __('Header Settings', 'madar-lite'),
            'priority' => 12,
        )
    );

    //Logo Manager
    $wp_customize->add_setting(
        'site_logo',
        array(
            'default-image' => '',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_logo',
            array(
               'label'          => __( 'Upload your Logo', 'madar-lite' ),
               'type'           => 'image',
               'section'        => 'title_tagline',
                'description' => __('Displayed instead of the site Title and Description', 'madar-lite'),
               'priority'       => 12,
            )
        )
    );
    //Top Menu Navigation
    $wp_customize->add_setting(
        'topmenu_enable',
        array(
            'sanitize_callback' => 'madarlite_sanitize_checkbox',
            'capability'        => 'edit_theme_options',
        )       
    );
    $wp_customize->add_control(
        'topmenu_enable',
        array(
            'type' => 'checkbox',
            'label' => __('To Enable Top Header Menu', 'madar-lite'),
            'section' => 'header-settings',
            'priority' => 1,
        )
    );

	//Top Advertisement (728x90)
    $wp_customize->add_setting(
        'topbanner_enable',
        array(
            'sanitize_callback' => 'madarlite_sanitize_checkbox',
            'capability'        => 'edit_theme_options',
        )       
    );
    $wp_customize->add_control(
        'topbanner_enable',
        array(
            'type' => 'checkbox',
            'label' => __('Check this box to enable Top Advertisement (728x90)', 'madar-lite'),
            'section' => 'header-settings',
            'priority' => 5,
        )
    );
//  Top Advertisement Image
	$wp_customize->add_setting('topbanner_img', array(
        'default-image'           => '',
        'capability'        => 'edit_theme_options',
    	'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'topbanner_img', array(
        'label'    			=> __('Top Advertisement Image', 'madar-lite'),
		'type'           => 'image',
        'section'  			=> 'header-settings',
		'description'   	=> __('Upload/Select an Advertisement Image. Recommended Size(728x90)','madar-lite'),
		'priority'       => 6,
    )));
    //Top Advertisement URL
    $wp_customize->add_setting(
        'topbanner_url',
        array(
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_url',
        )
    );
    $wp_customize->add_control(
        'topbanner_url',
        array(
            'label'     => __('Enter the Top Advertisement URL', 'madar-lite'),
            'section'   => 'header-settings',
            'type'      => 'text',
            'priority'  => 7,
        )
    );
    //Breaking News
    $wp_customize->add_setting(
        'breaking_enable',
        array(
            'sanitize_callback' => 'madarlite_sanitize_checkbox',
            'capability'        => 'edit_theme_options',
        )       
    );
    $wp_customize->add_control(
        'breaking_enable',
        array(
            'type' => 'checkbox',
            'label' => __('To Enable Breaking news ticker', 'madar-lite'),
            'section' => 'header-settings',
            'priority' => 3,
        )
    );
    //Display: Activate recent carousel
    $wp_customize->add_setting(
        'recent-carousel',
        array(
            'sanitize_callback' => 'madarlite_sanitize_checkbox',
            'capability'        => 'edit_theme_options',
        )       
    );
    $wp_customize->add_control(
        'recent-carousel',
        array(
            'type' => 'checkbox',
            'label' => __('Show Recent Post Carousel', 'madar-lite'),
            'section' => 'header-settings',
            'priority' => 4,           
        )
    );
	$wp_customize->add_section('social_sec',array(
			'title'	=> __('Social Settings','madar-lite'),				
			'description' => __( 'More social icon available in Madar PRO Version.', 'madar-lite' ),			
			'priority'		=> null
	));
	
	$wp_customize->add_setting('fb_link',array(
			'default'	=> '#facebook',
			'sanitize_callback'	=> 'esc_url_raw'	
	));
	
	$wp_customize->add_control('fb_link',array(
			'label'	=> __('Add facebook link here','madar-lite'),
			'section'	=> 'social_sec',
			'setting'	=> 'fb_link'
	));	
	$wp_customize->add_setting('rss_link',array(
			'default'	=> '#feed',
			'sanitize_callback'	=> 'esc_url_raw'	
	));
	
	$wp_customize->add_control('rss_link',array(
			'label'	=> __('Add Feed RSS link here','madar-lite'),
			'section'	=> 'social_sec',
			'setting'	=> 'rss_link'
	));	
	$wp_customize->add_setting('pinterest_link',array(
			'default'	=> '#pinterest',
			'sanitize_callback'	=> 'esc_url_raw'	
	));
	
	$wp_customize->add_control('pinterest_link',array(
			'label'	=> __('Add Pinterest link here','madar-lite'),
			'section'	=> 'social_sec',
			'setting'	=> 'pinterest_link'
	));	
	$wp_customize->add_setting('twitt_link',array(
			'default'	=> '#twitter',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('twitt_link',array(
			'label'	=> __('Add twitter link here','madar-lite'),
			'section'	=> 'social_sec',
			'setting'	=> 'twitt_link'
	));
	$wp_customize->add_setting('gplus_link',array(
			'default'	=> '#gplus',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('gplus_link',array(
			'label'	=> __('Add google plus link here','madar-lite'),
			'section'	=> 'social_sec',
			'setting'	=> 'gplus_link'
	));
	$wp_customize->add_setting('youtube_link',array(
			'default'	=> '#youtube',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('youtube_link',array(
			'label'	=> __('Add Youtube link here','madar-lite'),
			'section'	=> 'social_sec',
			'setting'	=> 'youtube_link'
	));

    //___Footer Settings___//
    $wp_customize->add_section(
        'footer-settings',
        array(
            'title' => __('Footer', 'madar-lite'),
            'priority' => 13,
        )
    );
    //Go to Top
    $wp_customize->add_setting(
        'gototop_enable',
        array(
            'sanitize_callback' => 'madarlite_sanitize_checkbox',
            'capability'        => 'edit_theme_options',
        )       
    );
    $wp_customize->add_control(
        'gototop_enable',
        array(
            'type' => 'checkbox',
            'label' => __('To Enable Go Top button', 'madar-lite'),
            'section' => 'footer-settings',
            'priority' => 24,
        )
    );

    //___Flexyslider___//
    $wp_customize->add_section(
        'flexyslider',
        array(
            'title' => __('Flexy Slider', 'madar-lite'),
            'priority' => 13,
        )
    );
    //Display: Activate flexyslider
    $wp_customize->add_setting(
        'slider_enable',
        array(
            'sanitize_callback' => 'madarlite_sanitize_checkbox',
            'capability'        => 'edit_theme_options',
        )       
    );
    $wp_customize->add_control(
        'slider_enable',
        array(
            'type' => 'checkbox',
            'label' => __('Show Flexy Slider', 'madar-lite'),
            'section' => 'flexyslider',
            'priority' => 8,           
        )
    );
    //Category
    $wp_customize->add_setting( 'slider_cat', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    ) );
    
    $wp_customize->add_control( new MadarLite_Categories_Dropdown( $wp_customize, 'slider_cat', array(
        'label'     => __('Select which category to show in Flexslider', 'madar-lite'),
        'section'   => 'flexyslider',
        'settings'  => 'slider_cat',
        'priority'  => 11
    ) ) );
    //Number of posts
    $wp_customize->add_setting(
        'slider_number',
        array(
            'default'           => '6',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'madarlite_sanitize_int',
        )
    );
    $wp_customize->add_control(
        'slider_number',
        array(
            'label'     => __('Enter the number of posts you want to show', 'madar-lite'),
            'section'   => 'flexyslider',
            'type'      => 'text',
            'priority'  => 12
        )
    );
}
add_action('customize_register', 'madarlite_theme_cutomizer');
	if ( ! function_exists( 'madarlite_get_option' ) ) :
	function madarlite_get_option( $madarlite_name, $madarlite_default = false ) {
	$madarlite_config = get_option( 'madarlite' );

	if ( ! isset( $madarlite_config ) ) : return $madarlite_default; else: $madarlite_options = $madarlite_config; endif;
	if ( isset( $madarlite_options[$madarlite_name] ) ):  return $madarlite_options[$madarlite_name]; else: return $madarlite_default; endif;
	}
	endif;
/**
 * Sanitize
 */
//Text
function madarlite_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
//Checkboxes
function madarlite_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}
//Integers
function madarlite_sanitize_int( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}

//Footer widget areas
function madarlite_sanitize_fw( $input ) {
    $valid = array(
        '1'     => __('One', 'madar-lite'),
        '2'     => __('Two', 'madar-lite'),
        '3'     => __('Three', 'madar-lite'),
        '4'     => __('Four', 'madar-lite')
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

//Blog Layout
function madarlite_sanitize_blog( $input ) {
    $valid = array(
        'boxed'           => __( 'Classic', 'madar-lite' ),
        'full'         => __( 'Full width (no sidebar)', 'madar-lite' )

    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}



function madarlite_sanitize_display( $input ) {
    $valid = array(
        'box'           => __( 'box homepage', 'madar-lite' ),
        'blog'         => __( 'blog home page width ', 'madar-lite' )

    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}


add_action( 'wp_head', 'madarlite_style_styles' );
function madarlite_style_styles() {
	$theme_color = esc_attr(get_theme_mod("primary_color"));
	?>
  <style type="text/css">
	  	.colour-line,.date-header,.main-navigation-menu li.current-menu-item,.single-header .comment,.single-header .comment,.home-box-header span,#back-top,a.custom-li,.cbp-qtprogress,.widget-header:after, .flex-control-paging li a.flex-active,.post-tags a{background: <?php echo $theme_color;?>; }
        a.random,a.user_profile,a.logout,a.login,.share-search,.top-menu li.current-menu-item,.top-menu li.current-menu-item:hover{border-bottom: 3px solid <?php echo $theme_color;?>; }
		ul.top-menu ul,ul.top-menu ul li ul,ul.madar-main-menu ul,ul.madar-main-menu ul li ul,.single-box .box-content,#related-posts ul,.blog .post-header,.post-header,#crumbs,.pagetitle{border-left: 3px solid <?php echo $theme_color;?>; }
        .date-header,a.custom-li{border: 1px dashed <?php echo $theme_color;?>; }
        #sidebar .menu li.current-menu-item > a,#sidebar .menu li a:hover,.widget-sidebar ul.image-widget li:hover,.two-column li.child-news:hover{border-left:1px solid <?php echo $theme_color;?>; }
        .theme-input input[type=text]:focus,.theme-input textarea:focus{ border: 1px solid <?php echo $theme_color;?>; }
        ul.tabs-header li a.current {border-top: 2px solid <?php echo $theme_color;?>; }
        .normal-box .normal-readmore a,.one-column li.child-text .child-title h3 a:hover,.one-column li.child-news .child-title h3 a:hover,.two-column li.child-news h3 a:hover,.top-navigation select,.main-navigation select { color:<?php echo $theme_color;?>; }
        .thumbnail-options  a.active,a.cat-color,.simple-button,.flex-direction-nav a,.default.button,.button,a.button, .form-submit #submit,#login-form .login-button,a.bp-title-button,#main-content input[type="submit"],.form-submit #submit {background-color: <?php echo $theme_color;?>; }
		footer {border-top: 10px solid <?php echo $theme_color;?>; }
		.single-header h1,.single-header .meta {border-color: #ddd #fff #ddd <?php echo $theme_color;?>; }
 </style>
  
<?php
}
?>	