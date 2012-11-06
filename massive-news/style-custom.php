html, body {
background:<?php if (get_option(THEME_PREFIX . "background_color")) { ?> #<?php echo get_option(THEME_PREFIX . "background_color"); ?><?php } ?><?php if (get_option(THEME_PREFIX . "background_img")) { ?> url(<?php echo get_option(THEME_PREFIX . "background_img"); ?>) <?php echo get_option(THEME_PREFIX . "background_vert"); ?> <?php echo get_option(THEME_PREFIX . "background_horiz"); ?> <?php echo get_option(THEME_PREFIX . "background_repeat"); ?><?php if (get_option(THEME_PREFIX . "background_fixed")) { ?> fixed<?php } ?><?php } ?>;
color: <?php if (get_option(THEME_PREFIX . "content_text_color")) { ?>#<?php echo get_option(THEME_PREFIX . "content_text_color"); ?><?php } ?>;
}

a:link, a:visited, .meta a:link, .meta a:visited, .meta {
color: #<?php echo get_option(THEME_PREFIX . "content_link_color"); ?>;
}

a:hover {
color: #<?php echo get_option(THEME_PREFIX . "content_link_hover_color"); ?>;
}

#header, #footer, .header_ad {
background: #<?php echo get_option(THEME_PREFIX . "header_background_color"); ?>;
border-color: #<?php echo get_option(THEME_PREFIX . "header_border_color"); ?>;
}

//#header {
//	background:  //url(wp-content/themes/massive-news/images/header-bg.jpg);
//}

.menu li {
border-color: #<?php echo get_option(THEME_PREFIX . "header_border_color"); ?>;
}

#navigation {
background: #<?php echo get_option(THEME_PREFIX . "menu_background_color"); ?>;
}

.menu a:link, .menu a:visited {
color: #<?php echo get_option(THEME_PREFIX . "menu_text_color"); ?>;
}

.container_16 {
background: #<?php echo get_option(THEME_PREFIX . "content_wrapper_background_color"); ?>;
}

.box, .article a.image {
background: #<?php echo get_option(THEME_PREFIX . "content_background_color"); ?>;
border-color: #<?php echo get_option(THEME_PREFIX . "content_border_color"); ?>;
}

li.recent_comment, ol.commentlist li.alt, ol.commentlist li {
border-color: #<?php echo get_option(THEME_PREFIX . "content_border_color"); ?>;
}

li.recent_comment:hover {
background: #<?php echo get_option(THEME_PREFIX . "content_background_color"); ?>;
}

blockquote {
border-color: #<?php echo get_option(THEME_PREFIX . "content_border_color"); ?>;
}

.meta {
color: #<?php echo get_option(THEME_PREFIX . "content_link_color"); ?>;
border-color: #<?php echo get_option(THEME_PREFIX . "content_border_color"); ?>;
}

.box h2, .box h2 a:link, .box h2 a:visited {
color: #<?php echo get_option(THEME_PREFIX . "container_heading_text_color"); ?>;
background: #<?php echo get_option(THEME_PREFIX . "container_heading_background_color"); ?>;
}

.box h1 a:link, .box h1 a:visited {
color: #<?php echo get_option(THEME_PREFIX . "heading_link_color"); ?>;
}

.box h1 a:hover {
color: #<?php echo get_option(THEME_PREFIX . "heading_link_hover_color"); ?>;
}

.box h1 {
color: #<?php echo get_option(THEME_PREFIX . "heading_text_color"); ?>;
}

#footer, #footer p, #footer a:link, #footer a:visited {
color: #<?php echo get_option(THEME_PREFIX . "footer_text_color"); ?>;
}

<?php if (get_option(THEME_PREFIX . "fixed_width")) { ?>
.container_16 {
width: <?php echo get_option(THEME_PREFIX . "fixed_width_width"); ?>px;
margin: 0px auto;
margin-bottom: 15px;
}
<?php } ?>

<?php if (get_option(THEME_PREFIX . "minimum_width")) { ?>
.container_16 {
min-width: <?php echo get_option(THEME_PREFIX . "minimum_width"); ?>px;
}
<?php } ?>

<?php if (get_option(THEME_PREFIX . "two_column")) { ?>
#content_right_wrapper {
width: 320px;
float: left;
margin-left: -320px;
}

.content_left {
margin-right: 330px;
}

.content_right {
width: 320px;
float: left;
}
<?php } ?>