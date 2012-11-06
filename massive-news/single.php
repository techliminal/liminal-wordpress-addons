<?php get_header(); ?>

<div class="container_16 main_wrap">
	<div id="content_left_wrapper">
		<div class="content_left_single">
			<div class="box">
				<h2><a href="<?php echo get_option('home'); ?>/">Home</a> &raquo;  <?php the_category(' &raquo;'); ?>   &raquo; Currently Reading:</h2> 
				
				<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				
				<div class="block">
					<div class="article first_main_article">
						<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
					
						<div class="meta">
							<span class="time"><?php the_time('F j, Y'); ?></span>
							<span class="categories"><?php the_category(', ') ?></span>
							<span class="discuss"><?php comments_number('No Comments', '1 Comment', '% Comments'); ?></span>
							
							<?php if (is_user_logged_in()) : ?>
							<span class="editlink"><?php edit_post_link('Edit This Post', '', ''); ?></span>
							<?php endif; ?>
						</div>
						
						<?php echo get_video($post->ID); ?>
						
						<?php if (get_option(THEME_PREFIX . "post_thumbnails_single")) { ?>
							<a href="<?php the_permalink() ?>" class="image"><?php the_post_thumbnail(); ?></a>
						<?php } ?>
						
						<?php the_content(''); ?>
					</div>  
				</div>
				
				<?php endwhile; ?>
				<?php else : ?>
				<?php endif; ?>
			</div>
			
			<?php comments_template(); ?>
			
			<div class="box">
				<h2>Comment on this Article:</h2>
				<div class="block widget_block">
					<?php include (TEMPLATEPATH . '/comments-form.php'); ?>
				</div>
			</div>			
			
		</div>
	</div>
	
	<div id="content_right_wrapper">
		<?php get_sidebar(); ?>
    </div>
    
    <div class="clear"></div>
</div>

<?php get_footer(); ?>