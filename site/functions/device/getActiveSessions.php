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
    case 'summary': {
        $result = $database->select("radacct", ["username", "callingstationid", "acctsessiontime", "acctinputoctets", "acctoutputoctets"], ["acctstoptime" => null, "LIMIT" => 10]);

        foreach ($result as $row) {
            $data[] = array(
                "username" => $row['username'],
                "macaddress" => $row['callingstationid'],
                "sessiononline" => secondsToHumanReadable($row['acctsessiontime'], 2),
                "sessionusage" => bytes($row['acctoutputoctets']) . "/" . bytes($row['acctinputoctets'])
            );
        }
    } break;
    case 'full': {
        $result = $database->select("radacct", ["username", "realm", "nasipaddress", "acctstarttime", "acctstoptime", "acctsessiontime", "acctinputoctets", "acctoutputoctets", "callingstationid", "servicetype", "framedprotocol", "framedipaddress", "acctupdatetime", "acctinterval"], ["acctstoptime" => null]);

        foreach ($result as $row) {
            $realm = $database->get("realms", ["realmname"], ["id" => (int)$row['realm']]);
            $data[] = array(
                "username" => $row['username'],
                "realm" => ($realm == false) ? null : $realm['realmname'],
                "nasipaddress" => getSingleValue1("nas", "shortname", ["nasname" => $row['nasipaddress']]),
                "acctstarttime" => $row['acctstarttime'],
                "acctsessiontime" => secondsToHumanReadable($row['acctsessiontime'], 2),
                "acctinputoctets" => bytes($row['acctinputoctets']),
                "acctoutputoctets" => bytes($row['acctoutputoctets']),
                "callingstationid" => $row['callingstationid'],
                "servicetype" => $row['servicetype'],
                "framedprotocol" => $row['framedprotocol'],
                "framedipaddress" => $row['framedipaddress'],
                "acctupdatetime" => $row['acctupdatetime'],
                "acctinterval" => $row['acctinterval']
            );
        }
    } break;
    default: return $data = null;
}

$response = array("aaData" => $data);
echo json_encode($response);

?>