<?php

/*
 * Front page
 */
class Home extends CI_Controller 
{
	// Home class constructor
	public function __construct() {
		parent::__construct();
		
		$this->load->model('Flight_model');
	}

	public function index() {
		// Get all data that will be displayed on the from page
		$data['new_flights'] = $this->Flight_model->getNewlyAddedFlights();
		$data['search_results'] = NULL;
		
		// Grab all airports
		$airports['airports'] = $this->Flight_model->getAirports(FALSE);
		
		// Get search data if it was posted
		if($this->input->post()) {
			$from = $this->input->post('from');
			$to = $this->input->post('to');
			$classType = $this->input->post('flight_class');
			$departStart = $this->input->post('depart_date_start');
			$departEnd = $this->input->post('depart_date_end');
			$arriveStart = $this->input->post('arrival_date_start');
			$arriveEnd = $this->input->post('arrival_date_end');
			$passengers = $this->input->post('passenger_adult');
			$passengers += $this->input->post('passenger_children');
			$passengers += $this->input->post('passenger_infant');
			$isDomestic = $this->input->post('is_domestic');
			
			//$airports['airports'] = $this->Flight_model->getAirports($isDomestic);
			$data['search_results'] = $this->Flight_model->search($from, $to, $departStart, $departEnd, $arriveStart, $arriveEnd, $classType, $passengers);
		} else {
			// If they haven't posted, assume domestic only
			
		}
		
		// Load template components (all are optional)
		$page_data['css'] = $this->load->view('home/style.css', NULL, true);
		$page_data['js'] = $this->load->view('home/js', $airports, true);
		$page_data['content'] = $this->load->view('home/content', $data, true);
		$page_data['widgets'] = $this->load->view('home/widgets', NULL, true);
		
		// Send page data to the site_main and have it rendered
		$this->load->view('site_main', $page_data);
	}
}

?>