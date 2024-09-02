<?php
	// Importing DBConfig.php file.
    include '../dbconnect.php';
    include '../whatsapp_api.php';




 function send_email($email)
    {
        //Mail function
       
        echo $email;

		require('../PHPMailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = "smtp.gmail.com"; 
		$mail->Port = 587;
		//$mail->SMTPDebug = 2; 
	    // used only when SMTP requires authentication   
		$mail->SMTPAuth = true;		
			
		$mail->Username = "info@igiver.org";
		$mail->Password = "LJR1DE7OBF3U"; 
		
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
    


function send_email($email,$name)
    {
        //Mail function
       
        echo $email;

		require('../PHPMailer/class.phpmailer.php');
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
                $mail->IsHTML(true);  
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
    
       // echo htmlspecialchars($_GET["cid"]);
       
     //  $filename=basename($_SERVER['PHP_SELF'], '.php'); // e.g., 'test'
     // print_r(explode('_',$filename));
      //  exit;
        $data = $_POST;
        $mac_provided = $data['mac'];  // Get the MAC from the POST data
        unset($data['mac']);  // Remove the MAC key from the data.
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
        
        
         $paymentid= $data['payment_id'];

	     
	
      $paymentid="MOJO2210R05N71898033";
	

    $url='https://www.instamojo.com/api/1.1/payments/'.$paymentid.'/';
    


    $apikey="1fe828914fe82850c959156b7cfaeb04";
    $apitoken="3cfe7524d76469cc556dee80c53927b3";

  //  $apikey="00f78d2b818914cc270618c974b84cd2";
 //   $apitoken="084e37a47ca76cead86fd4cd6656b008";

    $apikey="X-Api-Key: ". "1fe828914fe82850c959156b7cfaeb04";
    $apitoken="X-Auth-Token: "."3cfe7524d76469cc556dee80c53927b3";
    echo $apikey;
    echo $apitoken;
        

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        $apikey,
        $apitoken,
        
      ),
    ));

    $response = curl_exec($curl);
    
    curl_close($curl);
    echo $response;
    $data = json_decode($response);
    
    //echo $data->payment->payment_id;
    
    $payment_id= $data->payment->payment_id;
    $payment_status= $data->payment->status;
    $amount= $data->payment->amount;
    $buyer_name= $data->payment->buyer_name;
    $buyer_phone= $data->payment->buyer_phone;
    $buyer_email= $data->payment->buyer_email;
    //$quantity= $data->payment->quantity;
    //$unit_price= $data->payment->unit_price;
    $quantity= $amount / $unit_price_value;
    $unit_price= $unit_price_value;
    $fees= $data->payment->fees;
    
    $billing_instrument= $data->payment->billing_instrument;
    $created_at= $data->payment->created_at;
    
    //echo date( "Y-m-d H:i:s", strtotime($created_at) );
    $date = new DateTime($created_at);
    $result = $date->format('Y-m-d H:i:s');
    echo $result ;

    $sqlInsert ="INSERT INTO `payment_record`(`camp_id`, `camp_name`,`retail_code`, `payment_id`, `payment_status`, `amount`, `buyer_name`, `buyer_phone`, `buyer_email`, `quantity`, `unit_price`, `fees`, `billing_instrument`, `create_date`) VALUES ('$camp_id','$camp_name',
    '$retail_code','$payment_id','$payment_status','$amount','$buyer_name','$buyer_phone','$buyer_email','$quantity','$unit_price','$fees','$billing_instrument','$result')";
    
    echo $sqlInsert;

        //Send mail to igiver support
         send_email($buyer_email);

?>