<?php
	// Importing DBConfig.php file.
    include '../../dbconnect.php';

  
    
    function send_email($orderdetailarray,$campid,$retail_code)
    {
        //Mail function
       
       
		require("../../PHPMailer/class.phpmailer.php");
		$mail = new PHPMailer();
        $mail->SMTPDebug = 2;                                      
        $mail->isSMTP();                                           
        $mail->Host       = 'email-smtp.us-east-1.amazonaws.com;';                   
        $mail->SMTPAuth   = true;                            
        $mail->Username   = 'AKIA3SRZ6SZEQU7SFROB';                
        $mail->Password   = 'BDwWdrPOI+ytHkV5FvrMkhU0mUaECQZd4GTHg/SMAAN8';                       
        $mail->SMTPSecure = 'tls';                             
        $mail->Port       = 587; 
		
		$mail->SMTPSecure = 'tls';
		$mail->IsHTML(true); // if you are going to send HTML formatted emails
		$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.
		$mail->AddAddress('support@lokas.in'); // recipients email
		$mail->AddCC('raghav@lokas.in'); // recipients email
        $mail->AddCC('sowjanya@lokas.in'); // recipients email
		$mail->From = 'info@igiver.org';
		$mail->FromName = 'iGiver.Org'; // readable name
		$mail->Subject ='Webhook From' .$campid.' And Retail Code '.$retail_code; ; 
		$message='Order Details Payment Status from iGiver.Org  ';
		$headContent="Order Initiated from iGiver.Org"; //header
		$mail->Body .='    
			<table cellpadding="0" cellspacing="0" border="0">            
				<tbody>
				<tr><td align="left" valign="top">            
				<table cellpadding="0" cellspacing="0" border="0">
				<tbody>            
				<tr><td align="left" valign="top"></td></tr>
				<tr>
				<td style="font:bold;">Dear Retail Partner, Order Initiated from iGiver.Org  </td></tr>
				<tr><td align="left" valign="top">'.$message.'</td>
				</tr>
				<tr><td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr><td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr><td align="left" valign="top">Order Detail</td>
				</tr>
				<tr><td align="left" valign="top">'.$orderdetailarray.'</td>
				</tr>
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
    
    
       // echo htmlspecialchars($_GET["cid"]);
       
     //  $filename=basename($_SERVER['PHP_SELF'], '.php'); // e.g., 'test'
     // print_r(explode('_',$filename));
      //  exit;
        $data = $_POST;
        $mac_provided = $data['mac'];  // Get the MAC from the POST data
        unset($data['mac']);  // Remove the MAC key from the data.
        
        
        $orderid=$data['purpose'];//amount
        //echo $orderid;
        
        
        $ver = explode('.', phpversion());
        $major = (int) $ver[0];
        $minor = (int) $ver[1];
        
        if($major >= 5 and $minor >= 4){
             ksort($data, SORT_STRING | SORT_FLAG_CASE);
        }
        else{
             uksort($data, 'strcasecmp');
        }
        
        // You can get the 'salt' from Instamojo's developers page(make sure to log in first): https://www.instamojo.com/developers
        // Pass the 'salt' without the <>.
        $mac_calculated = hash_hmac("sha1", implode("|", $data), "57d1d59c72e9478fb06dff039dfac2ea");
        
        //For now testing
        $mac_provided=$mac_calculated;
        
        if($mac_provided == $mac_calculated)
        {
            //echo "MAC is fine";
            // Do something here
            
        }
        else{
            //echo "Invalid MAC passed";
            $errormsg="Invalid MAC passed";
        }
        
        
        
        //Record creating in payment_record table
        
        
         $paymentid= $data['payment_id'];
	     $retail_code="APL";
	     $campid="22";
	     
	     //Send mail to igiver support
         send_email(json_encode($_POST),$campid,$retail_code);
         
	      $curl = curl_init();
          curl_setopt_array($curl, array(
              
          CURLOPT_URL => 'https://api.igiver.org/v1/donorreatilorders/get_insta_webwookfile_common.php?paymentid='.$paymentid.'&campid='.$campid.'&retail_code='.$retail_code,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        echo $response;
   
     

?>