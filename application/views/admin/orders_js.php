<script>
$(function() {
	
	$( "#accordion" ).accordion();
	

	
	var availableTags = [
		"ActionScript",
		"AppleScript",
		"Asp",
		"BASIC",
		"C",
		"C++",
		"Clojure",
		"COBOL",
		"ColdFusion",
		"Erlang",
		"Fortran",
		"Groovy",
		"Haskell",
		"Java",
		"JavaScript",
		"Lisp",
		"Perl",
		"PHP",
		"Python",
		"Ruby",
		"Scala",
		"Scheme"
	];
	$( "#autocomplete" ).autocomplete({
		source: availableTags
	});


	// Click events for the radio buttons
	$("#cancel_order").click(function() {
		//Disable the fields
		$("#booked_seats").attr('disabled','disabled');
		$("#amount_paid").attr('disabled','disabled');
		$("#flight_id").attr('disabled','disabled');

		// Update the booked seats and amount paid to 0
		$("#booked_seats").val(0);
		$("#amount_paid").val(0);
	});

	$("#update_order").click(function() {
		$("#booked_seats").removeAttr('disabled');
		$("#amount_paid").removeAttr('disabled');
		$("#flight_id").removeAttr('disabled');
	});

	// When the number of seats changes, change the suggested price
	$("#booked_seats").change(function() {
		$("#suggested_price").html(calcSuggestedPrice());
	});

	function calcSuggestedPrice() {
		var seats = $("#booked_seats").val();
		var price = seats * <?php echo $modifiable_order_flight_data->ticket_price; ?>;
		return price;
	}

	
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