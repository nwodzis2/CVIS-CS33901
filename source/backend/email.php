<?php


include("../Libraries/PHPMailer/PHPMailer.php");
include("../Libraries/PHPMailer/SMTP.php");

function email($address, $subject, $body){

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP(); 
    
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'ssl'; 
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    
    //sender email address and password.
    //must turn on "less secure app access" on sender account.
    $mail->Username = "sender email address";
    $mail->Password = "password";
    $mail->SetFrom("sender email address");
    
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($address);
    
     if(!$mail->Send()) {
         echo "email failed to send";
     }
     
}

    

?>