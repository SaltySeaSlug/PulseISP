<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

class NAS_model extends CI_Model{

		public function assign_nas_to_ippool($poolid) {

		}

		public function add_nas($data){
			$this->db->insert($this->config->item('CONFIG_DB_TBL_RADNAS'), $data);
			return $this->db->insert_id();
		}

		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_nas_devices()
		{
			$this->db->select('*');
			//$this->db->where('is_admin',0);
			return $this->db->get($this->config->item('CONFIG_DB_TBL_RADNAS'))->result_array();
		}


		//---------------------------------------------------
		// Get user detail by ID
		public function get_nas_by_id($id)
		{
			$query = $this->db->get_where($this->config->item('CONFIG_DB_TBL_RADNAS'), array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_nas($data, $id)
		{
			$this->db->where('id', $id);
			$this->db->update($this->config->item('CONFIG_DB_TBL_RADNAS'), $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update($this->config->item('CONFIG_DB_TBL_RADNAS'));
		}

		function update_last_contact()
		{
			$ip = '100.99.1.255';
			$ttl = 128;
			$timeout = 1;

			if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
				try {
					$ping = new JJG\Ping($ip, $ttl, $timeout);
					$latency = $ping->ping('exec');

					if ($latency !== false) {
						echo $latency;
					} else {
						echo "ERR";
					}
				} catch (Exception $e) {
					echo "ERR";
				}
			}
		}
	}

?>
