<?php get_header(); ?>

<?php genesis_before_content_sidebar_wrap(); ?>
<div id="content-sidebar-wrap">

		<div id="featured-top">
			<div class="featured-top-left">
				<?php if (!dynamic_sidebar('Featured Top Left')) : ?>
					<div class="widget">
						<h4><?php _e("Featured Top Left", 'genesis'); ?></h4>
						<div class="wrap">
							<p><?php _e("This is a widgeted area which is called Featured Top Left. It is using the Genesis - Featured Posts widget to display what you see on the Rockstar child theme demo site. To get started, log into your WordPress dashboard, and then go to the Appearance > Widgets screen. There you can drag the Genesis - Featured Posts widget into the Featured Top Left widget area on the right hand side. To get the image to display, simply upload an image through the media uploader on the edit page screen and publish your page. The Featured Posts widget will know to display the post image as long as you select that option in the widget interface.", 'genesis'); ?></p>
						</div><!-- end .wrap -->
					</div><!-- end .widget -->
				<?php endif; ?>
			</div><!-- end .featured-top-left -->
			<div class="featured-top-right">
				<?php if (!dynamic_sidebar('Featured Top Right')) : ?>
					<div class="widget">
						<h4><?php _e("Featured Top Right", 'genesis'); ?></h4>
						<div class="wrap">
							<p><?php _e("This is a widgeted area which is called Featured Top Right. It is using the Genesis - Featured Posts widget to display what you see on the Rockstar child theme demo site. To get started, log into your WordPress dashboard, and then go to the Appearance > Widgets screen. There you can drag the Genesis - Featured Posts widget into the Featured Top Right widget area on the right hand side. To get the image to display, simply upload an image through the media uploader on the edit page screen and publish your page. The Featured Posts widget will know to display the post image as long as you select that option in the widget interface.", 'genesis'); ?></p>
						</div><!-- end .wrap -->
					</div><!-- end .widget -->
				<?php endif; ?>
			</div><!-- end .featured-top-right -->
		</div><!-- end #featured-top -->	
		
	<?php genesis_before_content(); ?>
	<div id="content" class="hfeed">
		
		<div id="featured-bottom">
			<?php if (!dynamic_sidebar('Featured Bottom')) : ?>
				<div class="widget">
					<h4>2012 East Oakland Project Blogs</h4>
					<div class="wrap">
                        <p>
                        <?php
$args = array(
'meta_key' => 'voices_contributor',
'meta_value' => '2012',
'meta_compare' => '=',
'orderby' => 'login',
'order' => 'ASC',
'count_total' => true,
'fields' => 'all',
 );
 
$authors = get_users($args);
if ($authors){
	foreach ($authors as $author){
		$curauth = get_userdata($author->ID);
		if($curauth->user_login !== 'admin' ) {
			$user_link = get_author_posts_url($curauth->ID);
			$avatar = 'default';
		}
	?>
	<div class="author_home">
	<?php 

if(userphoto_exists($curauth)) userphoto_thumbnail($curauth); else echo get_avatar($curauth->ID, 40); ?>
	<div class="name"><a href="<?php echo $user_link?>"><?php echo $curauth->display_name; ?></a>
	<span class="bio"><?php echo $curauth->user_description ?></div>
	</div>
	<?php
	
	}
}

?>
</p>
					</div><!-- end .wrap -->
				</div><!-- end .widget -->
			<?php endif; ?>
		</div><!-- end #featured-bottom -->	
		
	</div><!-- end #content -->
	<?php genesis_after_content(); ?>

</div><!-- end #content-sidebar-wrap -->
<?php genesis_after_content_sidebar_wrap(); ?>

<?php get_footer(); ?>