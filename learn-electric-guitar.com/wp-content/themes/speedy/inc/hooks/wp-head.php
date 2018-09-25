<?php
if( ! function_exists( 'speedy_wp_head' ) ) :

    /**
     * Speedy wp_head hook
     *
     * @since  Speedy 1.0.0
     */
    function speedy_wp_head(){
        global $speedy_customizer_all_values;
        global $speedy_google_fonts;
        $speedy_font_family_body = $speedy_google_fonts[$speedy_customizer_all_values['speedy-font-family-body']];
        $speedy_font_family_site_identity = $speedy_google_fonts[$speedy_customizer_all_values['speedy-font-family-site-identity']];
        $speedy_font_family_h1_h6 = $speedy_google_fonts[$speedy_customizer_all_values['speedy-font-family-h1-h6']];
        /*Color options */
        $speedy_h1_h6_color = $speedy_customizer_all_values['speedy-h1-h6-color'];
        $speedy_link_color = $speedy_customizer_all_values['speedy-link-color'];
        $speedy_link_hover_color = $speedy_customizer_all_values['speedy-link-hover-color'];
        $speedy_site_identity_color = $speedy_customizer_all_values['speedy-site-identity-color'];
        ?>
        <style type="text/css">
            /*site Body font family*/
            html,
            body,
            button,
            input,
            select,
            textarea,
            p,
            p a,
            q, 
            blockquote,
            a,
            code,
            kbd,
            tt,
            var,
            samp,
            pre,
            .main-navigation a,
            .widget_calendar caption {
                font-family: '<?php echo esc_attr( $speedy_font_family_body ); ?>'!important;
            }
            /*site identity font family*/
            .site-title,
            .site-title a,
            .site-description,
            .site-description a{
                font-family: '<?php echo esc_attr( $speedy_font_family_site_identity ); ?>'!important;
            }
            /*Title font family*/
            h1, h1 a,
            h1.site-title,
            h1.site-title a,
            h2, h2 a,
            h3, h3 a,
            h4, h4 a,
            h5, h5 a,
            h6, h6 a {
                font-family: '<?php echo esc_attr( $speedy_font_family_h1_h6 ); ?>'!important;
            }
            <?php
            /*Main h1-h6 color*/
            if( !empty($speedy_h1_h6_color) ){
            ?>
            h1, h1 a,
            h2, h2 a,
            h3, h3 a,
            h4, h4 a,
            h5, h5 a,
            h6, h6 a{
                color: <?php echo esc_attr( $speedy_h1_h6_color );?> !important; /*#212121*/
            }
            <?php
            }
          /*Link color*/
            if( !empty($speedy_link_color) ){
            ?>
            a,
            a > p,
            .posted-on a,
            .cat-links a,
            .tags-links a,
            .author a,
            .comments-link a,
            .edit-link a,
            .nav-links .nav-previous a,
            .nav-links .nav-next a,
            .page-links a {
                color: <?php echo esc_attr( $speedy_link_color ); ?> !important; /*#212121*/
            }
            <?php
            }
            /*Link Hover color*/
              if( !empty($speedy_link_hover_color) ){
              ?>
              a:hover,
              a > p:hover,
              .main-navigation a:hover,
              .posted-on a:hover,
              .cat-links a:hover,
              .tags-links a:hover,
              .author a:hover,
              .comments-link a:hover,
              .edit-link a:hover,
              .nav-links .nav-previous a:hover,
              .nav-links .nav-next a:hover,
              .page-links a:hover,
              .main-navigation li:hover > a,
              .main-navigation ul ul a:hover,
              .site-title:hover, .site-title a:hover, 
              .site-description:hover, 
              .site-description a:hover,
              .box-inner:hover .icon-container i.fa {
                  color: <?php echo esc_attr( $speedy_link_hover_color ); ?> !important; /*#212121*/
              }
              <?php
              }
            /*header menu text*/
            if( !empty( $speedy_site_identity_color ) ){
            ?>
            .site-title,
            .site-title a,
            .site-description,
            .site-description a{
                color: <?php echo esc_attr( $speedy_site_identity_color );?>!important;
            }
            <?php
            }
            $speedy_custom_css = $speedy_customizer_all_values['speedy-custom-css'];
            $speedy_custom_css_output = '';
            if ( ! empty( $speedy_custom_css ) ) {
                $speedy_custom_css_output .= esc_textarea( $speedy_custom_css ) ;
            }
            echo $speedy_custom_css_output;/*escaping done above*/
            ?>
        </style>
    <?php
    }
endif;
add_action( 'wp_head', 'speedy_wp_head' );
