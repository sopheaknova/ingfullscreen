<?php

add_action('wp_ajax_sp_gallery_shortcode', 'sp_gallery_shortcode_ajax' );

function sp_gallery_shortcode_ajax(){
	$defaults = array(
		'album' => null
	);
	$args = array_merge( $defaults, $_GET );
	?>

	<div id="sc-gallery-form">
			<table id="sc-gallery-table" class="form-table">
				<tr>
					<?php $field = 'album'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Album', 'sptheme_admin' ); ?></label></th>
					<td>
						<select name="<?php echo $field; ?>" id="option-<?php echo $field; ?>">
							<option value="-1" selected><?php _e( 'Select album', 'sptheme_admin' ); ?></option>
						<?php
						$args = (array(
							'post_type' => 'sp_gallery',
							'limit' => -1
						));
						$posts = get_posts( $args );
						foreach ( $posts as $post ) {
							echo '<option class="level-0" value="' . $post->ID . '">' . $post->post_title . '</option>';
						}
						?>
						</select>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="button" id="option-submit" class="button-primary" value="<?php printf( __( 'Insert %s', 'sptheme_admin' ), __( 'Gallery', 'sptheme_admin' ) ); ?>" name="submit" />
			</p>
	</div>			

	<?php
	exit();	
}
?>