<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$scriptpath = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . 'radius';

// LOAD FUNCTIONS
require($scriptpath . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'functions.php');

// AUTOLOAD CLASSES
spl_autoload_register('vendorClassAutoload');
spl_autoload_register('appClassAutoload');

# LOAD CONFIGURAGION FILE
require($scriptpath . DIRECTORY_SEPARATOR . 'config.php');

# INITIALIZE MEDOO
$database = new medoo($config);

    $result = $database->select("radacct", ["username", "callingstationid", "acctstarttime", "acctinputoctets", "acctoutputoctets"], ["acctstoptime" => null, "LIMIT" => 10]);

    $data = array();
    foreach ($result as $row) {
        $data[] = array(
            "username" => $row['username'],
            "macaddress" => $row['callingstationid'],
            "sessiononline" => secondsToHumanReadable($row['acctstarttime'], 2),
            "sessionusage" => bytes($row['acctoutputoctets']) . "/" . bytes($row['acctinputoctets'])
        );
    }

$response = array("aaData" => $data);
echo json_encode($response);

?>