<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:23
 */

class General_settings extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		// CHECK IF USER IS AUTHENTICATED
		auth_check();

		// CHECK IF USER IS ALLOWED TO ACCESS MODULE
		$this->rbac->check_module_access();
	}

	//-------------------------------------------------------------------------
	// General Setting View
	public function index()
	{
		$data['title'] = 'General Setting';
		$data['general_settings'] = $this->setting_model->get_general_settings();
		$data['languages'] = $this->setting_model->get_all_languages();

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/general_settings/setting', $data);
		$this->load->view('admin/includes/_footer');
	}

	//-------------------------------------------------------------------------
	public function add()
	{
		// Check if user is allowed to access operation
		$this->rbac->check_operation_access();

		$data = array(
			'application_name' => $this->input->post('application_name'),
			'timezone' => $this->input->post('timezone'),
			'currency' => $this->input->post('currency'),
			'default_language' => $this->input->post('language'),
			'copyright' => $this->input->post('copyright'),
			'email_from' => $this->input->post('email_from'),
			'smtp_host' => $this->input->post('smtp_host'),
			'smtp_port' => $this->input->post('smtp_port'),
			'smtp_user' => $this->input->post('smtp_user'),
			'smtp_pass' => $this->input->post('smtp_pass'),
			'facebook_link' => $this->input->post('facebook_link'),
			'twitter_link' => $this->input->post('twitter_link'),
			'google_link' => $this->input->post('google_link'),
			'youtube_link' => $this->input->post('youtube_link'),
			'linkedin_link' => $this->input->post('linkedin_link'),
			'instagram_link' => $this->input->post('instagram_link'),
			'company_name' => $this->input->post('company_name'),
			'address_line_1' => $this->input->post('address_line_1'),
			'address_line_2' => $this->input->post('address_line_2'),
			'email_address' => $this->input->post('email_address'),
			'contact_number' => $this->input->post('contact_number'),
			'terms' => $this->input->post('terms'),
			'recaptcha_secret_key' => $this->input->post('recaptcha_secret_key'),
			'recaptcha_site_key' => $this->input->post('recaptcha_site_key'),
			'recaptcha_lang' => $this->input->post('recaptcha_lang'),
			'created_date' => date('Y-m-d : h:m:s'),
			'updated_date' => date('Y-m-d : h:m:s'),
			'use_google_font' => $this->input->post('use_google_font'),
			'google_api_key' => $this->input->post('google_maps_api'),
			'google_places_is_active' => (bool)$this->input->post('cb_google_places_status'),
			'radius_secret' => $this->input->post('radius_secret'),
			'realm_suffix' => $this->input->post('realm_suffix')
		);

		$old_logo = $this->input->post('old_logo');
		$old_favicon = $this->input->post('old_favicon');

		$path="assets/img/";

		if(!empty($_FILES['logo']['name']))
		{
			$this->functions->delete_file($old_logo);

			$result = $this->functions->file_insert($path, 'logo', 'image', '9097152');
			if($result['status'] == 1){
				$data['logo'] = $path.$result['msg'];
			}
			else{
				$this->session->set_flashdata('error', $result['msg']);
				redirect(base_url('admin/general_settings'), 'refresh');
			}
		}

		// favicon
		if(!empty($_FILES['favicon']['name']))
		{
			$this->functions->delete_file($old_favicon);

			$result = $this->functions->file_insert($path, 'favicon', 'image', '197152');
			if($result['status'] == 1){
				$data['favicon'] = $path.$result['msg'];
			}
			else{
				$this->session->set_flashdata('error', $result['msg']);
				redirect(base_url('admin/general_settings'), 'refresh');
			}
		}

		$data = $this->security->xss_clean($data);
		$result = $this->setting_model->update_general_setting($data);
		if($result){
			$this->session->set_flashdata('success', 'Setting has been changed Successfully!');
			redirect(base_url('admin/general_settings'), 'refresh');
		}
	}

		/*--------------------------
	   Email Template Settings
	--------------------------*/

	// ------------------------------------------------------------
	public function email_templates()
	{
		// Check if user is allowed to access operation
		//$this->rbac->check_operation_access();

		if ($this->input->post()) {
			$this->form_validation->set_rules('subject', 'Email Subject', 'trim|required');
			$this->form_validation->set_rules('content', 'Email Body', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			} else {

				$id = $this->input->post('id');
				
				$data = array(
					'subject' => $this->input->post('subject'),
					'body' => $this->input->post('content'),
					'last_update' => date('Y-m-d H:i:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->setting_model->update_email_template($data, $id);
				if($result){
					echo "true";
				}
			}
		}
		else
		{
			$data['title'] = '';
			$data['templates'] = $this->setting_model->get_email_templates();

			$this->load->view('admin/includes/_header');
			$this->load->view('admin/general_settings/email_templates/templates_list', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	// ------------------------------------------------------------
	// Get Email Template & Related variables via Ajax by ID
	public function get_email_template_content_by_id()
	{
		$id = $this->input->post('template_id');

		$data['template'] = $this->setting_model->get_email_template_content_by_id($id);
		
		$variables = $this->setting_model->get_email_template_variables_by_id($id);

		$data['variables'] = implode(',',array_column($variables, 'variable_name'));

		echo json_encode($data);
	}

	//---------------------------------------------------------------
    //
    public function email_preview()
    {
        if($this->input->post('content'))
        {
            $data['content'] = $this->input->post('content');
            $data['head'] = $this->input->post('head');
            $data['title'] = 'Send Email to Subscribers';
            echo $this->load->view('admin/general_settings/email_templates/email_preview', $data,true);
        }
    }

    public function system_status(){
		$data['title'] = '';
		$data['general_status'] = $this->setting_model->systemInfo();
		$data['system_status'] = $this->setting_model->systemLoad();

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/general_settings/system_status', $data);
		$this->load->view('admin/includes/_footer');

	}
}

?>	
