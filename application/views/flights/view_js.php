<script>
$(function() {
<?php if($this->Account_model->isLoggedIn()) { ?>
	$("#buy_btn").button();
<?php } ?>
});
</script>