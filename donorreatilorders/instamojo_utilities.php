<?php 

// Importing DBConfig.php file.
    include '../dbconnect.php';
    
    $access_token='';
    
    //$im_orderid=get_imjo_create_order("NAL033898","TST",$con);
   // $myArray = array(json_decode($im_orderid, true));
    //echo $myArray[0]["order_id"];
    
    
    function get_imjo_create_pay_request($orderid,$retail_code,$con,$returnUrl){
         //get_imjo_access_token
        $access_token=get_imjo_access_token($retail_code,$con);
        //echo $access_token;
        //Get values from Order
        //$purpose,$phone,$amount,$don_name,$don_email
        
        
        $sql1 = "SELECT  `order_amount`,`order_sku`, `ngoid`, cus_phone,cus_name, cus_email  FROM `donor_retail_orders`, `customer` WHERE donor_retail_orders.donorid=customer.cus_userId AND orderid='".$orderid."'";
        //echo $sql1;
        $resorderdetail = mysqli_query($con,$sql1);
    
        if($resorderdetail)
        {
        	while($row = mysqli_fetch_array($resorderdetail))
        	{
        	    $purpose=$orderid;
        		$phone=$row['cus_phone'];
        		$amount=$row['order_amount'];
        		$don_name=$row['cus_name'];
        		$don_email=$row['cus_email'];
            }
        }
           //create_payment_request
        $payment_request_id=create_payment_request_web($access_token,$purpose,$phone,$amount,$don_name,$don_email,$orderid,$returnUrl);
        return $payment_request_id;
        
    }
    function get_imjo_create_order($orderid,$retail_code,$con)
    {
        //get_imjo_access_token
        $access_token=get_imjo_access_token($retail_code,$con);
        //echo $access_token;
        //Get values from Order
        //$purpose,$phone,$amount,$don_name,$don_email
        
        
        $sql1 = "SELECT  `order_amount`,`order_sku`, `ngoid`, cus_phone,cus_name, cus_email  FROM `donor_retail_orders`, `customer` WHERE donor_retail_orders.donorid=customer.cus_userId AND orderid='".$orderid."'";
        //echo $sql1;
        $resorderdetail = mysqli_query($con,$sql1);
    
        if($resorderdetail)
        {
        	while($row = mysqli_fetch_array($resorderdetail))
        	{
        	    $purpose=$orderid;
        		$phone=$row['cus_phone'];
        		$amount=$row['order_amount'];
        		$don_name=$row['cus_name'];
        		$don_email=$row['cus_email'];
            }
        }
        
        

        //create_payment_request
        $payment_request_id=create_payment_request($access_token,$purpose,$phone,$amount,$don_name,$don_email);
        //echo '<br>';
        //echo $payment_request_id;
        //echo '<br>';
        //Create order id
        $ch = curl_init();

        //$access_token='JaXH8dcG2VSLtYqBA3Rd7Nswsjxlek';
        //$payment_request_id="ff892d5312224f5a8315b78931223657";
         curl_setopt($ch, CURLOPT_URL, 'https://api.instamojo.com/v2/gateway/orders/payment-request/');      // For Live mode 
        // curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/v2/gateway/orders/payment-request/');      // For Sandbox mode 
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$access_token));
        
        $payload = Array(
            'id' => $payment_request_id
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch); 
        
        //echo $response;
        //echo '<br>';
        
        
        return $response;
    }
    

  function get_imjo_create_order_web($orderid,$retail_code,$con)
    {
        //get_imjo_access_token
        $access_token=get_imjo_access_token($retail_code,$con);
        //echo $access_token;
        //Get values from Order
        //$purpose,$phone,$amount,$don_name,$don_email
        
        
        $sql1 = "SELECT  `order_amount`,`order_sku`, `ngoid`, cus_phone,cus_name, cus_email  FROM `donor_retail_orders`, `customer` WHERE donor_retail_orders.donorid=customer.cus_userId AND orderid='".$orderid."'";
        //echo $sql1;
        $resorderdetail = mysqli_query($con,$sql1);
    
        if($resorderdetail)
        {
        	while($row = mysqli_fetch_array($resorderdetail))
        	{
        	    $purpose=$orderid;
        		$phone=$row['cus_phone'];
        		$amount=$row['order_amount'];
        		$don_name=$row['cus_name'];
        		$don_email=$row['cus_email'];
            }
        }
        
        
         $returnurl="https://donate.igiver.org/instaresponse/";
         // $returnurl="http://65.1.216.112:3000/instaresponse/";
        //create_payment_request
        $payment_request_id=create_payment_request_web($access_token,$purpose,$phone,$amount,$don_name,$don_email,$orderid,$returnurl);
        
        $imjo_orderid = $payment_request_id[0]["id"];
       
        
//          $sql = "UPDATE donor_retail_orders SET insta_pay_req_id='".$payment_request_id."' WHERE orderid='".$orderid."'";
// 		//echo $sql;
// 		$res = mysqli_query($con,$sql);
        
        return $imjo_orderid;
    }
    
    function getlongurl($instaid,$retailcode,$con)
    {
        $access_token=get_imjo_access_token($retailcode,$con);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.instamojo.com/v2/payment_requests/'.$instaid.'/');
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

curl_setopt($ch, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$access_token));

