<?php
/*
*****************************************************
* Gallery custom post
*
* CONTENT:
* - 1) Actions and filters
* - 2) Creating a custom post
* - 3) Custom post list in admin
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Registering CP
		add_action( 'init', 'sp_gallery_cp_init' );
		//CP list table columns
		add_action( 'manage_posts_custom_column', 'sp_gallery_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-sp_gallery_columns', 'sp_gallery_cp_columns' );




/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'sp_gallery_cp_init' ) ) {
		function sp_gallery_cp_init() {
			global $cp_menu_position;

			/*if ( $smof_data['sp_newsticker_revisions'] )
				$supports[] = 'revisions';*/
			$labels = array(
				'name'               => __( 'Galleries', 'sptheme_admin' ),
				'singular_name'      => __( 'Gallery', 'sptheme_admin' ),
				'add_new'            => __( 'Add New Album', 'sptheme_admin' ),
				'all_items'          => __( 'All Galleries', 'sptheme_admin' ),
				'add_new_item'       => __( 'Add New Album', 'sptheme_admin' ),
				'new_item'           => __( 'Add New Album', 'sptheme_admin' ),
				'edit_item'          => __( 'Edit Album', 'sptheme_admin' ),
				'view_item'          => __( 'View Album', 'sptheme_admin' ),
				'search_items'       => __( 'Search Album', 'sptheme_admin' ),
				'not_found'          => __( 'No Album found', 'sptheme_admin' ),
				'not_found_in_trash' => __( 'No Album found in trash', 'sptheme_admin' ),
				'parent_item_colon'  => __( 'Parent Album', 'sptheme_admin' ),
			);	

			$role     = 'post'; // page
			$slug     = 'gallery';
			$supports = array('title', 'thumbnail'); // 'title', 'editor', 'thumbnail'

			$args = array(
				'labels' 				=> $labels,
				'rewrite'               => array( 'slug' => $slug ),
				'menu_position'         => $cp_menu_position['sp_gallery'],
				'menu_icon'           => SP_ASSETS_ADMIN . 'images/icon-camera.png',
				'supports'              => $supports,
				'capability_type'     	=> $role,
				'query_var'           	=> true,
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_nav_menus'	    => true,
				'publicly_queryable'	=> true,
				'exclude_from_search'   => false,
				'has_archive'			=> false,
				'can_export'			=> true
			);
			register_post_type( 'sp_gallery' , $args );
		}
	} 


/*
*****************************************************
*      3) CUSTOM POST LIST IN ADMIN
*****************************************************
*/
	/*
	* Registration of the table columns
	*
	* $Cols = ARRAY [array of columns]
	*/
	if ( ! function_exists( 'sp_gallery_cp_columns' ) ) {
		function sp_gallery_cp_columns( $columns ) {
			
			$columns = array(
				'cb'                   	=> '<input type="checkbox" />',
				'thumbnail'            	=> __( 'Thumbnail', 'sptheme_admin' ),
				'title'                	=> __( 'Album Name', 'sptheme_admin' ),
				'date' 					=> __( 'Date', 'sptheme_admin' ),
				'author' 				=> __( 'Created By', 'sptheme_admin' )
			);

			return $columns;
		}
	} // /gallery_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'sp_gallery_cp_custom_column' ) ) {
		function sp_gallery_cp_custom_column( $column ) {
			global $post;
			
			switch ( $column ) {
				case "thumbnail":

					$albums = rwmb_meta( 'sp_gallery_album', $args = array('type' => 'plupload_image', 'size' => 'thumbnail') ); 
					$albums_count = 0;
					$cover_image = '';
					$size = explode( 'x', SP_ADMIN_LIST_THUMB );

					foreach ( $albums as $image ){
						if ($albums_count < 1) {
							$cover_image .= '<img src="' . $image["url"] . '" width="' . $size[0] . '" height="' . $size[1] . '" />';
						}	

						$albums_count++;
					}
					
					echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . $cover_image . '</a>';

				break;
				
				default:
				break;
			}
		}
	} // /sp_gallery_cp_custom_column

	
	