<script>
$(function() {
<?=$this->load->view('flights/searchbox_js', array('airports' => $airports), true)?>

	$("#recent_table").tablesorter({
		headers: {
			// Disable sorting in the last column (the arrows)
			4: {
				sorter: false
			}
		},
		// Sort by date
		sortList: [[0,0]]
	});
});
</script>