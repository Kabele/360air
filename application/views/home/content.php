<?=$this->load->view('flights/searchbox_content', NULL, true)?>
		
<h2>Recently Added Flights</h2>
<div class="ui-widget-content ui-corner-all" style="margin-bottom: 20px">
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
</table>
</div>

