<div class="content_right">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Right Sidebar') ) : ?>
	<?php endif; ?>	
</div> <!-- content_right -->

<?php if ( get_option(THEME_PREFIX . "two_column") || is_single()) : ?>
	<!-- nothing to see here -->
<?php else : ?>
<div class="content_center">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Center Sidebar') ) : ?>
	<?php endif; ?>
</div> <!-- content_center -->
<?php endif; ?>