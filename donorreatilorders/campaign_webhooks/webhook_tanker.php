<?php
// 	// Importing DBConfig.php file.
//     include '../dbconnect.php';
//     include '../whatsapp_api.php';




 function send_email($email)
    {
        //Mail function
       
        echo $email;
        // $email="sowjanyamca1988@gmail.com";
		require('../../PHPMailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = "smtp.gmail.com"; 
		$mail->Port = 587;
		//$mail->SMTPDebug = 2; 
	    // used only when SMTP requires authentication   
		$mail->SMTPAuth = true;		
			
		$mail->Username = "info@igiver.org";
		$mail->Password = "LJR1DE7OBF3U%2@#"; 
		
		$mail->SMTPSecure = 'tls';
		$mail->IsHTML(true); // if you are going to send HTML formatted emails
		$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.
		$mail->AddAddress($email); // recipients email
		$mail->AddCC('raghav@lokas.in'); // recipients email
		$mail->AddCC('sowjanya@lokas.in');
		
		$mail->From = 'info@igiver.org';
		$mail->FromName = 'iGiver.Org'; // readable name
		$mail->Subject ='Thank you note' ; 
		$message='Payment Status from iGiver.Org  ';
		$headContent="Thank you"; //header
		$mail->Body .='    
			<table cellpadding="0" cellspacing="0" border="0">            
				<tbody>
				<tr><td align="left" valign="top">            
				<table cellpadding="0" cellspacing="0" border="0">
				<tbody>            
				<tr><td align="left" valign="top"></td></tr>
				<tr>
				<td style="font:bold;">Dear donor, Thanks for your donation  </td></tr>
				
				</tbody>
				</table>
				</td>
				</tr>
				</tbody>
				</table>
			';  
        // Sending email
        if($mail->send())
        {
          //
        } 
        else
        {
            echo 'Unable to send email. Please try again.';
        }
        
    }
    
    
   
         send_email('sowjanyamca1988@gmail.com');
     
 

?>