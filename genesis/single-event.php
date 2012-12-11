<?php

function heyday_event_post_image(){
  $img = genesis_get_image( array( 'format' => 'html', 'size' => 'thumbnail', 'attr' => array( 'class' => 'alignleft post-image' ) ) );  
  
  $image = <<<EOI
      $img
EOI;
  echo $image;
  
}

/* ----------------  Page Rendering ----------------- */

//add_action('genesis_before_post_content', 'heyday_event_post_image');
remove_action('genesis_before_post_content', 'genesis_post_info');
add_action('genesis_before_post_content', 'heyday_display_event_info');
add_action('genesis_after_post_content', 'heyday_author_information');

remove_action('genesis_after_post_content', 'genesis_post_meta');

add_filter('genesis_pre_get_option_site_layout','heyday_full_width');

genesis();

// Maybe necessary?
//remove_filter('genesis_pre_get_option_site_layout','heyday_set_layout');

?>
