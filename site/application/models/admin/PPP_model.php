<?php
class PPP_model extends CI_Model{

	public function add_ppp_account_return_id($data){
		if ($data['passwordtype'] == ''){}

		if ($data['profileid'] == 0) {}
		elseif ($data['profileid'] > 0) {}
		else {}

		if ($data['ipaddresstype'] == "dhcp") {}
		elseif ($data['ipaddresstype'] == 'static') {}
		else {}

		$cleanData = array(
			'username' => $data['username'],
			'password' =>  $data['password'],
			'profileid' => $data['profileid'],
			'staticip' => NULL,
			'start_date' => $data['start_date']
			);

		$this->db->insert('ppp_accounts', $cleanData);
		return true;
	}
	public function link_ppp_to_user($pppid, $userid)
	{
		$data = array(
			'pppid' => $pppid,
			'userid' => $userid,
			'start_date' => date('Y-m-d H:i:s'),
			'is_active' => true,
		);
		$this->db->insert('ppp_accounts_users', $data);
		return true;
	}

	//---------------------------------------------------
	// get all users for server-side datatable processing (ajax based)
	public function get_all_nas_devices(){
		$this->db->select('*');
		//$this->db->where('is_admin',0);
		return $this->db->get('nas')->result_array();
	}


	//---------------------------------------------------
	// Get user detial by ID
	public function get_nas_by_id($id){
		$query = $this->db->get_where('nas', array('id' => $id));
		return $result = $query->row_array();
	}

	//---------------------------------------------------
	// Edit user Record
	public function edit_nas($data, $id){
		$this->db->where('id', $id);
		$this->db->update('nas', $data);
		return true;
	}

	//---------------------------------------------------
	// Change user status
	//-----------------------------------------------------
	function change_status()
	{
		$this->db->set('is_active', $this->input->post('status'));
		$this->db->where('id', $this->input->post('id'));
		$this->db->update('nas');
	}

}

?>
