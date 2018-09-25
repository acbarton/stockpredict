<?php
add_action( 'customize_register', 'themename_customize_register' );
function themename_customize_register($wp_customize) {
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Cleanblog_Customize_Misc_Control' ) ) :
class Cleanblog_Customize_Misc_Control extends WP_Customize_Control {
    public $settings = 'blogname';
    public $description = '';
    public function render_content() {
        switch ( $this->type ) {
            default:
            case 'desc' :
                echo '<p class="description">' . $this->description . '</p>';
                break;
 
            case 'heading':
                echo '<span class="customize-control-title" style="background-color: rgb(227, 227, 227);padding: 3px 5px;text-align: center;border: 1px solid rgb(183, 183, 183);margin: 0px -10px;">' . esc_html( $this->label ) . '</span>';
                break;
				
 			case 'title':
                echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
                break;
				
            case 'line' :
                echo '<hr />';
                break;
				
			case 'textdesc' :
                ?><label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <p class="description"><?php echo $this->description; ?></p>
            <input type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
        </label><?php
                break;
				
			case 'number' :
                ?><label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <p class="description"><?php echo $this->description; ?></p>
            <input type="number" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
        </label><?php
                break;	
        }
    }
}
endif;
//## Social Section
$wp_customize->add_section( 'cleanblog_social_section', array(
'title'          => __( 'Social Links', 'cleanblogg' ),
'priority'       => 36,
) );

//Section Top Message
$wp_customize->add_control( new Cleanblog_Customize_Misc_Control($wp_customize,'social_message',
array(
'section'  => 'cleanblog_social_section',
'description' => __( 'Set the URLs for your social media profiles here to be used in the Header and Footer. Keep the fields empty if you don\'t use.', 'cleanblogg' ),
'type'     => 'desc',
'priority' => 1,
)));
//Section Top Message End	

// Show social icons in Header
$wp_customize->add_setting( 'cleanblog_social_in_header', array(
'default'   => 'show',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'transport' => 'refresh') );

$wp_customize->add_control( 'cleanblog_social_in_header', array(
'label'      => __('Show/Hide Header Social Icons', 'cleanblogg'),
'section'    => 'cleanblog_social_section',
'settings'   => 'cleanblog_social_in_header',
'type'       => 'radio',
'choices'    => array(
'show' => 'Show',
'hide' => 'Hide',
),
'priority' => 2
) );

// Show social icons in Footer
$wp_customize->add_setting( 'cleanblog_social_in_footer', array(
'default'   => 'show',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_social_in_footer', array(
'label'      => __('Show/Hide Footer Social Icons', 'cleanblogg'),
'section'    => 'cleanblog_social_section',
'settings'   => 'cleanblog_social_in_footer',
'type'       => 'radio',
'choices'    => array(
'show' => 'Show',
'hide' => 'Hide',
),
'priority' => 3
) );

// Facebook
$wp_customize->add_setting( 'cleanblog_fb', array(
'default'   => '',
'sanitize_callback' => 'esc_url_raw',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_fb', array(
'label' => __( 'Facebook', 'cleanblogg' ),
'section' => 'cleanblog_social_section',
'type' => 'text',
'priority' => 4
) );

// Twitter
$wp_customize->add_setting( 'cleanblog_twitter', array(
'default'   => '',
'sanitize_callback' => 'esc_url_raw',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_twitter', array(
'label' => __( 'Twitter', 'cleanblogg' ),
'section' => 'cleanblog_social_section',
'type' => 'text',
'priority' => 5
) );

// Google Plus
$wp_customize->add_setting( 'cleanblog_googleplus', array(
'default'   => '',
'sanitize_callback' => 'esc_url_raw',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_googleplus', array(
'label' => __( 'Google +', 'cleanblogg' ),
'section' => 'cleanblog_social_section',
'type' => 'text',
'priority' => 6
) );

// Instagram
$wp_customize->add_setting( 'cleanblog_instagram', array(
'default'   => '',
'sanitize_callback' => 'esc_url_raw',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_instagram', array(
'label' => __( 'Instagram', 'cleanblogg' ),
'section' => 'cleanblog_social_section',
'type' => 'text',
'priority' => 7
) );

// Pinterest
$wp_customize->add_setting( 'cleanblog_pinterest', array(
'default'   => '',
'sanitize_callback' => 'esc_url_raw',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_pinterest', array(
'label' => __( 'Pinterest', 'cleanblogg' ),
'section' => 'cleanblog_social_section',
'type' => 'text',
'priority' => 8
) ); 
 
// RSS
$wp_customize->add_setting( 'cleanblog_rss', array(
'default'   =>'' ,
'sanitize_callback' => 'esc_url_raw',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_rss', array(
'label' => __( 'RSS Feed', 'cleanblogg' ),
'section' => 'cleanblog_social_section',
'type' => 'text',
'priority' => 9
) );  

//## Header Section

$wp_customize->add_section( 'cleanblog_header_section', array(
'title'          => __( 'Header', 'cleanblogg' ),
'priority'       => 34,
) );

//Section Top Message
$wp_customize->add_control( new Cleanblog_Customize_Misc_Control($wp_customize,'header_message',
array(
'section'  => 'cleanblog_header_section',
'description' => __( 'Manage elements of header', 'cleanblogg' ),
'type'     => 'desc',
'priority' => 1,
)));
//Section Top Message End

// Logo
$wp_customize->add_setting( 'cleanblog_logo', array(
'default' => '',
'sanitize_callback' => 'esc_url_raw', 
'transport' => 'refresh',
 ) );

$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'cleanblog_logo', array(
'label' => __( 'Upload Logo', 'cleanblogg' ),
'section' => 'cleanblog_header_section',
'settings' => 'cleanblog_logo',
'priority' => 1
) ) );
 
