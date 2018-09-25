<?php

/*-----------------------------------------------------------------------------------*/
# Get Principal Theme Functions and files
/*-----------------------------------------------------------------------------------*/
require get_template_directory() . '/inc/options/wp_list_comments.php' ;
require get_template_directory() . '/inc/options/slider.php' ;
require get_template_directory() . '/inc/options/breaking.php' ;
require get_template_directory() . '/inc/options/breadcrumbs.php' ;
require get_template_directory() . '/inc/options/related.php' ;
require get_template_directory() . '/inc/options/post-nav.php' ;
require get_template_directory() . '/inc/options/post-thumbnail.php' ;
require get_template_directory() . '/inc/options/madar-includes.php' ;
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/widgets/madar-category.php';
require get_template_directory() . '/widgets/madar-random-posts.php';
require get_template_directory() . '/widgets/madar-recent-comment.php';
require get_template_directory() . '/widgets/madar-recent-posts.php';
/*-----------------------------------------------------------------------------------*/
# Get WordPress Localization
/*-----------------------------------------------------------------------------------*/

add_action('after_setup_theme', 'madarlite_setup');
function madarlite_setup(){
load_theme_textdomain('madar-lite', get_template_directory() . '/languages');
if ( ! isset( $content_width ) ) $content_width = 900;
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'title-tag' );
add_theme_support( 'custom-logo', array(
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( 'site-title', 'site-description' ),
));
/*-----------------------------------------------------------------------------------*/
# @ Get Madar Thumbnail Size
/*-----------------------------------------------------------------------------------*/

	add_theme_support( 'post-thumbnails' );
	add_image_size( 'post-thumbnail', 258, 150, true);
	add_image_size( 'madar-thumbnail', 125, 125, true);
	add_image_size( 'box-thumbnail', 290, 175, true);
	add_image_size( 'madar-thumbnail-child', 55, 55, true);
	add_image_size( 'madar-thumbnail-recent', 150, 100, true);
	add_image_size( 'madar-thumbnail-mchild', 110, 70, true);
	add_image_size( 'madar-slide', 646, 380, true);
	add_image_size( 'madar-featured-big', 980, 400, true);
	add_image_size( 'madar-slide-item', 80, 80, true);
	add_image_size( 'madar-box', 315, 160, true);
	add_image_size( 'madar-box-thumbnail', 345, 240, true);
	add_image_size( 'madar-small-box-thumbnail', 315, 280, true);
	add_image_size( 'madar-featured', 650, 300, true);
	add_image_size( 'madar-related', 185, 110, true);
    set_post_thumbnail_size( 100, 100 ); ## small
	set_post_thumbnail_size( 110, 70 ); ## small mchild
	set_post_thumbnail_size( 650, 300 ); ## featured
	// custom menu support
	add_theme_support( 'menus' );
	if ( function_exists( 'register_nav_menus' ) ) {
	  	register_nav_menus(
	  		array(
	  		  'top-menu' => esc_html__( 'Top Menu', 'madar-lite' ),
	  		  'header-menu' => esc_html__( 'Primary Menu', 'madar-lite' ),
	  		  'footer-menu' => esc_html__( 'Footer Menu', 'madar-lite' )
	  		)
	  	);
	}
	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'madarlite_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}

function madarlite_about_page() { 
	add_theme_page( __('Madar Lite Panel','madar-lite'), __('Madar Lite Panel','madar-lite'), 'edit_theme_options', 'theme-about', 'madarlite_theme_about' ); 
	}
	add_action('admin_menu', 'madarlite_about_page');

function madarlite_theme_about() {  require_once ( trailingslashit(get_template_directory()) . 'inc/theme-about.php' ); }

// 	Functions for adding script to Admin Area
function madarlite_admin_style() { wp_enqueue_style( 'madarlite_about_css', get_template_directory_uri() . '/inc/admin-style.css', false ); }
	add_action( 'admin_enqueue_scripts', 'madarlite_admin_style' );

