( function( $ ) {
	
	if( ! wp || ! wp.customize )
		return;
		
	var api = parent.wp.customize;

	wp.customize( 'site_name_back_2', function( value ) {
		value.bind( function( to ) {
			$( '.head-wrapper' ).css( 'background', to_rgba( to,  GetControlVal( 'site_name_back_2_opacity' ) ) );
		} );
	} );
	
	wp.customize( 'site_name_back_2_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.head-wrapper' ).css( 'background-color', to_rgba( GetControlVal('site_name_back_2'), to ) );
		} );
	} );
	
	wp.customize( 'site_name_back_2_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal( 'site_name_back_2_opacity', parseInt( to ) /10 );
		} );
	} );	
	
//column background color
	wp.customize( 'sidebar32_back', function( value ) {
		value.bind( function( to ) {	
			$( '#page .sidebar-1, #page .sidebar-2' ).css( 'background-color', to_rgba( to, GetControlVal('sidebar32_back_opacity') ) );		
		} );
	} );
	wp.customize( 'sidebar32_back_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.#page .sidebar-1, #page .sidebar-2' ).css( 'background-color', to_rgba( GetControlVal('sidebar32_back'), to ) );
		} );
	} );
	
	wp.customize( 'sidebar32_back_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal( 'sidebar32_back_opacity', parseInt( to ) /10 );
		} );
	} );	
	
	/* Sidebar Layout */
	
	
	wp.customize( 'layout_color', function( value ) {
		value.bind( function( to ) {	
			$( '.widget.sgwindow_sidebar' ).css( 'background-color', to_rgba( to, GetControlVal('layout_color_opacity') ) );		
		} );
	} );
	wp.customize( 'layout_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.widget.sgwindow_sidebar' ).css( 'background-color', to_rgba( GetControlVal('layout_color'), to ) );
		} );
	} );
	
	wp.customize( 'layout_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal( 'layout_color_opacity', parseInt( to ) /10 );
		} );
	} );	
	
	wp.customize( 'layout_content', function( value ) {
		value.bind( function( to ) {	
			$( '.my-sidebar-layout' ).css( 'background-color', to_rgba( to, GetControlVal('layout_content_opacity') ) );		
		} );
	} );
	wp.customize( 'layout_content_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.my-sidebar-layout' ).css( 'background-color', to_rgba( GetControlVal('layout_content'), to ) );
		} );
	} );
	
	wp.customize( 'layout_content_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal( 'layout_content_opacity', parseInt( to ) /10 );
		} );
	} );
	
	//border
	wp.customize( 'layout_border', function( value ) {
		value.bind( function( to ) {	
			$( '.my-sidebar-layout' ).css( 'border-color', to );		
		} );
	} );
	
	/* site width */
	
	//max content wrapper width
	wp.customize( 'width_main_wrapper', function( value ) {
		value.bind( function( to ) {
			$( '.main-wrapper' ).css('maxWidth', to + 'px');
			$( '.max-header-width' ).css('maxWidth', to + 'px');
			$( '.max-width' ).css('maxWidth', to + 'px');
			
			$( '.sidebar-before-footer .widget > div' ).css('maxWidth', to + 'px');
			$( '.sidebar-before-footer .widget-area .widget > ul' ).css('maxWidth', to + 'px');
			$( '.sidebar-top-full .widget-area .widget > div' ).css('maxWidth', to + 'px');
			$( '.sidebar-top-full .widget-area .widget > ul' ).css('maxWidth', to + 'px');
		} );
	} );
	
	function GetControlVal(name) {
	    var control = api.control(name); 
		var rez = '';
		if( control ){
			rez = control.setting.get();
		}
		return rez;
	}
	
	function SetControlVal(name, newVal) {
	    var control = api.control(name); 
		if( control ){
			control.setting.set( newVal );
		}
		return;
	}	
	
	function to_rgba( color, opacity) {
		var rgbaCol = 'rgba(' + parseInt(color.slice(-6,-4),16)
		+ ',' + parseInt(color.slice(-4,-2),16)
		+ ',' + parseInt(color.slice(-2),16)
		+',' + opacity+')';
		return rgbaCol;
	}	
	
} )( jQuery );