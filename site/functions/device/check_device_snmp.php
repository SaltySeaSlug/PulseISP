<?php
header('Content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ABSPATH', dirname(dirname(__FILE__)) . '/' );

require ABSPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require ABSPATH . 'includes' . DIRECTORY_SEPARATOR . 'functions.php';
require ABSPATH . 'config.php';


if (isset($_GET['ip']) && !empty($_GET['ip'])) {
    $ip = $_GET['ip'];
    $ttl = 128;
    $timeout = 4;

    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {


        try {
            $snmpHost = new \OSS_SNMP\SNMP($ip, "public");
            $model = $snmpHost->getPlatform()->getModel();
            $os = $snmpHost->getPlatform()->getOs();

            if ($snmpHost->getPlatform()->getVendor() == 'Mikrotik') {
                $identity = $snmpHost->useMikrotik()->identity();
                $uptime = secondsToTime($snmpHost->useMikrotik()->uptime());
            }

            echo "<div class='alert alert-success'><b>SNMP Response:</b> $os $model<br><b>Device Name:</b> $identity<br> <b>Device Uptime:</b> $uptime<br></div>";

        } catch (Exception $e) { echo "<div class='alert alert-danger'><b>No SNMP Response</b> (Is SNMP enabled on the device?)</div>"; }
    } else { echo "<div class='alert alert-danger'><b>No SNMP Response</b> (Is SNMP enabled on the device?)</div>"; }
}


?>