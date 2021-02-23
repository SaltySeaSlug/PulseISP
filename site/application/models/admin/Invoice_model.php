<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

class Invoice_model extends CI_Model{

		//---------------------------------------------------
		// Get Customer detial by ID
		public function customer_detail($id){
			$query = $this->db->get_where($this->config->item('CONFIG_DB_TBL_USER'), array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Insert New Invoice
		public function add_invoice($data)
		{
			return $this->db->insert($this->config->item('CONFIG_DB_TBL_PAYMENT'), $data);
		}

		//---------------------------------------------------
		// Insert New Invoice
		public function add_company($data)
		{
			$this->db->insert($this->config->item('CONFIG_DB_TBL_COMPANY'), $data);
			return $this->db->insert_id();
		}

		//---------------------------------------------------
		// Get Add Invoices
		public function get_all_invoices(){
			$this->db->select('
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.id,
	    			' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.invoice_no,
	    			' . $this->config->item('CONFIG_DB_TBL_USER') . '.username as client_name,
	    			' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.payment_status,
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.grand_total,
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.currency,
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.due_date
					'
			);
			$this->db->from($this->config->item('CONFIG_DB_TBL_PAYMENT'));
			$this->db->join($this->config->item('CONFIG_DB_TBL_USER'), $this->config->item('CONFIG_DB_TBL_USER') . '.id = ' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.user_id ', 'Left');
			$query = $this->db->get();
			return $query->result_array();
		}

		//---------------------------------------------------
		// Get Customers List for Invoice
		public function get_customer_list()
		{
			$this->db->select('id, UPPER(CONCAT(firstname, " " ,lastname)) as username');
			$this->db->from($this->config->item('CONFIG_DB_TBL_USER'));
			return $this->db->get()->result_array();
		}


		//---------------------------------------------------
		// Get Invoice Detil by ID
		public function get_invoice_by_id($id){

			$this->db->select('
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.id,
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.user_id as client_id,
	    			' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.invoice_no,
	    			' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.items_detail,
	    			' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.payment_status,
	    			' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.sub_total,
	    			' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.total_tax,
	    			' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.discount,
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.grand_total,
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.currency,
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.client_note,
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.termsncondition,
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.due_date,
					' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.created_date,
					' . $this->config->item('CONFIG_DB_TBL_USER') . '.username as client_name,
					' . $this->config->item('CONFIG_DB_TBL_USER') . '.firstname,
					' . $this->config->item('CONFIG_DB_TBL_USER') . '.lastname,
					' . $this->config->item('CONFIG_DB_TBL_USER') . '.email as client_email,
					' . $this->config->item('CONFIG_DB_TBL_USER') . '.mobile_no as client_mobile_no,
					' . $this->config->item('CONFIG_DB_TBL_USER') . '.address as client_address,
					' . $this->config->item('CONFIG_DB_TBL_COMPANY') . '.id as company_id,
					' . $this->config->item('CONFIG_DB_TBL_COMPANY') . '.name as company_name,
					' . $this->config->item('CONFIG_DB_TBL_COMPANY') . '.email as company_email,
					' . $this->config->item('CONFIG_DB_TBL_COMPANY') . '.address1 as company_address1,
					' . $this->config->item('CONFIG_DB_TBL_COMPANY') . '.address2 as company_address2,
					' . $this->config->item('CONFIG_DB_TBL_COMPANY') . '.mobile_no as company_mobile_no,
					'
			);
			$this->db->from($this->config->item('CONFIG_DB_TBL_PAYMENT'));
			$this->db->join($this->config->item('CONFIG_DB_TBL_USER'), $this->config->item('CONFIG_DB_TBL_USER') . '.id = ' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.user_id ', 'Left');
			$this->db->join($this->config->item('CONFIG_DB_TBL_COMPANY'), $this->config->item('CONFIG_DB_TBL_COMPANY') . '.id = ' . $this->config->item('CONFIG_DB_TBL_PAYMENT') . '.company_id ', 'Left');
			$this->db->where($this->config->item('CONFIG_DB_TBL_PAYMENT') . '.id', $id);
			$query = $this->db->get();
			return $query->row_array();

		}



		//---------------------------------------------------
		// Get Invoice Detil by ID
		public function update_invoice($data, $id)
		{
			$this->db->where('id', $id);
			return $this->db->update($this->config->item('CONFIG_DB_TBL_PAYMENT'), $data);
		}

		//---------------------------------------------------
		// Update Customer Detail in invoice
		public function update_company($data, $id)
		{
			$this->db->where('id', $id);
			$this->db->update($this->config->item('CONFIG_DB_TBL_COMPANY'), $data);
			return $id; // return the updated id
		}

		
	}

?>
