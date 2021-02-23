<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

class Join_model extends CI_Model{
	
		public function get_all_serverside_payments()
	    {
			$this->db->select('
	    		' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.id,
				' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.invoice_no,
				' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.grand_total,
				' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.currency,
				' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.created_date,
				' . $this->config->item('CONFIG_DB_TBL_USER') . '.username as client_name,
				' . $this->config->item('CONFIG_DB_TBL_USER') . '.email as client_email,
				' . $this->config->item('CONFIG_DB_TBL_USER') . '.mobile_no as client_mobile_no
	    	');
			$this->db->join($this->config->item('CONFIG_DB_TBL_USER'), $this->config->item('CONFIG_DB_TBL_USER') . '.id = ' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.user_id', 'left');
			return $this->db->get($this->config->item('CONFIG_DB_TBL_PAYMENT'))->result_array();
		}


	    public function get_user_payment_details(){
	    	$this->db->select('
	    			' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.id,
	    			' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.invoice_no,
	    			' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.payment_status,
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.grand_total,
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.currency,
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.due_date,
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.created_date,
					' . $this->config->item('CONFIG_DB_TBL_USER') . '.username as client_name,
					' . $this->config->item('CONFIG_DB_TBL_USER') . '.firstname,
					' . $this->config->item('CONFIG_DB_TBL_USER') . '.lastname,
					' . $this->config->item('CONFIG_DB_TBL_USER') . '.email as client_email,
					' . $this->config->item('CONFIG_DB_TBL_USER') . '.mobile_no as client_mobile_no,
					' . $this->config->item('CONFIG_DB_TBL_USER') . '.address as client_address,'
			);
			$this->db->from($this->config->item('CONFIG_DB_TBL_PAYMENT'));
			$this->db->join($this->config->item('CONFIG_DB_TBL_USER'), $this->config->item('CONFIG_DB_TBL_USER') . '.id = ' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.user_id ', 'left');
			$query = $this->db->get();
			return $query->result_array();
		}

	}

?>

