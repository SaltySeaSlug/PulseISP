<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:22
 */

class MY_Controller extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();

			// LOAD MODULES, LIBRARIES AND HELPERS
			$this->load->model('admin/activity_model', 'activity_model');
			$this->load->model('admin/setting_model', 'setting_model');
			$this->load->model('admin/realm_model', 'realm_model');
			$this->load->library('gravatar');

			// GENERAL SETTINGS
			$global_data['general_settings'] = $this->setting_model->get_general_settings();
			$this->general_settings = $global_data['general_settings'];

			// SET TIMEZONE
			date_default_timezone_set($this->general_settings['timezone']);

			// RECAPTCHA STATUS
			$global_data['recaptcha_status'] = true;
			if (empty($this->general_settings['recaptcha_site_key']) || empty($this->general_settings['recaptcha_secret_key'])) {
				$global_data['recaptcha_status'] = false;
			}
			$this->recaptcha_status = $global_data['recaptcha_status'];

			// LANGUAGE
			$site_language = ($this->general_settings['default_language'] != "") ? $this->general_settings['default_language'] : "english";
			$language = ($this->session->userdata('site_lang') != "") ? $this->session->userdata('site_lang') : $site_language;
			$language = strtolower(get_lang_name_by_id($language));

			$this->config->set_item('language', $language);
			$this->lang->load(array('site'), $language);
		}

		//verify recaptcha
		public function recaptcha_verify_request()
		{
			if (!$this->recaptcha_status) {
				return true;
			}

			$this->load->library('recaptcha');
			$recaptcha = $this->input->post('g-recaptcha-response');
			if (!empty($recaptcha)) {
				$response = $this->recaptcha->verifyResponse($recaptcha);
				if (isset($response['success']) && $response['success'] === true) {
					return true;
				}
			}
			return false;
		}
	}
?>



