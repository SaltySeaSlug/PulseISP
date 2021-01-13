<?php

header('Content-type: application/text');

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ABSPATH', dirname(dirname(__FILE__)) . '/' );

require ABSPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require ABSPATH . 'config.php';

if (isset($_GET['ip']) && !empty($_GET['ip']) && isset($_GET['port']) && !empty($_GET['port'])) {
    $ip = $_GET['ip'];
    $port = $_GET['port'];
    $ttl = 128;
    $timeout = 1;

    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        try {
            $ping = new JJG\Ping($ip, $ttl, $timeout);
            $ping->setPort($port);
            $latency = $ping->ping('fsockopen');
            $result = $ping->getPort();

            if ($latency !== false) { echo "OK"; } else { echo "ERR"; }
        } catch (Exception $e) { echo "ERR"; }
    } else { echo "ERR"; }
}



?>