<?php

$scriptpath = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . 'radius';


error_reporting(E_ALL);
ini_set('display_errors', '1');


//$scriptpath = dirname(__DIR__);

// LOAD FUNCTIONS
require($scriptpath . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'functions.php');
require $scriptpath . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// AUTOLOAD CLASSES
spl_autoload_register('vendorClassAutoload');
spl_autoload_register('appClassAutoload');

# LOAD CONFIGURAGION FILE
require($scriptpath . DIRECTORY_SEPARATOR . 'config.php');

if(isset($_GET['ip'])) {
    $ipaddress = $_GET['ip'];
}

if(isset($_GET['comm'])) {
    $community = $_GET['comm'];
}

if(isset($_GET['oid'])) {
    $oid = $_GET['oid'];
}

$snmpHost = new \OSS_SNMP\SNMP("100.99.1.255", "public");
//echo $snmpHost->get(".1.3.6.1.2.1.1.3.0");
echo "Vendor: " . $snmpHost->getPlatform()->getVendor() . "</br>"
    . "Model: " . $snmpHost->getPlatform()->getModel() . "</br>"
    . "OS: " . $snmpHost->getPlatform()->getOs() . "</br>"
    . "OS Version: " . $snmpHost->getPlatform()->getOsVersion()  . "</br>"
    . "Serial Number: " . $snmpHost->getPlatform()->getSerialNumber()  . "</br>"
    . "OS Date: " . $snmpHost->getPlatform()->getOsDate()  . "</br>"
    . "Uptime: " . secondsToHumanReadable(($snmpHost->get('.1.3.6.1.2.1.1.3.0') / 100)) . "</br>";

echo "</br>";
//echo "Mikrotik Specific Function: " . $snmpHost->useMikrotik()->getUptime();

echo "</br>";
echo "</br>";

if (isset($oid)) echo "Custom OID: " . $snmpHost->get($oid);


/*snmp_set_quick_print(TRUE);

$a = snmpwalkoid($ipaddress, $community, $oid);
for (reset($a); $i = key($a); next($a)) {
    echo "$i: $a[$i]<br />\n";
}
*/
?>

<!--
PPP ACTIVE CONNECTIONS COUNT    :      .1.3.6.1.4.1.9.9.150.1.1.1.0

SYSTEM RESOURCES USED MEMORY    :      .1.3.6.1.2.1.25.2.3.1.6.65536
SYSTEM RESOURCES UPTIME         :      .1.3.6.1.2.1.1.3.0
SYSTEM RESOURCES BUILD TIME     :      .1.3.6.1.4.1.14988.1.1.7.6.0
SYSTEM RESOURCES TOTAL MEMORY   :      .1.3.6.1.2.1.25.2.3.1.5.65536
SYSTEM RESOURCES CPU FREQUENCY  :      .1.3.6.1.4.1.14988.1.1.3.14.0
SYSTEM RESOURCES CPU LOAD       :      .1.3.6.1.4.1.2021.11.10


-->
