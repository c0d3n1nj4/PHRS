<?php
class Users extends CI_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
		$this->_init();
    }
	
	// Initialize
	private function _init() {
		$this->load->database();
	}
	
	// Authentication
    public function authenticate_db($username, $password) {
		$where_arr = array('username'=>$username, 'password'=>sha1($password));
		$this->db->where($where_arr);
		$this->db->select("user_id, username, password");
        $query = $this->db->get('users');
        return $query->result();
    }

	// Update Logged to 'Y'
    public function login_user_db($user_id) {
		$data = array('logged'=>'Y');
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);
    }	
	
	// Update Logged to 'N'
    public function logout_user_db($user_id) {
		$data = array('logged'=>'N');
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);
    }	
	
	// Get specific User data
    public function get_user_data_db($user_id) {
		$where_arr = array('user_id'=>$user_id);
		$this->db->where($where_arr);
        $query = $this->db->get('users');
        return $query->result();
    }	

	// Get specific User messages
    public function get_user_messages_db($user_id) {
		$where_arr = array('users_user_id'=>$user_id);
		$this->db->where($where_arr);
        $query = $this->db->get('messages');
        return $query->result();
    }	
	
	// Get all Users
    public function get_all_users() {
        $query = $this->db->get('users');
        return $query->result();
    }	
	
	// Add New Message to Database
    public function add_user_message_db() {		
		$now = date("Y-m-d H:i:s");
		$data = array(
			'from'=>$this->input->post('from'),
			'message'=>$this->input->post('message'),
			'date_sent'=>$now,
			'users_user_id'=>$this->input->post('users_user_id')
		);
		$this->db->insert('messages', $data);
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }	

	// Delete specific Message
    public function delete_message($message_id) {
		$this->db->where('message_id', $message_id);
		$this->db->delete('messages');
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }		
}