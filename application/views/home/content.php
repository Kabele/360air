<?=$this->load->view('flights/searchbox_content', NULL, true)?>
		
<h2>Recently Added Flights</h2>
<div class="ui-widget-content ui-corner-all" style="margin-bottom: 20px">
<table border="0" cellspacing="1" cellpadding="2" style="width: 100%; padding:0; margin:0; ">
<thead>
<tr>
<th>Date</th>
<th>From</th>
<th>To</th>
<th>Price</th>
<th></th>
</tr>
</thead>

<tbody>		
<?php foreach($new_flights as $flt) { ?>
	<tr>
	<td><?=mdate('%m/%d/%y, %H:%i', $flt->depart_time)?></td>
	<td><?=$flt->depart_airport_code . ' - ' . $flt->depart_airport_name?></td>
	<td><?=$flt->arrival_airport_code . ' - ' . $flt->arrival_airport_name?></td>
	<td>$<?=$flt->ticket_price?></td>
	<td><a href="<?=site_url('flights/view/'.$flt->flight_pk)?>"><span class="ui-icon ui-icon-arrowthick-1-e"></span></a></td>
	</tr>
<? } ?>
</tbody>
</table>
</div>

