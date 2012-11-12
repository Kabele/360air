<?=$this->load->view('widgets/account_info', NULL, true)?>
<h2>Ticket Options</h2>
<a id="print_btn" onclick="window.print(); return false;">Print</a>
<?=anchor('orders/cancel/'.$order->order_pk, 'Cancel', array('id' => 'cancel_btn'))?><br />
