<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

class Setting_model extends CI_Model
{
	public bool $LINUX_OS;

	public function __construct()
	{
		parent::__construct();

		//$this->load->helper('custom_helper');
		$this->LINUX_OS = os_type();
	}

	//-----------------------------------------------------
	public function update_general_setting($data): bool
	{
		$this->db->where('id', 1);
		$this->db->update($this->config->item('CONFIG_DB_TBL_GENERAL_SETTING'), $data);
		return true;
	}

	//-----------------------------------------------------
	public function get_general_settings()
	{
		$this->db->where('id', 1);
		$query = $this->db->get($this->config->item('CONFIG_DB_TBL_GENERAL_SETTING'));
		return $query->row_array();
	}

	public function get_all_languages()
	{
		$this->db->where('status', 1);
		return $this->db->get($this->config->item('CONFIG_DB_TBL_LANGUAGE'))->result_array();
	}

	public function get_timezone_list() {
	    $time_Zones_arr = array();
	    $live_timestamp = time();
		    foreach(timezone_identifiers_list() as $key => $zone) {
		        date_default_timezone_set($zone);
		        $time_Zones_arr[$key]['zone'] = $zone;
		        $time_Zones_arr[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $live_timestamp);
		    }
	    return $time_Zones_arr;
	}

	public function get_currency_list()
	{
		return $this->db->get($this->config->item('CONFIG_DB_TBL_CURRENCY'))->result_array();
	}

	public function get_currency(){
		$this->db->where('id', 1);
		$query = $this->db->get($this->config->item('CONFIG_DB_TBL_GENERAL_SETTING'));
        return $query->row_array()['currency'];
	}

	/*--------------------------
	   Email Template Settings
	--------------------------*/

	function get_email_templates()
	{
		return $this->db->get($this->config->item('CONFIG_DB_TBL_EMAIL_TEMPLATE'))->result_array();
	}

	function update_email_template($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update($this->config->item('CONFIG_DB_TBL_EMAIL_TEMPLATE'), $data);
		return true;
	}

	function get_email_template_content_by_id($id)
	{
		return $this->db->get_where($this->config->item('CONFIG_DB_TBL_EMAIL_TEMPLATE'), array('id' => $id))->row_array();
	}

	function get_email_template_variables_by_id($id)
	{
		return $this->db->get_where($this->config->item('CONFIG_DB_TBL_EMAIL_TEMPLATE_VARIABLE'), array('template_id' => $id))->result_array();
	}


