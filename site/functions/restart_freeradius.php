<?php
header('Content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', '1');

define("REQUEST", "external");
define('ABSPATH', dirname(dirname(__FILE__)) . '/' );
ob_start();
require('instance.php');
require ABSPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
ob_end_clean();

echo json_encode(shell_exec("sudo /etc/init.d/freeradius restart"));

?>
