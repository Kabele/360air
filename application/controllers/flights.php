<?php

/*
 * Flights Controller
 */
class Flights extends CI_Controller 
{
	// Flight class constructor
	public function __construct() {
		parent::__construct();
		
		$this->load->model('Flight_model');
	}

	public function index() {
		redirect('/flights/search');
	}
	
	public function search() {
		$data['search_results'] = NULL;
	
		// Grab all airports
		$airports['airports'] = $this->Flight_model->getAirports(FALSE);
	
		// Get search data if it was posted
		if($this->input->post('search_submit')) {
			
				$from = $this->input->post('from');
				$to = $this->input->post('to');
				$classType = $this->input->post('flight_class');
				$isDomestic = $this->input->post('is_domestic');
				
				if($this->input->post('depart_date_start_picker'))
					$departStart = $this->input->post('depart_date_start')/1000;
				else 
					$departStart = NULL;
				
				if($this->input->post('depart_date_end_picker'))
					$departEnd = $this->input->post('depart_date_end')/1000;
				else 
					$departEnd = NULL;
				
				if($this->input->post('arrival_date_start_picker'))
					$arriveStart = $this->input->post('arrival_date_start')/1000;
				else
					$arriveStart = NULL;
				
				if($this->input->post('arrival_date_end_picker'))
					$arriveEnd = $this->input->post('arrival_date_end')/1000;
				else
					$arriveEnd = NULL;

				$result = $this->Flight_model->search($from, $to, $departStart, $departEnd, $arriveStart, $arriveEnd, $classType, $isDomestic);
				$data['search_results'] = $result;
		}
	
		//Load template components (all are optional)
		$page_data['css'] = $this->load->view("flights/search_style.css", NULL, true);
		$page_data['js'] = $this->load->view("flights/search_js", $airports, true);
		$page_data['content'] = $this->load->view("flights/search_content", $data, true);
		$page_data['widgets'] = $this->load->view("flights/search_widgets", NULL, true);
	
		//Send page data to the site_main and have it rendered
		$this->load->view("site_main",$page_data);
	}
	
	public function view($flight_id) {
		// Get the flight object
		$data['flight'] = $this->Flight_model->getFlight($flight_id);
		if($data['flight'] == NULL) {
			$this->session->set_flashdata('error_message', 'Flight not found');
			redirect('');
			return;
		}
		
		//Load template components (all are optional)
		$page_data['css'] = $this->load->view("flights/view_style.css", NULL, true);
		$page_data['js'] = $this->load->view("flights/view_js", NULL, true);
		$page_data['content'] = $this->load->view("flights/view_content", $data, true);
		$page_data['widgets'] = $this->load->view("flights/view_widgets", NULL, true);
	
		//Send page data to the site_main and have it rendered
		$this->load->view("site_main",$page_data);
	}
}

?>