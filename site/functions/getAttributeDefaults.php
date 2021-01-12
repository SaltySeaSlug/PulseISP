<?php

header('Content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ABSPATH', dirname(dirname(__FILE__)) . '/' );

require ABSPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require ABSPATH . 'config.php';


if(isset($_GET['attribute'])) {
    $attributeid = $_GET['attribute'];
}

if ($_GET['attribute'] == "None") {
    $values[] = "None";
    return;
}

$database = new medoo($config);
$result = $database->select("dictionary", "*", ["id" => $attributeid]);
$values = [];

if ($result > 0) {
    foreach($result as $row) {
        $values[] = $row['Value'] ?? null;
        $values[] = $row['RecommendedOP'] ?? ':=';
        $values[] = $row['RecommendedTable'] ?? 'reply';
    }
} else {
    $values[] = null;
    $values[] = ':=';
    $values[] = 'reply';
}

echo json_encode($values);

?>