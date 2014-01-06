<?php
 
/*
 *  Basic Theme Settings
 */
 
$shortname = get_template(); 

//WP 3.4+ only
$themeData     = wp_get_theme( $shortname );
$themeName     = $themeData->Name;
$themeName = str_replace( ' ', '', $themeName );

//Basic constants	
define( 'SP_THEME_NAME', 'ING' );
define( 'SP_TEXT_DOMAIN', strtolower($themeName) );
define( 'SP_SCRIPTS_VERSION', '20131007' ); // yyyymmdd
define( 'SP_ADMIN_LIST_THUMB', '64x64' ); //thumbnail size (width x height) on post/

define( 'SP_BASE_DIR',   get_template_directory() . '/' );
define( 'SP_BASE_URL',     get_template_directory_uri() . '/' );
define( 'SP_ASSETS_THEME', get_template_directory_uri() . '/assets/' );
define( 'SP_ASSETS_ADMIN', get_template_directory_uri() . '/library/assets/' );

/* Custom post WordPress admin menu position - 30, 33, 39, 42, 45, 48 */
if ( ! isset( $cp_menu_position ) )
	$cp_menu_position = array(
			'sp_project'		=> 30,
			'sp_gallery'		=> 33,
		);

/*
 *  load some backend functions
 */
/* theme setup */
require_once( SP_BASE_DIR . 'library/functions/setup-theme.php');
require_once( SP_BASE_DIR . 'library/functions/theme-functions.php');
require_once( SP_BASE_DIR . 'library/functions/aq_resizer.php');

/* Shortcode */
require_once( SP_BASE_DIR . 'library/shortcodes/shortcodes.php');
require_once( SP_BASE_DIR . 'library/shortcodes/visual-shortcodes.php' );

/* Register and load widgets */
require_once( SP_BASE_DIR . 'library/widgets/widgets.php');


/* meta boxes */
require_once( SP_BASE_DIR . 'library/meta-box/meta-box.php'); 
require_once( SP_BASE_DIR . 'library/meta-box/meta-options.php'); 

/* Custom post type */
require_once( SP_BASE_DIR . 'library/custom-posts/custom-posts.php');

/* Admin opitons */
require_once( SP_BASE_DIR . 'library/admin/index.php');
 
