<?php

/*
 * Accounts page
 */
class Accounts extends CI_Controller 
{
	public function __construct() {
		parent::__construct();
		
		$this->load->model('Account_model');
	}

	/**
	 * Forward the client to a account page based on login status.
	 * If logged in, forward to account management. Otherwise, show the login and register page
	 */
	function index()
	{
		// If logged in, redirect to the accounts preferences
		// If the account is not logged in, open up the login page
		if ($this->Account_model->isLoggedIn()) {
			redirect('accounts/manage', 'location');
		} else {
			redirect('accounts/showLogin', 'location');
		}
	}
	
	/*
	 * Redirect to preferences page if logged in. If registration post data submitted, process it and pass to the account model
	 */
	function register() {
		// If the account is already logged in and somehow ends up here, forward them to their profile
		if ($this->Account_model->isLoggedIn()) redirect('accounts/manage', 'location');
		
		// Check for registration POST data
		if($this->input->post('register')) {
			// Rules
			$this->form_validation->set_rules('reg_email', 'Email', 'trim|required|min_length[3]|max_length[12]|valid_email|xss_clean|prep_for_form');
			$this->form_validation->set_rules('confirm_email', 'Email Confirmation', 'required|matches[reg_email]');
			$this->form_validation->set_rules('reg_password', 'Password', 'trim|required|min_length[3]|max_length[20]|xss_clean|prep_for_form');
			$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|matches[reg_password]');
			// need rules for address here
			//$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[1]|max_length[16]|alpha|xss_clean|prep_for_form');
			//$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[1]|max_length[16]|alpha|xss_clean|prep_for_form');
			
			if($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error_message', validation_errors());
				redirect('accounts/showLogin', 'location');
			} else {
				// Add account to the database
				$regSuccessful = $this->Account_model->addAccount($email, $password);
				
				// Log the account in and redirect to the management page
				if($regSuccessful && $this->Account_model->doAccountLogin($this->input->post('reg_email'),  $this->input->post('reg_password'))) {
					$this->session->set_flashdata('status_message', 'Welcome to 360-air.com!');
					redirect('accounts/manage', 'location');
				} else {
					$this->session->set_flashdata('error_message', 'Could not add account to database');
				}
			}
		} else {
			$this->session->set_flashdata('error_message', 'You must fill in the registration form to register!');
		}
		
		// Send them to the login/register page:
		redirect('accounts/showLogin', 'location');
	}
	
	/**
	 * Show the account login and registration page
	 * Logged in accounts will be redirected to account management
	 */
	function showLogin() {
		// If the account is already logged in and somehow ends up here, forward them to their profile
		if ($this->Account_model->isLoggedIn()) redirect('accounts/manage', 'location');
	
		// Load the main page template
		/*$page_data['nocache'] = true;
		$page_data['header_js'] = $this->load->view('account/account_loginjs', '', true);
		$page_data['left_content'] = $this->load->view('account/account_loginleft', '', true);
		$page_data['right_content'] = $this->load->view('account/account_loginright', '', true);
		
		// Send page data to the site_main and have it rendered
		$this->load->view('site_main', $page_data);*/
	}
	
	// Login process function
	function login() {
		// Various vars for tracking the evaluation
		$result = false;
		$error_msg = '';
				
		// Setup the rules of our form
		$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[3]|max_length[12]|valid_email|xss_clean|prep_for_form');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[255]|xss_clean|prep_for_form');
		
		// Validate form input and check it against the db:
		if ($this->form_validation->run() == FALSE) {
			$error_msg = validation_errors();
			$result = false;
		} else {
			// Check the login credentials against the db
			if ($this->account_model->doAccountLogin($this->input->post('email'), $this->input->post('password')) != true) {
				// account didnt enter a valid account/pass combo
				$error_msg = 'Invalid Email and Password combination.';
				$result = false;
			} else {
				// We succeeded
				$result = true;
			}
		}
		
		$this->session->set_flashdata('error_message', $error_msg);

		if($result)
			redirect('accounts/manage', 'location');
		else
			redirect('accounts/showLogin', 'location');
	}
	
	/**
	 * Formally handle a client (current session) request to log out
	 */
	function logout() {
		// Destroy the session then redirect
		$this->account_model->doAccountLogout();
		redirect('', 'location');
	}
	
	/**
	 * Personal account management page
	 * Loads the account management page for the current account session
	 */
	function manage() {
		// The account must be logged in to view account management
		$this->account_model->checkLogin();
	}
}

?>