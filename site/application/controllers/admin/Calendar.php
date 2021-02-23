<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:23
 */

class Calendar extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		// CHECK IF USER IS AUTHENTICATED
		auth_check();

		// CHECK IF USER IS ALLOWED TO ACCESS MODULE
		$this->rbac->check_module_access();
	}

	public function index()
	{

		$data['title'] = 'Calendar';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/calendar/calendar', $data);
		$this->load->view('admin/includes/_footer');
	}
}

?>	
