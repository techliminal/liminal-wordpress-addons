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

function heyday_search_loop(){  
	$search_term = get_search_query();
	
	$post_type = isset($_REQUEST['post_type']) ? $_REQUEST['post_type'] : '';
	global $loop_counter;
	global $the_cat;
	
	global $wp_query;
	
	$original_query = $wp_query->query_vars;
	
	$got_results = false;
	
	// get the books
	if ($post_type == 'book' || $post_type == ''){
		$heyday_query = $wp_query->query_vars;
		$args = array(
					'order' =>'ASC',
					'orderby'=>'title',
					'post_type' =>'book'
		 );
		 $query_args = wp_parse_args($args, $heyday_query);
		 $books = array();
		 $book_ids = array();
	
			$books_1 = get_posts($query_args);
			foreach($books_1 as $book){
				$books[]= $book;
				$book_ids[] = $book->ID;
			}
			
			$tag = get_term_by('name', $query_args['s'], 'post_tag');
			if ($tag){
				$query_args = wp_parse_args(array('tag_id' => $tag->term_id, 'posts_not_in'=>$book_ids), $query_args);
			
				unset ($query_args['s']);		
				$books_2 = get_posts($query_args);
				foreach($books_2 as $book){
					$books[] = $book;
				}
			}
						
			usort($books, 'heyday_compare_post_titles');

			if (count($books)){
				echo '<h2>Books</h2>';
				$got_results = true;
			}
			foreach ($books as $book){	
				global $post;
				$post = $book;
				search_show_post(); 
				echo '<div class="clear"></div>'; 
			}
	}

	if ($post_type == 'person' || $post_type == ''){	
		// get the authors
		$args = array(
			'order' =>'ASC',
			'orderby'=>'title',
			'post_type' =>'person'
		 );
		 $query_args = wp_parse_args($args, $original_query);
	
		 $people  = new WP_Query($query_args);
	
		 if ($people->have_posts() ) {
			 echo '<h2>Bios</h2>';
			 $got_results = true;

			 while ( $people->have_posts() ){
					$people->the_post();
					search_show_post();  
			 } 
		 }
	}
	
	if ($post_type == 'post' || $post_type == ''){
		// get the blog content
		$heyday_query = $wp_query->query_vars;
		$args = array(
					'order' =>'ASC',
					'orderby'=>'title',
					'post_type' => array('post')
		 );
	
			// get the blog posts
		 $query_args = wp_parse_args($args, $heyday_query);
	
		 $blogs_1 = new WP_Query($query_args);
		 if ($blogs_1->have_posts() ) {
			 echo '<h2>From the Blog</h2>';
			 $got_results = true;
			 
			 while ( $blogs_1->have_posts() ){
					$blogs_1->the_post();
					global $post;
					search_show_post();  
			 } 
		 }
	}
	
	if (!$got_results){
		echo "Sorry, we couldn't find anything matching your search terms";
	}
}

//function heyday_search_loop_pages(){  // add pages back at end of page
//    $loop_counter = 0;
//	if ( have_posts() ) : while ( have_posts() ) {
//	  the_post(); // the loop
//	  global $post;
//	
//	if ($post->post_type === 'page'){ 
//	    echo "<h2> Pages</h2>";
//   	 	search_show_post();
//		$loop_counter++;
//	}
//  } /** end of one post **/
//	do_action( 'genesis_after_endwhile' );
//	else : /** if no posts exist **/
//	do_action( 'genesis_loop_else' );
//	endif; /** end loop **/
//}

function search_show_post() {
	do_action( 'genesis_before_post' );
    get_template_part("post", "basic");
    do_action( 'genesis_after_post' );
}
 
function display_search_widget_with_filter(){
	get_template_part("widget", "searchfilter");
}
 
 /* ------  Page Rendering ------- */
 
    //add_filter('posts_orderby', 'heyday_posttype' );

    
    add_filter('genesis_pre_get_option_site_layout','__genesis_return_full_width_content');

    add_action('genesis_before_loop', 'heyday_search_intro');
    add_action('genesis_before_loop', 'display_search_widget_with_filter', 12);

    remove_action('genesis_loop', 'genesis_do_loop');
    add_action('genesis_loop', 'heyday_search_loop');
	//add_action('genesis_loop', 'heyday_search_loop_pages');

    remove_action('genesis_post_content', 'genesis_do_post_image');
    add_action('genesis_before_post_title', 'genesis_do_post_image', 5);
    //add_action('genesis_before_post_title', 'heyday_display_post_type_description', 10);

    remove_action('genesis_before_post_content', 'genesis_post_info');
    add_action('genesis_before_post_content', 'heyday_search_result_postinfo');
    
	  remove_action('genesis_after_post_content', 'genesis_post_meta');
    
    remove_action('genesis_after_content', 'genesis_get_sidebar');
    //add_action('genesis_after_content', 'heyday_get_search_sidebar');
    
  genesis();
?>