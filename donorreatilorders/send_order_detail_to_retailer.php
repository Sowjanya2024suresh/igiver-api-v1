<?php
    //ob_start();
 
	// Importing DBConfig.php file.
    include '../dbconnect.php';
    // echo "Please wait.......";
   //$retail_code='';
    $samplejson="{\r\n    \"set_paid\": false,\r\n    \"currency\": \"INR\",\r\n    \"billing\": {\r\n        \"first_name\": \"DON_NAME\",\r\n        \"last_name\": \"DON_NAME\",\r\n        \"address_1\": \"Temp\",\r\n        \"address_2\": \"\",\r\n        \"city\": \"Chennai\",\r\n        \"state\": \"Tamilnadu\",\r\n        \"postcode\": \"600011\",\r\n        \"country\": \"IN\",\r\n        \"email\": \"DON_EMAIL\",\r\n        \"phone\": \"DON_MOBILE\"\r\n    },\r\n    \"shipping\": {\r\n        \"first_name\": \"NGO_NAME\",\r\n        \"last_name\": \"NGO_CONTACT_NAME\",\r\n        \"address_1\": \"NGO_ADDRESS\",\r\n        \"address_2\": \"NGO_MOBILE\",\r\n        \"city\": \"Temp\",\r\n        \"state\": \"Temp\",\r\n        \"postcode\": \"600011\",\r\n        \"country\": \"IN\"\r\n    },\r\n    \"line_items\": [\r\n        {\r\n            \"product_id\": SKU_ID,\r\n            \"quantity\": 1\r\n            \r\n        }\r\n    ],\r\n    \"shipping_lines\": [\r\n        {\r\n            \"method_id\": \"free_shipping\",\r\n            \"method_title\": \"Free shipping\",\r\n            \"total\": \"0.00\"\r\n        }\r\n    ],\r\n    \"meta_data\": [\r\n        {\r\n            \"key\": \"order_taken_from\",\r\n            \"value\": \"iGiver\"\r\n        },\r\n        {\r\n            \"key\": \"auth_code\",\r\n            \"value\": \"1234567890\"\r\n        }\r\n    ]\r\n}";
     $jayParsedAry = [
                   "set_paid" => false, 
                   "currency" => "INR", 
                   "billing" => [
                         "first_name" => "DON_NAME", 
                         "last_name" => "", 
                         "address_1" => "Temp", 
                         "address_2" => "", 
                         "city" => "", 
                         "state" => "", 
                         "postcode" => "", 
                         "country" => "IN", 
                         "email" => "sowjanyamca1988@gmail.com", 
                         "phone" => "9841200531" 
                      ], 
                   "shipping" => [
                            "first_name" => "Abode of joy", 
                            "last_name" => "Rajakumari", 
                            "address_1" => "No. 11 5th Street Kabali Nagar Athanoor Road Guduvanchery Chengalpattu Kanchipuram - 603001 Landmark NEAR Guduvanchery Railway Station ", 
                            "address_2" => "9176200203", 
                            "city" => "", 
                            "state" => "", 
                            "postcode" => "", 
                            "country" => "IN" 
                         ], 
                   "line_items" => [
                               [
                                  "product_id" => 0000, 
                                  "quantity" => 1 
                               ] 
                            ], 
                   "shipping_lines" => [
                                     [
                                        "method_id" => "free_shipping", 
                                        "method_title" => "Free shipping", 
                                        "total" => "0.00" 
                                     ] 
                                  ], 
                   "meta_data" => [
                                           [
                                              "key" => "order_taken_from", 
                                              "value" => "iGiver" 
                                           ], 
                                           [
                                              "key" => "auth_code", 
                                              "value" => "1234567890" 
                                              ],
                                            [
                                              "key" => "_shipping_phone", 
                                              "value" => "1234567890" 
                                              ] 
                                        ] 
                ];      
    
    function update_ack_orderid_igiverdb($ack_orderid,$igiver_orderid,$con)
   	{
   	    $sql="UPDATE `donor_retail_orders` SET `pay_ref_no`='$ack_orderid' WHERE orderid='$igiver_orderid'";
        //echo $sql;
          
        $err_code='';
        // Perform a query, check for error
        if (!mysqli_query($con,$sql)) {
            $err_code=mysqli_errno($con);
         //echo("Errorcode: " .$err_code );
        }
   	    
   	}
	 
	function send_email($toemail,$orderid,$orderdetailarray,$NgoDetailArray,$DonorDetailArray)
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
		$mail->AddAddress($toemail); // recipients email
	    $mail->AddCC('raghav@lokas.in'); // recipients email
		$mail->From = 'info@igiver.org';
		$mail->FromName = 'iGiver.Org'; // readable name
		$mail->Subject ='Order Initiated from iGiver.Org ';    
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
	 
	 
	 
	function call_ack_server($jsonfilled,$orderid,$con)
    {
       //var_dump($jsonfilled);exit;
       // Creating a variable to store the 
        // server address 
        //$ip_server = $_SERVER['SERVER_ADDR']; 
          
        // Printing the stored address 
        //echo "Server IP Address is: $ip_server"; 
       //var_dump(json_encode($jsonfilled, true));
	   
       $curl = curl_init();

        curl_setopt_array($curl, array(
          //CURLOPT_URL => "https://suncartstore.in/wp-fresh/wp-json/wc/v3/orders",
          CURLOPT_URL => "https://www.amarchitrakatha.com/wp-json/wc/v3/orders",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          //CURLOPT_POSTFIELDS =>"{\r\n    \"set_paid\": false,\r\n    \"currency\": \"INR\",\r\n    \"billing\": {\r\n        \"first_name\": \"John\",\r\n        \"last_name\": \"Doe\",\r\n        \"address_1\": \"969 Market\",\r\n        \"address_2\": \"\",\r\n        \"city\": \"JAIPUR\",\r\n        \"state\": \"RAJ\",\r\n        \"postcode\": \"302001\",\r\n        \"country\": \"IN\",\r\n        \"email\": \"john.doe@example.com\",\r\n        \"phone\": \"(555) 555-5555\"\r\n    },\r\n    \"shipping\": {\r\n        \"first_name\": \"John\",\r\n        \"last_name\": \"Doe\",\r\n        \"address_1\": \"969 Market\",\r\n        \"address_2\": \"\",\r\n        \"city\": \"JAIPUR\",\r\n        \"state\": \"RAJ\",\r\n        \"postcode\": \"302001\",\r\n        \"country\": \"IN\"\r\n    },\r\n    \"line_items\": [\r\n        {\r\n            \"product_id\": 5093,\r\n            \"quantity\": 1\r\n            \r\n        }\r\n    ],\r\n    \"shipping_lines\": [\r\n        {\r\n            \"method_id\": \"free_shipping\",\r\n            \"method_title\": \"Free shipping\",\r\n            \"total\": \"0.00\"\r\n        }\r\n    ],\r\n    \"meta_data\": [\r\n        {\r\n            \"key\": \"order_taken_from\",\r\n            \"value\": \"iGiver\"\r\n        },\r\n        {\r\n            \"key\": \"auth_code\",\r\n            \"value\": \"1234567890\"\r\n        }\r\n    ]\r\n}",
          CURLOPT_POSTFIELDS =>json_encode($jsonfilled, true),
          
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic aWdpdmVyX2RldjppZ2l2ZXJfYWNrX2RldnNfMjAyMA==",
            "Content-Type: application/json"
          ),
        ));

        //var_dump(json_decode($curl, true));
        //print_r(json_decode($curl, true));
       
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        //echo "----".$response."</BR></BR>";
        //var_dump(json_decode($response, true));


        $arr = json_decode($response, true);
       


        //Update igiverdb with order ID
        update_ack_orderid_igiverdb($arr["id"],$orderid,$con);
        
       
        //echo "Order ID:".$arr["id"]."</BR>";
        //echo $arr["order_key"];
        //$CURLOPT_URL="https://suncartstore.in/wp-fresh/wp-json/wp/v2/checkouturl/".$arr["id"];     
        $CURLOPT_URL="https://www.amarchitrakatha.com/wp-json/wp/v2/checkouturl/".$arr["id"];     
        //
        
        //echo $CURLOPT_URL."</BR>";
        
        //exit;
        $curl = curl_init();

        //Call to get Checkout URL 
        curl_setopt_array($curl, array(
          CURLOPT_URL => $CURLOPT_URL,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic aWdpdmVyX2RldjppZ2l2ZXJfYWNrX2RldnNfMjAyMA=='
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        //echo $response;
        
        $arr = json_decode($response, true);
        $checkout_url=$arr["data"]["checkout_url"];
        //echo "Chkout url :".$checkout_url."</BR>";
        
        //$checkout_url="https://suncartstore.in/wp-fresh/index.php/checkout/order-pay/".$arr['id']."/?pay_for_order=true&key=".$arr['order_key'];
      // echo $checkout_url;
         // exit;
         echo "<script>";
         echo "window.location = '".$checkout_url."';";
         echo "</script>";
         header("Location:$checkout_url "); 
        exit();
        
       
       

    }
    
    
    $orderid=$_GET['orderid'];
    //echo $orderid."</BR>";
   
    //Check if this gen orderid exists
    //Order Details
    $sql1 = "SELECT  `orderid`, `order_desc`, `order_amount`, `order_qty`, `order_sku`, `ngoid`, `donorid`, `orderdate`, `order_source`, `overall_status`, `paystatus`, `pay_ref_no`, `delivery_ref_no`, `flag`, `thanks_video_status`, `thanks_video_link`, `createdate`, `updatedate` ,`retail_code` FROM `donor_retail_orders` WHERE orderid='".$orderid."'";
    //echo $sql1;
    $resorderdetail = mysqli_query($con,$sql1);
    
     if($resorderdetail)
    {
    	while($row = mysqli_fetch_array($resorderdetail))
    	{
    		$NGOid=$row['ngoid'];
    		$donorid=$row['donorid'];
    		$retail_code=$row['retail_code'];
    		$order_sku=$row['order_sku'];
            $orderdetailarray[] =array('orderid'=>$row[0],'order_desc'=>$row[1],'order_amount'=>$row[2],'order_qty'=>$row[3],'order_sku'=>$row[4],'ngoid'=>$row[5],'donorid'=>$row[6],'orderdate'=>$row[7],'order_source'=>$row[8],'overall_status'=>$row[9],'paystatus'=>$row[10],'pay_ref_no'=>$row[11],'delivery_ref_no'=>$row[12],'createdate'=>$row[16],'retail_code'=>$row[18]);
        }
        //echo 	$retail_code."Order Details</BR>";
        //print_r(json_encode($orderdetailarray));
        
        //Replace Order  SKU
        //$samplejson="{\r\n    \"set_paid\": false,\r\n    \"currency\": \"INR\",\r\n    \"billing\": {\r\n        \"first_name\": \"John\",\r\n        \"last_name\": \"Doe\",\r\n        \"address_1\": \"969 Market\",\r\n        \"address_2\": \"\",\r\n        \"city\": \"JAIPUR\",\r\n        \"state\": \"RAJ\",\r\n        \"postcode\": \"302001\",\r\n        \"country\": \"IN\",\r\n        \"email\": \"john.doe@example.com\",\r\n        \"phone\": \"(555) 555-5555\"\r\n    },\r\n    \"shipping\": {\r\n        \"first_name\": \"John\",\r\n        \"last_name\": \"Doe\",\r\n        \"address_1\": \"969 Market\",\r\n        \"address_2\": \"\",\r\n        \"city\": \"JAIPUR\",\r\n        \"state\": \"RAJ\",\r\n        \"postcode\": \"302001\",\r\n        \"country\": \"IN\"\r\n    },\r\n    \"line_items\": [\r\n        {\r\n            \"product_id\": SKU_ID,\r\n            \"quantity\": 1\r\n            \r\n        }\r\n    ],\r\n    \"shipping_lines\": [\r\n        {\r\n            \"method_id\": \"free_shipping\",\r\n            \"method_title\": \"Free shipping\",\r\n            \"total\": \"0.00\"\r\n        }\r\n    ],\r\n    \"meta_data\": [\r\n        {\r\n            \"key\": \"order_taken_from\",\r\n            \"value\": \"iGiver\"\r\n        },\r\n        {\r\n            \"key\": \"auth_code\",\r\n            \"value\": \"1234567890\"\r\n        }\r\n    ]\r\n}";
        //echo $order_sku;
        // $samplejson=str_replace("SKU_ID",$order_sku,$samplejson);
         $jayParsedAry['line_items'][0]['product_id']=$order_sku;
         
        
        //NGO Detail
        //echo $NGOid."  ".$donorid;
        
        $sqlGetNGODetail = "SELECT `cus_id`, `cus_userId`, `cus_name`, `cus_email`, `cus_phone`, `cus_pwd`, `cus_cpwd`, `cus_role`, `crtd_date`, `modi_date`, `status`, `flag`, `ngo_link`, `otp`, `verification_status`, `cus_contact_name`, `cus_address`, `cus_field_of_service`, `cus_image` FROM `customer` where cus_userId='".$NGOid."'";
         
        $resNGO = mysqli_query($con,$sqlGetNGODetail);
        
        if($resNGO)
        {
            while($row = mysqli_fetch_array($resNGO))
            {       //NGO_NAME,NGO_CONTACT_NAME,NGO_ADDRESS,NGO_MOBILE
            		$ngo_name=$row['cus_name'];
            		$ngo_address=$row['cus_address'];
            		$ngo_contact_name=$row['cus_contact_name'];
            		$ngo_mobile=$row['cus_phone'];
            		
            		$jayParsedAry['shipping']['first_name']=$ngo_name;
            		$jayParsedAry['shipping']['last_name']=$ngo_contact_name;
            		$jayParsedAry['shipping']['address_1']=$ngo_address;
            		$jayParsedAry['shipping']['address_2']=$ngo_mobile;
            		//$jayParsedAry['meta_data'][2]['_shipping_phone']=$ngo_mobile;
            		$jayParsedAry['meta_data'][2]['value']=$ngo_mobile;
            		//_shipping_phone
            		
            		
            	    /*	$samplejson=str_replace("NGO_NAME",$ngo_name,$samplejson);
            		$samplejson=str_replace("NGO_ADDRESS",$ngo_address,$samplejson);
            		$samplejson=str_replace("NGO_CONTACT_NAME",$ngo_contact_name,$samplejson);
            		$samplejson=str_replace("NGO_MOBILE",$ngo_mobile,$ngo_mobile);
            		
            		  "shipping" => [
                            "first_name" => "Abode of joy", 
                            "last_name" => "Rajakumari", 
                            "address_1" => "No. 11 5th Street Kabali Nagar Athanoor Road Guduvanchery Chengalpattu Kanchipuram - 603001 Landmark NEAR Guduvanchery Railway Station ", 
                            "address_2" => "9176200203", 
                            "city" => "Temp", 
                            "state" => "Temp", 
                            "postcode" => "600011", 
                            "country" => "IN" 
                         ], */
            		
            		
            	
            		
            		
                    $NgoDetailArray[] =array('cus_id'=>$row[0],'cus_userId'=>$row[1],'cus_name'=>$row[2],'cus_email'=>$row[3],'cus_phone'=>$row[4],'crtd_date'=>$row[8],'ngo_link'=>$row[12],'cus_contact_name'=>$row[15],'cus_address'=>$row[16]);
            }
        	//echo "</BR>NGO Details</BR>";
        	//echo $ngo_address;
        	//echo $samplejson;
        	//print_r(json_encode($NgoDetailArray));	
        		
        
        	
        }
        
        //Donor Detail
        //echo $NGOid."  ".$donorid;
        
        $sqlGetDonorDetail = "SELECT `cus_id`, `cus_userId`, `cus_name`, `cus_email`, `cus_phone`, `cus_pwd`, `cus_cpwd`, `cus_role`, `crtd_date`, `modi_date`, `status`, `flag`, `ngo_link`, `otp`, `verification_status`, `cus_contact_name`, `cus_address`, `cus_field_of_service`, `cus_image` FROM `customer` where cus_userId='".$donorid."'";
         
        $resDonor = mysqli_query($con,$sqlGetDonorDetail);
       
        if($resDonor){
        	while($row = mysqli_fetch_array($resDonor)){
        	    //DON_NAME,DON_MOBILE, DON_EMAIL
            		$don_name=$row['cus_name'];
            		$don_email=$row['cus_email'];
            		$don_mobile=$row['cus_phone'];
            		
            		$jayParsedAry['billing']['first_name']=$don_name;
            		$jayParsedAry['billing']['email']=$don_email;
            		$jayParsedAry['billing']['phone']=$don_mobile;
            		
            		
            		/*$samplejson=str_replace("DON_NAME",$don_name,$samplejson);
            		$samplejson=str_replace("DON_EMAIL",$don_email,$samplejson);
            		$samplejson=str_replace("DON_MOBILE",$don_mobile,$samplejson);
            		
            		"billing" => [
                         "first_name" => "DON_NAME", 
                         "last_name" => "DON_NAME", 
                         "address_1" => "Temp", 
                         "address_2" => "", 
                         "city" => "", 
                         "state" => "", 
                         "postcode" => "", 
                         "country" => "IN", 
                         "email" => "sowjanyamca1988@gmail.com", 
                         "phone" => "9841200531" 
                      ], */
            		
            		
        		
                    $DonorDetailArray[] =array('cus_id'=>$row[0],'cus_userId'=>$row[1],'cus_name'=>$row[2],'cus_email'=>$row[3],'cus_phone'=>$row[4],'crtd_date'=>$row[8]);
        }
        
            //var_dump($jayParsedAry);
	        //exit;
            	
        
        	//echo "</BR>Donor Details</BR>";
        	//print_r(json_encode($DonorDetailArray));	
        	
        }
        
        //COMMENTED
        //Get retailer email and send 
        /*$toemail='';
       
        $sql = "SELECT  `email` FROM `retail_vendor` WHERE `retail_code`='".$retail_code."'";
        //echo $sql;
        
        $res = mysqli_query($con,$sql);
        //$row_cnt=$res->num_rows;
        //printf("Result set has %d rows.\n", $row_cnt);
        
        if($res)
        {
        	while($row = mysqli_fetch_array($res))
        	{
        		
                 $toemail=$row[0];
                 //echo "To email".$toemail;
            }
        }
      
        
        */
         $toemail="support@lokas.in";
      send_email($toemail,$orderid,json_encode($orderdetailarray),json_encode($NgoDetailArray),json_encode($DonorDetailArray));
      
      
      
      
      
      $reval=call_ack_server($jayParsedAry,$orderid,$con);
    }
    mysqli_close($con);
    

    
   
    		       

?>