jQuery(document).ready( function($) {	
	$('.em_title').tipsy({gravity: 's'});
	if ($.browser.msie) {
	}else{
		$('.em_gosocial .em_avatar img').mouseover(function() {		
			//	
		var links = $('.em_gosocial .em_social').css('width');
		  $('.em_gosocial .em_social a').slideUp('slow', function() {
			$('.em_gosocial .em_info').show();
			$('.em_gosocial').mouseleave( function() {
				$('.em_gosocial .em_info').hide();	
				$('.em_gosocial .em_social').slideDown('slow');
				//$('.em_gosocial .em_social').css('width',links);
				 $('.em_gosocial .em_social a').slideDown('slow');							 
			});
		  });
		});
	}
});