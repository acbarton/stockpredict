<?php
/**
 * Implement Editor Styles
 *
 * @since Speedy 1.0.0.5
 *
 * @param null
 * @return null
 *
 */
add_action( 'init', 'speedy_add_editor_styles' );

if ( ! function_exists( 'speedy_add_editor_styles' ) ) :
    function speedy_add_editor_styles() {
        add_editor_style( 'editor-style.css' );
    }
endif;