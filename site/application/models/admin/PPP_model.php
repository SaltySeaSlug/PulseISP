<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/13, 21:37
 */

class PPP_model extends CI_Model{

	public function add_data_account($data, $returnId = false) {
		$this->db->insert($this->config->item('CONFIG_DB_TBL_DATA_ACCOUNT'), $data);
		if ($returnId == true) return $this->db->insert_id();
		else return true;
	}

	public function add_ppp_account_return_id($data)
	{
		if ($data['passwordtype'] == '') {
		}

		if ($data['profileid'] == 0) {
		} elseif ($data['profileid'] > 0) {
		} else {
		}

		if ($data['ipaddresstype'] === 'dhcp') {

		} else {
			$data_ppp[] = array('staticip' => $this->input->post('staticip'));
		}

		$cleanData = array(
			'username' => $data['username'],
			'password' => $data['password'],
			'profileid' => $data['profileid'],
			'start_date' => $data['start_date']
		);

		$this->db->insert($this->config->item('CONFIG_DB_TBL_DATA_ACCOUNT'), $cleanData);
		return true;
	}
	public function link_data_account_to_user($dataAccountId, $userid)
	{
		$data = array(
			'ppp_id' => $dataAccountId,
			'user_id' => $userid,
			'start_date' => date('Y-m-d H:i:s'),
			'is_active' => true,
			'is_deleted' => false
		);
		$this->db->insert($this->config->item('CONFIG_DB_TBL_LINK_USER_DATA_ACCOUNT'), $data);
		return true;
	}
	public function add_attributes_to_radcheck($data){}
	public function add_attributes_to_radreply($data){}

}

?>
