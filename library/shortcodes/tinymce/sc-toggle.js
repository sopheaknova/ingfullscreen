/**
 * Toggle Short code button
 */

( function() {
     tinymce.create( 'tinymce.plugins.toggle', {
        init : function( ed, url ) {
             ed.addButton( 'toggle', {
                title : 'Insert a Toggle',
                image : url + '/ed-icons/toggle.png',
                onclick : function() {
						var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Toggle Options', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=sc-toggle-form' );
                 }
             });
         },
         createControl : function( n, cm ) {
             return null;
         },
     });
	tinymce.PluginManager.add( 'toggle', tinymce.plugins.toggle );
	jQuery( function() {
		var form = jQuery( '<div id="sc-toggle-form"><table id="sc-toggle-table" class="form-table">\
							<tr>\
							<th><label for="sc-toggle-title">Title</label></th>\
							<td><input type="text" id="sc-toggle-title" name="title" value="My Toggle" /><br />\
							<small>Enter a title for your toggle.</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-toggle-content">Content</label></th>\
							<td><textarea id="sc-toggle-content" name="sc-toggle-content" value="" rows="5"></textarea><br />\
							<small>Enter a title for your toggle.</small></td>\
							</tr>\
							</table>\
							<p class="submit">\
							<input type="button" id="sc-toggle-submit" class="button-primary" value="Insert Toggle" name="submit" />\
							</p>\
							</div>' );
		var table = form.find( 'table' );
		form.appendTo( 'body' ).hide();
		form.find( '#sc-toggle-submit' ).click( function() {
			var shortcode = '';
			var tog_title = table.find( '#sc-toggle-title' ).val(),
			tog_content = table.find( '#sc-toggle-content' ).val();
			shortcode = '[toggle title="' + tog_title + '"]<p>' + tog_content + '</p>[/toggle]';
			tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcode );
			tb_remove();
		} );
	} );
 } )();