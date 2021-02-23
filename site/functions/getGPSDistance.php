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
require(ABSPATH . 'includes' . DIRECTORY_SEPARATOR . 'functions.php');



if (isset($_GET['point1']) && !empty($_GET['point1']) && isset($_GET['point2']) && !empty($_GET['point2'])) {
    $lat1 = preg_split ('/\,/', $_GET['point1'])[0];
    $lng1 = preg_split ('/\,/', $_GET['point1'])[1];

    $lat2 = preg_split ('/\,/', $_GET['point2'])[0];
    $lng2 = preg_split ('/\,/', $_GET['point2'])[1];
}

if (isset($_GET['lat1']) && !empty($_GET['lat1']) && isset($_GET['lng1']) && !empty($_GET['lng1']) && isset($_GET['lat2']) && !empty($_GET['lat2']) && isset($_GET['lng2']) && !empty($_GET['lng2'])) {
    $lat1 = $_GET['lat1'];
    $lng1 = $_GET['lng1'];

    $lat2 = $_GET['lat2'];
    $lng2 = $_GET['lng2'];
}

if (isset($_GET['unit']) && !empty($_GET['unit'])) {
    $unit = ($_GET['unit'] == 'm') ? false : true;
}

if (isset($_GET['accu']) && !empty($_GET['accu'])) {
    $result = distVincenty( $lat1, $lng1, $lat2, $lng2, $unit);
}
else {
    $result = distFrom( $lat1, $lng1, $lat2, $lng2, $unit);
}


echo json_encode($result);

?>
