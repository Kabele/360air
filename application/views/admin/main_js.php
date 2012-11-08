<script>
$(function() {
	
	$( "#accordion" ).accordion();

	//YYYY-MM-DD HH:MM:SS AM/PM
	
	$( "#depart_date_picker" ).datetimepicker({
        defaultDate: new Date(),
        altField: '#depart_time',
        altFieldTimeOnly: false,
        altFormat: 'yy-mm-dd',
        altTimeFormat: 'hh:mm:ss TT',
        timeFormat: 'hh:mm tt',
        changeMonth: true,
        numberOfMonths: 1,
    });
    $( "#arrival_date_picker" ).datetimepicker({
        defaultDate: new Date(),
        altField: '#arrival_time',
        altFieldTimeOnly: false,
        altFormat: 'yy-mm-dd',
        altTimeFormat: 'hh:mm:ss TT',
        timeFormat: 'hh:mm tt',
        changeMonth: true,
        numberOfMonths: 1,
    });
	
	$( "#button" ).button();
	//$( "#radioset" ).buttonset();
	

	
	$( "#tabs" ).tabs();
	

	
	$( "#dialog" ).dialog({
		autoOpen: false,
		width: 400,
		buttons: [
			{
				text: "Ok",
				click: function() {
					$( this ).dialog( "close" );
				}
			},
			{
				text: "Cancel",
				click: function() {
					$( this ).dialog( "close" );
				}
			}
		]
	});

	// Link to open the dialog
	$( "#dialog-link" ).click(function( event ) {
		$( "#dialog" ).dialog( "open" );
		event.preventDefault();
	});
	

	
	$( "#datepicker" ).datepicker({
		inline: true
	});
	

	
	$( "#slider" ).slider({
		range: true,
		values: [ 17, 67 ]
	});
	

	
	$( "#progressbar" ).progressbar({
		value: 20
	});
	

	// Hover states on the static widgets
	$( "#dialog-link, #icons li" ).hover(
		function() {
			$( this ).addClass( "ui-state-hover" );
		},
		function() {
			$( this ).removeClass( "ui-state-hover" );
		}
	);
});
</script>