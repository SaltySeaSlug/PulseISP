<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:23
 */

class Profiles_components extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		// CHECK IF USER IS AUTHENTICATED
		auth_check();

		// CHECK IF USER IS ALLOWED TO ACCESS MODULE
		$this->rbac->check_module_access();

		$this->load->model('admin/profiles_components_model', 'profiles_components_model');
	}

	//-------------------------------------------------------------------------
	public function index()
	{
		if ($this->input->post('submit')) {
			$data = array(
				'username' => $this->input->post('username'),
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'email' => $this->input->post('email'),
				'mobile_no' => $this->input->post('mobile_no'),
				'updated_at' => date('Y-m-d : h:m:s'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->admin_model->update_user($data);
			if ($result) {
				$this->session->set_flashdata('success', 'Profile has been Updated Successfully!');
				redirect(base_url('admin/profile'), 'refresh');
			}
		} else {
			$data['title'] = 'Profiles and Components';
			$data['profiles'] = $this->profiles_components_model->get_all_profiles();
			$data['components'] = $this->profiles_components_model->get_all_components();

			$this->load->view('admin/includes/_header');
			$this->load->view('admin/profiles_components/list', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-------------------------------------------------------------------------
	public function profile_add()
	{
		// Check if user is allowed to access operation
		$this->rbac->check_operation_access();

		$id = $this->session->userdata('admin_id');

		if ($this->input->post('submit')) {

			$profiledata = array(
				'name' => $this->input->post('profilename')
			);

			$profile_data = $this->security->xss_clean($profiledata);
			$this->profiles_components_model->add_profile($profile_data);

			if (!empty($this->input->post('profilecomponents'))) {
				$componentdata = array(
					'profilecomponents' => $this->input->post('profilecomponents')
				);
				if (isset($componentdata['profilecomponents']) && $componentdata['profilecomponents'] != 0) {
					foreach ($componentdata['profilecomponents'] as $componentid) {
						$component_data = $this->security->xss_clean($componentid);

						$this->profiles_components_model->link_profile_component_to_profile($this->input->post('profilename'), $component_data);
					}
				}
			}
			// Activity Log
			$this->activity_model->add_to_system_log("Profile has been added successfully");

			$this->session->set_flashdata('success', 'Profile has been added successfully!');
			redirect(base_url('admin/profiles_components'));
		}
		else{
			$data['components'] = $this->profiles_components_model->get_all_components();

			$data['title'] = 'Add Profile Components';
			//$data['user'] = $this->admin_model->get_user_detail();
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/profiles_components/profile_add', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	public function component_add()
	{
		// Check if user is allowed to access operation
		$this->rbac->check_operation_access();

		$id = $this->session->userdata('admin_id');

		if ($this->input->post('submit')) {

			//echo json_encode($this->input->post());
			//return;

			$componentdata = array(
				'name' => $this->input->post('componentname')
			);

			$component_data = $this->security->xss_clean($componentdata);
			$this->profiles_components_model->add_profile_component($component_data);

			if (!empty($this->input->post('data'))) {

				$json = json_decode($this->input->post('data'), true);

				foreach ($json as $dictitem) {
					$vendor = $dictitem['Vendor'];
					$attribute = $dictitem['Attribute'];
					$operation = $dictitem['Operation'];
					$value = $dictitem['Value'];
					$target = $dictitem['Target'];

					$dictdata = array(
						'groupname' => $this->input->post('componentname'),
						'attribute' => $attribute,
						'op' => $operation,
						'value' => $value
					);
					$dict_data = $this->security->xss_clean($dictdata);

					$this->profiles_components_model->link_dictionaryitem_to_profile_component($dict_data, $target);
				}
			}
			// Activity Log
			$this->activity_model->add_to_system_log("Component has been added successfully");

			$this->session->set_flashdata('success', 'Component has been added successfully!');
			redirect(base_url('admin/profiles_components'));
		}
		else{
			$data['components'] = $this->profiles_components_model->get_all_components();

			$data['title'] = 'Add Profile Components';
			$data['vendors'] = $this->profiles_components_model->get_all_vendors();

			$this->load->view('admin/includes/_header');
			$this->load->view('admin/profiles_components/component_add', $data);
			$this->load->view('admin/includes/_footer');
		}
	}
}

?>	
