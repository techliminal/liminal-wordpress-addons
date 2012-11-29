<?php

// Make sure you do a wp_reset_query before you call this if you want to do it after a loop.

$post = get_queried_object();
$category = get_post_meta($post->ID, 'attach_category', true);

global $wp_query;

$bc = get_term_by('slug', $category, 'category');

$children = get_term_children($bc->term_id, 'category');

foreach($children as $cat){
		$term = get_term_by( 'id', $cat, 'category');
	 
		echo '<div class="post taxonomy book_category">';
		echo '<h2 class="entry_title">';
		echo '<a href="' . get_term_link( $term) . '">'. $term->name . '</a>';
		echo '</h2>';
		echo '<div class="entry_content">';
		echo $term->description;
		echo '</div></div>';
}
