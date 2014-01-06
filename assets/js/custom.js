(function($)
{
	/*--------------------------------------------------------------------------------------*/
	/* 	Navigation drop down 																*/
	/*--------------------------------------------------------------------------------------*/
	$( '.nav-menu ul, .sec-menu ul' ).css( { display: "none" } );
	function showMenu(){
		$( this ).find( 'ul:first' ).css( { visibility: "visible", display: "none" } ).slideDown( 300 );
	};
	function hideMenu(){
		$( this ).find( 'ul:first' ).css( { visibility: "visible", display: "none" } );
	};
	var config = {
		over	: showMenu,
		timeout	: 10,
		out		: hideMenu
	};
	$( '.nav-menu li, .sec-menu li' ).hoverIntent( config );

	/*--------------------------------------------------------------------------------------*/
	/* 	Make all the videos responsive with FitVids - http://fitvidsjs.com/					*/
	/*--------------------------------------------------------------------------------------*/
	$('#content').fitVids();

	/*--------------------------------------------------------------------------------------*/
	/* 	Set auto height for full-width content 												*/
	/*--------------------------------------------------------------------------------------*/
	function contentHeight(){
		var fullContentHeight = $('#content').height()
		$('.full-width .entry-content').css({'height': fullContentHeight - 120});
	}
	contentHeight();

	$(window).resize(function(){
		contentHeight();
	});
	
	/*--------------------------------------------------------------------------------------*/
	/* 	Toggle Content 																		*/
	/*--------------------------------------------------------------------------------------*/

	function toggleContent(show_or_hide) {

		var fullContentHeight = $('#content').height();
		var mapContainer = $('#map-container').height();

		$('.toggle-content').toggleClass('unvisible');
		if(show_or_hide) {
			$('#slide-nav').fadeOut(500);
			$('#content').show();
			$('#content .min').animate({'bottom': '30px'}, 1000, 'easeInOutExpo');
			$('#content .full-width').animate({'top': '20px'}, 1000, 'easeInOutExpo');
			$('.bg-overlay').fadeIn(500, function(){
				$('#content').show();	
			});
			$('#map-info').animate({'top': 180}, 1000, 'easeInOutExpo');
			$('#sidebar').animate({'top': 150}, 1000, 'easeInOutExpo');	

		} else {
			$('#slide-nav').fadeIn(500);
			$('#content .min').animate({'bottom': '-400px'}, 1000, 'easeInOutExpo', function() {
				$('#content').hide();
			});
			$('#content .full-width').animate({'top': fullContentHeight+30}, 1000, 'easeInOutExpo', function() {
				$('#content').hide();
			});
			$('.bg-overlay').fadeOut(500, function(){
				$('#content').hide();	
			});
			$('#map-info').animate({'top': mapContainer+30}, 1000, 'easeInOutExpo');	
			$('#sidebar').animate({'top': -400}, 1000, 'easeInOutExpo');	
		}
	}

	$( '.toggle-content').click(function(){
		$this = $(this);
		if ( $this.hasClass('unvisible') ) {
			toggleContent(1);
		} else {
			toggleContent(0);
		}
	});

	/*--------------------------------------------------------------------------------------*/
	/* 	Custom content scrolling 															*/
	/*--------------------------------------------------------------------------------------*/
	$('.entry-content').mCustomScrollbar({
		scrollButtons:{
			enable:true
		},
		theme:"dark"
	});
																																  
}(jQuery));