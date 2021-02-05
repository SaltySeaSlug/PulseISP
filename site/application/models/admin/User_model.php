<?php
	class User_model extends CI_Model{

		public function add_user($data){
			$this->db->insert('ci_users', $data);
			return true;
		}

		public function add_user_return_id($data){
			$this->db->insert('ci_users', $data);
			return $this->db->insert_id();
		}

		public function add_user1($data, $returnId = false){
			$this->db->insert('ci_users', $data);
			if ($returnId == true) return $this->db->insert_id();
			else return true;
		}

		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_users(){
			$this->db->select('*');
			$this->db->where('is_admin',0);
			return $this->db->get('ci_users')->result_array();
		}


		//---------------------------------------------------
		// Get user detial by ID
		public function get_user_by_id($id){
			$query = $this->db->get_where('ci_users', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_user($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_users', $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_users');
		}



		function user_id_exists($id) {
			$query = $this->db->select('id')->from('ci_users')->where('id'. $id)->get();
			if ($query->num_rows() > 0) { return true;} else { return false; }
		}
		function user_accountcode_exists($accountCode) {
			$query = $this->db->select('account_code')->from('ci_users')->where('account_code'. $accountCode)->get();
			if ($query->num_rows() > 0) { return true;} else { return false; }
		}
	}

?>
