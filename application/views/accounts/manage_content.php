<div id="manage_tabs">
	<ul>
		<li><a href="#order-tab">Orders</a></li>
		<li><a href="#account-tab">Account</a></li>
		<li><a href="#tabs-3">Other</a></li>
	</ul>
	<div id="order-tab">
	<table>
	<?php foreach($orders as $order) { // Transform this into an expanded accordion with all orders ?>
		<tr><td><?=$order->order_pk?></td></tr>
	<?php } ?>
	</table>
	</div>
	<div id="account-tab">
		<h2>Account Details</h2>
		Email: <?=$account->email?><br />
		First Name: <?=$account->first_name?><br />
		Last Name: <?=$account->last_name?><br />
		<h2>Change Password</h2>
		<div class="ui-widget-content ui-corner-all">
		<?=form_open('accounts/changepw')?>
		<span style="margin: 0 5px 0 5px; float: left">Old Password</span><?=form_password(array('name' => 'old_password'))?><br />
		<span style="margin: 0 5px 0 5px; float: left">New Password</span><?=form_password(array('name' => 'new_password'))?><br />
		<span style="margin: 0 5px 0 5px; float: left">Confirm Password</span><?=form_password(array('name' => 'confirm_password'))?><br />
		<?=form_submit(array('id' => 'change', 'name' => 'change'), 'Change')?>
		<?=form_close()?>
		</div>
	</div>
	<div id="tabs-3">Other stuff?</div>
</div>