function madarlite_widgets_init() {
	// Sidebar Widget
	// Location: the sidebar
	register_sidebar(array(
	    'name'=>__('Sidebar','madar-lite'),
		'id' => 'sidebar',
		'before_widget' => '<div class="widget-area widget-sidebar">',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget-header"><h3>',
		'after_title' => '</h3></div>',
	));
	//Footer widget areas
	register_sidebar( array(
			'name'          => __( 'Footer Position 1', 'madar-lite' ) ,
			'id'            => 'footer-1',
			'description'   => __( 'Put widget Here! ', 'madar-lite' ),
			'before_widget' => '<div class="footer-widget-area widget-footer">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="footer-widget-header"><h4>',
			'after_title'   => '</h4></div>',
    ) );

    // Register Footer Position 2
    register_sidebar( array(
			'name'          => __( 'Footer Position 2', 'madar-lite' ) ,
			'id'            => 'footer-2',
			'description'   => __( 'Put widget Here! ', 'madar-lite' ),
			'before_widget' => '<div class="footer-widget-area widget-footer">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="footer-widget-header"><h4>',
			'after_title'   => '</h4></div>',
    ) );

    // Register Footer Position 3
    register_sidebar( array(
			'name'          => __( 'Footer Position 3', 'madar-lite' ) ,
			'id'            => 'footer-3',
			'description'   => __( 'Put widget Here! ', 'madar-lite' ),
			'before_widget' => '<div class="footer-widget-area widget-footer">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="footer-widget-header"><h4>',
			'after_title'   => '</h4></div>',
    ) );

    // Register Footer Position 4
    register_sidebar( array(
			'name'          => __( 'Footer Position 4', 'madar-lite' ) ,
			'id'            => 'footer-4',
			'description'   => __( 'Put widget Here! ', 'madar-lite' ),
			'before_widget' => '<div class="footer-widget-area widget-footer">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="footer-widget-header"><h4>',
			'after_title'   => '</h4></div>',
    ) );

	//Custom widgets
	register_widget( 'madarlite_category_widgets' );
	register_widget( 'madarlite_random_post_widgets' );
	register_widget( 'madarlite_recent_comment_widgets' );
	register_widget( 'madarlite_recent_post_widget' );
}
add_action( 'widgets_init', 'madarlite_widgets_init' );

/*-----------------------------------------------------------------------------------*/
# @ Get Madar Navigation Fallback
/*-----------------------------------------------------------------------------------*/

function madarlite_nav_fallback(){
	echo '<div class="menu-alert">' . __('Use WordPress Menu builder OR Customizer to Manage Menus', 'madar-lite') . '</div>';
}
/*-----------------------------------------------------------------------------------*/
# Get Madar Principal Files !
/*-----------------------------------------------------------------------------------*/

// 	Excerpt Length
	function madarlite_excerpt_length( $length ) {
	global $madarlite_excerptlength;
	if ($madarlite_excerptlength) {
    return $madarlite_excerptlength;
	} else {
    return 30; //default value
    } }
	add_filter( 'excerpt_length', 'madarlite_excerpt_length', 999 );

    function madarlite_excerpt_more($more) {

	 $getappend = esc_html__( ' Continue Reading &raquo;', 'madar-lite' );
	return '<a href="'. esc_url( get_permalink(get_the_ID()) ) .'" class="read-more">'.$getappend.'</a>';
    }
    add_filter('excerpt_more', 'madarlite_excerpt_more');

    function madarlite_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';


	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';



	echo '<div class="date"><i class="fa fa-clock-o"></i>' . $posted_on . '</div>';

	$categories_list = get_the_category_list( __( ', ', 'madar-lite' ) );
	if ( $categories_list && madarlite_categorized_blog() ) {
		echo '<div class="cat"><i class="fa fa-tag"></i> ' . $categories_list . '</div>';
	}

    }

    function madarlite_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'madarlite_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'madarlite_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so madarlite_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so madarlite_categorized_blog should return false.
		return false;
	}
}
    function madarlite_post_meta(){ ?>
	<div class="post-footer">
		<p><i class="fa fa-comments-o"></i><?php comments_popup_link(__('No Comments', 'madar-lite'), '1 ' . __('Comment', 'madar-lite'), '% ' . __('Comments', 'madar-lite')); ?></p>
		<p><i class="fa fa-folder-open"></i><?php _e('Categories: ', 'madar-lite'); the_category(', ') ?></p>
	</div>	
	
	<?php
	}
//  The Content
	function madarlite_content() {
	if ( is_page() || is_single() ) : the_content('<span class="read-more">' . __('Read More','madar-lite') . '</span>');
	else: the_excerpt();
	endif;	
	}
// 	Post Author and Date Design
    function madarlite_author_meta() {
	$archive_year  = get_the_time('Y'); 
	$archive_month = get_the_time('m'); 
	$archive_day   = get_the_time('d'); 
	?>
	<p class="post-meta"><?php _e('Written on ', 'madar-lite'); the_time('F j, Y'); _e(', by ', 'madar-lite'); the_author_posts_link(); ?></p>
	<?php
	}
//	News Page Navigation
	function madarlite_page_nav() { ?>
 		<div class="default-navigation">
 	 		<div class="alignleft"><?php previous_posts_link('&laquo;  ' . __('Newer News','madar-lite') ) ?></div>
 	 		<div class="alignright"><?php next_posts_link(__('Older News','madar-lite') .' &raquo;') ?></div>
 		</div>
	<?php }
