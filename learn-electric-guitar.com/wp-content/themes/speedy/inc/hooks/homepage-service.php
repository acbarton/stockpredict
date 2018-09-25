<?php
if ( ! function_exists( 'speedy_home_service_array' ) ) :
    /**
     * 
     *
     * @since Speedy 1.0.0
     *
     * @param null
     * @return array
     */
    function speedy_home_service_array(){

        $speedy_home_service_contents_array = array();

        $speedy_home_service_contents_array[0]['speedy-home-service-title'] = __('LOVELY DESIGN', 'speedy');
        $speedy_home_service_contents_array[0]['speedy-home-service-content'] = __("The set doesn't moved. Deep don't fru it fowl gathering heaven days moving creeping under from i air. Set it fifth Meat was darkness. every bring in it.", 'speedy');
        $speedy_home_service_contents_array[0]['speedy-home-service-link'] = '#';
        $speedy_home_service_contents_array[0]['speedy-home-service-icon'] = 'fa-desktop';

        $speedy_home_service_contents_array[1]['speedy-home-service-title'] = __('STYLIES PHOTOGRAPY', 'speedy');
        $speedy_home_service_contents_array[1]['speedy-home-service-content'] = __("The set doesn't moved. Deep don't fru it fowl gathering heaven days moving creeping under from i air. Set it fifth Meat was darkness. every bring in it.", 'speedy');
        $speedy_home_service_contents_array[1]['speedy-home-service-link'] = '#';
        $speedy_home_service_contents_array[1]['speedy-home-service-icon'] = 'fa-camera-retro';

        $speedy_home_service_contents_array[2]['speedy-home-service-title'] = __('CREATIVE AGENCY', 'speedy');
        $speedy_home_service_contents_array[2]['speedy-home-service-content'] = __("The set doesn't moved. Deep don't fru it fowl gathering heaven days moving creeping under from i air. Set it fifth Meat was darkness. every bring in it.", 'speedy');
        $speedy_home_service_contents_array[2]['speedy-home-service-link'] = '#';
        $speedy_home_service_contents_array[2]['speedy-home-service-icon'] = 'fa-rocket';

        $speedy_icons_arrays = array();
        $speedy_home_service_args = array();

        $repeated = array('speedy-home-service-page-icon','speedy-home-service-pages-ids');

        $speedy_home_service_posts = evision_customizer_get_repeated_all_value(3, $repeated);
        $speedy_home_service_posts_ids = array();
        if( null != $speedy_home_service_posts ) {
            foreach( $speedy_home_service_posts as $speedy_home_service_post ) {
                if( isset($speedy_home_service_post['speedy-home-service-pages-ids']) && 0 != $speedy_home_service_post['speedy-home-service-pages-ids'] ){
                    $speedy_home_service_posts_ids[] = $speedy_home_service_post['speedy-home-service-pages-ids'];
                    if( isset( $speedy_home_service_post['speedy-home-service-page-icon'] )){
                        $speedy_home_service_page_icon = $speedy_home_service_post['speedy-home-service-page-icon'];
                    }
                    else{
                        $speedy_home_service_page_icon = 'fa-desktop';
                    }
                    $speedy_icons_arrays[] = $speedy_home_service_page_icon;
                }
            }
            if( !empty( $speedy_home_service_posts_ids )){
                $speedy_home_service_args =    array(
                    'post_type' => 'page',
                    'post__in' => $speedy_home_service_posts_ids,
                    'posts_per_page' => 3,
                    'orderby' => 'post__in'
                );
            }
        }
        // the query
        if( !empty( $speedy_home_service_args )){
            $speedy_home_service_contents_array = array(); /*again empty array*/
            $speedy_home_service_post_query = new WP_Query( $speedy_home_service_args );
            if ( $speedy_home_service_post_query->have_posts() ) :
                $i = 0;
                while ( $speedy_home_service_post_query->have_posts() ) : $speedy_home_service_post_query->the_post();
                    $speedy_home_service_contents_array[$i]['speedy-home-service-title'] = get_the_title();
                    $speedy_home_service_contents_array[$i]['speedy-home-service-content'] = speedy_words_count( 30 ,get_the_content());
                    $speedy_home_service_contents_array[$i]['speedy-home-service-link'] = get_permalink();
                    if(isset( $speedy_icons_arrays[$i] )){
                        $speedy_home_service_contents_array[$i]['speedy-home-service-icon'] = $speedy_icons_arrays[$i];
                    }
                    else{
                        $speedy_home_service_contents_array[$i]['speedy-home-service-icon'] = 'fa-desktop';
                    }
                    $i++;
                endwhile;
                wp_reset_postdata();
            endif;
        }
        return $speedy_home_service_contents_array;
    }
endif;

if ( ! function_exists( 'speedy_home_service' ) ) :
    /**
     *
     * @since Speedy 1.0.0
     *
     * @param null
     * @return null
     *
     */
    function speedy_home_service() {
        global $speedy_customizer_all_values;
        if( 1 != $speedy_customizer_all_values['speedy-home-service-enable'] ){
            return null;
        }
        $speedy_service_arrays = speedy_home_service_array();
        if( is_array( $speedy_service_arrays )){
            ?>
            <section class="evision-wrapper block-section wrap-service">
                <div class="container-fluid">
                    <div class="row block-row overhidden">
                        <?php
                        $i = 1;
                        $data_delay = 0;
                        foreach( $speedy_service_arrays as $speedy_service_array ){
                            if( 3 < $i){
                                break;
                            }
                            $data_wow_delay = 'data-wow-delay='.$data_delay.'s';
                            ?>
                            <div class="col-md-4 box-container evision-animate bounceInRight" <?php echo esc_attr( $data_wow_delay );?>>
                                <div class="box-inner">
                                        <div class="icon-container">
                                            <span><i class="fa <?php echo esc_attr( $speedy_service_array['speedy-home-service-icon'] ); ?>"></i></span>
                                        </div>
                                        <div class="box-content">
                                            <h3>
                                                <?php echo esc_html( $speedy_service_array['speedy-home-service-title'] );?>
                                            </h3>
                                            <div class="box-content-text">
                                                <p>
                                                    <?php echo wp_kses_post( $speedy_service_array['speedy-home-service-content'] );?>
                                                </p>
                                                <a href="<?php echo esc_url( $speedy_service_array['speedy-home-service-link'] );?>" title="<?php echo esc_attr( $speedy_service_array['speedy-home-service-title'] ); ?>">
                                                    <?php esc_html_e( 'View more', 'speedy' ); ?>
                                                    <i class="fa fa-angle-double-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                   
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                        ?>

                    </div>
                    </div>
                <div class="container-fluid">
                   <div class="divider"></div>
               </div>
            </section><!-- service section -->
               
            <?php
        }
        ?>
        <?php
    }
endif;
add_action( 'speedy_action_home_service', 'speedy_home_service', 20 );