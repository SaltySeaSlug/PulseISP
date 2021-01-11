<?php
	class NAS_model extends CI_Model{

		public function add_nas($data){
			$this->db->insert('nas', $data);
			return true;
		}

		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_nas_devices(){
			$this->db->select('*');
			//$this->db->where('is_admin',0);
			return $this->db->get('nas')->result_array();
		}


		//---------------------------------------------------
		// Get user detial by ID
		public function get_nas_by_id($id){
			$query = $this->db->get_where('nas', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_nas($data, $id){
			$this->db->where('id', $id);
			$this->db->update('nas', $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('nas');
		} 

	}

?>