<?php

/*
 * Admin Controller
 */
class Admin extends CI_Controller 
{		
	// Admin class constructor
	public function __construct() {
		parent::__construct();
		
		$this->load->model('Flight_model');
		$this->load->model('Account_model');
		$this->load->model('Order_model');
		
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
		
		date_default_timezone_set('UTC');
	}

	public function index() {
		$this->isAdmin();
		$data['flight'] = NULL;
		
		// Load template components (all are optional)
		$page_data['css'] = $this->load->view('admin/flights_style.css', NULL, true);
		$page_data['js'] = $this->load->view('admin/flights_js', NULL, true);
		$page_data['content'] = $this->load->view('admin/flights_content', $data, true);
		$page_data['widgets'] = $this->load->view('admin/flights_widgets', NULL, true);
		
		// Send page data to the site_main and have it rendered
		$this->load->view('site_main', $page_data);
	}
	
	public function searchFlight() {
		$this->isAdmin();
		// Check for admin privilages
		if($this->input->post('search_flight')) {
			// Validation rules
			$this->form_validation->set_rules('flight_id', 'Flight ID', 'trim|required|numeric');
			
			if($this->form_validation->run() == FALSE) {
				$data['flight'] = NULL;
				$data['error_message'] = validation_errors();
			} else {
				$flt = $this->Flight_model->getFlight($this->input->post('flight_id'));
				$data['flight'] = $flt;
				if($flt != NULL) {
					$data['formatted_depart'] = date('m/d/Y h:i a', $flt->depart_time);
					$data['formatted_arrival'] = date('m/d/Y h:i a', $flt->arrival_time);
					$data['depart_time'] = date('Y-m-d h:i:s A', $flt->depart_time);
					$data['arrival_time'] = date('Y-m-d h:i:s A', $flt->arrival_time);
				} else {
					$data['status_message'] = 'Flight not found';
				}
			}
					
			// Load template components (all are optional)
			$page_data['css'] = $this->load->view('admin/flights_style.css', NULL, true);
			$page_data['js'] = $this->load->view('admin/flights_js', NULL, true);
			$page_data['content'] = $this->load->view('admin/flights_content', $data, true);
			$page_data['widgets'] = $this->load->view('admin/flights_widgets', NULL, true);
			
			// Send page data to the site_main and have it rendered
			$this->load->view('site_main', $page_data);
		}
	}

	
	// Scheduling, Updating, Cancelling flights
	public function CRUDFlight() {
		$this->isAdmin();
		if($this->input->post('crud_flight')) {
			$oper = $this->input->post('operation');
			
			// Validation rules (Everything is required)
			$this->form_validation->set_rules('arrival_airport_code', 'Arrival Airport Code', 'trim|alpha_numeric|required|callback_check_airport_code');
			$this->form_validation->set_rules('depart_airport_code', 'Depart Airport Code', 'trim|alpha_numeric|required|callback_check_airport_code');
			$this->form_validation->set_rules('arrival_time', 'Arrival Time', 'required|prep_for_form');
			$this->form_validation->set_rules('depart_time', 'Depart Time', 'required|prep_for_form');
			$this->form_validation->set_rules('available_seats', 'Available Seats', 'is_natural');
			$this->form_validation->set_rules('total_seats', 'Total Seats', 'required|is_natural_no_zero|greater_than_equal_to[available_seats]');
			$this->form_validation->set_rules('flight_class', 'Flight Class', 'required');
			$this->form_validation->set_rules('price', 'Ticket Price', 'required|numeric|greater_than[0]');
			$this->form_validation->set_rules('operation', 'Add/Update/Delete', 'required');
			if($oper == 'update_flight' || $oper == 'delete_flight') {
				$this->form_validation->set_rules('reason', 'Reason', 'required|prep_for_form');
			}
			
			// Build the flight object
			$flt = new Flight();
			$flt->flight_pk = $this->input->post('flight_id');
			$flt->arrival_airport_code = $this->input->post('arrival_airport_code');
			$flt->arrival_airport_id = $this->Flight_model->airportCodeToId($flt->arrival_airport_code);
			$flt->depart_airport_code = $this->input->post('depart_airport_code');
			$flt->depart_airport_id = $this->Flight_model->airportCodeToId($flt->depart_airport_code);
			$flt->arrival_time = human_to_unix($this->input->post('arrival_time'));
			$flt->depart_time = human_to_unix($this->input->post('depart_time'));
			$flt->total_seats = $this->input->post('total_seats');
			$flt->available_seats = $this->input->post('available_seats');
			$flt->class_type = $this->input->post('flight_class');
			$flt->ticket_price = $this->input->post('price');
			
			// Set the date data
			$data['formatted_depart'] = date('m/d/Y h:i a', $flt->depart_time);
			$data['formatted_arrival'] = date('m/d/Y h:i a', $flt->arrival_time);
			$data['depart_time'] = date('Y-m-d h:i:s A', $flt->depart_time);
			$data['arrival_time'] = date('Y-m-d h:i:s A', $flt->arrival_time);
			
			if($this->form_validation->run() == FALSE) {
				$data['flight'] = $flt;
				$data['error_message'] = validation_errors();
			} else {
				// Adding a flight
				if($oper == 'add_flight') {
					
					// Use the total seats as avaialble seats
					$flt->available_seats = $flt->total_seats;
					
					$result = $this->Flight_model->addFlight($flt);			
					if($result != -1) {
						$flt->flight_pk = $result;
						$data['status_message'] = 'Flight number ' . $result . ' scheduled';
					} else {
						$data['status_message'] = 'Flight could not be scheduled';
					}
					
					// Populate all the fields with the data from the form
					$data['flight'] = $flt;				
					
					
				// Updating a flight
				} else if($oper == 'update_flight') {
					
					$result = $this->Flight_model->updateFlight($flt, $this->input->post('reason'), $this->getUserId());
					if($result != -1) {
						$flt->flight_pk = $result;
						$data['status_message'] =  'Flight number ' . $result . ' updated';
					} else {
						$data['status_message'] =  'Flight number ' . $flt->flight_pk . ' could not be updated';
					}
					// Populate all the fields with the data from the form
					$data['flight'] = $flt;
				
				// Deleting a flight
				} else if($oper == 'delete_flight') {
					
					// Check to make sure the flight is "empty"
					if($flt->available_seats != $flt->total_seats) {
						$data['error_message'] = 'Cannot cancel a flight with booked seats';
						$data['flight'] = $flt;
					} else {
					
						$result = $this->Flight_model->removeFlight($flt, $this->input->post('reason'), $this->getUserId());
						if($result != FALSE) {
							$data['status_message'] =  'Flight number ' . $flt->flight_pk . ' removed';
						} else {
							$data['status_message'] =  'Flight number ' . $flt->flight_pk . ' could not be removed';
						}
						// Empty all fields
						$data['flight'] = NULL;
					}
				} else {
					$data['error_message'] = 'Invalid option';
					$data['flight'] = NULL;
				}
			}
			
			// Load template components (all are optional)
			$page_data['css'] = $this->load->view('admin/flights_style.css', NULL, true);
			$page_data['js'] = $this->load->view('admin/flights_js', NULL, true);
			$page_data['content'] = $this->load->view('admin/flights_content', $data, true);
			$page_data['widgets'] = $this->load->view('admin/flights_widgets', NULL, true);
			
			// Send page data to the site_main and have it rendered
			$this->load->view('site_main', $page_data);
				
		}
	}
	
