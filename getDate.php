<?php
error_reporting(0);
$tablename = $_GET['name'];
//$tablename="probeuse";
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
$dates_zero = [];
$dates_one = [];
$dates_00 = [];
$dates_11 = [];
// while ($row = mysqli_fetch_assoc($result)) {
// 	if($row['status'] == 0){
//   $dates_zero[] = strtotime($row['date'])*1000;
// }else{
// 	$dates_one[]=strtotime($row['date'])*1000;	
// 	}
// }
while ($row = mysqli_fetch_assoc($result)) {
	if($row['status'] == 0){
  $dates_00[] = ($row['date']);
}else{
	$dates_11[]=($row['date']);	
	}
}

$thisYear = date("Y");
$sizezero= count($dates_00);
$sizeone = count($dates_11);
$j=0;
for($i=0;$i<$sizezero;$i++){
  $test=substr($dates_00[$i],-4);
  if($test >= $thisYear){
    $dates_zero[$j] =strtotime($dates_00[$i])*1000 ;
    $j++;
  }
}
$j=0;
for($i=0;$i<$sizeone;$i++){
  $test=substr($dates_11[$i],-4);
  if($test >= $thisYear){
    $dates_one[$j] = strtotime($dates_11[$i])*1000;
    $j++;
  }
}

echo json_encode([ $dates_zero,$dates_one]);
mysqli_free_result($result);
mysqli_close($connection);
?>