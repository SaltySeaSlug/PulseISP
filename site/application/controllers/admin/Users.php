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
			if ($this->rbac->check_operation_permission('view')) { $action_view = '<a title="View" class="btn-right text-primary pr-1" href="'.base_url('admin/users/edit/'.$row['id']).'"> <i class="fad fa-eye"></i></a>';}
			if ($this->rbac->check_operation_permission('edit')) { $action_edit = '<a title="Edit" class="btn-right text-warning pr-1" href="'.base_url('admin/users/edit/'.$row['id']).'"> <i class="fad fa-edit"></i></a>';}
			if ($this->rbac->check_operation_permission('delete')) {$action_delete = '<a title="Delete" class="btn-right text-danger pr-1" href='.base_url("admin/users/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fad fa-trash-alt"></i></a>';}



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

 				'<div class="text-right">'.$action_view.''.$action_edit.''.$action_delete.'</div>'
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
		
		$this->rbac->check_operation_access(); // check opration permission

		$data['general_settings'] = $this->setting_model->get_general_settings();

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
				$data = array(
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'),
					'email' => $this->input->post('email'),
					'mobile_no' => $this->input->post('mobile_no'),
					'address' => $this->input->post('address'),
					'account_code' => $this->input->post('profile-input-account-code'),
					'created_at' => date('Y-m-d : h:m:s'),
					//'updated_at' => date('Y-m-d : h:m:s'),
				);
				$data_ppp = array(
					'username' => $this->input->post('username'),
					'password' =>  $this->input->post('password'),
					'passwordtype' => $this->input->post('passwordtype'),
					'profileid' => $this->input->post('profileid'),
					'ipaddresstype' => $this->input->post('ipaddresstype'),
					'dhcppool' => $this->input->post('dhcppool'),
					'staticip' => $this->input->post('staticip'),
					'start_date' => date('Y-m-d H:i:s')
				);

				$data = $this->security->xss_clean($data);
				$userid = $this->user_model->add_user_return_id($data);
				$pppid = $this->ppp_model->add_ppp_account_return_id($userid, $data_ppp);

				if($pppid > 0) {
					// Activity Log
					$this->activity_model->add_to_log(1, "PPP has been added successfully");
					$this->session->set_flashdata('success', 'PPP has been added successfully!');
				}
				
				if($userid > 0) {
					$this->activity_model->add_to_log(1, "User has been added successfully");

					$this->session->set_flashdata('success', 'User has been added successfully!');
					redirect(base_url('admin/users'));
				}
			}
		}
		else{
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/users/user_add');
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
