<?php
	// Importing DBConfig.php file.
    include 'dbconnect.php';
	 
	function generateRandomString($length = 4) 
	{
    	$characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    function send_sms($mobno,$msg)
   	{
         //For testing
        //echo $msg;
	    $user_id = 'nmch-igiver';
	    $password = 'igiver12';
	    $sendid = 'iGIVER';
	    //$msg="Thank you for initiating order with order: $orderid";		  
	    //$url="http://hpsms.nimbuschennai.com:8080/sendsms/bulksms?username=".$user_id."&password=".$password."&type=0&dlr=1&destination=".$mobno."&source=iGIVER&message=".urlencode($msg).""; 

        $url="http://103.16.101.52/sendsms/bulksms?username=nmch-igiver&password=igiver12&type=0&dlr=1&destination=".$mobno."&source=iGIVER&message=".urlencode($msg)."&entityid=1201159477885387789&tempid=1207162410559457458";

        //echo $url;
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$response = curl_exec($ch); 
		curl_close($ch);
        return $response;
    }
    
    // echo "post_max_size: ".ini_get('post_max_size');
    // var_dump($_POST);
    
    // Optionally, you can give it a desired string length.
	$otp=rand(1000, 9999);
	$cusName=$_POST['name'];
	$cusPhone=$_POST['mobile'];
	$crtdate=date('y-m-d');
	$moddate=date('y-m-d');
	$status='1';
	$flag='1';
	$clati = $_POST['rlati'];
	$clongi = $_POST['rlongi'];
	$cusRole = $_POST['rrole'];
	$cusTKID = $_POST['rtkid'];
	$cusemail = $_POST['email'];
	$cusRoles = '0';
	$cusUserID = "DON".generateRandomString();
// 	echo " Ph".$cusPhone;
	$sql1="Select * from customer where cus_phone ='".$cusPhone."' and cus_role=0";
    // echo $sql1;
    $cust = mysqli_query($con,$sql1);
       $cust_res = mysqli_fetch_row($cust);
        $existing_cust_id=$cust_res[0];
         //echo " Existing  ".$existing_cust_id;
        if($cust_res==""){
    			if($cusName !=""){
    			    $sql2="insert into customer (cus_userId,cus_name,cus_email,cus_phone,cus_role,crtd_date,modi_date,status,flag,otp) values ('$cusUserID','$cusName','$cusemail','$cusPhone','$cusRoles','$crtdate','$moddate','$status','$flag','$otp') ";
                    //echo $sql2;
                    $r=mysqli_query($con,$sql2);
        		    $last_id = mysqli_insert_id($con);
    		  
    		        if($r){
        		        $mob = $cusPhone;
            		   // $msg="Thank you. To complete the registration enter your OTP : $otp";	
$msg="Dear user Welcome to iGiver.Org Your OTP for iGiver registration is ". $otp." Do not share this OTP. Visit iGiver.org for support.";		  
          		    
//echo $msg;
send_sms($mob,$msg);
            		    
            		    
            		    
            		    
            		    
            		    
            		    
    		      
    		  }
    		   $r1=mysqli_query($con,"insert into customer_location (cus_id,latitude,longitude,created_date,modified_date,status,flag) values ('$last_id','$clati','$clongi','$crtdate','$moddate','$status','$flag') ");
    			 $time = time();
    			
    		   
    		   $r2 = "Select cus_uid from gcm_token where gcm_tokenid ='".$cusTKID."'";
    		   $cusToken = mysqli_query($con,$r2);
               while($cust_resTK = mysqli_fetch_row($cusToken)){
        		   $ctk = $cust_resTK[0];
        	   }
        	   if($ctk !=""){
        		   $sql = "UPDATE gcm_token SET cus_uid='".$cusUserID."',cus_role='".$cusRoles."' WHERE gcm_tokenid='".$cusTKID."'";
        		   $r2 = mysqli_query($con,$sql); 
        	   }
                    $list = array('cus_id' => $last_id, 'otp' => $otp, 'success' => 1,'cus_userid' => $cusUserID);
        	        $json = $list;
        	    }
        }else{
            
            //$existing_cust_id=$cust_res[0];
            //echo $existing_cust_id;
            $list = array('cus_id' => $existing_cust_id, 'success' => 0);
		    $json = $list;
		
		}
	echo json_encode($json);
	mysqli_close($con);
?>