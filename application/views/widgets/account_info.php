<h2>Account</h2>
<div class="ui-widget-content ui-corner-all">
Welcome <?=$this->session->userdata('email')?> to 360-air.com!<br /><br />
<?=anchor('accounts/manage', 'Manage Account', array('id' => 'manage_btn'))?> 
<?=anchor('accounts/logout', 'Logout', array('id' => 'logout_btn'))?><br />
<script>
$(function() {
	$("#manage_btn").button();
	$("#logout_btn").button();
});
</script>
</div>

<div class="ui-widget-content ui-corner-all">
<?php if($this->session->userdata('is_admin') == true) {?>
<h2>Admin Pages</h2>
	<?=anchor('admin', 'Admin Flights', array('id' => 'admin_btn'))?>
	<?=anchor('admin/orders', 'Admin Orders', array('id' =>'admin_orders_btn')) ?>
	<script>
	$(function() {
		$("#admin_btn").button();
		$("#admin_orders_btn").button();
	});
	</script>
<?php } ?>
</div>