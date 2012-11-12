<div id="manage_tabs">
	<ul>
		<li><a href="#order-tab">Tickets</a></li>
		<li><a href="#account-tab">Account</a></li>
		<li><a href="#tabs-3">Other</a></li>
	</ul>
	<div id="order-tab">
		<span style="font-weight: bold">History</span><br /><br />
		<table id="history_table" class="tablesorter">
		<thead>
			<tr>
				<th>Order #</th>
				<th>Flight #</th>
				<th>Purchase Date</th>
				<th>Seats</th>
				<th>Paid</th>
				<th>Status</th>
			</tr>
		</thead>
			
		<tbody>
		<?php foreach($orders as $order) { ?>
			<tr>
				<td><?=anchor('orders/view/'.$order->order_pk, $order->order_pk)?></td>
				<td><?=anchor('flights/view/'.$order->flight_id, $order->flight_id)?></td>
				<td><?=mdate('%m/%d/%y, %H:%i', $order->time)?></td>
				<td><?=$order->seats?></td>
				<td>$<?=$order->amount_paid?></td>
				<td><?=$order->status?></td>
			</tr>
		<?php } ?>
		
		</tbody>
		</table>
	</div>
	<div id="account-tab">
		<span style="font-weight: bold">Email:</span> <?=$account->email?><br />
		<span style="font-weight: bold">First Name:</span> <?=$account->first_name?><br />
		<span style="font-weight: bold">Last Name:</span> <?=$account->last_name?><br /><br />
		
		<span style="font-weight: bold">Change Password</span><br />
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