<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/14, 13:50
 */

header('Content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ABSPATH', dirname(dirname(__FILE__)) . '/' );

require ABSPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require ABSPATH . 'config.php';

if (isset($_GET['table']) && !empty($_GET['table']) && isset($_GET['id']) && !empty($_GET['id'])) {
    getDetails($config, $_GET['table'], $_GET['id']);
}

function getDetails($dbConfig, $table, $id)
{
    $requestData = $_REQUEST;
    $database = new medoo($dbConfig);
    $result = $database->get($table, "*", ["id" => $id]);

    echo json_encode($result);
}

?>
