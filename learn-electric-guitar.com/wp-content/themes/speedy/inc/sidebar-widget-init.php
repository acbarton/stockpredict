<?php

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function speedy_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'speedy' ),
        'id'            => 'sidebar-1',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'speedy_widgets_init' );