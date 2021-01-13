<?php
header('Content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', '1');

echo json_encode(shell_exec("sudo /etc/init.d/freeradius restart"));

?>
