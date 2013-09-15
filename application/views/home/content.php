<?=$this->load->view('flights/searchbox_content', NULL, true)?>
		
<h2>Recently Added Flights</h2>
<table id="recent_table" class="tablesorter">
<thead>
<tr>
	<th>Date</th>
	<th>From</th>
	<th>To</th>
	<th>Price</th>
	<th>View</th>
</tr>
</thead>

<tbody>		
<?php foreach($new_flights as $flt) { ?>
	<tr>
	<td><?=mdate('%m/%d/%y, %H:%i', $flt->depart_time)?></td>
	<td><?=$flt->depart_airport_code . ' - ' . $flt->depart_airport_name?></td>
	<td><?=$flt->arrival_airport_code . ' - ' . $flt->arrival_airport_name?></td>
	<td>$<?=$flt->ticket_price?></td>
	<td><a href="<?=base_url('flights/view/'.$flt->flight_pk)?>"><span class="ui-icon ui-icon-arrowthick-1-e"></span></a></td>
	</tr>
<?php } ?>
</tbody>
</table>

