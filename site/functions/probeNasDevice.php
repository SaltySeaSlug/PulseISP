<?php

header('Content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ABSPATH', dirname(dirname(__FILE__)) . '/' );

require ABSPATH . 'includes' . DIRECTORY_SEPARATOR . 'functions.php';
require ABSPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require ABSPATH . 'config.php';

$database = new medoo($config);

if(isset($_GET['ip'])) {
    $ipaddress = $_GET['ip'];
}

if(isset($_GET['us'])) {
    $username = $_GET['us'];
}

if(isset($_GET['pw'])) {
    $password = $_GET['pw'];
}

echo json_encode(getRouterInfo($ipaddress, $username, $password));

?>