<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/14, 13:50
 */

header('Content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ABSPATH', dirname(dirname(__FILE__)) . '/' );

require ABSPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require(ABSPATH . 'includes' . DIRECTORY_SEPARATOR . 'functions.php');
require ABSPATH . 'config.php';

if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'getIPCount' :
            getIPCount($config);
            break;
        case 'getSessionCount' :
            getSessionCount($config);
            break;
        case 'getCustomerCount' :
            getCustomerCount($config);
            break;
        case 'getAlertCount' :
            getAlertCount($config);
            break;
        case 'getUsageCount' :
            getUsageCount($config);
            break;
        case 'getChartUsageData' :
            if (isset($_GET['period']) && !empty($_GET['period'])) {
                getChartUsageData($config, $_GET['period']);
            }
            break;
        case 'getChartAuthData' :
            if (isset($_GET['period']) && !empty($_GET['period'])) {
                getChartAuthData($config, $_GET['period']);
            }
            break;
        case 'getChartSessionData' :
                getChartSessionData($config);
            break;
        case 'getNasDevices':
            if (isset($_GET['perms']) && !empty($_GET['perms'])) {
                getNasDevices($config, $_GET['perms']);
            }
            break;
        case 'getActiveSessions':
            if (isset($_GET['perms']) && !empty($_GET['perms'])) {
                getActiveSessions($config, $_GET['perms']);
            }
            break;
        case 'getAuthRequests':
            if (isset($_GET['perms']) && !empty($_GET['perms'])) {
                getAuthRequests($config, $_GET['perms']);
            }
            break;
    }
}

function bytes1($bytes, $force_unit = NULL, $format = NULL, $si = FALSE)
{
    // Format string
    $format = ($format === NULL) ? '%01.2f %s' : (string) $format;

    // IEC prefixes (binary)
    if ($si == FALSE OR strpos($force_unit, 'i') !== FALSE)
    {
        $units = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
        $mod   = 1024;
    }
    // SI prefixes (decimal)
    else
    {
        $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB');
        $mod   = 1000;
    }

    // Determine unit to use
    if (($power = array_search((string) $force_unit, $units)) === FALSE)
    {
        $power = ($bytes > 0) ? floor(log($bytes, $mod)) : 0;
    }

    return ($bytes / pow($mod, $power));
}
function getWeekday($date) {
    return date('w', strtotime($date));
}
function getDay($dow_numeric){
    $dowMap = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    return $dowMap[$dow_numeric];
}
function daysBetween($dt1, $dt2) {
    return date_diff(
        date_create($dt2),  
        date_create($dt1)
    )->format('%a');
}

