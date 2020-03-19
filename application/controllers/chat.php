<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {
	public function index() {       
		/* $this->load->view('chat-view'); */
	}
	
	/************************************************ Chat ************************************************/
	
	// Resource: http://runnable.com/UXl9axZnE6ggAAMa/a-chat-example-using-codeigniter-and-jquery-php
	// Get chat message from Database
	// Params: 
	//			$time = time where to get messages 	
	public function get_chats($time) {	
		header('Content-Type: application/json');
		echo json_encode($this->patients->get_chat_after($time));
	}
	
	// Insert chat message into Database
	public function insert_chat() {
		$user=$this->input->post('user');
		$message=$this->input->post('message');
		$this->patients->insert_message($user, htmlspecialchars($message)); 
	}
	
	/************************************************ /Chat ************************************************/
}?>	