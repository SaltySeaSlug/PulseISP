<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:23
 */

class Ui extends MY_Controller
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
	public function buttons()
	{

		$data['title'] = '';	

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/ui/buttons');
		$this->load->view('admin/includes/_footer');
	}

	//-------------------------------------------------------------------------
	public function general(){

		$data['title'] = '';	

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/ui/general');
		$this->load->view('admin/includes/_footer');
	}

	//-------------------------------------------------------------------------
	public function icons(){

		$data['title'] = '';	

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/ui/icons');
		$this->load->view('admin/includes/_footer');
	}


}
