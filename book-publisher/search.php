<?php
    /* File: search.php
     * Heyday Search Results Template
     */
    
    
function heyday_get_search_sidebar() {
    get_sidebar('search');
}

function heyday_search_intro(){
    echo "<h1 class='entry-title'>Search Results</h1>";
    
    //$search_term = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
    $search_term = get_search_query();
    $post_type = isset($_REQUEST['post_type']) ? $_REQUEST['post_type'] : '';

    if ($search_term){
        echo "<p class='intro'>You searched for <strong>$search_term</strong> </p>"; 
    } 
}

/* ----------  Post Type Description ------------ */

function heyday_display_post_type_description(){
  global $post;
  
  if ($post->post_type === 'post'){
    $label = "Blog";
  } else  if ($post->post_type === 'person'){
    $label = "Bio";
  } else {
    $post_type = get_post_type_object($post->post_type);
    $label = $post_type->labels->singular_name;
  }
  
  echo "<span class='postlabel'>" . $label . "</span>";
}

/* ----------  Post Information for Events ----------- */
 
function heyday_search_result_postinfo(){
  global $post;
  
  if ($post->post_type === 'event'){
    heyday_display_event_info();
  }
  
  if ($post->post_type === 'post'){
  	the_time('l, F j, Y');
  }
}

/* --------------  Custom Search loop ---------------- */
$search_term = get_search_query();
$post_type = isset($_REQUEST['post_type']) ? $_REQUEST['post_type'] : '';
global $loop_counter;
global $the_cat;
function heyday_search_loop(){  
  $loop_counter = 0;
	if ( have_posts() ) : while ( have_posts() ) {
	  the_post(); // the loop
    global $post;
	$type_title = $post->post_type; 
	global $last_type_title;
	    // skip past all the event posts
    if ($post->post_type === 'event'){
      continue;
    }
	if (empty($post->post_title)){
		continue;
	}
	if ($post->post_type === 'page'){  // remove pages
      continue;
    } 
	else {
		if ($last_type_title != $type_title){
			if ($type_title === 'person'){
				echo "<h2> People </h2>";
			}
			else {
				echo "<h2>" . ucwords($type_title) . "s </h2>";
				$last_type_title = $type_title;
			}
		} 
		search_show_post();
	    $loop_counter++;

	}
  } /** end of one post **/

	do_action( 'genesis_after_endwhile' );
	else : /** if no posts exist **/
	do_action( 'genesis_loop_else' );
	endif; /** end loop **/
}

function heyday_search_loop_pages(){  // add pages back at end of page
    $loop_counter = 0;
	if ( have_posts() ) : while ( have_posts() ) {
	  the_post(); // the loop
	  global $post;
	
	if ($post->post_type === 'page'){ 
	    echo "<h2> Pages</h2>";
   	 	search_show_post();
		$loop_counter++;
	}
  } /** end of one post **/
	do_action( 'genesis_after_endwhile' );
	else : /** if no posts exist **/
	do_action( 'genesis_loop_else' );
	endif; /** end loop **/
}

function search_show_post() {
	do_action( 'genesis_before_post' );
    get_template_part("post", "basic");
    do_action( 'genesis_after_post' );
}
 
function display_search_widget_with_filter(){
	get_template_part("widget", "searchfilter");
}
 
 /* ------  Page Rendering ------- */
 
    add_filter('posts_orderby', 'heyday_posttype' );

    
    add_filter('genesis_pre_get_option_site_layout','__genesis_return_full_width_content');

    add_action('genesis_before_loop', 'heyday_search_intro');
    add_action('genesis_before_loop', 'display_search_widget_with_filter', 12);

    remove_action('genesis_loop', 'genesis_do_loop');
    add_action('genesis_loop', 'heyday_search_loop');
	add_action('genesis_loop', 'heyday_search_loop_pages');

    remove_action('genesis_post_content', 'genesis_do_post_image');
    add_action('genesis_before_post_title', 'genesis_do_post_image', 5);
    add_action('genesis_before_post_title', 'heyday_display_post_type_description', 10);

    remove_action('genesis_before_post_content', 'genesis_post_info');
    add_action('genesis_before_post_content', 'heyday_search_result_postinfo');
    
	  remove_action('genesis_after_post_content', 'genesis_post_meta');
    
    remove_action('genesis_after_content', 'genesis_get_sidebar');
    //add_action('genesis_after_content', 'heyday_get_search_sidebar');
    
  genesis();
?>