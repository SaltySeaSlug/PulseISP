<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:23
 */

class Forms extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		// CHECK IF USER IS AUTHENTICATED
		auth_check();

		// CHECK IF USER IS ALLOWED TO ACCESS MODULE
		$this->rbac->check_module_access();
	}

	public function general()
	{

		$data['title'] = 'Export Database';

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/forms/general');
		$this->load->view('admin/includes/_footer');
	}

	//------------------------------------------------------------------
	public function advanced(){

		$data['title'] = 'Export Database';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/forms/advanced', $data);
		$this->load->view('admin/includes/_footer');
	}

	//------------------------------------------------------------------
	public function editors(){

		$data['title'] = 'Export Database';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/forms/editors', $data);
		$this->load->view('admin/includes/_footer');
	}

}

	?>
