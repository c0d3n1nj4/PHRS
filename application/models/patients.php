<?php
class Patients extends CI_Model {
    public function __construct() {
        // Call the Model constructor
        parent::__construct();
		$this->_init();
    }
	
	// Initialize
	private function _init() {
		$this->load->database();
	}

	// Get all Patients
	// Params: 
	//			$limit=how many records to return; 
	// 			$start=what record to start from
    public function get_all_patients($limit, $start) {
		$this->db->limit($limit, $start);
		$this->db->order_by("patient_id", "DESC");
        $query = $this->db->get('patient');
        return $query->result();
    }
	
	// Get the record count of all Patients
    public function patients_record_count() {
        return $this->db->count_all("patient");
    }	
	
	/************************************************ Personal Info ************************************************/
	// Get specific Patient's Personal Info
	// Params: 
	// 			$id=patient id	
    public function get_personal_info($id) {
		$where_arr = array('patient_id'=>$id);
		$this->db->where($where_arr);
        $query = $this->db->get('patient');
        return $query->result();
    }
	
	// Get Patient's First Name
	// Params: 
	// 			$id=patient id	
    public function get_first_name($id) {
		$where_arr = array('patient_id'=>$id);
		$this->db->where($where_arr);
        $query = $this->db->get('patient');
		
		foreach ($query->result() as $row) {
			$result = $row->first_name;
		}	
		return $result;
    }	
	
	// Get Patient's Middle Name
	// Params: 
	// 			$id=patient id	
    public function get_middle_name($id) {
		$where_arr = array('patient_id'=>$id);
		$this->db->where($where_arr);
        $query = $this->db->get('patient');
		
		foreach ($query->result() as $row) {
			$result = $row->middle_name;
		}	
		return $result;
    }		
	
	// Get Patient's Last Name
	// Params: 
	// 			$id=patient id	
    public function get_last_name($id) {
		$where_arr = array('patient_id'=>$id);
		$this->db->where($where_arr);
        $query = $this->db->get('patient');
		
		foreach ($query->result() as $row) {
			$result = $row->last_name;
		}	
		return $result;
    }		
	
	// Update Patient Personal Information
    public function update_personal_info($picture_filename) {
		date_default_timezone_set('Asia/Manila');
        $now = date("Y-m-d H:i:s");
		$data = array(
			'first_name'=>$this->input->post('first_name'),
			'middle_name'=>$this->input->post('middle_name'),
			'last_name'=>$this->input->post('last_name'),
			'sex'=>$this->input->post('sex'),
			'birth_date'=>$this->input->post('birth_date'),
			'address'=>$this->input->post('address'),
			'school'=>$this->input->post('school'),
			'father_name'=>$this->input->post('father_name'),
			'father_age'=>$this->input->post('father_age'),
			'father_contact_no'=>$this->input->post('father_contact_no'),
			'mother_name'=>$this->input->post('mother_name'),
			'mother_age'=>$this->input->post('mother_age'),
			'mother_contact_no'=>$this->input->post('mother_contact_no'),
			'date_updated'=>$now
		);
		if ($picture_filename != '') {
			$data['picture'] = $picture_filename;
		}		
		$this->db->where('patient_id', $this->input->post('patient_id'));
		$this->db->update('patient', $data);
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }	
	/************************************************ /Personal Info ************************************************/
	
	// Get specific Patient's Birth History
	// Params: 
	// 			$id=patient id
    public function get_patient_birth_history($id) {
		$where_arr = array('patient_patient_id'=>$id);
		$this->db->where($where_arr);
        $query = $this->db->get('birth_history');	
		return $query->result();
    }		

	// Get all Patients
	// Params: 
	// 			$limit=number of new patients to display	
    public function get_new_patients($limit) {	
		$this->db->order_by("patient_id", "DESC");
		$this->db->limit($limit);		
		$this->db->select("patient_id, first_name, last_name");
        $query = $this->db->get('patient');
        return $query->result();		
	}
	
	// Delete multiple Patients
    public function delete_patients($checked_patients) {
		$checked_patients = array();
		$this->db->where_in('patient_id', $checked_patients);
		$this->db->delete('patient');
    }	
	
	// Delete specific Patient
    public function delete_patient($id) {
		$ids = array($id);
		$this->delete_visit_by_ppid($id); // Delete records from visits table
		$this->delete_birth_history_data_by_ppid($id); // Delete records from birth histoy table
		$this->delete_immunization_record_by_ppid($id); // Delete records from immunization record table
		$this->db->where_in('patient_id', $ids);
		$this->db->delete('patient');
		
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }

