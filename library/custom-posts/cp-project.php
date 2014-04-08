<?php
/*
*****************************************************
* project custom post
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
		add_action( 'init', 'sp_project_cp_init' );
		//CP list table columns
		add_action( 'manage_posts_custom_column', 'sp_project_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-sp_project_columns', 'sp_project_cp_columns' );
		// make Order column sortable
		add_filter('manage_edit-sp_project_sortable_columns','order_column_register_sortable');




/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'sp_project_cp_init' ) ) {
		function sp_project_cp_init() {
			global $cp_menu_position;

			/*if ( $smof_data['sp_newsticker_revisions'] )
				$supports[] = 'revisions';*/
			$labels = array(
				'name'               => __( 'Projects', 'sptheme_admin' ),
				'singular_name'      => __( 'project', 'sptheme_admin' ),
				'add_new'            => __( 'Add New', 'sptheme_admin' ),
				'all_items'          => __( 'All Projects', 'sptheme_admin' ),
				'add_new_item'       => __( 'Add New project', 'sptheme_admin' ),
				'new_item'           => __( 'Add New project', 'sptheme_admin' ),
				'edit_item'          => __( 'Edit project', 'sptheme_admin' ),
				'view_item'          => __( 'View project', 'sptheme_admin' ),
				'search_items'       => __( 'Search project', 'sptheme_admin' ),
				'not_found'          => __( 'No project found', 'sptheme_admin' ),
				'not_found_in_trash' => __( 'No project found in trash', 'sptheme_admin' ),
				'parent_item_colon'  => __( 'Parent project', 'sptheme_admin' ),
			);	

			$role     = 'post'; // page
			$slug     = 'ing-project';
			$supports = array('title', 'editor', 'thumbnail', 'page-attributes'); // 'title', 'editor', 'thumbnail'

			$args = array(
				'labels' 				=> $labels,
				'rewrite'               => array( 'slug' => $slug ),
				'menu_position'         => $cp_menu_position['sp_project'],
				'menu_icon'           => SP_ASSETS_ADMIN . 'images/icon-portfolio.png',
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
			register_post_type( 'sp_project' , $args );
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
	if ( ! function_exists( 'sp_project_cp_columns' ) ) {
		function sp_project_cp_columns( $columns ) {
			
			$columns = array(
				'cb'                   	=> '<input type="checkbox" />',
				'thumbnail'            	=> __( 'Thumbnail', 'sptheme_admin' ),
				'title'                	=> __( 'Name', 'sptheme_admin' ),
				'project-category' 		=> __( 'Project Type', 'sptheme_admin' ),
				'phase' 				=> __( 'Phase', 'sptheme_admin' ),
				'date' 					=> __( 'Date', 'sptheme_admin' ),
				'menu_order' 			=> __( 'Order', 'sptheme_admin' )
			);

			return $columns;
		}
	} // /project_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'sp_project_cp_custom_column' ) ) {
		function sp_project_cp_custom_column( $column ) {
			global $post;
			
			switch ( $column ) {
				case "project-category":

					$terms = get_the_terms( $post->ID, 'sp_project_name_ct' );

					if ( empty( $terms ) )
						break;
		
						$output = array();
		
						foreach ( $terms as $term ) {
							
							$output[] = sprintf( '<a href="%s">%s</a>',
								esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'sp_project_name_ct' => $term->slug ), 'edit.php' ) ),
								esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'sp_project_name_ct', 'display' ) )
							);
		
						}
		
						echo join( ', ', $output );

				break;
				case "phase":

					$terms = get_the_terms( $post->ID, 'sp_phase_ct' );

					if ( empty( $terms ) )
						break;
		
						$output = array();
		
						foreach ( $terms as $term ) {
							
							$output[] = sprintf( '<a href="%s">%s</a>',
								esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'sp_phase_ct' => $term->slug ), 'edit.php' ) ),
								esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'sp_phase_ct', 'display' ) )
							);
		
						}
		
						echo join( ', ', $output );

				break;
				case "thumbnail":

					$size = explode( 'x', SP_ADMIN_LIST_THUMB );
					echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, $size, array( 'title' => get_the_title( $post->ID ) ) ) . '</a>';

				break;

				case 'menu_order':
				      $order = $post->menu_order;
				      echo $order;
				break;      
				
				default:
				break;
			}
		}
	} // /sp_project_cp_custom_column

	/**
	* make Order column sortable
	*/
	function order_column_register_sortable($columns){
	  $columns['menu_order'] = 'menu_order';
	  return $columns;
	}

	
	