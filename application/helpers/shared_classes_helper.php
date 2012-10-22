<?php

function print_class_vars($obj) {
	var_dump(get_object_vars($obj));
}
/*
 * Shared Classes
 */

class Flight {
	// Database Properties
	public $flight_pk;
	public $available_seats;
	public $total_seats;
	public $depart_airport_id;
	public $arrival_airport_id;
	public $depart_time;
	public $arrival_time;
	public $ticket_price;
	
	// Application properties
	public $depart_airport_code;
	public $arrival_airport_code;
	
	function __construct() {
		$this->flight_pk = 0;
		$this->available_seats = 0;
		$this->total_seats = 0;
		$this->depart_airport_id = 0;
		$this->arrival_airport_id = 0;
		$this->depart_time = 0;
		$this->arrival_time = 0;
		$this->ticket_price = 0;
		
		$this->depart_airport_code = "?";
		$this->arrival_airport_code = "?";
	}
}

?>