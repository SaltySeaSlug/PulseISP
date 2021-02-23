<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

class Freeradius_Behavior_model extends CI_Model
{

	protected $tables_to_delete_username = [
		'radcheck',
		'radreply',
		'radacct',
		'radpostauth',
		'data_account',
		'data_account_stat'
	];

	public function setAutoMac($username, $auto = true)
	{
		if ($auto == 'true') {
			$this->_replace_radcheck_item($username, 'Rd-Auto-Mac', 1);
		} else {
			$this->_remove_radcheck_item($username, 'Rd-Auto-Mac');
		}
	}

	private function _replace_radcheck_item($username, $item, $value, $op = ":=")
	{
		$this->{'Radchecks'}->deleteAll(['username' => $username, 'attribute' => $item]);
		$data = [
			'username' => $username,
			'op' => $op,
			'attribute' => $item,
			'value' => $value
		];
		$entity = $this->{'Radchecks'}->newEntity($data);
		$this->{'Radchecks'}->save($entity);
	}

	private function _remove_radcheck_item($username, $item)
	{
		$this->{'Radchecks'}->deleteAll(['username' => $username, 'attribute' => $item]);
	}

	public function getCleartextPassword($username)
	{
		$qr = $this->Radchecks->find()->where([
			'username' => $username,
			'attribute' => 'Cleartext-Password'
		])->first();
		return $qr ? $qr->value : '';
	}

	private function _deleteUsernameEntriesFromTables($username)
	{
		$this->db->where('username', $username);
		$this->db->delete($this->tables_to_delete_username);
	}
}

?>
