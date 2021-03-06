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
	 * @param $seats Number of seats to order
	 * @return Array with result (boolean: True if successful) and message (string) fields
	 */
	function placeOrder($account_id, $flight_id, $seats) {
		// Ensure flight still has an adequate number of seats
		$qf = $this->db->get_where('flights', array('flight_pk' => $flight_id), 1, 0);
		$flight = NULL;
		if($qf->num_rows() == 0) {
			return array('result' => FALSE, 'message' => 'Flight does not exist');
		} else {
			$flight = $qf->row(0, 'Flight');
			if(($flight->available_seats - $seats) <= 0)
				return array('result' => FALSE, 'message' => 'Flight is full. ' . $flight->available_seats . ' seats are available.');
		}
		
		// Flight must not have already departed
		if($flight->depart_time < now())
			return array('result' => FALSE, 'message' => 'Flight has already departed');
			
		// Calculate final amount paid
		$paid = $flight->ticket_price * $seats;
		
		// Insert order in table
		$od = array(
			'account_id' => $account_id,
			'time' => now(),
			'status' => 'COMPLETED',
			'amount_paid' => $paid,
			'flight_id' => $flight_id,
			'seats' => $seats);
		$this->db->insert('orders', $od);
		if($this->db->affected_rows() != 1)
			return array('result' => FALSE, 'message' => 'Could not insert order into the database');
		$order_id = $this->db->insert_id();
		
		// Decrement the number of seats on the flight by the number of seats purchased
		$flight->available_seats = $flight->available_seats - $seats;
		$this->db->where('flight_pk', $flight->flight_pk);
		$this->db->update('flights', array('available_seats' => $flight->available_seats));
		
		return array('result' => TRUE, 'order_id' => $order_id);
	}
	
	/*
	 * Checks if the account has a COMPLETED order for a particular flight ID
	 *
	 * @param $account_id ID of the account to check against
	 * @param $flight_id ID of the flight
	 * @reutrn TRUE if the account_id and flight_id exist in a COMPLETED order. FALSE if otherwise
	 */
	function hasOrder($account_id, $flight_id) {
		$this->db->where('account_id', $account_id);
		$this->db->where('flight_id', $flight_id);
		$this->db->where('status', 'COMPLETED');
		$this->db->from('orders');
		
		if($this->db->count_all_results() == 0)
			return FALSE;
		
		return TRUE;
	}
	
	/*
	 * Attempts to cancel a order
	 *
	 * @param $account_id ID of the account canceling the order (user or staff)
	 * @param $order_id ID of the order to cancel
	 * @param $reason The comment to be entered for the order modification
	 * @return TRUE if successful. FALSE if otherwise
	 */
	function cancelOrder($account_id, $order_id, $reason) {		
		// Get the order. Must be in a COMPELTED state
		$qo = $this->db->get_where('orders', array('order_pk' => $order_id, 'status' => 'COMPLETED'), 1, 0);
		if($qo->num_rows() == 0)
			return array('result' => FALSE, 'message' => 'A COMPLETED order was not found');
		$order = $qo->row();
		
		// Get the flight and make sure it hasn't already passed
		// Otherwise it doesn't make sense to cancel an order for a departed flight
		$qf = $this->db->get_where('flights', array('flight_pk' => $order->flight_id), 1, 0);
		if($qf->num_rows() == 0)
			return array('result' => FALSE, 'message' => 'Flight does not exist');
		$flight = $qf->row(0, 'Flight');
		
		// Flight must not have left
		if($flight->depart_time < now())
			return array('result' => FALSE, 'message' => 'Flight has already departed');
		
		// Update the order to a canceled status
		$this->db->where('order_pk', $order_id);
		$this->db->update('orders', array('status' => 'CANCELED'));
		
		// Insert an order modification
		$om = array(
			'time' => now(),
			'comment' => $reason,
			'order_id' => $order_id,
			'account_id' => $account_id);
		$this->db->insert('order_modifications', $om);
		
		// Increment the number of seats on the flight by the number of seats purchased
		$flight->available_seats = $flight->available_seats + $order->seats;
		$this->db->where('flight_pk', $flight->flight_pk);
		$this->db->update('flights', array('available_seats' => $flight->available_seats));
		
		return array('result' => TRUE);
	}
	
	/*
	 * Attempts to update an order
	 *
	 * @param $account_id ID of the account canceling the order (user or staff)
	 * @param $order_id ID of the order to cancel
	 * @param $reason The comment to be entered for the order modification
	 * @param $seats The number of seats the order should have after the update
	 * @param $paid The new amount paid for the order
	 * @return TRUE if successful. FALSE if otherwise
	 */
	function updateOrder($account_id, $order_id, $reason, $seats, $paid) {		
		// Get the order. Must be in a COMPELTED state
		$qo = $this->db->get_where('orders', array('order_pk' => $order_id, 'status' => 'COMPLETED'), 1, 0);
		if($qo->num_rows() == 0)
			return array('result' => FALSE, 'message' => 'A COMPLETED order was not found');
		$order = $qo->row();
		
		// Get the flight and make sure it hasn't already passed
		// Otherwise it doesn't make sense to cancel an order for a departed flight
		$qf = $this->db->get_where('flights', array('flight_pk' => $order->flight_id), 1, 0);
		if($qf->num_rows() == 0)
			return array('result' => FALSE, 'message' => 'Flight does not exist');
		$flight = $qf->row(0, 'Flight');
		
		// Make sure the flight has enough seats to accomdate the change
		$seatDifference = $order->seats - $seats;
		if($flight->available_seats < $seatDifference) {
			return array('result' => FALSE, 'message' => 'Flight does not have enough seats');
		}
		
		// Update the number of seats and amount paid
		$this->db->where('order_pk', $order_id);
		$this->db->update('orders', array('amount_paid' => $paid, 'seats' => $seats));
		
		// Insert an order modification
		$om = array(
			'time' => now(),
			'comment' => $reason,
			'order_id' => $order_id,
			'account_id' => $account_id);
		$this->db->insert('order_modifications', $om);
		
		// Update the number of seats available on the flight by the seatDifference
		$flight->available_seats = $flight->available_seats + $seatDifference;
		$this->db->where('flight_pk', $flight->flight_pk);
		$this->db->update('flights', array('available_seats' => $flight->available_seats));
		
		return array('result' => TRUE);
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
	
	/*
	 * Gets an order by its id (pk)
	 * 
	 * @param $order_id
	 * @return Row of the order
	 */
	function getOrder($orderId) {
		$query = $this->db->get_where('orders', array('order_pk' => $orderId), 1, 0);
		
		if($query->num_rows() > 0)
			return $query->row();
			
		return FALSE;
	}
}

?>