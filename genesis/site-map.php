<?php
/* 
Template Name: Site Map
*/
/* This takes the 404 page and creates a site map page for NCEM */

/** Remove default loop **/
remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_loop', 'genesis_404' );
/**
 * This function outputs a 404 "Not Found" error message
 *
 * @since 1.6
 */
function genesis_404() { ?>

	<div class="post hentry">

		<h1 class="entry-title">Site Map</h1>
		<div class="sitemap-entry-content">

			<div class="archive-page">

				<!--<h4><?php _e( 'Pages:', 'genesis' ); ?></h4>-->
				<ul>
					<?php wp_list_pages( 'title_li=' ); ?>
				</ul>


			</div><!-- end .archive-page-->

			<div class="archive-page">

  <!-- removed content from here -->


			</div><!-- end .archive-page-->

		</div><!-- end .entry-content -->

	</div><!-- end .postclass -->

<?php
}

genesis();
