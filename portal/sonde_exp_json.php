<?php
/*
Ranges:
	day: no average required, take all datapoints
	1 week: average period = 30 min
	1 month: average period = 3 hours
	1 year: average period: 1 day
	
URL parameters (GET)
	callback (string):	callback {String} The name of the JSONP callback to pad the JSON within
	sonde_id (int):		id of the probe 
	start (int):		the starting point for DB extract
	end (in):			the ending point for DB extract
*/

define('ROOT', dirname(__FILE__) . '/');
require_once (ROOT.'include/init.php');

$callback = $_GET['callback'];
if (!preg_match('/^[a-zA-Z0-9_]+$/', $callback)) {
	die('Invalid callback name');
	}

$sonde_id = $_GET['sonde_id'];
if ($sonde_id && !preg_match('/^[0-9]+$/', $sonde_id))	{
	die('Paramètre sonde_id manquant ou erroné: '.$sonde_id);  
	}

$start = $_GET['start'];
if ($start && !preg_match('/^[0-9]+$/', $start)) {
	die("Invalid start parameter: $start");
	}

$end = $_GET['end'];
if ($end && !preg_match('/^[0-9]+$/', $end)) {
	die("Invalid end parameter: $end");
	}

if (!$end) $end = mktime() * 1000;
if (!$start) $start = (strtotime(T0_TIMESTAMP))*1000;

// set some utility variables
$range = $end - $start;
$startTime = strftime('%Y-%m-%d %H:%M:%S', $start / 1000);
$endTime = strftime('%Y-%m-%d %H:%M:%S', $end / 1000);
//echo "/* console.log('start:$start end:$end range:$range starttime:$startTime endtime:$endTime'); */\n";

// find the right table
// two days range loads nominal 5min data
if ($range <= 2 * 24 * 3600 * 1000) {
	$sql = "SELECT UNIX_TIMESTAMP(timestamp)*1000 as temps, mesure, NULL as max_mesure, NULL as min_mesure FROM t_mesures WHERE (sonde_id =$sonde_id) AND (timestamp BETWEEN '$startTime' and '$endTime') ORDER BY temps";
	
// one week range loads 30min averaged data
} elseif ($range <= 7 * 24 * 3600 * 1000) {
	$sql = "SELECT UNIX_TIMESTAMP(mid_period)*1000 as temps, round(avg_mesure,2) as mesure, round(max_mesure,2) as max_mesure, round(min_mesure,2) as min_mesure FROM v_mesures_avg_30min WHERE (sonde_id =$sonde_id) AND (mid_period BETWEEN '$startTime' and '$endTime') ORDER BY temps";
	
// one month range loads 3hours averaged data
} elseif ($range <= 31 * 24 * 3600 * 1000) {
	$sql = "SELECT UNIX_TIMESTAMP(mid_period)*1000 as temps, round(avg_mesure,2) as mesure , round(max_mesure,2) as max_mesure, round(min_mesure,2) as min_mesure FROM v_mesures_avg_3h WHERE (sonde_id =$sonde_id) AND (mid_period BETWEEN '$startTime' and '$endTime') ORDER BY temps";

// greater range loads monthly data
} else {
	$sql = "SELECT UNIX_TIMESTAMP(mid_period)*1000 as temps, round(avg_mesure,2) as mesure , round(max_mesure,2) as max_mesure, round(min_mesure,2) as min_mesure FROM v_mesures_avg_1jour  WHERE (sonde_id =$sonde_id) AND (mid_period BETWEEN '$startTime' and '$endTime') ORDER BY temps";
} 

$query = mysqli_query($DBCon,$sql) 
	or die ("Echec de la requete pour export Json: \n\n" . $sql."\n\n".mysqli_error($DBCon));
$data = array();
$data1 = array();
$data2 = array();

while ($row = mysqli_fetch_array($query, MYSQL_ASSOC)) 
        {
        extract ($row);
		$data[average][]=array($temps,$mesure);
		if ($range > 2 * 24 * 3600 * 1000) $data[range][]=array($temps,$min_mesure, $max_mesure); //we export min/max only in case of consolidation
        }

//echo "/* console.log('Nb records:'".mysqli_num_rows($query)." ); */\n\n";

print json_encode($data,JSON_NUMERIC_CHECK);
?>
