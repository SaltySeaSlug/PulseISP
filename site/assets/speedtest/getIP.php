<?php

$public_ip = $_GET['public_ip'];

/*
if (isset($_GET["public_ip"])) {
	$server_ip = file_get_contents("https://ipinfo.io/ip");
	if ($server_ip == $ip){
		$ip = $_GET['public_ip'];
	}
}
*/


if (strpos($public_ip, '::1') !== false) {
	echo $public_ip . " - localhost ipv6 access";
	die();
}
if (strpos($public_ip, '127.0.0') !== false) {
	echo $public_ip . " - localhost ipv4 access";
	die();
}

/**
 * Optimized algorithm from http://www.codexworld.com
 *
 * @param float $latitudeFrom
 * @param float $longitudeFrom
 * @param float $latitudeTo
 * @param float $longitudeTo
 *
 * @return float [km]
 */
function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
{
	$rad = M_PI / 180;
	$theta = $longitudeFrom - $longitudeTo;
	$dist = sin($latitudeFrom * $rad) * sin($latitudeTo * $rad) + cos($latitudeFrom * $rad) * cos($latitudeTo * $rad) * cos($theta * $rad);
	return acos($dist) / $rad * 60 * 1.853;
}

if (isset($_GET["isp"])) {
	$isp = "";
	try {
		$json = file_get_contents("https://ipinfo.io/" . $public_ip . "/json");
		$details = json_decode($json, true);
		if (array_key_exists("org", $details)) {
			$isp .= $details["org"];
		} else {
			$isp .= "Unknown ISP";
		}

		if (array_key_exists("country", $details))
			$isp .= ", " . $details["country"];
		$clientLoc = NULL;
		$serverLoc = NULL;
		if (array_key_exists("loc", $details))
			$clientLoc = $details["loc"];
		if (isset($_GET["distance"])) {
			if ($clientLoc) {
				$json = file_get_contents("https://ipinfo.io/json");
				$details = json_decode($json, true);
				if (array_key_exists("loc", $details))
					$serverLoc = $details["loc"];
				if ($serverLoc) {
					try {
						$clientLoc = explode(",", $clientLoc);
						$serverLoc = explode(",", $serverLoc);
						$dist = distance($clientLoc[0], $clientLoc[1], $serverLoc[0], $serverLoc[1]);
						if ($_GET["distance"] == "mi") {
							$dist /= 1.609344;
							$dist = round($dist, -1);
							if ($dist < 15)
								$dist = "<15";
							$isp .= " (" . $dist . " mi)";
						} else if ($_GET["distance"] == "km") {
							$dist = round($dist, -1);
							if ($dist < 20)
								$dist = "<20";
							$isp .= " (" . $dist . " km)";
						}
					} catch (Exception $e) {

					}
				}
			}
		}
	} catch (Exception $ex) {
		$isp = "Unknown ISP";
	}
	echo "$public_ip - $isp";
} else {
	echo $public_ip;
}
?>
