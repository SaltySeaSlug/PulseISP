<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

class Ippool_model extends CI_Model{

		function array_xor ($array_a, $array_b)
		{
			$union_array = array_merge($array_a, $array_b);
			$intersect_array = array_intersect($array_a, $array_b);
			return array_diff($union_array, $intersect_array);
		}

		public function assign_ippool_to_nas($nasid) {

		}

		public function get_all_ippools()
		{
			$this->db->select('DISTINCT(pool_name), MIN(id) as id');
			$this->db->group_by('pool_name');
			return $this->db->get($this->config->item('CONFIG_DB_TBL_RADIPPOOL'))->result_array();

			//return $this->db->query('SELECT DISTINCT(pool_name), MIN(id) as id FROM '.$this->config->item('CONFIG_DB_TBL_RADIPPOOL').' GROUP BY pool_name')->result_array();
		}

		public function link_pool_to_nas($nasId, $poolId)
		{
			$nas = $this->db->query("SELECT nasname FROM " . $this->config->item('CONFIG_DB_TBL_RADNAS') . " WHERE id = " . $nasId)->row()->nasname;
			$pool = $this->db->query("SELECT pool_name FROM " . $this->config->item('CONFIG_DB_TBL_RADIPPOOL') . " WHERE id = " . $poolId)->row()->pool_name;
			$link = $this->db->query("SELECT * FROM " . $this->config->item('CONFIG_DB_TBL_RADNAS_POOL_NAME') . " WHERE nas_ip_address ='\". $nas . \"'");

			if ($link->num_rows() > 0) {
				// IF RECORD EXISTS UPDATE RECORD
			} else {
				return $this->db->insert($this->config->item('CONFIG_DB_TBL_RADNAS_POOL_NAME'), ['nas_ip_address' => $nas, 'pool_name' => $pool]);
			}
		}

		public function link_pool_to_nas_by_poolname($nasId, $poolName)
		{
			$nas = $this->db->query("SELECT nasname FROM " . $this->config->item('CONFIG_DB_TBL_RADNAS') . " WHERE id = " . $nasId)->row()->nasname;
			$link = $this->db->query("SELECT * FROM " . $this->config->item('CONFIG_DB_TBL_RADNAS_POOL_NAME') . " WHERE nas_ip_address ='\". $nas . \"'");

			if ($link->num_rows() > 0) {
				// IF RECORD EXISTS UPDATE RECORD
			} else {
				return $this->db->insert($this->config->item('CONFIG_DB_TBL_RADNAS_POOL_NAME'), ['nas_ip_address' => $nas, 'pool_name' => $poolName]);
			}
		}

		public function unlink_pool_from_nas($nasId, $poolId)
		{
			$nas = $this->db->query("SELECT nasname FROM " . $this->config->item('CONFIG_DB_TBL_RADNAS') . " WHERE id = " . $nasId)->row()->nasname;
			return $this->db->delete($this->config->item('CONFIG_DB_TBL_RADNAS_POOL_NAME'), ['nas_ip_address' => $nas]);
		}

		public function get_ips_by_poolname($poolname) {
			$this->db->select('framedipaddress');
			$query = $this->db->get_where($this->config->item('CONFIG_DB_TBL_RADIPPOOL'), ['pool_name' => $poolname])->result_array();
			return array_column($query, 'framedipaddress');
		}

		public function add_bulk_ips($data){
			if (count($data) > 0) {
				$this->db->insert_batch($this->config->item('CONFIG_DB_TBL_RADIPPOOL'), $data);
			}
			return true;
		}

		//---------------------------------------------------
		// IP Addresses
		public function get_all_ips(){
			$this->db->select('*');
			return $this->db->get($this->config->item('CONFIG_DB_TBL_RADIPPOOL'))->result_array();
		}
		public function get_all_allocated_ips(){
			$this->db->select('*');
			$this->db->where('username IS NOT NULL');
			return $this->db->get($this->config->item('CONFIG_DB_TBL_RADIPPOOL'))->result_array();
		}
		public function get_all_unallocated_ips(){
			$this->db->select('*');
			$this->db->where('username IS NULL');
			return $this->db->get($this->config->item('CONFIG_DB_TBL_RADIPPOOL'))->result_array();
		}
	}

?>
