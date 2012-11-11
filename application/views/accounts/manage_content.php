<div id="manage_tabs">
	<ul>
		<li><a href="#order-tab">Orders</a></li>
		<li><a href="#account-tab">Account</a></li>
		<li><a href="#tabs-3">Other</a></li>
	</ul>
	<div id="order-tab">
	<table>
	<?php foreach($orders as $order) { // Transform this into an expanded accordion with all orders ?>
		<tr>
			<td>Order No.</td>
			<td>Time</td>
			<td>Paid</td>
			<td>Status</td>
		</tr>
		<tr>
			<td><?=anchor('orders/view/'.$order->order_pk, $order->order_pk)?></td>
			<td><?=$order->time?></td>
			<td><?=$order->amount_paid?></td>
			<td><?=$order->status?></td>
		</tr>
	<?php } ?>
	</table>
	</div>
	<div id="account-tab">
		<h2>Account Details</h2>
		<div class="ui-widget-content ui-corner-all">
			<span style="font-weight: bold">Email:</span> <?=$account->email?><br />
			<span style="font-weight: bold">First Name:</span> <?=$account->first_name?><br />
			<span style="font-weight: bold">Last Name:</span> <?=$account->last_name?><br />
		</div>
		
		<h2>Change Password</h2>
		<div class="ui-widget-content ui-corner-all">
			<?=form_open('accounts/changepw')?>
			<span style="margin: 0 5px 0 5px; float: left">Old Password</span><?=form_password(array('name' => 'old_password'))?><br />
			<span style="margin: 0 5px 0 5px; float: left">New Password</span><?=form_password(array('name' => 'new_password'))?><br />
			<span style="margin: 0 5px 0 5px; float: left">Confirm Password</span><?=form_password(array('name' => 'confirm_password'))?><br />
			<?=form_submit(array('id' => 'change_btn', 'name' => 'change'), 'Change')?>
			<?=form_close()?>
		</div>
	</div>
	<div id="tabs-3">Other stuff?</div>
</div>