<script>
$(function() {
<?php if($this->Account_model->isLoggedIn()) { ?>

	$("#book").button();
<?php } ?>
});
</script>