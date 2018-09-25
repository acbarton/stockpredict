/*
	home.js	
	License:  Free to use under the GPLv2 license.
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
jQuery(window).load(function() {
				jQuery('.flexslider').flexslider({
		        animation: "fade",
		        direction: "horizontal",
		        randomize: false,
		        touch: true,
		        pauseOnAction: true, 
		        pauseOnHover: false, 
		        slideshowSpeed: 5000,
		        animationSpeed: 300,
		   });
				jQuery('#cbp-qtrotator').cbpQTRotator({// default transition speed (ms)
					speed : 700,
					// default transition easing
					easing : 'ease',
					// rotator interval (ms)
					interval : 8000
		   });
 });