<?php

// Theme Constants
define("THEME_PREFIX", "massivenews_");

// Theme Location
define('THEME', get_bloginfo('template_url'), true);

// Add RSS Feed Links
add_theme_support( 'automatic-feed-links' );

// WordPress Post Thumbnail Support
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(100, 100, true);
    add_image_size('sidebar', 100, 100, true);
    add_image_size('featured', 550, 550, true);
	add_image_size('header', 250, 175, true);
}

// Include Custom Widgets
include('widgets/cat-posts.php');
include('widgets/related-posts.php');
include('widgets/recent-comments.php');
include('widgets/simple-sidebar-ads.php');

// Load Required Theme Scripts
function sf_theme_js() {
	if (is_admin()) return;
	wp_enqueue_script('jquery');
	wp_enqueue_script('superfish', THEME . '/scripts/jquery.superfish.js');
	wp_enqueue_script('easing', THEME . '/scripts/jquery.easing.js', 'jquery');
	wp_enqueue_style('fancybox', THEME . '/scripts/fancybox/style.css');
	wp_enqueue_script('fancybox', THEME . '/scripts/fancybox/jquery.fancybox.js', 'jquery');
	wp_enqueue_script('slide', THEME . '/scripts/jquery.slide.js', 'jquery');
}
add_action('init', sf_theme_js);

// The Admin Page
add_action('admin_menu', "sf_massivenews_admin_init");

// Register Admin
function sf_massivenews_admin_init()
{
	$page = add_theme_page( "Massive News Options", "Theme Options", 8, 'sf_massivenews_admin_menu', 'sf_massivenews_admin');

	// Custom Image Uploaders
	sf_add_img_upload_filter(THEME_PREFIX.'background_img', 'sf_handle_bg_upload');
	sf_add_img_upload_filter(THEME_PREFIX.'logo_img', 'sf_handle_logo_upload');
	sf_add_img_upload_filter(THEME_PREFIX.'favicon', 'sf_handle_favicon_upload');
}

// Image Upload Helper Function
function sf_add_img_upload_filter($option_name, $handler) {
  add_filter('pre_update_option_'.$option_name, $handler, 10, 2);
}

// Image Upload Handler Functions
function sf_handle_bg_upload($new_value, $old_value) {
  return sf_handle_img_upload(
    $new_value, 
    $old_value, 
    THEME_PREFIX.'background_img_upload', 
    THEME_PREFIX.'delete_bg_img');
}

function sf_handle_logo_upload($new_value, $old_value) {
  return sf_handle_img_upload(
    $new_value, 
    $old_value, 
    THEME_PREFIX.'logo_img_upload', 
    THEME_PREFIX.'delete_logo_img');
}

function sf_handle_favicon_upload($new_value, $old_value) {
  return sf_handle_img_upload(
    $new_value, 
    $old_value, 
    THEME_PREFIX.'favicon_upload', 
    THEME_PREFIX.'delete_favicon');
}

// Generic Image Upload Handler
function sf_handle_img_upload($new_value, $old_value, $file_index, $delete_field) {
  if ( isset($_POST[$delete_field]) && $_POST[$delete_field]=='true' )
    return '';

  if ( empty($_FILES) || !isset($_FILES[$file_index]) || 0==$_FILES[$file_index]['size'] )
    return $old_value;

  $overrides = array('test_form' => false);
  $file = wp_handle_upload($_FILES[$file_index], $overrides);

  if ( isset($file['error']) )
    wp_die( $file['error'] );

  $url = $file['url'];
  $type = $file['type'];
  $file = $file['file'];
  $filename = basename($file);

  // Construct The Object Array
  $object = array(
		  'post_title' => $filename,
		  'post_content' => $url,
		  'post_mime_type' => $type,
		  'guid' => $url
		  );

  // Save The Data
  $id = wp_insert_attachment($object, $file);

  // Add The Meta
  wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file ) );

  do_action('wp_create_file_in_uploads', $file, $id); // For replication
  return esc_url($url);
}

