<?php
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: *");
	// Importing DBConfig.php file.
    include '../dbconnect.php';
	include 'instamojo_utilities.php'; 
	
	function generateRandomString($length = 6)
	{
    	$characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    function send_email($orderid,$orderdetailarray)
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
		$mail->Username = "info@igiver.org";
		$mail->Password = "LJR1DE7OBF3U%2@#"; 
		$mail->SMTPSecure = 'tls';
		$mail->IsHTML(true); // if you are going to send HTML formatted emails
		$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.
		$mail->AddAddress('info@igiver.org'); // recipients email
		$mail->AddCC('raghav@lokas.in'); // recipients email
		$mail->From = 'info@igiver.org';
		$mail->FromName = 'iGiver.Org'; // readable name
		$mail->Subject ='Order Details Initiated from iGiver.Org : '.$orderid.''; 
		$message='Order Details Initiated from iGiver.Org : '.$orderid.'';
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
				<tr><td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr><td align="left" valign="top">NGO Detail</td>
				</tr>
				<tr><td align="left" valign="top">'.$NgoDetailArray.'</td>
				</tr>
					<tr><td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr><td align="left" valign="top">Donor Detail</td>
				</tr>
				<tr><td align="left" valign="top">'.$DonorDetailArray.'</td>
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
    
  
    // Optionally, you can give it a desired string length.
    $retail_code=$_GET['retail_code'];
    $rand = generateRandomString();
    $orderid=$retail_code.$rand;
    
    //echo $orderid;
    //printf("Result %d ", $orderid);
    //Check if this gen orderid exists
    //Verify authcode
    $sql1 = "SELECT id FROM `donor_retail_orders` WHERE orderid='".$orderid."'";
    
    $res1 = mysqli_query($con,$sql1);
    $row_cnt=$res->num_rows;
    //printf("Result set has %d rows.\n", $row_cnt);
    
    if($row_cnt>0)//ID exists, exit with code 0
    {
        	$json['orderid'] = 0;
	        echo json_encode($json);
	        exit();
    }
    else //Proceed with insert
    {
        $order_desc=$_GET['order_desc'];
        $order_desc=$_GET['order_desc'];
        $order_amount=$_GET['order_amount'];
        $order_qty=$_GET['order_qty'];
        $order_sku=$_GET['order_sku'];
        $ngoid=$_GET['ngoid'];
        $donorid=$_GET['donorid'];
        // $orderdate=date('y-m-d');
         $orderdate=$_GET['datestr'];
        $order_source= $_GET['ordersource']?$_GET['ordersource']:1;
        $overall_status=1;
        $paystatus=0;
        //$order_status=0;
        $pay_ref_no=0;
        $delivery_ref_no=0;
        $flag=0;
        $thanks_video_status=0;
        $thanks_video_link='';
        $createdate=date('y-m-d');
        $updatedate=date('y-m-d');
         $productid=$_GET['productid'];
         $returnUrl = $_GET['returnUrl'];
        
        $sqlInsert ="INSERT INTO `donor_retail_orders`( `retail_code`,`orderid`, `order_desc`, `order_amount`, `order_qty`, `order_sku`, `ngoid`, `donorid`, `orderdate`, `order_source`, `overall_status`, `paystatus`, `pay_ref_no`, `delivery_ref_no`, `flag`, `thanks_video_status`, `thanks_video_link`, `createdate`, `updatedate`, `product_id`) VALUES ('$retail_code','$orderid',
        '$order_desc','$order_amount','$order_qty','$order_sku','$ngoid','$donorid','$orderdate','$order_source','$overall_status','$paystatus','$pay_ref_no','$delivery_ref_no','$flag','$thanks_video_status','$thanks_video_link','$createdate','$updatedate','$productid')";
        
        // echo $sqlInsert;

        $resultInstert=mysqli_query($con,$sqlInsert);
        //echo $resultInstert;
        //exit;
        
        
        
        
        //If Instamojo PG return Instamojo orderid
        $sqlpayway = "SELECT payment_gateway FROM `retail_vendor` WHERE retail_code='".$retail_code."'";
        //echo $sqlpayway;
        $respayway= mysqli_query($con,$sqlpayway);
        
        if($respayway)
        {
        	$row = mysqli_fetch_array($respayway);
        	$payway=$row[0];
        	//echo $payway;
        	if($payway='INST')
        	{
        	     // $im_orderid =get_imjo_create_order($orderid,$retail_code,$con);
        	     
        	      $im_orderid = get_imjo_create_pay_request($orderid,$retail_code,$con,$returnUrl);
                 
        	   // print_r($im_orderid);
        	}
        	
            
        }
        
        //For testing
        $mob = '8667054876';
	    $user_id = 'nmch-igiver';
	    $password = 'igiver12';
	    $sendid = 'iGIVER';
	    $msg="Thank you for initiating order with order: $orderid";		  
	    $url="http://hpsms.nimbuschennai.com:8080/sendsms/bulksms?username=".$user_id."&password=".$password."&type=0&dlr=1&destination=".$mob."&source=iGIVER&message=".urlencode($msg).""; 
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$response = curl_exec($ch); 
		curl_close($ch);
        
        
       
       
        
        
        // echo json_encode($orderid);
         //$json['orderid'] = $orderid;
         $order_info[] =array('order_id'=>$orderid,'insta_order_info'=>$im_orderid);
        
         //Sending email
        // send_email($orderid,json_encode($order_info));
        
        print_r(json_encode($order_info));
         
         //echo json_encode($json);
         //echo $im_orderid;
	    mysqli_close($con);
    }

    
   
    		       

?>