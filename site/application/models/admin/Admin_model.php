<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

class Admin_model extends CI_Model{

	public function get_user_detail(){
		$id = $this->session->userdata('admin_id');
		$query = $this->db->get_where($this->config->item('CONFIG_DB_TBL_ADMIN'), array('admin_id' => $id));
		return $result = $query->row_array();
	}
	//--------------------------------------------------------------------
	public function update_user($data)
	{
		$id = $this->session->userdata('admin_id');
		$this->db->where('admin_id', $id);
		$this->db->update($this->config->item('CONFIG_DB_TBL_ADMIN'), $data);
		return true;
	}
	//--------------------------------------------------------------------
	public function change_pwd($data, $id)
	{
		$this->db->where('admin_id', $id);
		$this->db->update($this->config->item('CONFIG_DB_TBL_ADMIN'), $data);
		return true;
	}
	//-----------------------------------------------------
	function get_admin_roles()
	{
		$this->db->from($this->config->item('CONFIG_DB_TBL_ADMIN_ROLE'));
		$this->db->where('admin_role_status', 1);
		$query = $this->db->get();
		return $query->result_array();
	}

	//-----------------------------------------------------
	function get_admin_by_id($id)
	{
		$this->db->from($this->config->item('CONFIG_DB_TBL_ADMIN'));
		$this->db->join($this->config->item('CONFIG_DB_TBL_ADMIN_ROLE'), $this->config->item('CONFIG_DB_TBL_ADMIN_ROLE') . 'admin_role_id=' . $this->config->item('CONFIG_DB_TBL_ADMIN') . '.admin_role_id');
		$this->db->where('admin_id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	//-----------------------------------------------------
	function get_all()
	{

		$this->db->from($this->config->item('CONFIG_DB_TBL_ADMIN'));

		$this->db->join($this->config->item('CONFIG_DB_TBL_ADMIN_ROLE'), $this->config->item('CONFIG_DB_TBL_ADMIN_ROLE') . '.admin_role_id=' . $this->config->item('CONFIG_DB_TBL_ADMIN') . '.admin_role_id');

		if ($this->session->userdata('filter_type') != '')

			$this->db->where($this->config->item('CONFIG_DB_TBL_ADMIN') . '.admin_role_id', $this->session->userdata('filter_type'));

		if ($this->session->userdata('filter_status') != '')

			$this->db->where($this->config->item('CONFIG_DB_TBL_ADMIN') . '.is_active', $this->session->userdata('filter_status'));


		$filterData = $this->session->userdata('filter_keyword');

		$this->db->like($this->config->item('CONFIG_DB_TBL_ADMIN_ROLE') . '.admin_role_title', $filterData);
		$this->db->or_like($this->config->item('CONFIG_DB_TBL_ADMIN') . '.firstname', $filterData);
		$this->db->or_like($this->config->item('CONFIG_DB_TBL_ADMIN') . '.lastname', $filterData);
		$this->db->or_like($this->config->item('CONFIG_DB_TBL_ADMIN') . '.email', $filterData);
		$this->db->or_like($this->config->item('CONFIG_DB_TBL_ADMIN') . '.mobile_no', $filterData);
		$this->db->or_like($this->config->item('CONFIG_DB_TBL_ADMIN') . '.username', $filterData);

		$this->db->where($this->config->item('CONFIG_DB_TBL_ADMIN') . '.is_supper !=', 1);

		$this->db->order_by($this->config->item('CONFIG_DB_TBL_ADMIN') . '.admin_id', 'desc');

		$query = $this->db->get();

		$module = array();

		if ($query->num_rows() > 0) {
			$module = $query->result_array();
		}

		return $module;
	}

	//-----------------------------------------------------
public function add_admin($data)
{
	$this->db->insert($this->config->item('CONFIG_DB_TBL_ADMIN'), $data);
	return true;
}

	//---------------------------------------------------
	// Edit Admin Record
public function edit_admin($data, $id)
{
	$this->db->where('admin_id', $id);
	$this->db->update($this->config->item('CONFIG_DB_TBL_ADMIN'), $data);
	return true;
}

	//-----------------------------------------------------
function change_status()
{
	$this->db->set('is_active', $this->input->post('status'));
	$this->db->where('admin_id', $this->input->post('id'));
	$this->db->update($this->config->item('CONFIG_DB_TBL_ADMIN'));
} 

	//-----------------------------------------------------
function delete($id)
{
	$this->db->where('admin_id', $id);
	$this->db->delete($this->config->item('CONFIG_DB_TBL_ADMIN'));
} 

}

?>
