<?php
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: *");
	// Importing DBConfig.php file.
    include '../dbconnect.php';
	include 'instamarketplaceutilities.php'; 
    if($_SERVER['REQUEST_METHOD']==='POST' && empty($_POST)) {
        $_POST = json_decode(file_get_contents('php://input'),true); 
    }
    $mojoId = $_POST['mojoId'];
    
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
        $fullfillsettlement =  mojo_settlement_fullfill($access_token, $mojoId);
        if($fullfillsettlement[0]['fulfil']==true){
            $fullfilldetails = get_mojo_settlement_detail($access_token, $mojoId);
            mysqli_query($con,"UPDATE `wallet_donor_transaction` SET  settlement_status='1' WHERE mojo_id='$mojoId' ");
            print_r($fullfilldetails);
            
            sendEmailRetailer($mojoId);
            $donardetails = mysqli_fetch_array(mysqli_query($con, "Select ngo_id from wallet_donor_transaction  WHERE mojo_id='$mojoId' "));
    $donorid = $donardetails['ngo_id'];
    
   //Send a SMS to NGO
                     $NGODetailsql = "SELECT  `cus_name`, `cus_email`, `cus_phone` FROM `customer` WHERE `cus_userId`='". $ngoid."' AND `cus_role`=1";
                   //  echo $NGODetailsql;
                    
                    $res = mysqli_query($con,$NGODetailsql);
                    if($res)
                    {
                    	while($row = mysqli_fetch_array($res))
                    	{
                             $ngo_name=$row[0];$ngo_email=$row[1];$ngo_phone=$row[2];;
                        }
                    }
                    // echo $ngo_name.'  '.$ngo_phone.'  '.$ngo_email;
                    $ngo_msg="Dear ".$ngo_name." you have recived an in-kind donation through igiver for Big Baasket Wallet! Please check your app. ";
                    // sendSms($ngo_phone,$ngo_msg);
                    sendSms('7200011175',$ngo_msg);
               
        
        }else{
            print_r($fullfillsettlement);
        }
    }else{
        
        echo 'Access Token error';
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

function sendEmailRetailer($mojoId){
     $curl = curl_init();

        curl_setopt_array($curl, array(
           // CURLOPT_URL => 'https://cp.igiver.org/ngoapp/bigbasketapi/send_order_email_all.php?orderid='.$mojoId,
            CURLOPT_URL => 'https://api.igiver.org/v1/bigbasketapi/send_order_email_all.php?orderid='.$mojoId,
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