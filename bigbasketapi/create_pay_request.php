<?php
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: *");
	// Importing DBConfig.php file.
    include '../dbconnect.php';
	include 'instamarketplaceutilities.php'; 
	if($_SERVER['REQUEST_METHOD']==='POST' && empty($_POST)) {
        $_POST = json_decode(file_get_contents('php://input'),true); 
    }
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
    
     $rand = generateRandomString();
     if(!empty($_POST)){
    
    
    $donorid = $_POST['donorid'];
    $ngo_id = $_POST['ngoid'];
    $amount = $_POST['order_amount'];
    $purpose = 'BB Wallet Donation for '.$_POST['order_desc'];
    $returnUrl = $_POST['returnUrl'];
    // echo "select cus_name, cus_email, cus_phone, cus_id FROM customer where cus_userId='".$donorid."'";
    $donaordetails = mysqli_fetch_array(mysqli_query($con, "select cus_name, cus_email, cus_phone, cus_id,cus_userId FROM customer where cus_userId='".$donorid."'"));
    
    $buyer_name =$donaordetails['cus_name'];
    $email =$donaordetails['cus_email'];
    $phone = $donaordetails['cus_phone'];
    $redirect_url =$returnUrl;
// $webhook = 'https://cp.igiver.org/ngoapp/bigbasketapi/bigbasketwebhook.php';

    $webhook = 'https://api.igiver.org/v1/bigbasketapi/bigbasketwebhook.php';
    $allow_repeated_payments = false;
    $send_email = true;
    $send_sms = true;
    $expires_at = '';
    $createdate=date('y-m-d');
    $updatedate=date('y-m-d');
    // echo "select wallet_retailer_id from customer where cus_id='$ngo_id'";
    // echo "select wallet_retailer_id, cus_id,cus_userId from customer where cus_userId='".$ngo_id."'";
    $wallet_retailer_ids = mysqli_fetch_array(mysqli_query($con,"select wallet_retailer_id, cus_id,cus_userId from customer where cus_userId='".$ngo_id."'"));
    // print_r($wallet_retailer_ids);
    // exit;
    //  $donorcusid = $donaordetails['cus_userId'];
    //  $ngocusid = $wallet_retailer_ids['cus_userId'];
    
     $donorcusid = $donorid;
     $ngocusid = $ngo_id;
    $wallet_retailer_id = $wallet_retailer_ids['wallet_retailer_id'];
    // echo "select retail_code from wallet_retailer_details where id='$wallet_retailer_id'";
    $sqlGetRetailersSql = mysqli_fetch_array(mysqli_query($con, "select retail_code from wallet_retailer_details where id='$wallet_retailer_id'"));
    // print_r($sqlGetRetailersSql);
    $orderid=$sqlGetRetailersSql['retail_code'].$rand;
    
    // echo "INSERT INTO `wallet_donor_transaction`( `donor_id`,`ngo_id`, `amount`, `wallet_retailer_id`, `date_donated`, `transfered_status`, `mojo_id`, `settlement_id`,`settlement_date`,	`settlement_name`,	`createddate`) 
    // VALUES ('$donorcusid','$ngocusid', '$amount','$wallet_retailer_id','$createdate','0','','','','','$createdate')";
    $sqlInsert ="INSERT INTO `wallet_donor_transaction`( `orderid`,`donor_id`,`ngo_id`, `amount`, `wallet_retailer_id`, `date_donated`, `transfered_status`, `mojo_id`, `settlement_id`,`settlement_date`, `settlement_name`, `createddate`, `payrequetId`, `webhookdata`) 
     VALUES ('$orderid','$donorcusid','$ngocusid', '$amount','$wallet_retailer_id','$createdate','0','','','','','$createdate','','')";
        
       //  echo $sqlInsert;
// exit;
        $resultInstert=mysqli_query($con,$sqlInsert);
        //echo $resultInstert;
        //exit;
        
        // $orderid = mysqli_insert_id($con);
        
        
        //If Instamojo PG return Instamojo orderid
        $sqlpayway = "SELECT * FROM `insta_marketplace_cred`";
        //echo $sqlpayway;
        $respayway= mysqli_query($con,$sqlpayway);
        
        if($respayway)
        {
        	$row = mysqli_fetch_array($respayway);
        	$client_id = $row['client_id'];
            $client_sceret  = $row['client_secret'];
        	$accesstoken_data = get_imjo_access_token($client_id,$client_sceret); 
        	if($accesstoken_data['http_code'] == '201' || $accesstoken_data['http_code']=='200')
            {    
        	     $access_token = $accesstoken_data["access_token"];
        	     
        	     $payload = Array(
                    'purpose' => $orderid,
                    'amount' => $amount,
                    'buyer_name' => $buyer_name,
                    'email' => $email,
                    'phone' =>  $phone,
                    'redirect_url' => $redirect_url,
                    'send_email' => 'True',
                    'send_sms' => 'True',
                    'webhook' => $webhook,
                    'allow_repeated_payments' => 'False',
                );
        
        	     
        	     $im_orderid = get_imjo_create_pay_request($access_token,$payload);
        	     if($im_orderid['http_code'] == '201' || $im_orderid['http_code'] == '200'){
        	        $orderrequestid = $im_orderid[0]['id'];
        	        $sqlUpdate ="UPDATE `wallet_donor_transaction` SET  payrequetId='$orderrequestid' WHERE orderid='$orderid'";
        	        $resultupdate=mysqli_query($con,$sqlUpdate);
        	        $order_info[] =array('order_id'=>$orderid,'insta_url'=>$im_orderid[0]['longurl']);	
        	        print_r(json_encode($order_info));
                }else{
                    $order_info[] =array('order_id'=>'','message'=>'Unable to create payment request');	
        	        print_r(json_encode($order_info));
                }     
        	 
                
            
        }else{
            $order_info[] =array('order_id'=>'','message'=>'Unable to generate accesstoken');	
        	        print_r(json_encode($order_info));
        }
    }
     }
	    mysqli_close($con);
    


   
    		       

?>