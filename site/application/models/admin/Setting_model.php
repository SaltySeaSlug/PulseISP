<?php
class Setting_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//-----------------------------------------------------
	public function update_general_setting($data){
		$this->db->where('id', 1);
		$this->db->update('ci_general_settings', $data);
		return true;

	}

	//-----------------------------------------------------
	public function get_general_settings(){
		$this->db->where('id', 1);
        $query = $this->db->get('ci_general_settings');
        return $query->row_array();
	}

	public function get_all_languages()
	{
		$this->db->where('status',1);
		return $this->db->get('ci_language')->result_array();
	}

	public function get_timezone_list() {
	    $time_Zones_arr = array();
	    $live_timestamp = time();
		    foreach(timezone_identifiers_list() as $key => $zone) {
		        date_default_timezone_set($zone);
		        $time_Zones_arr[$key]['zone'] = $zone;
		        $time_Zones_arr[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $live_timestamp);
		    }
	    return $time_Zones_arr;
	}

	public function get_currency_list() {
		return $this->db->get('ci_currency')->result_array();
	}

	public function get_currency(){
		$this->db->where('id', 1);
        $query = $this->db->get('ci_general_settings');
        return $query->row_array()['currency'];
	}

	/*--------------------------
	   Email Template Settings
	--------------------------*/

	function get_email_templates()
	{
		return $this->db->get('ci_email_templates')->result_array();
	}

	function update_email_template($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update('ci_email_templates', $data);
		return true;
	}

	function get_email_template_content_by_id($id)
	{
		return $this->db->get_where('ci_email_templates',array('id' => $id))->row_array();
	}

	function get_email_template_variables_by_id($id)
	{
		return $this->db->get_where('ci_email_template_variables',array('template_id' => $id))->result_array();
	}

	
}
?>
