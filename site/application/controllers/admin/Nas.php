<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Nas extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();

		$this->load->model('admin/Nas_model', 'nas_model');
		$this->load->model('admin/Activity_model', 'activity_model');
		$this->load->model('admin/Setting_model', 'setting_model');
		$this->load->model('admin/Ippool_model', 'ippool_model');
		$this->load->helper('data_helper');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/nas/nas_list');
		$this->load->view('admin/includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->nas_model->get_all_nas_devices();
		$data = array();

		foreach ($records['data'] as $row)
		{
			$status = empty($row['last_contact']) ? '<span class="badge badge-secondary">Never</span>' : (check_nas_status($row['id']) ? '<span class="badge badge-success">Online</span>' : '<span class="badge badge-danger" title="Last seen '. $row['last_contact'] .'">Offline</span>');
			$data[]= array(
				$row['id'],
				$row['shortname'],
				$row['nasname'],
				$row['nasidentifier'],
				//date_time($row['created_at']),	
				//'<span class="btn btn-success">'.$verify.'</span>',	
				//'<input class="tgl tgl-light tgl_checkbox" data-id="'.$row['id'].'" id="cb_'.$row['id'].'" type="checkbox" '.$status.'><label class="tgl-btn" for="cb_'.$row['id'].'"></label>',
				$status,

				'<div class="btn-group float-right">
						<a title="View" class="btn btn-sm btn-info" href="'.base_url('admin/nas/edit/'.$row['id']).'"> <i class="fad fa-eye"></i></a>
						<a title="Edit" class="btn btn-sm btn-warning" href="'.base_url('admin/nas/edit/'.$row['id']).'"> <i class="fad fa-edit"></i></a>
						<a title="Delete" class="btn btn-sm btn-danger" href='.base_url("admin/nas/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fad fa-trash-alt"></i></a>
				</div>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	function change_status()
	{   
		$this->nas_model->change_status();
	}

	public function add(){
		
		$this->rbac->check_operation_access(); // check opration permission

		$data['general_settings'] = $this->setting_model->get_general_settings();

		if($this->input->post('submit')){
			$this->form_validation->set_rules('nasname', 'Name', 'trim|required');
			$this->form_validation->set_rules('nashost', 'IP Address', 'trim|required');
			$this->form_validation->set_rules('nasidentifier', 'Identifier', 'trim|required');
			$this->form_validation->set_rules('nassecret', 'Secret', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array('errors' => validation_errors());
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/nas/add'),'refresh');
			}
			else{
				$data = array(
					'connection_type' => 'direct',
					'nasname' => $this->input->post('nashost'),
					'secret' => $this->input->post('nassecret'),
					'type' => $this->input->post('nastype'),
					'shortname' => $this->input->post('nasname'),
					'nasidentifier' => $this->input->post('nasidentifier')
				);

				$data = $this->security->xss_clean($data);
				$nasId = $this->nas_model->add_nas($data);

				if (!empty($this->input->post('ippool')) && $this->input->post('ippool') > 0) { $ippooldata = array('pool_name' => $this->input->post('ippool'));
					$ippooldata = $this->security->xss_clean($ippooldata);
					$this->ippool_model->link_pool_to_nas($nasId, $ippooldata['pool_name']);
				} else {
					$this->ippool_model->unlink_pool_to_nas($nasId);
				}

				if($nasId > 0){


					// Activity Log 
					$this->activity_model->add_to_system_log("NAS device has been added successfully");
					$this->activity_model->add_to_system_log("Freeradius restarted " . shell_exec("sudo /etc/init.d/freeradius restart 2>&1"));


					//$this->session->set_flashdata('success', shell_exec("sudo /etc/init.d/freeradius restart"));
					$this->session->set_flashdata('success', 'Nas Device has been added successfully!');
					redirect(base_url('admin/nas'));
				}
			}
		}
		else{
			$data['ippools'] = $this->ippool_model->get_all_ippools();
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/nas/nas_add', $data);
			$this->load->view('admin/includes/_footer');
		}
		
	}

	public function edit($id = 0){

		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('nasname', 'Name', 'trim|required');
			$this->form_validation->set_rules('nashost', 'IP Address', 'trim|required');
			$this->form_validation->set_rules('nasidentifier', 'Identifier', 'trim|required');
			$this->form_validation->set_rules('nassecret', 'Secret', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('admin/nas/edit/'.$id),'refresh');
			}
			else{
				$data = array(
					'connection_type' => 'direct', //$this->input->post('nasconnectiontype'),
					'nasname' => $this->input->post('nashost'),
					'secret' => $this->input->post('nassecret'),
					'type' => $this->input->post('nastype'),
					'shortname' => $this->input->post('nasname'),
					'nasidentifier' => $this->input->post('nasidentifier')
					//password_hash($this->input->post('password'), PASSWORD_BCRYPT),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->nas_model->edit_nas($data, $id);
				if($result){

					shell_exec("sudo /etc/init.d/freeradius restart 2>&1");

					// Activity Log 
					$this->activity_model->add_to_system_log("NAS device has been updated successfully");

					$this->session->set_flashdata('success', 'NAS device has been updated successfully!');
					redirect(base_url('admin/nas'));
				}
			}
		}
		else{
			$data['nas'] = $this->nas_model->get_nas_by_id($id);
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/nas/nas_edit', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	public function delete($id = 0)
	{
		$this->rbac->check_operation_access(); // check opration permission
		
		$this->db->delete('radnas', array('id' => $id));

		// Activity Log 
		$this->activity_model->add_to_system_log("NAS device has been deleted successfully");

		$this->session->set_flashdata('success', 'Use has been deleted successfully!');
		redirect(base_url('admin/nas'));
	}

}


?>
