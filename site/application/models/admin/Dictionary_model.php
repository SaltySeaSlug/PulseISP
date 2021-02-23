<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

class Dictionary_model extends CI_Model
	{
		public function add_dictionary($data)
		{
			$this->load->helper('url');
			$this->load->helper('file');

			$string = file_get_contents($data['filepath']);
			$myDictionary = preg_split('/\n/', $string);            // we break the POST variable (continous string) into an array

			$myVendor = '';                            // by default we set the vendor name to be the file name
			$myAttribute = '';                                // variables are initialized
			$myType = '';
			$vendorTmp = '';
			$vendorUnique = 1;                            // we set $vendorUnique boolean to be unique

			foreach ($myDictionary as $line) {

				if (preg_match('/^#/', $line))
					continue;                        // if a line starts with # then it's a comment, skip it

				if (preg_match('/^\n/', $line))
					continue;                        // if a line is empty, we skip it as well

				if (preg_match('/^VALUE/', $line))
					continue;                        // if a line starts with VALUE we have no use for it, we skip it

				if (preg_match('/^BEGIN-VENDOR/', $line))
					continue;                        // if a line starts with BEGIN-VENDOR we have no use for it,
				// we skip it

				if (preg_match('/^END-VENDOR/', $line))
					continue;                        // if a line starts with END-VENDOR we have no use for it,
				// we skip it


				if (preg_match('/^VENDOR/', $line)) {                // extract vendor name

					if (preg_match('/\t/', $line))
						list($junk, $vendorTmp) = preg_split('/\t+/', $line);        // check if line is splitted by a sequence of tabs
					else if (preg_match('/ /', $line))
						list($junk, $vendorTmp) = preg_split('/[ ]+/', $line);        // check if line is splitted by a sequence of
					// whitespaces

					if ($vendorTmp != "")
						$myVendor = trim($vendorTmp);

					continue;
				}


				if (preg_match('/^ATTRIBUTE/', $line)) {                // extract attribute name

					if (preg_match('/\t/', $line))
						list($junk, $attribute, $junk2, $type) = preg_split('/\t+/', $line);        // check if line is splitted by
					// a sequence of tabs
					else if (preg_match('/ /', $line))
						list($junk, $attribute, $junk2, $type) = preg_split('/[ ]+/', $line);        // check if line is splitted by
					//a sequence of whitespaces
					if ($attribute != "")
						$myAttribute = trim($attribute);
					else
						$myAttribute = "NULL";

					if ($type != "")
						$myType = trim($type);
					else
						$myType = "NULL";

					/*
					// before we start inserting vendor dictionary attributes to the database we need to check that the vendor
					// doesn't already exist - for now we don't check it...
									$sql = "SELECT Vendor FROM ".$configValues['CONFIG_DB_TBL_DALODICTIONARY'].
													" WHERE Vendor = $myVendor";
									$res = $dbSocket->query($sql);
									$logDebugSQL .= $sql . "\n";
					$row = $res->fetchRow();
					$vendorName = $row[0];
					if ($vendorName == $myVendor) {
						$vendorUnique = 0;
						break;
					}
					*/

					$sql = array(
						'id' => 0,
						'type' => $myType,
						'attribute' => $myAttribute,
						'vendor' => $myVendor
					);

					$this->db->insert($this->config->item('CONFIG_DB_TBL_RADDICTIONARY'), $sql);
				}
			}

			return true;
		}
		public function get_all_dictionaries()
		{
			$this->db->select('attribute, value, vendor');
			return $this->db->get($this->config->item('CONFIG_DB_TBL_RADDICTIONARY'))->result_array();
		}
	}
?>
