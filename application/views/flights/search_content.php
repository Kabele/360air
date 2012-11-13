<?=$this->load->view('flights/searchbox_content', NULL, true)?>

<h2>Search Results</h2>
<?php if(isset($search_results) && $search_results != NULL) { ?>

	<?php //var_dump($search_results); ?>
	
	<table id="search_results_table" class="tablesorter"><thead>
	<tr><th>Flight #</th><th>From</th><th>To</th><th>Departs</th><th>Arrives</th><th>Price</th><th>View</th></tr>
	</thead>
	<tbody>
		
	<?php foreach($search_results as $flight) { ?>
		<tr>
		<td><?=$flight->flight_pk; ?></td>
		<td><?=$flight->depart_airport_code . ' - ' . $flight->depart_airport_name?></td>
		<td><?=$flight->arrival_airport_code . ' - ' . $flight->arrival_airport_name?></td>
		<td><?=mdate('%m/%d/%y, %H:%i', $flight->depart_time)?></td>
		<td><?=mdate('%m/%d/%y, %H:%i', $flight->arrival_time)?></td>
		<td>$<?=$flight->ticket_price; ?></td>
		<td><a href="<?=site_url('flights/view/'.$flight->flight_pk)?>"><span class="ui-icon ui-icon-arrowthick-1-e"></span></a></td>
		</tr>	
		
	<?php }?>
	</tbody>
	</table>
<?php } else { ?>
	No results found
<?php } ?>