<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package eVision themes
 * @subpackage Speedy
 * @since Speedy 1.0.0
 */

/**
 * speedy_action_after_content hook
 * @since Speedy 1.0.0
 *
 * @hooked null
 */
do_action( 'speedy_action_after_content' );

/**
 * speedy_action_before_footer hook
 * @since Speedy 1.0.0
 *
 * @hooked null
 */
do_action( 'speedy_action_before_footer' );

/**
 * speedy_action_footer hook
 * @since Speedy 1.0.0
 *
 * @hooked speedy_footer - 10
 */
do_action( 'speedy_action_footer' );

/**
 * speedy_action_after_footer hook
 * @since Speedy 1.0.0
 *
 * @hooked null
 */
do_action( 'speedy_action_after_footer' );

/**
 * speedy_action_after hook
 * @since Speedy 1.0.0
 *
 * @hooked speedy_page_end - 10
 */
do_action( 'speedy_action_after' );
?>
<?php wp_footer(); ?>
</body>
</html>