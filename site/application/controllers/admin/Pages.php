<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:23
 */

class Pages extends MY_Controller
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
	public function invoice()
	{

		$data['title'] = '';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/pages/invoice', $data);
		$this->load->view('admin/includes/_footer');
	}

	//---------------------------------------------------------------
	public function profile(){

		$data['title'] = '';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/pages/profile', $data);
		$this->load->view('admin/includes/_footer');
	}

	//---------------------------------------------------------------
	public function login(){

		$data['title'] = '';
		$data['navbar'] = false;
		$data['sidebar'] = false;
		$data['footer'] = false;

		$this->load->view('admin/includes/_header' , $data);
		$this->load->view('admin/pages/login', $data);
		$this->load->view('admin/includes/_footer' , $data);
	}

	//---------------------------------------------------------------
	public function register(){

		$data['title'] = '';
		$data['navbar'] = false;
		$data['sidebar'] = false;
		$data['footer'] = false;

		$this->load->view('admin/includes/_header' , $data);
		$this->load->view('admin/pages/register', $data);
		$this->load->view('admin/includes/_footer' , $data);
	}

	//---------------------------------------------------------------
	public function lockscreen(){

		$data['title'] = '';
		$data['navbar'] = false;
		$data['sidebar'] = false;
		$data['footer'] = false;
		
		$this->load->view('admin/includes/_header' , $data);
		$this->load->view('admin/pages/lockscreen', $data);
		$this->load->view('admin/includes/_footer' , $data);

	}

	

	//---------------------------------------------------------------
	public function pace(){

		$data['title'] = '';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/pages/pace', $data);
		$this->load->view('admin/includes/_footer');
	}

}

?>
