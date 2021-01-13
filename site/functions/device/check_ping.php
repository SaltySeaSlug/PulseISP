<?php
header('Content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ABSPATH', dirname(dirname(__FILE__)) . '/' );

require ABSPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require ABSPATH . 'config.php';

if (isset($_GET['ip']) && !empty($_GET['ip'])) {
    $ip = $_GET['ip'];
    $ttl = 128;
    $timeout = 1;

    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        try {
            $ping = new JJG\Ping($ip, $ttl, $timeout);
            $latency = $ping->ping('exec');

            if ($latency !== false) { echo "<div class='alert alert-success'>Ping Successful, $latency ms</div>"; } else { echo "<div class='alert alert-danger'>Unable to ping $ip</div>"; }
        } catch (Exception $e) { echo "<div class='alert alert-danger'>Unable to ping $ip</div>"; }
    } else { echo "<div class='alert alert-danger'>Unable to ping $ip</div>"; }
}



?>