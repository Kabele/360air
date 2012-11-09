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
		$page_data['js'] = $this->load->view('admin/orders_js', NULL, true);
		$page_data['content'] = $this->load->view('admin/orders_content', $data, true);
		$page_data['widgets'] = $this->load->view('admin/flights_widgets', NULL, true);
		
		// Send page data to the site_main and have it rendered
		$this->load->view('site_main', $page_data);
	}
	
	public function searchOrders() {
		$this->isAdmin();
		
		if($this->input->post('search_orders')) {
			
			$firstName = $this->input->post('first_name');
			$lastName = $this->input->post('last_name');
			$email = $this->input->post('email');
			$flightId = $this->input->post('flight_number');
			$orderId = $this->input->post('booking_number');
			
			if($firstName != NULL && $lastName != NULL) {
				$account = $this->Account_model->getAccountByName($firstName, $lastName);
			}
			
			if($email != NULL) {
				// Search the account by email
				$account = $this->Account_model->getAccountByEmail($email);
			}
			
			if($flightId != NULL) {
				// Get account by searching orders using flight id to narrow results
			}
			
			if($orderId != NULL) {
				// Search for account by order id
				$order = $this->Order_model->getOrder($orderId);
				$account = $this->Account_model->getAccount($order->account_id);
			}
			
			$data['account'] = $account;
		
			// Load template components (all are optional)
			$page_data['css'] = $this->load->view('admin/orders_style.css', NULL, true);
			$page_data['js'] = $this->load->view('admin/orders_js', NULL, true);
			$page_data['content'] = $this->load->view('admin/orders_content', $data, true);
			$page_data['widgets'] = $this->load->view('admin/flights_widgets', NULL, true);
			
			// Send page data to the site_main and have it rendered
			$this->load->view('site_main', $page_data);
		}
	}
	
	public function cancelOrder() {
		$usrdata = $this->session->all_userdata();
		if($this->Account_model->accountHasPermissions($usrdata['account_id'], 'ADMIN')) {
			if($this->input->post('cancel_order')) {
				// Validation rules
				$this->form_validation->set_rules('account_id', 'Account Id', 'required');
				$this->form_validation->set_rules('order_id', 'Order Id', 'required');
				
				if($this->form_validation->run() == FALSE) {
					$this->session->set_flashdata('error_message', validation_errors());
				} else {
					$result = $this->Order_model->cancelOrder($this->post('account_id'), $this->post('order_id'));
					if($result == TRUE) {
						$this->session->set_flashdata('result', 'Order successfully canceled');
					} else {
						$this->session->set_flashdata('result', 'Order could not be canceled');
					}
				}
					
			}
		} else {
			// Redirect with error message
			$this->session->set_flashdata('error_message', 'You do not have sufficient privelages');
			redirect('home/index', 'location');
		}
	}
	
	/*
	 * Helper functions
	 */
	private function isAdmin() {
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
	
	private function getUserId() {
		$this->Account_model->checkLogin();
		$usrdata = $this->session->all_userdata();
		return $usrdata['account_id'];
	}
	
	private function check_airport_code($code) {
		if($this->Flight_model->airportCodeToId($code) == NULL) {
			$this->form_validation->set_message('check_airport_code', 'The %s field was not a valid airport code');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
}

?>