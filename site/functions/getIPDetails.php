<?php

header('Content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ABSPATH', dirname(dirname(__FILE__)) . '/' );
require ABSPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

if(isset($_GET['iprange'])) {
    $ipAddress = $_GET['iprange'];
}

function ip_range($start, $end)
{
	$start = ip2long($start);
	$end = ip2long($end);
	return array_map('long2ip', range($start, $end));
}
function checkIfIPRange($ipAddress)
{
	return preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}-(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}?$/', $ipAddress);
}
function checkIfCIDR($ipAddress)
{
	return preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}(\/([0-9]|[1-2][0-9]|3[0-2]))?$/', $ipAddress);
}
function iMask($s){
	return base_convert((pow(2, 32) - pow(2, (32-$s))), 10, 16);
}
function iprange2cidr($ipStart, $ipEnd){
	if (is_string($ipStart) || is_string($ipEnd)){
		$start = ip2long($ipStart);
		$end = ip2long($ipEnd);
	}
	else{
		$start = $ipStart;
		$end = $ipEnd;
	}

	$result = array();

	while($end >= $start){
		$maxSize = 32;
		while ($maxSize > 0){
			$mask = hexdec(iMask($maxSize - 1));
			$maskBase = $start & $mask;
			if($maskBase != $start) break;
			$maxSize--;
		}
		$x = log($end - $start + 1)/log(2);
		$maxDiff = floor(32 - floor($x));

		if($maxSize < $maxDiff){
			$maxSize = $maxDiff;
		}

		$ip = long2ip($start);
		array_push($result, "$ip/$maxSize");
		$start += pow(2, (32-$maxSize));
	}
	return $result;
}


if (checkIfIPRange($ipAddress)) {
    $ip = preg_split ('#-#', $ipAddress);

    $ranges = iprange2cidr($ip[0], $ip[1]);
    $tableArray = array();

    foreach ($ranges as $range) {

        $ipR = preg_split ('#/#', $range);
		$sub = new IPv4\SubnetCalculator($ipR[0], $ipR[1]);

        $number_ip_addresses    = $sub->getNumberIPAddresses();      // 512
        $number_hosts           = $sub->getNumberAddressableHosts(); // 510
        $address_rage           = $sub->getIPAddressRange();         // [192.168.112.0, 192.168.113.255]
        $addressable_host_range = $sub->getAddressableHostRange();   // [192.168.112.1, 192.168.113.254]
        $network_size           = $sub->getNetworkSize();            // 23
        $broadcast_address      = $sub->getBroadcastAddress();       // 192.168.113.255
        $subnet_mask            = $sub->getSubnetMask();
        $min_host               = $sub->getMinHost();
        $max_host               = $sub->getMaxHost();
        $ip_address             = $sub->getIPAddress();

		$tableArray[] = "<td>CIDR Range</td><td>$ip_address/$network_size</td>";
		$tableArray[] = "<td>Netmask</td><td>$subnet_mask</td>";
		$tableArray[] = "<td>Broadcast Address</td><td>$broadcast_address</td>";
		$tableArray[] = "<td>Addressable Range</td><td>$addressable_host_range[0] - $addressable_host_range[1]</td>";
		$tableArray[] = "<td>IP Range</td><td>$address_rage[0] - $address_rage[1]</td>";
		$tableArray[] = "<td>Host IP</td><td>$ip_address</td>";
		$tableArray[] = "<td>First IP</td><td>$min_host</td>";
		$tableArray[] = "<td>Last IP</td><td>$max_host</td>";
		$tableArray[] = "<td>Addressable Hosts</td><td>$number_hosts</td>";
		$tableArray[] = "<td>Total Hosts</td><td>$number_ip_addresses</td>";
    }
}
else if (checkIfCIDR($ipAddress)) {

    $ip = preg_split("#/#", $ipAddress);
	$sub = new IPv4\SubnetCalculator($ip[0], $ip[1]);

    $number_ip_addresses    = $sub->getNumberIPAddresses();      // 512
    $number_hosts           = $sub->getNumberAddressableHosts(); // 510
    $address_rage           = $sub->getIPAddressRange();         // [192.168.112.0, 192.168.113.255]
    $addressable_host_range = $sub->getAddressableHostRange();   // [192.168.112.1, 192.168.113.254]
    $network_size           = $sub->getNetworkSize();            // 23
    $broadcast_address      = $sub->getBroadcastAddress();       // 192.168.113.255
    $subnet_mask            = $sub->getSubnetMask();
    $min_host               = $sub->getMinHost();
    $max_host               = $sub->getMaxHost();
    $ip_address             = $sub->getIPAddress();

    $tableArray = array();

    $tableArray[] = "<td>CIDR Range</td><td>$ip_address/$network_size</td>";
    $tableArray[] = "<td>Netmask</td><td>$subnet_mask</td>";
    $tableArray[] = "<td>Broadcast Address</td><td>$broadcast_address</td>";
    $tableArray[] = "<td>Addressable Range</td><td>$addressable_host_range[0] - $addressable_host_range[1]</td>";
    $tableArray[] = "<td>IP Range</td><td>$address_rage[0] - $address_rage[1]</td>";
    $tableArray[] = "<td>Host IP</td><td>$ip_address</td>";
    $tableArray[] = "<td>First IP</td><td>$min_host</td>";
    $tableArray[] = "<td>Last IP</td><td>$max_host</td>";
    $tableArray[] = "<td>Addressable Hosts</td><td>$number_hosts</td>";
    $tableArray[] = "<td>Total Hosts</td><td>$number_ip_addresses</td>";
}
else {}
echo json_encode($tableArray);
?>
