jQuery( document ).ready(function( $ ) {
	
	if ( $( '.sgwindow_sidebar_nav' ).size() > 0 )
		return;

	var adm = 0;
	if(parseInt($('#wpadminbar')) != 'undefined')
		adm = parseInt($('#wpadminbar').css('height'));
		
	if ( isNaN( adm ) )
		adm = 0;
		
	$('.top-navigation')
	.addClass('original')
	.clone()
	.insertAfter('.top-navigation')
	.addClass('cloned')
	.css('position','fixed')
	.css('top','0')
	.css('margin-top',adm)
	.css('margin-left','0')
	.css('z-index','500')
	.removeClass('original')
	.hide();
	
});