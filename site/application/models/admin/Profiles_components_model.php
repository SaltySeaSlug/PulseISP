<?php
class Profiles_components_model extends CI_Model{

	public function get_all_profiles() {
		return $this->db->get('ci_profiles')->result_array();
	}
	public function get_profile_components($profileName) {
		if ($profileName == null) { return; }

		return $this->db_get_where('radusergroup', ['username' => $profileName])->result_array();
	}
	public function get_all_profiles_join(){
		$this->db->select('
	    		ci_profiles.id,
				ci_profiles.name,
				radusergroup.id as radgroupid,
				radusergroup.username as profilename,
				radusergroup.groupname,
				radusergroup.priority
	    	');
		$this->db->join('radusergroup','radusergroup.username = ci_profiles.name','left');
		return $this->db->get('ci_profiles')->result_array();
	}

	public function get_all_components() {
		return $this->db->get('ci_profile_components')->result_array();
	}
	public function get_all_components_join(){
		$this->db->select('
	    		ci_profile_components.id,
				ci_profile_components.name,
				'.$this->config->item('CONFIG_DB_TBL_RADGROUPREPLY').'.id as radgroupid,
				'.$this->config->item('CONFIG_DB_TBL_RADGROUPREPLY').'.groupname as groupname,
				'.$this->config->item('CONFIG_DB_TBL_RADGROUPREPLY').'.attribute as attribute,
				'.$this->config->item('CONFIG_DB_TBL_RADGROUPREPLY').'.op as op,
				'.$this->config->item('CONFIG_DB_TBL_RADGROUPREPLY').'.value as value
	    	');
		$this->db->join($this->config->item('CONFIG_DB_TBL_RADGROUPREPLY'),''.$this->config->item('CONFIG_DB_TBL_RADGROUPREPLY').'.groupname = ci_profile_components.name','left');
		return $this->db->get('ci_profile_components')->result_array();
	}


	public function add_profile($data){
		return $this->db->insert('ci_profiles', $data);
	}

	public function link_profile_component_to_profile($profilename, $componentid){
		$componentName = $this->db->get("ci_profile_components", $componentid)->row()->name;
		$insert = array("username" => $profilename, "groupname" => $componentName, "priority" => 5);
		return $this->db->insert("radusergroup", $insert);
	}

	public function add_profile_component($data){
		return $this->db->insert('ci_profile_components', $data);
	}

	public function link_dictionaryitem_to_profile_component($dictionaryitem, $target = "Reply")
	{
		if ($target == "Reply") {
			$this->db->insert($this->config->item('CONFIG_DB_TBL_RADGROUPREPLY'), $dictionaryitem);
		} else {
			$this->db->insert("radgroupcheck", $dictionaryitem);
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