	function shapeSpace_server_uptime() {

		$file_name = "/proc/uptime";
		$fopen_file = fopen($file_name, 'r');
		$buffer = explode(' ', fgets($fopen_file, 4096));
		fclose($fopen_file);
		$sys_ticks = trim($buffer[0]);
		$min = $sys_ticks / 60;
		$hours = $min / 60;
		$days = floor($hours / 24);
		$hours = floor($hours - ($days * 24));
		$min = floor($min - ($days * 60 * 24) - ($hours * 60));
		$result = "";
		if ($days != 0) {
			if ($days > 1)
				$result = "$days " . " days ";
			else
				$result = "$days " . " day ";
		}
		if ($hours != 0) {
			if ($hours > 1)
				$result .= "$hours " . " hours ";
			else
				$result .= "$hours " . " hour ";
		}
		if ($min > 1 || $min == 0)
			$result .= "$min " . " minutes ";
		elseif ($min == 1)
			$result .= "$min " . " minute ";
		return $result;

	}
	function get_datetime() {
		if ($today = date("F j, Y, g:i a")) {
			$result = $today;
		} else {
			$result = "(none)";
		}
		return $result;
	}
	function get_hostname() {
		$file_name = "/proc/sys/kernel/hostname";
		if ($fopen_file = fopen($file_name, 'r')) {
			$result = trim(fgets($fopen_file, 4096));
			fclose($fopen_file);
		} else {
			$result = "(none)";
		}
		return $result;
	}
	function get_memory() {
		$file_name = "/proc/meminfo";
		$mem_array = array();
		$buffer = file($file_name);

		foreach($buffer as $key => $value) {
			if (strpos($value, ':') !== false) {
				$match_line = explode(':', $value);
				$match_value = explode(' ', trim($match_line[1]));
				if (is_numeric($match_value[0])) {
					$mem_array[trim($match_line[0])] = trim($match_value[0]);
				}
			}
		}
		return $mem_array;
	}
	function shapeSpace_system_load($coreCount = 2, $interval = 1) {
		$rs = sys_getloadavg();
		$interval = $interval >= 1 && 3 <= $interval ? $interval : 1;
		$load = $rs[$interval];
		return round(($load * 100) / $coreCount,2);
	}
	function get_system_load() {
		$file_name = "/proc/loadavg";
		$result = "";
		$output = "";
		// get the /proc/loadavg information
		if ($fopen_file = fopen($file_name, 'r')) {
			$result = trim(fgets($fopen_file, 256));
			fclose($fopen_file);
		} else {
			$result = "(none)";
		}
		$loadavg = explode(" ", $result);
		$output .= $loadavg[0] . " " . $loadavg[1] . " " . $loadavg[2] . "<br/>";
		// get information the 'top' program
		$file_name = "top -b -n1 | grep \"Tasks:\" -A1";
		$result = "";
		if ($popen_file = popen($file_name, 'r')) {
			$result = trim(fread($popen_file, 2048));
			pclose($popen_file);
		} else {
			$result = "(none)";
		}
		$result = str_replace("\n", "<br/>", $result);
		$output .= $result;
		return $output;
	}
	function toxbyte($size)
	{
		// Gigabytes
		if ( $size > 1073741824 )
		{
			$ret = $size / 1073741824;
			$ret = round($ret,2)." GB";
			return $ret;
		}
		// Megabytes
		if ( $size > 1048576 )
		{
			$ret = $size / 1048576;
			$ret = round($ret,2)." MB";
			return $ret;
		}
		// Kilobytes
		if ($size > 1024 )
		{
			$ret = $size / 1024;
			$ret = round($ret,2)." KB";
			return $ret;
		}
		// Bytes
		if ( ($size != "") && ($size <= 1024 ) )
		{
			$ret = $size." B";
			return $ret;
		}
	}
	function convert_ToMB($value) {
		return round($value / 1024) . " MB\n";
	}
	function get_hdd_size(){
		$ds = disk_total_space("/");
		return $ds;
	}
	function get_hdd_freespace() {
		$df = disk_free_space("/");
		return $df;
	}
	function getNiceFileSize($bytes, $binaryPrefix=true) {
		if ($binaryPrefix) {
			$unit=array('B','KiB','MiB','GiB','TiB','PiB');
			if ($bytes==0) return '0 ' . $unit[0];
			return @round($bytes/pow(1024,($i=floor(log($bytes,1024)))),2) .' '. (isset($unit[$i]) ? $unit[$i] : 'B');
		} else {
			$unit=array('B','KB','MB','GB','TB','PB');
			if ($bytes==0) return '0 ' . $unit[0];
			return @round($bytes/pow(1000,($i=floor(log($bytes,1000)))),2) .' '. (isset($unit[$i]) ? $unit[$i] : 'B');
		}
	}

