/**
 * Project Grid Short code button
 */

(function($) {
     tinymce.create( 'tinymce.plugins.project_grid', {
        init : function( ed, url ) {
             ed.addButton( 'project_grid', {
                title : 'Insert a projects grid',
                image : url + '/ed-icons/project.png',
                onclick : function() {
						var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Project Grid Options', 'admin-ajax.php?action=sp_project_grid_shortcode&width=' + W + '&height=' + H );					                 }
             });
         },
         getInfo : function() {
				return {
						longname : 'SP Theme',
						author : 'Sopheak Peas',
						authorurl : 'http://www.linkedin.com/in/sopheakpeas',
						infourl : 'http://www.linkedin.com/in/sopheakpeas',
						version : '1.0.1'
				};
		}
     });
	tinymce.PluginManager.add( 'project_grid', tinymce.plugins.project_grid );

	// handles the click event of the submit button
	$('body').on('click', '#sc-project-grid-form #option-submit', function() {
		form = $('#sc-project-grid-form');
		// defines the options and their default values
		// again, this is not the most elegant way to do this
		// but well, this gets the job done nonetheless
		var options = { 
			'limit': '6',
			'project_term': '-1',
			'phase_term': '-1',
			'orderby': 'menu_order'
			};
		var shortcode = '[projects_grid';
		
		for( var index in options) {
			var value = form.find('#option-' + index).val();
			
			// attaches the attribute to the shortcode only if it's different from the default value
			if ( value !== options[index] )
				shortcode += ' ' + index + '="' + value + '"';
		}
		
		shortcode += ']';
		
		if ($('#option-project_term').val() == -1){
			alert('Please select project');
		} else if($('#option-phase_term').val() == -1){
			alert('Please select phase');
		} else {	
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			// closes Thickbox
			tb_remove();
		}
		
	});
	
})(jQuery);