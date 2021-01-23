<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// -----------------------------------------------------------------------------
// Get Language by ID
function get_lang_name_by_id($id)
{
    $ci = & get_instance();
    $ci->db->where('id',$id);
    return $ci->db->get('ci_language')->row_array()['name'];
}

// -----------------------------------------------------------------------------
// Get Language Short Code
function get_lang_short_code($id)
{
    $ci = & get_instance();
    $ci->db->where('id',$id);
    return $ci->db->get('ci_language')->row_array()['short_name'];
}

// -----------------------------------------------------------------------------
// Get Language List
function get_language_list()
{
    $ci = & get_instance();
    $ci->db->where('status',1);
    return $ci->db->get('ci_language')->result_array();
}

// -----------------------------------------------------------------------------
// Get country list
function get_country_list()
{
    $ci = & get_instance();
    return $ci->db->get('ci_countries')->result_array();
}

// -----------------------------------------------------------------------------
// Get country name by ID
function get_country_name($id)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_countries', array('id' => $id))->row_array()['name'];
}

// -----------------------------------------------------------------------------
// Get City ID by Name
function get_country_id($title)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_countries', array('slug' => $title))->row_array()['id'];
}

// -----------------------------------------------------------------------------
// Get country slug
function get_country_slug($id)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_countries', array('id' => $id))->row_array()['slug'];
}

// -----------------------------------------------------------------------------
// Get country's states
function get_country_states($country_id)
{
    $ci = & get_instance();
    return $ci->db->select('*')->where('country_id',$country_id)->get('ci_states')->result_array();
}

// -----------------------------------------------------------------------------
// Get state's cities
function get_state_cities($state_id)
{
    $ci = & get_instance();
    return $ci->db->select('*')->where('state_id',$state_id)->get('ci_cities')->result_array();
}

// Get state name by ID
function get_state_name($id)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_states', array('id' => $id))->row_array()['name'];
}

// -----------------------------------------------------------------------------
// Get city name by ID
function get_city_name($id)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_cities', array('id' => $id))->row_array()['name'];
}

// -----------------------------------------------------------------------------
// Get city ID by title
function get_city_slug($id)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_cities', array('id' => $id))->row_array()['slug'];
}

/**
 * Generic function which returns the translation of input label in currently loaded language of user
 * @param $string
 * @return mixed
 */
function trans($string)
{
    $ci =& get_instance();
    return empty($ci->lang->line($string)) ? '<b class="text-danger">| Missing key from language file ['.$string.'] |</b>' : $ci->lang->line($string);
}

// -----------------------------------------------------------------------------
// Get the newest invoice number
function get_new_invoice_number()
{
    $ci = & get_instance();
    $record = $ci->db->select('invoice_no')->order_by('invoice_no',"desc")->limit(1)->get('ci_payments')->row();//->invoice_no;
    if (!empty($record->invoice_no)) {
		$last = preg_replace('/\D/', '', $record->invoice_no);
		return 'INV' . str_pad(++$last, 5, '0', STR_PAD_LEFT);
	}
    else {
		return 'INV' . str_pad(1, 5, '0', STR_PAD_LEFT);
	}
}

function getRealIpAddr(){
 if ( !empty($_SERVER['HTTP_CLIENT_IP']) ) {
  // Check IP from internet.
  $ip = $_SERVER['HTTP_CLIENT_IP'];
 } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
  // Check IP is passed from proxy.
  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
 } else {
  // Get IP address from remote address.
  $ip = $_SERVER['REMOTE_ADDR'];
 }
 return $ip;
}