function getIPCount($dbConfig)
{
    $requestData = $_REQUEST;
    $database = new medoo($dbConfig);

    $total = $database->count("radippool");
    $free = $database->count("radippool", ["username" => null]);
    $used = ($total - $free);

    $json_data = array(
        "used" => $used,
        "free" => $free,
        "total" => $total
    );

    echo json_encode($json_data);
}
function getSessionCount($dbConfig)
{
    $database = new medoo($dbConfig);

    $active = $database->count("radacct", ["acctstoptime" => null]);
    $total = $database->count("ppp_accounts", ["AND" => ["startdate[!]" => null, "enddate" => null, "isdisabled" => false]]);

    $json_data = array(
        "active" => $active,
        "total" => $total
    );

    echo json_encode($json_data);
}
function getCustomerCount($dbConfig)
{
    $requestData = $_REQUEST;
    $database = new medoo($dbConfig);

    $active = $database->count("clients", ["startdate[!]" => null]);
    $total = $database->count("clients", ["enddate" => null]);

    $json_data = array(
        "active" => $active,
        "total" => $total
    );
    echo json_encode($json_data);
}
function getAlertCount($dbConfig)
{
    $requestData = $_REQUEST;
    $database = new medoo($dbConfig);

    $json_data = array(
        "info" => "0",
        "urgent" => "0",
        "total" => "0"
    );
    echo json_encode($json_data);
}
function getUsageCount($dbConfig)
{
    $requestData = $_REQUEST;
    $database = new medoo($dbConfig);
    $today = $database->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download FROM ppp_accounts_stats WHERE DATE(timestamp) = CURDATE()")->fetch();
    $thisweek = $database->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download FROM ppp_accounts_stats WHERE YEARWEEK(timestamp, 0) = YEARWEEK(CURDATE(), 0)")->fetch();
    $thismonth = $database->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download FROM ppp_accounts_stats WHERE YEAR(`timestamp`) = YEAR(CURRENT_DATE()) AND MONTH(`timestamp`) = MONTH(CURRENT_DATE())")->fetch();

    $json_data = array(
        "today" => array("download" => $today['download'], "upload" => $today['upload']),
        "thisweek" => array("download" => $thisweek['download'], "upload" => $thisweek['upload']),
        "thismonth" => array("download" => $thismonth['download'], "upload" => $thismonth['upload'])
    );
    echo json_encode($json_data);
}
function getChartUsageData($dbConfig, $period = null, $start = null, $end = null)
{
    $requestData = $_REQUEST;
    $database = new medoo($dbConfig);
    $json_data = null;

    switch ($period)
    {
        case 'T': {
            $today = $database->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download, HOUR(`timestamp`) as hour FROM ppp_accounts_stats WHERE DATE(`timestamp`) = CURDATE() GROUP BY HOUR(`timestamp`) ASC")->fetchAll();
            $todayCount = $database->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download FROM ppp_accounts_stats WHERE DATE(timestamp) = CURDATE()")->fetch();

            $data = range(0, 23);

            foreach ($today as $row) {
                $data[$row['hour']] = array("downloaded" => bytes1($row['download'], 'B'), "uploaded" => bytes1($row['upload'], 'B'), "period" => $row['hour']);
            }
            $count = 0;
            foreach (array_keys($data) as $index => $key) {
                if ($index == $count && is_numeric($data[$key])) {
                    $data[$key] = array("period" => $key);
                }
                $count++;
            }

            $json_data = array("count" => array("downloaded" => $todayCount['download'] ?? 0, "uploaded" => $todayCount['upload'] ?? 0), "chartdata" => $data);
        } break;
        case 'W': {
            $thisweek = $database->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download, DAYNAME(`timestamp`) as day FROM ppp_accounts_stats WHERE WEEK(timestamp, 0) = WEEK(CURDATE(), 0) GROUP BY DAYNAME(`timestamp`) ORDER BY DAYOFWEEK(day)")->fetchAll();
            $thisweekCount = $database->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download FROM ppp_accounts_stats WHERE WEEK(timestamp, 0) = WEEK(CURDATE(), 0)")->fetch();

            $data = range(0, 6);
            foreach ($thisweek as $row) {
                $data[getWeekday($row['day'])] = array("downloaded" => bytes1($row['download'], 'B'), "uploaded" => bytes1($row['upload'], 'B'), "period" => $row['day']);
            }
            $count = 0;
            foreach (array_keys($data) as $index => $key) {
                if ($index == $count && is_numeric($data[$key])) {
                    $data[$key] = array("period" => getDay($key));
                }
                $count++;
            }

            $json_data = array("count" => array("downloaded" => $thisweekCount['download'] ?? 0, "uploaded" => $thisweekCount['upload'] ?? 0), "chartdata" => $data);
        } break;
        case 'M': {
            $thismonth = $database->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download, DAY(`timestamp`) as day FROM ppp_accounts_stats WHERE YEAR(`timestamp`) = YEAR(CURRENT_DATE()) AND MONTH(`timestamp`) = MONTH(CURRENT_DATE()) GROUP BY DAY(`timestamp`) ASC")->fetchAll();
            $thismonthCount = $database->query("SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download FROM ppp_accounts_stats WHERE YEAR(`timestamp`) = YEAR(CURRENT_DATE()) AND MONTH(`timestamp`) = MONTH(CURRENT_DATE())")->fetch();

            $data = range(1, date('t') + 1);
            foreach ($thismonth as $row) {
                $data[$row['day']] = array("downloaded" => bytes1($row['download'], 'B'), "uploaded" => bytes1($row['upload'], 'B'), "period" => $row['day']);
            }
            $count = 0;
            foreach (array_keys($data) as $index => $key) {
                if ($count != 0 && $index == $count && is_numeric($data[$key])) {
                    $data[$key] = array("period" => $key);
                }
                if ($count == 0) unset($data[$key]);
                $count++;
            }
            $json_data = array("count" => array("downloaded" => $thismonthCount['download'] ?? 0, "uploaded" => $thismonthCount['upload'] ?? 0), "chartdata" => $data);
        } break;
        default: break;
    }

    echo json_encode($json_data);
}
function getChartAuthData($dbConfig, $period = null, $start = null, $end = null)
{
    $requestData = $_REQUEST;
    $database = new medoo($dbConfig);
    $json_data = null;

    switch ($period)
    {
        case 'T': {
            $today = $database->query("SELECT HOUR(`authdate`) as hour, COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject FROM radpostauth WHERE DATE(`authdate`) = CURDATE() GROUP BY HOUR(`authdate`)")->fetchAll();
            $todayCount = $database->query("SELECT COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject FROM radpostauth WHERE DATE(`authdate`) = CURDATE()")->fetch();

            $data = range(0, 23);

            foreach ($today as $row) {
                $data[$row['hour']] = array("accept" => $row['accept'], "reject" => $row['reject'], "period" => $row['hour']);
            }
            $count = 0;
            foreach (array_keys($data) as $index => $key) {
                if ($index == $count && is_numeric($data[$key])) {
                    $data[$key] = array("period" => $key);
                }
                $count++;
            }

            $json_data = array("count" => array("accepted" => $todayCount['accept'], "rejected" => $todayCount['reject']), "chartdata" => $data);
        } break;
        case 'W': {
            $thisweek = $database->query("SELECT COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject, DAYNAME(`authdate`) as day FROM radpostauth WHERE YEARWEEK(`authdate`, 0) = YEARWEEK(CURDATE(), 0) GROUP BY DAYNAME(`authdate`) ORDER BY DAYOFWEEK(day)")->fetchAll();
            $thisweekCount = $database->query("SELECT COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject, DAYNAME(`authdate`) as day FROM radpostauth WHERE YEARWEEK(`authdate`, 0) = YEARWEEK(CURDATE(), 0)")->fetch();

            $data = range(0, 6);
            foreach ($thisweek as $row) {
                $data[getWeekday($row['day'])] = array("accept" => $row['accept'], "reject" => $row['reject'], "period" => $row['day']);
            }
            $count = 0;
            foreach (array_keys($data) as $index => $key) {
                if ($index == $count && is_numeric($data[$key])) {
                    $data[$key] = array("period" => getDay($key));
                }
                $count++;
            }

            $json_data = array("count" => array("accepted" => $thisweekCount['accept'], "rejected" => $thisweekCount['reject']), "chartdata" => $data);
        } break;
        case 'M': {
            $thismonth = $database->query("SELECT DAY(`authdate`) as day, COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject FROM radpostauth WHERE YEAR(`authdate`) = YEAR(CURRENT_DATE()) AND MONTH(`authdate`) = MONTH(CURRENT_DATE()) GROUP BY DAY(`authdate`) ASC")->fetchAll();
            $thismonthCount = $database->query("SELECT DAY(`authdate`) as day, COUNT(CASE WHEN `reply` = 'Access-Accept' THEN ( SELECT `id` ) END) as accept, COUNT(CASE WHEN `reply` = 'Access-Reject' THEN ( SELECT `id` ) END) as reject FROM radpostauth WHERE YEAR(`authdate`) = YEAR(CURRENT_DATE()) AND MONTH(`authdate`) = MONTH(CURRENT_DATE())")->fetch();

            $data = range(1, date('t') + 1);
            foreach ($thismonth as $row) {
                $data[$row['day']] = array("accept" => $row['accept'], "reject" => $row['reject'], "period" => $row['day']);
            }
            $count = 0;
            foreach (array_keys($data) as $index => $key) {
                if ($count != 0 && $index == $count && is_numeric($data[$key])) {
                    $data[$key] = array("period" => $key);
                }
                if ($count == 0) unset($data[$key]);
                $count++;
            }
            $json_data = array("count" => array("accepted" => $thismonthCount['accept'], "rejected" => $thismonthCount['reject']), "chartdata" => $data);
        } break;
        default: break;
    }

    echo json_encode($json_data);
}
function getChartSessionData($dbConfig)
{
    $requestData = $_REQUEST;
    $database = new medoo($dbConfig);
    $json_data = null;

    $today = $database->query("SELECT COUNT(IFNULL(`username`,0)) as active, FROM_UNIXTIME(FLOOR((UNIX_TIMESTAMP(`acctupdatetime`))/300)*300) AS period FROM radacct WHERE `acctstoptime` IS NULL AND DATE(`acctupdatetime`) = CURDATE() GROUP BY period ORDER BY period")->fetchAll();
    $todayCount = $database->count("radacct", ["acctstoptime" => null]);

    $data = array();

    foreach ($today as $row) {
        $data[] = array("active" => $row['active'], "period" => (int)strtotime($row['period']));
    }
    $count = 0;

    /*foreach (array_keys($data) as $index => $key) {
        if ($index == $count && is_numeric($data[$key])) {
            $data[$key] = array("period" => $key);
        }
        $count++;
    }*/

    $json_data = array("count" => array("accepted" => $todayCount['accept'], "rejected" => $todayCount['reject']), "chartdata" => $data);

    echo json_encode($json_data);
}

