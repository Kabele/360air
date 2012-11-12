<h2>Flight Details</h2>
<div id="flight_details" class="ui-widget-content ui-corner-all">
	<span>Flight Number:</span> <?=$flight->flight_pk?><br />
	<span>From:</span> <?=$flight->depart_airport_name . ' ('.$flight->depart_airport_code.')'?><br />
	<span>To:</span> <?=$flight->arrival_airport_name . ' ('.$flight->arrival_airport_code.')'?><br />
	<span>Departure Time:</span> <?=mdate('%D, %j %M %Y @ %H:%i', $flight->depart_time)?><br />
	<span>Arrival Time:</span> <?=mdate('%D, %j %M %Y @ %H:%i', $flight->arrival_time)?><br />
	<span>Price per Seat:</span> $<?=$flight->ticket_price?><br />
	<span>Total Seats:</span> <?=$flight->total_seats?><br />
	<span>Available Seats:</span> <?=$flight->available_seats?><br />
</div>

<h2>Booking Options</h2>
<div id="flight_booking" class="ui-widget-content ui-corner-all">
<?php if($this->Account_model->isLoggedIn()) { ?>

	<?php if($flight->depart_time < now()) { ?>
		This flight has already departed<br/>
	<?php } else { ?>
		There are <?=$flight->available_seats?> seats available for this flight.<br /><br />
		<?=form_open('orders/bookTicket')?>
		<?=form_hidden('flight_id', $flight->flight_pk)?>
		<span style="margin: 0 5px 0 5px; float: left">Seats</span><?=form_input(array('id' => 'seats', 'name' => 'seats', 'size' => '2'))?><br /><br />
		<span id="total" style="margin: 0 5px 0 5px; float: left">Total: $0</span><br /><br />
		<?=form_submit(array('id' => 'book', 'name' => 'book'), 'Book Ticket')?>
		<?=form_close()?>
		<script>
		// Calculate the total price based on the number of seats entered
		// Move this to js file later
		$("#seats").change(function() {
		  var seats = parseInt($("#seats").val());
		  if(isNaN(seats)) seats = 0;
		  seats = seats * <?=$flight->ticket_price?>;
		  $("#total").text("Total: $" + seats);
		  return false;
		});
		</script>
	<?php } ?>
	
<?php } else { ?>
	
	You must be logged in to book a ticket
	
<?php } ?>
</div>