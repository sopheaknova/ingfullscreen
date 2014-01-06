/**
 * List Short code button
 */

( function() {
     tinymce.create( 'tinymce.plugins.list', {
        init : function( ed, url ) {
             ed.addButton( 'list', {
                title : 'Insert icon list',
                image : url + '/ed-icons/list.png',
                onclick : function() {
						var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'List Options', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=sc-list-form' );					                 }
             });
         },
         createControl : function( n, cm ) {
             return null;
         },
     });
	tinymce.PluginManager.add( 'list', tinymce.plugins.list );
	jQuery( function() {
		var form = jQuery( '<div id="sc-list-form"><table id="sc-list-table" class="form-table">\
						  <tr>\
						  <th><label for="sc-list-liststyle">List Style Icon</label></th>\
						  <td><select name="align" id="sc-list-liststyle">\
						  <option value="next">Next arrow</option>\
						  <option value="checkmark">Checkmark</option>\
						  <option value="dot">Dot</option>\
						  <option value="pinned">Pinned</option>\
						  </select><br />\
						  <small>Select a list style.</small></td>\
						  </tr>\
						  </table>\
						  <p class="submit">\
						  <input type="button" id="sc-list-submit" class="button-primary" value="Insert List" name="submit" />\
						  </p>\
						  </div>');
		var table = form.find( 'table' );
		form.appendTo( 'body' ).hide();
		form.find( '#sc-list-submit' ).click( function() {
			var shortcode = '';
			var liststyle = table.find( '#sc-list-liststyle' ).val();
			shortcode = '<ul class="sc-list ' + liststyle + '">';
			shortcode += '<li>List item one</li>';
			shortcode += '<li>List item one</li>';
			shortcode += '<li>List item one</li>';
			shortcode += '<li>List item one</li>';
			shortcode += '</ul>';
			tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcode );
			tb_remove();
		} );
	} );
 } )();