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
    case 'ipaddresses': {
        $total = $database->count("radippool");
        $free = $database->count("radippool", ["username" => null]);

            $data[] = array(
                "free" => $free,
                "used" => ($total - $free),
                "total" => $total
            );
    } break;
    case 'sessions': {
        $count = $database->count("radacct", ["acctstoptime" => null]);

            $data[] = array(
                "count" => $count
            );
    } break;
    case 'clients': {
        $count = $database->count("clients");

            $data[] = array(
                "count" => $count
            );
    } break;
    case 'alerts': {
        $result = $database->select("radacct", ["username", "realm", "nasipaddress", "acctstarttime", "acctstoptime", "acctsessiontime", "acctinputoctets", "acctoutputoctets", "callingstationid", "servicetype", "framedprotocol", "framedipaddress", "acctupdatetime", "acctinterval"], ["acctstoptime" => null]);

        foreach ($result as $row) {
            $data[] = array(
                "username" => $row['username'],
                "realm" => getSingleValue("realms", "realmname", (int)$row['realm']),
                "nasipaddress" => getSingleValue1("nas", "nasidentifier", ["nasname" => $row['nasipaddress']]),
                "acctstarttime" => $row['acctstarttime'],
                "acctstoptime" => $row['acctstoptime'],
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
    case 'authrequests': {

	   	$authRequests = $database->query("SELECT DISTINCT(reply) as status, count(reply) AS count FROM radpostauth GROUP BY reply")->fetchAll();
        $statAuthRequests = new SplFixedArray(2);
        foreach($authRequests as $row) {
            if ($row['status'] == 'Access-Accept') $statAuthRequests[0] = array("Status" => $row['status'], "Count" => $row['count']);
            else if ($row['status'] == 'Access-Reject') $statAuthRequests[1] = array("Status" => $row['status'], "Count" => $row['count']);
            else {}
        }

        $result = '<span class="label bg-green">Accepted [ '. (!is_null($statAuthRequests->toArray()[0]) ? $statAuthRequests[0]['Count'] : 0) .' ]</span> <span class="label bg-red">Rejected [ '. (!is_null($statAuthRequests->toArray()[1]) ? $statAuthRequests[1]['Count'] : 0) .' ]</span>';

         $data[] = array(
                "result" => $result
            );

    } break;
    default: return $data = null;
}


/*
$activeSessions = array();
$authRequests = array();

$result = $database->select("radacct", ["username", "callingstationid", "acctsessiontime", "acctinputoctets", "acctoutputoctets"], ["acctstoptime" => null, "LIMIT" => 10]);

foreach ($result as $row) {
    $activeSessions[] = array(
        "username" => $row['username'],
        "macaddress" => $row['callingstationid'],
        "sessiononline" => secondsToHumanReadable($row['acctsessiontime'], 2),
        "sessionusage" => bytes($row['acctoutputoctets']) . "/" . bytes($row['acctinputoctets'])
    );
}

$result = $database->select("radpostauth", ["username", "reply", "callingstationid", "authdate"], ["ORDER" => "authdate DESC", "LIMIT" => 10]);

foreach ($result as $row) {
    $status = ($row['reply'] == "Access-Accept") ? '<td><span class="label bg-green">Accepted</span></td>' : '<td><span class="label bg-red">Rejected</span></td>';

    $authRequests[] = array(
        "username" => '<td>'. $row['username'] . '</td>',
        "status" => $status,
        "callingstationid" => '<td>' . $row['callingstationid'] . '</td>',
        "authdate" => '<td>' . $row['authdate'] . '</td>'
    );
}
*/
$response = $data;
echo json_encode($response);

?>