<?php

/*
 * Front page
 */
class Home extends CI_Controller 
{
	// Home class constructor
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		echo "home index";
	}
}

?>