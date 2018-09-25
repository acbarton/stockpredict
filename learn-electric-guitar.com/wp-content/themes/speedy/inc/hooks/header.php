<?php
if ( ! function_exists( 'speedy_set_global' ) ) :
/**
 * Setting global values for all saved customizer values
 *
 * @since Speedy 1.0.0
 *
 * @param null
 * @return null
 *
 */
function speedy_set_global() {
    /*Getting saved values start*/
    $GLOBALS['speedy_customizer_all_values'] = speedy_get_all_options(1);
}
endif;
add_action( 'speedy_action_before_head', 'speedy_set_global', 0 );

if ( ! function_exists( 'speedy_doctype' ) ) :
/**
 * Doctype Declaration
 *
 * @since Speedy 1.0.0
 *
 * @param null
 * @return null
 *
 */
function speedy_doctype() {
    ?>
    <!DOCTYPE html><html <?php language_attributes(); ?>>
<?php
}
endif;
add_action( 'speedy_action_before_head', 'speedy_doctype', 10 );

if ( ! function_exists( 'speedy_before_wp_head' ) ) :
/**
 * Before wp head codes
 *
 * @since Speedy 1.0.0
 *
 * @param null
 * @return null
 *
 */
function speedy_before_wp_head() {
    ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php
}
endif;
add_action( 'speedy_action_before_wp_head', 'speedy_before_wp_head', 10 );

if( ! function_exists( 'speedy_default_layout' ) ) :
    /**
     * Speedy default layout function
     *
     * @since  Speedy 1.0.0
     *
     * @param int
     * @return string
     */
    function speedy_default_layout(){
        global $speedy_customizer_all_values,$post;
        $speedy_default_layout = $speedy_customizer_all_values['speedy-default-layout'];
        return $speedy_default_layout;
    }
endif;

if ( ! function_exists( 'speedy_body_class' ) ) :
/**
 * add body class
 *
 * @since Speedy 1.0.0
 *
 * @param null
 * @return null
 *
 */
function speedy_body_class( $speedy_body_classes ) {
    if(!is_front_page() || ( is_front_page())){
        $speedy_default_layout = speedy_default_layout();
        if( !empty( $speedy_default_layout ) ){
            if( 'left-sidebar' == $speedy_default_layout ){
                $speedy_body_classes[] = 'evision-left-sidebar';
            }
            elseif( 'right-sidebar' == $speedy_default_layout ){
                $speedy_body_classes[] = 'evision-right-sidebar';
            }
            elseif( 'no-sidebar' == $speedy_default_layout ){
                $speedy_body_classes[] = 'evision-no-sidebar';
            }
            else{
                $speedy_body_classes[] = 'evision-right-sidebar';
            }
        }
        else{
            $speedy_body_classes[] = 'speedy-right-sidebar';
        }
    }
    return $speedy_body_classes;

}
endif;
add_action( 'body_class', 'speedy_body_class', 10, 1);

if ( ! function_exists( 'speedy_page_start' ) ) :
/**
 * page start
 *
 * @since Speedy 1.0.0
 *
 * @param null
 * @return null
 *
 */
function speedy_page_start() {
?>
    <div id="page" class="hfeed site">
<?php
}
endif;
add_action( 'speedy_action_before', 'speedy_page_start', 15 );

if ( ! function_exists( 'speedy_skip_to_content' ) ) :
/**
 * Skip to content
 *
 * @since Speedy 1.0.0
 *
 * @param null
 * @return null
 *
 */
function speedy_skip_to_content() {
    ?>
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'speedy' ); ?></a>
<?php
}
endif;
add_action( 'speedy_action_before_header', 'speedy_skip_to_content', 10 );

if ( ! function_exists( 'speedy_header' ) ) :
/**
 * Main header
 *
 * @since Speedy 1.0.0
 *
 * @param null
 * @return null
 *
 */
