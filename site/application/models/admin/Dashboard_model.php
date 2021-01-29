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

		public function daily() {
			$today = date("Y-m-d");
			$start = $today.' 00:00:00';
			$end = $today.' 23:59:59';
			$username = 'test@test';

			$query = $this->db->query('SELECT FLOOR(SUM(acctinputoctets+acctoutputoctets)/1024/1024) as total FROM radacct WHERE username=\''.$username.'\' AND acctstarttime > \''.$start.'\' AND acctstoptime < \''.$end.'\'');
			$row = $query->row();

			return isset($row->total) ? $row->total : 0;
		}

		public function monthly() {
			$this_month =  date("Y-m");
			$start = date('Y-m-01 00:00:00', strtotime($this_month));
			$end = date('Y-m-t 00:00:00', strtotime($this_month));
			$username = 'test@test';

			$query = $this->db->query('SELECT FLOOR(SUM(acctinputoctets+acctoutputoctets)/1024/1024) as total FROM radacct WHERE username=\''.$username.'\' AND acctstarttime > \''.$start.'\' AND acctstoptime < \''.$end.'\'');
			$row = $query->row();

			return isset($row->total) ? $row->total : 0;
		}

		public function top($from,$to,$take = 10,$order = 'download',$order_type = 'desc') {//$this->db->save_queries = TRUE;
			$query = $this->db->query('SELECT DISTINCT(radacct.username),radacct.acctstarttime,MAX(radacct.acctstoptime) AS acctstoptime, radacct.radacctid, SUM(radacct.acctsessiontime) AS `time`, SUM(radacct.acctinputoctets) AS upload, SUM(radacct.acctoutputoctets) AS download FROM radacct WHERE radacct.acctstarttime > \''.$from.'\' AND acctstarttime < \''.$to.'\' GROUP BY radacct.username ORDER BY '.$order.' '.$order_type.' LIMIT '.$take);
			return $query->result_array();
		}
	}

?>
