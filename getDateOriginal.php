<?php
error_reporting(0);
$tablename = $_GET['name'];
require_once "dbase_connection.php";
$connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

// test for connection
/*if (mysqli_connect_errno()) {
  die("Database connection failed: " .
    mysqli_connect_error() .
    " ( " . mysqli_connect_errno() . ")");

}*/
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
while ($row = mysqli_fetch_assoc($result)) {
	if($row['status'] == 0){
  $dates_zero[] = strtotime($row['date'])*1000;
}else{
	$dates_one[]=strtotime($row['date'])*1000;	
	}
}

echo json_encode([ $dates_zero,$dates_one]);
mysqli_free_result($result);
mysqli_close($connection);
?>