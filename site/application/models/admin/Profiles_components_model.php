<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

class Profiles_components_model extends CI_Model{

	public function get_all_profiles() {
		return $this->db->get($this->config->item('CONFIG_DB_TBL_PROFILE'))->result_array();
	}
	public function get_profile_components($profileName)
	{
		if ($profileName == null) {
			return;
		}

		return $this->db_get_where($this->config->item('CONFIG_DB_TBL_RADUSERGROUP'), ['username' => $profileName])->result_array();
	}
	public function get_all_profiles_join()
	{
		$this->db->select('
	    		' . $this->config->item('CONFIG_DB_TBL_PROFILE') . '.id,
				' . $this->config->item('CONFIG_DB_TBL_PROFILE') . '.name,
				' . $this->config->item('CONFIG_DB_TBL_RADUSERGROUP') . '.id as radgroupid,
				' . $this->config->item('CONFIG_DB_TBL_RADUSERGROUP') . '.username as profilename,
				' . $this->config->item('CONFIG_DB_TBL_RADUSERGROUP') . '.groupname,
				' . $this->config->item('CONFIG_DB_TBL_RADUSERGROUP') . '.priority
	    	');
		$this->db->join($this->config->item('CONFIG_DB_TBL_RADUSERGROUP'), $this->config->item('CONFIG_DB_TBL_RADUSERGROUP') . 'radusergroup.username = ' . $this->config->item('CONFIG_DB_TBL_PROFILE') . '.name', 'left');
		return $this->db->get($this->config->item('CONFIG_DB_TBL_PROFILE'))->result_array();
	}

	public function get_all_components()
	{
		return $this->db->get($this->config->item('CONFIG_DB_TBL_PROFILE_COMPONENT'))->result_array();
	}
	public function get_all_components_join()
	{
		$this->db->select('
	    		' . $this->config->item('CONFIG_DB_TBL_PROFILE_COMPONENT') . '.id,
				' . $this->config->item('CONFIG_DB_TBL_PROFILE_COMPONENT') . '.name,
				' . $this->config->item('CONFIG_DB_TBL_RADGROUPREPLY') . '.id as radgroupid,
				' . $this->config->item('CONFIG_DB_TBL_RADGROUPREPLY') . '.groupname as groupname,
				' . $this->config->item('CONFIG_DB_TBL_RADGROUPREPLY') . '.attribute as attribute,
				' . $this->config->item('CONFIG_DB_TBL_RADGROUPREPLY') . '.op as op,
				' . $this->config->item('CONFIG_DB_TBL_RADGROUPREPLY') . '.value as value
	    	');
		$this->db->join($this->config->item('CONFIG_DB_TBL_RADGROUPREPLY'), '' . $this->config->item('CONFIG_DB_TBL_RADGROUPREPLY') . '.groupname = ' . $this->config->item('CONFIG_DB_TBL_PROFILE_COMPONENT') . '.name', 'left');
		return $this->db->get($this->config->item('CONFIG_DB_TBL_PROFILE_COMPONENT'))->result_array();
	}


	public function add_profile($data)
	{
		return $this->db->insert($this->config->item('CONFIG_DB_TBL_PROFILE'), $data);
	}

	public function link_profile_component_to_profile($profilename, $componentid)
	{
		$componentName = $this->db->get($this->config->item('CONFIG_DB_TBL_PROFILE_COMPONENT'), $componentid)->row()->name;
		$insert = array("username" => $profilename, "groupname" => $componentName, "priority" => 5);
		return $this->db->insert($this->config->item('CONFIG_DB_TBL_RADUSERGROUP'), $insert);
	}

	public function add_profile_component($data)
	{
		return $this->db->insert($this->config->item('CONFIG_DB_TBL_PROFILE_COMPONENT'), $data);
	}

	public function link_dictionaryitem_to_profile_component($dictionaryitem, $target = "Reply")
	{
		if ($target === "Reply") {
			$this->db->insert($this->config->item('CONFIG_DB_TBL_RADGROUPREPLY'), $dictionaryitem);
		} else {
			$this->db->insert($this->config->item('CONFIG_DB_TBL_RADGROUPCHECK'), $dictionaryitem);
		}
	}

	public function get_all_vendors() {
		$this->db->distinct();
		$this->db->select('vendor');
		$this->db->order_by('vendor', 'ASC');
		$this->db->from($this->config->item('CONFIG_DB_TBL_RADDICTIONARY'));
		return $this->db->get()->result_array();
	}
}

?>
