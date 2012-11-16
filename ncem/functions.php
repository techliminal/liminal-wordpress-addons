<?php
/** Start the engine */
require_once( TEMPLATEPATH . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'Minimum Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/themes/minimum' );

$content_width = apply_filters( 'content_width', 660, 490, 760 );

/** Add new image sizes */
add_image_size( 'featured', 500, 250, TRUE );
add_image_size( 'portfolio', 160, 100, TRUE );


/** Add suport for custom background */
/* This uses the Custom Field called Background, and takes the URL value to create the background image 
*/
add_custom_background();

function ncem_background_image(){
	$page = get_queried_object();
	$background_url = get_post_meta($page->ID, 'background', true);
	if ( 'none' == $background_url || '' == $background_url )
	return false;
?>
<style type="text/css">body {background: url(<?php echo $background_url ; ?>);}</style>
<?php
}

add_action( 'wp_head', 'ncem_background_image' );

/** Add support for custom header */
add_theme_support( 'genesis-custom-header', array( 'width' => 1024, 'height' => 94, 'textcolor' => '444', 'admin_header_callback' => 'minimum_admin_style', 'background' => '#7f7f7f' ) );

/**
 * Register a custom admin callback to display the custom header preview with the
 * same style as is shown on the front end.
 *
 */
function minimum_admin_style() {

	$headimg = sprintf( '.appearance_page_custom-header #headimg { background: url(%s) no-repeat; font-family: Oswald, arial, serif; min-height: %spx; }', get_header_image(), HEADER_IMAGE_HEIGHT );
	$h1 = sprintf( '#headimg h1, #headimg h1 a { color: #%s; font-size: 48px; font-weight: normal; line-height: 48px; margin: 25px 0 0; text-decoration: none; }', esc_html( get_header_textcolor() ) );
	$desc = sprintf( '#headimg #desc { color: #%s; display: none; }', esc_html( get_header_textcolor() ) );

	printf( '<style type="text/css">%1$s %2$s %3$s background: #7f7f7f;</style>', $headimg, $h1, $desc );

}

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );

/** Register widget areas */
genesis_register_sidebar( array(
	'id'			=> 'welcome',
	'name'			=> __( 'Home Header Image', 'minimum' ),
	'description'	=> __( 'This is where to put images and videos.', 'minimum' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'featured',
	'name'			=> __( 'Home Middle', 'minimum' ),
	'description'	=> __( 'This is where to put main content.', 'minimum' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'portfolio',
	'name'			=> __( 'Home Left', 'minimum' ),
	'description'	=> __( 'This is where to put other content', 'minimum' ),
) );