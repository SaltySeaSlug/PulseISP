<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('check_nas_status')) {
	function check_nas_status($id)
	{
		$ci = &get_instance();
		$ci->db->where('id', $id);
		$dateTime = strtotime($ci->db->get('radnas')->row_array()['last_contact']);
		$dateTimeNow = (strtotime(date('Y-m-d H:i:s')) - 30 * 60);

		if ($dateTime >= $dateTimeNow) return true;
		else return false;
	}
}
if (!function_exists('ip_range')) {

	function ip_range($start, $end)
	{
		$start = ip2long($start);
		$end = ip2long($end);
		return array_map('long2ip', range($start, $end));
	}
}
if (!function_exists('checkIfIPRange')) {

	function checkIfIPRange($ipAddress)
	{
		return preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}-(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}?$/', $ipAddress);
	}
}
if (!function_exists('checkIfCIDR')) {

	function checkIfCIDR($ipAddress)
	{
		return preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}(\/([0-9]|[1-2][0-9]|3[0-2]))?$/', $ipAddress);
	}
}
if (!function_exists('iMask')) {

	function iMask($s)
	{
		return base_convert((pow(2, 32) - pow(2, (32 - $s))), 10, 16);
	}
}
if (!function_exists('iprange2cidr')) {

	function iprange2cidr($ipStart, $ipEnd)
	{
		if (is_string($ipStart) || is_string($ipEnd)) {
			$start = ip2long($ipStart);
			$end = ip2long($ipEnd);
		} else {
			$start = $ipStart;
			$end = $ipEnd;
		}

		$result = array();

		while ($end >= $start) {
			$maxSize = 32;
			while ($maxSize > 0) {
				$mask = hexdec(iMask($maxSize - 1));
				$maskBase = $start & $mask;
				if ($maskBase != $start) break;
				$maxSize--;
			}
			$x = log($end - $start + 1) / log(2);
			$maxDiff = floor(32 - floor($x));

			if ($maxSize < $maxDiff) {
				$maxSize = $maxDiff;
			}

			$ip = long2ip($start);
			array_push($result, "$ip/$maxSize");
			$start += pow(2, (32 - $maxSize));
		}
		return $result;
	}
}

?> 
