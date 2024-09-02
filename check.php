<?php



require("PHPMailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = "smtp.madrascricketclub.org"; 
		$mail->Port = 465;
		$mail->SMTPDebug = 2; 

	    // used only when SMTP requires authentication   
		$mail->SMTPAuth = true;		
		$mail->Username = "social@madrascricketclub.org";
		$mail->Password = "m%b9mL082"; 
//$mail->Username = "info@igiver.org";
//		$mail->Password = "LJR1DE7OBF3U%2@#"; 
		$mail->SMTPSecure = 'tls';
		$mail->IsHTML(true); // if you are going to send HTML formatted emails
		$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.
		$mail->AddAddress('sowjanya@lokas.in'); // recipients email
	   // $mail->AddCC('support@lokas.in'); // recipients email
		$mail->From = 'social@madrascricketclub.org';
		$mail->FromName = 'MCC'; // readable name
		$mail->Subject ='Test';  
		
		


    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
   
//echo 'Message between';
    if(!$mail->Send()) 
{
  echo 'Message was not sent.';
  echo 'Mailer error: ' . $mail->ErrorInfo;
} 
else {
  echo 'Message has been sent.';
}
    
   


?>