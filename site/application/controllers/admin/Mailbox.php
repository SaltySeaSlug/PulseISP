<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:23
 */

class Mailbox extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		// CHECK IF USER IS AUTHENTICATED
		auth_check();

		// CHECK IF USER IS ALLOWED TO ACCESS MODULE
		$this->rbac->check_module_access();
	}

	//---------------------------------------------------------------------------
	public function inbox()
	{

		$data['title'] = '';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/mailbox/mailbox', $data);
		$this->load->view('admin/includes/_footer');
	}

	//----------------------------------------------------------------------------
	public function compose(){

		$data['title'] = '';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/mailbox/compose', $data);
		$this->load->view('admin/includes/_footer');
	}

	//-----------------------------------------------------------------------------
	public function read_mail(){

		$data['title'] = '';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/mailbox/read-mail', $data);
		$this->load->view('admin/includes/_footer');
	}
}

?>
