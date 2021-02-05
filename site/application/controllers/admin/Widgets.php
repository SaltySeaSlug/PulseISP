<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widgets extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
	}

	//-------------------------------------------------------------------------
	public function index(){

		$data['title'] = 'Widgets';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/widgets/widgets', $data);
		$this->load->view('admin/includes/_footer');
	}

}

	?>
