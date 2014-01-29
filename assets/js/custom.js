(function($)
{
	/*--------------------------------------------------------------------------------------*/
	/* 	Init
	/*--------------------------------------------------------------------------------------*/
	dropdownNav();
	window.onresize = function() {
		dropdownNav();
	}

	/*--------------------------------------------------------------------------------------*/
	/* 	Navigation drop down 																
	/*--------------------------------------------------------------------------------------*/
	function dropdownNav() {
		var wrapper = $('#page').width();
		if ( wrapper >= 985 ) {
			$('.primary-nav ul li ul').css( {display: "none"} );

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
			$( '.primary-nav li' ).hoverIntent( config );
		} else {
			$('.primary-nav li').unbind("mouseenter").unbind("mouseleave");
			$('.primary-nav li').removeProp('hoverIntent_t');
			$('.primary-nav li').removeProp('hoverIntent_s');
			
			$('.primary-nav ul li ul').css( {display: "block"} );
		}
	}

	/*--------------------------------------------------------------------------------------*/
	/* 	Set auto height for main content 												
	/*--------------------------------------------------------------------------------------*/
	function contentHeight(){
		var sidebarHeight = $('#sidebar').height(),
		mainWidth = $('#main').width();
		mainHeight = $('#main').height();
		if (sidebarHeight > mainHeight && mainWidth > 480) {
			$('#main').css({'min-height': sidebarHeight + 70});
		}
	}
	contentHeight();

	/*--------------------------------------------------------------------------------------*/
	/* 	Set Map auto height in Contact page 												
	/*--------------------------------------------------------------------------------------*/
	function mapHeightAuto(){
		var mapHeight = $(window).height() - $('#header').height();
		$('#single-map-canvas').css("height", mapHeight - 5);
	}
	mapHeightAuto();

	/*--------------------------------------------------------------------------------------*/
	/* 	Make all the videos responsive with FitVids - http://fitvidsjs.com/					
	/*--------------------------------------------------------------------------------------*/
	$('#content').fitVids();

	/*--------------------------------------------------------------------------------------*/
	/* 	Social share floating in article
	/*--------------------------------------------------------------------------------------*/
	if($(".social-icons-float").length != 0 && $(window).width() > 800){
		var boooo = $(".social-icons-float").offset().top-31;

		$(window).scroll(function () {
			var position = $(window).scrollTop();
			if(position >= boooo){
				$(".social-icons-float").css("position", "fixed").css("top", "30px").css("left", "50%").css("margin-left", "380px");
			}else{
				$(".social-icons-float").css("position", "absolute").css("top", "47px").css("right", "0px");
			}
		});
	}

	/*--------------------------------------------------------------------------------------*/
	/* 	Flexslider post
	/*--------------------------------------------------------------------------------------*/
	$('.flexslider').flexslider({
	    animation: "slide",
	    smoothHeight: "true"
	  });

	/*--------------------------------------------------------------------------------------*/
	/* 	Responsive Nav
	/*--------------------------------------------------------------------------------------*/
	var navigation = responsiveNav('.primary-nav');
																																  
}(jQuery));