$response = curl_exec($ch);
curl_close($ch); 

 $myArray = array(json_decode($response, true));
        
        return $myArray[0]["longurl"];

    }
    function get_imjo_access_token($retailcode,$con)
    {
        
        //Fetch secret
        $client_id='';
        $client_secret='';
        $sqlsecret = "SELECT `client_id`,`client_secret` FROM `retail_vendor` WHERE retail_code='".$retailcode."'";
        //echo $sqlsecret;
        $ressecret= mysqli_query($con,$sqlsecret);
        //var_dump($ressecret);
        if($ressecret)
        {
            while($row = mysqli_fetch_array($ressecret))
        	{
        		$client_id=$row['client_id'];
        		$client_secret=$row['client_secret'];
                 //$products[] =array('id'=>$row[0],'sku'=>$row[1],'name'=>$row[2],'description'=>$row[3],'unit_price'=>$row[4],'image_url'=>$row[5]);
            }
            //echo 	$client_id.'-----'.$client_secret."</BR>";
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.instamojo.com/oauth2/token/');     // For Live mode 
        //curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/oauth2/token/');      // For Sandbox mode
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        
        $payload = Array(
            'grant_type' => 'client_credentials',
            'client_id' => $client_id,
            //'client_id' => '4VD6Tjl1VwsOcjYD8pt5vCrlfXt3cjX76aBkAoHq',
            'client_secret' => $client_secret,
            //'client_secret' => 'TLN97yhGQsUBjiB5AO97t9pCcksDcTVW2goRJ8i8olVTqSDkeXzOb4dWA07LwmlgbPZnetLxi8Ah3keK7NUYfvQ3JD4KKwoKRT7RHoA64Uuubx6llUrSisNA8bNdTKqK',
            //'scope' => 'virtual-accounts:write'
        );
        
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch); 
        
        $decodedText = html_entity_decode($response);
        $myArray = array(json_decode($response, true));
        
        $access_token = $myArray[0]["access_token"];
        
        //echo $response;
        
        //echo '<br>';
        //echo '<br>';
       // echo $access_token;
        return $access_token;
        
    }
    
    function create_payment_request($access_token,$purpose,$phone,$amount,$don_name,$don_email)
    {
        
        $ch = curl_init();
        //$access_token='JaXH8dcG2VSLtYqBA3Rd7Nswsjxlek';
        curl_setopt($ch, CURLOPT_URL, 'https://api.instamojo.com/v2/payment_requests/');      // For Live mode
        //curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/v2/payment_requests/');      // For Sandbox mode
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$access_token));
        $payload = Array(
            'purpose' => $purpose,
            'phone' => $phone,
            'amount' => $amount,
            'buyer_name' => $don_name,
            'redirect_url' => 'https://api.instamojo.com/integrations/android/redirect/',     // For Live mode
            //'redirect_url' => 'https://test.instamojo.com/integrations/android/redirect/',    // For Sandbox mode
            'send_email' => false,
            //'webhook' => 'http://igiver.org/ngoapp/donorreatilorders/insta_webhook.php',
             'webhook' => 'https://api.igiver.org/v1/donorreatilorders/insta_webhook.php',
            'send_sms' => false,
            'email' => $don_email,
            'allow_repeated_payments' => false
        );
        //echo $payload.'</BR>';
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch); 
        
        //echo $response;
        $myArray = array(json_decode($response, true));
        
        $imjo_orderid = $myArray[0]["id"];
        return $imjo_orderid;
        //echo $insta_orderid.'<br>';
    }
    
    function create_payment_request_web($access_token,$purpose,$phone,$amount,$don_name,$don_email,$orderid,$returnUrl)
    {
        

        $ch = curl_init();
        //$access_token='JaXH8dcG2VSLtYqBA3Rd7Nswsjxlek';
        curl_setopt($ch, CURLOPT_URL, 'https://api.instamojo.com/v2/payment_requests/');      // For Live mode
        //curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/v2/payment_requests/');      // For Sandbox mode
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$access_token));
        $payload = Array(
            'purpose' => $purpose,
            'phone' => $phone,
            'amount' => $amount,
            'buyer_name' => $don_name,
            'redirect_url' => $returnUrl.'?orderid='.$orderid,     // For Live mode
            //'redirect_url' => 'https://test.instamojo.com/integrations/android/redirect/',    // For Sandbox mode
            'send_email' => false,
            //'webhook' => 'http://igiver.org/ngoapp/donorreatilorders/insta_webhook.php',
            'webhook' => 'https://api.igiver.org/v1/donorreatilorders/insta_webhook.php',
            'send_sms' => false,
            'email' => $don_email,
            'allow_repeated_payments' => false
        );
        //echo $payload.'</BR>';
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch); 
        
        //echo $response;
        return $myArray = array(json_decode($response, true));
        
        // $imjo_orderid = $myArray[0]["id"];
        // return $imjo_orderid;
        //echo $insta_orderid.'<br>';
    }
    

?>