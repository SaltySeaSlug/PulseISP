<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

class Activity_model extends CI_Model{

	public function get_activity_log(){
		$this->db->select('
			' . $this->config->item('CONFIG_DB_TBL_ACTIVITY_LOG') . '.id,
			' . $this->config->item('CONFIG_DB_TBL_ACTIVITY_LOG') . '.activity_id,
			' . $this->config->item('CONFIG_DB_TBL_ACTIVITY_LOG') . '.user_id,
			' . $this->config->item('CONFIG_DB_TBL_ACTIVITY_LOG') . '.admin_id,
			' . $this->config->item('CONFIG_DB_TBL_ACTIVITY_LOG') . '.created_at,
			' . $this->config->item('CONFIG_DB_TBL_ACTIVITY_LOG') . '.description as message,
			' . $this->config->item('CONFIG_DB_TBL_ACTIVITY_LOG') . '.ip_address,
			' . $this->config->item('CONFIG_DB_TBL_ACTIVITY_STATUS') . '.description,
			' . $this->config->item('CONFIG_DB_TBL_USER') . '.id as uid,
			' . $this->config->item('CONFIG_DB_TBL_USER') . '.username,
			' . $this->config->item('CONFIG_DB_TBL_ADMIN') . '.admin_id,
			' . $this->config->item('CONFIG_DB_TBL_ADMIN') . '.username as adminname
		');
		$this->db->join($this->config->item('CONFIG_DB_TBL_ACTIVITY_STATUS'), '' . $this->config->item('CONFIG_DB_TBL_ACTIVITY_STATUS') . '.id=' . $this->config->item('CONFIG_DB_TBL_ACTIVITY_LOG') . '.activity_id');
		$this->db->join($this->config->item('CONFIG_DB_TBL_USER'), '' . $this->config->item('CONFIG_DB_TBL_USER') . '.id=' . $this->config->item('CONFIG_DB_TBL_ACTIVITY_LOG') . '.user_id', 'left');
		$this->db->join($this->config->item('CONFIG_DB_TBL_ADMIN'), '' . $this->config->item('CONFIG_DB_TBL_ADMIN') . '.admin_id=' . $this->config->item('CONFIG_DB_TBL_ACTIVITY_LOG') . '.admin_id', 'left');
		$this->db->order_by($this->config->item('CONFIG_DB_TBL_ACTIVITY_LOG') . '.id', 'desc');
		return $this->db->get()->result_array();
	}

	//--------------------------------------------------------------------
	/*public function add_log($activity){
		$data = array(
			'activity_id' => $activity,
			'user_id' => ($this->session->userdata('user_id') != '') ? $this->session->userdata('user_id') : 0,
			'admin_id' => ($this->session->userdata('admin_id') != '') ? $this->session->userdata('admin_id') : 0,
			'created_at' => date('Y-m-d H:i:s')
		);
		$this->db->insert('ci_activity_log',$data);
		return true;
	}*/
	public function add_to_system_log($message, $activity = 4)
	{
		$data = array(
			'activity_id' => $activity,
			'user_id' => ($this->session->userdata('user_id') != '') ? $this->session->userdata('user_id') : null,
			'admin_id' => ($this->session->userdata('admin_id') != '') ? $this->session->userdata('admin_id') : null,
			'description' => json_encode($message),
			'ip_address' => getRealIpAddr(),
			'created_at' => date('Y-m-d H:i:s')
		);
		$this->db->insert($this->config->item('CONFIG_DB_TBL_ACTIVITY_LOG'), $data);
		return true;
	}
	public function get_audit_trail()
	{
		return $this->db->get($this->config->item('CONFIG_DB_TBL_AUDIT_TRAIL'))->result_array();
	}

	
}

?>
