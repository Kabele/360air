<?php

class Flight_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * Get Flight
	 * Given a flight ID query the database and return a new Flight object
	 * 
	 * @param $flight_id ID of the flight
	 * @return Flight object (if found), NULL if flight not found
	 */
	function getFlight($flight_id) {
		$q = $this->db->get_where('flights', array('flight_pk' => $flight_id), 1, 0);
		if($q->num_rows() == 1) {
			// Instantiate $flight with a Flight object and fill in the matching class properties
			$flight = $q->row(0, 'Flight');
			
			// Lookup the depart airport code
			$dq = $this->db->get_where('airports', array('airport_pk' => $flight->depart_airport_id), 1, 0);
			if($dq->num_rows() == 1)
				$flight->depart_airport_code = $dq->row()->code;
			$dq->free_result();
			
			// Lookup the arrival airport code
			$aq = $this->db->get_where('airports', array('airport_pk' => $flight->arrival_airport_id), 1, 0);
			if($aq->num_rows() == 1)
				$flight->arrival_airport_code = $aq->row()->code;
			$aq->free_result();
			
			return $flight;
		} else {
			return NULL;
		}
	}
	
	/*
	 * Add a flight to the database
	 *
	 * @param $flt Flight object
	 * @return TRUE if successful, false if otherwise
	 */
	function addFlight(Flight $flt) {
		$this->db->insert('flights', get_object_vars($flt));
		
		if($this->db->affected_rows() == 1)
			return TRUE;
			
		return FALSE;
	}
	
	/*
	 * Returns a list of at most 5 recent flights taken for a given user
	 * 
	 * @param $id to match the Account id of the user
	 * @return List of flights of max size 5
	 */
	function getRecentFlights($id) {
		// Get the flights with the corresponding account id
		$orders = $this->db->get_where('orders', array('account_id' => $id))->order_by('time', 'desc')->limit(5);
		
		$recentFlights = array();
		foreach($orders as $o) {
			$recentFlights[] = getFlight($o->flight_id);
		}
		
		
		return $recentFlights;
	}
	
	/*
	 * Returns a list of the 5 most recently added flights to the flights table
	 * 
	 * @return List of flights of max size 5
	 */
	function getNewlyAddedFlights() {
		$flights = $this->db->order_by('flight_pk', 'desc')->limit(5)->get('flights');
		return $flights->result();
	}
	/*
	 * Returns a list of flights filtered by the parameters
	 * 
	 * @param 
	 * @return a list of flight data matching the search criteria
	 */
	function search($departAirport, $arrivalAirport, $departTimeStart, $departTimeEnd, $arriveTimeStart, $arriveTimeEnd, $classType, $availableSeats) {
		// Add filter parameters depending on what was passed
		// Filter by depart airport
		if($departAirport != NULL) {
			// Look up the airport id using the code provided			
			$this->db->join('airports as d_airport', 'flights.depart_airport_id = d_airport.airport_pk');
			$this->db->where('d_airport.code',$departAirport);
		}
		// Filter by arrival airport
		if($arrivalAirport != NULL) {
			// Look up the airport id using the code provided			
			$this->db->join('airports as a_airport', 'flights.arrival_airport_id = a_airport.airport_pk');
			$this->db->where('a_airport.code',$arrivalAirport);
		}
		if($departTimeStart != NULL) {
			$this->db->where('flights.depart_time >=', $departTimeStart);
		}
		if($departTimeEnd != NULL) {
			$this->db->where('flights.depart_time <=', $departTimeEnd);
		}
		if($arriveTimeStart != NULL) {
			$this->db->where('flights.arrival_time >=', $arriveTimeStart);
		}
		if($arriveTimeEnd != NULL) {
			$this->db->where('flights.arrival_time <=', $arriveTimeEnd);
		}
		if($classType != NULL) {
			$this->db->where('flights.class_type',$classType);
		}
		if($availableSeats != NULL) {
			$this->db->where('flights.available_seats >=', $availableSeats);
		}
		
		// Populate with the airport code and name for depart and arrival
		$this->db->join('airports as depart_airport', 'flights.depart_airport_id = depart_airport.airport_pk');
		$this->db->select('depart_airport.code as depart_airport_code, depart_airport.name as depart_airport_name');
		
		$this->db->join('airports as arrive_airport', 'flights.arrival_airport_id = arrive_airport.airport_pk');
		$this->db->select('arrive_airport.code as arrival_airport_code, arrive_airport.name as arrival_airport_name');
		
		$this->db->select('flights.*');
		
		$flights = $this->db->get('flights');
		
		return $flights->result();
	}
	
	/*
	 * Gets a list of airports including their airport code and name
	 * 
	 * @param $isDomestic indicates whether only domestic airports should be included
	 * @return a list of airport code/name pairs
	 */
	function getAirports($isDomestic) {
		$this->db->from('airports');
		$this->db->select('code, name');
		if($isDomestic) {
			$this->db->where('is_domestic',1);
		}
		$airports = $this->db->get();
		
		return $airports->result();
	}
}

?>