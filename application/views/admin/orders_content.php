<div id="#flight_history" style="width:100%;float:left">
<h2>View a user's flight history</h2>
<div style="float:left;width:40%;">
<?php echo form_open('admin/listOrders'); ?>
<h3>Enter search criteria</h3>
<table>
<tbody>
<tr><td><label>First Name</label></td><td><input type="text" size="20" name="first_name" id="first_name" value="<?php echo set_value('first_name');?>" /></td></tr>
<tr><td><label>Last Name</label></td><td><input type="text" size="20" name="last_name" id="last_name" value="<?php echo set_value('last_name'); ?>" /></td></tr>
<tr><td><label>Email</label></td><td><input type="text" size="20" name="email" id="email" value="<?php echo set_value('email'); ?>"  /></td></tr>
<tr><td><label>Recent Flight Number</label></td><td><input type="text" size="20" name="flight_number" id="flight_number" value="<?php echo set_value('flight_number'); ?>"  /></td></tr>
<tr><td><label>Booking Confirmation Number</label></td><td><input type="text" size="20" name="booking_number" id="booking_number" value="<?php echo set_value('booking_number'); ?>" /></td></tr>

</tbody>
</table>
<?php echo form_submit('list_orders', 'Search', 'class="button"'); ?><?php echo form_submit('search_booking', 'Modify ', 'class="button"'); ?>
<?php echo form_close(); ?>
</div>

<div style="float:right;width:60%;">
<h3>Booking Information to Modify</h3>
<?php if(!isset($customer_orders)) { ?>
<p>No results</p>
<?php } else { ?>
	<table>
	<thead><tr><td>Order ID</td><td>Time</td><td>Status</td><td>Paid</td><td>Flight ID</td></tr></thead>
	<tbody>
	<?php foreach($customer_orders as $order) { ?>
		<tr><td><?php echo $order->order_pk; ?></td><td><?php echo unix_to_human($order->time);?></td><td><?php echo $order->status; ?></td><td><?php echo $order->amount_paid;?></td><td><?php echo $order->flight_id; ?></td></tr>	
			
	<? } ?>
	</tbody>
	</table>
<?} ?>
</div>
</div>

<hr />

<div style="float:left;width:60%;">
<h3>Order results</h3>
<?php if(!isset($modifiable_order)) { ?>
<p>No results</p>
<?php } else { ?>
	<?php echo form_open('admin/modifyOrder');?>
	<div id="radioset">
	<input type="radio" name="operation" id="cancel_order" value="cancel_order">Cancel Order
	<input type="radio" name="operation" id="update_order" value="update_order">Update Order
	</div>
	<table>
	<thead><tr><td>Order ID</td><td>Time</td><td>Status</td><td>Seats Booked</td><td>Price</td><td>Flight ID</td></tr></thead>
	<tbody>
	<tr>
	<td><?php echo $modifiable_order->order_pk; ?><input type="hidden" name="order_id" value="<?php echo $modifiable_order->order_pk; ?>" /></td>
	<td><?php echo unix_to_human($modifiable_order->time);?></td>
	<td><?php echo $modifiable_order->status; ?></td>
	<td><input type="text" size="3" name="booked_seats" id="booked_seats" value="<?php echo $modifiable_order->seats; ?>" /></td>
	<td><input type="text" name="amount_paid" id="amount_paid" value="<?php echo $modifiable_order->amount_paid;?>"  /></td>
	<td><?php echo $modifiable_order->flight_id; ?></td></tr>	
	</tbody>
	</table>
	Suggested price: <span id="suggested_price"><?php echo $modifiable_order->amount_paid; ?></span><br />
	Reason: <br />
	<textarea name="reason" id="reason"><?php echo set_value('reason')?></textarea><br />
	<input type="checkbox" id="book_confirm">Confirm Values<br />
	<?php echo form_submit('modify_order', 'Update', 'id="modify_order"'); ?>
	<?php echo form_close(); ?>
<?} ?>
</div>
