<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
    require "PHPmailer/src/PHPMailer.php";
    require "PHPmailer/src/Exception.php";
    require "PHPmailer/src/SMTP.php";
   

function sendMail($fullName,$account,$email,$secondemail,$thirdemail,$html){
    $mail = new PHPMailer(true);                              
    try {   
        $mail->CharSet="UTF-8";
        $mail->isSMTP();                                     
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;                              
        $mail->Username = 'reserveies@gmail.com';                 
        $mail->Password = 'magnetite';                           
        $mail->SMTPSecure = 'ssl';                           
        $mail->Port = 465;                                    
        //Recipients
        $mail->setFrom('reserveies@gmail.com', ' NO REPLY - IES Reservations');
        $mail->addAddress($email);     // Add a recipient
        $mail->addAddress($secondemail); // Add another recipient
        if(!empty($thirdemail)){
         $mail->addAddress($thirdemail); 
        }
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'IES Reservations -- NO REPLY';
      $mail->Body    = $html;


        $mail->send();
      echo ( 'sent');
    } catch (Exception $e) {
        return json_encode ('error');
    }
}