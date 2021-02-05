<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();

		$this->load->model('admin/user_model', 'user_model');
		$this->load->model('admin/Activity_model', 'activity_model');
		$this->load->model('admin/Setting_model', 'setting_model');
		$this->load->model('admin/PPP_model', 'ppp_model');
		$this->load->model('admin/Profiles_components_model', 'profiles_components_model');
		$this->load->model('admin/Ippool_model', 'ippool_model');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/users/user_list');
		$this->load->view('admin/includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->user_model->get_all_users();
		$data = array();

		foreach ($records['data']   as $row)
		{
			if ($this->rbac->check_operation_permission('view')) { $action_view = '<a title="View" class="btn btn-sm btn-info" href="'.base_url('admin/users/edit/'.$row['id']).'"> <i class="fad fa-eye"></i></a>';}
			if ($this->rbac->check_operation_permission('edit')) { $action_edit = '<a title="Edit" class="btn btn-sm btn-warning" href="'.base_url('admin/users/edit/'.$row['id']).'"> <i class="fad fa-edit"></i></a>';}
			if ($this->rbac->check_operation_permission('delete')) {$action_delete = '<a title="Delete" class="btn btn-sm btn-danger" href='.base_url("admin/users/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fad fa-trash"></i></a>';}



			$status = ($row['is_active'] == 1)? 'checked': '';
			$verify = ($row['is_verify'] == 1)? 'Verified': 'Pending';
			$data[]= array(
				$row['id'],
				$row['username'],
				$row['email'],
				$row['mobile_no'],
				date_time($row['created_at']),	
				'<span class="badge badge-success">'.$verify.'</span>',
				'<input class="tgl tgl-light tgl_checkbox" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox"  
				'.$status.'><label class="tgl-btn" for="cb_'.$row['id'].'"></label>',

 				'<div class="btn-group float-right">'.$action_view.''.$action_edit.''.$action_delete.'</div>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	function change_status()
	{   
		$this->user_model->change_status();
	}

	public function add(){
		
		$this->rbac->check_operation_access(); // check operation permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			$this->form_validation->set_rules('mobile_no', 'Number', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/users/add'),'refresh');
			}
			else{

				$userData = array(
					'id_number' => $this->input->post('profile-input-id-number'),
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'),
					'email' => $this->input->post('email'),
					'mobile_no' => $this->input->post('mobile_no'),
					'physical_address' => $this->input->post('physical_address'),
					'gps_coordinates' => $this->input->post('gps_coordinates'),
					'account_code' => $this->input->post('profile-input-account-code'),
					'created_at' => date('Y-m-d : h:m:s')
				);
				$accountData = array(
					'username' => $this->input->post('username'),
					'password' => $this->input->post('password'),
				);
				$radReplyData = array(

				);
				$radCheckData = array(
					'username' => $this->input->post('username'),
					'attribute' => 'Cleartext-Password',
					'value' => $this->input->post('password'),
					'op' => ':='
					//'passwordtype' => $this->input->post('passwordtype')
				);

				if ($this->input->post('summary-input-type') == 1) {
					$userData[] = array(
						'company-name' => $this->input->post('company-name'),
						'company-registration' => $this->input->post('company-registration'),
						'company-vat-number' => $this->input->post('company-vat-number')
					);
				}
				else {}

				if ($this->input->post('cb_data_account') == true) {
					if ($this->input->post('profileid') != -1) {
						$accountData[] = array(
							'profileid' => $this->input->post('profileid')
						);
					}
					else {}

					if ($this->input->post('ipaddresstype') == 'static') {
						$accountData[] = array(
							'staticip' => $this->input->post('staticip')
						);
						$radReplyData[] = array(
							'username' => $this->input->post('username'),
							'attribute' => 'Framed-IP-Address',
							'value' => $this->input->post('staticip'),
							'op' => ':='
						);
					}
					else {$radReplyData[] = array(
						'username' => $this->input->post('username'),
						'attribute' => 'Pool-Name',
						'value' => 'GET_FIRST_AVAILABLE_POOL_NAME',
						'op' => ':='
					);}
				}
				else {}

				// Bool (allow portal login) *pending
				// Data Portal (username) *pending
				// Data portal (password) *pending



				$userData = $this->security->xss_clean($userData);
				$accountData = $this->security->xss_clean($accountData);
				$radReplyData = $this->security->xss_clean($radReplyData);
				$radCheckData = $this->security->xss_clean($radCheckData);

				// Add User and return ID (ci_users)
				$userId = $this->user_model->add_user1($userData, true);
				// Add Data Account and return ID (data_accounts)
				$dataAccountId = $this->ppp_model->add_data_account($accountData, true);
				// Link Data Account to User (link_users_data_accounts)
				$this->ppp_model->link_data_account_to_user($userId, $dataAccountId);
				//(radcheck)(radreply)
				$this->ppp_model->add_attributes_to_radreply($radReplyData);
				$this->ppp_model->add_attributes_to_radcheck($radCheckData);



				//$userid = $this->user_model->add_user_return_id($data);
				//$pppid = $this->ppp_model->add_ppp_account_return_id($userid, $data_ppp);

				/*if($pppid > 0) {
					// Activity Log
					$this->activity_model->add_to_log(1, "PPP has been added successfully");
					$this->session->set_flashdata('success', 'PPP has been added successfully!');
				}
				
				if($userid > 0) {
					$this->activity_model->add_to_log(1, "User has been added successfully");

					$this->session->set_flashdata('success', 'User has been added successfully!');
					redirect(base_url('admin/users'));
				}*/
			}
		}
		else{
			$data['general_settings'] = $this->setting_model->get_general_settings();

			$data['profiles'] = $this->profiles_components_model->get_all_profiles();
			$data['ipAddresses'] = $this->ippool_model->get_all_unallocated_ips();
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/users/user_add', $data);
			$this->load->view('admin/includes/_footer');
		}
		
	}

	public function edit($id = 0){

		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('firstname', 'Username', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			$this->form_validation->set_rules('mobile_no', 'Number', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('admin/users/user_edit/'.$id),'refresh');
			}
			else{
				$data = array(
					'username' => $this->input->post('username'),
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'),
					'email' => $this->input->post('email'),
					'mobile_no' => $this->input->post('mobile_no'),
					'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
					'is_active' => $this->input->post('status'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->user_model->edit_user($data, $id);
				if($result){
					// Activity Log
					$this->activity_model->add_to_log(2, "User has been updated successfully");

					$this->session->set_flashdata('success', 'User has been updated successfully!');
					redirect(base_url('admin/users'));
				}
			}
		}
		else{
			$data['user'] = $this->user_model->get_user_by_id($id);
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/users/user_edit', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	public function delete($id = 0)
	{
		$this->rbac->check_operation_access(); // check opration permission
		
		$this->db->delete('ci_users', array('id' => $id));

		// Activity Log
		$this->activity_model->add_to_log(3, "User has been deleted successfully");

		$this->session->set_flashdata('success', 'Use has been deleted successfully!');
		redirect(base_url('admin/users'));
	}

}


?>