//	404 Error Content
    function madarlite_404() { ?>
	<div class="no-results">
				<p><strong><?php _e('There has been an error.', 'madar-lite'); ?></strong></p>
				<p><?php _e('We apologize for any inconvenience, please hit back on your browser or use the search form below.', 'madar-lite'); ?></p>
				<?php get_search_form(); ?>
	</div>
	<?php }
/*-----------------------------------------------------------------------------------*/
# @ Get Madar pagination Settings
/*-----------------------------------------------------------------------------------*/

	$madarlite_pageArgs = array(
		'before'=> '<div class="pagination">',
		'after'=> '</div>',
		'link_before'=> '<div class="page-item">',
		'link_after'=> '</div>',
		'next_or_number'=> 'number',
		'nextpagelink' => __('Next page', 'madar-lite'),
		'previouspagelink'=> __('Previous page', 'madar-lite'),
		'pagelink'=> '%',
	);
/*-----------------------------------------------------------------------------------*/
# @ Get Madar Custom Image Resizer
/*-----------------------------------------------------------------------------------*/

function madarlite_thumb($width='315', $height='150', $type){
	$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
	<img src="<?php echo $feat_image; ?>" class="wp-post-image" alt="<?php the_title(); ?>" <?php if($type){echo 'title="'.get_the_title().'"';} ?> height="<?php echo $height; ?>" width="<?php echo $width; ?>"><?php
}

/*-----------------------------------------------------------------------------------*/
# @ Get Madar Custom Thumbnail Resizer
/*-----------------------------------------------------------------------------------*/

function madarlite_thumbnail($pagename, $imgtype = '', $the_thumb=''){
	if($pagename == 'post'){
		$the_thumb = 'madar-thumbnail';
		$size = array(125,125);
	}elseif($pagename == 'box'){
		$the_thumb = 'madar-box';
		$size = array(315,160);
	}elseif($pagename == 'msmall'){
		$the_thumb = 'madar-thumbnail-mchild';
		$size = array(110,70);
	}elseif($pagename == 'big'){
		$the_thumb = 'madar-box-thumbnail';
		$size = array(345,240);
	}elseif($pagename == 'medium'){
		$the_thumb = 'madar-small-box-thumbnail';
		$size = array(315, 280);
	}elseif($pagename == 'small'){
		$the_thumb = 'madar-thumbnail-child';
		$size = array(55,55);
	}elseif($pagename == 'rsmall'){
		$the_thumb = 'madar-thumbnail-recent';
		$size = array(150,100);
	}elseif($pagename == 'related'){
		$the_thumb = 'madar-related';
		$size = array(185,110);
	}
	if ( has_post_thumbnail() ) {
		if($imgtype){ ?>
			<a class="madar-thumb <?php echo $imgtype; ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php
			if ( get_theme_mod('resizer_enable')) {	
				madarlite_thumb();
			} else {
				the_post_thumbnail($the_thumb, array('alt' => get_the_title()));
			} ?>
			<span class="fa overlay-icon"></span>
			</a>
		<?php }else{ ?> 
			<a class="madar-thumb" href="<?php the_permalink(); ?>" ><?php
			if ( get_theme_mod('resizer_enable')) {	
				madarlite_thumb();
			} else {
				the_post_thumbnail($the_thumb, array('alt' => get_the_title(), 'title' => get_the_title()));
			} ?>
			</a>
	<?php }
	}	
}

/*-----------------------------------------------------------------------------------*/
# @ Get Madar Comment Excerpt
/*-----------------------------------------------------------------------------------*/

function madarlite_comment_excerpt($comment_ID = 0, $num_words = 10) {
	$comment = get_comment( $comment_ID );
	$comment_text = strip_tags($comment->comment_content);
	$blah = explode(' ', $comment_text);
	if (count($blah) > $num_words) {
		$k = $num_words;
		$use_dotdotdot = 1;
	} else {
		$k = count($blah);
		$use_dotdotdot = 0;
	}
	$excerpt = '';
	for ($i=0; $i<$k; $i++) {
		$excerpt .= $blah[$i] . ' ';
	}
	$excerpt .= ($use_dotdotdot) ? '...' : '';
	return apply_filters('get_comment_excerpt', $excerpt);
}



/*-----------------------------------------------------------------------------------*/
# @ Get Madar Comment Counter
/*-----------------------------------------------------------------------------------*/

