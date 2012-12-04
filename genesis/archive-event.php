<?php


// Hook the sidebar and widgets about right here.

// Layout and rendering...


// http://codex.wordpress.org/Function_Reference/body_class
function hd_event_archive_body_class($classes){
  
  $classes[] = 'sidebar-content';		
  return $classes;
} 

 
 function event_listing_loop(){
    global $wp_query;
    $today = date("Y-m-d");

    $cf = $wp_query->query_vars;
        $meta_query = array(
        'key' => tl_utilities::make_field_name('event_date'),
        'value' => $today,
        'compare' => ">=",
        'type' => 'DATE'
    );
    
	$args = array(
        'order' =>'ASC',
        'orderby'=>'meta_value',
        'posts_per_page'=>-1,
        'nopaging'=> true,
        'meta_key' => tl_utilities::make_field_name('event_date'),
        'meta_compare' => '>=',
        'meta_value' => $today,
        //'meta_query' => $meta_query,
        'post_status' => 'publish'
    );
    $query_args = wp_parse_args($args, $cf);
    genesis_custom_loop($query_args);
}


 
/* ------  Build Page from Actions ------- */

add_filter('genesis_pre_get_option_site_layout','heyday_full_width');

remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'event_listing_loop');

//remove_filter('body_class', 'genesis_layout_body_classes');
//add_filter('body_class', 'hd_event_archive_body_class', 40);

remove_action('genesis_post_content', 'genesis_do_post_image');
add_action('genesis_before_post_title', 'genesis_do_post_image');

remove_action('genesis_before_post_content', 'genesis_post_info');
add_action('genesis_before_post_content', 'heyday_display_event_info');

remove_action('genesis_post_content', 'genesis_do_post_content');
add_action('genesis_post_content', 'heyday_full_content');

remove_action('genesis_after_post_content', 'genesis_post_meta');



genesis();


?>
