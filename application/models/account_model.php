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
        $res = $this->db->get_where('accounts', array('email' => $email), 1, 0);
        
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
            redirect('accounts/showLogin', 'location');
		}
    }
    
    /**
     * Retrieves account data from the database based on the ID
     *
     * @param id Account ID to use for looking up the account information
     * @return Account object with fields that match the database. NULL if not found
     */
    function getAccount($id) {
    	$query = $this->db->get_where('accounts', array('account_pk' => $id), 1, 0);
    	if($query->num_rows() > 0)
    		return $query->row();
    	else
    		return NULL;
    }
	
	/**
	 * Attempts to add an account to the database
	 *
	 * @param $data is an array containing the fields: email, password
	 * @return true if adding the account to the database was successful. False if otherwise
	 */
	function addAccount($data) {
		// Make sure the account email doesn't already exist
        $res = $this->db->get_where('accounts', array('email' => $data['email']));
        
        // Account email already exists
        if ($res->num_rows() != 0)
            return FALSE;
	
		// Generate salt for password
		$this->load->helper('string');
		$salt = random_string('alnum', 16);
		
		// Insert account to the database
		$account = array(
			'email'              => $data['email'],
			'password'              => md5(md5($data['password']) . $salt),
			'salt'              	=> $salt,
			'address_id'            => 0,
		);
		$this->db->insert('accounts', $account);
		
		if($this->db->affected_rows() == 1)
			return TRUE;
		
		return FALSE;
	}
	
	/**
	 * Checks if the account has a certain access by querying the existence for a permission string
	 * in the permissions table
	 *
	 * @param $id Account ID
	 * @param $access Access String to look for
	 * @return TRUE if the account has the permission. False if otherwise
	 */
	function accountHasPermission($id, $access) {
		$query = $this->db->get_where('permissions', array('account_id' => $id, 'access' => $access));
		
		if($query->num_rows() > 0)
			return TRUE;
			
		return FALSE;
	}
	
	/**
	 * Gets an account using email as criterion
	 * 
	 * @param $email email address for the account
	 * @return The account if found, NULL otherwise
	 */
	function getAccountByEmail($email) {
		$account = $this->db->get_where('accounts', array('email' => $email), 1, 0);
		
		if($account->num_rows() > 0)
			return $account->result();
			
		return NULL;
	}
	
/**
	 * Gets an account using email as criterion
	 * 
	 * @param $firstName, $lastName first and last name on the account
	 * @return The account if found, NULL otherwise
	 */
	function getAccountByName($firstName, $lastName) {
		$account = $this->db->get_where('accounts', array('first_name' => $firstName, 'last_name' => $lastName), 1, 0);
		
		if($account->num_rows() > 0)
			return $account->result();
			
		return NULL;
	}
}
?>