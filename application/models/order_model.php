<?php

class Order_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	/*
	 * Place an order for a particular flight
	 * 
	 * @param $account_id
	 * @param $flight_id
	 * @return Array with result (boolean: True if successful) and message (string) fields
	 */
	function placeOrder($account_id, $flight_id) {
		// Ensure flight still has an adequate number of seats
		$qf = $this->db->get_where('flights', array('flight_pk' => $flight_id), 1, 0);
		$flight = NULL;
		if($qf->num_rows() == 0) {
			return array('result' => FALSE, 'message' => 'Flight does not exist');
		} else {
			$flight = $query->row(0, 'Flight');
			if($flight->available_seats <= 0)
				return array('result' => FALSE, 'message' => 'Flight is full');
		}
		
		// Insert order in table
		$tm = now();
		$od = array(
			'account_id' => $account_id,
			'time' => $tm,
			'status' => 'COMPLETED',
			'amount_paid' => $flight->ticket_price,
			'flight_id' => $flight_id);
		$this->db->insert('orders', $od);
		if($this->db->affected_rows() != 1)
			return array('result' => FALSE, 'message' => 'Could not insert order into the database');
			
		// Insert an order modification
		$om = array(
			'time' => $tm,
			'comment' => 'Created',
			'account_id' => $account_id);
		$this->db->insert('order_modifications', $om);
		
		// Decrement the number of seats on the flight by 1
		$flight->available_seats--;
		$this->db->where('flight_pk', $flight->flight_pk);
		$this->db->update('flights', array('available_seats' => $flight->available_seats));
		
		return array('result' => TRUE, 'message' => 'Order complete');
	}
	
	/*
	 * Attempts to cancel a order
	 *
	 * @param $order_id ID of the order to cancel
	 * @param $account_id ID of the account canceling the order (user or staff)
	 * @return TRUE if successful. FALSE if otherwise
	 */
	function cancelOrder($order_id, $account_id) {		
		// Get the order
		$qo = $this->db->get_where('orders', array('order_pk' => $order_id), 1, 0);
		if($qo->num_rows() == 0)
			return FALSE;
		$order = $qo->row()->flight_id;
		
		// Ensure the account attempting to cancel is the user that placed the order or is an admin with proper access
		if($order->account_id != $account_id) {
			if(!accountHasPermission($account_id, 'admin_orders'))
				return FALSE;
		}
		
		// Get the flight and make sure it hasn't already passed
		// Otherwise it doesn't make sense to cancel an order for a departed flight
		$qf = $this->db->get_where('flights', array('flight_pk' => $order->flight_id), 1, 0);
		if($qf->num_rows() == 0)
			return FALSE;
		$flight = $qf->row(0, 'Flight');
		
		if($qf->depart_time < now())
			return FALSE;
		
		// Update the order to a canceled status
		$this->db->where('order_pk', $order_id);
		$this->db->update('orders', 'status' => 'CANCELED');
		
		// Insert an order modification
		$om = array(
			'time' => $tm,
			'comment' => 'Canceled',
			'account_id' => $account_id);
		$this->db->insert('order_modifications', $om);
		
		// Increment the number of seats on the flight by 1
		$flight->available_seats++;
		$this->db->where('flight_pk', $flight->flight_pk);
		$this->db->update('flights', array('available_seats' => $flight->available_seats));
		
		return TRUE;
	}
	
	/*
	 * List orders owned by an account id
	 *
	 * @param $account_id Account that owns the orders
	 * @return Array of order objects. Empty array if nothing
	 */
	function listOrders($account_id) {
		$query = $this->db->get_where('orders', array('account_id' => $account_id));
		return $query->result();
	}
}

?>