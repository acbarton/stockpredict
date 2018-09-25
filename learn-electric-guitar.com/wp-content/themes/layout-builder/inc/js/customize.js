jQuery( document ).ready(function( $ ) {

	if ( ! wp || ! wp.customize )
		return;
		
	var ids = []
		
	var control_check = wp.customize.control( 'are_we_saved' );
	if ( ! control_check )
		return;

	var sidebar = wp.customize.control( 'sidebars_widgets[sidebar-top-home]' );

	if ( sidebar ) {
		sidebar.addWidget( 'sgwindow_side_bar' );
		updateWidget( 2 );
	}
	
	function updateWidget( count ) {
		wp.customize.control.each( function( control ) {
		
			//control.container.find( 'a.widget-control-remove' ).click();
					
			if ( 'sgwindow_side_bar' == control.params.widget_id_base ) {
			
				if ( -1 != $.inArray( control.id, ids )  )
					return;
					
				ids.push( control.id ); 
				
				control.container.find( "input[id$='-count']" ).val( count );
				control.container.find( '.add-sidebar-button' ).click();
				
				if ( 4 == count ) {
					control.container.find( "input[id$='width_0']" ).val( 25 );
					control.container.find( "input[id$='-sidebar_name_0']" ).val( 'Top 1' );
					control.container.find( "input[id$='width_1']" ).val( 25 );
					control.container.find( "input[id$='-sidebar_name_1']" ).val( 'Top 2' );
					control.container.find( "input[id$='width_2']" ).val( 25 );
					control.container.find( "input[id$='-sidebar_name_2']" ).val( 'Top 3' );
					control.container.find( "input[id$='width_3']" ).val( 25 );
					control.container.find( "input[id$='-sidebar_name_3']" ).val( 'Top 4' );					
				} else if ( 2 == count ) {
					control.container.find( "input[id$='width_0']" ).val( 60 );
					control.container.find( "input[id$='-sidebar_name_0']" ).val( 'Top 5' );
					control.container.find( "input[id$='width_1']" ).val( 40 );
					control.container.find( "input[id$='-sidebar_name_1']" ).val( 'Top 6' );
				} else if ( 1 == count ) {
					control.container.find( "input[id$='width_0']" ).val( 100 );
					control.container.find( "input[id$='-sidebar_name_0']" ).val( 'Full Width' );
				}
				
				control.updateWidget();
				
			}
			
			
		} );
	}
	
	control_check.setting.set( '1' );
	
});
