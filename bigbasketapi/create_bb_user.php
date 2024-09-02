<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
// Importing DBConfig.php file.
include '../dbconnect.php';
include './instamarketplaceutilities.php'; 
if($_SERVER['REQUEST_METHOD']==='POST' && empty($_POST)) {
        $_POST = json_decode(file_get_contents('php://input'),true); 
}


if(!empty($_POST)){
$sqlpayway = "SELECT * FROM `insta_marketplace_cred`";
//echo $sqlpayway;
$respayway= mysqli_query($con,$sqlpayway);
$row = mysqli_fetch_array($respayway);
$client_id = $row['client_id'];
$client_sceret  = $row['client_secret'];




$password = $_POST['password'];
$email =$_POST['email'];
$phone = $_POST['phone'];
$refferer_name = $row['refferer_name'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$location = $_POST['location'];
$account_holder_name = $_POST['account_holder_name'];
$account_number = $_POST['account_number'];
$ifsc_code = $_POST['ifsc_code']; 
$bank_name = $_POST['bank_name'];

$data = array();

$accesstoken_data = get_imjo_access_token($client_id,$client_sceret); 
if($accesstoken_data['http_code'] == '201' || $accesstoken_data['http_code']=='200')
{
	$myArray = array(json_decode($response, true));
 	$access_token = $accesstoken_data["access_token"];

		$step_one_data = Array(
    			'email' => $email,
	    		'password' => $password,
    			'phone' => $phone,
	    		'referrer' => $refferer_name
		);
	$stepone_result = create_user_stepone($step_one_data,$access_token); 

	if($stepone_result[0]['http_code'] == '200' || $stepone_result[0]['http_code'] =='201'){
	      $mer_id = $stepone_result[0]['id'];
              $username = $stepone_result[0]['username'];
              $merchant_email= $stepone_result[0]['email'];
              $merchant_phone = $stepone_result[0]['phone']; 
              $retail_code = 'BB'.substr(strtoupper($location), 0, 3);
              
             $sql = "insert into wallet_retailer_details (retail_code, name, city, insta_username, insta_password, insta_user_id, email, phone, legal_name, bank_name,bank_account_no,branch,ifsc,app_access_token,user_access_token,refresh_token,createddate ) value('$retail_code','','$location','$username','$password','$mer_id','$merchant_email','$merchant_phone','','','','','','','','',CURRENT_TIMESTAMP)"; 
             $insert_merchat = mysqli_query($con, $sql);
		
		$steptwo_access_data = Array(
		    'grant_type' => 'password',
		    'client_id' => $client_id,
		    'client_secret' => $client_sceret,
		    'username' => $username,
		    'password' => $password
		  );

		
		$merchant_accessToken_details = get_merchant_access_token($steptwo_access_data);

		if($merchant_accessToken_details['http_code']=='201' || $merchant_accessToken_details['http_code']=='200'){
			// print_r($merchant_accessToken_details);
 			// exit;

	    		$merchant_accessToken = $merchant_accessToken_details[0]["access_token"];
                	$merchant_refreshToken = $merchant_accessToken_details[0]["refresh_token"];
                
                	mysqli_query($con,"UPDATE wallet_retailer_details set app_access_token='$merchant_accessToken', refresh_token='$merchant_refreshToken' where insta_user_id='$mer_id'");
                
                	$steptwo_data = array(
                   		'first_name' => $first_name,
                    		'last_name' => $last_name,
                    		'phone' => $phone,
                    		'location' => $location,
                  
                  	);
                  	$step2result = patch_user_steptwo($steptwo_data, $merchant_accessToken, $mer_id);
			if($step2result[0]['http_code'] == '200' || $step2result[0]['http_code'] =='201'){

				mysqli_query($con,"UPDATE wallet_retailer_details set name='".$step2result[0]['name']."',  city='$location' where insta_user_id='$mer_id'");
                  		$stepthree_data = array(
                   			'account_holder_name' => $account_holder_name,
                    			'account_number' => $account_number,
                    			'ifsc_code' => $ifsc_code,
                    			'bank_name' => $bank_name
                  
                  		);

				// print_r($stepthree_data);

	                  	$step3result = put_user_stepthree($stepthree_data, $merchant_accessToken,$mer_id);
				if($step3result[0]['http_code'] == '200' || $step3result[0]['http_code'] =='201'){

					mysqli_query($con,"UPDATE wallet_retailer_details set legal_name='$account_holder_name',  bank_account_no='$account_number',  ifsc='$ifsc_code',bank_name ='$bank_name' where insta_user_id='$mer_id'");

					

					$data['error'] = false;
                			$data['userInfo'] = $step2result;
					$data['userBankInfo'] = $step3result;
                			$data['message'] = "User Created Successfully";
				}else{
					$data['error'] = true;
             				$data['message'] = 'Unable to Update User Bank Details';
				}

				
			}else{
				$data['error'] = true;
             			$data['message'] = 'Unable to Update User Details';
			}
	
			
		}else{

			if(isset($merchant_accessToken_details[0]['error'])){
				$data['error'] = true;
             			$data['message'] = $merchant_accessToken_details[0]['error_description'];
			}
		}
		
	}else{
		if(isset($stepone_result[0]['email'])){
			$data['error'] = true;
             		$data['message'] = $stepone_result[0]['email'][0];
		}
	}
	
}else{
	
	$data['error'] = true;
        $data['message'] = "Unable to create Application Access Token.";
         
}
echo json_encode($data);
}
?>