	public function orders() {
		$this->isAdmin();
		
		$data = NULL;
		
		// Load template components (all are optional)
		$page_data['css'] = $this->load->view('admin/orders_style.css', NULL, true);
		$page_data['js'] = $this->load->view('admin/orders_js', $data, true);
		$page_data['content'] = $this->load->view('admin/orders_content', $data, true);
		$page_data['widgets'] = $this->load->view('admin/flights_widgets', NULL, true);
		
		// Send page data to the site_main and have it rendered
		$this->load->view('site_main', $page_data);
	}
	
	public function listOrders() {
		$this->isAdmin();
		
		if($this->input->post()) {
			
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|prep_for_form');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|prep_for_form');
			$this->form_validation->set_rules('email', 'Email', 'valid_email|prep_for_form');
			$this->form_validation->set_rules('flight_number', 'Flight Number', 'numeric');
			$this->form_validation->set_rules('booking_number', 'Booking Confirmation Number', 'numeric');
			
			if($this->form_validation->run() == FALSE) {
				$data['error_message'] = validation_errors();
			} else {
			
			
				$firstName = $this->input->post('first_name');
				$lastName = $this->input->post('last_name');
				$email = $this->input->post('email');
				$flightId = $this->input->post('flight_number');
				$orderId = $this->input->post('booking_number');
				
				$criteriaCount = 0;
				$account = NULL;
				$continue = TRUE;				
				
				// Use the name to get the account if available
				if($firstName != NULL && $lastName != NULL) {
					// Search for account by name
					$account = $this->Account_model->getAccountByName($firstName, $lastName);
					if($account != NULL)
						$criteriaCount++;
				}
				
				// Use the email to verify the account or get it
				if($email != NULL) {
					// See if the email matches an account already searched
					if($account != NULL) {
						if(strcasecmp($account->email,$email) != 0) {
							$data['error_message'] = 'Criteria do not match';
							$continue = FALSE;
						} else {
							$criteriaCount++;
						}
					} else {
						// Search the account by email
						$account = $this->Account_model->getAccountByEmail($email);
						if($account != NULL)
							$criteriaCount++;
					}
				}
				
				// User the orderId to verify the account or get it
				if($continue && $orderId != NULL) {
					// Search for account by order id
					$order = $this->Order_model->getOrder($orderId);
					if($order == NULL) {
						$data['error_message'] = 'Could not find an order with the given Booking Number';
						$continue = FALSE;
					} else {				
						if($account != NULL) {
							if($account->account_pk != $order->account_id) {
								$data['error_message'] = 'Criteria do not match';
								$continue = FALSE;
							} else {
								$criteriaCount++;
								$modifiable_order = $order;
							}
						} else {							
							$account = $this->Account_model->getAccount($order->account_id);
							if($account != NULL) {
								$criteriaCount++;
								$modifiable_order = $order;
							}
						}
					}
				}
				
				// By this point we should have an account
				// Check to see if the flightId provided generated any orders with a matching account
				if($continue && $account != NULL && $flightId != NULL) {
					// Get the orders associated with the account
					$orders = $this->Order_model->listOrders($account->account_pk);
					if($orders == NULL) {
						$data['error_message'] = 'Could not find an order matching the flight number';
						$continue = FALSE;
					} else {
						// Search for an order with the flightId
						$flag = false;
						foreach($orders as $ord) {			
							if($ord->flight_id == $flightId) {
								if(isset($order) && $order != NULL) {
									if($ord->order_pk == $order->order_pk) {
										$modifiable_order = $ord;
										$flag = true;
									}
								} else {
									$modifiable_order = $ord;
									$flag = true;
								}
							}
							
						}
						if($flag) {
							$criteriaCount++;
						} else {
							$data['error_message'] = 'Criteria do not match';
							$continue = FALSE;
						}
					}
				}
				
				if($this->input->post('list_orders')) {
				
					if($continue && $criteriaCount < 2) {
						$data['error_message'] = 'Must enter at least 2 search criteria';
						$continue = FALSE;
					}
				
					if($continue) {
						
						// Get the orders for this account
						$orders = $this->Order_model->listOrders($account->account_pk);
						$data['customer_orders'] = $orders;
						
					}
						
				} else if($this->input->post('search_booking'))	{
					
					// Get the orders for this account (for convenience)
					$orders = $this->Order_model->listOrders($account->account_pk);
					$data['customer_orders'] = $orders;
					
					if($continue && $criteriaCount < 3) {
						$data['error_message'] = 'Must enter at least 3 search criteria';
						$continue = FALSE;
					}
				
					if($continue) {						
						// Set the modifiable order that was found earlier
						$data['modifiable_order'] = $modifiable_order;		

						// Get the flight info for this order so it can be used to suggest a price
						$flt_data = $this->Flight_model->getFlight($modifiable_order->flight_id);
						$data['modifiable_order_flight_data'] = $flt_data;

					}
					
				}
								
			}			
			
			$data['account'] = $account;
		
			// Load template components (all are optional)
			$page_data['css'] = $this->load->view('admin/orders_style.css', NULL, true);
			$page_data['js'] = $this->load->view('admin/orders_js', $data, true);
			$page_data['content'] = $this->load->view('admin/orders_content', $data, true);
			$page_data['widgets'] = $this->load->view('admin/flights_widgets', NULL, true);
			
			// Send page data to the site_main and have it rendered
			$this->load->view('site_main', $page_data);
		}
	}
	
	public function modifyOrder() {
		$this->isAdmin();
		
		if($this->input->post('modify_order')) {
			
			$oper = $this->input->post('operation');
			
			$this->form_validation->set_rules('order_id', 'Order ID', 'required|trim|numeric|prep_for_form');
			$this->form_validation->set_rules('reason', 'Reason', 'required|prep_for_form');
			if($oper == 'update_order') {
				$this->form_validation->set_rules('amount_paid', 'Amount Paid', 'required|numeric|prep_for_form');
				$this->form_validation->set_rules('booked_seats', 'Booked Seats', 'required|numeric');
			}
			
			
			if($this->form_validation->run() == FALSE) {
				$data['error_message'] = validation_errors();
			} else {
				
				$order_id = $this->input->post('order_id');
				$seats = $this->input->post('booked_seats');
				$reason = $this->input->post('reason');
				$paid = $this->input->post('amount_paid');
				
				if($oper == 'cancel_order') {
					$result = $this->Order_model->cancelOrder($this->getUserId(), $order_id, $reason);
					if($result['result'] == FALSE) {
						$data['error_message'] = $result->message;
					} else {
						$data['status_message'] = 'Order number ' . $order_id . ' successfully canceled';
					}
				} else if($oper == 'update_order') {
					$result = $this->Order_model->updateOrder($this->getUserId(), $order_id, $reason, $seats, $paid);
					if($result['result'] == FALSE) {
						$data['error_message'] = $result->message;
					} else {
						$data['status_message'] = 'Order number ' . $order_id . ' successfully updated';
					}
				} else {
					// Invalid operation
				}
				
			}
			
			// Load template components (all are optional)
			$page_data['css'] = $this->load->view('admin/orders_style.css', NULL, true);
			$page_data['js'] = $this->load->view('admin/orders_js', $data, true);
			$page_data['content'] = $this->load->view('admin/orders_content', $data, true);
			$page_data['widgets'] = $this->load->view('admin/flights_widgets', NULL, true);
			
			// Send page data to the site_main and have it rendered
			$this->load->view('site_main', $page_data);
			
		}
		
	}
	
	/*
	 * Helper functions
	 */
	function isAdmin() {
		$this->Account_model->checkLogin();
		$usrdata = $this->session->all_userdata();
		if($this->Account_model->accountHasPermission($usrdata['account_id'], 'ADMIN')) {
			return TRUE;
		} else {
			// Redirect with error message
			$this->session->set_flashdata('error_message', 'You do not have sufficient privelages');
			redirect('home/index', 'location');
			return FALSE;
		}
	}
	
	function getUserId() {
		$this->Account_model->checkLogin();
		$usrdata = $this->session->all_userdata();
		return $usrdata['account_id'];
	}
	
	function check_airport_code($code) {
		if($this->Flight_model->airportCodeToId($code) == NULL) {
			$this->form_validation->set_message('check_airport_code', 'The %s field was not a valid airport code');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
}

?>