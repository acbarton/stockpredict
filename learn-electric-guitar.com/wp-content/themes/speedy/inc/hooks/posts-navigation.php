<?php
if ( ! function_exists( 'speedy_posts_navigation' ) ) :

    /**
     * Posts navigation options
     *
     * @since Speedy 1.0.0
     *
     * @param null
     * @return int
     */
    function speedy_posts_navigation() {
        the_posts_navigation();
    }
endif;
add_action( 'speedy_action_posts_navigation', 'speedy_posts_navigation' );