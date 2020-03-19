<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	// Constructor
    function __construct() {
        parent::__construct();
    }
	
	// Initialize
	public function index() {
		$this->load->view('login');
	}
	
	// Check login details
	public function authenticate() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');	
		$data = $this->users->authenticate_db($username, $password);
		// If Authentication is OK
		if (!empty($data)) {
			// Change Logged to 'Y'
			$this->users->login_user_db($data[0]->user_id);
			$user_id = $data[0]->user_id;
			// Erase contents from array $data so that we can re-use the array
			unset($data);
			$data = $this->users->get_user_data_db($user_id);
			$this->session->set_userdata(array('user' => $data));
			redirect('dashboard', 'location');	
		} else {
			$data['success'] = "0";
			$data['message'] = "FAILED! Something wrong with your Username and Password combination. Try again.";
			$this->load->view('login', $data);
		}		
	}	

	// Logout and Destroy Sessions
	public function logout($user_id) {
		$this->users->logout_user_db($user_id);
		$this->session->unset_userdata($user, $recent_patients, $users);
		$this->session->sess_destroy();
		redirect('user', 'location');	
	}		
}