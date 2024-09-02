<?php
	// Importing DBConfig.php file.
    include 'dbconnect.php';
	 
	
   

	$cusEmail = $_POST['cusEmail'];
	//get email from db

	$cusPwd='';
//	$cusEmail='contact.raghav@gmail.com';
//	$cus_pwd='googly01'
	$sql = "select cus_cpwd from customer where cus_email='".$cusEmail."'"; 
	
    $res = mysqli_query($con,$sql);
    $result = array();
    $row = mysqli_fetch_array($res);
    $cusPwd = $row[0];
       
    //Mail function
    require("PHPMailer/class.phpmailer.php");
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
	$mail->AddAddress($cusEmail); // recipients email
	$mail->From = 'info@igiver.org';
	$mail->FromName = 'iGiver Support'; // readable name
	$mail->Subject ='Forget Password Assitance';    
	$message='Your  Password : '.$cusPwd.'';
	$headContent="Forget Password Assitance"; //header
	$mail->Body .='    
	<table cellpadding="0" cellspacing="0" border="0">            
		<tbody>
		<tr><td align="left" valign="top">            
		<table cellpadding="0" cellspacing="0" border="0">
		<tbody>            
		<tr><td align="left" valign="top"></td></tr>
		<tr>
		<td style="font:bold;">Dear User, Welcome to iGiver.Org . </td></tr>
		<tr><td align="left" valign="top">'.$message.' </td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		</tbody>
		</table>
	';  
    // Sending email
    if($mail->send()){
       	$json['success'] = 1;
    } else{
       	$json['success'] = 0;
    }
     
	echo json_encode($json);
	mysqli_close($con);
?>