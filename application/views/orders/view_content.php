<h2><?=$flight->depart_airport_name . ' ('.$flight->depart_airport_code.')'?> -> <?=$flight->arrival_airport_name . ' ('.$flight->arrival_airport_code.')'?> on <?=mdate('%D, %j %M %Y @ %H:%i', $flight->depart_time)?></h2>
<div id="view_accordion">
	<h3>Ticket Details</h3>
	<div>
		<span>Order Number:</span> <?=$order->order_pk?><br />
		<span>Purchase Date:</span> <?=mdate('%m/%d/%y, %H:%i', $order->time)?><br />
		<span>Status:</span> <?=$order->status?><br />
		<span>Passenger:</span> <?=$order->account_id?><br />
		<span>Seats:</span> <?=$order->seats?><br />
		<span>Class:</span><br />
		<span>Paid:</span> $<?=$order->amount_paid?><br />
	</div>
	<h3>Flight Details</h3>
	<div>
		<span>Flight Number:</span> <?=$flight->flight_pk?><br />
		<span>From:</span> <?=$flight->depart_airport_name . ' ('.$flight->depart_airport_code.')'?><br />
		<span>To:</span> <?=$flight->arrival_airport_name . ' ('.$flight->arrival_airport_code.')'?><br />
		<span>Departure Time:</span> <?=mdate('%D, %j %M %Y @ %H:%i', $flight->depart_time)?><br />
		<span>Arrival Time:</span> <?=mdate('%D, %j %M %Y @ %H:%i', $flight->arrival_time)?><br />
		<span>Price per Seat:</span> $<?=$flight->ticket_price?><br />
	</div>
</div>