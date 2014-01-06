/**
 * Project Grid Short code button
 */

(function($) {
     tinymce.create( 'tinymce.plugins.team', {
        init : function( ed, url ) {
             ed.addButton( 'team', {
                title : 'Insert team information',
                image : url + '/ed-icons/people.png',
                onclick : function() {
						var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'team Options', 'admin-ajax.php?action=sp_team_shortcode&width=' + W + '&height=' + H );					                 }
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
	tinymce.PluginManager.add( 'team', tinymce.plugins.team );

	// handles the click event of the submit button
	$('body').on('click', '#sc-team-form #option-submit', function() {
		form = $('#sc-team-form');
		dummy = '<p>Insert your content here...</p>';
		// defines the options and their default values
		// again, this is not the most elegant way to do this
		// but well, this gets the job done nonetheless
		var options = {
			'team_photo' : null, 
			'name' : null,
			'position' : null
			};
		var shortcode = '[team_sc';
		
		for( var index in options) {
			var value = form.find('#option-' + index).val();
			
			// attaches the attribute to the shortcode only if it's different from the default value
			if ( value !== options[index] )
				shortcode += ' ' + index + '="' + value + '"';
		}
		
		shortcode += ']' + dummy + '[/team_sc]';

		
		if ($('#option-name').val() == ''){
			alert('Please enter name');
		} else if ($('#option-photo_team').val() == ''){
			alert('Please upload photo');
		} else if ($('#option-position').val() == ''){
			alert('Please enter position');
		} else {	
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			// closes Thickbox
			tb_remove();
		}
		
	});
	
})(jQuery);