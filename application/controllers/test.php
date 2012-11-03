<?php

/*
 * Testing Controller
 */
class Test extends CI_Controller 
{
	// Test class constructor
	public function __construct() {
		parent::__construct();
		
		$this->load->model('Flight_model');
	}

	public function index() {
		echo "Tests index";
	}
	
	public function getFlight($flight_id) {
		// Get the flight object
		echo 'Testing Flight_model/getFlight<br>';
		$flight = $this->Flight_model->getFlight($flight_id);
		if($flight == NULL)
			echo 'Flight not found';
		else
			$flight->print_data();
	}
	
	public function getNewlyAddedFlights() {
		echo 'Testing Flight_model/getNewlyAddedFlights<br>';
		$flights = $this->Flight_model->getNewlyAddedFlights();
		var_dump($flights);
	}
	
	public function searchFlights() {
		if($this->input->post()) {
			echo 'Testing Flight_model/search<br>';
			$departAirport = $this->input->post('departAirport');
			$arrivalAirport = $this->input->post('arrivalAirport');
			$departTimeStart = $this->input->post('departTimeStart');
			$departTimeEnd = $this->input->post('departTimeEnd');
			$arriveTimeStart = $this->input->post('arriveTimeStart');
			$arriveTimeEnd = $this->input->post('arriveTimeEnd');
			$classType = $this->input->post('classType');
			$availableSeats = $this->input->post('availableSeats');
			
			$flights = $this->Flight_model->search($departAirport, $arrivalAirport, $departTimeStart, $departTimeEnd, $arriveTimeStart, $arriveTimeEnd, $classType, $availableSeats);
			var_dump($flights);
		}
	}
	
	public function addFlight() {
		if($this->input->post()) {
			echo 'Testing Flight_model/addFlight<br>';
			$flt = new Flight();
			
			$flt->depart_airport_id = $this->input->post('departAirportId');
			$flt->arrival_airport_id = $this->input->post('arrivalAirportId');
			$flt->depart_time = $this->input->post('departTime');
			$flt->arrival_time = $this->input->post('arriveTime');
			$flt->class_type = $this->input->post('classType');		
			$flt->ticket_price = $this->input->post('ticketPrice');
			$flt->total_seats = $this->input->post('totalSeats');
			$flt->available_seats = $flt->total_seats;
			
			$result = $this->Flight_model->addFlight($flt);
			echo $result;
		}
	}
	
	public function updateFlight() {
		if($this->input->post()) {
			echo 'Testing Flight_model/addFlight<br>';
			$flt = new Flight();
			
			$flt->depart_airport_id = $this->input->post('departAirportId');
			$flt->arrival_airport_id = $this->input->post('arrivalAirportId');
			$flt->depart_time = $this->input->post('departTime');
			$flt->arrival_time = $this->input->post('arriveTime');
			$flt->class_type = $this->input->post('classType');		
			$flt->ticket_price = $this->input->post('ticketPrice');
			$flt->total_seats = $this->input->post('totalSeats');
			$flt->available_seats = $flt->total_seats;
			
			$result = $this->Flight_model->updateFlight($flt);
			echo $result;
		}
	}
	
	public function getAirports($isDomestic) {
		var_dump( $this->Flight_model->getAirports($isDomestic));
	}
	
	
}

?>
