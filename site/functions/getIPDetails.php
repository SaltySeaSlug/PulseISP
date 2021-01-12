<?php

use IPTools\IP;
use IPTools\Range;

include(".." . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'functions.php');
include(".." . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'class.iptools.php');

//vendorClassAutoload("iptools");

if(isset($_GET['iprange'])) {
    $ipAddress = $_GET['iprange'];
}


if (checkIfIPRange($ipAddress)) {
    $ip = preg_split ('#-#', $ipAddress);

    $ranges = iprange2cidr($ip[0], $ip[1]);
    $tableArray = array();
    $count = 0;
    $hostcount = 0;
    $test = new Range(new IP($ip[0]), new IP($ip[1]));
    echo json_encode($test->getSpanNetwork());

    foreach ($ranges as $range) {

        $ipR = preg_split ('#/#', $range);
        $sub = new Net\Subnet($ipR[0], $ipR[1]);

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
        $tableArray[] = "<td>Wildcard Bits</td><td></td>";
        $tableArray[] = "<td>First IP</td><td>$min_host</td>";
        $tableArray[] = "<td>Last IP</td><td>$max_host</td>";
        $tableArray[] = "<td>Total Hosts</td><td>$number_ip_addresses</td>";

        $count += $number_ip_addresses;
        $hostcount += $number_hosts;

    }

    $tableArray[] = "<td>Total IP ADDRESSES</td><td>$count</td>";
    $tableArray[] = "<td>Total Host IP ADDRESSES</td><td>$hostcount</td>";

}
if (checkIfCIDR($ipAddress)) {

    $ip = preg_split("#/#", $ipAddress);
    $sub = new Net\Subnet($ip[0], $ip[1]);

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

echo json_encode($tableArray);
?>