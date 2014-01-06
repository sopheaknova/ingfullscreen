/**
 * Button Short code button
 */

( function() {
     tinymce.create( 'tinymce.plugins.callout_box', {
        init : function( ed, url ) {
             ed.addButton( 'callout_box', {
                title : 'Insert a Callout box',
                image : url + '/ed-icons/callout-box.png',
                onclick : function() {
						var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Callout Box Options', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=sc-callout-box-form' );
                 }
             });
         },
         createControl : function( n, cm ) {
             return null;
         },
     });
	tinymce.PluginManager.add( 'callout_box', tinymce.plugins.callout_box );
	jQuery( function() {
		var form = jQuery( '<div id="sc-callout-box-form"><table id="sc-callout-box-table" class="form-table">\
							<tr>\
							<th><label for="sc-callout-box-title">Title</label></th>\
							<td><input type="text" id="sc-callout-box-title" name="sc-callout-box-title" /><br />\
							<small>Enter callout title.</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-callout-box-caption">Caption</label></th>\
							<td><textarea id="sc-callout-box-caption" name="sc-callout-box-caption" value="" rows="3" cols="30"></textarea></td>\
							</tr>\
							<tr>\
							<th><label for="sc-callout-box-button_name">Button Text</label></th>\
							<td><input type="text" id="sc-callout-box-button_name" name="sc-callout-box-button_name" value="Click Me" /><br />\
							<small>Enter a button text.</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-callout-box-button_link">Button links to</label></th>\
							<td><input type="text" id="sc-callout-box-button_link" name="sc-callout-box-button_link" value="http://yoursite.com" /><br />\
							<small>Enter full URL of the target link.</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-callout-box-button_color">Button Style</label></th>\
							<td><select name="color" id="sc-callout-box-button_color">\
							<option value="standard" selected="selected">Standard</option>\
							<option value="black">Black</option>\
							<option value="light-blue">Blue Light</option>\
							<option value="dark-blue">Blue Dark</option>\
							<option value="light-green">Green Light</option>\
							<option value="dark-green">Green Dark</option>\
							<option value="grey">Grey</option>\
							<option value="orange">Orange</option>\
							<option value="pink">Pink</option>\
							<option value="light-purple">Purple Light</option>\
							<option value="dark-purple">Purple Dark</option>\
							<option value="red">Red</option>\
							<option value="yellow">Yellow</option>\
							</select><br/>\
							<small>Select a button style.</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-callout-box-button_size">Button Size</label></th>\
							<td><select name="size" id="sc-callout-box-button_size">\
							<option value="small">Default (small)</option>\
							<option value="medium">Medium</option>\
							<option value="large">Large</option>\
							</select><br/>\
							<small>Select a size for button.</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-callout-box-button_type">Button Type</label></th>\
							<td><select name="type" id="sc-callout-box-button_type">\
							<option value="square" selected="selected">Square</option>\
							<option value="rounded">Rounded</option>\
							</select><br/>\
							<small>Select a button round or square.</small></td>\
							</tr>\
							</table>\
							<p class="submit">\
							<input type="button" id="sc-callout-box-submit" class="button-primary" value="Insert Button" name="submit" />\
							</p>\
							</div>' );
		var table = form.find( 'table' );
		form.appendTo( 'body' ).hide();
		form.find( '#sc-callout-box-submit' ).click( function() {
			var options = {
				'title'			: '',
				'button_name'	: '',
				'button_link'	: '',
				'button_color'	: 'standard',
				'button_size'	: '',
				'button_type'	: ''
				};
			var shortcode = '[callout_box';
			for ( var index in options ) {
				var value = table.find( '#sc-callout-box-' + index ).val();
				if ( value !== options[ index ] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			var callout_box_caption = table.find( '#sc-callout-box-caption' ).val();
			shortcode += ']' + callout_box_caption + '[/callout_box]';
			tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcode );
			tb_remove();
		} );
	} );
 } )();