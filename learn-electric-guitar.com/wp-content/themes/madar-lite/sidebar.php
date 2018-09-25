<?php
/**
 * The sidebar containing the main widget area.
 *
 * @WordPress Theme package Madar Lite
 */

if ( ! is_active_sidebar( 'sidebar' ) ) {
	return;
}
?>
<aside id="sidebar">
<?php dynamic_sidebar( 'sidebar' ); ?>
</aside><!--sidebar-->