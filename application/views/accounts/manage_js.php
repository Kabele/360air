<script>
$(function() {
	$("#manage_tabs").tabs();
	$("#change_btn").button();
	$("#history_table").tablesorter({
		// Sort by purchase date
		sortList: [[2,0]]
	});
});
</script>