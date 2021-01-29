<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
    
    // -----------------------------------------------------------------------------
    //check auth
    if (!function_exists('auth_check')) {
        function auth_check()
        {
			$ci =& get_instance();

			/*if ($ci->session->has_userdata('locked')) {
				redirect(base_url('admin/auth/lock_screen'), 'refresh');
			}
			else */
				if(!$ci->session->has_userdata('is_admin_login')) {
				redirect('admin/auth/login', 'refresh');
			/*}
			else {
*/
			}
        }
    }


    // -----------------------------------------------------------------------------
    // Get General Setting
    if (!function_exists('get_general_settings')) {
        function get_general_settings()
        {
            $ci =& get_instance();
            $ci->load->model('admin/setting_model');
            return $ci->setting_model->get_general_settings();
        }
    }

     // -----------------------------------------------------------------------------
    // Generate Admin Sidebar Sub Menu
    if (!function_exists('get_sidebar_sub_menu')) {
        function get_sidebar_sub_menu($parent_id)
        {
            $ci =& get_instance();
            $ci->db->select('*');
            $ci->db->where('parent',$parent_id);
            $ci->db->order_by('sort_order','asc');
            return $ci->db->get('ci_sub_module')->result_array();
        }
    }


    // -----------------------------------------------------------------------------
    // Generate Admin Sidebar Menu
    if (!function_exists('get_sidebar_menu')) {
        function get_sidebar_menu()
        {
            $ci =& get_instance();
            $ci->db->select('*');
            $ci->db->order_by('sort_order','asc');
            return $ci->db->get('ci_module')->result_array();
        }
    }

     // -----------------------------------------------------------------------------
    // Make Slug Function    
    if (!function_exists('make_slug'))
    {
        function make_slug($string)
        {
            $lower_case_string = strtolower($string);
            $string1 = preg_replace('/[^a-zA-Z0-9 ]/s', '', $lower_case_string);
            return strtolower(preg_replace('/\s+/', '-', $string1));        
        }
    }

    // -----------------------------------------------------------------------------
    //get recaptcha
    if (!function_exists('generate_recaptcha')) {
        function generate_recaptcha()
        {
            $ci =& get_instance();
            if ($ci->recaptcha_status) {
                $ci->load->library('recaptcha');
                echo '<div class="form-group mt-2">';
                echo $ci->recaptcha->getWidget();
                echo $ci->recaptcha->getScriptTag();
                echo ' </div>';
            }
        }
    }

    // ----------------------------------------------------------------------------
    //print old form data
    if (!function_exists('old')) {
        function old($field)
        {
            $ci =& get_instance();
            return html_escape($ci->session->flashdata('form_data')[$field]);
        }
    }

    // --------------------------------------------------------------------------------
    if (!function_exists('date_time')) {
        function date_time($datetime) 
        {
           return date('F j, Y',strtotime($datetime));
        }
    }

    // --------------------------------------------------------------------------------
    // limit the no of characters
    if (!function_exists('text_limit')) {
        function text_limit($x, $length)
        {
          if(strlen($x)<=$length)
          {
            echo $x;
          }
          else
          {
            $y=substr($x,0,$length) . '...';
            echo $y;
          }
        }
    }

if(!function_exists('time2str')) {
	function time2str($time) {
		$str = "";
		$time = floor($time);
		if (!$time)
			return "0 seconds";
		$d = $time/86400;
		$d = floor($d);
		if ($d){
			$str .= "$d days, ";
			$time = $time % 86400;
		}
		$h = $time/3600;
		$h = floor($h);
		if ($h){
			$str .= "$h hours, ";
			$time = $time % 3600;
		}
		$m = $time/60;
		$m = floor($m);
		if ($m){
			$str .= "$m minutes, ";
			$time = $time % 60;
		}
		if ($time)
			$str .= "$time seconds, ";
		$str = preg_replace("/, $/",'',$str);
		return $str;
	}
}

if(!function_exists('toxbyte')) {
	function toxbyte($size)
	{
		// Gigabytes
		if ($size > 1073741824) {
			$ret = $size / 1073741824;
			$ret = round($ret, 2) . " Gb";
			return $ret;
		}

		// Megabytes
		if ($size > 1048576) {
			$ret = $size / 1048576;
			$ret = round($ret, 2) . " Mb";
			return $ret;
		}

		// Kilobytes
		if ($size > 1024) {
			$ret = $size / 1024;
			$ret = round($ret, 2) . " Kb";
			return $ret;
		}

		// Bytes
		if (($size != "") && ($size <= 1024)) {
			$ret = $size . " B";
			return $ret;
		}
	}
}

?>
