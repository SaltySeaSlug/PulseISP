<?php

class License_model extends CI_Model
{

	public function viewLicenseKey($licenseData)
	{
	}

	public function licenseKey()
	{
		// CHECK IF LICENSE KEY FILE EXISTS
		// IF NOT SEND TO LICENSE PAGE
		// CHECK IF LICENSE KEY IS IN DATABASE
		// IF NOT SEND TO LICENSE PAGE

		// COMPARE LICENSE KEY IN FILE WITH LICENSE KEY IN DATABASE
		// IF LICENSE DOES NOT MATCH SEND TO LICENSE PAGE
		// ELSE CONTINUE WITH CHECKS
		// CHECK IF LICENSE AS EXPIRY DATE
		// CHECK IF LICENSE HAS CALL BACK DATE
		// CHECK IF LICENSE HAS DOMAIN/IP ASSIGNED
		// CHECK IF LICENSE HAS ANY RESTRICTIONS

		$licenseData = $this->generateLicenseKey(array('id' => 1, 'name' => "Mark", 'surname' => "Cockbain", 'expiry_date' => date('Y-m-d H:i:s'), 'call_back' => 24));
		$encrypted = $this->encryptLicenseKey($licenseData);
		$decrypted = $this->decryptLicenseKey($encrypted);


		$data =
			[
				'original' => $licenseData,
				'encrypted' => $encrypted,
				'decrypted' => $decrypted,
			];

		return $licenseData['license_key'];
	}

	public function generateLicenseKey($array)
	{
		if (preg_match('/(\d{4})(\d{4})(\d{4})(\d{4})$/', rand(1111111111111111, 9999999999999999), $matches)) {
			$rand = $matches[1] . '-' . $matches[2] . '-' . $matches[3] . '-' . $matches[4];
		}

		$array['license_key'] = $rand;

		/*if (file_exists("license.key")) {
			$myfile = fopen("license.key", "r") or die("Unable to open file!");
			$key = fgets($myfile);
			$array['license_key'] = $key;
			fclose($myfile);
		} else {
			$myfile = fopen("license.key", "w") or die("Unable to open file!");
			fwrite($myfile, $rand);
		}*/

		//$myfile = fopen("license.key", "w") or die("Unable to open file!");
		//fwrite($myfile, $rand);

		return $array;
	}

	public function encryptLicenseKey($licenseData)
	{
		$this->load->library('encryption');
		$encrypter = new CI_Encryption;
		return $encrypter->encrypt($this->encode_arr($licenseData));
	}

	function encode_arr($data)
	{
		return base64_encode(serialize($data));
	}

	public function decryptLicenseKey($licenseData)
	{
		$this->load->library('encryption');
		$encrypter = new CI_Encryption;
		return $this->decode_arr($encrypter->decrypt($licenseData));
	}

	function decode_arr($data)
	{
		return unserialize(base64_decode($data));
	}

	public function callHome()
	{
		$client = new GuzzleHttp\Client();
		$res = $client->get('https://api.github.com/users', [
			'auth' => ['user', 'pass']
		]);
		echo $res->getStatusCode();           // 200
		echo $res->getHeader('Content-type: application/json; charset=utf8'); // 'application/json; charset=utf8'
		echo $res->getBody();                 // {"type":"User"...'
		var_export($res->json());             // Outputs the JSON decoded data
	}

	// GET UNIQUE MACHINE ID
	public function getMachineID()
	{
	}

	// CREATE LICENSE
	public function createLicense()
	{
	}

	// SAVE LICENSE
	public function saveLicense()
	{
	}

	// DELETE LICENSE
	public function deleteLicense()
	{
	}

	// ENCRYPT CURRENT LICENSE DATA
	public function encryptLicense()
	{
	}

	// DECRYPT CURRENT LICENSE DATA
	public function decryptLicense()
	{
	}
}

?>
