<?php /* 
Template Name: Microscope
*/ ?> 

<?php
remove_action('genesis_loop', 'genesis_do_loop');
// Remove post meta

/**
 * Example function that replaces the default loop
 * with a custom loop querying 'PostType' CPT.
*/
add_action('genesis_loop', 'microscope_custom_loop');
function microscope_custom_loop() {
global $paged;
    $args = array('post_type' => 'microscope');
    // Accepts WP_Query args 
    // (http://codex.wordpress.org/Class_Reference/WP_Query)
    genesis_custom_loop( $args );
 
}
?>

<?php genesis(); ?>