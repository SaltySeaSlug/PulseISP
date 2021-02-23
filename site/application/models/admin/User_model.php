<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

class User_model extends CI_Model{

		public function add_user($data){
			$this->db->insert($this->config->item('CONFIG_DB_TBL_USER'), $data);
			return true;
		}

		public function add_user_return_id($data)
		{
			$this->db->insert($this->config->item('CONFIG_DB_TBL_USER'), $data);
			return $this->db->insert_id();
		}

		public function add_user1($data, $returnId = false)
		{
			$this->db->insert($this->config->item('CONFIG_DB_TBL_USER'), $data);
			if ($returnId == true) return $this->db->insert_id();
			else return true;
		}

		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_users()
		{
			$this->db->select('*');
			//$this->db->where('is_admin',0);
			return $this->db->get($this->config->item('CONFIG_DB_TBL_USER'))->result_array();
		}


		//---------------------------------------------------
		// Get user detial by ID
		public function get_user_by_id($id)
		{
			$query = $this->db->get_where($this->config->item('CONFIG_DB_TBL_USER'), array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_user($data, $id)
		{
			$this->db->where('id', $id);
			$this->db->update($this->config->item('CONFIG_DB_TBL_USER'), $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{
			$this->db->set('active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update($this->config->item('CONFIG_DB_TBL_USER'));
		}



		function user_id_exists($id)
		{
			$query = $this->db->select('id')->from($this->config->item('CONFIG_DB_TBL_USER'))->where('id' . $id)->get();
			if ($query->num_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}
		function user_accountcode_exists($accountCode)
		{
			$query = $this->db->select('account_code')->from($this->config->item('CONFIG_DB_TBL_USER'))->where('account_code' . $accountCode)->get();
			if ($query->num_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}
	}

?>
