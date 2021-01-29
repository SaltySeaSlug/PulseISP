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
				radgroupreply.id as radgroupid,
				radgroupreply.groupname as groupname,
				radgroupreply.attribute as attribute,
				radgroupreply.op as op,
				radgroupreply.value as value
	    	');
		$this->db->join('radgroupreply','radgroupreply.groupname = ci_profile_components.name','left');
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
			$this->db->insert("radgroupreply", $dictionaryitem);
		} else {
			$this->db->insert("radgroupcheck", $dictionaryitem);
		}
	}

	public function get_all_vendors() {
		return $this->db->query('SELECT DISTINCT vendor FROM raddictionary ORDER BY vendor ASC;')->result_array();
	}
}

?>
