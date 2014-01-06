<?php

add_action('wp_ajax_sp_team_shortcode', 'sp_team_shortcode_ajax' );

function sp_team_shortcode_ajax(){
	$defaults = array(
		'team_photo' => null,
		'name' => null,
		'postion' => null
	);
	$args = array_merge( $defaults, $_GET );

	wp_enqueue_script('media_upload');

	?>
	<script type="text/javascript">
		(function($) {

			$(function(){
				$('#upload_file_image_button').click(function(){
					orginal_media_upload = wp.media.editor.send.attachment;
					wp.media.editor.send.attachment = function(props, attachment){
						$('#option-team_photo').val(attachment.url);
					}

					wp.media.editor.open(this);
					window.send_to_editor = orginal_media_upload;

					return false;
				});
			});

		}(jQuery));

	</script>

	<div id="sc-team-form">
			<table id="sc-team-table" class="form-table">
				<tr>
					<?php $field = 'team_photo'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Photo', 'sptheme_admin' ); ?></label></th>
					<td>
						<input type="text" id="option-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $args[$field]; ?>" />
						<input type="button" id="upload_file_image_button" class="upload_button button" value="Upload photo" />
					</td>
				</tr>
				<tr>
					<?php $field = 'name'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Name', 'sptheme_admin' ); ?></label></th>
					<td><input type="text" id="option-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $args[$field]; ?>" /> <small>(<?php _e( 'John Doe', 'sptheme_admin' ); ?>)</small></td>
				</tr>
				<tr>
					<?php $field = 'position'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Position', 'sptheme_admin' ); ?></label></th>
					<td><input type="text" id="option-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $args[$field]; ?>" /> <small>(<?php _e( 'CEO', 'sptheme_admin' ); ?>)</small></td>
				</tr>
			</table>
			<p class="submit">
				<input type="button" id="option-submit" class="button-primary" value="<?php printf( __( 'Insert %s', 'sptheme_admin' ), __( 'Team', 'sptheme_admin' ) ); ?>" name="submit" />
			</p>
	</div>			

	<?php
	exit();	
}
?>