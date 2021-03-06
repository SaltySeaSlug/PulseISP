<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/19, 15:05
 */

class Data extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		header('Content-type: application/json');
	}

	//-------------------------------------------------------------------------
	public function index()
	{
	}
	//-------------------------------------------------------------------------


	// Check if username exists
	public function check_portal_username()
	{
		$username = isset($_GET['un']) ? $_GET['un'] : null;
		if (empty($username)) return false;

		if ($this->db->where(['username' => $username])->from($this->config->item('CONFIG_DB_TBL_USER'))->count_all_results() == 0) {
			echo json_encode(false);
		} else {
			echo json_encode(true);
		}
	}
	public function check_admin_username()
	{
		$username = isset($_GET['un']) ? $_GET['un'] : null;
		if (empty($username)) return false;

		if ($this->db->where(['username' => $username])->from($this->config->item('CONFIG_DB_TBL_ADMIN'))->count_all_results() == 0) {
			echo json_encode(false);
		} else {
			echo json_encode(true);
		}
	}
	public function check_data_account_username($username = null)
	{
		$un = isset($_GET['un']) ? $_GET['un'] : null;

		if (!empty($username)) {
			$un = $username;
		}

		if (empty($un)) echo false;

		if ($this->db->where(['username' => $un])->from($this->config->item('CONFIG_DB_TBL_DATA_ACCOUNT'))->count_all_results() == 0) {
			echo false;
		} else {
			echo true;
		}
	}

	// Generate
	public function generate_user_account_code() {
		$result = '';
		$accountCode = isset($_GET['ac']) ? $_GET['ac'] : null;
		$name = isset($_GET['name']) ? $_GET['name'] : null;
		$query = null;

		if (!empty($accountCode) || !empty($name)) {
			$CI =& get_instance();

			if (!empty($accountCode)) {
				$CI->db->select_max('account_code', $accountCode);
				$query = $CI->db->get($this->config->item('CONFIG_DB_TBL_USER'))->row();
			}

			if (!empty($query)) {
				$name = substr($query->firstname, 0, 3);

				if (is_null($query->account_code)) {
					$res = preg_replace("/[a-zA-Z]/", "", $query->account_code);
				} else {
					$res = 00000;
				}
				$result = generate_numbers(strtoupper($name), (int)$res);
			} else {
				$result = 'Generating new account code using supplied firstname';

				if (!empty($name)) {
					$name1 = substr($name, 0, 3);

					$res = preg_replace("/[a-zA-Z]/", "", $name1);
					$result = generate_numbers(strtoupper($name1), (int)$res);
				}
			}

			$response_array['status'] = 'OK';
		} else {
			$response_array['status'] = 'ERR';
		}

		$response_array['result'] = $result;
		echo json_encode($response_array);
	}
	public function generate_data_account_username() {
		$result = '';
		$name = isset($_GET['firstname']) ? $_GET['firstname'] : null;
		$surname = isset($_GET['lastname']) ? $_GET['lastname'] : null;
		$general_settings = $this->setting_model->get_general_settings();

		if (!empty($name) || !empty($surname)) {
			$result = $this->generate_username($name, $surname, $general_settings['realm_suffix']);
			$response_array['status'] = 'OK';
		} else {
			$response_array['status'] = 'ERR';
		}

		$response_array['result'] = $result;
		echo json_encode($response_array);
	}
	private function generate_username($firstname, $lastname, $realm, $count = 1) {
		$name = substr($firstname, 0, $count);
		$surname = $lastname;
		$username = $surname . '.' . $name . (!empty($realm) ? '@' . $realm : '');

		if ($this->check_data_account_username($username)) {
			return $this->generate_username($firstname, $lastname, $realm, rand($count, str_word_count($name)));
		} else {
			return $username;
		}
	}




	public function doSNMP(){
		$snmp = new \OSS_SNMP\SNMP('100.99.1.255','public');
		echo "All: " . $snmp->useMikrotik()->activePPPoECount();
		echo "Unity: " . $snmp->useMikrotik()->activePPPoECount("unity");
		echo "Hnet: " . $snmp->useMikrotik()->activePPPoECount("hnet");

		echo "All: " . json_encode($snmp->useMikrotik()->activePPPoEList());
		echo "Unity: " . json_encode($snmp->useMikrotik()->activePPPoEList("unity"));
		echo "Hnet: " . json_encode($snmp->useMikrotik()->activePPPoEList("hnet"));

		echo $snmp->useMikrotik()->model();
		echo $snmp->useMikrotik()->identity();
		echo secondsToTime($snmp->useMikrotik()->uptime());
		echo 'CPU Usage: ' . $snmp->useMikrotik()->getCPUUsage() . ' %';
	}
	public function freeradiusStatus() {
		$output = null;
		$output = shell_exec("echo 'Message-Authenticator = 0x00, FreeRADIUS-Statistics-Type = All' | radclient localhost:18121 status tSxbnRo0E1U4Mkt- -x");
		echo "<pve>". json_encode($output) . "</pve>";
	}
	public function checkDevice() {

		if (isset($_GET['ip']) && !empty($_GET['ip'])) {
			$ip = $_GET['ip'];

			if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
				$ttl = 128;
				$timeout = 1;

				try {
					$ping = new JJG\Ping($ip, $ttl, $timeout);
					$latency = $ping->ping('exec');

					if ($latency !== false) {
						echo "<div class='alert alert-success'><b>Ping:</b> $latency ms</div>";
					} else {
						echo "<div class='alert alert-danger'><b>No Ping Response</b> (Is the device accessible?)</div>";
					}
				} catch (Exception $e) {
					echo "<div class='alert alert-danger'><b>No Ping Response</b> (Is the device accessible?)</div>";
				}

				try {
					$snmpHost = new \OSS_SNMP\SNMP($ip, "public");
					$model = $snmpHost->getPlatform()->getModel();
					$os = $snmpHost->getPlatform()->getOs();
					$vendor = $snmpHost->getPlatform()->getVendor();
					$identity = null;
					$uptime = null;

					if ($vendor == 'Mikrotik') {
						$identity = $snmpHost->useMikrotik()->identity();
						$uptime = secondsToTime($snmpHost->useMikrotik()->uptime());
					}

					echo "<div class='alert alert-success'><b>SNMP Response:</b> $os $model<br><b>Device Vendor:</b> $vendor<br> <b>Device Identity:</b> $identity<br> <b>Device Uptime:</b> $uptime<br></div>";

				} catch (Exception $e) {
					echo "<div class='alert alert-danger'><b>No SNMP Response</b> (Is SNMP enabled on the device?)</div>";
				}

			} else {
				echo "<div class='alert alert-danger'><b>No SNMP Response</b> (Is SNMP enabled on the device?)</div>";
			}
		}
	}

	function update_last_contact()
	{
		if (isset($_GET['ip']) && !empty($_GET['ip'])) {
			$ip = $_GET['ip'];
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
















	public function get_vendor_attributes()
	{
		header('Content-type: application/json');
		$vendor = isset($_GET['vendor']) ? $_GET['vendor'] : null;
		$result = $this->db->query('SELECT MAX(id), attribute FROM ' . $this->config->item('CONFIG_DB_TBL_RADDICTIONARY') . ' WHERE vendor = \'' . $vendor . '\'  GROUP BY attribute ORDER BY attribute ASC');

		if ($result->num_rows() > 0) {
			$attributes[] = '<option selected>None</option>';

			foreach ($result->result_array() as $row) {
				$attributes[] = '<option value="' . $row['attribute'] . '">' . $row['attribute'] . '</option>';
			}
		} else {
			$attributes[] = null;
		}

		echo json_encode($attributes);
	}
	public function get_attribute_defaults()
	{
		header('Content-type: application/json');
		$attributeid = isset($_GET['attribute']) ? $_GET['attribute'] : null;


		$this->db->select("*", ["id" => $attributeid]);
		$result = $this->db->get_where($this->config->item('CONFIG_DB_TBL_RADDICTIONARY'), array('id' => $attributeid));
		$values = [];

		if ($result->num_rows() > 0) {
			foreach ($result->result_array() as $row) {
				$values[] = $row['value'] ?? null;
				$values[] = $row['recommended_op'] ?? ':=';
				$values[] = $row['recommended_table'] ?? 'reply';
			}
		} else {
			$values[] = null;
			$values[] = ':=';
			$values[] = 'reply';
		}

		echo json_encode($values);
	}
	public function getChartUsageData()
	{
		$action = isset($_GET['action']) ? $_GET['action'] : null;
		$period = isset($_GET['period']) ? $_GET['period'] : null;

		$json_data = null;

		switch ($period)
		{
			case 'T':
				{
					$today = $this->db->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download, HOUR(`acctstarttime`) as hour FROM " . $this->config->item('CONFIG_DB_TBL_RADACCT') . " WHERE DATE(`acctstarttime`) = CURDATE() GROUP BY HOUR(`acctstarttime`) ORDER BY HOUR(`acctstarttime`) ASC")->result_array();
					$todayCount = $this->db->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download FROM " . $this->config->item('CONFIG_DB_TBL_RADACCT') . " WHERE DATE(acctstarttime) = CURDATE()")->row();

					$data = range(0, 23);

					foreach ($today as $row) {
						$data[$row['hour']] = array("downloaded" => toxBytes($row['download'], 'B'), "uploaded" => toxBytes($row['upload'], 'B'), "period" => $row['hour']);
					}

					$count = 0;
					foreach (array_keys($data) as $index => $key) {
						if ($index == $count && is_numeric($data[$key])) {
						$data[$key] = array("period" => $key);
					}
					$count++;
				}

				$json_data = array("count" => array("downloaded" => $todayCount->download ?? 0, "uploaded" => $todayCount->upload ?? 0), "chartdata" => $data);
			} break;
			case 'W':
				{
					$thisweek = $this->db->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download, DAYNAME(`acctstarttime`) as day FROM " . $this->config->item('CONFIG_DB_TBL_RADACCT') . " WHERE WEEK(acctstarttime, 0) = WEEK(CURDATE(), 0) GROUP BY DAYNAME(`acctstarttime`) ORDER BY DAYOFWEEK(day)")->result_array();
					$thisweekCount = $this->db->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download FROM " . $this->config->item('CONFIG_DB_TBL_RADACCT') . " WHERE WEEK(acctstarttime, 0) = WEEK(CURDATE(), 0)")->row();

					$data = range(0, 6);
					foreach ($thisweek as $row) {
						$data[getWeekday($row['day'])] = array("downloaded" => toxBytes($row['download'], 'B'), "uploaded" => toxBytes($row['upload'], 'B'), "period" => $row['day']);
					}
					$count = 0;
					foreach (array_keys($data) as $index => $key) {
						if ($index == $count && is_numeric($data[$key])) {
							$data[$key] = array("period" => getDay($key));
						}
					$count++;
				}

				$json_data = array("count" => array("downloaded" => $thisweekCount->download ?? 0, "uploaded" => $thisweekCount->upload ?? 0), "chartdata" => $data);
			} break;
			case 'M':
				{
					$thismonth = $this->db->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download, DAY(`acctstarttime`) as day FROM " . $this->config->item('CONFIG_DB_TBL_RADACCT') . " WHERE YEAR(`acctstarttime`) = YEAR(CURRENT_DATE()) AND MONTH(`acctstarttime`) = MONTH(CURRENT_DATE()) GROUP BY DAY(`acctstarttime`) ORDER BY DAY(`acctstarttime`) ASC")->result_array();
					$thismonthCount = $this->db->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download FROM " . $this->config->item('CONFIG_DB_TBL_RADACCT') . " WHERE YEAR(`acctstarttime`) = YEAR(CURRENT_DATE()) AND MONTH(`acctstarttime`) = MONTH(CURRENT_DATE())")->row();

					$data = range(1, date('t') + 1);
					foreach ($thismonth as $row) {
						$data[$row['day']] = array("downloaded" => toxBytes($row['download'], 'B'), "uploaded" => toxBytes($row['upload'], 'B'), "period" => $row['day']);
					}
					$count = 0;
					foreach (array_keys($data) as $index => $key) {
						if ($count != 0 && $index == $count && is_numeric($data[$key])) {
							$data[$key] = array("period" => $key);
						}
					if ($count == 0) unset($data[$key]);
					$count++;
				}
				$json_data = array("count" => array("downloaded" => $thismonthCount->download ?? 0, "uploaded" => $thismonthCount->upload ?? 0), "chartdata" => $data);
			} break;
			default: break;
		}

		echo json_encode($json_data);
	}
	public function getChartAuthData()
	{
		$action = isset($_GET['action']) ? $_GET['action'] : null;
		$period = isset($_GET['period']) ? $_GET['period'] : null;

		$requestData = $_REQUEST;
		$json_data = null;

		switch ($period)
		{
			case 'T':
				{
					$today = $this->db->query("SELECT HOUR(`authdate`) as hour, COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject FROM " . $this->config->item('CONFIG_DB_TBL_RADPOSTAUTH') . " WHERE DATE(`authdate`) = CURDATE() GROUP BY HOUR(`authdate`)")->result_array();
					$todayCount = $this->db->query("SELECT COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject FROM " . $this->config->item('CONFIG_DB_TBL_RADPOSTAUTH') . " WHERE DATE(`authdate`) = CURDATE()")->row();

					$data = range(0, 23);

					foreach ($today as $row) {
						$data[$row['hour']] = array("accept" => $row['accept'], "reject" => $row['reject'], "period" => $row['hour']);
					}
					$count = 0;
					foreach (array_keys($data) as $index => $key) {
						if ($index == $count && is_numeric($data[$key])) {
							$data[$key] = array("period" => $key);
					}
					$count++;
				}

				$json_data = array("count" => array("accepted" => $todayCount->accept, "rejected" => $todayCount->reject), "chartdata" => $data);
			} break;
			case 'W':
				{
					$thisweek = $this->db->query("SELECT COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject, DAYNAME(`authdate`) as day FROM " . $this->config->item('CONFIG_DB_TBL_RADPOSTAUTH') . " WHERE YEARWEEK(`authdate`, 0) = YEARWEEK(CURDATE(), 0) GROUP BY DAYNAME(`authdate`)")->result_array();
					$thisweekCount = $this->db->query("SELECT COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject, DAYNAME(`authdate`) as day FROM " . $this->config->item('CONFIG_DB_TBL_RADPOSTAUTH') . " WHERE YEARWEEK(`authdate`, 0) = YEARWEEK(CURDATE(), 0) GROUP BY day")->row();

					$data = range(0, 6);
					foreach ($thisweek as $row) {
						$data[getWeekday($row['day'])] = array("accept" => $row['accept'], "reject" => $row['reject'], "period" => $row['day']);
					}
					$count = 0;
					foreach (array_keys($data) as $index => $key) {
						if ($index == $count && is_numeric($data[$key])) {
							$data[$key] = array("period" => getDay($key));
						}
					$count++;
				}

				$json_data = array("count" => array("accepted" => $thisweekCount->accept, "rejected" => $thisweekCount->reject), "chartdata" => $data);
			} break;
			case 'M':
				{
					$thismonth = $this->db->query("SELECT DAY(`authdate`) as day, COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject FROM " . $this->config->item('CONFIG_DB_TBL_RADPOSTAUTH') . " WHERE YEAR(`authdate`) = YEAR(CURRENT_DATE()) AND MONTH(`authdate`) = MONTH(CURRENT_DATE()) GROUP BY DAY(`authdate`)")->result_array();
					$thismonthCount = $this->db->query("SELECT DAY(`authdate`) as day, COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject FROM " . $this->config->item('CONFIG_DB_TBL_RADPOSTAUTH') . " WHERE YEAR(`authdate`) = YEAR(CURRENT_DATE()) AND MONTH(`authdate`) = MONTH(CURRENT_DATE()) GROUP BY day")->row();

					$data = range(1, date('t') + 1);
					foreach ($thismonth as $row) {
						$data[$row['day']] = array("accept" => $row['accept'], "reject" => $row['reject'], "period" => $row['day']);
					}
					$count = 0;
					foreach (array_keys($data) as $index => $key) {
						if ($count != 0 && $index == $count && is_numeric($data[$key])) {
							$data[$key] = array("period" => $key);
						}
					if ($count == 0) unset($data[$key]);
					$count++;
				}
				$json_data = array("count" => array("accepted" => $thismonthCount->accept, "rejected" => $thismonthCount->reject), "chartdata" => $data);
			} break;
			default: break;
		}

		echo json_encode($json_data);
	}
}



?>
