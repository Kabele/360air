<?php

/*
 * Orders page
 */
class Orders extends CI_Controller 
{
	public function __construct() {
		parent::__construct();
		
		$this->load->model('Order_model');
		$this->load->model('Flight_model');
	}

	public function index() {
		// User must be logged in to view this page
		$this->Account_model->checkLogin();
		
		echo "A list of past orders for this account";
	}
	
	/*
	 * Display a page detailing an order belonging to the currently logged in account
	 *
	 * @param order_id ID of the order to view
	 */
	public function view($order_id) {
		// User must be logged in to view this page
		$this->Account_model->checkLogin();
		
		// Get order object and ensure its for this account
		$order = $this->Order_model->getOrder($order_id);
		if($order == NULL || ($order->account_id != $this->session->userdata('account_id'))) {
			$this->session->set_flashdata('error_message', 'Order is not valid or does not belong to this account');
			redirect('orders');
			return;
		}
		
		// Get the flight data
		$flight = $this->Flight_model->getFlight($order->flight_id);
		if($flight == NULL) {
			$this->session->set_flashdata('error_message', 'Flight referenced in the order is not valid');
			redirect('orders');
			return;
		}
		
		$data = array('flight' => $flight, 'order' => $order);
		
		// View a details for an order on the currently logged in account
		$page_data['css'] = $this->load->view('orders/view_style.css', NULL, true);
		$page_data['js'] = $this->load->view('orders/view_js', '', true);
		$page_data['content'] = $this->load->view('orders/view_content', $data, true);
		$page_data['widgets'] = $this->load->view('orders/view_widgets', $data, true);
		
		// Send page data to the site_main and have it rendered
		$this->load->view('site_main', $page_data);
	}
	
	/*
	 * Process a order cancelation request
	 * The request will be fulfilled if the user reqesting it is authorized, the flight hasn't left, and hasn't already been canceled
	 *
	 * @param $order_id ID of the order to cancel
	 */
	public function cancel($order_id) {
		// User must be logged initiate this action
		$this->Account_model->checkLogin();
	
		// Attempt to cancel an order on this account
		if($this->Order_model->cancelOrder($this->session->userdata('account_id'), $order_id)) {
			$this->session->set_flashdata('status_message', 'Order has been canceled successfully');
			redirect('orders/view/'.$order_id);
		} else {
			$this->session->set_flashdata('error_message', 'Unable to cancel the order');
			redirect('orders/view/'.$order_id);
		}
	}
	
	/*
	 * Confirmation page where the user can select the number of seats, view, and choose to finalize a booking
	 */
	public function confirmTicket($flight_id) {
		// User must be logged in to view this page
		$this->Account_model->checkLogin();
		
		
	}
	
	/*
	 * Process a flight booking attempt by the user and redirect to the order view page if successful
	 * If the booking fails, set the error_message and redirect to the confim page
	 */
	public function bookTicket($flight_id) {
		// User must be logged in to initate this action
		$this->Account_model->checkLogin();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('seats', 'Seats', 'trim|required|is_natural_no_zero|xss_clean|prep_for_form');
			
		if(!$this->input->post('book') || !$this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_message', validation_errors());
			redirect('orders/confirmTicket/'.$flight_id);
			return;
		}
		
		// User must not already have a ticket for the flight
		if($this->Order_model->hasOrder($this->session->userdata('account_id'), $flight_id)) {
			$this->session->set_flashdata('error_message', 'You already have an open ticket for the flight');
			redirect('orders/confirmTicket/'.$flight_id);
			return;
		}
			
		// Attempt to purchase ticket for a flight on this account
		$book_res = $this->Order_model->placeOrder($this->session->userdata('account_id'), $flight_id, $this->input->post('seats'));
		if($book_res['result'] == FALSE) {
			$this->session->set_flashdata('error_message', $book_res['message']);
			redirect('orders/confirmTicket/'.$flight_id);
			return;
		}
		
		// Redirect to the order view
		$this->session->set_flashdata('status_message', 'Ticket booked successfully!');
		redirect('orders/view/'.$book_res['order_id']);
	}
}

?>