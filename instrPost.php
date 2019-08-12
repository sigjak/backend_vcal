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

$status = 1;
$fullName = mysqli_real_escape_string($connection, trim($request->fullname));
$email = mysqli_real_escape_string($connection, trim($request->email));
$account = mysqli_real_escape_string($connection, trim($request->account));
$supervisor = mysqli_real_escape_string($connection, trim($request->supervisor));

$dates =  $request->selectedDays;

$le=count($dates);
for($i=0;$i<$le;$i++){
    $dates[$i]=date('d-n-Y', $dates[$i]);
}
$unit=$request->unit;
$slide27=$request->slide27;
$slide27coated=$request->slide27Coated;
$oneround=$request->oneRound;
$onepolished=$request->onePolished;
$mountcoated=$request->mountCoated;
$oneseven=$request->oneSeven;
$carbon=$request->carbon;
$repolish=$request->repolish;

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

if($tablename == 'thin_sections'){
    foreach ($dates as $date) {
      $query = "INSERT INTO $tablename (";
      $query .= "status,fullName,email,account,";
      $query .= "supervisor, date, comments,";
         $query .= "slide27, slide27coated,oneround,onepolished,";
        $query .= " mountcoated, oneseven, carbon, repolish";
      $query .= ") VALUES (";
      $query .= "'${status}','${fullName}','${email}', '${account}',";
      $query .= "'${supervisor}','${date}','${comments}',";
      $query .= "'${slide27}','${slide27coated}','${oneround}','${onepolished}',";
      $query .= "'${mountcoated}','${oneseven}','${carbon}','${repolish}'";
      $query .= ")";
      $result = (mysqli_query($connection, $query));
    }
    // send thin section email
        mysqli_close($connection);
        $datesImpl= implode(", ", $dates);
        require "emailItems/emailitemThin.php";
    sendMail($fullName,$account,$email,$secondEmail,$thirdEmail,$html);
    
}else{
      foreach ($dates as $date) {
      $query = "INSERT INTO $tablename (";
      $query .= "status,fullName,email,account,";
      $query .= "supervisor, date, comments";
      $query .= ") VALUES (";
      $query .= "'${status}','${fullName}','${email}', '${account}',";
      $query .= "'${supervisor}','${date}','${comments}' ";
      $query .= ")";
      $result = (mysqli_query($connection, $query));
  } 
    // send regular instrument email
        mysqli_close($connection);
        $datesImpl= implode(", ", $dates);
        require "emailItems/emailitem.php";
      $message =  sendMail($fullName,$account,$email,$secondEmail,$thirdEmail,$html);
	echo $message;
    
}


?>