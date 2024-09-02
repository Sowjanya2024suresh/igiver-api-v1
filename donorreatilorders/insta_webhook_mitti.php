<?php
	// Importing DBConfig.php file.
    include '../dbconnect.php';
    
   
    
    function send_email($orderdetailarray)
    {
        //Mail function
       
       
		require("../PHPMailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = "smtp.gmail.com"; 
		$mail->Port = 587;
		//$mail->SMTPDebug = 2; 
	    // used only when SMTP requires authentication   
		$mail->SMTPAuth = true;		
		$mail->Username = "support@lokas.in";
		$mail->Password = "LokasG@2020"; 
		$mail->SMTPSecure = 'tls';
		$mail->IsHTML(true); // if you are going to send HTML formatted emails
		$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.
		$mail->AddAddress('support@lokas.in'); // recipients email
		$mail->AddCC('raghav@lokas.in'); // recipients email
		$mail->From = 'info@igiver.org';
		$mail->FromName = 'iGiver.Org'; // readable name
		$mail->Subject ='Webhook From Ambika Rice Campaign'; 
		$message='Order Details Payment Status from iGiver.Org  ';
		$headContent="'Order Initiated from iGiver.Org"; //header
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
           
               //Send mail to igiver support
                send_email(json_encode($_POST));
               
            
           
            
        }
        else{
            //echo "Invalid MAC passed";
            $errormsg="Invalid MAC passed";
        }
        
        
        
        //Record creating in payment_record table
        
        
         $paymentid= $data['payment_id'];
//$paymentid='MOJO1628K05D25747259';
    // $paymentid='MOJO1617A05D63433086';
    $url='https://www.instamojo.com/api/1.1/payments/'.$paymentid.'/';
    // echo $url;
// echo $paymentid;
$retail_code='MCF';
$camp_id='2';
$camp_name='giveonemeal';
$apikey='';
$apitoken='';
$sqlxapi = "SELECT x_api_key,x_auth_token FROM `retail_vendor` WHERE retail_code='".$retail_code."'";
//echo $sqlxapi;
 $res = mysqli_query($con,$sqlxapi);
        	if($res)
        {
          while( $row1 = mysqli_fetch_array($res))
          {
            $apikey="X-Api-Key: ". $row1[0];
            $apitoken="X-Auth-Token: ".$row1[1];
          }
        }

// $sql = "SELECT id,campaign_name,retail_vendor,campaign_desc FROM `focus_campaigns` WHERE active='1'";
//         // echo $sql;
//         $respayway = mysqli_query($con,$sql);
//         // echo $respayway;
//         if($respayway)
//         {
//             while($row = mysqli_fetch_array($respayway))
//         	{
//         // 	$row = mysqli_fetch_array($respayway);
//         	$camp_id=$row[0];
//         	$camp_name=$row[1];
//         	$retail_code=$row[2];
//         	}
        
// $sqlxapi = "SELECT x_api_key,x_auth_token FROM `retail_vendor` WHERE retail_code='".$retail_code."'";
// echo $sqlxapi;
//  $res = mysqli_query($con,$sqlxapi);
//         	if($res)
//         {
//           while( $row1 = mysqli_fetch_array($res))
//           {
//             $apikey="X-Api-Key: ". $row1[0];
//             $apitoken="X-Auth-Token: ".$row1[1];
//           }
//         }
            
//         }
        
        
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

 echo $data->payment->payment_id;

$payment_id= $data->payment->payment_id;
$payment_status= $data->payment->status;
$amount= $data->payment->amount;
$buyer_name= $data->payment->buyer_name;
$buyer_phone= $data->payment->buyer_phone;
$buyer_email= $data->payment->buyer_email;
$quantity= $data->payment->quantity;
$unit_price= $data->payment->unit_price;
$fees= $data->payment->fees;

$billing_instrument= $data->payment->billing_instrument;
$created_at= $data->payment->created_at;





       $sqlInsert ="INSERT INTO `payment_record`(`camp_id`, `camp_name`,`retail_code`, `payment_id`, `payment_status`, `amount`, `buyer_name`, `buyer_phone`, `buyer_email`, `quantity`, `unit_price`, `fees`, `billing_instrument`, `create_date`) VALUES ('$camp_id','$camp_name',
        '$retail_code','$payment_id','$payment_status','$amount','$buyer_name','$buyer_phone','$buyer_email','$quantity','$unit_price','$fees','$billing_instrument','$created_at')";
        
         echo $sqlInsert;

        $resultInstert=mysqli_query($con,$sqlInsert);
        
     

?>