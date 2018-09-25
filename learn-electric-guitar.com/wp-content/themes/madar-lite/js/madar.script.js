jQuery(document).ready(function(){	
   	jQuery(".madarlist-content").slideUp();
	jQuery('.top-menu  ul > li > ul, .top-menu  ul > li > ul > li > ul, .top-menu  ul > li > ul > li > ul> li > ul ').parent('li').addClass('parent-list');
	//jQuery('.parent-list').find("a:first").append(' <span class="sub-indicator"></span>')
				jQuery('ul.madar-main-menu li ul li').addClass('noLava');
			jQuery('ul.madar-main-menu > li').addClass('top-level');
			
			var parentHeight = jQuery('ul.madar-main-menu ul').parent().height();
			//alert(parentHeight);
			
			//jQuery('ul.madar-main-menu ul').css( 'top' , parentHeight)  + "px";

	jQuery(".madarlist-content").slideUp();
	jQuery('#main-nav ul > li > ul, #main-nav ul > li > ul > li > ul, #main-nav ul > li > ul > li > ul> li > ul, #main-nav ul > li > ul > li > ul> li > ul > li > ul, .top-menu  ul > li > ul, .top-menu  ul > li > ul > li > ul, .top-menu  ul > li > ul > li > ul> li > ul ').parent('li').addClass('parent-list');
	//jQuery('.parent-list').find("a:first").append(' <span class="sub-indicator"></span>')
				jQuery('ul.madar-main-menu li ul li').addClass('noLava');
			jQuery('ul.madar-main-menu > li').addClass('top-level');
			
			var parentHeight = jQuery('ul.madar-main-menu ul').parent().height();
			//alert(parentHeight);
			
			//jQuery('ul.madar-main-menu ul').css( 'top' , parentHeight)  + "px";
	
	
	jQuery("#main-nav li, #top-nav li").each(function(){	
		var $sublist = jQuery(this).find('ul:first');
		function makeTall() {
				// mouseover
				$sublist.stop(true, true).slideDown('fast');
			}
		function makeShort() {
				// mouseout
				$sublist.stop(true, true).fadeOut(200); 		
			}

	 	jQuery(this).hoverIntent({
				over: makeTall, 
				timeout: 500, 
				out: makeShort
			});
	});
	function responsive_nav(nav){
	/* Clone our navigation */
	var handler = "nav." + nav;
	var mainNavigation = jQuery(handler).clone();
			
		/* Get the window's width, and check whether it is narrower than 480 pixels */
		var windowWidth = jQuery(window).width();
		//alert(windowWidth);
		//alert(mainNavigation);
		if (windowWidth <= 3006) {
		

		
			/* Replace unordered list with a "select" element to be populated with options, and create a variable to select our new empty option menu */
			jQuery(handler).append('<select class="menu"></select>');
			var handler2 = "nav." + nav + " select.menu";
			var selectMenu = jQuery(handler2);
		
			/* Navigate our nav clone for information needed to populate options */
			jQuery(mainNavigation).children('div').children('ul').children('li').each(function() {
		
				/* Get top-level link and text */
				var href = jQuery(this).children('a').attr('href');
				var text = jQuery(this).children('a').text();
		
				if(jQuery(this).hasClass('current-menu-item')){
				//if(jQuery(this).hasClass('selectedLava')){
					jQuery(selectMenu).append('<option value="'+href+'" selected="selected">'+text+'</option>');
				}else{
					jQuery(selectMenu).append('<option value="'+href+'">'+text+'</option>');
				}
				/* Append this option to our "select" */
				
		
				/* Check for "children" and navigate for more options if they exist */
				if (jQuery(this).children('ul').length > 0) {
					jQuery('ul li', this).each(function() {

					/* Get child-level link and text */
					var href2 = jQuery(this).children('a').attr('href');
					var text2 = '';
					for ($i=0; $i<jQuery(this).parents('ul').length-1; $i++){
						text2 += '- ';
					}
					text2 += jQuery(this).children('a').text();
		
					/* Append this option to our "select" */
					if(jQuery(this).hasClass('current-menu-item')){
					//if(jQuery(this).hasClass('selectedLava')){
						jQuery(selectMenu).append('<option value="'+href2+'" selected="selected">'+text2+'</option>');
					}else{
						jQuery(selectMenu).append('<option value="'+href2+'">'+text2+'</option>');
					}
					});
				}
			});
		}

		/* When our select menu is changed, change the window location to match the value of the selected option. */
		jQuery(selectMenu).change(function() {
			location = this.options[this.selectedIndex].value;
		});
	}
		responsive_nav("top-navigation");
		responsive_nav("main-navigation");	

	jQuery('.flexslider li a img').each(function(){
		jQuery(this).removeAttr('width')
		jQuery(this).removeAttr('height');
	});
});