	// Insert new Patient
    public function insert_new_patient($picture_filename) {
		date_default_timezone_set('Asia/Manila');
        $now = date("Y-m-d H:i:s");
		if ($picture_filename == '') {
			if ($this->input->post('sex') == 'M') {
				$picture = 'default_profile_male.jpg';
			} else {
				$picture = 'default_profile_female.jpg';
			}
		} else {
			$picture = $picture_filename;
		}
		
		$data = array(
			'first_name'=>$this->input->post('first_name'),
			'middle_name'=>$this->input->post('middle_name'),
			'last_name'=>$this->input->post('last_name'),
			'sex'=>$this->input->post('sex'),
			'birth_date'=>$this->input->post('birth_date'),
			'address'=>$this->input->post('address'),
			'school'=>$this->input->post('school'),
			'father_name'=>$this->input->post('father_name'),
			'father_age'=>$this->input->post('father_age'),
			'father_contact_no'=>$this->input->post('father_contact_no'),
			'mother_name'=>$this->input->post('mother_name'),
			'mother_age'=>$this->input->post('mother_age'),
			'mother_contact_no'=>$this->input->post('mother_contact_no'),
			'picture'=>$picture,
			'date_entered'=>$now
		);
		$this->db->insert('patient', $data);
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }

	/************************************************ VISITS ************************************************/
	// Get specific Patient's Visits Record
	// Params: 
	//			$id=patient id; 
	//			$limit=how many records to return; 
	// 			$start=what record to start from
    public function get_patient_visits($id, $limit, $start) {
		$where_arr = array('patient_patient_id'=>$id);
		$this->db->limit($limit, $start);
		$this->db->where($where_arr)->order_by("date_of_visit", "DESC");
        $query = $this->db->get('visits');
		return $query->result();	
    }		
	
	// Get specific Patient's Visit Record
	// Params: 
	//			$vid=visit id; 
	//			$ppid=patient id; 
    public function get_patient_visit($vid, $ppid) {
		$where_arr = array('visit_id'=>$vid, 'patient_patient_id'=>$ppid);
		$this->db->where($where_arr);
        $query = $this->db->get('visits');
		return $query->result();	
    }		
	
	// Get specific Patient's Visit charge
	// Params: 
	//			$ppid=patient id; 
	//			$date_of_visit=date of visit; 
    public function get_visit_charge_db($ppid, $date_of_visit) {
		$where_arr = array('patient_patient_id'=>$ppid, 'date_of_visit'=>$date_of_visit);
		$this->db->where($where_arr);
        $query = $this->db->get('visits');
		
		$result = '';	
		foreach ($query->result() as $row) {
			$result = $row->charge;		
		}	
		return $result;		
    }

	// Get specific Patient's Insurance
	// Params: 
	//			$ppid=patient id; 
    public function get_visit_insurance_db($ppid) {
		$where_arr = array('patient_patient_id'=>$ppid);
		$this->db->where($where_arr);
        $query = $this->db->get('visits');

		$result = '';	
		foreach ($query->result() as $row) {
			$result = $row->insurance;
		}	
		return $result;		
    }	

	// Get the record count of all Patients' visits
    public function visits_record_count($id) {
		$where_arr = array('patient_patient_id'=>$id);
		$this->db->where($where_arr);
		$query = $this->db->get('visits');
        return count($query->result());
    }
	
	// Insert new Patient's Visit
    public function insert_new_visit() {
		date_default_timezone_set('Asia/Manila');
        // $now = date("Y-m-d H:i:s");
		$now = date("Y-m-d");
		
		$data = array(
			'date_of_visit'=>$this->input->post('date_of_visit'),
			'age'=>$this->input->post('age'),
			'temperature'=>$this->input->post('temperature'),
			'weight'=>$this->input->post('weight')." ".$this->input->post('weight_label'),
			'height'=>$this->input->post('height')." ".$this->input->post('height_label'),
			'complaints'=>$this->input->post('complaints'),
			'physician_findings'=>$this->input->post('physician_findings'),
			'treatment'=>$this->input->post('treatment'),
			'charge'=>$this->input->post('charge'),
			'insurance'=>$this->input->post('insurance'),
			'patient_patient_id'=>$this->input->post('patient_patient_id')
		);
		$this->db->insert('visits', $data);
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }	
	
