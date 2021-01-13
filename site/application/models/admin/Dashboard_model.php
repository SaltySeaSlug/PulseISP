<?php
	class Dashboard_model extends CI_Model{

		public function get_all_users(){
			return $this->db->count_all('ci_users');
		}
		public function get_active_users(){
			$this->db->where('is_active', 1);
			return $this->db->count_all_results('ci_users');
		}
		public function get_deactive_users(){
			$this->db->where('is_active', 0);
			return $this->db->count_all_results('ci_users');
		}

		public function get_all_ips() {
			//$this->db->where('radippool', 0);
			return $this->db->count_all('radippool');
		}
		public function get_free_ips() {
			$this->db->where('username', NULL);
			return $this->db->count_all_results('radippool');
		}
		public function get_used_ips() {
			$this->db->where('username NOT NULL');
			return $this->db->count_all_results('radippool');
		}
		public function get_active_user_sessions() {
			$this->db->where('acctstoptime', NULL);
			return $this->db->count_all_results('radacct');
		}

		public function get_all_alerts() {
			return 0;
		}
	}

?>
