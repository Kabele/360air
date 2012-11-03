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
	public $class_type;
	
	// Application properties
	public $depart_airport_code;
	public $arrival_airport_code;
	public $depart_airport_name;
	public $arrival_airport_name;
	
	function __construct() {
		$this->flight_pk = 0;
		$this->available_seats = 0;
		$this->total_seats = 0;
		$this->depart_airport_id = 0;
		$this->arrival_airport_id = 0;
		$this->depart_time = 0;
		$this->arrival_time = 0;
		$this->ticket_price = 0;
		$this->class_type = 0;
		
		$this->depart_airport_code = "?";
		$this->arrival_airport_code = "?";
		$this->depart_airport_name = "?";
		$this->arrival_airport_name = "?";
	}
	
	function print_data() {
		print_class_vars($this);
	}
	
	function get_db_vars() {
		return array('flight_pk' => $this->flight_pk, 'available_seats' => $this->available_seats, 'total_seats' => $this->total_seats,
			'depart_airport_id' => $this->depart_airport_id, 'arrival_airport_id' => $this->arrival_airport_id, 'depart_time' => $this->depart_time,
			'arrival_time' => $this->arrival_time, 'ticket_price' => $this->ticket_price, 'class_type' => $this->class_type);
	}
}

?>