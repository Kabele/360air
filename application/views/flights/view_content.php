<h2>Flight Details</h2>
<div id="flight_details" class="ui-widget-content ui-corner-all">
	<span>Flight Number:</span> <?=$flight->flight_pk?><br />
	<span>From:</span> <?=$flight->depart_airport_name . ' ('.$flight->depart_airport_code.')'?><br />
	<span>To:</span> <?=$flight->arrival_airport_name . ' ('.$flight->arrival_airport_code.')'?><br />
	<span>Departure Time:</span> <?=mdate('%D, %j %M %Y @ %H:</span>%i', $flight->depart_time)?><br />
	<span>Arrival Time:</span> <?=mdate('%D, %j %M %Y @ %H:</span>%i', $flight->arrival_time)?><br />
	<span>Price:</span> $<?=$flight->ticket_price?><br />
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
		<?=anchor('orders/confirmTicket/'.$flight->flight_pk, 'Buy a Ticket', array('id' => 'buy_btn'))?>
	<?php } ?>
	
<?php } else { ?>
	
	You must be logged in to book a ticket
	
<?php } ?>
</div>