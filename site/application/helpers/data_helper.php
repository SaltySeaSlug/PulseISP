<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('check_nas_status')) {
	function check_nas_status($id)
	{
		$ci = &get_instance();
		$ci->db->where('id', $id);
		$dateTime = strtotime($ci->db->get('nas')->row_array()['last_contact']);
		$dateTimeNow = (strtotime(date('Y-m-d H:i:s')) - 30 * 60);

		if ($dateTime >= $dateTimeNow) return true;
		else return false;
	}
}
?> 
