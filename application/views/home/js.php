<script>
$(function() {
<?=$this->load->view('flights/searchbox_js', array('airports' => $airports), true)?>

<?php if(!$this->Account_model->isLoggedIn()): ?>
	// For the login widget
	$("#login").button();
<?php endif; ?>
});
</script>