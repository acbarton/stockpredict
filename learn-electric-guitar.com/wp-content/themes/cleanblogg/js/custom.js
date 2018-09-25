(function($) {
  "use strict";
  $(document).ready(function(){
		  $(".cb-top-search-btn").click(function(){
				  $('.cb-top-search-form').toggle();
		  });
		  $('.cb-slider ul').bxSlider({
				  auto: cleanblogVars.slider_options.auto,
				  mode: cleanblogVars.slider_options.mode,
				  speed: cleanblogVars.slider_options.speed,
				  pause: cleanblogVars.slider_options.pause, 
				  easing:'ease-in-out',
				  autoControls: true,
		  });
		  $('.widget-nav-tabs a').click(function (e) {
				  e.preventDefault();
				  $(this).tab('show');
		  });
		  $('.cb-menu-toggle').click( function(e) {
				  e.preventDefault();
				  $(this).toggleClass('cb-open-menu');
				  $('.cb-nav ul.menu').toggleClass('cb-show-menu');
		  });
		  
  });
  })(jQuery);