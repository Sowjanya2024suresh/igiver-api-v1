<?php
header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: *");
	// Importing DBConfig.php file.
    include '../dbconnect.php';
    include '../whatsapp_api.php';
	include 'instamarketplaceutilities.php'; 
// print_r($_REQUEST);

$payment_id = $_REQUEST['payment_id'];
$payment_status = $_REQUEST['payment_status'];
$payment_request_id = $_REQUEST['payment_request_id'];

//$payment_id ='MOJO1c21L05N69769725';
//$payment_status ='Failed';
//$payment_request_id ='ef7a4fa04990449c8bb43063e9d60853';

if($payment_status =='Credit'){
    
    $sqlUpdate =mysqli_query($con,"UPDATE `wallet_donor_transaction` SET transfered_status='1', mojo_id='$payment_id' WHERE payrequetId='$payment_request_id'");
    
    // exit;
    sendEmailRetailer($payment_id);
    
    $donardetails = mysqli_fetch_array(mysqli_query($con, "Select donor_id from wallet_donor_transaction  WHERE payrequetId='$payment_request_id'"));
    $donorid = $donardetails['donor_id'];
    
    $DonorDetailsql = "SELECT  `cus_name`, `cus_email`, `cus_phone` FROM `customer` WHERE `cus_userId`='". $donorid."' AND `cus_role`=0";
                    // echo $DonorDetailsql;
                    
                    $resDon = mysqli_query($con,$DonorDetailsql);
                    if($resDon)
                    {
                    	while($row = mysqli_fetch_array($resDon))
                    	{
                             $donor_name=$row[0];$donor_email=$row[1];$donor_phone=$row[2];;
                        }
                    }
    $don_msg="Dear ".$donor_name.". Thank you for your kindness.Your order Id is".$orderid.". Kindly quote this for any support queries.Please call 7200011175 for any help. ";
   send_sms($donor_phone,$don_msg);
   sendSms('7200011175',$don_msg);


// Send whatsapp to donor

 $Detailsql = "SELECT (select cus_name from customer where donor_id=cus_userId) as donor_name,(select cus_phone from customer where donor_id=cus_userId) as donor_phone,mojo_id FROM `wallet_donor_transaction` where payrequetId='". $payment_request_id."'";
                    // echo $DonorDetailsql;
                    
                    $resretail = mysqli_query($con,$Detailsql);
                    if($resretail)
                    {
                    	while($row = mysqli_fetch_array($resretail))
                    	{
                             $donor_name=$row[0];$donor_phone=$row[1];$mojo_id=$row[2];
                        }
                    }

  send_whatsapp_orderconfirmtodonor($donor_name,$donor_phone,$mojo_id); 

//complete
               
    $resultupdate=mysqli_query($con,$sqlUpdate);
     //If Instamojo PG return Instamojo orderid
    $sqlpayway = "SELECT * FROM `insta_marketplace_cred`";
    //echo $sqlpayway;
    $respayway= mysqli_query($con,$sqlpayway);
    $row = mysqli_fetch_array($respayway);
        	$client_id = $row['client_id'];
            $client_sceret  = $row['client_secret'];
        	$accesstoken_data = get_imjo_access_token($client_id,$client_sceret); 
        	if($accesstoken_data['http_code'] == '201' || $accesstoken_data['http_code']=='200')
            {    
                
                $access_token = $accesstoken_data["access_token"];
               //  echo "SELECT wallet_retailer_id, id, orderid, amount from wallet_donor_transaction WHERE mojo_id='$payment_id'";
                
                $transactiondetails = mysqli_fetch_array(mysqli_query($con,"SELECT wallet_retailer_id, id, orderid, amount from wallet_donor_transaction WHERE mojo_id='$payment_id'"));
        	    
        	    $merchatId = mysqli_fetch_array(mysqli_query($con,"SELECT insta_user_id, name from wallet_retailer_details WHERE id='".$transactiondetails['wallet_retailer_id']."'"));
        	    $merName = $merchatId['name'];
        	     $payload = Array(
                    'settlement_id'=> $transactiondetails['orderid'],
                    'type'=> 'CREDIT',
                    'submerchant'=> $merchatId['insta_user_id'],
                    'amount'=> $transactiondetails['amount']
                );
                // print_r($payload);
                 $settelementrequest =  mojo_create_settlement($payload ,$access_token,$payment_id);
                // print_r($settelementrequest);
                if($settelementrequest[0]['http_code'] == '200' || $settelementrequest[0]['http_code'] == '201'){
                    $settlement_id = $settelementrequest[0]['settlement_id'];
                    $created = date('Y-m-d', strtotime($settelementrequest[0]['created']));
                    $sqlUpdate ="UPDATE `wallet_donor_transaction` SET settlement_id='$settlement_id', settlement_date='$created', settlement_name='$merName' WHERE payrequetId='$payment_request_id'";
                    $resultupdate=mysqli_query($con,$sqlUpdate);
                }
            }
    
}






function sendSms($mobno,$msg){
     //For testing
        //echo $msg;
	    $user_id = 'nmch-igiver';
	    $password = 'igiver12';
	    $sendid = 'iGIVER';
	    //$msg="Thank you for initiating order with order: $orderid";		  
	    $url="http://hpsms.nimbuschennai.com:8080/sendsms/bulksms?username=".$user_id."&password=".$password."&type=0&dlr=1&destination=".$mobno."&source=iGIVER&message=".urlencode($msg).""; 
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$response = curl_exec($ch); 
		curl_close($ch);
        return $response;
}

function sendEmailRetailer($payment_id){
     $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://cp.igiver.org/ngoapp/bigbasketapi/send_order_email_donor.php?orderid='.$payment_id,
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
        // echo $response;
}
?>