function getNasDevices($dbConfig, $roleId)
{
    $database = new medoo($dbConfig);

    $perms = unserialize($database->get("roles", "perms", ["id" => $roleId]));

    $result = $database->select("nas", ["id", "shortname", "nasname", "nasidentifier", "last_contact", "community", "type"]);
    $json_data = array();

    foreach ($result as $row) {

        $snmpHost = new \OSS_SNMP\SNMP($row['nasname'], $row['community']);
        $snmpHost->setTimeout(40000);

        $manage = in_array("manageNAS", $perms) ? '<a title="Manage" href="?route=nas/manage&id=' . $row['id'] . '" class="btn-right text-primary"><i class="far fa-eye"></i></a>&nbsp;' : "";
        $edit = in_array("editNAS", $perms) ? '<a title="Edit" href="#" onClick=showM("index.php?modal=nas/edit&reroute=radius/nas&id=' . $row['id'] . '"); return false" class="btn-right text-warning"><i class="far fa-edit"></i></a>&nbsp;' : "";
        $delete = in_array("deleteNAS", $perms) ? '<a title="Delete" href="#" onClick=showM("index.php?modal=nas/delete&reroute=radius/nas&id=' . $row['id'] . '"); return false" class="btn-right text-danger"><i class="far fa-trash-alt"></i></a>' : "";
        $pingable = ($ping = doPing($row['nasname']) > 0) ? '<td><span class="badge bg-green">' . $ping . ' ms</span></td>' : '<td><span class="badge bg-red">Unavailable</span></td>';
        $status = (date("Y-m-d H:i:s", strtotime("-2 minutes")) < $row['last_contact']) ? '<td><span class="badge bg-green">Online</span></td>' : '<td><span class="badge bg-red">Offline</span></td>';

        if (strpos($row['type'], 'Mikrotik') !== false) {
            $pppcount = $snmpHost->useMikrotik()->activePPPCount();
            $fcpu = $snmpHost->useMikrotik()->getCPUUsage();
            $cpu = ($fcpu >= 0 && $fcpu <= 40) ? '<td><span class="badge bg-green">CPU: ' . $fcpu . ' %</span></td>' : (($fcpu >= 41 && $fcpu <= 60) ? '<td><span class="badge bg-yellow">CPU: ' . $fcpu . ' %</span></td>' : ($fcpu == -1) ? '<td><span class="badge bg-red">Unavailable</span></td>' : '<td><span class="badge bg-red">CPU: ' . $fcpu . ' %</span></td>');
        } else {
            $pppcount = '<td></td>';
            $cpu = '<td></td>';
        }

        if ($ping > 0 || $fcpu != -1 && !(date("Y-m-d H:i:s", strtotime("-2 minutes")) < $row['last_contact'])) {
            $status = '<td><span class="badge bg-green">Online</span></td>';
        }

        $json_data[] = array(
            "shortname" => '<td><a href="?route=nas/manage&id=' . $row['id'] . '">' . $row['shortname'] . '</a></td>',
            "ipaddress" => '<td><span class="badge bg-blue">' . $row['nasname'] . '</span></td>',
            "nasidentifier" => $row['nasidentifier'],
            "activeppp" => $pppcount,
            "status" => $status,
            "ping" => $pingable,
            "stats" => $cpu,
            "functions" => '<td><div class="pull-right ml-auto">' . $manage . $edit . $delete . '</div></td>'
        );
    }

    echo json_encode(array("aaData" => $json_data));
}
function getActiveSessions($dbConfig, $roleId) {
    $database = new medoo($dbConfig);

    $perms = unserialize($database->get("roles", "perms", ["id" => $roleId]));

    $result = $database->select("radacct", ["username", "realm", "nasipaddress", "acctstarttime", "acctstoptime", "acctsessiontime", "acctinputoctets", "acctoutputoctets", "callingstationid", "servicetype", "framedprotocol", "framedipaddress", "acctupdatetime", "acctinterval"], ["acctstoptime" => null]);

    $json_data = array();

    foreach ($result as $row) {
        $nas = $database->get("nas", "*" , ["nasname" => $row['nasipaddress']]);
        $kick = in_array("allowKickSession", $perms) ? '<a href="#" title="End Session" onClick=showM("index.php?modal=sessions/kick&reroute=radius/sessions&id='. $row['username'] .'"); return false" class="btn-right text-red"><i class="fa fa-times"></i></a>' : "";

        $json_data[] = array(
            "username" => $row['username'],
            "nasipaddress" => $nas['shortname'],
            "acctstarttime" => $row['acctstarttime'],
            "acctsessiontime" => secondsToHumanReadable($row['acctsessiontime'], 2),
            "acctinputoctets" => bytes($row['acctinputoctets']),
            "acctoutputoctets" => bytes($row['acctoutputoctets']),
            "callingstationid" => $row['callingstationid'],
            "servicetype" => $row['servicetype'],
            "framedprotocol" => $row['framedprotocol'],
            "framedipaddress" => $row['framedipaddress'],
            "acctupdatetime" => $row['acctupdatetime'],
            "acctinterval" => $row['acctinterval'],
            "functions" => '<td><div class="pull-right">'. $kick .'</div></td>'
        );
    }
    echo json_encode(array("aaData" => $json_data));
}
function getAuthRequests($dbConfig, $roleId) {
    $database = new medoo($dbConfig);

    $perms = unserialize($database->get("roles", "perms", ["id" => $roleId]));

    $result = $database->select("radpostauth", ["username", "pass", "reply", "callingstationid", "authdate"], ["ORDER" => "authdate DESC"]);

    $json_data = array();
    if ($result != null) {
        foreach ($result as $row) {
            //$kick = in_array("deleteClient", $perms) ? '<a href="#" title="End Session" onClick=showM("index.php?modal=sessions/kick&reroute=radius/sessions&id='. $row['username'] .'"); return false" class="btn-right text-red"><i class="fa fa-times"></i></a>' : "";

            $json_data[] = array(
                "username" => $row['username'],
                "pass" => $row['pass'],
                "reply" => $row['reply'],
                "callingstationid" => $row['callingstationid'],
                "authdate" => $row['authdate'],
                //"functions" => '<td><div class="pull-right">'. $kick .'</div></td>'
            );
        }
    }
    echo json_encode(array("aaData" => $json_data));
}

?>