	function systemInfo() {

		$dd=array(
			'Server Uptime'=> ($this->LINUX_OS) ? $this->shapeSpace_server_uptime() : '',
			'System Time'=> $this->get_datetime(),
			'Hostname'=> ($this->LINUX_OS) ? $this->get_hostname() : '',

			'Server Address'=>$_SERVER['SERVER_ADDR'],
			'Webserver'=>$_SERVER['SERVER_SOFTWARE'],
			'Document Root'=>$_SERVER['DOCUMENT_ROOT'],
			'HTTP Host'=>$_SERVER['HTTP_HOST'],
		);

		return $dd;
	}
	function systemLoad() {

		$meminfo = ($this->LINUX_OS) ? $this->get_memory() : array('MemTotal' => 1024, 'MemFree' => 1024);
		$memused = ($this->LINUX_OS) ? ($meminfo['MemTotal'] - $meminfo['MemFree']) : 1024;

		$dd=array(
			'System Load'=>($this->LINUX_OS) ? $this->shapeSpace_system_load() : '',
			'System Load'=>($this->LINUX_OS) ?$this->get_system_load():'',

			'Memory Total'=>$this->convert_ToMB($meminfo['MemTotal']),
			'Memory Free'=>$this->convert_ToMB($meminfo['MemFree']),
			'Memory Used'=>$this->convert_ToMB($memused),

			'Total HDD Space'=>$this->toxbyte($this->get_hdd_size()),
			'Free HDD Space'=>$this->toxbyte($this->get_hdd_freespace()),
		);

		return $dd;
	}
	function systemInterface() {

		$meminfo = $this->get_memory();

		$dd=array(
			'Uptime'=>$this->shapeSpace_server_uptime(),
			'System Time'=>$this->get_datetime(),
			'Hostname'=>$this->get_hostname(),
			'System Load'=>$this->shapeSpace_system_load(),
			'System Load'=>$this->get_system_load(),
			'Memory Total'=>$this->getNiceFileSize($meminfo['MemTotal']),
			'Memory Free'=>$this->getNiceFileSize($meminfo['MemFree']),
			'Memory Used'=>$this->getNiceFileSize($meminfo['MemTotal'] - $meminfo['MemFree']),
			'Server Address'=>$_SERVER['SERVER_ADDR'],
			'Webserver'=>$_SERVER['SERVER_SOFTWARE'],
			'Document Root'=>$_SERVER['DOCUMENT_ROOT'],
			'HTTP Host'=>$_SERVER['HTTP_HOST'],
			'Free HDD Space'=>$this->toxbyte ($this->get_hdd_freespace()),
			'HDD Size'=>$this->toxbyte ($this->get_hdd_size()),
			'Remote Port'=>$_SERVER['REMOTE_PORT'],
			'Script File Name'=>$_SERVER['SCRIPT_FILENAME'],
			'Server Admin'=>$_SERVER['SERVER_ADMIN'],
			'Serever Port'=>$_SERVER['SERVER_PORT'],
			'Script Name'=>$_SERVER['SCRIPT_NAME'],
			'Request URI'=>$_SERVER['REQUEST_URI'],
			'PHP Self'=>$_SERVER['PHP_SELF']
		);

		return $dd;
	}
	function systemLoad1() {

		$meminfo = $this->get_memory();

		$dd=array(
			'System Uptime'=>$this->shapeSpace_server_uptime(),
			'Current Date'=>$this->get_datetime(),
			'Hostname'=>$this->get_hostname(),

			'System Load'=>$this->shapeSpace_system_load(),
			'System Load'=>$this->get_system_load(),

			'Memory Total'=>$this->convert_ToMB($meminfo['MemTotal']),
			'Memory Free'=>$this->convert_ToMB($meminfo['MemFree']),
			'Memory Used'=>$this->convert_ToMB($meminfo['MemTotal'] - $meminfo['MemFree']),
			'Server Address'=>$_SERVER['SERVER_ADDR'],
			'Webserver'=>$_SERVER['SERVER_SOFTWARE'],
			'Document Root'=>$_SERVER['DOCUMENT_ROOT'],
			'HTTP Host'=>$_SERVER['HTTP_HOST'],
			'Free HDD Space'=>$this->toxbyte ($this->get_hdd_freespace()),
			'HDD Size'=>$this->toxbyte ($this->get_hdd_size()),
			'Remote Port'=>$_SERVER['REMOTE_PORT'],
			'Script File Name'=>$_SERVER['SCRIPT_FILENAME'],
			'Server Admin'=>$_SERVER['SERVER_ADMIN'],
			'Serever Port'=>$_SERVER['SERVER_PORT'],
			'Script Name'=>$_SERVER['SCRIPT_NAME'],
			'Request URI'=>$_SERVER['REQUEST_URI'],
			'PHP Self'=>$_SERVER['PHP_SELF']
		);

		return $dd;
	}

}
?>
