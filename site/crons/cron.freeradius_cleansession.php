<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$scriptpath = dirname(__DIR__);

// LOAD FUNCTIONS
require($scriptpath . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'functions.php');
require $scriptpath . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// AUTOLOAD CLASSES
spl_autoload_register('vendorClassAutoload');
spl_autoload_register('appClassAutoload');

# LOAD CONFIGURAGION FILE
require($scriptpath . DIRECTORY_SEPARATOR . 'config.php');
$database = new medoo($config);

// CHECK IF SESSION IS STALE, NO RESPONSE OR UPDATES IN THE LAST 2 MINUTES OR MORE
// TODO : CHANGE '120' to (Interval + Grace Period)
$database->query("UPDATE radacct SET acctstoptime=NOW(), acctterminatecause='Stale-Session' WHERE (UNIX_TIMESTAMP(NOW()) - (UNIX_TIMESTAMP(acctstarttime) + IFNULL(acctsessiontime, 0)) > 120) AND (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(acctupdatetime) > 120) AND (acctstoptime = UNIX_TIMESTAMP('0000-00-00 00:00:00') OR acctstoptime IS NULL)")->fetchAll();
// CHECK IF SESSION WAS MARKED STALE, BUT RADIUS IS STILL USING THE CURRENT SESSION ID, UPDATE STOPTIME TO NULL - MARK AS ACTIVE ONCE AGAIN
$database->query("UPDATE radacct SET acctstoptime=NULL, acctterminatecause=NULL WHERE UNIX_TIMESTAMP(acctupdatetime) > UNIX_TIMESTAMP(acctstoptime) AND (acctstoptime = UNIX_TIMESTAMP('0000-00-00 00:00:00') OR acctstoptime IS NOT NULL)")->fetchAll();




// CHECK IF CUSTOMER HAS EXCEEDED RECOMMENDED - SOFT OR HARD CAPS
//hint: 1 gigabyte = 1073741824 byte

// Over usage calculation for the month:
// Usage to date – Usage limit + Topups = Over usage
$softlimit = 524288000; // LIMIT YOU PURCHASED OR WERE ASSIGNED (500MB CAPPED ACCOUNT) - EXCEED THIS AND SPEEDS ARE DROPPED
$hardlimit = 1073741824; // LIMIT AT WHICH ACCOUNT (INTERNET ACCESS) IS CUT OFF
$query = $database->query("SELECT radacctid, acctsessionid, username, nasipaddress, nasportid, acctsessiontime, acctinputoctets, acctoutputoctets, calledstationid, callingstationid, framedipaddress FROM radacct WHERE (acctstoptime = '0000-00-00 00:00:00' OR acctstoptime IS NULL)")->fetchAll();
foreach ($query as $row) {
    $download = (float)$row['acctoutputoctets'];
    $upload = (float)$row['acctinputoctets'];
    $traffic = (float)$download + $upload;

    if ($traffic >= $softlimit) {
        // TRAFFIC NOTIFICATION : SOFT LIMIT
        }
    else if ($traffic >= $hardlimit) {
        // TRAFFIC NOTIFICATION : HARD LIMIT
    }
    else continue;
}

echo json_encode($database->error());
var_dump($database->log());
print_r($database->info());



?>