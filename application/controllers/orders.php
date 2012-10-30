<?php

/*
 * Orders page
 */
class Orders extends CI_Controller 
{
	public function __construct() {
		parent::__construct();
		
		$this->load->model('Order_model');
	}

	public function index() {
		// User must be logged in to view this page
		$this->Account_model->checkLogin();
		
		echo "A list of past orders for this account";
	}
	
	public function view($order_id) {
		// User must be logged in to view this page
		$this->Account_model->checkLogin();
	
		// View a particular order for this account
	}
	
	public function cancel($order_id) {
		// User must be logged in to view this page
		$this->Account_model->checkLogin();
	
		// Attempt to cancel an order on this account
	}
	
	public function buy_ticket($flight_id) {
		// User must be logged in to view this page
		$this->Account_model->checkLogin();
	
		// Attempt to purchase ticket for a flight on this account
	}
}

?>