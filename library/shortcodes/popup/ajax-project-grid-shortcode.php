<?php

add_action('wp_ajax_sp_project_grid_shortcode', 'sp_project_grid_shortcode_ajax' );

function sp_project_grid_shortcode_ajax(){
	$defaults = array(
		'limit' => 6,
		'project_term' => null,
		'phase_term' => null,
		'orderby' => 'menu_order'
	);
	$args = array_merge( $defaults, $_GET );
	?>

	<div id="sc-project-grid-form">
			<table id="sc-project-grid-table" class="form-table">
				<tr>
					<?php $field = 'limit'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Limit', 'sptheme_admin' ); ?></label></th>
					<td><input type="text" id="option-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $args[$field]; ?>" size="3" /> <small>(<?php _e( '0 = no limit', 'sptheme_admin' ); ?>)</small></td>
				</tr>
				<tr>
					<?php $field = 'project_term'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Project Term', 'sptheme_admin' ); ?></label></th>
					<td>
						<?php
						wp_dropdown_categories(array(
							'show_option_none' => __( 'Select project' ),
							'hide_empty' => 0,
							'orderby' => 'title',
							'taxonomy' => 'sp_project_name_ct',
							'selected' => $args[$field],
							'name' => $field,
							'id' => 'option-' . $field
						));
						?>
					</td>
				</tr>
				<tr>
					<?php $field = 'phase_term'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Phase Term', 'sptheme_admin' ); ?></label></th>
					<td>
						<?php
						wp_dropdown_categories(array(
							'show_option_none' => __( 'Select phase' ),
							'hide_empty' => 0,
							'orderby' => 'title',
							'taxonomy' => 'sp_phase_ct',
							'selected' => $args[$field],
							'name' => $field,
							'id' => 'option-' . $field
						));
						?>
					</td>
				</tr>
				<tr>
					<?php $field = 'orderby'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Order by', 'sptheme_admin' ); ?></label></th>
					<td><input type="text" id="option-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $args[$field]; ?>" /></td>
				</tr>
			</table>
			<p class="submit">
				<input type="button" id="option-submit" class="button-primary" value="<?php printf( __( 'Insert %s', 'sptheme_admin' ), __( 'Projects', 'sptheme_admin' ) ); ?>" name="submit" />
			</p>
	</div>			

	<?php
	exit();	
}
?>