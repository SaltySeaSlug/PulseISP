<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

header('Content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', '1');

define("REQUEST", "external");
define('ABSPATH', dirname(dirname(__FILE__)) . '/' );
ob_start();
//require('instance.php');
require ABSPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
ob_end_clean();




$result = '';

if (isset($_GET['us'])) {
	$username = $_GET['us'];

	$ci = &get_instance();
	$count = $ci->db->where(['username' => $username])->from($this->config->item('CONFIG_DB_TBL_USER'))->count_all_results();

	if ($count == 0 || $count == null) $result = 'ERR';
	else  $result = 'OK';

} else { $result = 'No username supplied'; }

echo json_encode($result);

?>
