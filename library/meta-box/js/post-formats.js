jQuery( document ).ready( function($) {

	var	$quoteSettings = $('#post-quote-settings').hide(),
		$statusSettings = $('#post-status-settings').hide(),
		$videoSettings = $('#post-video-settings').hide(),
		$audioSettings = $('#post-audio-settings').hide(),
		$postdivrich   = $('#postdivrich'),
		$postFormat    = $('#post-formats-select input[name="post_format"]'),
		
		//var for change template
		$layoutPanel    = $('#layout-settings'),
		$mastheadPanel = $('#masthead'),
		$pageTempalte = $('#page_template'),
		$pageLayout = $('.rwmb-label-radio-image input[name="sp_page_layout"]'),
		$selectSidebar = $('.rwmb-sidebar-wrapper').hide(),
		$pageBgImage = $('#page-background-image');
	
	$postFormat.each(function() {
		
		var $this = $(this);

		if( $this.is(':checked') )
			changePostFormat( $this.val() );

	});

	$postFormat.change(function() {

		changePostFormat( $(this).val() );

	});

	function changePostFormat( val ) {
		
		$quoteSettings.hide();
		$statusSettings.hide();
		$videoSettings.hide();
		$audioSettings.hide();
		$postdivrich.show();

		if( val === 'quote' ) {
			$quoteSettings.show();
		} else if( val === 'status' ) {
			$statusSettings.show();
		} else if( val === 'video' ) {
			$videoSettings.show();
		} else if( val === 'audio' ) {
			$audioSettings.show();
		}

	}
	
	
	if ( ($('body').hasClass('post-type-page')) && ($('#page_template').val() !== 'default') ) {
		$layoutPanel.hide();
		$mastheadPanel.hide();
		$pageBgImage.hide();
	}
	
	$('#page_template').change(function() {
		changePageTemplate( $(this).val() );
	});
	
	function changePageTemplate( val ) {
		
		$layoutPanel.show();
		$mastheadPanel.show();
		$pageBgImage.show();
		
		if( val !== 'default' ) {

			$layoutPanel.hide();
			$mastheadPanel.hide();
			$pageBgImage.hide();
			
		}
	}
	
	
	$pageLayout.each(function() {
		
		var $this = $(this);

		if( $this.is(':checked') )
			changePageLayout( $this.val() );

	});
	
	$pageLayout.change(function() {
		changePageLayout( $(this).val() );
	})
	
	function changePageLayout( val ) {
		
		$selectSidebar.show();
		
		if( val === '1col' ) {

			$selectSidebar.hide();
			
		} else if( val === '2cr' || val === '3col' ) {
			$selectSidebar.show();
		}
	}

	/***********************************************
	* Custom diable content box
	***********************************************/
	var $disableContent = $('#sp_diable_content_box'),
	$postdivrich = $('#postdivrich');

	$disableContent.each(function() {
		var $this = $(this);

		if( $this.is(':checked') )
			toggleContentBox( $this.attr('checked') );
	})

	$disableContent.change(function(){
		toggleContentBox( $(this).attr('checked') );
	});

	function toggleContentBox( checked ){
		if (checked == 'checked'){
			$postdivrich.hide();
			$pageLayout.parent().parent().parent().hide();
			
		} else {
			$postdivrich.show();
			$pageLayout.parent().parent().parent().show();
		}
	}

	/***********************************************
	* Enable upload multiple project gallery
	***********************************************/
	var $projectGallery = $('#sp_project_img_type'),
	$uploadProjectGallery = $('#project-settings').find('.rwmb-meta-box').children().eq(3).hide();

	$projectGallery.each(function() {
		var $this = $(this);

		if( $this.is(':checked') )
			toggleUploadGallery( $this.attr('checked') );
	})

	$projectGallery.change(function(){
		toggleUploadGallery( $(this).attr('checked') );
	});

	function toggleUploadGallery( checked ){
		if (checked == 'checked'){
			$uploadProjectGallery.show();
			
		} else {
			$uploadProjectGallery.hide();
		}
	}
	

});