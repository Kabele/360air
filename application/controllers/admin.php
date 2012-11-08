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
		$data['error_message'] = NULL;
		$data['flight'] = NULL;
		
		// Load template components (all are optional)
		$page_data['css'] = $this->load->view('admin/main_style.css', NULL, true);
		$page_data['js'] = $this->load->view('admin/main_js', NULL, true);
		$page_data['content'] = $this->load->view('admin/main_content', $data, true);
		$page_data['widgets'] = $this->load->view('admin/main_widgets', NULL, true);
		
		// Send page data to the site_main and have it rendered
		$this->load->view('site_main', $page_data);
	}
	
	public function searchFlight() {
		// Check for admin privilages
		if($this->input->post('search_flight')) {
			// Validation rules
			$this->form_validation->set_rules('flight_id', 'Flight ID', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$data['flight'] = NULL;
				$this->session->set_flashdata('error_message', validation_errors());
			} else {
				
				$flt = $this->Flight_model->getFlight($this->input->post('flight_id'));
				$data['flight'] = $flt;
				if($flt != NULL) {
					$data['formatted_depart'] = date('m/d/Y h:i a', $flt->depart_time);
					$data['formatted_arrival'] = date('m/d/Y h:i a', $flt->arrival_time);
					$data['depart_time'] = date('Y-m-d h:i:s A', $flt->depart_time);
					$data['arrival_time'] = date('Y-m-d h:i:s A', $flt->arrival_time);
				}
			}
					
			// Load template components (all are optional)
			$page_data['css'] = $this->load->view('admin/main_style.css', NULL, true);
			$page_data['js'] = $this->load->view('admin/main_js', NULL, true);
			$page_data['content'] = $this->load->view('admin/main_content', $data, true);
			$page_data['widgets'] = $this->load->view('admin/main_widgets', NULL, true);
			
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
	
	// Scheduling, Updating, Cancelling flights
	public function CRUDFlight() {
		//$usrdata = $this->session->all_userdata();
		//if($this->Account_model->accountHasPermissions($usrdata['account_id'], 'ADMIN')) {
			if($this->input->post('crud_flight')) {
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
				$flt->available_seats = $flt->total_seats;
				$flt->class_type = $this->input->post('flight_class');
				$flt->ticket_price = $this->input->post('price');
				
				// Set the date data
				$data['formatted_depart'] = date('m/d/Y h:i a', $flt->depart_time);
				$data['formatted_arrival'] = date('m/d/Y h:i a', $flt->arrival_time);
				$data['depart_time'] = date('Y-m-d h:i:s A', $flt->depart_time);
				$data['arrival_time'] = date('Y-m-d h:i:s A', $flt->arrival_time);
				
				if($this->form_validation->run() == FALSE) {
					$data['flight'] = $flt;
					$this->session->set_flashdata('error_message', validation_errors());
				} else {
					// Adding a flight
					$oper = $this->input->post('operation');
					if($oper == 'add_flight') {
						
						$result = $this->Flight_model->addFlight($flt);			
						if($result != -1) {
							$flt->flight_pk = $result;
							$this->session->set_flashdata('status_message', 'Flight number ' . $result . ' scheduled');
						} else {
							$this->session->set_flashdata('status_message', 'Flight could not be scheduled');
						}
						
						// Populate all the fields with the data from the form
						$data['flight'] = $flt;
					
						
						
					// Updating a flight
					} else if($oper == 'update_flight') {
						
						$result = $this->Flight_model->updateFlight($flt);
						if($result != -1) {
							$flt->flight_pk = $result;
							$this->session->set_flashdata('status_message', 'Flight number ' . $result . ' updated');
						} else {
							$this->session->set_flashdata('status_message', 'Flight number ' . $flt->flight_pk . ' could not be updated');
						}
						// Populate all the fields with the data from the form
						$data['flight'] = $flt;
					
					// Deleting a flight
					} else if($oper == 'delete_flight') {
						$result = $this->Flight_model->removeFlight($flt);
						if($result != FALSE) {
							$this->session->set_flashdata('status_message', 'Flight number ' . $result . ' removed');
						} else {
							$this->session->set_flashdata('status_message', 'Flight number ' . $flt->flight_pk . ' could not be removed');
						}
						// Populate all the fields with the data from the form
						$data['flight'] = NULL;
					} else {
						$data['flight'] = NULL;
					}
				}
				
				// Load template components (all are optional)
				$page_data['css'] = $this->load->view('admin/main_style.css', NULL, true);
				$page_data['js'] = $this->load->view('admin/main_js', NULL, true);
				$page_data['content'] = $this->load->view('admin/main_content', $data, true);
				$page_data['widgets'] = $this->load->view('admin/main_widgets', NULL, true);
				
				// Send page data to the site_main and have it rendered
				$this->load->view('site_main', $page_data);
					
			}
		/*} else {
			// Redirect with error message
			$this->session->set_flashdata('error_message', 'You do not have sufficient privelages');
			redirect('home/index', 'location');
		}*/
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