function sf_massivenews_admin() {

	$option_fields = array();

	if ( $_GET['updated'] ) echo '<div id="message" class="updated fade"><p>Massive News Theme Options Saved.</p></div>';
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_url').'/functions.css" type="text/css" media="all" />';
	
	// Accordion Script
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_url').'/scripts/accordion/style.css" type="text/css" media="all" />';
	echo '<script src="'.get_bloginfo('template_url').'/scripts/accordion/jquery.ui.js" type="text/javascript"></script>';
	echo '<script src="'.get_bloginfo('template_url').'/scripts/accordion/jquery.accordion.js" type="text/javascript"></script>';
	
	// Color Picker Script
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_url').'/scripts/colorpicker/style.css" type="text/css" media="all" />';
	echo '<script src="'.get_bloginfo('template_url').'/scripts/colorpicker/jquery.colorpicker.js" type="text/javascript"></script>';
	echo '<script src="'.get_bloginfo('template_url').'/scripts/colorpicker/jquery.eye.js" type="text/javascript"></script>';
	
	// Styling File Form Elements
	echo '<script src="'.get_bloginfo('template_url').'/scripts/si.files.js" type="text/javascript"></script>';
?>

<div class="wrap">
    <div id="icon-options-general" class="icon32"><br/></div>

    <h2>Massive News Theme Options</h2>
    <div class="metabox-holder">
    	<form method="post" action="options.php" enctype="multipart/form-data">
		<?php wp_nonce_field('update-options'); ?>
    
        <div id="theme-options">
	        <div id="accordion" class="postbox-container">
	            <?php 
	            	include("options/custom-logo.php");
	            	include("options/custom-favicon.php");
	            	include("options/header-advertisement.php");
	            	include("options/custom-menus.php");
	            	include("options/custom-layout.php");
	            	include("options/custom-styles.php");
	            	include("options/featured-content.php");
	            	include("options/post-thumbnails.php");
	            	include("options/footer-text.php");
	            	include("options/analytics-code.php");
	            	include("options/no-ie.php");
	        	?>
	        </div> <!-- postbox-container -->
        </div> <!-- theme-options -->
        
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="<?php echo implode(",", $option_fields); ?>" />
        </form>
        
        <script type="text/javascript" language="javascript">SI.Files.stylizeAll();</script>
    </div> <!-- metabox-holder -->
</div> <!-- wrap -->

<?php
}

// Custom Video Function
function get_video($postID) {
	if( function_exists('p75GetVideo') ) {
		$video = p75GetVideo($postID);
		return $video ? "<div class='video'>" . $video . "</div>" : "";
	}
	return "";
}

// Get Published Posts
function p75_get_published_posts() {
	global $wpdb;
	
	return $wpdb->get_results( 'SELECT ID, post_title FROM ' . $wpdb->posts . ' WHERE post_status="publish" AND post_type="post" ORDER BY post_date DESC' );
}

// Get Published Pages
function p75_get_published_pages() {
	global $wpdb;
	
	return $wpdb->get_results( 'SELECT ID, post_title FROM ' . $wpdb->posts . ' WHERE post_status="publish" AND post_type="page" ORDER BY post_date DESC' );
}

// Custom Styles Function
add_action( 'parse_request', 'sf_custom_css' );
function sf_custom_css($wp) {
    if (
        !empty( $_GET['sf-custom-content'] )
        && $_GET['sf-custom-content'] == 'css'
    ) {
        header( 'Content-Type: text/css' );
        require dirname( __FILE__ ) . '/style-custom.php';
        exit;
    }
}

// Custom Excerpt Length
function new_excerpt_length($length) {
	return 50;
}
add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_more($more) {
	return ' ...';
}
add_filter('excerpt_more', 'new_excerpt_more');

// Custom Pagination Function
function sf_pagenavi($before = '', $after = '', $prelabel = '', $nxtlabel = '', $pages_to_show = 5, $always_show = false) {
	global $request, $posts_per_page, $wpdb, $paged;
	if(empty($prelabel)) {   $prelabel = '';
		} if(empty($nxtlabel)) {
		$nxtlabel = '';
	} $half_pages_to_show = round($pages_to_show/2);
	if (!is_single()) {
		if(!is_category()) {
		preg_match('#FROM\s(.*)\sORDER BY#siU', $request, $matches);  } else {
		preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);  }
		$fromwhere = $matches[1];
		$numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $fromwhere");
		$max_page = ceil($numposts /$posts_per_page);
		if(empty($paged)) {
			$paged = 1;
		}
		if($max_page > 1 || $always_show) {
			echo "$before <div class='box pagination'>Pages ... ";   if ($paged >= ($pages_to_show-1)) {
			echo '';  }
			previous_posts_link($prelabel);
			for($i = $paged - $half_pages_to_show; $i <= $paged + $half_pages_to_show; $i++) {   if ($i >= 1 && $i <= $max_page) {   if($i == $paged) {
						echo "$i";
						} else {
					echo ' <a href="'.get_pagenum_link($i).'">'.$i.'</a> ';   }
				}
			}
			next_posts_link($nxtlabel, $max_page);
			if (($paged+$half_pages_to_show) < ($max_page)) {
			echo '';   }
			echo "<div class='clear'></div></div> $after";
		}
	}
}

// Register Sidebars

if (is_category('blog'))
	get_option(THEME_PREFIX . "two_column") = true;
	
if ( function_exists('register_sidebar') && get_option(THEME_PREFIX . "two_column")==false )
register_sidebar(array('name'=>'Center Sidebar',
'before_widget' => '<div id="%1$s" class="box widget %2$s">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>'
));

if ( function_exists('register_sidebar') && get_option(THEME_PREFIX . "two_column")==false )
register_sidebar(array('name'=>'Right Sidebar',
'before_widget' => '<div id="%1$s" class="box widget %2$s">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>'
));

if (function_exists('register_sidebar') && get_option(THEME_PREFIX . "two_column")==true) 
register_sidebar(array('name'=>'Right Sidebar',
'before_widget' => '<div id="%1$s" class="box widget %2$s">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>'
));
?>