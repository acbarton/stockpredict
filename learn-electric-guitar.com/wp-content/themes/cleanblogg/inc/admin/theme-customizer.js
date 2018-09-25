(function($){
	wp.customize("ads_code", function(value) {
		value.bind(function(newval) {
			$("#ads_code").html(newval);
		} );
	});
})(jQuery);