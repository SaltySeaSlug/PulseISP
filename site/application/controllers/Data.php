<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends MY_Controller
{

	public function __construct()
	{

		parent::__construct();
		$this->load->model('admin/Setting_model', 'setting_model');
	}

	//-------------------------------------------------------------------------

	public function index()
	{
		echo 'Hello World!';
	}


	//-------------------------------------------------------------------------
	function generate_numbers($letter, $start, $digits = 5)
	{
		return $letter . str_pad($start + 1, $digits, "0", STR_PAD_LEFT);
	}

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
					$result = $this->generate_numbers(strtoupper($name1), (int)$res);
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
}



?>
