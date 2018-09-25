<?php
if( ! function_exists( 'speedy_excerpt_length' ) ) :

    /**
     * Excerpt length
     *
     * @since  Speedy 1.0.0
     *
     * @param null
     * @return int
     */
    function speedy_excerpt_length( ){
        return esc_attr( 30 );
    }

endif;
add_filter( 'excerpt_length', 'speedy_excerpt_length', 999 );