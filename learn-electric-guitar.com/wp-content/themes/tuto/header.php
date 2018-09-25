<!DOCTYPE html>
<html class="no-js<?php tuto_html_class(); ?>" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>
<body id="mh-mobile" <?php body_class(); ?>>
<?php tuto_before_header();
get_template_part('content', 'header');
tuto_after_header(); ?>