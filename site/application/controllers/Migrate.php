<?php
/**
 * CodeIgniter Migrate
 *
 * @author  Natan Felles <natanfelles@gmail.com>
 * @link    http://github.com/natanfelles/codeigniter-migrate
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Migrate
 */
class Migrate extends CI_Controller
{


	/**
	 * @var array Migrations
	 */
	protected $migrations;

	/**
	 * @var bool Migration Status
	 */
	protected $migration_enabled;


	/**
	 * Migrate constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->config->load('migration');
		$this->migration_enabled = $this->config->item('migration_enabled');
		if ($this->migration_enabled && uri_string() != 'migrate/token') {
			$this->load->database($this->input->get('dbgroup') ?: '');
			$this->load->library('migration');
			$this->migrations = $this->migration->find_migrations();
		}
	}


	/**
	 * Index page
	 */
	public function index()
	{
		if ($this->migration_enabled) {
			foreach ($this->migrations as $version => $filepath) {
				$fp = explode(DIRECTORY_SEPARATOR, $filepath);
				$data['migrations'][] = [
					'version' => $version,
					'file' => $fp[count($fp) - 1],
				];
			}
			$migration_db = $this->db->get($this->config->item('migration_table'))->row_array(1);
			$data['current_version'] = $migration_db['version'];
		} else {
			$data['migration_disabled'] = TRUE;
		}

		$dbconfig = $this->get_dbconfig();

		$data['dbgroups'] = $dbconfig['dbgroups'];
		$data['active_group'] = $this->input->get('dbgroup') ?: $dbconfig['active_group'];

		$this->load->view('migrate', $data);
	}

	/**
	 * Get Database Config file info
	 *
	 * @return array
	 */
	protected function get_dbconfig()
	{
		// Is the config file in the environment folder?
		if (!file_exists($file_path = APPPATH . 'config/' . ENVIRONMENT . '/database.php')
			&& !file_exists($file_path = APPPATH . 'config/database.php')) {
			show_error('The configuration file database.php does not exist.');
		}

		include($file_path);

		return [
			'dbgroups' => array_keys($db),
			'active_group' => $active_group,
		];
	}

	/**
	 * Post page
	 */
	public function post()
	{
		error_reporting(-1);
		ini_set('display_errors', 1);

		if ($this->input->is_ajax_request() && $this->migration_enabled) {
			// If you works with Foreign Keys look this helper:
			// https://gist.github.com/natanfelles/4024b598f3b31db47c3e139d82dec281
			$this->load->helper('db');
			$version = (string)$this->input->post('version');
			if ($version == 0) {
				$this->migration->version(0);
				$response = [
					'type' => 'success',
					'header' => 'Success!',
					'content' => "Migrations has ben reseted.",
				];
			} elseif (array_key_exists($version, $this->migrations)) {
				$v = $this->migration->version($version);

				if (is_numeric($v)) {
					$response = [
						'type' => 'success',
						'header' => 'Success!',
						'content' => "The current version is <strong>{$v}</strong> now.",
					];
				} elseif ($v === TRUE) {
					$response = [
						'type' => 'info',
						'header' => 'Info',
						'content' => 'Migration continues in the same version.',
					];
				} elseif ($v === FALSE) {
					$response = [
						'type' => 'danger',
						'header' => 'Error!',
						'content' => 'Migration failed.',
						'version' => $v,
						'v' => $version,
						'mig' => $this->migrations,
						'latest' => $this->migration->latest()
					];
				}
			} else {
				$response = [
					'type' => 'warning',
					'header' => 'Warning!',
					'content' => 'The migration version <strong>' . htmlentities($version) . '</strong> does not exists.',
				];
			}
			$response[] = show_error($this->migration->error_string());

			header('Content-Type: application/json');
			echo json_encode(isset($response) ? $response : '');
		}
	}

	/**
	 * Token page
	 */
	public function token()
	{
		header('Content-Type: application/json');
		echo json_encode([
			'name' => $this->security->get_csrf_token_name(),
			'value' => $this->security->get_csrf_hash(),
		]);
	}

	public function Do()
	{
		//$this->load->library('BootstrapMigrations', null, 'mig');
		//$this->mig->create_migration();

		$this->load->library('Sqltoci');
		$this->sqltoci->generate();

	}

	public function do_migration($version = NULL)
	{
		$this->load->library('migration');

		if (isset($version) && ($this->migration->version($version) === FALSE)) {
			show_error($this->migration->error_string());
		} elseif (is_null($version) && $this->migration->latest() === FALSE) {
			show_error($this->migration->error_string());
		} else {
			echo 'The migration has concluded successfully.';
		}
	}
}
