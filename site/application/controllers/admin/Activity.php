<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
class Activity extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();

		$this->load->model('admin/Activity_model', 'activity_model');
	}

	public function index()
	{
		// $records = $this->activity_model->get_activity_log();
		// var_dump($records);exit();
		$data['title'] = 'Activity Log';
		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/activity/activity-list', $data);
		$this->load->view('admin/includes/_footer');
	}

	public function datatable_json()
	{
		$records['data'] = $this->activity_model->get_audit_trail();

		$data = array();
		foreach ($records['data']  as $row)
		{  
			$data[]= array(
				$row['id'],
				$row['user_id'],
				$row['admin_id'],
				$row['name'],
				$row['event'],
				$row['table_name'],
				$row['old_values'],
				$row['new_values'],
				$row['url'],
				$row['ip_address'],
				$row['user_agent'],
				date('F d, Y H:i',strtotime($row['created_at']))
			);
		}
		$records['data'] = $data;
		echo json_encode($records);
	}
}

?>	
