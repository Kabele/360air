<h2>Search/Add/Update/Remove Flights</h2>

<?php echo form_open('admin/searchFlight'); ?>
Flight ID
<input type="text" size="20" name="flight_id" id="flight_id" value="<?php if($flight != NULL) echo $flight->flight_pk; else echo set_value('flight_id');?>">
<?php echo form_submit('search_flight', 'Search');?>

<?php echo form_close(); ?>

<?php echo form_open('admin/CRUDFlight'); ?>

<table>
<tbody>

<tr>
<td>&nbsp;<b>From</b></td>
<td>&nbsp;<b>To</b></td>
<td>&nbsp;<b>Class</B></td>
<td>&nbsp;<b>Price</b></td>
</tr>

<tr>
<td>
<input type="hidden" name="flight_id" value="<? if($flight != NULL) echo $flight->flight_pk; ?>" />
<input type="text" size="20" name="depart_airport_code" id="depart_airport_code" value="<?php if($flight != NULL) echo $flight->depart_airport_code; ?>">
</td>
<td>
<input type="text" size="20" name="arrival_airport_code" id="arrival_airport_code" value="<?php if($flight != NULL) echo $flight->arrival_airport_code; ?>">
</td>
<td>
<select name="flight_class" id="flight_class">
<option value="1" <?php if($flight!= NULL && $flight->class_type == "1") { ?>selected="selected" <?php }?>>Economic</option>
<option value="2" <?php if($flight!= NULL && $flight->class_type == "2") { ?>selected="selected" <?php }?>>Business</option>
</select>
</td>
<td>$&nbsp<input type="text" size="8" name="price" id="price" value="<?php if($flight != NULL) echo $flight->ticket_price; ?>"></td>
</tr>

<tr>
<td>Depart Time</td>
<td>ArrivalTime</td>
<td>Total Seats</td>
<td>Available Seats</td>
</tr>

<tr>
<td>
<input type="text" size="24" name="depart_date_picker" id="depart_date_picker" value="<?php if($flight != NULL) echo $formatted_depart;?>" />
<input type="hidden" name="depart_time" id="depart_time" value="<?php if($flight != NULL) echo $depart_time;?>" />
</td>
<td>
<input type="text" size="24" name="arrival_date_picker" id="arrival_date_picker" value="<?php if($flight != NULL) echo $formatted_arrival;?>" />
<input type="hidden" name="arrival_time" id="arrival_time" value="<?php if($flight != NULL) echo $arrival_time;?>" />
</td>
<td>
<input type="text" size="3" name="total_seats" id="total_seats" value="<?php if($flight != NULL) echo $flight->total_seats; ?>" />
</td>
<td>
<input name="available_seats" id="available_seats" readonly="readonly" type="text" size="3" value="<?php if($flight != NULL) echo $flight->available_seats; ?>" />
</tr>

<tr>

</tr>

</table>

<div id="radioset">
<input type="radio" name="operation" id="add_flight" value="add_flight">Add flight
<input type="radio" name="operation" id="update_flight" value="update_flight">Update flight
<input type="radio" name="operation" id="delete_flight" value="delete_flight">Delete flight
</div>

<div id="comment">
Reason: <br />
<textarea name="reason" id="reason"><?php echo set_value('reason')?></textarea>
</div>

<?php echo form_submit('crud_flight', 'Submit'); ?>
<?php echo form_close(); ?>