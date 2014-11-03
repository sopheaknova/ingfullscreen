<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */

/********************* META BOX DEFINITIONS ***********************/

$prefix = 'sp_';

global $meta_boxes, $sidebars;

$meta_boxes = array();
		
/* ---------------------------------------------------------------------- */
/*	General for Page and Post
/* ---------------------------------------------------------------------- */

$meta_boxes[] = array(
	'id'       => 'layout-settings',
	'title'    => __('Layout Settings', 'sptheme_admin'),
	'pages'    => array('page', 'post', 'sp_project'),
	'context'  => 'normal',
	'priority' => 'high',
	'fields'   => array(
		/*array(
			'name' => __('Disable content box', 'sptheme_admin'),
			'id'   => $prefix . 'diable_content_box',
			'type' => 'checkbox',
			'std'  => 0,
			'desc' => __('Check to disable content box on this page/post', 'sptheme_admin'),
		),*/
		
		array(
			'name'     => __('Page Layout', 'sptheme_admin'),
			'id'       => $prefix . 'page_layout',
			'type'     => 'radio_image',
			'options'  => array(
				'1col' => '<img src="' . SP_ASSETS_ADMIN . 'images/meta-box/1col.png" alt="' . __('Fullwidth - No sidebar', 'sptheme_admin') . '" title="' . __('Fullwidth - No sidebar"', 'sptheme_admin') . ' />',
				'2cl'  => '<img src="' . SP_ASSETS_ADMIN . 'images/meta-box/2cl.png" alt="' . __('Sidebar on the left', 'sptheme_admin') . '" title="' . __('Sidebar on the left', 'sptheme_admin') . '" />',
				/*'2cr'  => '<img src="' . SP_ASSETS_ADMIN . 'images/meta-box/2cr.png" alt="' . __('Sidebar on the right', 'sptheme_admin') . '" title="' . __('Sidebar on the right', 'sptheme_admin') . '" />',*/
			),
			'std'  => '2cl',
			'desc' => __('select the layout structure for this page.', 'sptheme_admin')
		),
		array(
			'name' => __('Sidebar', 'sptheme_admin'),
			'id'   => $prefix . 'selected_sidebar',
			'type' => 'sidebar',
			'std'  => '',
			'desc' => 'Choose a sidebar to display'
		)
	)
);

