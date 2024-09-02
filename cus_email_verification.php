<?php
	// Importing DBConfig.php file.
    include 'dbconnect.php';
     function send_sms($mobno,$msg)
   	{
         //For testing
        //echo $msg;
	    $user_id = 'nmch-igiver';
	    $password = 'igiver12';
	    $sendid = 'iGIVER';
	    //$msg="Thank you for initiating order with order: $orderid";		  
	    // $url="http://hpsms.nimbuschennai.com:8080/sendsms/bulksms?username=".$user_id."&password=".$password."&type=0&dlr=1&destination=".$mobno."&source=iGIVER&message=".urlencode($msg).""; 
$url="http://103.16.101.52/sendsms/bulksms?username=nmch-igiver&password=igiver12&type=0&dlr=1&destination=".$mobno."&source=iGIVER&message=".urlencode($msg)."&entityid=1201159477885387789&tempid=1207162410559457458";

		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$response = curl_exec($ch); 
		curl_close($ch);
        return $response;
    }
    
    $cus_id = $_POST['cus_id'];
    
    // If 'SAVE' value posted 
    if($_POST['save'] == 'save')
    {  
        $otp=$_POST['otp']; 
        $sql = "Select * from customer where cus_id ='".$cus_id."' AND otp ='".$otp."'";
        //echo $sql;
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result) > 0){
            
            //Update Verfication status 
            $que = "UPDATE customer SET verification_status='1' WHERE cus_id='".$cus_id."'";
            //echo $que;
            $res = mysqli_query($con,$que);
           $update_status= 1;
        }else {
           $update_status= 0;
        }   
        
         $json['success'] = $update_status;
       // $status[] =array('sql'=>$sql,'status:save'=>$update_status);
       // print_r(json_encode($status));
    } 
    
    // If 'resend' value posted 
    elseif($_POST['resend'] = 'resend')
     {
            $rotp=rand(1000, 9999);
            $query = "UPDATE customer SET otp='".$rotp."' WHERE cus_id='".$cus_id."'";
            //echo $query."</BR>";
            $results = mysqli_query($con,$query);

            $sql1 = "Select * from customer where cus_id ='".$cus_id."'";
            $rest = mysqli_query($con, $sql1);
            if(mysqli_num_rows($rest) > 0){
                while ($row=mysqli_fetch_row($rest))
                    {
                        $name = $row[2];
                        $email = $row[3];
                        $cus_phone=$row[4];
                    }
            }
            
                // $smsmsg="Thank you. To complete the registration enter your OTP : $rotp";		  
        	$smsmsg="Dear user Welcome to iGiver.Org Your OTP for iGiver registration is ".  $rotp." Do not share this OTP. Visit iGiver.org for support.";	  
 send_sms($cus_phone,$smsmsg);
                
                if($email=='')
                {
                    
                    $email='info@igiver.org';
                    
                }
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
    				$mail->AddAddress($email); // recipients email
    				$mail->From = 'LJR1DE7OBF3U%2@#';
    				$mail->FromName = 'NGO'; // readable name
    				$mail->Subject =='OTP';    
    				$message='Your Resend OTP : '.$rotp.'';
    				$headContent="Email Verification Resend OTP"; //header
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
                    $list = array('otp' => $rotp, 'success' => 1);
                    $json = $list;
                   // $update_status=1;
                    
                    } else{
                       $json['success'] = 0;
                       //$update_status=0;
                    
                    }	
                
                 //$status[] =array('sql'=>$query,'status:resend'=>$update_status,'otp'=>$rotp);
                //print_r(json_encode($status));
     }
     
     // Response 
    
	echo json_encode($json);
	mysqli_close($con);
?>