	// Update specific Patient's Visit Data from Database
    public function update_visit_data() {
		$data = array(
			'date_of_visit'=>$this->input->post('date_of_visit'),
			'age'=>$this->input->post('age'),
			'temperature'=>$this->input->post('temperature'),
			'weight'=>$this->input->post('weight')." ".$this->input->post('weight_label'),
			'height'=>$this->input->post('height')." ".$this->input->post('height_label'),
			'complaints'=>$this->input->post('complaints'),
			'physician_findings'=>$this->input->post('physician_findings'),
			'treatment'=>$this->input->post('treatment'),
			'charge'=>$this->input->post('charge'),
			'insurance'=>$this->input->post('insurance')
		);		
		$this->db->where('visit_id', $this->input->post('visit_id'));
		$this->db->where('patient_patient_id', $this->input->post('patient_patient_id'));
		$this->db->update('visits', $data);
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }	

	// Delete specific Patient's visit
	// Params: 
	//			$vid=visit id; 	
    public function delete_visit($vid) {
		$ids = array($vid);
		$this->db->where_in('visit_id', $ids);
		$this->db->delete('visits');
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }	

	// Delete specific Patient's visit using patient_patient_id
	// Params: 
	//			$ppid=patient id; 	
    public function delete_visit_by_ppid($ppid) {
		$ids = array($ppid);
		$this->db->where_in('patient_patient_id', $ids);
		$this->db->delete('visits');
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }		
	/************************************************ /VISITS ************************************************/	
	
	/************************************************ BIRTH HISTORY ************************************************/
	// Insert new Patient's Birth History Data
    public function insert_birth_history_data() {		
		$data = array(
			'preterm'=>($this->input->post('preterm')) ? $this->input->post('preterm') : NULL,
			'full_term'=>($this->input->post('full_term')) ? $this->input->post('full_term') : NULL,
			'nsd'=>($this->input->post('nsd')) ? $this->input->post('nsd') : NULL,
			'cs'=>($this->input->post('cs')) ? $this->input->post('cs') : NULL,
			'birth_weight'=>$this->input->post('birth_weight')." ".$this->input->post('weight_label'),
			'bw_percentile'=>$this->input->post('bw_percentile'),
			'birth_head_circumference'=>$this->input->post('birth_head_circumference'),
			'bhc_percentile'=>$this->input->post('bhc_percentile'),
			'birth_length'=>$this->input->post('birth_length')." ".$this->input->post('length_label'),
			'bl_percentile'=>$this->input->post('bl_percentile'),
			'birth_chest_circumference'=>$this->input->post('birth_chest_circumference'),
			'bcc_percentile'=>$this->input->post('bcc_percentile'),			
			'blood_type'=>$this->input->post('blood_type'),
			'birth_abdominal_circumference'=>$this->input->post('birth_abdominal_circumference'),
			'patient_patient_id'=>$this->input->post('patient_patient_id')
		);
		$this->db->insert('birth_history', $data);
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }	

	// Delete specific Patient's Birth History Data using patient_patient_id
	// Params: 
	//			$ppid=patient id; 
    public function delete_birth_history_data_by_ppid($ppid) {
		$ids = array($ppid);
		$this->db->where_in('patient_patient_id', $ids);
		$this->db->delete('birth_history');
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }		
	
	// Get Patient's Birth History Data
	// Params: 
	//			$bhid=birth history id; 
	//			$ppid=patient id; 
    public function get_birth_history_data($bhid, $ppid) {
		$where_arr = array('birth_history_id'=>$bhid, 'patient_patient_id'=>$ppid);
		$this->db->where($where_arr);
        $query = $this->db->get('birth_history');
		return $query->result();	
    }	
	
	// Update specific Patient's Birth History Data from Database
    public function update_birth_history_data() {
		$data = array(
			'preterm'=>($this->input->post('preterm')) ? $this->input->post('preterm') : NULL,
			'full_term'=>($this->input->post('full_term')) ? $this->input->post('full_term') : NULL,
			'nsd'=>($this->input->post('nsd')) ? $this->input->post('nsd') : NULL,
			'cs'=>($this->input->post('cs')) ? $this->input->post('cs') : NULL,
			'birth_weight'=>$this->input->post('birth_weight'),
			'bw_percentile'=>$this->input->post('bw_percentile'),
			'birth_head_circumference'=>$this->input->post('birth_head_circumference'),
			'bhc_percentile'=>$this->input->post('bhc_percentile'),
			'birth_length'=>$this->input->post('birth_length'),
			'bl_percentile'=>$this->input->post('bl_percentile'),
			'birth_chest_circumference'=>$this->input->post('birth_chest_circumference'),
			'bcc_percentile'=>$this->input->post('bcc_percentile'),			
			'blood_type'=>$this->input->post('blood_type'),
			'birth_abdominal_circumference'=>$this->input->post('birth_abdominal_circumference')
		);
		$this->db->where('birth_history_id', $this->input->post('birth_history_id'));
		$this->db->where('patient_patient_id', $this->input->post('patient_patient_id'));
		$this->db->update('birth_history', $data);
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }				
	/************************************************ /BIRTH HISTORY ************************************************/		
		