function speedy_header() {
    global $speedy_customizer_all_values;
    ?>
        <header id="masthead" class="evision-wrapper site-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 rtl-fright">
                        <?php 
                            speedy_the_custom_logo();
                            if ( is_front_page() && is_home() ) : ?>
                                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                            <?php else : ?>
                                <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                            <?php endif;
                                $description = get_bloginfo( 'description', 'display' );
                                if ( $description || is_customize_preview() ) : ?>
                                <h2 class="site-description"><?php echo $description; ?></h2>
                            <?php endif;
                        ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 header-right rtl-fleft">
                            <div class="social-group-nav evision-social-section">
                                <?php
                                if(  1 == $speedy_customizer_all_values['speedy-enable-social-icons']) {
                                    ?>
                                    <?php wp_nav_menu( array( 'theme_location' => 'social', 'menu_id' => 'primary-menu' ) ); ?>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="head-search-section">
                                <i class="fa fa-search search-box-btn"></i>
                                <div id="search-box">
                                    <?php 
                                        get_search_form();
                                    ?>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </header>
        <section class="evision-wrapper wrap-nav">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <a href="#site-navigation" id="hamburger"><span></span></a>
                        <nav id="site-navigation" class="main-navigation" role="navigation">
                            <?php wp_nav_menu( array( 
                            'theme_location' => 'primary',
                            'container' => false,
                            ) ); ?>
                        </nav> 
                    </div>
                </div>
            </div>
        </section>

<?php
}
endif;
add_action( 'speedy_action_header', 'speedy_header', 10 );

if( ! function_exists( 'speedy_header_banner' ) ) :

/**
 * Home Banner section
 *
 * @since Speedy 1.0.0
 *
 * @param null
 * @return null
 *
 */
    function speedy_header_banner(){
        $check_page = get_query_var( 'paged');
        // Bail if Home Page
        if ( is_front_page()  && $check_page < 1 ) {
            global $speedy_customizer_all_values;
            $speedy_banner_title = $speedy_customizer_all_values['speedy-banner-title'];

            if( 1 != $speedy_customizer_all_values['speedy-home-banner-enable'] ){
                return null;
            }
            ?>
            <section class="evision-wrapper block-section wrap-banner overhidden">
                <div class="container-fluid evision-animate fadeInDown">
                     <?php if ( get_header_image() ) : ?>

                        <img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
                         <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <span class="banner-title evision-animate fadeInRight">
                                <?php echo esc_html( $speedy_banner_title ); ?>
                            </span>
                         </a>
                        <?php endif; // End header image check. ?>
                </div>
            </section><!-- highlight section --> 
        <?php }
        else{
            return;
        }
    }
endif;
add_action( 'speedy_action_after_header', 'speedy_header_banner', 10 );

if( ! function_exists( 'speedy_add_breadcrumb' ) ) :

/**
 * Breadcrumb
 *
 * @since Speedy 1.0.0
 *
 * @param null
 * @return null
 *
 */
    function speedy_add_breadcrumb(){
        // Bail if Home Page
        if ( is_front_page() || is_home() ) {
            return;
        }
        echo '<div id="breadcrumb" class="evision-wrapper block-section"><div class="container-fluid"><div class="breadcrumb-inner">';
         speedy_simple_breadcrumb();
        echo '</div></div><!-- .container-fluid --></div><!-- #breadcrumb -->';
        return;
    }
endif;
add_action( 'speedy_action_after_header', 'speedy_add_breadcrumb', 20 );



if( ! function_exists( 'speedy_content_wrapper' ) ) :

/**
 * Home Banner section
 *
 * @since Speedy 1.0.0
 *
 * @param null
 * @return null
 *
 */
    function speedy_content_wrapper(){
        echo '<section class="evision-wrapper block-section main-content-wrapper">';
    }
endif;
add_action( 'speedy_action_before_content', 'speedy_content_wrapper', 40 );


if( ! function_exists( 'speedy_header_service' ) ) :

/**
 * Home Service section
 *
 * @since Speedy 1.0.0
 *
 * @param null
 * @return null
 *
 */
    function speedy_header_service(){

        $check_page = get_query_var( 'paged');
        // Bail if Home Page
        if ( is_front_page() && ! is_home() ) {
            do_action('speedy_action_home_service');
        }
        else{
            return;
        }
    }
endif;
add_action( 'speedy_action_after_header', 'speedy_header_service', 30 );

