<?php
class Account_model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}
	
	// Check a email / password combo against the DB and setup session data. Return's true if login is successful
	function doAccountLogin($email, $password)
    {
		$this->session->unset_userdata('logged_in');
		
    	// Get the users data from the db
        $res = $this->db->get_where('accounts', array('email' => $email, 'password' => $password), 1, 0);
        
        // Account doesnt even exist, bail
        if ($res->num_rows() == 0)
            return false;
            
    	// Get the result array (should only be 1 since we set a limit)
    	$row = $res->row();
        
        // Grab the users hashed password and their salt
        $hashedpw = $row->password;
        $salt = $row->salt;
        
        // Compute the hash of the attempted password with the salt
        $computedpw = md5(md5($password) . $salt);
        
        // If the hashed password doesnt match the computed password, bail
        if ($hashedpw != $computedpw)
        	return false;
            
    	// Fill in the session data
		$this->session->set_userdata('logged_in', true);
		$this->session->set_userdata('email', $row->email);
		$this->session->set_userdata('account_id', $row->account_pk);
		$this->session->set_userdata('address_id', $row->address_id);
        
        return true;
    }
    
    // Destroy the user's session (on logout)
    function doAccountLogout() {
    	$this->session->sess_destroy();
    }
        
    // Check if the user is already logged in
    function isLoggedIn() {
    	return $this->session->userdata('logged_in') == true;
    }
    
    // If user is logged in, do nothing. If user is not logged in, redirect.
    function checkLogin() {
        if($this->isLoggedIn()) {
            return;
		} else {
            $this->session->set_flashdata('error_message', 'You must be logged in to perform this action!');
            redirect(base_url().'accounts/showLogin', 'location');
		}
    }
	
	function addAccount() {
		// Generate salt for password
		$this->load->helper('string');
		$salt = random_string('alnum', 16);
		$account = array(
			'email'              => $this->input->post('reg_email'),
			'password'              => md5(md5($this->input->post('reg_password')) . $salt),
			'salt'              	=> $salt,
			'address_id'            => 0,
		);
	}
}
?>