<?php

header('Content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ABSPATH', dirname(dirname(__FILE__)) . '/' );

require ABSPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require(ABSPATH . 'includes' . DIRECTORY_SEPARATOR . 'functions.php');
require ABSPATH . 'config.php';

if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'customerTable' :
            customerTable($config);
            break;
    }
}

function customerTable($dbConfig)
{
    $requestData = $_REQUEST;
    $database = new medoo($dbConfig);

    $db = $database->select("clients", "*");
    $result = array();

    foreach ($db as $row) {
        $result[] = array("id" => $row['id'], "name" => $row['name'], "surname" => $row['surname']);
    }

    $json_data = array(
        "sEcho" => 1,
        "draw"            => intval( $_REQUEST['draw'] ?? 1 ),
        "recordsTotal"    => count( $result ),
        "recordsFiltered" => count( $result ),
        "data"            => $result);

    echo json_encode($json_data);
}


?>