jQuery(document).ready( function($) {	
	$('#tabs div').hide();
	$('#tabs div:first').show();
	$('#tabs ul li:first').addClass('active');
	
	$('a.nav-tab').click(function(){						   
		$('a.nav-tab').removeClass('nav-tab-active');
		$(this).addClass('nav-tab-active');
		var currentTab = $(this).attr('href');
		$('#tabs div').hide();
		$(currentTab).show();
		
		return false;
	});
});