	/************************************************ IMMUNIZATION RECORD ************************************************/
	// Get specific Patient's Immunization Records
	// Params: 
	//			$id=patient id; 
	//			$limit=how many records to return; 
	// 			$start=what record to start from
    public function get_immunization_records($id, $limit, $start) {
		$where_arr = array('patient_patient_id'=>$id);
		$this->db->limit($limit, $start);
		$this->db->where($where_arr)->order_by("immunization_record_id", "DESC");
        $query = $this->db->get('immunization_record');
		return $query->result();	
    }	
	
	// Get specific Patient's Immunization Record
	// Params: 
	//			$irid=immunization record id; 
	//			$ppid=patient id; 
    public function get_immunization_record($irid, $ppid) {
		$where_arr = array('immunization_record_id'=>$irid, 'patient_patient_id'=>$ppid);
		$this->db->where($where_arr);
        $query = $this->db->get('immunization_record');
		return $query->result();	
    }	
	
	// Add new Patient's Immunization Record
    public function add_immunization_record() {		
		$data = array(
			'vaccines'=>implode(",", $this->input->post('vaccine_ids')),
			'first'=>$this->input->post('first'),
			'second'=>$this->input->post('second'),
			'third'=>$this->input->post('third'),
			'booster_one'=>$this->input->post('booster_one'),
			'booster_two'=>$this->input->post('booster_two'),
			'booster_three'=>$this->input->post('booster_three'),
			'other_vaccine'=>$this->input->post('other_vaccine'),
			'reaction'=>$this->input->post('reaction'),
			'patient_patient_id'=>$this->input->post('patient_patient_id')
		);
		$this->db->insert('immunization_record', $data);
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }
	
	// Get the count of all Patients' Immunization Records
	// Params: 
	//			$ppid=patient id; 	
    public function immunization_records_count($ppid) {
		$where_arr = array('patient_patient_id'=>$ppid);
		$this->db->where($where_arr);
		$query = $this->db->get('immunization_record');
        return count($query->result());
    }	
	
	// Update specific Patient's Immunization Record from Database
    public function update_immunization_record() {
		$data = array(
			'vaccines'=>implode(",", $this->input->post('vaccine_ids')),
			'first'=>$this->input->post('first'),
			'second'=>$this->input->post('second'),
			'third'=>$this->input->post('third'),
			'booster_one'=>$this->input->post('booster_one'),
			'booster_two'=>$this->input->post('booster_two'),
			'booster_three'=>$this->input->post('booster_three'),
			'other_vaccine'=>$this->input->post('other_vaccine'),
			'reaction'=>$this->input->post('reaction')
		);
		$this->db->where('immunization_record_id', $this->input->post('immunization_record_id'));
		$this->db->where('patient_patient_id', $this->input->post('patient_patient_id'));
		$this->db->update('immunization_record', $data);
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }		
	
	// Delete specific Patient's Immunization Record
	// Params: 
	//			$irid = immunization record id	
    public function delete_immunization_record($irid) {
		$ids = array($irid);
		$this->db->where_in('immunization_record_id', $ids);
		$this->db->delete('immunization_record');
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }	

	// Delete specific Patient's Immunization Record using patient_patient_id
	// Params: 
	//			$ppid = patient id	
    public function delete_immunization_record_by_ppid($ppid) {
		$ids = array($ppid);
		$this->db->where_in('patient_patient_id', $ids);
		$this->db->delete('immunization_record');
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }	
	/************************************************ /IMMUNIZATION RECORD ************************************************/	
		
	/************************************************ RESERVATIONS ************************************************/		
	// Add new Patient Reservation
    public function insert_new_reservation_db() {		
		$data = array(
			'priority'=>$this->input->post('priority'),
			'date_reserved'=>$this->input->post('date_reserved'),
			'status'=>$this->input->post('status'),
			'patient_patient_id'=>$this->input->post('patient_patient_id')
		);
		$this->db->insert('reservations', $data);
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }
	
