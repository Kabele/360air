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