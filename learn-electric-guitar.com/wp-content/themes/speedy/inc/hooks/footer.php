<?php
if( ! function_exists( 'speedy_content_wrapper_end' ) ) :

/**
 * Home Banner section
 *
 * @since Speedy 1.0.0
 *
 * @param null
 * @return null
 *
 */
    function speedy_content_wrapper_end(){
        echo "</section>";
    }
endif;
add_action( 'speedy_action_after_content', 'speedy_content_wrapper_end', 10 );

if ( ! function_exists( 'speedy_footer' ) ) :
    /**
     * Footer content
     *
     * @since Speedy 1.0.0
     *
     * @param null
     * @return null
     *
     */
    function speedy_footer() {
        global $speedy_customizer_all_values;
        ?>
        <!-- *****************************************
             Footer section starts
    ****************************************** -->
        <footer id="colophon" class="wrapper evision-wrapper site-footer" role="contentinfo">
            <div class="container">
                <span class="copyright">
                    <?php
                    if(isset($speedy_customizer_all_values['speedy-copyright-text'])){
                        echo wp_kses_post( $speedy_customizer_all_values['speedy-copyright-text'] );
                    }
                    ?>
                </span>
                <span class="site-info">
                    <a href="<?php echo esc_url( 'https://wordpress.org/', 'speedy' ); ?>"><?php printf( esc_html__( 'Proudly powered by %s.', 'speedy' ), 'WordPress' ); ?></a>
                    <span class="sep"> | </span>
                    <?php printf( esc_html__( 'Theme: %1$s by %2$s', 'speedy' ), 'Speedy', '<a href="http://evisionthemes.com/" rel="designer">eVisionThemes</a>' ); ?>
                </span><!-- .site-info -->
            </div>
        </footer><!-- #colophon -->
        <!-- *****************************************
                 Footer section ends
        ****************************************** -->
    <?php
    }
endif;
add_action( 'speedy_action_footer', 'speedy_footer', 10 );

if ( ! function_exists( 'speedy_page_end' ) ) :
    /**
     * Page end
     *
     * @since Speedy 1.0.0
     *
     * @param null
     * @return null
     *
     */
    function speedy_page_end() {
        ?>
        <a class="evision-back-to-top" href="#page"><i class="fa fa-angle-up"></i></a>
        </div><!-- #page -->
    <?php
    }
endif;
add_action( 'speedy_action_after_content', 'speedy_page_end', 10 );