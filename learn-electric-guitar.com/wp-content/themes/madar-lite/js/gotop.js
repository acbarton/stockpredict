/*
	gotop.js
	License:  Free to use under the GPLv2 license.
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
jQuery(document).ready(function(){
    jQuery(window).load(function(){
	if(jQuery('.fixed-enabled').length>0){
		var headerHeight = jQuery('.fixed-enabled').offset().top ;
		var mainNav = jQuery('.fixed-enabled');
		jQuery(window).scroll(function(){
			var scrollY=jQuery(window).scrollTop();
			if(scrollY > headerHeight){
				mainNav.addClass('stickynav');
			}else if(scrollY < headerHeight){
				mainNav.removeClass('stickynav');
			}
		});
	}
    });
	jQuery(window).scroll(function(){
		if (jQuery(this).scrollTop() > 100) {
			jQuery('#back-top').css({bottom:"15px"});
		} else {
			jQuery('#back-top').css({bottom:"-100px"});
		}
	});
	jQuery('#back-top').click(function(){
		jQuery('html, body').animate({scrollTop: '0px'}, 800);
		return false;
	});
		jQuery('ul.top-menu li:first-child').addClass("current_page_item");
		jQuery('#ticker').newsticker({ 
			'tickerDelay': 3000,
			'hoverStop' : false
		});
		jQuery("html").niceScroll({cursoropacitymax:0.5,boxzoom:true});
		var active_subpage = jQuery('ul.main-navigation-menu ul li.current-cat, ul.main-navigation-menu ul li.current_page_item, ul.main-navigation-menu ul li.current-menu-item').parents('li.top-level').prevAll().length;
	});