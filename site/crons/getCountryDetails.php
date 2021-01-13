<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

global $scriptpath;

// LOAD FUNCTIONS
require($scriptpath . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'functions.php');
require $scriptpath . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// AUTOLOAD CLASSES
spl_autoload_register('vendorClassAutoload');
spl_autoload_register('appClassAutoload');

# LOAD CONFIGURAGION FILE
require($scriptpath . DIRECTORY_SEPARATOR . 'config.php');
$database = new medoo($config);

$response = file_get_contents('https://restcountries.eu/rest/v2/all');
$content = json_decode($response, true);

$servername = "127.0.0.1";
$database = "radius";
$username = "system";
$password = "system";

// Create connection

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


foreach($content as $item) {
    //$columns = implode(", ",array_keys($item));
    //$escaped_values = array_map('real_escape_string', array_values($item));
    //$values  = "'".implode("', '", $escaped_values)."'";
    $values = "'".$item['name']."'" . "," . "'".$item['alpha2Code']."'" . "," . "'".$item['flag']."'";
    $sql = "INSERT INTO `country`(`name`, `alpha2Code`, `flag`) VALUES ($values)";
    echo $sql . "</br>";
    mysqli_query($conn, $sql);
}

?>
