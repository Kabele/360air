<script>
$(document).ready(function() {
	$("#order_results_table").tablesorter();
	<? if(isset($customer_orders)) { ?>

		$("#order_results_table").tablesorter();
	<? } ?>

	<? if(isset($modifiable_order)) { ?>

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

		// Change the booked seats and amount paid back to their original value
		$("#booked_seats").val(<? echo $modifiable_order->seats; ?>);
		$("#amount_paid").val(<? echo $modifiable_order->amount_paid; ?>);
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

	<?php } ?>

	$( ".button" ).each(function() {
		$(this).button();
	});

	$("#modify_order").button().attr('disabled', true);

	$("#book_confirm").change(function() {
        if ($(this).is(':checked')) {
        	$("#modify_order").button().attr('disabled', false).removeClass( 'ui-state-disabled' );
        }
	});
	
});
</script>