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
			
			// Lookup the arrival airport code
			$aq = $this->db->get_where('airports', array('airport_pk' => $flight->arrival_airport_id), 1, 0);
			if($aq->num_rows() == 1)
				$flight->arrival_airport_code = $aq->row()->code;
			
			return $flight;
		} else {
			return NULL;
		}
	}
	
	
	function search() {
	}
}

?>