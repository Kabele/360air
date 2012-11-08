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
		
		// Grab all airports
		$airports['airports'] = $this->Flight_model->getAirports(FALSE);
		
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