// Logo Width
$wp_customize->add_setting( 'cleanblog_logo_width', array(
'default'   =>'250',
'sanitize_callback' => 'sanitize_text_field',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_logo_width', array(
'label' => __( 'Logo Width (px)', 'cleanblogg' ),
'section' => 'cleanblog_header_section',
'type' => 'text',
'priority' => 2
) );   

// Logo Top Margin
$wp_customize->add_setting( 'cleanblog_logo_top', array(
'default'   =>'50',
'sanitize_callback' => 'sanitize_text_field',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_logo_top', array(
'label' => __( 'Logo Top Margin (px)', 'cleanblogg' ),
'section' => 'cleanblog_header_section',
'type' => 'text',
'priority' => 3
) );  

// Logo Bottom Margin
$wp_customize->add_setting( 'cleanblog_logo_bottom', array(
'default'   =>'50',
'sanitize_callback' => 'sanitize_text_field',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_logo_bottom', array(
'label' => __( 'Logo Bottom Margin (px)', 'cleanblogg' ),
'section' => 'cleanblog_header_section',
'type' => 'text',
'priority' => 4
) );

// Show Search
$wp_customize->add_setting( 'cleanblog_show_search', array(
'default'   => 'show',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_show_search', array(
'label'      => __('Show/Hide Search Form', 'cleanblogg'),
'section'    => 'cleanblog_header_section',
'settings'   => 'cleanblog_show_search',
'type'       => 'radio',
'choices'    => array(
'show' => 'Show',
'hide' => 'Hide',
),
'priority' => 5
) ); 

//## Footer Section
 
$wp_customize->add_section( 'cleanblog_footer_section', array(
'title'          => __( 'Footer', 'cleanblogg' ),
'priority'       => 36,
) );

//Section Top Message
$wp_customize->add_control( new Cleanblog_Customize_Misc_Control($wp_customize,'footer_message',
array(
'section'  => 'cleanblog_footer_section',
'description' => __( 'Adjust your site footer setting and widget areas to the specific number desired and turning on or off various parts as needed.', 'cleanblogg' ),
'type'     => 'desc',
'priority' => 1,
)));
//Section Top Message End 

