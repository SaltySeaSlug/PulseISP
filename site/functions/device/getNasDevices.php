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

if(isset($_GET['perms'])) {
    $roleId = $_GET['perms'];
}

$perms = unserialize(getSingleValue('roles', 'perms', $roleId));

$data = array();
switch($dataType) {
    case 'full':
        {
            $result = $database->select("nas", ["id", "shortname", "nasname", "nasidentifier", "last_contact"]);

            foreach ($result as $row) {
                $manage = in_array("manageClient", $perms) ? '<a href="?route=nas/manage&id=' . $row['id'] . '" class="btn-right text-dark"><i class="fa fa-eye"></i></a>&nbsp;' : "";
                $edit = in_array("editClient", $perms) ? '<a href="#" onClick=showM("index.php?modal=nas/edit&reroute=nas&id=' . $row['id'] . '"); return false" class="btn-right text-dark"><i class="fa fa-edit"></i></a>&nbsp;' : "";
                $delete = in_array("deleteClient", $perms) ? '<a href="#" onClick=showM("index.php?modal=nas/delete&reroute=nas&id=' . $row['id'] . '"); return false" class="btn-right text-red"><i class="fa fa-trash-o"></i></a>' : "";
                $status = (date("Y-m-d H:i:s", strtotime("-2 minutes")) < $row['last_contact']) ? '<td><span class="label bg-green">Online</span></td>' : '<td><span class="label bg-red">Offline</span></td>';

                $data[] = array(
                    "id" => '<td><a href="?route=nas/manage&id=' . $row['id'] . '">' . $row['id'] . '</a></td>',
                    "shortname" => '<td><a href="?route=nas/manage&id=' . $row['id'] . '">' . $row['shortname'] . '</a></td>',
                    "ipaddress" => '<td><span class="label bg-blue">' . $row['nasname'] . '</span></td>',
                    "nasidentifier" => $row['nasidentifier'],
                    "status" => $status,
                    "functions" => '<td><div class="pull-right">'. $manage . $edit . $delete .'</div></td>'
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