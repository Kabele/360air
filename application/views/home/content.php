<body bgcolor="#8F8B8B" text="#000" link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF" topmargin="4">
<center>
<br></br><br></br>
<?php $this->load->helper('form'); ?>
<?php echo form_open(''); ?>

<table width="900"  border="0" bgcolor="#FFFFFF" cellspacing="1" cellpadding="2" style="padding:0; margin:0; ">
<tbody>

<tr>
<td width="100%" colSpan="4" style="padding:0; margin:0; " height="100%" bgcolor="#FFFFFF">
</td>
</tr>

<tr>
<td>&nbsp;<b>From:</b></td>
<td>&nbsp;<b>To:</b></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

<tr>
<td>
<input type="text" size="20" name="from" id="from" class="autocomplete" value="<?php echo set_value('from');?>" />
</td>
<td>
<input type="text" size="20" name="to" id="to" class="autocomplete" value="<?php echo set_value('to');?>" />
</td>
<!--  Disabling until we figure out how to handle this <td>
<center><select name="trip_type" id="trip_type">
<option value="1" <?php echo set_select('trip_type','1');?>>One-way</option>
<option value="2" <?php echo set_select('trip_type','2');?>>Round Trip</option>
</select></center>
</td>
-->
<td>
<center><select name="is_domestic" id="is_domestic">
<option value="1" <?php echo set_select('flight_class',1);?>>Domestic</option>
<option value="0" <?php echo set_select('flight_class',0);?>>International</option>
</select></center>
</td>

<td>
<center><select name="flight_class" id="flight_class">
<option value="<?php echo FLIGHT_TYPE_COACH; ?>" <?php echo set_select('flight_class',FLIGHT_TYPE_COACH);?>>Economic</option>
<option value="<?php echo FLIGHT_TYPE_BUSINESS; ?>" <?php echo set_select('flight_class', FLIGHT_TYPE_BUSINESS);?>>Business</option>
</select></center>
</td>
</tr>

<tr><td>&nbsp;</td></tr>

</table>

<table width="900" border="0" bgcolor="#FFFFFF" cellspacing="1" cellpadding="2" style="padding:0; margin:0; ">
<tbody>
<tr>
<td>&nbsp;<b>Departure Date:</b></td>
<td>&nbsp;</td>
<td>&nbsp;<b>Arrival Date:</b></td>
<td>&nbsp;</td>
</tr>

<tr>
<td>
From: <input type="text" size="20" name="depart_date_start_picker" id="depart_date_start_picker" value="<?php echo set_value('depart_date_start_picker');?>" />
<input type="hidden" name="depart_date_start" id="depart_date_start" value="<?php echo set_value('depart_date_start');?>" />
</td>
<td>
To: <input type="text" size="20" name="depart_date_end_picker" id="depart_date_end_picker" value="<?php echo set_value('depart_date_end_picker');?>" />
<input type="hidden" name="depart_date_end" id="depart_date_end" value="<?php echo set_value('depart_date_end');?>" />
</td>
				
<td>
From: <input type="text" size="20" name="arrival_date_start_picker" id="arrival_date_start_picker" value="<?php echo set_value('arrival_date_start_picker');?>" />
<input type="hidden" name="arrival_date_start" id="arrival_date_start" value="<?php echo set_value('arrival_date_start');?>" />
</td>
<td>
To: <input type="text" size="20" name="arrival_date_end_picker" id="arrival_date_end_picker" value="<?php echo set_value('arrival_date_end_picker');?>" />
<input type="hidden" name="arrival_date_end" id="arrival_date_end" value="<?php echo set_value('arrival_date_end');?>" />
</td>
</tr>

				<tr><td>&nbsp;</td></tr>
				
</table>

<table width="900" border="0" bgcolor="#FFFFFF" cellspacing="1" cellpadding="2" style="padding:0; margin:0; ">
<tbody>
<tr>
<td width="100%" colSpan="9" style="padding:0; margin:0; " height="100%" bgcolor="#FFFFFF">
</tr>
<tr>
<td>Adults (12+)</td>
<td>
<select id="passenger_number" name="passenger_adult">
						<option value="0" <?php echo set_select('passenger_adult','0');?>>0</option>
                        <option value="1" <?php echo set_select('passenger_adult','1');?>>1</option>
                        <option value="2" <?php echo set_select('passenger_adult','2');?>>2</option>
                        <option value="3" <?php echo set_select('passenger_adult','3');?>>3</option>
                        <option value="4" <?php echo set_select('passenger_adult','4');?>>4</option>
                        <option value="5" <?php echo set_select('passenger_adult','5');?>>5</option>
                        <option value="6" <?php echo set_select('passenger_adult','6');?>>6</option>
                </select>
				</td>
<td>Children (2-11)</td>
<td>
<select id="passenger_number" name="passenger_children">
                        <option value="0" <?php echo set_select('passenger_children','0');?>>0</option>
                        <option value="1" <?php echo set_select('passenger_children','1');?>>1</option>
                        <option value="2" <?php echo set_select('passenger_children','2');?>>2</option>
                        <option value="3" <?php echo set_select('passenger_children','3');?>>3</option>
                        <option value="4" <?php echo set_select('passenger_children','4');?>>4</option>
                </select>
				</td>	
<td>Infants (under 2)</td>
<td>
<select id="passenger_number" name="passenger_infant">
                        <option value="0" <?php echo set_select('passenger_infant','0');?>>0</option>
                        <option value="1" <?php echo set_select('passenger_infant','1');?>>1</option>
                        <option value="2" <?php echo set_select('passenger_infant','2');?>>2</option>
                        <option value="3" <?php echo set_select('passenger_infant','3');?>>3</option>
                </select>
				</td>
				</tr>		
				
				
				<tr><td>&nbsp;</td></tr>

</table>

<?php echo form_submit('submit', 'Search!');?>

<?php echo form_close(); ?>
				
				<br></br>
		
<h2>Search Results</h2>
<?php var_dump($search_results); ?>
		
		
<h2>Recently Added Flights</h2>
<table width="900" border="0" bgcolor="#FFFFFF" cellspacing="1" cellpadding="2" style="padding:0; margin:0; ">
<thead>
<tr>
<th>Date</th>
<th>From</th>
<th>To</th>
<th>Price</th>
</tr>
</thead>

<tbody>		
<?php foreach($new_flights as $flt) { ?>
	<tr>
	<td><? echo $flt->depart_time; ?></td>
	<td><? echo $flt->depart_airport_code . '(' . $flt->depart_airport_name . ')';?></td>
	<td><? echo $flt->arrival_airport_code . '(' . $flt->arrival_airport_name . ')';?></td>
	<td><? echo $flt->ticket_price; ?></td>
<? } ?>
</tbody>
</table></center>
