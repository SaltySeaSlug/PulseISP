<?php
	class Languages_model extends CI_Model{

		public function add_language($data){
			return $this->db->insert('ci_language', $data);
		}

		public function get_all_languages(){
			$query = $this->db->get('ci_language');
			return $result = $query->result_array();
		}

		public function edit_language($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_language', $data);
			return true;

		}

		public function get_language_by_id($id){
			$query = $this->db->get_where('ci_language', array('id' => $id));
			return $result = $query->row_array();
		}

		public function delete_language($id) {
			$this->db->delete('ci_language', array('id' => $id));
			return true;
		}

		public function set_default_language($id){
			$language = $this->get_language_by_id($id);
			$this->db->update('ci_general_settings', array('default_language' => $language['directory_name'])); // setting in General settings table

			$this->db->update('ci_language', array('is_default' => 0)); // setting all previous to 0

			$this->db->where('id', $id);
			$this->db->update('ci_language', array('is_default' => 1));
			return true;

		}

		public function write_to_file($my_lang)
		{
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
			$this->load->helper('file');

			//$this->db->where('id',1);
			//$query = $this->db->get('ci_language')->row_array()['short_name'];
			$category = 'test';
			$description = 'mystuff';
			$token = 'My Special Language file';

			$lang = array();
			$langstr = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
                /**
                *
                * Created:  2014-05-31 by Vickel
                *
                * Description:  " . $my_lang . " language file for general views
                *
                */" . "\n\n\n";


			//foreach ($query->result() as $row) {
				//$lang['error_csrf'] = 'This form post did not pass our security checks.';
				$langstr .= "\$lang['" . $category . "_" . $description . "'] = \"$token\";" . "\n";
			//}
			write_file('./application/language/' . $my_lang . '/custom_lang.php', $langstr);
echo json_encode($langstr);
		}
	}

?>	
