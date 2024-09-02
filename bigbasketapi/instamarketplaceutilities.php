<?php 
// Importing DBConfig.php file.
    include '../dbconnect.php';
    
    $access_token='';
function get_imjo_create_pay_request($access_token,$requestdata){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.instamojo.com/v2/payment_requests/');
        // curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/v2/payment_requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Authorization: Bearer '. $access_token));
        $payload = $requestdata;
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch);
        curl_close($ch);
        $myArray = array(json_decode($response, true));
        $myArray['http_code'] = $httpcode['http_code'];
        return $myArray; 
}

  function get_imjo_access_token($client_id, $client_secret)
    {
        
  
        		// $client_id=$payway['client_id'];
        		// $client_secret=$payway['client_secret'];
                $cha = curl_init();
                curl_setopt($cha, CURLOPT_URL, 'https://api.instamojo.com/oauth2/token/');     // For Live mode 
                // curl_setopt($cha, CURLOPT_URL, 'https://test.instamojo.com/oauth2/token/');      // For Sandbox mode
                curl_setopt($cha, CURLOPT_HEADER, FALSE);
                curl_setopt($cha, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($cha, CURLOPT_FOLLOWLOCATION, TRUE);
                $payloada = Array(
                'grant_type' => 'client_credentials',
                'client_id' => $client_id,
                'client_secret' => $client_secret
                );
                curl_setopt($cha, CURLOPT_POST, true);
                curl_setopt($cha, CURLOPT_POSTFIELDS, http_build_query($payloada));
                $responsea = curl_exec($cha);
		        $httpcodea = curl_getinfo($cha);
                curl_close($cha);
                $myArraya = array(json_decode($responsea, true));
                $access_token = $myArraya[0]["access_token"];
		$returnarray = array();
		$returnarray['http_code'] = $httpcodea['http_code'];
		$returnarray['access_token'] = $access_token;
                return $returnarray;
        
    }
    
      function create_payment_request_web($access_token,$purpose,$phone,$amount,$don_name,$don_email,$orderid,$returnUrl)
    {
        
        $chb = curl_init();
        //$access_token='JaXH8dcG2VSLtYqBA3Rd7Nswsjxlek';
       curl_setopt($chb, CURLOPT_URL, 'https://api.instamojo.com/v2/payment_requests/');      // For Live mode
       // curl_setopt($chb, CURLOPT_URL, 'https://test.instamojo.com/v2/payment_requests/');      // For Sandbox mode
        curl_setopt($chb, CURLOPT_HEADER, FALSE);
        curl_setopt($chb, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($chb, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($chb, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$access_token));
        $payloadb = Array(
            'purpose' => $purpose,
            'phone' => $phone,
            'amount' => $amount,
            'buyer_name' => $don_name,
            'redirect_url' => $returnUrl.'?orderid='.$orderid,     // For Live mode
            //'redirect_url' => 'https://test.instamojo.com/integrations/android/redirect/',    // For Sandbox mode
            'send_email' => false,
            //'webhook' => 'http://igiver.org/ngoapp/donorreatilorders/insta_webhook.php',
            //'webhook' => 'https://api.igiver.org/v1/bigbasketapi/prakash_insta_marketplace_webhook.php',
              'webhook' => 'https://api.igiver.org/v1/bigbasketapi/bigbasketwebhook.php',
            'send_sms' => false,
            'email' => $don_email,
            'allow_repeated_payments' => false
        );
        //echo $payload.'</BR>';
        curl_setopt($chb, CURLOPT_POST, true);
        curl_setopt($chb, CURLOPT_POSTFIELDS, http_build_query($payloadb));
        $responseb = curl_exec($chb);
        curl_close($chb); 
        
        //echo $response;
        return $myArrayb = array(json_decode($responseb, true));
        
        // $imjo_orderid = $myArray[0]["id"];
        // return $imjo_orderid;
        //echo $insta_orderid.'<br>';
    }
    
    function  get_imjo_create_new_user($payway,$con, $post){
         $access_token=get_imjo_access_token($payway,$con);
         $refferer_name = $payway['refferer_name'];
         $email = $post['email'];
         $passsword = $post['password'];
         $phone = $post['phone'];
         
        $step_one_data = Array(
            'email' => $email,
            'passsword' => $passsword,
            'phone' => $phone,
            'referrer' => $refferer_name,
            );
        $stepone_result = create_user_stepone($step_one_data,$access_token);
      
          // print_r($stepone_result[0]);
          $data = array();
          if($stepone_result[0]['http_code'] == '200' || $stepone_result[0]['http_code'] =='201'){
              $mer_id = $stepone_result[0]['id'];
              $username = $stepone_result[0]['username'];
              $password = $passsword;
              $merchant_email= $stepone_result[0]['email'];
              $merchant_phone = $stepone_result[0]['phone'];
              $retail_code = 'BB_ACH';
              
              $sql = "insert into wallet_retailer_details (retail_code,  insta_username, insta_password, insta_user_id, email, phone) value('$retail_code','$username','$password','$mer_id','$merchant_email','$merchant_phone')";
              
             $insert_merchat = mysqli_query($con, $sql);
              
                $data['error'] = false;
                $data['userId'] = $stepone_result;
                $data['message'] = "User Created Successfully";
                
          }else{
              if(isset($stepone_result[0]['email']))
             $data['error'] = true;
             $data['message'] = $stepone_result[0]['email'][0];
          }
          return $data;
         
    }
    function get_imjo_update_user($payway,$con, $post){
        $insta_id = $post['usesrId'];
        $userInfo = mysqli_fetch_array(mysqli_query($con, "SELECT insta_username, insta_password, email FROM wallet_retailer_details WHERE insta_user_id ='$insta_id'"));
        // print_r($userInfo);
        
        /*  grant_type:password
                    client_id:test_gYbnJOCEG2prcwzDRiKU8sSiV3AMEJ0PZhe
                    client_secret:test_A0uYyvj8b1fH6dP4uzwjU3kGAb9ShAVkxHKZueJbGA8Nsum0QfPJrTFFC02jIZGmBU79FiOw4sif7pYILyvR1zVw4cs8rNukVapY1xsj6fSz5wcWcuNySdxtkre
                    username:prakash_0579a
                    password:googly
                */
                    $steptwo_access_data = Array(
                    'grant_type' => 'password',
                    'client_id' => $payway['client_id'],
                    'client_secret' => $payway['client_secret'],
                    'username' => $userInfo['email'],
                    'password' => $userInfo['insta_password'],
                    );

                // print_r($steptwo_access_data);
                  
                $merchant_accessToken_details = get_merchant_access_token($steptwo_access_data);
                  // print_r($merchant_accessToken_details);
                  //  exit;
                if(!isset($merchant_accessToken_details[0]['error'])){
                    $merchant_accessToken = $merchant_accessToken_details[0]["access_token"];
                     $data['error'] = false;
             $data['message'] = $merchant_accessToken_details[0]; 
                }else{
                   $data['error'] = true;
                    $data['message'] = $merchant_accessToken_details[0]; 
                }
                return $data;
        
        
        
    }
    function get_merchant_access_token($steptwo_access_data){
        $chc = curl_init();
        curl_setopt($chc, CURLOPT_URL, 'https://api.instamojo.com/oauth2/token/');
        // curl_setopt($chc, CURLOPT_URL, 'https://test.instamojo.com/oauth2/token/');
        curl_setopt($chc, CURLOPT_HEADER, FALSE);
        curl_setopt($chc, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($chc, CURLOPT_FOLLOWLOCATION, TRUE);
        $payloadc = $steptwo_access_data;
        
        curl_setopt($chc, CURLOPT_POST, true);
        curl_setopt($chc, CURLOPT_POSTFIELDS, http_build_query($payloadc));
        $responsec = curl_exec($chc);
	$httpcodec = curl_getinfo($chc);
        curl_close($chc);
        $myArrayc = array(json_decode($responsec, true));
	$myArrayc ['http_code'] = $httpcodec ['http_code'];
        return $myArrayc;
        
    }
    
    function refresh_merchant_access_token($refresh_access_data){
        
        $chd = curl_init();
        curl_setopt($chd, CURLOPT_URL, 'https://api.instamojo.com/oauth2/token/');     
        // curl_setopt($chd, CURLOPT_URL, 'https://test.instamojo.com/oauth2/token/');     
        curl_setopt($chd, CURLOPT_HEADER, FALSE);
        curl_setopt($chd, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($chd, CURLOPT_FOLLOWLOCATION, TRUE);
        
        $payloadd = $refresh_access_data;
        
        curl_setopt($chd, CURLOPT_POST, true);
        curl_setopt($chd, CURLOPT_POSTFIELDS, http_build_query($payloadd));
        $responsed = curl_exec($chd);
	$httpcoded = curl_getinfo($chd);
        curl_close($chd);
        $myArrayd = array(json_decode($responsed, true));
	$myArrayd['http_code'] = $httpcoded['http_code'];
        return $myArrayd; 
        
    }
     
    function create_user_stepone($step_one_data,$access_token ){
       
        $che = curl_init();
        curl_setopt($che, CURLOPT_URL, 'https://api.instamojo.com/v2/users/');
        // curl_setopt($che, CURLOPT_URL, 'https://test.instamojo.com/v2/users/');
        curl_setopt($che, CURLOPT_HEADER, FALSE);
        curl_setopt($che, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($che, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($che, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$access_token));
        $payloade = $step_one_data;
        curl_setopt($che, CURLOPT_POST, true);
        curl_setopt($che, CURLOPT_POSTFIELDS, http_build_query($payloade));
        $responsee = curl_exec($che);
        $httpcodee = curl_getinfo($che);
        curl_close($che);
        $responsefinale = json_decode($responsee, true);
        $responsefinale['http_code'] = $httpcodee['http_code'];
        // print_r($response);
        return $myArraye = array($responsefinale);
        
    }
    
    function patch_user_steptwo($steptwo_data, $merchant_accessToken,$mer_id){
	
	
       
        $chf = curl_init();
        curl_setopt($chf, CURLOPT_URL, 'https://api.instamojo.com/v2/users/'.$mer_id.'/');
        // curl_setopt($chf, CURLOPT_URL, 'https://test.instamojo.com/v2/users/'.$mer_id.'/');
        curl_setopt($chf, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($chf, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($chf, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($chf, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$merchant_accessToken));
        $payloadf = $steptwo_data;
        
        curl_setopt($chf, CURLOPT_POSTFIELDS, $payloadf);
        $responsef = curl_exec($chf);
        $httpcodef = curl_getinfo($chf);
        curl_close($chf);
        $responsefinalf = json_decode($responsef, true);
        $responsefinalf['http_code'] = $httpcodef['http_code'];
        // print_r($response);
        return $myArrayf = array($responsefinalf);
        
    }
    
    function put_user_stepthree($stepthree_data, $merchant_accessToken,$mer_id){
        
        
        $chg = curl_init();
        curl_setopt($chg, CURLOPT_URL, 'https://api.instamojo.com/v2/users/'.$mer_id.'/inrbankaccount/');
        // curl_setopt($chg, CURLOPT_URL, 'https://test.instamojo.com/v2/users/'.$mer_id.'/inrbankaccount/');
        curl_setopt($chg, CURLOPT_HEADER, FALSE);
        curl_setopt($chg, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($chg, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($chg, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($chg, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$merchant_accessToken));
        $payloadg = $stepthree_data;
        curl_setopt($chg, CURLOPT_POSTFIELDS, http_build_query($payloadg));
        $responseg = curl_exec($chg);
        $httpcodeg = curl_getinfo($chg);
        curl_close($chg); 
        $responsefinalg = json_decode($responseg, true);
        $responsefinalg['http_code'] = $httpcodeg['http_code'];
        // print_r($response);
        return $myArrayg = array($responsefinalg);
        
        
    }
    
    function get_payment_details_by_mojoId( $accessToken, $mojoId){
        
        $chh = curl_init();
        curl_setopt($chh, CURLOPT_URL, 'https://api.instamojo.com/v2/payments/'.$mer_id.'/');
        // curl_setopt($chh, CURLOPT_URL, 'https://test.instamojo.com/v2/payments/'.$mojoId.'/');
        curl_setopt($chh, CURLOPT_HEADER, FALSE);
        curl_setopt($chh, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($chh, CURLOPT_FOLLOWLOCATION, TRUE);

        curl_setopt($chh, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$accessToken));
        $responseh = curl_exec($chh);
        $httpcodeh = curl_getinfo($chh);
        curl_close($chh); 
        $responsefinalh = json_decode($responseh, true);
        $responsefinalh['http_code'] = $httpcodeh['http_code'];
        // print_r($response);
        return $myArrayh = array($responsefinalh);
        
    }
    
    function mojo_create_settlement($settlementdata, $accessToken, $mojoId){
        
        $chi = curl_init();
        curl_setopt($chi, CURLOPT_URL, 'https://api.instamojo.com/v2/payments/'.$mojoId.'/settlements/');
        // curl_setopt($chi, CURLOPT_URL, 'https://test.instamojo.com/v2/payments/'.$mojoId.'/settlements/');
        curl_setopt($chi, CURLOPT_HEADER, FALSE);
        curl_setopt($chi, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($chi, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($chi, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$accessToken));
        $payloadi = $settlementdata;
        curl_setopt($chi, CURLOPT_POST, true);
        curl_setopt($chi, CURLOPT_POSTFIELDS, http_build_query($payloadi));
        $responsei = curl_exec($chi);
        $httpcodei = curl_getinfo($chi);
        curl_close($chi);
        $responsefinali = json_decode($responsei, true);
        $responsefinali['http_code'] = $httpcodei['http_code'];
        // print_r($response);
        return $myArrayi = array($responsefinali);
        
    }
    
    function mojo_settlement_fullfill($accessToken, $mojoId){
        
        $chj = curl_init();
        curl_setopt($chj, CURLOPT_URL, 'https://api.instamojo.com/v2/payments/'.$mojoId.'/fulfil/');
        // curl_setopt($chj, CURLOPT_URL, 'https://test.instamojo.com/v2/payments/'.$mojoId.'/fulfil/');
        curl_setopt($chj, CURLOPT_HEADER, FALSE);
        curl_setopt($chj, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($chj, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($chj, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$accessToken));
        curl_setopt($chj, CURLOPT_POST, true);
        // curl_setopt($chj, CURLOPT_POSTFIELDS, http_build_query($payloadj));
        $responsej = curl_exec($chj);
        $httpcodej = curl_getinfo($chj);
        curl_close($chj);
        $responsefinalj = json_decode($responsej, true);
        $responsefinalj['http_code'] = $httpcodej['http_code'];
        // print_r($response);
        return $myArrayj = array($responsefinalj);
        
        
    }
    
    function get_mojo_settlement_detail($accessToken, $mojoId){
        
        $chk = curl_init();
        curl_setopt($chk, CURLOPT_URL, 'https://api.instamojo.com/v2/payments/'.$mojoId.'/settlements/');
        // curl_setopt($chk, CURLOPT_URL, 'https://test.instamojo.com/v2/payments/'.$mojoId.'/settlements/');
        curl_setopt($chk, CURLOPT_HEADER, FALSE);
        curl_setopt($chk, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($chk, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($chk, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$accessToken));
        
        $responsek = curl_exec($chk);
        $httpcodek = curl_getinfo($chk);
        curl_close($chk);
        $responsefinalk = json_decode($responsek, true);
        $responsefinalk['http_code'] = $httpcodek['http_code'];
        // print_r($response);
        return $myArrayk = array($responsefinalk);
    }
    


?>