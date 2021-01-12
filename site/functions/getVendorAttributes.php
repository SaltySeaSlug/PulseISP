<?php

header('Content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ABSPATH', dirname(dirname(__FILE__)) . '/' );

require ABSPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require ABSPATH . 'config.php';

if(isset($_GET['vendor'])) {
    $vendor = $_GET['vendor'];
}

if ($_GET['vendor'] == "None") {
    $attributes[] = "None";
    return;
}

$database = new medoo($config);

$result = $database->query("SELECT MAX(id), Attribute FROM dictionary WHERE Vendor = '$vendor'  GROUP BY Attribute ORDER BY Attribute ASC")->fetchAll();

if ($result > 0) {
    $attributes[] = '<option selected>None</option>';

    foreach($result as $row) {
        $attributes[] = '<option value="'.$row['Attribute'].'">'.$row['Attribute'].'</option>';
    }
} else {
    $attributes[] = null;
}

echo json_encode($attributes);

?>