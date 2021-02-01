<?php
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
			return $this->db->query("SELECT DISTINCT(pool_name), MIN(id) as id FROM radippool GROUP BY pool_name")->result_array();
		}

		public function link_pool_to_nas($nasId, $poolId) {
			$query_nas = $this->db->get_where('radnas', ['id' => $nasId]);
			return $this->db->insert('radnas_pool_names', ['nas_ip_address' => $nasIpAddress, 'pool_nmme' => $poolName]);
		}

		public function get_ips_by_poolname($poolname) {
			$this->db->select('framedipaddress');
			$query = $this->db->get_where('radippool', ['pool_name' => $poolname])->result_array();
			return array_column($query, 'framedipaddress');
		}

		public function add_bulk_ips($data){
			if (count($data) > 0) {
				$this->db->insert_batch('radippool', $data);
			}
			return true;
		}

		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_ips(){
			$this->db->select('*');
			//$this->db->where('is_admin',0);
			return $this->db->get('radippool')->result_array();
		}


		//---------------------------------------------------
		// Get user detial by ID
		public function get_nas_by_id($id){
			$query = $this->db->get_where('radnas', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_nas($data, $id){
			$this->db->where('id', $id);
			$this->db->update('radnas', $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('radnas');
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
