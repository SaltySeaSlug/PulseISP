<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Ip_pool extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();

		$this->load->model('admin/Ippool_model', 'ippool_model');
		$this->load->model('admin/Activity_model', 'activity_model');
		$this->load->model('admin/Setting_model', 'setting_model');
		$this->load->helper('data_helper');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/ippool/ippool_list');
		$this->load->view('admin/includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->ippool_model->get_all_ips();
		$data = array();

		foreach ($records['data'] as $row)
		{
			$status = empty($row['username']) ? '<span class="badge badge-danger">Unallocated</span>' : '<span class="badge badge-success">Allocated</span>';
			$data[]= array(
				$row['id'],
				$row['pool_name'],
				$row['framedipaddress'],
				$status,
				$row['username'],
				//date_time($row['created_at']),	
				//'<span class="btn btn-success">'.$verify.'</span>',	
				//'<input class="tgl tgl-light tgl_checkbox" data-id="'.$row['id'].'" id="cb_'.$row['id'].'" type="checkbox" '.$status.'><label class="tgl-btn" for="cb_'.$row['id'].'"></label>',

				//'<div class="text-right"><a title="View" class="btn-right text-primary pr-1" href="'.base_url('admin/nas/edit/'.$row['id']).'"> <i class="fad fa-eye"></i></a>
				//<a title="Edit" class="btn-right text-warning pr-1" href="'.base_url('admin/nas/edit/'.$row['id']).'"> <i class="fad fa-edit"></i></a>
				//<a title="Delete" class="btn-right text-danger pr-1" href='.base_url("admin/nas/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fad fa-trash-alt"></i></a></div>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	function change_status()
	{   
		$this->nas_model->change_status();
	}
	function array_xor ($array_a, $array_b)
	{
		if (isset($array_a) || isset($array_b)) return array();

		$union_array = array_merge($array_a, $array_b);

		$intersect_array = array_intersect($array_a, $array_b);
		return array_diff($union_array, $intersect_array);
	}
	public function add()
	{
		$this->rbac->check_operation_access(); // check opration permission

		$data['general_settings'] = $this->setting_model->get_general_settings();

		if ($this->input->post('submit')) {
			$this->form_validation->set_rules('iprange', 'IP Range', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array('errors' => validation_errors());
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/ippool/ippool_add'), 'refresh');
			} else {
				$sql = array();
				$iprange = array();

				if (checkIfIPRange($this->input->post('iprange'))) {

				} elseif (checkIfCIDR($this->input->post('iprange'))) {

					$ip = preg_split("#/#", $this->input->post('iprange'));
					$sub = new IPv4\SubnetCalculator($ip[0], $ip[1]);
					$bool = !empty($this->input->post('addunaddressableips'));

					if ($bool) {
						//$pool = $this->ippool_model->get_ips_by_poolname($this->input->post('poolname'));
						//$address_rage = $sub->getIPAddressRange();
						//foreach (ip_range($address_rage[0], $address_rage[1]) as $ip_address) {	$iprange[] = $ip_address; }

						//$uniqueRange = $this->array_xor($iprange, $pool);
						foreach ($iprange as $ip_address) {
							$sql[] = array('pool_name' => $this->input->post('poolname'), 'framedipaddress' => $ip_address);
						}

						//$excluded = IPTools\Network::parse($this->input->post('iprange'));
						//foreach ($pool as $ip) {
						//		$excluded->exclude(new \IPTools\IP($ip));
						//}

						//echo json_encode($pool);
						//echo json_encode($iprange);
						//echo json_encode($uniqueRange);
						//echo json_encode($sql);
						//echo json_encode($excluded);
					}
					else {
						//$pool = $this->ippool_model->get_ips_by_poolname($this->input->post('poolname'));
						foreach (ip_range($sub->getMinHost(), $sub->getMaxHost()) as $ip_address) {	$iprange[] = $ip_address; }

						//$uniqueRange = $this->array_xor($iprange, $pool);
						foreach ($iprange as $ip_address) {
							$sql[] = array('pool_name' => $this->input->post('poolname'), 'framedipaddress' => $ip_address);
						}

						//$excluded = IPTools\Network::parse($this->input->post('iprange'));
						//foreach ($pool as $ip) {
						//	$excluded->exclude(new \IPTools\IP($ip));
						//}

						//echo json_encode($pool);
						//echo json_encode($iprange);
						//echo json_encode($uniqueRange);
						//echo json_encode($sql);
						//echo json_encode($excluded);
					}
				}

				$data = $this->security->xss_clean($sql);
				$result = $this->ippool_model->add_bulk_ips($data);

				if ($result) {
					// Activity Log
					$this->activity_model->add_to_system_log("IP pool has been added successfully");

					$this->session->set_flashdata('success', 'IP pool has been added successfully!');
					redirect(base_url('admin/ip_pool'));
				}
			}
		} else {
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/ippool/ippool_add', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	public function edit($id = 0){

		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('nasname', 'Name', 'trim|required');
			$this->form_validation->set_rules('nashost', 'IP Address', 'trim|required');
			$this->form_validation->set_rules('nasidentifier', 'Identifier', 'trim|required');
			$this->form_validation->set_rules('nassecret', 'Secret', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('admin/nas/edit/'.$id),'refresh');
			}
			else{
				$data = array(
					'connection_type' => 'direct', //$this->input->post('nasconnectiontype'),
					'nasname' => $this->input->post('nashost'),
					'secret' => $this->input->post('nassecret'),
					'type' => $this->input->post('nastype'),
					'shortname' => $this->input->post('nasname'),
					'nasidentifier' => $this->input->post('nasidentifier')
					//password_hash($this->input->post('password'), PASSWORD_BCRYPT),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->nas_model->edit_nas($data, $id);
				if($result){

					shell_exec("sudo /etc/init.d/freeradius restart 2>&1");

					// Activity Log 
					$this->activity_model->add_to_system_log("IP pool has been updated successfully");

					$this->session->set_flashdata('success', 'IP pool has been updated successfully!');
					redirect(base_url('admin/nas'));
				}
			}
		}
		else{
			$data['nas'] = $this->nas_model->get_nas_by_id($id);
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/nas/nas_edit', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	public function delete($id = 0)
	{
		$this->rbac->check_operation_access(); // check opration permission
		
		$this->db->delete('radnas', array('id' => $id));

		// Activity Log 
		$this->activity_model->add_to_system_log("IP pool has been deleted successfully");

		$this->session->set_flashdata('success', 'Use has been deleted successfully!');
		redirect(base_url('admin/nas'));
	}

}


?>
