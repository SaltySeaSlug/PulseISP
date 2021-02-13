<?php defined('BASEPATH') or exit('No direct script access allowed');

class License extends MY_Controller
{
	public function __construct()
	{
		header('Content-type: application/json');

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();

		$this->load->model('License_model', 'license_model');
	}


}
