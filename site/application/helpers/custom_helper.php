<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('generate_numbers')) {
	function generate_numbers($letter, $start, $digits = 5)
	{
		return $letter . str_pad($start + 1, $digits, "0", STR_PAD_LEFT);
	}
}
if(!function_exists('time2str')) {
	function time2str($time) {
		$str = "";
		$time = floor($time);
		if (!$time)
			return "0 seconds";
		$d = $time/86400;
		$d = floor($d);
		if ($d){
			$str .= "$d days, ";
			$time = $time % 86400;
		}
		$h = $time/3600;
		$h = floor($h);
		if ($h){
			$str .= "$h hours, ";
			$time = $time % 3600;
		}
		$m = $time/60;
		$m = floor($m);
		if ($m){
			$str .= "$m minutes, ";
			$time = $time % 60;
		}
		if ($time)
			$str .= "$time seconds, ";
		$str = preg_replace("/, $/",'',$str);
		return $str;
	}
}
if(!function_exists('toxbyte')) {
	function toxbyte($size)
	{
		// Gigabytes
		if ($size > 1073741824) {
			$ret = $size / 1073741824;
			$ret = round($ret, 2) . " Gb";
			return $ret;
		}

		// Megabytes
		if ($size > 1048576) {
			$ret = $size / 1048576;
			$ret = round($ret, 2) . " Mb";
			return $ret;
		}

		// Kilobytes
		if ($size > 1024) {
			$ret = $size / 1024;
			$ret = round($ret, 2) . " Kb";
			return $ret;
		}

		// Bytes
		if (($size != "") && ($size <= 1024)) {
			$ret = $size . " B";
			return $ret;
		}
	}
}
if(!function_exists('toxBytes')) {
	function toxBytes($bytes, $force_unit = NULL, $format = NULL, $si = FALSE)
	{
		//if ($bytes == 0) return 0;
		// Format string
		$format = ($format === NULL) ? '%01.2f %s' : (string)$format;

		// IEC prefixes (binary)
		if ($si == FALSE or strpos($force_unit, 'i') !== FALSE) {
			$units = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
			$mod = 1024;
		} // SI prefixes (decimal)
		else {
			$units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB');
			$mod = 1000;
		}

		// Determine unit to use
		if (($power = array_search((string)$force_unit, $units)) === FALSE) {
			$power = ($bytes > 0) ? floor(log($bytes, $mod)) : 0;
		}

		return ($bytes / pow($mod, $power));
	}
}
if(!function_exists('getWeekday')) {
	function getWeekday($date)
	{
		return date('w', strtotime($date));
	}
}
if(!function_exists('getDay')) {
	function getDay($dow_numeric)
	{
		$dowMap = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		return $dowMap[$dow_numeric];
	}
}
if(!function_exists('daysBetween')) {
	function daysBetween($dt1, $dt2)
	{
		return date_diff(
			date_create($dt2),
			date_create($dt1)
		)->format('%a');
	}
}
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

if (!function_exists('os_type'))
{
	function os_type() {
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			return false;
		}
		else {
			return true;
		}
	}
}