//Footer widgets
$wp_customize->add_setting( 'cleanblog_footer_widgets_show', array(
'default'   => 'none',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_footer_widgets_show', array(
'label'      => __('Footer Widgets', 'cleanblogg'),
'section'    => 'cleanblog_footer_section',
'settings'   => 'cleanblog_footer_widgets_show',
'type'       => 'radio',
'choices'    => array(
'none' => 'None (Disables Footer Widgets)',
'one' => 'One',
'two' => 'Two',
'three' => 'Three',
),
'priority' =>2
) ); 
//Footer socket Show/Hide	
$wp_customize->add_setting( 'cleanblog_footer_socket', array(
'default'   => 'show',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_footer_socket', array(
'label'      => __('Show/Hide Footer Socket', 'cleanblogg'),
'section'    => 'cleanblog_footer_section',
'settings'   => 'cleanblog_footer_socket',
'type'       => 'radio',
'choices'    => array(
'show' => 'Show',
'hide' => 'Hide',
),
'priority' =>3
) ); 	

//Footer copyright Show/Hide	
$wp_customize->add_setting( 'cleanblog_footer_copyright_show', array(
'default'   => 'show',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_footer_copyright_show', array(
'label'      => __('Show/Hide Footer Copyright', 'cleanblogg'),
'section'    => 'cleanblog_footer_section',
'settings'   => 'cleanblog_footer_copyright_show',
'type'       => 'radio',
'choices'    => array(
'show' => 'Show',
'hide' => 'Hide',
),
'priority' =>4
) ); 	
/* */
//Footer copyright Text
$wp_customize->add_setting( 'cleanblog_footer_copyright', array(
'default' => sprintf( __( 'Copyright 2015 CleanBlog | Theme by %s', 'cleanblogg' ), '<a href="http://airthemes.net/cleanblog" target="_blank">AirThemes</a>' ),
'sanitize_callback' => 'balanceTags',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_footer_copyright', array(
'label' => __( 'Copyright Content', 'cleanblogg' ),
'section' => 'cleanblog_footer_section',
'type' => 'textarea',
'priority' => 5
) );  

//## Slider Section

$wp_customize->add_section( 'cleanblog_slider_section', array(
'title'          => __( 'Slider', 'cleanblogg' ),
'priority'       => 35,
) );

//Section Top Message
$wp_customize->add_control( new Cleanblog_Customize_Misc_Control($wp_customize,'slider_message',
array(
'section'  => 'cleanblog_slider_section',
'description' => __( 'Adjust your slider settings and customize slider posts .', 'cleanblogg' ),
'type'     => 'desc',
'priority' => 1,
)));
//Section Top Message End  

//Slider Show/Hide	
$wp_customize->add_setting( 'cleanblog_slider_show', array(
'default'   => 'show',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_slider_show', array(
'label'      => __('Show/Hide Slider', 'cleanblogg'),
'section'    => 'cleanblog_slider_section',
'settings'   => 'cleanblog_slider_show',
'type'       => 'radio',
'choices'    => array(
'show' => 'Show',
'hide' => 'Hide',
),
'priority' =>2
) ); 	

//Slider Posts
$wp_customize->add_setting( 'cleanblog_slider_posts', array(
'default'   => 'ASC',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_slider_posts', array(
'label'      => __('Slider Posts', 'cleanblogg'),
'section'    => 'cleanblog_slider_section',
'settings'   => 'cleanblog_slider_posts',
'type'       => 'radio',
'choices'    => array(
'ASC' => 'Recent Posts',
'comment_count' => 'Popular Posts',
'rand' => 'Random Posts',
),
'priority' =>2
) ); 	

