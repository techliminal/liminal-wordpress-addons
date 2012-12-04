<?php /* 
Template Name: Attach Category Template
*/


add_action('genesis_after_loop', 'tl_attach_category');

/* if using this with Genesis, hook this after the loop.  
   The name of the custom field can be hidden, if you provide a metabox for choosing it.
   The simplest thing is to leave it visible and just use the custom field selector.
 */
 
function tl_attach_category(){
	global $post;
	
	$attach_option = get_post_meta($post->ID, 'categories', true);
	
        // You might want to do different things for different categories
	if ($attach_option){ 

			$args=array(
			'cat' => $attach_option,
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => 10,
			'caller_get_posts'=> 1
			);	

  		$my_query = null;
  		global $more; $more = 0;
		$my_query = new WP_Query($args);
		if( $my_query->have_posts() ) {
			while($my_query->have_posts()): $my_query->the_post();
				?>
				<div class="headline_area">
					<h2 class="entry_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				</div>
				<div class="entry-content">
				<?php

				//the_excerpt();
				$more = 0;
				the_content("Read More");
						
				echo "</div>";
			
			endwhile;
  		}
                wp_reset_query();
  	}
}

genesis();