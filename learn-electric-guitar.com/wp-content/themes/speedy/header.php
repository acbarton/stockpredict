	<?php
	/**
	 * The default template for displaying header
	 *
	 * @package eVision themes
	 * @subpackage Speedy
	 * @since Speedy 1.0.0
	 */

	/**
	 * Speedy_action_before_head hook
	 * @since Speedy 1.0.0
	 *
	 * @hooked Speedy_set_global -  0
	 * @hooked Speedy_doctype -  10
	 */
	do_action( 'speedy_action_before_head' );?>
	<head>

		<?php
		/**
		 * Speedy_action_before_wp_head hook
		 * @since Speedy 1.0.0
		 *
		 * @hooked Speedy_before_wp_head -  10
		 */
		do_action( 'speedy_action_before_wp_head' );

		wp_head();

		/**
		 * Speedy_action_after_wp_head hook
		 * @since Speedy 1.0.0
		 *
		 * @hooked null
		 */
		do_action( 'speedy_action_after_wp_head' );
		?>

	</head>

	<body <?php body_class(); ?>>

	<?php
	/**
	 * Speedy_action_before hook
	 * @since Speedy 1.0.0
	 *
	 * @hooked Speedy_page_start - 15
	 */
	do_action( 'speedy_action_before' );

	/**
	 * Speedy_action_before_header hook
	 * @since Speedy 1.0.0
	 *
	 * @hooked Speedy_skip_to_content - 10
	 */
	do_action( 'speedy_action_before_header' );


	/**
	 * Speedy_action_header hook
	 * @since Speedy 1.0.0
	 *
	 * @hooked Speedy_after_header - 10
	 */
	do_action( 'speedy_action_header' );


	/**
	 * Speedy_action_after_header hook
	 * @since Speedy 1.0.0
	 *
	 * @hooked null
	 */
	do_action( 'speedy_action_after_header' );


	/**
	 * Speedy_action_before_content hook
	 * @since Speedy 1.0.0
	 *
	 * @hooked null
	 */
	do_action( 'speedy_action_before_content' );
	?>
