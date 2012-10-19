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
		echo "flight index";
	}
	
	public function view($flight_id) {
		// Get the flight object
		$flight = $this->Flight_model->getFlight($flight_id);
		if($flight == NULL)
			echo 'Flight not found';
		else
			print_class_vars($flight);
	}
}

?>