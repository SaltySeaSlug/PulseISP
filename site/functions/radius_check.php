<?php
header('Content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', '1');

$radius = "127.0.0.1";
$username = $creds['username'];
$password = $creds['password'];
// process advanced options to pass to radclient
isset($_REQUEST['debug']) ? $debug = $_REQUEST['debug'] : $debug = "no";
isset($_REQUEST['timeout']) ? $timeout = $_REQUEST['timeout'] : $timeout = 3;
isset($_REQUEST['retries']) ? $retries = $_REQUEST['retries'] : $retries = 3;
isset($_REQUEST['count']) ? $count = $_REQUEST['count'] : $count = 1;
isset($_REQUEST['retries']) ? $requests = $_REQUEST['requests'] : $requests = 3;
// create the optional arguments variable
// convert the debug = yes to the actual debug option which is "-x" to pass to radclient
if ($debug == "yes")
	$debug = "-x";
else
	$debug = "-x";
$radiusport = "1812";
$secret = "testing123";
$dictionaryPath = null;
$options = array("count" => $count, "requests" => $requests, "retries" => $retries, "timeout" => $timeout, "debug" => $debug, "dictionary" => $dictionaryPath);
$successMsg = user_auth($options, $username, $password, $radius, $radiusport, $secret);
echo $successMsg;
?>
