<?php
class Cron_model extends CI_Model{

	function update_last_contact()
	{
		$ip = '100.99.1.255';
		$ttl = 128;
		$timeout = 1;

		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
			try {
				$ping = new JJG\Ping($ip, $ttl, $timeout);
				$latency = $ping->ping('exec');

				if ($latency !== false) {
					echo $latency;
				} else {
					echo "ERR";
				}
			} catch (Exception $e) {
				echo "ERR";
			}
		}
	}
}

?>