// Slider Number of Posts 
$wp_customize->add_setting( 'cleanblog_slider_posts_num', array(
'default'   => '10',
'sanitize_callback' => 'sanitize_text_field',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( new Cleanblog_Customize_Misc_Control($wp_customize,'cleanblog_slider_posts_num',
array(
'label'  => __('Number of Posts', 'cleanblogg'),
'section'  => 'cleanblog_slider_section',
'settings'   => 'cleanblog_slider_posts_num',
'type' => 'textdesc',
'description' => 'Enter number of posts do you want show in the slider. Show all posts enter value "-1" ',
'priority' => 3,
)));

//Slider Automatically Transition	
$wp_customize->add_setting( 'cleanblog_slider_auto', array(
'default'   => 'true',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_slider_auto', array(
'label'      => __('Automatically Transition', 'cleanblogg'),
'section'    => 'cleanblog_slider_section',
'settings'   => 'cleanblog_slider_auto',
'type'       => 'radio',
'choices'    => array(
'true' => 'Yes',
'false' => 'No',
),
'priority' =>4
) ); 	

//Slider Transition	Mode
$wp_customize->add_setting( 'cleanblog_slider_mode', array(
'default'   => 'horizontal',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_slider_mode', array(
'label'      => __('Transition	Mode', 'cleanblogg'),
'section'    => 'cleanblog_slider_section',
'settings'   => 'cleanblog_slider_mode',
'type'       => 'radio',
'choices'    => array(
'horizontal' => 'Slide',
'fade' => 'Fade',
),
'priority' =>5
) ); 	

//Slider Speed
$wp_customize->add_setting( 'cleanblog_slider_speed', array(
'default'   => '1000',
'sanitize_callback' => 'sanitize_text_field',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_slider_speed', array(
'label' => __( 'Transition Speed (ms)', 'cleanblogg' ),
'section' => 'cleanblog_slider_section',
'type' => 'text',
'priority' => 6
) );

//Slider Pause
$wp_customize->add_setting( 'cleanblog_slider_pause', array(
'default'   => '5000',
'sanitize_callback' => 'sanitize_text_field',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_slider_pause', array(
'label' => __( 'Pause Time (ms)', 'cleanblogg' ),
'section' => 'cleanblog_slider_section',
'type' => 'text',
'priority' => 7
) );

//## Layout Section

$wp_customize->add_section( 'cleanblog_layout_section', array(
'title'          => __( 'Layout', 'cleanblogg' ),
'priority'       => 35,
) );

//Section Top Message
$wp_customize->add_control( new Cleanblog_Customize_Misc_Control($wp_customize,'layout_message',
array(
'section'  => 'cleanblog_layout_section',
'description' => __( 'Select your site\'s layout options here and manage blog listing layouts', 'cleanblogg' ),
'type'     => 'desc',
'priority' => 1,
)));
//Section Top Message End  

//Layout	
$wp_customize->add_setting( 'cleanblog_content_layout', array(
'default'   => 'right',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_content_layout', array(
'label'      => __('Content Layout', 'cleanblogg'),
'section'    => 'cleanblog_layout_section',
'settings'   => 'cleanblog_content_layout',
'type'       => 'radio',
'choices'    => array(
'right' => 'Content Left, Sidebar Right',
'left' => 'Sidebar Left, Content Right',
'full' => 'Fullwidth',
),
'priority' =>2
) );

$wp_customize->add_setting( 'cleanblog_content_width', array(
'default'   => '1100',
'sanitize_callback' => 'sanitize_text_field',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_content_width', array(
'type'        => 'number',
'priority'    => 10,
'section'     => 'cleanblog_layout_section',
'settings'   => 'cleanblog_content_width',
'label'       => __('Content Width (px)','cleanblogg'),
'description' => __('Enter value between 800px and 1200px','cleanblogg'),
'input_attrs' => array(
'min'   => 800,
'max'   => 1200,
'step'  => 10,
'value' => 1100,
),
) );

//## Blog Section

$wp_customize->add_section( 'cleanblog_blog_section', array(
'title'          => __( 'Blog', 'cleanblogg' ),
'priority'       => 38,
) );

//Section Top Message
$wp_customize->add_control( new Cleanblog_Customize_Misc_Control($wp_customize,'blog_message',
array(
'section'  => 'cleanblog_blog_section',
'description' => __( 'Adjust the style and layout of your blog using the settings below. This will affect the posts index page and archive or search results pages of your blog. ', 'cleanblogg' ),
'type'     => 'desc',
'priority' => 1,
)));
//Section Top Message End 

//Blog Default Style	
$wp_customize->add_setting( 'cleanblog_content_style', array(
'default'   => 'grid',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_content_style', array(
'label'      => __('Blog Default Style', 'cleanblogg'),
'section'    => 'cleanblog_blog_section',
'settings'   => 'cleanblog_content_style',
'type'       => 'radio',
'choices'    => array(
'standard' => 'Standard Layout',
'list' => 'List Layout',
'grid' => 'Grid Layout',
),
'priority' =>2
) );

//Blog Archive Style	
$wp_customize->add_setting( 'cleanblog_archive_style', array(
'default'   => 'grid',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'transport' => 'refresh',
 ) );

$wp_customize->add_control( 'cleanblog_archive_style', array(
'label'      => __('Blog Archive Style', 'cleanblogg'),
'section'    => 'cleanblog_blog_section',
'settings'   => 'cleanblog_archive_style',
'type'       => 'radio',
'choices'    => array(
'standard' => __('Standard Layout', 'cleanblogg'),
'list' => __('List Layout', 'cleanblogg'),
'grid' => __('Grid Layout', 'cleanblogg'),
),
'priority' =>3
) );

$wp_customize->add_control( new Cleanblog_Customize_Misc_Control($wp_customize,'blog_list_title',
array(
'section'  => 'cleanblog_blog_section',
'label' => __( 'Show/Hide Elements in Posts List', 'cleanblogg' ),
'type'     => 'title',
'priority' => 4,
)));


// Standerd Featured Image
$wp_customize->add_setting('cleanblog_list_featured_image_show', array(
'transport' => 'refresh',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'default'    => '1'
));

$wp_customize->add_control(
new WP_Customize_Control(
$wp_customize,'cleanblog_list_featured_image_show',array(
'label'     => __('Featured Image','cleanblogg'),
'section'   => 'cleanblog_blog_section',
'settings'  => 'cleanblog_list_featured_image_show',
'type'      => 'checkbox',
'priority' => 6,
)
)
);

// Standerd Category
$wp_customize->add_setting('cleanblog_list_category_show', array(
'transport' => 'refresh',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'default'    => '1'
));

$wp_customize->add_control(
new WP_Customize_Control(
$wp_customize,'cleanblog_list_category_show',array(
'label'     => __('Category','cleanblogg'),
'section'   => 'cleanblog_blog_section',
'settings'  => 'cleanblog_list_category_show',
'type'      => 'checkbox',
'priority' => 7,
)
)
);

// Standerd Date
$wp_customize->add_setting('cleanblog_list_date_show', array(
'transport' => 'refresh',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'default'    => '1',
 
));

$wp_customize->add_control(
new WP_Customize_Control(
$wp_customize,'cleanblog_list_date_show',array(
'label'     => __('Date','cleanblogg'),
'section'   => 'cleanblog_blog_section',
'settings'  => 'cleanblog_list_date_show',
'type'      => 'checkbox',
'priority' => 8,
)
)
);

// Standerd Author
$wp_customize->add_setting('cleanblog_list_author_show', array(
'transport' => 'refresh',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'default'    => '1'
));

$wp_customize->add_control(
new WP_Customize_Control(
$wp_customize,'cleanblog_list_author_show',array(
'label'     => __('Author','cleanblogg'),
'section'   => 'cleanblog_blog_section',
'settings'  => 'cleanblog_list_author_show',
'type'      => 'checkbox',
'priority' => 9,
)
)
);

// Standerd Comments
$wp_customize->add_setting('cleanblog_list_comments_show', array(
'transport' => 'refresh',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'default'    => '1'
));

$wp_customize->add_control(
new WP_Customize_Control(
$wp_customize,'cleanblog_list_comments_show',array(
'label'     => __('Comment Counts','cleanblogg'),
'section'   => 'cleanblog_blog_section',
'settings'  => 'cleanblog_list_comments_show',
'type'      => 'checkbox',
'priority' => 10,
)));

$wp_customize->add_control( new Cleanblog_Customize_Misc_Control($wp_customize,'blog_single_title',
array(
'section'  => 'cleanblog_blog_section',
'label' => __( 'Show/Hide Elements in Single Post', 'cleanblogg' ),
'type'     => 'title',
'priority' => 12,
)));

// Single Featured Image
$wp_customize->add_setting('cleanblog_single_featured_image_show', array(
'transport' => 'refresh',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'default'    => '1'
));

$wp_customize->add_control(
new WP_Customize_Control(
$wp_customize,'cleanblog_single_featured_image_show',array(
'label'     => __('Featured Image','cleanblogg'),
'section'   => 'cleanblog_blog_section',
'settings'  => 'cleanblog_single_featured_image_show',
'type'      => 'checkbox',
'priority' => 13,
)
)
);

// Single Category
$wp_customize->add_setting('cleanblog_single_category_show', array(
'transport' => 'refresh',
'sanitize_callback' => 'esc_url_raw',
'default'    => '1'
));

$wp_customize->add_control(
new WP_Customize_Control(
$wp_customize,'cleanblog_single_category_show',array(
'label'     => __('Category','cleanblogg'),
'section'   => 'cleanblog_blog_section',
'settings'  => 'cleanblog_single_category_show',
'type'      => 'checkbox',
'priority' => 14,
)
)
);

// Single Date
$wp_customize->add_setting('cleanblog_single_date_show', array(
'transport' => 'refresh',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'default'    => '1'
));

$wp_customize->add_control(
new WP_Customize_Control(
$wp_customize,'cleanblog_single_date_show',array(
'label'     => __('Date','cleanblogg'),
'section'   => 'cleanblog_blog_section',
'settings'  => 'cleanblog_single_date_show',
'type'      => 'checkbox',
'priority' => 15,
)
)
);

// Single Author
$wp_customize->add_setting('cleanblog_single_author_show', array(
'transport' => 'refresh',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'default'    => '1'
));

$wp_customize->add_control(
new WP_Customize_Control(
$wp_customize,'cleanblog_single_author_show',array(
'label'     => __('Author','cleanblogg'),
'section'   => 'cleanblog_blog_section',
'settings'  => 'cleanblog_single_author_show',
'type'      => 'checkbox',
'priority' => 16,
)
)
);

// Single Comments
$wp_customize->add_setting('cleanblog_single_comments_show', array(
'transport' => 'refresh',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'default'    => '1'
));

$wp_customize->add_control(
new WP_Customize_Control(
$wp_customize,'cleanblog_single_comments_show',array(
'label'     => __('Comment Counts','cleanblogg'),
'section'   => 'cleanblog_blog_section',
'settings'  => 'cleanblog_single_comments_show',
'type'      => 'checkbox',
'priority' => 17,
)
)
);

// Single Tags
$wp_customize->add_setting('cleanblog_single_tags_show', array(
'transport' => 'refresh',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'default'    => '1'
));

$wp_customize->add_control(
new WP_Customize_Control(
$wp_customize,'cleanblog_single_tags_show',array(
'label'     => __('Tags','cleanblogg'),
'section'   => 'cleanblog_blog_section',
'settings'  => 'cleanblog_single_tags_show',
'type'      => 'checkbox',
'priority' => 19,
)));
// Single Author Bio Info
$wp_customize->add_setting('cleanblog_single_author_bio_show', array(
'transport' => 'refresh',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'default'    => '0'
));

$wp_customize->add_control(
new WP_Customize_Control(
$wp_customize,'cleanblog_single_author_show',array(
'label'     => __('Author Bio Info','cleanblogg'),
'section'   => 'cleanblog_blog_section',
'settings'  => 'cleanblog_single_author_bio_show',
'type'      => 'checkbox',
'priority' => 20,
)));	

// Single Related Posts
$wp_customize->add_setting('cleanblog_single_relatedpost_show', array(
'transport' => 'refresh',
'sanitize_callback' => 'cleanblogg_sanitize_value',
'default'    => '0'
));

$wp_customize->add_control(
new WP_Customize_Control(
$wp_customize,'cleanblog_single_relatedpost_show',array(
'label'     => __('Related Posts','cleanblogg'),
'section'   => 'cleanblog_blog_section',
'settings'  => 'cleanblog_single_relatedpost_show',
'type'      => 'checkbox',
'priority' => 21,
)));		

//## Page Section

$wp_customize->add_section( 'cleanblog_page_section', array(
'title'          => __( 'Page', 'cleanblogg' ),
'sanitize_callback' => 'esc_url_raw',
'priority'       => 39,
) );

//Section Top Message
$wp_customize->add_control( new Cleanblog_Customize_Misc_Control($wp_customize,'page_message',
array(
'section'  => 'cleanblog_page_section',
'description' => __( 'Adjust the style and layout of your page using the settings below.', 'cleanblogg' ),
'type'     => 'desc',
'priority' => 1,
)));
 
}
function cleanblogg_sanitize_value( $value ) {
    return $value;
}
?>