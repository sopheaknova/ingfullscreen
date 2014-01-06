<?php
/**
 * Short codes in visual editor
 * Register short code buttons and add them to the visual mode of editor
 */

// Register Buttons
function register_buttons( $buttons ) {
	array_push( $buttons, 'col' );
	array_push( $buttons, 'accordion' );
	array_push( $buttons, 'toggle' );
	array_push( $buttons, 'tabs' );
	array_push( $buttons, 'callout_box' );
	array_push( $buttons, 'list' );
	array_push( $buttons, 'horz_rule' );
	array_push( $buttons, 'btn' );
	array_push( $buttons, 'email_encoder' );
	array_push( $buttons, 'team' );
	array_push( $buttons, 'project_grid' );
	array_push( $buttons, 'gallery' );
	//array_push( $buttons, 'insert_posts' );

    return $buttons;
}

// Register TinyMCE Plugin
function add_plugins($plugin_array) {
	$js_path = SP_BASE_URL . 'library/shortcodes/tinymce/';
	$plugin_array['col'] 			= $js_path . 'sc-columns.js';
	$plugin_array['accordion']		= $js_path . 'sc-accordion.js';
	$plugin_array['toggle']			= $js_path . 'sc-toggle.js';
	$plugin_array['tabs']			= $js_path . 'sc-tabs.js';
	$plugin_array['callout_box']	= $js_path . 'sc-callout-box.js';
	$plugin_array['list']			= $js_path . 'sc-list.js';
	$plugin_array['horz_rule']		= $js_path . 'sc-hr.js';
	$plugin_array['btn']			= $js_path . 'sc-btn.js';
	$plugin_array['email_encoder']	= $js_path . 'sc-email-encoder.js';
	$plugin_array['team']			= $js_path . 'sc-team.js';
	$plugin_array['project_grid']	= $js_path . 'sc-project-grid.js';
	$plugin_array['gallery']		= $js_path . 'sc-gallery.js';
	//$plugin_array['insert_posts']	= $js_path . 'sc-insert-posts.js';
	
    return $plugin_array;
 }

// Initialization Function
function add_buttons() {

    if ( current_user_can( 'edit_posts' ) &&  current_user_can( 'edit_pages' ) ) {
	  add_filter( 'mce_external_plugins', 'add_plugins' );
      add_filter( 'mce_buttons_3', 'register_buttons' );
	}
 }
add_action( 'init', 'add_buttons' );  

require_once( SP_BASE_DIR . 'library/shortcodes/popup/ajax-team-shortcode.php');
require_once( SP_BASE_DIR . 'library/shortcodes/popup/ajax-project-grid-shortcode.php');
require_once( SP_BASE_DIR . 'library/shortcodes/popup/ajax-gallery-shortcode.php');

?>