	// Get Patient Reservations
	// Params: 
	//			$bhid=birth history id; 
	//			$ppid=patient id; 
    public function get_reservations_db($date_reserved) {
		$where_arr = array('date_reserved'=>$date_reserved);
		$this->db->where($where_arr);
		$this->db->order_by('date_reserved', 'ASC');
        $query = $this->db->get('reservations');
		return $query->result();	
    }
	
	// Get the record count of all Patient Reservations
    public function get_reservations_count_db($date_reserved) {
		$where_arr = array('date_reserved'=>$date_reserved);
		$this->db->where($where_arr);
		$query = $this->db->get('reservations');
        return count($query->result());
    }	
	
	// Update specific Patient Reservation
    public function update_reservation_status_db($rid, $status) {
		if ($status=='Waiting') {
			$data = array('status'=>'Finished');
		} else {
			$data = array('status'=>'Waiting');
		}	
		$this->db->where('reservation_id', $rid);
		$this->db->update('reservations', $data);
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }	

	// Update charge total per date
	// Params: 
	//			$date_reserved = date reserved	
	//			$total = total	
    public function update_charge_total_per_date($date_reserved, $total) {
		$data = array('total'=>$total);
		$this->db->where('date_reserved', $date_reserved);
		$this->db->update('reservations', $data);
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }		

	// Delete specific Patient Reservation
	// Params: 
	//			$rid = reservation id
    public function delete_reservation_db($rid) {
		$ids = array($rid);
		$this->db->where_in('reservation_id', $ids);
		$this->db->delete('reservations');
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }		
	/************************************************ /RESERVATIONS ************************************************/		
		
	/************************************************ GET ALL BLOOD TYPES ************************************************/
    public function get_all_blood_types() {
        $query = $this->db->get('blood_types');
        return $query->result();
    }	
	/************************************************ /GET ALL BLOOD TYPES ************************************************/
	
	/************************************************ GET ALL VACCINES ************************************************/
    public function get_all_vaccines() {
        $query = $this->db->get('vaccines');
        return $query->result();
    }	
	/************************************************ /GET ALL VACCINES ************************************************/	
	
	/************************************************ GET ALL ALLERGIES ************************************************/
    public function get_all_allergies() {
        $query = $this->db->get('allergies');
        return $query->result();
    }	
	/************************************************ /GET ALL ALLERGIES ************************************************/		
	
	/************************************************ SEARCH PATIENT ************************************************/
    public function search_patient_db($keyword) {
		$this->db->like('first_name', $keyword);	
		$this->db->or_like('last_name', $keyword);
        $query = $this->db->get('patient');
        return $query->result();
    }
	
    public function search_patient_res_db($keyword) {
		$this->db->like('first_name', $keyword);	
		$this->db->or_like('last_name', $keyword);
        $query = $this->db->get('patient');

		foreach ($query->result() as $row) {
			$results[] = array('patient_id'  => $row->patient_id, 
								'first_name' => $row->first_name, 
								'middle_name' => $row->middle_name, 
								'last_name' => $row->last_name, 
								'birth_date' => $row->birth_date, 
								'sex' => $row->sex);
		}

		return $results;	
    }	
	/************************************************ /SEARCH PATIENT ************************************************/

	/************************************************ AUTHENTICATE USER ************************************************/
    public function authenticate_db($username, $password) {
		$where_arr = array('username'=>$username, 'password'=>sha1($password));
		$this->db->where($where_arr);
        $query = $this->db->get('users');
        return $query->result();
    }	
	/************************************************ /AUTHENTICATE USER ************************************************/
	
	/************************************************ CHAT ************************************************/	
	public function get_last_item() {
		$this->db->order_by('chat_id', 'DESC');
		$query = $this->db->get('chat', 1);
		return $query->result();
	}	
	
	// Insert chat message into Database
	// Params: 
	//			$user = user who send the chat message	
	//			$message = chat message sent by the user
	public function insert_message($user, $message) {
		$data = array(
			'name'=>$user,
			'message'=>$message,
			'date_sent'=>time()
		);
		$this->db->insert('chat', $data);
	}

	public function get_chat_after($time) {
		$this->db->where('date_sent >', $time);
		$this->db->order_by('date_sent', 'DESC')->limit(10); 
		$query = $this->db->get('chat');

		$results = array();

		foreach ($query->result() as $row) {
			$results[] = array($row->name, $row->message, date("m-d-Y h:i:s", $row->date_sent));
			// $results[] = array($row->name, $row->message, $row->date_sent);
		}		
		
		return array_reverse($results);
	}	
	/************************************************ /CHAT ************************************************/
}