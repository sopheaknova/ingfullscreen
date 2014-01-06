<?php
add_action('init', 'sp_phase_ct_init', 0);

function sp_phase_ct_init() {
	register_taxonomy(
		'sp_phase_ct',
		array( 'sp_project' ),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Phase', 'sptheme_admin' ),
				'singular_name' => __( 'Phase', 'sptheme_admin' ),
				'search_items' =>  __( 'Search Phase', 'sptheme_admin' ),
				'all_items' => __( 'All Phase', 'sptheme_admin' ),
				'parent_item' => __( 'Parent Phase', 'sptheme_admin' ),
				'parent_item_colon' => __( 'Parent Phase:', 'sptheme_admin' ),
				'edit_item' => __( 'Edit Phase', 'sptheme_admin' ),
				'update_item' => __( 'Update Phase', 'sptheme_admin' ),
				'add_new_item' => __( 'Add New Phase', 'sptheme_admin' ),
				'new_item_name' => __( 'Phase', 'sptheme_admin' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'phase' )
		)
	);
}
?>