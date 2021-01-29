<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Dashboard extends My_Controller {



	public function __construct(){

		parent::__construct();

		auth_check(); // check login auth

		$this->rbac->check_module_access();

		if($this->uri->segment(3) != '')
		$this->rbac->check_operation_access();

		$this->load->model('admin/dashboard_model', 'dashboard_model');

	}

	//--------------------------------------------------------------------------

	public function index(){


		$data['all_users'] = $this->dashboard_model->get_all_users();

		$data['active_users'] = $this->dashboard_model->get_active_users();

		$data['deactive_users'] = $this->dashboard_model->get_deactive_users();

		$data['title'] = 'Dashboard';



		$this->load->view('admin/includes/_header', $data);

    	$this->load->view('admin/dashboard/index', $data);

    	$this->load->view('admin/includes/_footer');

	}

	//--------------------------------------------------------------------------

	public function index_1(){

		$data['title'] = 'Dashboard';

		$data['all_ips'] = $this->dashboard_model->get_all_ips();
		$data['free_ips'] = $this->dashboard_model->get_free_ips();
		$data['active_user_sessions'] = $this->dashboard_model->get_active_user_sessions();
		$data['total_users'] = $this->dashboard_model->get_all_users();
		$data['total_alerts'] = $this->dashboard_model->get_all_alerts();
		$data['statUsageToday']['upload'] = 0;
		$data['statUsageToday']['download'] = 0;

		//echo json_encode($this->dashboard_model->top('2021-01-01 00:00:00', '2021-01-31 00:00:00', 10));

		$this->load->view('admin/includes/_header', $data);

    	$this->load->view('admin/dashboard/general', $data);

    	$this->load->view('admin/includes/_footer');
	}



	//--------------------------------------------------------------------------

	public function index_2(){

		$data['title'] = 'Dashboard';


		$this->load->view('admin/includes/_header');

    	$this->load->view('admin/dashboard/index2');

    	$this->load->view('admin/includes/_footer');

	}



	//--------------------------------------------------------------------------

	public function index_3(){

		$data['title'] = 'Dashboard';

		$this->load->view('admin/includes/_header');

    	$this->load->view('admin/dashboard/index3');

    	$this->load->view('admin/includes/_footer');

	}

}
?>	
