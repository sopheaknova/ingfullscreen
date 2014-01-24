(function($)
{
	/*--------------------------------------------------------------------------------------*/
	/* 	Navigation drop down 																
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
	/* 	Make all the videos responsive with FitVids - http://fitvidsjs.com/					
	/*--------------------------------------------------------------------------------------*/
	$('#content').fitVids();

	/*--------------------------------------------------------------------------------------*/
	/* 	Set auto height for main content 												
	/*--------------------------------------------------------------------------------------*/
	function contentHeight(){
		var sidebarHeight = $('#sidebar').height(),
		mainHeight = $('#main').height();
		if (sidebarHeight > mainHeight) {
			$('#main').css({'min-height': sidebarHeight + 70});
		}
	}
	contentHeight();

	/*--------------------------------------------------------------------------------------*/
	/* 	Social share floating in article
	/*--------------------------------------------------------------------------------------*/
	if($(".social-icons-float").length != 0){
		var boooo = $(".social-icons-float").offset().top-31;

		$(window).scroll(function () {
			//console.log($(this).css("top"));
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
	    animation: "slide"
	  });
																																  
}(jQuery));