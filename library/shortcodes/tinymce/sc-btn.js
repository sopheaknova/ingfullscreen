/**
 * Button Short code button
 */

( function() {
     tinymce.create( 'tinymce.plugins.btn', {
        init : function( ed, url ) {
             ed.addButton( 'btn', {
                title : 'Insert a Button',
                image : url + '/ed-icons/btn.png',
                onclick : function() {
						var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Button Options', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=sc-btn-form' );
                 }
             });
         },
         createControl : function( n, cm ) {
             return null;
         },
     });
	tinymce.PluginManager.add( 'btn', tinymce.plugins.btn );
	jQuery( function() {
		var form = jQuery( '<div id="sc-btn-form"><table id="sc-btn-table" class="form-table">\
							<tr>\
							<th><label for="sc-btn-text">Button Text</label></th>\
							<td><input type="text" id="sc-btn-text" name="text" value="Click Me" /><br />\
							<small>Enter a button text.</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-btn-link">Button links to</label></th>\
							<td><input type="text" id="sc-btn-link" name="link" value="http://yoursite.com" /><br />\
							<small>Enter full URL of the target link.</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-btn-target">Button Link Target</label></th>\
							<td><select name="target" id="sc-btn-target">\
							<option value="_self">_self</option>\
							<option value="_blank">_blank</option>\
							</select><br/>\
							<small>Select a link target. _blank is for new window.</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-btn-color">Button Style</label></th>\
							<td><select name="color" id="sc-btn-color">\
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
							<th><label for="sc-btn-size">Button Size</label></th>\
							<td><select name="size" id="sc-btn-size">\
							<option value="small">Default (small)</option>\
							<option value="medium">Medium</option>\
							<option value="large">Large</option>\
							</select><br/>\
							<small>Select a size for button.</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-btn-type">Button Type</label></th>\
							<td><select name="type" id="sc-btn-type">\
							<option value="square" selected="selected">Square</option>\
							<option value="rounded">Rounded</option>\
							</select><br/>\
							<small>Select a button round or square.</small></td>\
							</tr>\
							</table>\
							<p class="submit">\
							<input type="button" id="sc-btn-submit" class="button-primary" value="Insert Button" name="submit" />\
							</p>\
							</div>' );
		var table = form.find( 'table' );
		form.appendTo( 'body' ).hide();
		form.find( '#sc-btn-submit' ).click( function() {
			var options = {
				'link'		: '',
				'color'		: 'standard',
				'size'		: '',
				'type'		: '',
				'target'	: '_self'
				};
			var shortcode = '[btn';
			for ( var index in options ) {
				var value = table.find( '#sc-btn-' + index ).val();
				if ( value !== options[ index ] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			var btn_text = table.find( '#sc-btn-text' ).val();
			shortcode += ']' + btn_text + '[/btn]';
			tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcode );
			tb_remove();
		} );
	} );
 } )();