/**
 * Tabs Short code button
 */

( function() {
     tinymce.create('tinymce.plugins.tabs', {
        init : function( ed, url ) {
             ed.addButton( 'tabs', {
                title : 'Insert a tabbed content',
                image : url + '/ed-icons/tabs.png',
                onclick : function() {
						var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Tabbed Content Options', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=sc-tabs-form' );
                 }
             });
         },
         createControl : function( n, cm ) {
             return null;
         },
     } );
	tinymce.PluginManager.add( 'tabs', tinymce.plugins.tabs );
	jQuery( function() {
		var form = jQuery( '<div id="sc-tabs-form"><table id="sc-tabs-table" class="form-table">\
							<tr>\
							<th><label for="tabgroup-new">New Tab Group?</label></th>\
							<td>\
								<select id="tabgroup-new" name="tabgroup-new" size="1">\
									<option value="no" selected="selected">No</option>\
									<option value="yes">Yes</option>\
								</select>\
							</td>\
							</tr>\
							<tr>\
							<th><label for="tab-title">Tab title</label></th>\
							<td><input type="text" name="tab-title" id="tab-title" /></td>\
							</tr>\
							<tr>\
							<th><label for="tab-content">Tab content</label></th>\
							<td><textarea id="tab-content" name="tab-content" value="" rows="5"></textarea></td>\
							</tr>\
							</table>\
							<p class="submit">\
							<input type="button" id="sc-tabs-submit" class="button-primary" value="Insert Tabs" name="submit" />\
							</p>\
							</div>' );
		var table = form.find( 'table' );
		form.appendTo( 'body' ).hide();
		form.find( '#sc-tabs-submit' ).click( function() {
			var tabgroup = table.find( '#tabgroup-new' ).val(),
			title = table.find('#tab-title').val(),
			content = table.find('#tab-content').val(),
			shortcode = '';

			// Check if this is a new tabgroup
			if (tabgroup == 'yes') {
				shortcode += '[tabgroup][tab'; 
			}
			else {
				shortcode += '[tab';
			}
			
			// Check if the title field is empty
			if (title) {
				shortcode += ' title=\"' + title + '\"]';
			}
			else {
				shortcode += ' title=\"Title Goes Here\"]';
			}
			
			// Check if the content field is empty
			if (content) {
				shortcode += content;
			}
			else {
				shortcode += 'Content Goes Here';
			}
			
			// Check if this is a new tabgroup
			if (tabgroup == 'yes') {
				shortcode += '[/tab][/tabgroup]'; 
			}
			else {
				shortcode += '[/tab]';
			}

			tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcode );
			tb_remove();
		} );
	} );
 } )();