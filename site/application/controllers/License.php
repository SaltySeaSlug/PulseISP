<?php defined('BASEPATH') or exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/13, 11:49
 */

class License extends MY_Controller
{
	public function __construct()
	{
		header('Content-type: application/json');

		parent::__construct();
		// Check if user is authenticated
		auth_check();
		// Check if user is allowed to access module
		$this->rbac->check_module_access();

		$this->load->model('License_model', 'license_model');
	}


}
