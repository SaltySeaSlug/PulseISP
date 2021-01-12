<?php
header('Content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', '1');

define("REQUEST", "external");
define('ABSPATH', dirname(dirname(__FILE__)) . '/' );
ob_start();
require('instance.php');
require ABSPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
ob_end_clean();

$result = '';
$maxid = 0;
$accountCode = isset($_GET['ac']) ? $_GET['ac'] : null;
$name = isset($_GET['name']) ? $_GET['name'] : null;
$query = null;

function generate_numbers($letter, $start, $digits = 5)
{
	return $letter . str_pad($start + 1, $digits, "0", STR_PAD_LEFT);
}

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
	if (isset($_GET['name'])) {
		$name = substr($_GET['name'], 0, 3);

		$res = preg_replace("/[a-zA-Z]/", "", $name);
		$result = generate_numbers(strtoupper($name), (int)$res);
	}
}

	$response_array['status'] = 'OK';
} else { $response_array['status'] = 'ERR'; }

$response_array['result'] = $result;
echo json_encode($response_array);




/*
if (isset($_GET['company'])) {
    $name = substr($_GET['company'], 0, 3);
	$CI =& get_instance();

$this->db->select_max('id');
$query = $this->db->get('emplyee_personal_details');


$row = $this->db->query('SELECT MAX(id) AS `maxid` FROM `emplyee_personal_details`')->row();
if ($row) {
	$maxid = $row->maxid;

	//$db = $CI->db->max("clients", "account_code", ["account_code[~]" => $name]);
    $res = preg_replace("/[a-zA-Z]/", "", $db);
    $result = generate_numbers(strtoupper($name), (int)$res);
}

if (isset($_GET['name'])) {
    $name = substr($_GET['name'], 0, 3);

    $db = $database->max("clients", "account_code", ["account_code[~]" => $name]);
    $res = preg_replace("/[a-zA-Z]/", "", $db);
    $result = generate_numbers(strtoupper($name), (int)$res);
}

echo json_encode($result);
*/
?>
