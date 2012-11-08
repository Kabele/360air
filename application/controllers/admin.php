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
			} else {
				
				$data['flight'] = $this->Flight_model->getFlight($this->input->post('flight_id'));
				$data['formatted_depart'] = date('m/d/Y h:i a', $data['flight']->depart_time);
				$data['formatted_arrival'] = date('m/d/Y h:i a', $data['flight']->arrival_time);
				$data['depart_time'] = date('Y-m-d h:i:s A', $data['flight']->depart_time);
				$data['arrival_time'] = date('Y-m-d h:i:s A', $data['flight']->arrival_time);
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
				// fields from form here
				
				//if($this->form_validation->run() == FALSE) {
					$data['flight'] = NULL;
				//} else {
					// Adding a flight
					$oper = $this->input->post('operation');
					if($oper == 'add_flight') {
						// Build the flight object
						$flt = new Flight();
						$flt->arrival_airport_code = $this->input->post('arrival_airport_code');
						$flt->depart_airport_code = $this->input->post('depart_airport_code');
						$flt->arrival_time = human_to_unix($this->input->post('arrival_time'));
						$flt->depart_time = human_to_unix($this->input->post('depart_time'));
						$flt->total_seats = $this->input->post('total_seats');
						$flt->available_seats = $flt->total_seats;
						$flt->class_type = $this->input->post('flight_class');
						$flt->ticket_price = $this->input->post('price');
						
						// Populate all the fields with the data from the form
						$data['flight'] = $flt;
						
						//TODO:  Figure out how to use the radio buttons to do different actions with crud_flight
						// posting.  Make sure to get all fields and have them validated.  
						

						$result = $this->Flight_model->addFlight($flt);
						if($result != TRUE) {
							$this->session->set_flashdata('result', 'Flight scheduled');
						} else {
							$this->session->set_flashdata('result', 'Flight could not be scheduled');
						}
					} else {
						$data['flight'] = NULL;
					}
				//}
				
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
	
}

?>