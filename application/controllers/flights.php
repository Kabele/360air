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

	}
	
	public function search() {
	//Load template components (all are optional)
		$page_data['css'] = $this->load->view("flights/search_style.css", NULL, true);
	$page_data['js'] = $this->load->view("flights/search_js", NULL, true);
	$page_data['content'] = $this->load->view("flights/search_content", NULL, true);
	$page_data['widgets'] = $this->load->view("flights/search_widgets", NULL, true);
	
	//Send page data to the site_main and have it rendered
	$this->load->view("site_main",$page_data);
	}
	
	public function view($flight_id) {
		// Get the flight object
		$flight = $this->Flight_model->getFlight($flight_id);
		if($flight == NULL)
			echo 'Flight not found';
		else
			$flight->print_data();
	}
}

?>