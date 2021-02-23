<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:23
 */

class Tables extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		// CHECK IF USER IS AUTHENTICATED
		auth_check();

		// CHECK IF USER IS ALLOWED TO ACCESS MODULE
		$this->rbac->check_module_access();
	}

	//----------------------------------------------------------------
	public function simple()
	{

		$data['title'] = 'Simple Table';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/tables/simple', $data);
		$this->load->view('admin/includes/_footer');
	}

	//------------------------------------------------------------------
	public function data(){

		$data['title'] = 'Datatable';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/tables/data', $data);
		$this->load->view('admin/includes/_footer');
	}

}

	?>
