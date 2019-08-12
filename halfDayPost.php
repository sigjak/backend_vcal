<?php
require_once "mail.php";
require_once "dbase_connection.php";

$connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
mysqli_set_charset($connection,'utf8mb4_general_ci');
// Get the posted data.
$postdata = file_get_contents("php://input");
if(!$postdata)exit;
$request = json_decode($postdata);
// test for connection
if (mysqli_connect_errno()) {
  die("Database connection failed: " .
    mysqli_connect_error() .
    " ( " . mysqli_connect_errno() . ")");
}


$fullName = mysqli_real_escape_string($connection, trim($request->fullname));
$email = mysqli_real_escape_string($connection, trim($request->email));
$account = mysqli_real_escape_string($connection, trim($request->account));
$supervisor = mysqli_real_escape_string($connection, trim($request->supervisor));

$dates =  $request->selectedDays;
$status = $request ->status;
$le=count($dates);
for($i=0;$i<$le;$i++){
    $dates[$i]=date('d-n-Y', $dates[$i]);
}
$unit=$request->unit;


$comments = mysqli_real_escape_string($connection, trim($request->comments));
$tablename = $request->table;

$query = "SELECT * FROM inits WHERE unit = '$tablename' ";
$result = mysqli_query( $connection, $query );
if ( !$result ) {
	die( "Database query failed" );
} else {
	while ( $row = mysqli_fetch_assoc( $result ) ) {
		$secondEmail= $row[ 'emailOne' ];
		$thirdEmail= $row[ 'emailTwo' ];
        $message=$row['message'];
	}
}
        $le=count($dates);
     
    for($i=0;$i<$le;$i++){
      $query = "INSERT INTO $tablename (";
      $query .= "status,fullName,email,account,";
      $query .= "supervisor, date, comments";
      $query .= ") VALUES (";
      $query .= "'${status[$i]}','${fullName}','${email}', '${account}',";
      $query .= "'${supervisor}','${dates[$i]}','${comments}' ";
      $query .= ")";
      $result = (mysqli_query($connection, $query));
  } 
    // send regular instrument email

        for($i=0;$i<$le;$i++){
            if($status[$i]== 0){
               $append ='AM'; 
            }else if($status[$i] == 1){
                $append='AMPM';
            }else{
                $append = 'PM';
            }
        $dates[$i]= $dates[$i].'('. $append. ')';
}
        mysqli_close($connection);
        $datesImpl= implode(", ", $dates);
        require "emailItems/emailitem.php";
        $message =sendMail($fullName,$account,$email,$secondEmail,$thirdEmail,$html);
    
echo $message;


?>