<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends MY_Controller
{

	public function __construct()
	{

		parent::__construct();
		$this->load->model('admin/Setting_model', 'setting_model');

		header('Content-type: application/json');

	}

	//-------------------------------------------------------------------------

	public function index()
	{
		echo 'Hello World!';
	}


	//-------------------------------------------------------------------------

	public function generate_account_code()
	{
		header('Content-type: application/json');

		$result = '';
		$maxid = 0;
		$accountCode = isset($_GET['ac']) ? $_GET['ac'] : null;
		$name = isset($_GET['name']) ? $_GET['name'] : null;
		$query = null;


		if (!empty($accountCode) || !empty($name)) {
			//$accountCode = $_GET['ac'];
			$CI =& get_instance();

			if (!empty($accountCode)) {
				$CI->db->select_max('account_code', $accountCode);
				$query = $CI->db->get('ci_users')->row();
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


	public function generate_username($firstname, $lastname, $realm, $count = 1)
	{
		$name = substr($firstname, 0, $count);
		$surname = $lastname;
		$username = $surname . '.' . $name . '@' . $realm;

		if ($this->check_if_username_exists($username)) {
			return $this->generate_username($firstname, $lastname, $realm, rand($count, 10));
		} else {
			return $username;

		}
	}

	public function check_if_username_exists($username)
	{
		if ($this->db->where(['username' => $username])->from("ci_users")->count_all_results() == 0) {
			return false;
		} else {
			return true;
		}
	}

	public function generate_ppp_username()
	{
		header('Content-type: application/json');
		$result = '';
		$name = isset($_GET['firstname']) ? $_GET['firstname'] : null;
		$surname = isset($_GET['lastname']) ? $_GET['lastname'] : null;
		$general_settings = $this->setting_model->get_general_settings();

		//$name = substr($name, 0, 1);


		if (!empty($name) || !empty($surname)) {
			$result = $this->generate_username($name, $surname, $general_settings['realm_suffix']);
			$response_array['status'] = 'OK';
		} else {
			$response_array['status'] = 'ERR';
		}

		$response_array['result'] = $result;
		echo json_encode($response_array);
	}

	public function check_username()
	{
		header('Content-type: application/json');

		$username = isset($_GET['username']) ? $_GET['username'] : null;

		if ($this->db->where(['username' => $username])->from("ci_users")->count_all_results() == 0) {
			echo json_encode(false);
		} else {
			echo json_encode(true);
		}
	}

	public function get_vendor_attributes()
	{
		header('Content-type: application/json');
		$vendor = isset($_GET['vendor']) ? $_GET['vendor'] : null;
		$result = $this->db->query('SELECT MAX(id), attribute FROM raddictionary WHERE vendor = \'' . $vendor . '\'  GROUP BY attribute ORDER BY attribute ASC');

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

	public function get_attribute_defaults(){
		header('Content-type: application/json');
		$attributeid = isset($_GET['attribute']) ? $_GET['attribute'] : null;


		$this->db->select("*", ["id" => $attributeid]);
		$result = $this->db->get_where('raddictionary', array('id' => $attributeid));
		$values = [];

		if ($result->num_rows() > 0) {
			foreach($result->result_array() as $row) {
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
			case 'T': {
				$today = $this->db->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download, HOUR(`timestamp`) as hour FROM ppp_accounts_stats WHERE DATE(`timestamp`) = CURDATE() GROUP BY HOUR(`timestamp`) ASC")->result_array();
				$todayCount = $this->db->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download FROM ppp_accounts_stats WHERE DATE(timestamp) = CURDATE()")->row();

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
			case 'W': {
				$thisweek = $this->db->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download, DAYNAME(`timestamp`) as day FROM ppp_accounts_stats WHERE WEEK(timestamp, 0) = WEEK(CURDATE(), 0) GROUP BY DAYNAME(`timestamp`) ORDER BY DAYOFWEEK(day)")->result_array();
				$thisweekCount = $this->db->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download FROM ppp_accounts_stats WHERE WEEK(timestamp, 0) = WEEK(CURDATE(), 0)")->row();

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
			case 'M': {
				$thismonth = $this->db->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download, DAY(`timestamp`) as day FROM ppp_accounts_stats WHERE YEAR(`timestamp`) = YEAR(CURRENT_DATE()) AND MONTH(`timestamp`) = MONTH(CURRENT_DATE()) GROUP BY DAY(`timestamp`) ASC")->result_array();
				$thismonthCount = $this->db->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download FROM ppp_accounts_stats WHERE YEAR(`timestamp`) = YEAR(CURRENT_DATE()) AND MONTH(`timestamp`) = MONTH(CURRENT_DATE())")->row();

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
			case 'T': {
				$today = $this->db->query("SELECT HOUR(`authdate`) as hour, COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject FROM radpostauth WHERE DATE(`authdate`) = CURDATE() GROUP BY HOUR(`authdate`)")->result_array();
				$todayCount = $this->db->query("SELECT COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject FROM radpostauth WHERE DATE(`authdate`) = CURDATE()")->row();

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
			case 'W': {
				$thisweek = $this->db->query("SELECT COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject, DAYNAME(`authdate`) as day FROM radpostauth WHERE YEARWEEK(`authdate`, 0) = YEARWEEK(CURDATE(), 0) GROUP BY DAYNAME(`authdate`) ORDER BY DAYOFWEEK(day)")->result_array();
				$thisweekCount = $this->db->query("SELECT COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject, DAYNAME(`authdate`) as day FROM radpostauth WHERE YEARWEEK(`authdate`, 0) = YEARWEEK(CURDATE(), 0)")->row();

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
			case 'M': {
				$thismonth = $this->db->query("SELECT DAY(`authdate`) as day, COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject FROM radpostauth WHERE YEAR(`authdate`) = YEAR(CURRENT_DATE()) AND MONTH(`authdate`) = MONTH(CURRENT_DATE()) GROUP BY DAY(`authdate`) ASC")->result_array();
				$thismonthCount = $this->db->query("SELECT DAY(`authdate`) as day, COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject FROM radpostauth WHERE YEAR(`authdate`) = YEAR(CURRENT_DATE()) AND MONTH(`authdate`) = MONTH(CURRENT_DATE())")->row();

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
