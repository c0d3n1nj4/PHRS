<?php
class custom404 extends CI_Controller {
    public function __construct() {
        parent::__construct(); 
    } 

    public function index() { 
		$this->output->set_template('404');
        $this->output->set_status_header('404'); 
        $data['content'] = 'custom404view'; // View name 
        $this->load->view('custom404view', $data);//loading in my template 
    } 
} 
?> 