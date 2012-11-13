<script>
$(function() {
<?php echo $this->load->view('flights/searchbox_js', array('airports' => $airports), true) ?>

$("#search_results_table").tablesorter({
	headers: {
		// Disable sorting in the last column (the arrows)
		6: {
			sorter: false
		}
	},
	// Sort by Flight ID
	sortList: [[0,0]]
});

});

</script>