<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 18:05
 */

class Widgets extends MY_Controller
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
	public function index()
	{

		$data['title'] = 'Widgets';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/widgets/widgets', $data);
		$this->load->view('admin/includes/_footer');
	}

}

?>
