<?php
 
 require_once('../PHPMailer/class.phpmailer.php');
 $mail = new PHPMailer();
 
try {
    $mail->SMTPDebug = 2;                                      
    $mail->isSMTP();                                           
    $mail->Host       = 'email-smtp.us-east-1.amazonaws.com;';                   
    $mail->SMTPAuth   = true;                            
    $mail->Username   = 'AKIA3SRZ6SZEQU7SFROB';                
    $mail->Password   = 'BDwWdrPOI+ytHkV5FvrMkhU0mUaECQZd4GTHg/SMAAN8';                       
    $mail->SMTPSecure = 'tls';                             
    $mail->Port       = 587; 
 
    $mail->setFrom('info@igiver.org', 'IGIVER');          
    $mail->addAddress('sowjanyamca1988@gmail.com');
    // $mail->addAddress('receiver2@gfg.com', 'Name');
      
    $mail->isHTML(true);                                 
    $mail->Subject = 'Subject';
    $mail->Body    = 'HTML message body in <b>bold</b> ';
    $mail->AltBody = 'Body in plain text for non-HTML mail clients';
    $mail->send();
    echo "Mail has been sent successfully!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
 
?>