$meta_boxes[] = array(
	'id'       => 'page-background-image',
	'title'    => __('Background images', 'sptheme_admin'),
	'pages'    => array('page', 'post', 'sp_project'),
	'context'  => 'normal',
	'priority' => 'high',
	'fields'   => array(
		array(
			'name' => __('Upload background page', 'sptheme_admin'),
			'id'   => $prefix . 'background_page',
			'type' => 'image_advanced',
			'max_file_uploads' => 20,
			'std'  => '',
			'desc' => 'Min size 1280px by 800px'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	POST FORMAT: Video
/* ---------------------------------------------------------------------- */

$meta_boxes[] = array(
	'id'       => 'post-video-settings',
	'title'    => __('External Video Settings', 'sptheme_admin'),
	'pages'    => array('post'),
	'context'  => 'normal',
	'priority' => 'high',
	'fields'   => array(
		array(
			'name' => __('Video URL', 'sptheme_admin'),
			'id'   => $prefix . 'video_id',
			'type' => 'text',
			'std'  => '',
			'desc' => __('ex: http://www.youtube.com/watch?v=sdUUx5FdySs', 'sptheme_admin'),
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	GALLEY POST TYPE
/* ---------------------------------------------------------------------- */
$meta_boxes[] = array(
	'id'       => 'album-setting',
	'title'    => __('Album setting', 'sptheme_admin'),
	'pages'    => array('sp_gallery'),
	'context'  => 'normal',
	'priority' => 'high',
	'fields'   => array(
		array(
			'name' => __('Upload photos', 'sptheme_admin'),
			'id'   => $prefix . 'gallery_album',
			'type' => 'image_advanced',
			'max_file_uploads' => 50,
			'std'  => '',
			'desc' => 'Max size 1024px by 768px'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	PROJECT POST TYPE
/* ---------------------------------------------------------------------- */
$meta_boxes[] = array(
	'id'       => 'project-settings',
	'title'    => __('Project settings', 'sptheme_admin'),
	'pages'    => array('sp_project'),
	'context'  => 'normal',
	'priority' => 'high',
	'fields'   => array(
		array(
			'name' => __('Multiple images slideshow', 'sptheme_admin'),
			'id'   => $prefix . 'project_img_type',
			'type' => 'checkbox',
			'std'  => 0,
			'desc' => __('Check to upload multiple photos for this project', 'sptheme_admin'),
		),
		array(
			'name' => __('Upload background page', 'sptheme_admin'),
			'id'   => $prefix . 'project_gallery',
			'type' => 'image_advanced',
			'max_file_uploads' => 10,
			'std'  => '',
			'desc' => 'Min size 1280px by 800px'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	CONTACT TEMPLATE PAGE
/* ---------------------------------------------------------------------- */

$meta_boxes [] = array(
	'id'       => 'contact-settings',
	'title'  => __( 'Quick contact information', 'sptheme_admin' ),
	'pages' => array('page'),
	'fields' => array(
		
		// array(
		// 	'name' => __('Sub Title', 'sptheme_admin'),
		// 	'id'   => $prefix . 'sub_title',
		// 	'type' => 'text',
		// 	'std'  => 'More information',
		// 	'desc' => __('ex: More information', 'sptheme_admin'),
		// ),

		// array(
		// 	'name' => __('Phone', 'sptheme_admin'),
		// 	'id'   => $prefix . 'phone',
		// 	'type' => 'text',
		// 	'std'  => '(+855) 23 888 123',
		// 	'desc' => __('ex: (+855) 23 888 123', 'sptheme_admin'),
		// ),
		
		// array(
		// 	'name' => __('E-mail', 'sptheme_admin'),
		// 	'id'   => $prefix . 'email',
		// 	'type' => 'text',
		// 	'std'  => 'info@yourcompany.com',
		// 	'desc' => __('ex: info@yourcompany.com', 'sptheme_admin'),
		// ),
		array(
			'id'            => $prefix . 'direction_label',
			'name'          => __( 'Direction label', 'sptheme_admin' ),
			'type'          => 'text',
			'std'           => __( 'Get Direction', 'sptheme_admin' ),
		),
		array(
			'id'            => $prefix . 'address',
			'name'          => __( 'Address', 'sptheme_admin' ),
			'type'          => 'textarea',
			'std'           => __( 'Phnom Penh, Cambodia', 'sptheme_admin' ),
		),
		array(
			'id'            => $prefix . 'contact_map',
			'name'          => __( 'Location', 'sptheme_admin' ),
			'type'          => 'map',
			'std'           => '11.558831,104.917445,15',     // 'latitude,longitude[,zoom]' (zoom is optional)
			'style'         => 'width: 500px; height: 250px',
			'address_field' => 'address',                     // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
		),
	),
	'only_contact_page'    => array(
		'template' => array( 'template-contact-map.php', 'template-contact.php' ),
	),
);


/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function sp_register_meta_boxes()
{
	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( !class_exists( 'RW_Meta_Box' ) )
		return;

	global $meta_boxes;
	
	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) ) {
		foreach ( $meta_boxes as $meta_box ) {
			if ( isset( $meta_box['only_contact_page'] ) && ! rw_maybe_include( $meta_box['only_contact_page'] ) ) {
				continue;
			}

			new RW_Meta_Box( $meta_box );
		}
	}
}

/**
 * Check if meta boxes is included
 *
 * @return bool
 */
function rw_maybe_include( $conditions ) {
	// Include in back-end only
	if ( ! defined( 'WP_ADMIN' ) || ! WP_ADMIN ) {
		return false;
	}

	// Always include for ajax
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return true;
	}

	if ( isset( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	}
	elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	}
	else {
		$post_id = false;
	}

	$post_id = (int) $post_id;
	$post    = get_post( $post_id );

	foreach ( $conditions as $cond => $v ) {
		// Catch non-arrays too
		if ( ! is_array( $v ) ) {
			$v = array( $v );
		}

		switch ( $cond ) {
			case 'id':
				if ( in_array( $post_id, $v ) ) {
					return true;
				}
			break;
			case 'parent':
				$post_parent = $post->post_parent;
				if ( in_array( $post_parent, $v ) ) {
					return true;
				}
			break;
			case 'slug':
				$post_slug = $post->post_name;
				if ( in_array( $post_slug, $v ) ) {
					return true;
				}
			break;
			case 'template':
				$template = get_post_meta( $post_id, '_wp_page_template', true );
				if ( in_array( $template, $v ) ) {
					return true;
				}
			break;
		}
	}

	// If no condition matched
	return false;
}

// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'sp_register_meta_boxes' );
