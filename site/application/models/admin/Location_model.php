<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

class Location_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//-----------------------------------------------------
	public function get_all_countries(){

		$wh = array();

		$query = $this->db->get($this->config->item('CONFIG_DB_TBL_COUNTRY'));
		$SQL = $this->db->last_query();

		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			return $this->datatable->LoadJson($SQL, $WHERE);
		} else {
			return $this->datatable->LoadJson($SQL);
		}
	}

	//-----------------------------------------------------
	public function get_all_states()
	{

		$wh = array();

		$query = $this->db->get($this->config->item('CONFIG_DB_TBL_STATE'));
		$SQL = $this->db->last_query();

		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			return $this->datatable->LoadJson($SQL, $WHERE);
		} else {
			return $this->datatable->LoadJson($SQL);
		}
	}

	//-----------------------------------------------------
	public function get_all_cities()
	{

		$wh = array();

		$query = $this->db->get($this->config->item('CONFIG_DB_TBL_CITY'));
		$SQL = $this->db->last_query();

		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			return $this->datatable->LoadJson($SQL, $WHERE);
		} else {
			return $this->datatable->LoadJson($SQL);
		}
	}


	//-----------------------------------------------------
	public function add_country($data)
	{

		$result = $this->db->insert($this->config->item('CONFIG_DB_TBL_COUNTRY'), $data);
		return $this->db->insert_id();
	}

	//-----------------------------------------------------
	public function add_state($data)
	{

		$result = $this->db->insert($this->config->item('CONFIG_DB_TBL_STATE'), $data);
		return true;
	}

	//-----------------------------------------------------
	public function add_city($data)
	{

		$result = $this->db->insert($this->config->item('CONFIG_DB_TBL_CITY'), $data);
		return true;
	}

	//-----------------------------------------------------
	public function edit_country($data, $id)
	{

		$this->db->where('id', $id);
		$this->db->update($this->config->item('CONFIG_DB_TBL_COUNTRY'), $data);
		return true;

	}

	//-----------------------------------------------------
	public function edit_state($data, $id)
	{

		$this->db->where('id', $id);
		$this->db->update($this->config->item('CONFIG_DB_TBL_STATE'), $data);
		return true;

	}

	//-----------------------------------------------------
	public function edit_city($data, $id)
	{

		$this->db->where('id', $id);
		$this->db->update($this->config->item('CONFIG_DB_TBL_CITY'), $data);
		return true;

	}

	//-----------------------------------------------------
	public function get_country_by_id($id)
	{

		$query = $this->db->get_where($this->config->item('CONFIG_DB_TBL_COUNTRY'), array('id' => $id));
		return $result = $query->row_array();
	}

	//-----------------------------------------------------
	public function get_state_by_id($id)
	{

		$query = $this->db->get_where($this->config->item('CONFIG_DB_TBL_STATE'), array('id' => $id));
		return $result = $query->row_array();
	}

	//-----------------------------------------------------
	public function get_city_by_id($id)
	{

		$query = $this->db->get_where($this->config->item('CONFIG_DB_TBL_CITY'), array('id' => $id));
		return $result = $query->row_array();
	}

		//------------------------------------------------
	// Get Countries
	function get_countries_list($id=0)
	{
		if($id==0) {
			return $this->db->get($this->config->item('CONFIG_DB_TBL_COUNTRY'))->result_array();
		}
		else {
			return $this->db->select('id,country')->from($this->config->item('CONFIG_DB_TBL_COUNTRY'))->where('id', $id)->get()->row_array();
		}
	}	

	//------------------------------------------------
	// Get Cities
	function get_cities_list($id=0)
	{
		if($id==0) {
			return $this->db->get($this->config->item('CONFIG_DB_TBL_CITY'))->result_array();
		}
		else {
			return $this->db->select('id,city')->from($this->config->item('CONFIG_DB_TBL_CITY'))->where('id', $id)->get()->row_array();
		}
	}	

	//------------------------------------------------
	// Get States
	function get_states_list($id=0)
	{
		if($id==0) {
			return $this->db->get($this->config->item('CONFIG_DB_TBL_STATE'))->result_array();
		}
		else {
			return $this->db->select('id,s')->from($this->config->item('CONFIG_DB_TBL_CITY'))->where('id', $id)->get()->row_array();
		}
	}
	
}
?>
