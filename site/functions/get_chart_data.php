<?php

header('Content-Type: application/json');
function bytes($bytes, $force_unit = NULL, $format = NULL, $si = FALSE)
{
	// Format string
	$format = ($format === NULL) ? '%01.2f %s' : (string) $format;

	// IEC prefixes (binary)
	if ($si == FALSE OR strpos($force_unit, 'i') !== FALSE)
	{
		$units = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
		$mod   = 1024;
	}
	// SI prefixes (decimal)
	else
	{
		$units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB');
		$mod   = 1000;
	}

	// Determine unit to use
	if (($power = array_search((string) $force_unit, $units)) === FALSE)
	{
		$power = ($bytes > 0) ? floor(log($bytes, $mod)) : 0;
	}

	return ($bytes / pow($mod, $power));
}
function sizeFormat($bytes, $unit = "", $decimals = 2) {
	$units = array('B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4, 'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8);

	$value = 0;
	if ($bytes > 0) {
		if (!array_key_exists($unit, $units)) {
			$pow = floor(log($bytes)/log(1024));
			$unit = array_search($pow, $units);
		}
		$value = ($bytes/pow(1024,floor($units[$unit])));
	}
	if (!is_numeric($decimals) || $decimals < 0) {
		$decimals = 2;
	}
	return sprintf('%.' . $decimals . 'f '.$unit, $value);
}

$servername = "127.0.0.1";
$database = "pulseisp_db";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

$sql = "SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download, HOUR(`timestamp`) as hour FROM ppp_accounts_stats WHERE DATE(`timestamp`) = CURDATE() GROUP BY HOUR(`timestamp`) ORDER BY hour ASC";
$result = mysqli_query($conn, $sql);

// GENERATE RANGE 0 to 23
	$data = range(0, 23);
	foreach ($result as $row) {
		$data[$row['hour']] = array("SUMDownload" => bytes($row['download'], 'B'), "SUMUpload" => bytes($row['upload'], 'B'), "SUMTime" => $row['hour']);
	}

// FOREACH ROW (0 to 23) CHECK IF VALUE IS AN INT
// IF IT IS AN INT DEFAULT TO BLANK DATA RECORD
	$count = 0;
	foreach (array_keys($data) as $index => $key) {
		if ($index == $count && is_numeric($data[$key])) {
			$data[$key] = array("SUMTime" => $key);
		}
		$count++;
	}

	mysqli_close($conn);

	echo json_encode($data);

// SELECT SUM(IFNULL(`acctinputoctets`,0)) as upload, SUM(IFNULL(`acctoutputoctets`,0)) as download FROM user_stats WHERE DATE(timestamp) = CURDATE()
?>