function madarlite_getcomment_count($id, $post='normal'){ 
	if ($post == 'normal'){
		$num_comments = get_comments_number($id); // get_comments_number returns only a numeric value
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$comments = __('0', 'madar-lite');
			} elseif ( $num_comments > 1 ) {
				$comments = $num_comments . ' ' . __('Comments', 'madar-lite');
			} else {
				$comments = '1 ' . __('reply', 'madar-lite');
			}
		$write_comments = '<span class="post-comments"><a href="' . get_comments_link() .'"><i class="fa fa-comment"></i>'. $comments.'</a></span>';
		} else {
			$write_comments =  __('Closed', 'madar-lite');
		} 
		return $write_comments;
	}elseif ($post == 'index') {
		$num_comments = get_comments_number($id); // get_comments_number returns only a numeric value
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$write_comments = '0';
			} elseif ( $num_comments > 1 ) {
				$write_comments = $num_comments . '';
			} else {
				$write_comments = '1';
			}
		} else {
			$write_comments =  'closed';
		} 
		return $write_comments;
	}elseif ($post == 'post') {
		$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$comments = '0';
				$commentsdesc = __('Be First!', 'madar-lite');		
			} elseif ( $num_comments > 1 ) {
				$comments = $num_comments;
				$commentsdesc = __('Comments', 'madar-lite');
			} else {
				$comments = '1';
				$commentsdesc = __('Comment', 'madar-lite');
			}
			$write_comments = '<div class="count-head"><a href="' . get_comments_link() .'">'. $comments.'</a></div><div class="count-desc">'. $commentsdesc.'</div>';
		} else {
			$write_comments =  __('Closed', 'madar-lite');
		} 
		return $write_comments;
	}
}

/*-----------------------------------------------------------------------------------*/
# @ Get Madar Random Post
/*-----------------------------------------------------------------------------------*/

add_action('init', 'madarlite_random_post');
function madarlite_random_post(){
	if ( isset($_GET['madarliterand']) ){

		$args = array(
			'posts_per_page'		 => 1,
			'orderby'				 => 'rand',
			'no_found_rows'          => true,
			'ignore_sticky_posts'	 => true
		);
$random = new WP_Query( $args );
if ($random->have_posts()) {
	while ($random->have_posts()) : $random->the_post();
		$URL = get_permalink();
	endwhile;
	wp_reset_query(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Refresh" content="0; url=<?php echo $URL; ?>">
</head>
<body>
</body>
</html>
<?php }
		die;
	}
}

/*-----------------------------------------------------------------------------------*/
# @ Get Madar Lite Enqueue Scripts
/*-----------------------------------------------------------------------------------*/
function madarlite_scripts() {
	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5shiv.js', false, '', true );	
	wp_enqueue_style( 'madarlite-style', get_stylesheet_uri() );
	wp_enqueue_script( 'madar-jslib', get_template_directory_uri() . '/js/madar.jslib.js', false, '', true );	
	wp_enqueue_script( 'gotop', get_template_directory_uri() . '/js/gotop.js', false, '', true );	
	wp_enqueue_script( 'madar-script', get_template_directory_uri() . '/js/madar.script.js', false, '', true );
	wp_enqueue_script( 'bonzo', get_template_directory_uri() . '/js/bonzo.js', false, '', true );
	// Register and enqueue mainav.js
	wp_enqueue_script( 'madarlite-jquery-navigation', get_template_directory_uri() . '/js/mainav.js', array( 'jquery' ), '20160421' );
	
	// Passing Parameters to mainav.js
	wp_localize_script( 'madarlite-jquery-navigation', 'madarlite_menu_title', esc_html__( 'Navigation', 'madar-lite' ) );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
	}
	if (is_front_page()):
    wp_enqueue_script( 'flex-script', get_template_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ) );	
	wp_enqueue_script( 'madarlite-home', get_template_directory_uri() . '/js/home.js', array( 'jquery' ) );
	endif;
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css' );	
 	if (!isset($_GET['device'])) {
	wp_enqueue_style( 'responsive-css', get_template_directory_uri() . '/css/responsive.css' );	
	}
?>
<?php
global $is_IE;
if( $is_IE ){ ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?php }
}
add_action('wp_enqueue_scripts', 'madarlite_scripts');
/*-----------------------------------------------------------------------------------*/
# @ Get Madar Popular Post
/*-----------------------------------------------------------------------------------*/

function madarlite_postlisting($type, $data, $thumb='true'){ ?>
	<?php while($data->have_posts()) : $data->the_post(); ?>
		<li>
			<?php if($thumb){ ?>
			<div class="widget-thumb">
				<?php echo madarlite_thumbnail('small');?>
			</div>
			<?php } ?>
			<h3>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
					<?php echo the_title();?>
				</a>
			</h3>
			<div class="widget-meta">
				<p class="post-meta">
					<i class="fa fa-clock-o"></i><?php the_time('M j, Y'); ?>
					<?php echo madarlite_getcomment_count(get_the_ID()); ?>
				</p>
			</div>
		</li>
		<?php wp_reset_postdata(); 
	endwhile; ?>
<?php
}
?>