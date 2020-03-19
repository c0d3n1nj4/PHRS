<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	private $user_messages_db = array();
	private $pagination_config = array();
	private $per_page = 20; // Number of rows/records to display
	private $new_patients_limit = 20; // Number of new patients to display on the left side
	private $num_links = 2; // Specifies how many links to display before and after current page
	
	// Constructor
    public function __construct() {
        parent::__construct();
		$this->_init();
    }
	
	// Initialize
	private function _init() {
		$this->output->set_template('default');
		//$this->load->js('assets/themes/default/js/jquery-1.9.1.min.js');
		$user = $this->session->userdata('user');	

		if ($user) {
			$recent_patients = $this->patients->get_new_patients($this->new_patients_limit);
			$all_users = $this->users->get_all_users();
			$this->session->set_userdata(array('recent_patients'=>$recent_patients, 'all_users'=>$all_users));	
			$this->user_messages_db = $this->users->get_user_messages_db($user[0]->user_id);
		} else { 
			$this->session_expired();
		}
	}
	
	// Initialize pagination function on a page
	// Params: 
	//			$page = page to paginate
	//			$record_count = total number of patients
	//			$segment = depending if you have parameters
	// Return: 
	// 			$this->pagination->create_links()
	private function pagination($page, $record_count, $segment, $tab='') {
		// Pagination
        $this->pagination_config = array();
		// This is the full URL to the controller class/function containing your pagination.
        $this->pagination_config["base_url"] = base_url() . "/dashboard/".$page."/".$tab."/";
		// This number represents the total rows in the result set you are creating pagination for. 
		// Typically this number will be the total rows that your database query returned. 
        $this->pagination_config["total_rows"] = $record_count;
		// The number of items you intend to show per page.
        $this->pagination_config["per_page"] = $this->per_page;
		// The following is a list of all the preferences you can pass to the initialization function to tailor the display.
        $this->pagination_config["uri_segment"] = $segment;
		// Specifies how many links to display before and after current page
		$this->pagination_config['num_links'] = $this->num_links;
		
		// The text you would like shown in the "first" link on the left. If you do not want this link rendered, you can set its value to FALSE.
		$this->pagination_config['first_link'] = 'First';
		// The text you would like shown in the "last" link on the right. If you do not want this link rendered, you can set its value to FALSE.
		$this->pagination_config['last_link'] = 'Last';

		$this->pagination->initialize($this->pagination_config);
		
		return $this->pagination->create_links();
	}
	
	private function session_expired() {
		$this->session->sess_destroy();
		//echo '<script>$(document).ready(function() { $.alert("Your Session has expired. Please log back in.", "SESSION EXPIRED!"); });</script>';	
		echo "<script>alert('SESSION EXPIRED! Please log back in.');</script>";
		redirect('user', 'refresh');	
	}
	
	// Upload file
	private function upload_file($page, $patient_id='') {
		$config['upload_path'] = './uploads/images/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '150';
		$config['max_height']  = '150';

		$this->load->library('upload', $config);
		$field_name = "picture";
		if (!$this->upload->do_upload($field_name)) {
			if ($patient_id=='') {
				$data = array('error'=>$this->upload->display_errors(),
							  'user_messages'=>$this->user_messages_db);
			} else {
				$data = array('error'=>$this->upload->display_errors(), 
							  'patients'=>$this->patients->get_personal_info($patient_id),
							  'user_messages'=>$this->user_messages_db
							  );
			}
			$this->load->view($page, $data);
		} else {
			$data = $this->upload->data();		
			return $data;
		}	
	}	

	// Load the Dashboard Landing Page
	public function index() {
		date_default_timezone_set('Asia/Manila');
		$now = date("Y-m-d");
		$data['user_messages'] = $this->user_messages_db;
		$data['current'] = 'home';
		$res_arr = $this->patients->get_reservations_db($now);	
		$data['reservations_count'] = $this->patients->get_reservations_count_db($now);

		$total=0;
		foreach($res_arr as $r) {
			$charge = $this->patients->get_visit_charge_db($r->patient_patient_id, $r->date_reserved);
			$data['reservations'][] = array(
				'reservation_id' => $r->reservation_id,
				'priority' => $r->priority,
				'patient_id' => $r->patient_patient_id,
				'first_name' => $this->patients->get_first_name($r->patient_patient_id),
				'middle_name' => $this->patients->get_middle_name($r->patient_patient_id),
				'last_name' => $this->patients->get_last_name($r->patient_patient_id),
				'date_reserved' => $r->date_reserved,
				'status' => $r->status,
				'charge' => $charge,
				'insurance' => $this->patients->get_visit_insurance_db($r->patient_patient_id),
				'total' => $total+=(float)$charge
			);
		}
		
		$this->load->view('dashboard', $data);
	}
	
	// Get all existing patients	
	public function get_existing_patients() {
		// Page for Pagination
		$segment = 3; // method has 2 parameter
		// $page_links = $this->pagination("index", $this->patients->patients_record_count(), $segment, 'tab1');
		$page_links = $this->pagination("get_existing_patients/", $this->patients->patients_record_count(), $segment, '');
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
		$data["links"] = $page_links;
		
		$data['user_messages'] = $this->user_messages_db;
		$data['patients'] = $this->patients->get_all_patients($this->per_page, $page);
		$data['patients_count'] = $this->patients->patients_record_count();
		$data['page'] = $page;
		$data['current'] = 'existing_patients';
	
		$this->load->view('get-existing-patients', $data);
	}		
	
	/************************************************ Add/Delete/Search Patient ************************************************/
	// Load the view to Add New Patient
	public function add_patient() {
		$data['user_messages'] = $this->user_messages_db;
		$this->load->view('add-patient', $data);
	}	
	
	// Add New Patient
	public function add_new_patient() {
		// Pagination
		$segment = 3; // method has no parameters
		$page_links = $this->pagination("index", $this->patients->patients_record_count(), $segment, 'tab1');
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
		$data['user_messages'] = $this->user_messages_db;
		
		if($this->input->post('submit_new_patient')) {
			$data['file_name'] = '';
			// If the file field is NOT Empty
			if ($_FILES['picture']['error'] != 4) {
				$data = $this->upload_file('add-patient', '');
			}
			// If there are no Errors encountered
			if (count($data) > 1) {
				if($this->patients->insert_new_patient($data['file_name']) == TRUE) {
					$data['success'] = "1";
					$data['message'] = "SUCCESS! New Patient was successfully saved.";
				} else {
					$data['success'] = "0";
					$data['message'] = "FAILED! New Patient was NOT successfully saved.";
				}
				$data["links"] = $page_links;
				$data['user_messages'] = $this->user_messages_db;
				$data['patients'] = $this->patients->get_all_patients($this->per_page, $page);
				$data['patients_count'] = $this->patients->patients_record_count();
				$data['page'] = $page;
				$data['current'] = 'existing_patients'; // set the Dashboard Top Nav to active
				$this->session->set_userdata(array('recent_patients'=>$this->patients->get_new_patients($this->new_patients_limit))); // update recent patients on the left side
				$this->load->view('get-existing-patients', $data);
			}
		} else {
			redirect('dashboard/get_existing_patients', 'location');
		}		
	}	
	
	// Delete specific Patient
	// Params: 
	//			$pid=patient id
	public function delete_patient($pid) {
		if($this->patients->delete_patient($pid) == TRUE) {
			$this->session->set_flashdata('flashSuccess', "SUCCESS! Selected Patient was successfully deleted.");
		} else {
			$this->session->set_flashdata('flashError', "FAILED! Selected Patient was NOT successfully deleted.");
		}		
		redirect('dashboard/get_existing_patients', 'location');
	}
	
	// Delete multiple Patients
	public function delete_patients() {
		$checked_patients = $this->input->post('pids'); //selected patients  
        $this->patients->delete_patients($checked_patients);  
		$data['user_messages'] = $this->user_messages_db;
		$data['patients'] = $this->patients->get_personal_info();
		$this->load->view('dashboard', $data);		
	}	

	// Search Patient
	public function search_patient() {
		$keyword = $this->input->post('search_keyword');		
		$data['user_messages'] = $this->user_messages_db;
		$data['patients'] = $this->patients->search_patient_db($keyword);
		$data['patients_count'] = $this->patients->patients_record_count();
		
		// Page for Pagination
		$segment = 3; // method has no parameters
		$page_links = $this->pagination("index", count($data['patients']), $segment, NULL);
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
		$data["links"] = $page_links;		
		$data['page'] = $page;
		$data['current'] = 'existing_patients';		
		
		$this->load->view('get-existing-patients', $data);		
	}	
	/************************************************ /Add/Delete/Search Patient ************************************************/
	
	/************************************************ Personal Info ************************************************/
	// Get specific Patient's Personal Info
	// Params: 
	//			$id = patient id	
	//			$tab = active tab (Visits, Birth History, Immunization Records)		
	public function get_personal_info($id, $tab='tab1') {
		// Pagination
		$segment = 5; // method has 2 parameter
		$v_page_links = $this->pagination("get_personal_info/".$id, $this->patients->visits_record_count($id), $segment, 'tab1');
		$ir_page_links = $this->pagination("get_personal_info/".$id, $this->patients->immunization_records_count($id), $segment, 'tab3');
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
		$data["v_links"] = $v_page_links;
		$data["ir_links"] = $ir_page_links;
		
		$data['user_messages'] = $this->user_messages_db;
		$data['blood_types'] = $this->patients->get_all_blood_types();
		$data['patients'] = (count($this->patients->get_personal_info($id)) > 0) ? $this->patients->get_personal_info($id) : array();
		$data['visits'] = (count($this->patients->get_patient_visits($id, $this->per_page, $page)) > 0) ? $this->patients->get_patient_visits($id, $this->per_page, $page) : array();	
		$data['birth_history'] = (count($this->patients->get_patient_birth_history($id)) > 0) ? $this->patients->get_patient_birth_history($id) : array();	
		$data['immunization_records'] = (count($this->patients->get_immunization_records($id, $this->per_page, $page)) > 0) ? $this->patients->get_immunization_records($id, $this->per_page, $page) : array();
		$data['vaccines'] = $this->patients->get_all_vaccines();
		$data['tab'] = $tab;
		$this->load->view('get-personal-info', $data);
	}	
	
	// Update specific Patient's Personal Info
	public function update_personal_info($id) {
		$data['user_messages'] = $this->user_messages_db;
		$data['patients'] = $this->patients->get_personal_info($id);
		$this->load->view('update-personal-info', $data);	
	}		

	// Update specific Patient's Personal Info from Database
	public function update_personal_info_db() {
		$patient_id = $this->input->post('patient_id');
		
		// Pagination
		$segment = 4; // method has 1 parameter
		$page_links = $this->pagination("index", $this->patients->visits_record_count($patient_id), $segment);
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
		$data["links"] = $page_links;
		
		// If the Submit button is clicked
		if($this->input->post('submit_updated_info')) {
			$data['file_name'] = '';
			// If the file field is NOT Empty
			if ($_FILES['picture']['error'] != 4) {
				$data = $this->upload_file('update-personal-info', $patient_id);
			}
			// If there are no Errors encountered
			if (count($data) >= 1) {
				if($this->patients->update_personal_info($data['file_name']) == TRUE) {
					$data['success'] = "1";
					$data['message'] = "SUCCESS! Patient Personal Information was successfully updated.";
				} else {
					$data['success'] = "0";
					$data['message'] = "FAILED! Patient Personal Information was NOT successfully updated.";
				}
				$data['user_messages'] = $this->user_messages_db;	
				$data['patients'] = $this->patients->get_personal_info($patient_id);
				$data['visits'] = $this->patients->get_patient_visits($patient_id, $this->per_page, $page);
				$this->load->view('get-personal-info', $data);
			}	
		// If the Cancel button is clicked	
		} else {
			$data['user_messages'] = $this->user_messages_db;
			$data['patients'] = $this->patients->get_personal_info($patient_id);
			$data['visits'] = $this->patients->get_patient_visits($patient_id, $this->per_page, $page);
			$this->load->view('get-personal-info', $data);		
		}    
	}	
	/************************************************ /Personal Info ************************************************/	
	
	/************************************************ RESERVATIONS ************************************************/
	// Add New Reservation	
	public function add_new_reservation() {
		$this->patients->insert_new_reservation_db();
		redirect('dashboard', 'location');
		// $this->show_dashboard_from_res($this->input->post('date_reserved'));
	}	
	
	// Update Patient Reservation
	// Params: 
	//			$rid = reservation id	
	//			$status = reservation status
	//			$date_reserved = reservation date
	public function update_reservation_status($rid, $status, $date_reserved) {
		if($this->patients->update_reservation_status_db($rid, $status) == TRUE) {
			$data['message'] = "SUCCESS! Patient Reservation was successfully updated.";
			$data['success'] = "1";			
		} else {
			$data['message'] = "FAILED! Patient Reservation was NOT successfully updated.";
			$data['success'] = "0";				
		}		
		
		$this->show_dashboard_from_res($date_reserved);
	}		

	// Show Dashboard
	// Params: 
	//			$date_reserved = date_reserved		
	private function show_dashboard_from_res($date_reserved) {
		$data['user_messages'] = $this->user_messages_db;
		$res_arr = $this->patients->get_reservations_db($date_reserved);
		$data['reservations_count'] = $this->patients->get_reservations_count_db($date_reserved);	
		$data['filter_date'] = $date_reserved;
		$data['current'] = 'home';

		$total=0;
		foreach($res_arr as $r) {
			$charge = $this->patients->get_visit_charge_db($r->patient_patient_id, $r->date_reserved);
			$data['reservations'][] = array(
				'reservation_id' => $r->reservation_id,
				'priority' => $r->priority,
				'patient_id' => $r->patient_patient_id,
				'first_name' => $this->patients->get_first_name($r->patient_patient_id),
				'middle_name' => $this->patients->get_middle_name($r->patient_patient_id),
				'last_name' => $this->patients->get_last_name($r->patient_patient_id),
				'date_reserved' => $r->date_reserved,
				'status' => $r->status,
				'charge' => $charge,
				'insurance' => $this->patients->get_visit_insurance_db($r->patient_patient_id),
				'total' => $total+=(float)$charge
			);
		}	
		// Update total on database first
		$this->patients->update_charge_total_per_date($date_reserved, $total);			
		$this->load->view('dashboard', $data);	
	}
	
	// Delete specific Reservation
	// Params: 
	//			$rid = reservation id
	public function delete_reservation($rid) {
		if($this->patients->delete_reservation_db($rid) == TRUE) {
			$this->session->set_flashdata('flashSuccess', "SUCCESS! Selected Reservation successfully deleted.");
		} else {
			$this->session->set_flashdata('flashError', "FAILED! Selected Reservation was NOT successfully deleted.");
		}	
		redirect('dashboard', 'location');
	}		
	
	// Search Patient Reservation
	public function search_reservation() {	
		date_default_timezone_set('Asia/Manila');
		$now = date("Y-m-d");
		$data['user_messages'] = $this->user_messages_db;
		$date_reserved = $this->input->post('date_reserved');
		if(empty($date_reserved)) {
			$this->session->set_flashdata('flashError', "ERROR Please select a specific date.");
			$res_arr = $this->patients->get_reservations_db($now);		
			$data['reservations_count'] = $this->patients->get_reservations_count_db($now);	
			$data['filter_date'] = $now;
			$data['message'] = "ERROR! Please select a specific date.";
			$data['success'] = "0";
			
		} else {		
			$res_arr = $this->patients->get_reservations_db($date_reserved);
			$data['reservations_count'] = $this->patients->get_reservations_count_db($date_reserved);	
			$data['filter_date'] = $date_reserved;
		}

		$total=0;
		foreach($res_arr as $r) {	
			$charge = $this->patients->get_visit_charge_db($r->patient_patient_id, $r->date_reserved);
			$data['reservations'][] = array(
				'reservation_id' => $r->reservation_id,
				'priority' => $r->priority,
				'patient_id' => $r->patient_patient_id,
				'first_name' => $this->patients->get_first_name($r->patient_patient_id),
				'middle_name' => $this->patients->get_middle_name($r->patient_patient_id),
				'last_name' => $this->patients->get_last_name($r->patient_patient_id),
				'date_reserved' => $r->date_reserved,
				'status' => $r->status,
				'charge' => $charge,
				'insurance' => $this->patients->get_visit_insurance_db($r->patient_patient_id),
				'total' => $total+=(float)$charge
			);
		}		
		// Update total on database first
		$this->patients->update_charge_total_per_date($date_reserved, $total);			
		$this->load->view('dashboard', $data);		
	}		
	
	// Search Patient for Reservation
	public function search_patient_res() {
		$keyword = $this->input->post('search_keyword');	
		$rows = $this->patients->search_patient_res_db($keyword);

		$html = '<table class="search_patients">
				<thead>
					<tr>
						<th scope="col" class="rounded">ID</th>
						<th scope="col" class="rounded">First Name</th>
						<th scope="col" class="rounded">Middle Name</th>
						<th scope="col" class="rounded">Last Name</th>
						<th scope="col" class="rounded">Birth Date</th>
						<th scope="col" class="rounded">Gender</th>
						<th scope="col" class="rounded-q4" align="center">Reservation</th>
					</tr>
				</thead>';
		foreach ($rows as $row) {
			$html .= "<tr>"
					."<td>".$row['patient_id']."</td>"
					."<td>".$row['first_name']."</td>"
					."<td>".$row['middle_name']."</td>"
					."<td>".$row['last_name']."</td>"
					."<td>".$row['birth_date']."</td>"
					."<td>".$row['sex']."</td>"
					."<td align='center'><a href='dashboard/show_add_reservation_form/".$row['patient_id']."/".$row['first_name']."/".$row['middle_name']."/".$row['last_name']."' id='reserve_patient_link' style='color:green; font-weight:bold;' title='Reserve Patient'>Reserve</a></td>"
					."</tr>";
		}	
		$html .= "</table>";		
		echo $html;
	}	
	
	// Add Reservations
	// Params: 
	//			$ppid = patient id
	//			$fn = patient first name
	//			$mn = patient middle name
	//			$ln = patient last name
	public function show_add_reservation_form($ppid, $fn, $mn, $ln) {		
		$data['user_messages'] = $this->user_messages_db;
		$data['patient_patient_id'] = $ppid;
		$data['first_name'] = $fn;
		$data['middle_name'] = $mn;
		$data['last_name'] = $ln;
		$this->load->view('add-reservations', $data);	
	}		
	/************************************************ /RESERVATIONS ************************************************/
	
	/************************************************ VISITS ************************************************/
	
	// View specific Patient's Visit
	// Params: 
	//			$vid = visit id, 
	//			$ppid = patient id
	//			$page = page number
	public function view_visit($vid, $ppid, $page) {
		$data['user_messages'] = $this->user_messages_db;
		$data['visit'] = $this->patients->get_patient_visit($vid, $ppid);
		$data['page'] = $page;
		$this->load->view('update-visit', $data);	
	}		
	
	// Add New Patient's Visit
	public function add_new_visit() {
		$ppid = $this->input->post('patient_patient_id');
		if($this->patients->insert_new_visit() == TRUE) {
			$this->session->set_flashdata('flashSuccess', "SUCCESS! New Visit Data was successfully saved.");
		} else {
			$this->session->set_flashdata('flashError', "FAILED! New Visit Data was NOT successfully saved.");
		}
		redirect('dashboard/get_personal_info/'.$ppid.'/tab1', 'location');
	}	

	// Update specific Patient's Visit Data from Database
	public function update_visit_data() {
		$ppid = $this->input->post('patient_patient_id');
		if($this->patients->update_visit_data() == TRUE) {
			$this->session->set_flashdata('flashSuccess', "SUCCESS! Patient Visit Data was successfully updated.");
		} else {
			$this->session->set_flashdata('flashError', "FAILED! Patient Visit Data was NOT successfully updated.");
		}
		redirect('dashboard/get_personal_info/'.$ppid.'/tab1', 'location');
	}		
	
	// Delete specific Patient's Visit
	// Params: 
	//			$vid = visit id, 
	//			$ppid = patient id
	public function delete_visit($vid, $ppid) {
		if($this->patients->delete_visit($vid) == TRUE) {
			$this->session->set_flashdata('flashSuccess', "SUCCESS! Selected Patient's Visit Data was successfully deleted.");
		} else {
			$this->session->set_flashdata('flashError', "FAILED! Selected Patient's Visit Data was NOT successfully deleted.");
		}	
		redirect('dashboard/get_personal_info/'.$ppid.'/tab1', 'location');
	}		
	/************************************************ /VISITS ************************************************/

	/************************************************ BIRTH HISTORY ************************************************/
	// Add Patient's Birth History Data
	public function add_birth_history_data() {
		$ppid = $this->input->post('patient_patient_id');
		if($this->patients->insert_birth_history_data() == TRUE) {
			$this->session->set_flashdata('flashSuccess', "SUCCESS! Birth History data was successfully saved.");
		} else {
			$this->session->set_flashdata('flashError', "FAILED! Birth History data was NOT successfully saved.");
		}
		
		redirect('dashboard/get_personal_info/'.$ppid.'/tab2', 'location');
	}		
	
	// View Patient's Birth History Data
	// Params: 
	//			$bhid = birth history id, 
	//			$ppid = patient id
	public function view_birth_history_data($bhid, $ppid) {
		$data['user_messages'] = $this->user_messages_db;
		$data['birth_history'] = $this->patients->get_birth_history_data($bhid, $ppid);
		$this->load->view('update-birth-history-data', $data);	
	}		
	
	// Update Patient's Birth History Data
	public function update_birth_history_data() {
		$ppid = $this->input->post('patient_patient_id');
		if($this->patients->update_birth_history_data() == TRUE) {
			$this->session->set_flashdata('flashSuccess', 'SUCCESS! Patient Birth History Data was successfully updated.');
		} else {
			$this->session->set_flashdata('flashError', 'FAILED! Patient Birth History Data was NOT successfully updated.');
		}	
		redirect('dashboard/get_personal_info/'.$ppid.'/tab2', 'location');		
	}		
	/************************************************ /BIRTH HISTORY ************************************************/
	
	/************************************************ Immunization Records ************************************************/
	// Add Immunization Records
	// Params: 
	//			$ppid = patient id
	public function show_add_immunization_record_form($ppid) {		
		$data['user_messages'] = $this->user_messages_db;
		$data['patient_patient_id'] = $ppid;
		$data['vaccines'] = $this->patients->get_all_vaccines();
		$this->load->view('add-immunization-record', $data);	
	}	
	
	// Add Immunization Records
	public function add_immunization_record() {		
		$ppid=$this->input->post('patient_patient_id');
		if($this->patients->add_immunization_record() == TRUE) {
			$this->session->set_flashdata('flashSuccess', 'SUCCESS! New Immunization Record was successfully saved.');
		} else {
			$this->session->set_flashdata('flashError', 'FAILED! New Immunization Record was NOT successfully saved.');
		}		
		redirect('dashboard/get_personal_info/'.$ppid.'/tab3', 'location');
	}	
	
	// View specific Patient's Immunization Records
	// Params: 
	//			$irid = immunization record id, 
	//			$ppid = patient id
	//			$page = page number
	public function view_immunization_record($irid, $ppid, $page) {
		$data['user_messages'] = $this->user_messages_db;
		$data['immunization_record'] = $this->patients->get_immunization_record($irid, $ppid);
		$data['page'] = $page;
		$data['vaccines'] = $this->patients->get_all_vaccines();
		$this->load->view('update-immunization-record', $data);	
	}		
	
	// Update specific Patient's Immunization Record from Database
	public function update_immunization_record() {
		$ppid = $this->input->post('patient_patient_id');
		if($this->patients->update_immunization_record() == TRUE) {
			$this->session->set_flashdata('flashSuccess', 'SUCCESS! Patient Immunization Record was successfully updated.');
		} else {
			$this->session->set_flashdata('flashError', 'FAILED! Patient Immunization Record was NOT successfully updated.');
		}		
		redirect('dashboard/get_personal_info/'.$ppid.'/tab3', 'location');
	}		
	
	// Delete specific Patient's Immunization Record
	// Params: 
	//			$irid = immunization record id, 
	//			$ppid = patient id
	public function delete_immunization_record($irid, $ppid) {
		if($this->patients->delete_immunization_record($irid) == TRUE) {
			$this->session->set_flashdata('flashSuccess', "SUCCESS! Selected Patient's Immunization Record was successfully deleted.");
		} else {
			$this->session->set_flashdata('flashError', "FAILED! Selected Patient's Immunization Record was NOT successfully deleted.");		
		}	
		redirect('dashboard/get_personal_info/'.$ppid.'/tab3', 'location');
	}		
	/************************************************ /Immunization Records ************************************************/
	
	// Compose New Message
	// Params: 
	//			$uid = user id
	//			$username = username
	public function show_compose_message_form($uid, $username) {		
		$data['user_messages'] = $this->user_messages_db;
		$data['users'] = $this->users->get_all_users();
		$data['user_id'] = $uid;
		$data['from'] = $username;
		$this->load->view('compose-message', $data);	
	}		

	// Add New Message to Database
	public function add_user_message() {		
		$uid=$this->input->post('user_id');
		if($this->users->add_user_message_db() == TRUE) {
			$this->session->set_flashdata('flashSuccess', 'SUCCESS! Your message has been sent.');
		} else {
			$this->session->set_flashdata('flashError', 'FAILED! Your message was not sent.');
		}		
		redirect('dashboard/get_user_messages/'.$uid);
	}
	
	// Get User messages
	public function get_user_messages() {
		$data['user_messages'] = $this->user_messages_db;
		$this->load->view('get-user-messages', $data);				
	}	
	
	// Delete specific message
	public function delete_message($user_id, $message_id) {
		if($this->users->delete_message($message_id) == TRUE) {
			$this->session->set_flashdata('flashSuccess', 'SUCCESS! Selected Message was successfully deleted.');
		} else {
			$this->session->set_flashdata('flashError', 'FAILED! Selected Message was NOT successfully deleted.');
		}		
		redirect('dashboard/get_user_messages/'.$uid);	
	}	
	
	// Display the Help Page
	public function help() {
		$data['user_messages'] = $this->user_messages_db;
		$data['current'] = 'help';
		$this->load->view('help', $data);				
	}		
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */