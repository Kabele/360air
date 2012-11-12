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
	
	$( ".button" ).each(function() {
		$(this).button();
	});
	
	$("#add_flight").click(function() {
		$("#comment").hide();
	});
	$("#update_flight").click(function() {
		$("#comment").show();
	});
	$("#delete_flight").click(function() {
		$("#comment").show();
	});

	$("#crud_flight").button().attr('disabled', true);

	$("#crud_confirm").change(function() {
        if ($(this).is(':checked')) {
        	$("#crud_flight").button().attr('disabled', false).removeClass( 'ui-state-disabled' );
        }
	});

	// Link to open the dialog
	$( "#dialog-link" ).click(function( event ) {
		$( "#dialog" ).dialog( "open" );
		event.preventDefault();
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