<?php
header('Content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ABSPATH', dirname(dirname(__FILE__)) . '/' );
require ABSPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';



if (isset($_GET['ip']) && !empty($_GET['ip'])) {
    $ip = $_GET['ip'];
    $ttl = 128;
    $timeout = 1;

    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        try {
            $ping = new JJG\Ping($ip, $ttl, $timeout);
            $latency = $ping->ping('exec');

            if ($latency !== false) { echo $latency;  } else { echo "ERR"; }
        } catch (Exception $e) { echo "ERR"; }
    } else { echo "ERR"; }
}



?>
