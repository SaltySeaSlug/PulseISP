<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

class Auth_model extends CI_Model{

	public function login($data){

		$this->db->from($this->config->item('CONFIG_DB_TBL_ADMIN'));
		$this->db->join($this->config->item('CONFIG_DB_TBL_ADMIN_ROLE'), $this->config->item('CONFIG_DB_TBL_ADMIN_ROLE') . '.admin_role_id = ' . $this->config->item('CONFIG_DB_TBL_ADMIN') . '.admin_role_id');
		$this->db->where($this->config->item('CONFIG_DB_TBL_ADMIN') . '.username', $data['username']);

		$query = $this->db->get();

		if ($query->num_rows() == 0) {
			return false;
		} else {
			//Compare the password attempt with the password we have stored.
			$result = $query->row_array();
			$validPassword = password_verify($data['password'], $result['password']);

			$session_data['last_ip'] = getRealIpAddr();

			$this->db->where('admin_id', $result['admin_id']);
			$this->db->update($this->config->item('CONFIG_DB_TBL_ADMIN'), $session_data);

			if ($validPassword) {
				return $result = $query->row_array();
			}
		}
	}

	//--------------------------------------------------------------------
	public function register($data)
	{
		$this->db->insert($this->config->item('CONFIG_DB_TBL_ADMIN'), $data);
		return true;
	}

	//--------------------------------------------------------------------
	public function email_verification($code)
	{
		$this->db->select('email, token, is_active');
		$this->db->from($this->config->item('CONFIG_DB_TBL_ADMIN'));
		$this->db->where('token', $code);
		$query = $this->db->get();
		$result = $query->result_array();
		$match = count($result);
		if ($match > 0) {
			$this->db->where('token', $code);
			$this->db->update($this->config->item('CONFIG_DB_TBL_ADMIN'), array('is_verify' => 1, 'token' => ''));
			return true;
		} else {
			return false;
			}
	}

	//============ Check User Email ============
    function check_user_mail($email)
	{
		$result = $this->db->get_where($this->config->item('CONFIG_DB_TBL_ADMIN'), array('email' => $email));

		if ($result->num_rows() > 0) {
			$result = $result->row_array();
			return $result;
		} else {
			return false;
		}
	}

    //============ Update Reset Code Function ===================
    public function update_reset_code($reset_code, $user_id)
	{
		$data = array('password_reset_code' => $reset_code);
		$this->db->where('admin_id', $user_id);
		$this->db->update($this->config->item('CONFIG_DB_TBL_ADMIN'), $data);
	}

    //============ Activation code for Password Reset Function ===================
    public function check_password_reset_code($code)
	{

		$result = $this->db->get_where($this->config->item('CONFIG_DB_TBL_ADMIN'), array('password_reset_code' => $code));
		if ($result->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
    
    //============ Reset Password ===================
    public function reset_password($id, $new_password)
	{
		$data = array(
			'password_reset_code' => '',
			'password' => $new_password
		);
		$this->db->where('password_reset_code', $id);
		$this->db->update($this->config->item('CONFIG_DB_TBL_ADMIN'), $data);
		return true;
	}

    //--------------------------------------------------------------------
	public function get_admin_detail()
	{
		$id = $this->session->userdata('admin_id');
		$query = $this->db->get_where($this->config->item('CONFIG_DB_TBL_ADMIN'), array('admin_id' => $id));
		return $result = $query->row_array();
	}

	//--------------------------------------------------------------------
	public function update_admin($data)
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

}

?>
