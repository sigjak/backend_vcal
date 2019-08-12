<?php

error_reporting(0);
$tablename = $_GET['name'];
//$tablename = 'sem';
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
$dates_two = [];

$dates_00 = [];
$dates_11 = [];
$dates_22 = [];
while ($row = mysqli_fetch_assoc($result)) {
	if($row['status'] == 0){
  $dates_00[] = ($row['date']);
        
}elseif($row['status'] == 2){
  $dates_22[]=($row['date']);
}else{
  $dates_11[]=($row['date']);	
	}
}

$dates_zero = yearsort($dates_00);
$dates_one = yearsort($dates_11);
$dates_two = yearsort($dates_22);

// compare arrays zero and two if in both arrays remove from both
// and add to onr array

$match=array_intersect($dates_zero,$dates_two);
$dates_zero=array_values(array_diff($dates_zero,$match));
$dates_one=array_merge($dates_one,$match);
$dates_two=array_values(array_diff($dates_two,$match)); 




 echo json_encode([ $dates_zero,$dates_one,$dates_two]);
mysqli_free_result($result);
mysqli_close($connection);
?>