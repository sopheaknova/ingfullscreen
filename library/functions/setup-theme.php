<?php

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 500;
	
/* ---------------------------------------------------------------------- */
/*	Setup wordpress theme support
/* ---------------------------------------------------------------------- */
	
add_action( 'after_setup_theme', 'sp_theme_setup' );
if(!function_exists('sp_theme_setup'))
{
	function sp_theme_setup(){
		
		// Makes theme available for translation.
		load_theme_textdomain( SP_TEXT_DOMAIN, get_template_directory() . '/languages' );
		
		// Add visual editor stylesheet support
		add_editor_style( SP_ASSETS_THEME . 'css/editor-style.css');
	
		// Adds RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );
	
		// Add post formats
		add_theme_support( 'post-formats', array('video', 'gallery'));
	
		// Add navigation menus
		register_nav_menus( array(
			'primary'	=> __( 'Main Navigation', SP_TEXT_DOMAIN )
			//'footer'  => __( 'Footer Navigation', SP_TEXT_DOMAIN )
		) );
	
		// Add suport for post thumbnails and set default sizes
		add_theme_support( 'post-thumbnails' );
		
		add_image_size('project-thumb', 280, 190, true); // project thumbnails
		add_image_size('supersized-thumb', 200, 150, true); // project thumbnails
		add_image_size('page-featured-image', 600, 450, true ); // page and post thumbnails
		
	}

}	

/* ---------------------------------------------------------------------- */
/*	Register CSS and JS
/* ---------------------------------------------------------------------- */
if(!function_exists('sp_print_scripts_styles'))
{
add_action('wp_enqueue_scripts', 'sp_print_scripts_styles'); //print Script and CSS

	function sp_print_scripts_styles() {
		
		if(!is_admin()){
			//CSS
			wp_enqueue_style('gfont-opensans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,700,700italic', false, '1');
			wp_enqueue_style('sp-theme-styles', SP_BASE_URL . 'style.css', false, '1');
			wp_enqueue_style('reset', SP_ASSETS_THEME . 'css/reset.css', false, '1');
			wp_enqueue_style('base', SP_ASSETS_THEME . 'css/editor-style.css', false, '1');
			wp_enqueue_style('supersized', SP_ASSETS_THEME . 'css/supersized.css', false, '1');
			wp_enqueue_style('supersized-shutter', SP_ASSETS_THEME . 'css/supersized.shutter.css', false, '1');
			
			if ( !WP_PRETTY_PHOTO_PLUGIN_ACTIVE ) {
				wp_enqueue_style('pretty_photo', SP_ASSETS_THEME . 'js/prettyPhoto/css/prettyPhoto.css', false, '3.1.3');
			}
			wp_enqueue_style('flexslider', SP_ASSETS_THEME . 'css/flexslider.css', false, '1');
			wp_enqueue_style('layout', SP_ASSETS_THEME . 'css/layout.css', false, '1');
			wp_enqueue_style('responsive', SP_ASSETS_THEME . 'css/responsive.css', false, '1');
			
			//JS
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'hoverIntent',    SP_ASSETS_THEME . 'js/jquery.hoverintent.min.js', array('jquery'), null, true );
			wp_enqueue_script( 'responsive-nav',    SP_ASSETS_THEME . 'js/responsive-nav.min.js', array('jquery'), null, true );

			wp_enqueue_script( 'supersized', SP_ASSETS_THEME . 'js/supersized.3.2.7.min.js', array('jquery'), null, false );
			wp_enqueue_script( 'supersized-shutter', SP_ASSETS_THEME . 'js/supersized.shutter.js', array('jquery'), null, false );
			if( !WP_PRETTY_PHOTO_PLUGIN_ACTIVE ) {
				wp_enqueue_script('pretty_photo_lib', SP_ASSETS_THEME . "js/prettyPhoto/js/jquery.prettyPhoto.js", array('jquery'), '3.1.3', true);
				wp_enqueue_script('custom_pretty_photo', SP_ASSETS_THEME . "js/prettyPhoto/custom_params.js", array('pretty_photo_lib'), '3.1.3', true);
			}
			if ( is_singular() ) {
				wp_enqueue_script( "comment-reply");
			}
			wp_enqueue_script( 'fitvideos',    SP_ASSETS_THEME . 'js/jquery.fitvids.js', array('jquery'), null, true );
			wp_enqueue_script( 'js-flexslider', SP_ASSETS_THEME . 'js/jquery.flexslider.js', array('jquery'), null, true );
			wp_enqueue_script( 'easing', SP_ASSETS_THEME . 'js/jquery.easing.min.js', array('jquery'), null, true );
			wp_enqueue_script( 'custom-scripts',    SP_ASSETS_THEME . 'js/custom.js', array('jquery'), null, true );

			
			
		}
	
	}
}

