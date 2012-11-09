<h2>View a user's flight history</h2>



<div style="float:left">
<?php echo form_open('admin/searchOrders'); ?>
<h3>Enter search criteria</h3>
<table>
<tbody>
<tr><td><label>First Name</label></td><td><input type="text" size="20" name="first_name" id="first_name" value="" /></td></tr>
<tr><td><label>Last Name</label></td><td><input type="text" size="20" name="last_name" id="last_name" value="" /></td></tr>
<tr><td><label>Email</label></td><td><input type="text" size="20" name="email" id="email" value=""  /></td></tr>
<tr><td><label>Recent Flight Number</label></td><td><input type="text" size="20" name="flight_number" id="flight_number" value=""  /></td></tr>
<tr><td><label>Booking Confirmation Number</label></td><td><input type="text" size="20" name="booking_number" id="booking_number" value="" /></td></tr>

</tbody>
</table>
<?php echo form_submit('search_orders', 'Search'); ?>
<?php echo form_close(); ?>
</div>

<div style="float:right">
<h3>Order results</h3>
<?php if(!isset($customer_orders)) { ?>
<p>No results</p>
<?php } else { 
			foreach($customer_orders as $order) { ?>
				
			
			<? }
} ?>

<?php var_dump($account);?>
</div>
