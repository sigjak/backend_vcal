<?php
error_reporting(0);
$tablename = $_GET['name'];
//$tablename="probeuse";
require_once "dbase_connection.php";
require_once "functions.php";
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
$dates_zero = [];
$dates_one = [];
$dates_00 = [];
$dates_11 = [];

while ($row = mysqli_fetch_assoc($result)) {
	if($row['status'] == 0){
  $dates_00[] = ($row['date']);
}else{
	$dates_11[]=($row['date']);	
	}
}

$dates_zero= yearsort($dates_00);
$dates_one = yearsort($dates_11);

echo json_encode([ $dates_zero,$dates_one]);
mysqli_free_result($result);
mysqli_close($connection);
?>