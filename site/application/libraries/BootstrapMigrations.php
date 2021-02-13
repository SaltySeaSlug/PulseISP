<?php

class BootstrapMigrations
{

	public $CI;
	private $outputdata;

	function __construct()
	{

		if (!isset($this->CI)) {
			$this->CI =& get_instance();
		}

		$this->outputdata = array();

	}

	function create_migration()
	{

		$tables = $this->CI->db->list_tables();

		foreach ($tables as $table) {
			$query = $this->CI->db->query("show fields from " . $table);

			$fields = array();

			foreach ($query->result() as $row) {
				$field = new stdClass;
				$field->name = $row->Field;
				$field->type = $row->Type;
				$field->isnull = ($row->Null == 'YES') ? TRUE : FALSE;
				$field->iskey = $row->Key;
				$field->defaultVal = $row->Default;
				$field->extra = $row->Extra;
				$fields[$field->name] = $field;
			}

			$this->table_migration($table, $fields);

		}


		$data = '<?php

defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');

class Migration_BootstrapMigration extends CI_Migration {

        public function up()
        {
        	';

		$data .= implode("\r\n", $this->outputdata);

		$data .= '
               }

        public function down()
        {
        	';
		foreach ($tables as $table) {
			$data .= '$this->CI->dbforge->drop_table(\'' . $table . '\');
            ';
		}
		$data .= '
		}

}
';
		file_put_contents(APPPATH . 'migrations\\' . date('YmdHis') . '_migration.php', $data);

	}

	function table_migration($tablename, $fields)
	{

		if ($fields) {

			$this->outputdata[] = '$this->CI->dbforge->add_field(array(';

			foreach ($fields as $field) {

				$type = substr($field->type, 0, (strpos($field->type, '(')) ? strpos($field->type, '(') : strlen($field->type));//everything to the left of the bracket
				$constraint_start = strpos($field->type, '(');
				$constraint_end = strpos($field->type, ')');
				$constraint_len = strlen($field->type);

				if ($constraint_start && $constraint_end) {
					$constraint = substr($field->type, $constraint_start + 1, ($constraint_end - $constraint_start - 1));
				} else {
					$constraint = FALSE;
				}

				$this->outputdata[] = "'" . $field->name . "' => array(";
				$this->outputdata[] = "    'type' => '" . strtoupper($type) . "',";
				if (strpos($field->type, 'unsigned')) {
					$this->outputdata[] = "    'unsigned' => TRUE,";
				}
				if ($constraint) {
					$this->outputdata[] = "    'constraint' => " . $constraint . ",";
				}
				if ($field->isnull) {
					$this->outputdata[] = "    'null' => TRUE,";
				}
				if (strpos($field->extra, 'autoincrement')) {
					$this->outputdata[] = "    'auto_increment' => TRUE,";
				}
				if ($field->defaultVal) {
					$this->outputdata[] = "    'default' => '" . $field->defaultVal . "',";
				}
				$this->outputdata[] = "),";

			}
			$this->outputdata[] = '));';


			foreach ($fields as $field) {

				if ($field->iskey) {
					switch ($field->iskey) {
						case 'PRI':
							$this->outputdata[] = '$this->CI->dbforge->add_key(\'' . $field->name . '\', \'TRUE\');';
							break;
						case 'MUL':
							$this->outputdata[] = '$this->CI->dbforge->add_key(\'' . $field->name . '\');';
							break;

					}
				}

			}

			$this->outputdata[] = '$this->CI->dbforge->create_table(\'' . $tablename . '\');';

		}


	}

}
