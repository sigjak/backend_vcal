<?php
$html = <<<EOT
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Reservations </title>

</head>
<body>

  <table  width="500" style=" border: 1px solid grey;border-radius:5px;  margin-top:20px;"  align="center" cellspacing="0" bgcolor="#E9E9E9"  >
    <tbody >
      <tr >
        <td colspan="2" ><h2 style="color: #0E618C;text-align:center;margin-bottom:0; border-radius:20px;">IES RESERVATIONS</h2></td>
      </tr>
      <tr bgcolor="#E9E9E9">
        <td colspan="2" style="border-bottom: 2px solid" ><h3 style="color: #0E618C; text-align:center;margin-top: 0;">$unit</h3></td>
      </tr>
      <tr>
        <td bgcolor="#fff" style="padding-left:30px;  padding-top:10px;"> Name:</td>
        <td bgcolor="#fff" style="padding-top:10px;" >$fullName</td>
      </tr>
      <tr>
        <td bgcolor="#fff" style="padding-left:30px; " >Email:</td>
        <td bgcolor="#fff">$email</td>
      </tr>
      <tr>
        <td bgcolor="#fff" style="padding-left:30px; " >Account:</td>
        <td bgcolor="#fff">$account</td>
      </tr>
      <tr>
        <td bgcolor="#fff" style="padding-left:30px; " >Supervisor:</td>
        <td bgcolor="#fff">$supervisor</td>
      </tr>
      <tr>
        <td bgcolor="#fff" style="padding-left:30px;width:190px " >Dates [DMY]:</td>
        <td bgcolor="#fff" width="270px">$datesImpl</td>
      </tr>
		
      <tr>
        <td bgcolor="#fff" style="padding-left:30px; width:190px " >Comments:</td>
        <td  style="margin-bottom:10px;" bgcolor="#fff" width="270px">$comments</td>
      </tr>
    
		
      <tr>
         <td colspan="2" style="color:#B75408;  border-top: 1px solid; padding:5px 0px 5px 30px;">$message</td>
      </tr>
    </tbody>
  </table>

</body>
</html>
EOT;
?>