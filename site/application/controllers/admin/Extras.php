<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:23
 */

class Extras extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		// CHECK IF USER IS AUTHENTICATED
		auth_check();

		// CHECK IF USER IS ALLOWED TO ACCESS MODULE
		$this->rbac->check_module_access();
	}

	//---------------------------------------------------------------
	public function error404()
	{

		$data['title'] = '';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/pages/404', $data);
		$this->load->view('admin/includes/_footer');
	}

	//---------------------------------------------------------------
	public function error500(){

		$data['title'] = '';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/pages/500', $data);
		$this->load->view('admin/includes/_footer');
	}

	//---------------------------------------------------------------
	public function blank(){

		$data['title'] = '';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/pages/blank', $data);
		$this->load->view('admin/includes/_footer');
	}

	//---------------------------------------------------------------
	public function starter(){

		$data['title'] = '';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/pages/starter', $data);
		$this->load->view('admin/includes/_footer');
	}

}

?>
