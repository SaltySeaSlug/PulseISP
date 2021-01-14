<?php

$scriptpath = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . 'radius';
require($scriptpath . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'functions.php');
spl_autoload_register('vendorClassAutoload');
spl_autoload_register('appClassAutoload');
require($scriptpath . DIRECTORY_SEPARATOR . 'config.php');
$database = new medoo($config);

if(isset($_GET['dataType'])) {
    $dataType = $_GET['dataType'];
}

$data = array();
switch($dataType) {
    case 'summary':
        {
            $result = $database->select("radpostauth", ["username", "reply", "callingstationid", "authdate"], ["ORDER" => "authdate DESC", "LIMIT" => 10]);

            foreach ($result as $row) {
                $status = ($row['reply'] == "Access-Accept") ? '<td><span class="label bg-green">Accepted</span></td>' : '<td><span class="label bg-red">Rejected</span></td>';

                $data[] = array(
                    "username" => '<td>'. $row['username'] . '</td>',
                    "status" => $status,
                    "callingstationid" => '<td>' . $row['callingstationid'] . '</td>',
                    "authdate" => '<td>' . $row['authdate'] . '</td>'
                );
            }
        }
        break;
    default:
        return $data = null;
}

$response = array("aaData" => $data);
echo json_encode($response);

?>