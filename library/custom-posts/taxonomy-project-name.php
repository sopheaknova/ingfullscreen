<?php
add_action('init', 'sp_project_name_ct_init', 0);

function sp_project_name_ct_init() {
	register_taxonomy(
		'sp_project_name_ct',
		array( 'sp_project' ),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Project Name', 'sptheme_admin' ),
				'singular_name' => __( 'Project Name', 'sptheme_admin' ),
				'search_items' =>  __( 'Search Project Name', 'sptheme_admin' ),
				'all_items' => __( 'All Projects Name', 'sptheme_admin' ),
				'parent_item' => __( 'Parent Project Name', 'sptheme_admin' ),
				'parent_item_colon' => __( 'Parent Project Name:', 'sptheme_admin' ),
				'edit_item' => __( 'Edit Project Name', 'sptheme_admin' ),
				'update_item' => __( 'Update Project Name', 'sptheme_admin' ),
				'add_new_item' => __( 'Add New Project Name', 'sptheme_admin' ),
				'new_item_name' => __( 'Project Name', 'sptheme_admin' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'project-name' )
		)
	);
}

?>