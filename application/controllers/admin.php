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
	}

	public function index() {

		echo 'admin index';
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
	
	public function scheduleFlight() {
		$usrdata = $this->session->all_userdata();
		if($this->Account_model->accountHasPermissions($usrdata['account_id'], 'ADMIN')) {
			if($this->input->post('cancel_order')) {
				// Validation rules
				// fields from form here
				
				if($this->form_validation->run() == FALSE) {
					$this->session->set_flashdata('error_message', validation_errors());
				} else {
					// Build the flight object
					$flt = new Flight();
					// Populate all the fields with the data from the form
					
					$result = $this->Order_model->addFlight($flt);
					if($result == TRUE) {
						$this->session->set_flashdata('result', 'Flight scheduled');
					} else {
						$this->session->set_flashdata('result', 'Flight could not be scheduled');
					}
				}
					
			}
		} else {
			// Redirect with error message
			$this->session->set_flashdata('error_message', 'You do not have sufficient privelages');
			redirect('home/index', 'location');
		}
	}
	
}

?>