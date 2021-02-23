<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

class RBAC
{
	function __construct()
	{
		$this->obj =& get_instance();
		$this->obj->module_access = $this->obj->session->userdata('module_access');
		$this->obj->is_supper = $this->obj->session->userdata('is_supper');
	}

	//----------------------------------------------------------------
	function set_access_in_session()
	{
		$this->obj->db->from('ci_module_access');
		$this->obj->db->where('admin_role_id', $this->obj->session->userdata('admin_role_id'));
		$query = $this->obj->db->get();
		$data = array();
		foreach ($query->result_array() as $v) {
			$data[$v['module']][$v['operation']] = '';
		}

		$this->obj->session->set_userdata('module_access', $data);
	}


	//--------------------------------------------------------------	
	function check_module_access(): int
	{
		//if ($this->obj->is_supper) return 1;

		//sending controller name
		if (!$this->check_module_permission($this->obj->uri->segment(2))) {
			$back_to = $_SERVER['REQUEST_URI'];
			$back_to = $this->obj->functions->encode($back_to);
			redirect('access_denied/index/' . $back_to);
		} else return 0;
	}

	//--------------------------------------------------------------
	// $module is controller name
	function check_module_permission($module): int
	{
		//if ($this->obj->is_supper) return true;

		$access = false;

		if (isset($this->obj->module_access[$module])) {
			foreach ($this->obj->module_access[$module] as $key => $value) {
				if ($key == 'access') {
					$access = true;
				}
			}

			if ($access) return 1;
			else return 0;
		} else return 0;
	}

	//--------------------------------------------------------------	
	function check_operation_access(): int
	{
		//if ($this->obj->is_supper) return 1;

		if (!$this->check_operation_permission($this->obj->uri->segment(3))) {
			$back_to = $_SERVER['REQUEST_URI'];
			$back_to = $this->obj->functions->encode($back_to);
			redirect('access_denied/index/' . $back_to);
		} else return 0;
	}

	//--------------------------------------------------------------	
	function check_operation_permission($operation): int
	{
		if (isset($this->obj->module_access[$this->obj->uri->segment(2)][$operation]))
			return 1;
		else
			return 0;
	}


}
?>
