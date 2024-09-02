<?php
header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: *");
	// Importing DBConfig.php file.
    include '../dbconnect.php';
	include 'instamarketplaceutilities.php'; 

/*

usesrId = d49f0e29b4cc43f982fde937e13b0af0

// update users other details
first_name:prakash
last_name:developer
location:chennai
phone:7200011185

// put method to add bank details
account_holder_name:raghav
account_number:123456789
ifsc_code:SBIN0000111
bank_name:hdfc


*/

 $sqlpayway = "SELECT * FROM `insta_marketplace_cred`";
        //echo $sqlpayway;
        $respayway= mysqli_query($con,$sqlpayway);
       
        if($respayway)
        {
        	$row = mysqli_fetch_array($respayway);
        	$payway=$row;
        //	print_r($payway);
        //	exit;
        	      $user_data = get_imjo_update_user($payway,$con, $_POST);
                 
        	 
        	
            
        }
        
       
        
        
       
       
        
        
        // echo json_encode($orderid);
         //$json['orderid'] = $orderid;
         $user_info[] =array('user_details'=>$user_data);
        
         //Sending email
        // send_email($orderid,json_encode($order_info));
        
        print_r(json_encode($user_info));
         
         //echo json_encode($json);
         //echo $im_orderid;
	    mysqli_close($con);

?>	
	
?>