/* ---------------------------------------------------------------------- */
/*	Add ie conditional html5 shim to header
/* ---------------------------------------------------------------------- */
function add_ie_support_html5_css3 () {
	global $is_IE;
	if ($is_IE) {
   		echo '<!--[if lt IE 9]>';
    	echo '<script src="' . SP_ASSETS_THEME . 'js/html5.js"></script>';
    	echo '<script src="' . SP_ASSETS_THEME . 'js/selectivizr-min.js"></script>';
    	echo '<script src="' . SP_ASSETS_THEME . 'js/respond.js"></script>';
    	echo '<link rel="stylesheet" type="text/css" href="' . SP_ASSETS_THEME . 'css/ie.css" />';
    	echo '<![endif]-->';
    }	
}
add_action('wp_head', 'add_ie_support_html5_css3');


/* ---------------------------------------------------------------------- */
/*	Visual editor improvment
/* ---------------------------------------------------------------------- */

if ( is_admin() ) {
	add_filter( 'mce_buttons', 'sp_add_buttons_row1' );
	add_filter( 'mce_buttons_2', 'sp_add_buttons_row2' );
}
	
/*
* Add buttons to visual editor first row
*
* $buttons = ARRAY [default WordPress visual editor buttons array]
*/
if ( ! function_exists( 'sp_add_buttons_row1' ) ) {
	function sp_add_buttons_row1( $buttons ) {
		//inserting buttons after "italic" button
		$pos = array_search( 'italic', $buttons, true );
		if ( $pos != false ) {
			$add = array_slice( $buttons, 0, $pos + 1 );
			$add[] = 'underline';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}

		//inserting buttons after "justifyright" button
		$pos = array_search( 'justifyright', $buttons, true );
		if ( $pos != false ) {
			$add = array_slice( $buttons, 0, $pos + 1 );
			$add[] = 'justifyfull';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}
		
		return $buttons;
	}
} // /sp_add_buttons_row1

/*
* Add buttons to visual editor second row
*
* $buttons = ARRAY [default WordPress visual editor buttons array]
*/
if ( ! function_exists( 'sp_add_buttons_row2' ) ) {
	function sp_add_buttons_row2( $buttons ) {
		//inserting buttons before "underline" button
		$pos = array_search( 'underline', $buttons, true );
		if ( $pos != false ) {
			$add = array_slice( $buttons, 0, $pos );
			$add[] = 'removeformat';
			$add[] = '|';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}

		//remove "justify full" button from second row
		$pos = array_search( 'justifyfull', $buttons, true );
		if ( $pos != false ) {
			unset( $buttons[$pos] );
			$add = array_slice( $buttons, 0, $pos + 1 );
			$add[] = '|';
			$add[] = 'sub';
			$add[] = 'sup';
			$add[] = '|';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}

		return $buttons;
	}
} // sp_add_buttons_row2

/* ---------------------------------------------------------------------- */
/*	Customizable login screen and WordPress admin area
/* ---------------------------------------------------------------------- */

// Custom logo login
add_action('login_head', 'sp_custom_login_logo');
function sp_custom_login_logo() {
    echo '<style type="text/css">
		body.login{ background-color:#ffffff; }
        .login h1 a { background-image:url('.SP_ASSETS_THEME.'images/logo-admin.png) !important; width:191px; height:121px; background-size: auto auto !important;}
    </style>';
}

// Remove wordpress link on admin login logo
add_filter('login_headerurl', 'sp_remove_link_on_admin_login_info');
function sp_remove_link_on_admin_login_info() {
     return  get_bloginfo('url');
}

// Change login logo title
add_filter('login_headertitle', 'sp_change_loging_logo_title');
function sp_change_loging_logo_title(){
	return 'Go to '.get_bloginfo('name').' Homepage';
}

//	Remove logo and other items in Admin menu bar
add_action( 'wp_before_admin_bar_render', 'sp_remove_admin_bar_links' );
function sp_remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('wp-logo');
}

//  Remove wordpress version generation
add_filter('the_generator', 'sp_remove_version_info');
function sp_remove_version_info() {
     return '';
}

//  Clean up wp_head()
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'start_post_rel_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// Customising footer text
add_filter('admin_footer_text', 'sp_modify_footer_admin');
function sp_modify_footer_admin () {  
  echo 'Created by <a href="http://www.novacambodia.com" target="_blank">novadesign</a>. Powered by <a href="http://www.wordpress.org" target="_blank">WordPress</a>';  
} 

//  Set favicons for backend code
add_action( 'admin_head', 'sp_adminfavicon' );
function sp_adminfavicon() {
echo '<link rel="icon" type="image/x-icon" href="'.SP_BASE_URL.'favicon.ico" />';
}