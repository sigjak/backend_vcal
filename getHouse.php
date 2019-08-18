<?php
error_reporting(0);
$tablename = $_GET['name'];
//$tablename= 'vidimelur';
require_once "dbase_connection.php";
$connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);


if(!$connection){
	echo ('ConnectionError');
	exit();
}


$query = "SELECT * FROM $tablename ";
$result = mysqli_query($connection, $query);
if (!$result) {
  die("ConnectionError");
}

$dates = [];
$status = [];
$alldates = [];
$allstatus = [];
$available = [];
while ($row = mysqli_fetch_assoc($result)) {
	$alldates[] = ($row['date']);
	$allstatus[] = ($row['status']);
}
$thisYear = date("Y");
$allLength=count($alldates);
$j=0;
for($i=0;$i<$allLength; $i++){
	$test=substr($alldates[$i],-4);
	
	if($test >= $thisYear){
		$dates[$j] = $alldates[$i];
		$status[$j] = $allstatus[$i];
		$j++;
	}
}


$datesUnique = array_unique($dates);

$uniqueLength = count($datesUnique);
$datesLength = count($dates);

$newdates = [];
$newstatus = [];
$disabled =[];

if ($tablename == 'dyngja') {
	$maxOccupancy = 7;
} elseif ($tablename == 'helluhraun') {
	$maxOccupancy = 11;
} elseif ($tablename == 'iridium') {
	$maxOccupancy = 4;
}  elseif ($tablename == 'gasdetect') {
	$maxOccupancy = 6;
} else {
	$maxOccupancy = 2;
}

foreach ($datesUnique as $key => $value) {
	array_push($newdates, $value);
}

$nn=[];
$timestamp=[];

for ($i = 0; $i < $uniqueLength; $i++) {
	$temp = $newdates[$i];
	$newstatus[$i] = 0;
	for ($j = 0; $j < $datesLength; $j++) {
		if ($temp == $dates[$j]) {
			$newstatus[$i] += $status[$j];
		}
	}
	//$newdates[$i] = new DateTime($newdates[$i]);
	array_push($nn,  new DateTime($newdates[$i]));

	$timestamp[$i] = date_timestamp_get($nn[$i])*1000;
	$available[$i] = $maxOccupancy - $newstatus[$i];
}


//change all $timestamp and newdates from here to $timestamps
for ($i = 0; $i < $uniqueLength; $i++) {
	if ($available[$i] <= 0) {
	    array_push($disabled,$timestamp[$i]);
		unset($timestamp[$i]);
		//unset($newstatus[$i]);
        unset($available[$i]);
		
	}
}



$timestamp=array_values($timestamp);

//$newstatus=array_values($newstatus);

$available=array_values($available);





echo json_encode([$timestamp, $available,$disabled,$maxOccupancy]);
mysqli_free_result($result);
mysqli_close($connection);
?>