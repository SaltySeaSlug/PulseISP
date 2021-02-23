<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */


####
#0 0 0 0 0 /usr/bin/php /var/www/html/index.php cron updateAge
####
class Cron extends MY_Controller
{
	/**
	 * This is default constructor of the class
	 */
	public function __construct()
	{
		parent::__construct();
		//auth_check(); // check login auth
		//$this->rbac->check_module_access();

		//$this->load->library('input');
		$this->load->model('Cron_model', 'cron_model');
	}

	/**
	 * This function is used to update the age of users automatically
	 * This function is called by cron job once in a day at midnight 00:00
	 */
	public function updateAge()
	{
		// is_cli_request() is provided by default input library of codeigniter
		if($this->input->is_cli_request())
		{
			echo "THIS TASK WAS CALLED SUCCESSFULLY".PHP_EOL;
		}
		else
		{
			echo "You dont have access";
		}
	}

	public function message($to = 'World')
	{
		if ($this->input->is_cli_request()) {
			$this->cron_model->update_last_contact();
			echo "Hello {$to}!" . PHP_EOL;
		} else {
			echo "You dont have access";
		}
	}

	public function _check()
	{
		//if ($this->input->is_cli_request())
		//{
		$query = $this->db->where(["session_auto_close" => 1])->from("radnas")->row_array();
		if ($query) {
			foreach ($query as $item) {
				$nasname = $item->nasname;
				$close_after = $item->session_dead_time;
				$this->db->query("UPDATE radacct set acctstoptime=ADDDATE(acctstarttime, INTERVAL acctsessiontime SECOND), acctterminatecause='Clear-Stale-Session' where nasipaddress='$nasname' AND acctstoptime is NULL AND ((UNIX_TIMESTAMP(now()) - (UNIX_TIMESTAMP(acctstarttime)+acctsessiontime)))");
				$nasidentifier = $item->nasidentifier;
				$this->db->query("UPDATE radacct set acctstoptime=ADDDATE(acctstarttime, INTERVAL acctsessiontime SECOND), acctterminatecause='Clear-Stale-Session' where nasidentifier='$nasidentifier' AND acctstoptime is NULL AND ((UNIX_TIMESTAMP(now()) - (UNIX_TIMESTAMP(acctstarttime)+acctsessiontime)))");
			}
		} else {

		}
		//}
		//else
		//{

		//}
	}
}
?>
